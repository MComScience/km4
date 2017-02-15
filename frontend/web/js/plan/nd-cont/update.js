$(document).ready(function () {
    GettableDetails();
    GetVendorName();
});
function GettableDetails() {
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    var type = 'edit';
    LoadingClass();
    $.ajax({
        url: 'gettable-details',
        type: 'POST',
        data: {PCPlanNum: PCPlanNum, type: type},
        dataType: 'json',
        success: function (data) {
            $('#tables-content').html(data);
            SetDatatableDetails();
            $('.page-content').waitMe('hide');
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

function SetDatatableDetails() {
    var t = $("#tabledata").DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "order": [[1, "asc"]],
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": "ค้นหา : _INPUT_ " + '<a href="javascript:GetModalTableND(this)" class="btn btn-success ladda-button"  data-style= "expand-left"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการเวชภัณฑ์ฯ</a>'
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        "columns": [
            {"bSortable": false},
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ]
    });
    $('#tabledata tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            t.$('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
        ;
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
}

/* เรียกใช้ Modal เลือกยา */
function GetModalTableND() {
    $('#CheckOnSubmit').val('true');
    $('#fromheader').yiiActiveForm('validate', true);
    var e = document.getElementById("tbpcplan-pcplantypeid");
    var PCPlanTypeID = e.options[e.selectedIndex].text || null;
    if (PCPlanTypeID === '----- ประเภทแผนจัดซื้อ -----') {
        swal("Oops!", "กรุณาเลือกประเภทแผน!", "warning");
    } else if ($("#contenttablend").val() !== '') {
        $('#modal-table-nd').modal('show');
    } else {
        LoadingClass();
        $.ajax({
            url: 'get-table-nd',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modal-table-nd').find('.modal-body').html(data);
                $('#contenttablend').html(data);
                $('div#modal-table-nd .modal-title').html('เลือกรายการเวชภัณฑ์ฯ');
                $('.page-content').waitMe('hide');
                $('#modal-table-nd').modal('show');
                var t = $('#datatable-nd').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    "responsive": true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    //"bFilter": true,
                    //"bSort": false,
                    //"aaSorting": [[0]],
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

/* Savedraft */
$('#fromheader').on('beforeSubmit', function (e)
{
    var l = $('.save-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                if (result !== 'CheckOnSubmit') {
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
                                    $(".sendtoverify").removeAttr("disabled");
                                }
                            });
                } else {
                    l.ladda('stop');
                    $('#CheckOnSubmit').val('false');
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

function AdditemDetail(ItemID) {
    LoadingClass();
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    $.ajax({
        url: 'add-itemdetail',
        type: 'GET',
        data: {ItemID: ItemID, PCPlanNum: PCPlanNum},
        success: function (result)
        {
            if (result === 'false') {
                swal({
                    title: "",
                    text: "คุณเลือกตัวยาซ้ำ!",
                    type: "warning"
                });
                $('.page-content').waitMe('hide');
            } else {
                $('#formitemdetails').trigger("reset");
                $('#nd-modal').find('.modal-body').html(result);
                $('#nd-modal .modal-title').html('บันทึกรายการเวชภัณฑ์ฯ แผนจัดซื้อ');
                $('#contentfrom').html(result);
                $('.page-content').waitMe('hide');
                $('#nd-modal').modal('show');
                $('#tbpcplannddetail-pcplannum').val(PCPlanNum);
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

function EditDetails(ids) {
    LoadingClass();
    $.ajax({
        url: 'edit-detail',
        type: 'GET',
        data: {ids: ids},
        success: function (result)
        {
            $('#formitemdetails').trigger("reset");
            $('#nd-modal').find('.modal-body').html(result);
            $('#nd-modal .modal-title').html('แก้ไขรายการเวชภัณฑ์ฯ แผนจัดซื้อ');
            $('#contentfrom').html(result);
            $('.page-content').waitMe('hide');
            $('#nd-modal').modal('show');
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

function DeleteDetail(ids) {
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
                    $.get(
                            'delete-detail',
                            {
                                ids: ids
                            },
                            function (data)
                            {
                                GettableDetails();
                                setTimeout(function () {
                                    swal("Deleted!", "", "success");
                                }, 200);
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops...", error, "error");
                    });
                }
            });
}

$('.sendtoverify').click(function (e) {
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    swal({
        title: "ยืนยันการส่งอนุมัติ?",
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
                            'sendto-verify',
                            {
                                PCPlanNum: PCPlanNum
                            },
                            function (data)
                            {
                                window.location.replace("/km4/plan/default/index");
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops...", error, "error");
                    });
                }
            });
});

function GetVendorName() {
    var vendorid = $('#tbpcplan-pcvendorid').val() || null;
    if (vendorid !== null) {
        $.post(
                'getvdname',
                {
                    vendorid: vendorid
                },
                function (result)
                {
                    $('#tbpcplan-vendorname').val(result);
                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
        });
    }
}