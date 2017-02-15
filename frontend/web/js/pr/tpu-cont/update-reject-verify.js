$(function () {
    SelectVendorName();
});
function SelectVendorName() {
    var e = document.getElementById("tbpr2-pocontactnum");
    var id = e.options[e.selectedIndex].value;
    if (id !== "") {
        $.ajax({
            url: "get-vendorid",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (result) {
                $("#tbpr2-vendorname").val(result).trigger("change");
            }
        });
    } else {
        $("#tbpr2-vendorname").val(null).trigger("change");
    }
}
/* เรียกใช้ Modal เลือกยาการค้า */
function GetModalTableTPU() {
    var e = document.getElementById("tbpr2-pocontactnum");
    var id = e.options[e.selectedIndex].value;
    var ctext = e.options[e.selectedIndex].text;
    if (ctext === '----- เลขที่สัญญาจะซื้อจะขาย -----') {
        swal({
            title: "กรุณาเลือกเลขที่สัญญาจะซื้อจะขาย",
            text: "",
            type: "error",
            confirmButtonText: "OK"
        });
    } else if ($("#datatpu").val() !== '') {
        $('#modal-table-tpu').modal('show');
    } else {
        LoadingClass();
        $.ajax({
            url: 'get-table-tpu',
            type: 'GET',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#modal-table-tpu').find('.modal-body').html(data);
                $('#datatpu').html(data);
                $('div#modal-table-tpu .modal-title').html('เลือกยาการค้า');
                $('.page-content').waitMe('hide');
                $('#modal-table-tpu').modal('show');
                var t = $('#datatable-tpu').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    "responsive": true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    //"bFilter": true,
                    "bSort": false,
                    "aaSorting": [[0]],
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

                $('#datatable-tpu tbody').on('click', 'tr', function () {
                    if ($(this).hasClass('warning')) {
                        $(this).removeClass('warning');
                    } else {
                        t.$('tr.warning').removeClass('warning');
                        $(this).addClass('warning');
                    }
                });
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
            },
        });
    }
}

function SelectTPU(e) {
    var PRID = $('#tbpr2-prid').val();
    var plan = (e.getAttribute("data-id"));
    var tpu = (e.getAttribute("id"));
    var ItemID = (e.getAttribute("itemid"));
    var GPU = (e.getAttribute("TMTID_GPU"));
    LoadingClass();
    $.ajax({
        url: 'add-itemdetail-reject',
        type: 'POST',
        data: {tpu: tpu, PRID: PRID, plan: plan, ItemID: ItemID, GPU: GPU},
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
                $('#tpu-modal').find('.modal-body').html(data);
                $('#tpu-modal .modal-title').html('บันทึกรายการยาการค้า ใบขอซื้อ');
                $('#data').html(data);
                $('.page-content').waitMe('hide');
                $('#tpu-modal').modal('show');
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
                    $('#tpu-modal').find('.modal-body').html(data);
                    $('#data').html(data);
                    $('#tpu-modal .modal-title').html('ปรับปรุงรายการยาการค้าจะซื้อจะขาย ใบขอซื้อ');
                    $('.page-content').waitMe('hide');
                    $('#tpu-modal').modal('show');

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
                                        $.pjax.reload({container: '#detail_tpu_pjax'});
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
$('#detail_tpu_pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
/* Savedraft */
$('#form-verify').on('beforeSubmit', function (e)
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
