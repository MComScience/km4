$(function () {
    GetVendorName();
});
$(document).ready(function () {
    $(".modal-reject").on('show.bs.modal', function () {
        setTimeout(function () {
        }, 0);
    });
});
function GetVendorName() {
    var vd1 = $('#tbpo2-vendorid').val();
    var vd2 = $('#tbpo2-menu_vendorid').val();
    if (vd1 !== "") {
        $.ajax({
            url: "get-vendorname",
            type: "post",
            data: {id: vd1},
            dataType: 'json',
            success: function (result) {
                $("#tbpo2-vendorname").val(result);
            }
        });
    }
    if (vd2 !== "") {
        $.ajax({
            url: "get-vendorname",
            type: "post",
            data: {id: vd2},
            dataType: 'json',
            success: function (result) {
                $("#tbpo2-menuvendorname").val(result);
            }
        });
    }
}
/*Reject*/
$('#btn-reject').click(function (e) {
    $('#modal_reject').modal('show');
    $('#modal_reject .modal-title').html('เหตุผลการ Reject Approve');
});
$('#SaveRejectApprove').click(function (e) {
    var POID = $("#tbpo2-poid").val();
    var PONum = $("#tbpo2-ponum").val();
    var PORejectReason = $("#PRRejectReason").val();
    var l = $('.btn-reject').ladda();
    l.ladda('start');
    if (PORejectReason === "") {
        swal({
            title: "",
            text: "กรุณากรอกเหตุผล!",
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
    } else {
        $.post(
                'rejected-approve',
                {
                    POID: POID, PORejectReason: PORejectReason, PONum: PONum
                },
                function (data)
                {
                    window.location.replace("/km4/po/default/list-approve");
                }
        ).fail(function (xhr, status, error) {
            swal("Oops...", error, "error");
            l.ladda('stop');
        });
    }
});
/*Approve*/
$('.btn-approve').click(function (e) {
    var POID = $("#tbpo2-poid").val();
    swal({
        title: "ยืนยันการอนุมัติ?",
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
                            'approved',
                            {
                                POID: POID
                            },
                            function (data)
                            {
                                window.location.replace("/km4/po/default/list-approve");
                            }
                    ).error(function (xhr, status, error) {
                        swal("Oops...", error, "error");
                    });
                }
            });
});
function init_click_handlers() {
    /*Edit Verify*/
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-detail-approve',
                {
                    id: fID
                },
                function (result)
                {
                    $('#formitemdetails').trigger("reset");
                    $('#modal-from').find('.modal-body').html(result);
                    $('#modalcontent').html(result);
                    $('#modal-from .modal-title').html('ปรับปรุงรายการใบสั่งซื้อ');
                    $('.page-content').waitMe('hide');
                    $('#modal-from').modal('show');
                }
        ).fail(function (xhr, status, error) {
            $('.page-content').waitMe('hide');
            swal("Oops...", error, "error");
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
                                'delete-detail-verify',
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    setTimeout(function () {
                                        swal("Deleted!", "", "success");
                                        $.pjax.reload({container: '#po_detail_2'});
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
$('#po_detail_1,#po_detail_2').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
/* เรียกใช้ Modal เลือกยาการค้า */
function GetModalTableTPU() {
    if ($("#content-table-tpu2").val() !== '') {
        $('#modal-table-tpu2').modal('show');
    } else {
        LoadingClass();
        $.ajax({
            url: 'get-modal-tpu',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modal-table-tpu2').find('.modal-body').html(data);
                $('#content-table-tpu2').html(data);
                $('div#modal-table-tpu2 .modal-title').html('เลือกรายการยาการค้า');
                $('.page-content').waitMe('hide');
                $('#modal-table-tpu2').modal('show');
                var t = $('#datatable-tpu2').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
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

                $('#datatable-tpu2 tbody').on('click', 'tr', function () {
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
            },
        });
    }
}
/* เรียกใช้ Modal เลือกรายการเวชภัณฑ์ */
function GetModalTableND() {
    if ($("#content-table-nd2").val() !== '') {
        $('#modal-table-nd2').modal('show');
    } else {
        LoadingClass();
        $.ajax({
            url: 'get-modal-nd',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#modal-table-nd2').find('.modal-body').html(data);
                $('#content-table-nd2').html(data);
                $('div#modal-table-nd2 .modal-title').html('เลือกรายการเวชภัณฑ์');
                $('.page-content').waitMe('hide');
                $('#modal-table-nd2').modal('show');
                var t = $('#datatable-nd').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    "responsive": true,
                    "bDestroy": true,
                    "bAutoWidth": true,
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
            },
        });
    }
}
function SelectItemType2(e) {
    var ItemID = (e.getAttribute("data-id"));
    var POID = $('#tbpo2-poid').val();
    LoadingClass();
    $.ajax({
        url: 'add-itemdetailverify-type2',
        type: 'POST',
        data: {ItemID: ItemID, POID: POID},
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
                $('#modal-from').find('.modal-body').html(result);
                $('#modal-from .modal-title').html('บันทึกรายการใบสั่งซื้อ');
                $('#modalcontent').html(result);
                $('.page-content').waitMe('hide');
                $('#modal-from').modal('show');
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
function CancelPO() {
    var PONum = $('#tbpo2-ponum').val();
    var POID = $('#tbpo2-poid').val();
    swal({
        title: "Are you sure cancel?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        closeOnCancel: true,
        confirmButtonText: "Confirm!",
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'cancel-po',
                            {
                                PONum: PONum, POID: POID
                            },
                            function (result)
                            {
                                if (result === 'false') {
                                    swal("ไม่สามารถยกเลิกได้!", "ใบสั่งซื้อเลขที่ " + PONum + " มีการรับสินค้าไปแล้ว!", "error");
                                } else {
                                    window.location.replace("/km4/po/default/approve");
                                }
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops!", error, "error");
                    });
                }
            });
}