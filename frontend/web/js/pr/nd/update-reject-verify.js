/* Savedraft */
$('#formtempgpu').on('beforeSubmit', function (e)
{
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                if (result == "เกินประเภทการสั่งซื้อ")
                {
                    swal({
                        title: "",
                        text: "ไม่สามารถขอซื้อเกินมูลค่าของประเภทการสั่งซื้อ",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                }
                            });
                } else
                {
                    swal({
                        title: "Save Completed!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    Savereason();
                                    $(".sendtoverify").removeAttr("disabled");
                                }
                            });
                }
            })
            .fail(function (xhr, status, error)
            {
                l.ladda('stop');
                swal("Oops...", error, "error");
                console.log(error);
            });
    return false;
});

/* Function ส่งใบขอซื้อไป verify */
$('.sendtoverify').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRNum = $("#tbpr2-prnum").val();
    swal({
        title: "ยืนยันการส่งทวนสอบ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        closeOnCancel: true,
        confirmButtonText: "Confirm",
        showLoaderOnConfirm: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'sendtoverify-reject',
                            {
                                PRNum: PRNum, PRID: PRID
                            },
                            function (data)
                            {

                            }
                    ).fail(function (xhr, status, error) {
                        //swal("Oops...", error, "error");
                    });
                }
            });
});

/* Function แก้ไข,ลบ ข้อมูลที่บันทึกลงตาราง */
function init_click_handlers() {
    /* Edit */
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-detail-reject',
                {
                    id: fID
                },
                function (data)
                {
                    $('#formitemdetails').trigger("reset");
                    $('#nd-modal').find('.modal-body').html(data);
                    $('#data').html(data);
                    $('#nd-modal .modal-title').html('ปรับปรุงรายการเวชภัณฑ์ ใบขอซื้อ');
                    $('.page-content').waitMe('hide');
                    $('#nd-modal').modal('show');

                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
            $('.page-content').waitMe('hide');
        });
    });
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-detail-reject',
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    setTimeout(function () {
                                        swal("Deleted!", "", "success");
                                        $.pjax.reload({container: '#detail_nd_pjax'});
                                    }, 200);
                                }
                        ).fail(function (xhr, status, error) {
                            swal("Oops...", error, "error");
                        });
                    }
                });
    });
}
init_click_handlers(); //first run
$('#detail_nd_pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});

/* Save เหตุผลการขอซื้อเมื่อกด SaveDraft */
function Savereason() {
    var PRID = $("#tbpr2-prid").val();
    var reasonid = new Array();
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            reasonid.push($(this).val());
        }
    });
    $.post(
            'save-reason',
            {
                PRID: PRID, reasonid: reasonid
            },
            function (data)
            {

            }
    ).fail(function (xhr, status, error) {
        swal("Oops...", error, "error");
    });
}
/* เรียกใช้ Modal เลือกยาสามัญ */
function GetModalTableND() {
    if ($("#datand").val() != '') {
        $('#modal-table-nd').modal('show');
    } else {
        LoadingClass();
        $.ajax({
            url: 'get-table-nd',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modal-table-nd').find('.modal-body').html(data);
                $('#datand').html(data);
                $('div#modal-table-nd .modal-title').html('เลือกรายการเวชภัณฑ์');
                $('.page-content').waitMe('hide');
                $('#modal-table-nd').modal('show');
                var t = $('#datatable-nd').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    "responsive": true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    "bSort": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "infoEmpty": "No records available",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });

                $('#datatable-nd tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('warning')) {
                        $(this).removeClass('warning');
                    } else {
                        t.$('tr.warning').removeClass('warning');
                        $(this).addClass('warning');
                    }
                });
                /*
                 t.on('order.dt search.dt', function () {
                 t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                 cell.innerHTML = i + 1;
                 });
                 }).draw();*/
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
                //alert(xhr.responseText);
            },
        });
    }
}

function SelectND(e) {
    var PRID = $('#tbpr2-prid').val();
    var plan = (e.getAttribute("data-id"));
    var ItemID = (e.getAttribute("id"));
    LoadingClass();
    $.ajax({
        url: 'add-itemdetail-reject',
        type: 'POST',
        data: {ItemID: ItemID, PRID: PRID, plan: plan},
        success: function (data)
        {
            if (data == 'false') {
                swal({
                    title: "",
                    text: "คุณเลือกตัวยาซ้ำ!",
                    type: "warning"
                });
                $('.page-content').waitMe('hide');
            } else {
                $('#formitemdetails').trigger("reset");
                $('#nd-modal').find('.modal-body').html(data);
                $('#nd-modal .modal-title').html('บันทึกรายการเวชภัณฑ์ ใบขอซื้อ');
                $('#data').html(data);
                $('.page-content').waitMe('hide');
                $('#nd-modal').modal('show');
                $('#tbpritemdetail2-prid').val(PRID);
                if (plan != "") {
                    $("#tbpritemdetail2-pcplannum").val(plan).trigger("change");
                }
            }
        },
        error: function (xhr, status, error)
        {
            swal({
                title: error,
                text: "",
                type: "error",
                confirmButtonText: "OK"
            });
            $('.page-content').waitMe('hide');
        }
    });
}