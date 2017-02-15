$(function () {
    GetVendorName();
});
function GetVendorName() {
    var vd1 = $('#tbpo2temp-vendorid').val();
    var vd2 = $('#tbpo2temp-menu_vendorid').val();
    if (vd1 !== "") {
        $.ajax({
            url: "get-vendorname",
            type: "post",
            data: {id: vd1},
            dataType: 'json',
            success: function (result) {
                $("#tbpo2temp-vendorname").val(result);
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
                $("#tbpo2temp-menuvendorname").val(result);
            }
        });
    }
}
/* เลขที่ผู้จำหน่าย */
$("#tbpo2temp-vendorid").keyup(function () {
    if ($(this).val() === '') {
        $('#tbpo2temp-vendorname').val(null);
    }
});
/* ผู้ผลิต */
$("#tbpo2temp-menu_vendorid").keyup(function () {
    if ($(this).val() === '') {
        $('#tbpo2temp-menuvendorname').val(null);
    }
});

function SelectItem(e) {
    var TMTID_GPU = (e.getAttribute("gpu"));
    var ids = (e.getAttribute("key"));
    LoadingClass();
    $.ajax({
        url: 'get-table-tpu',
        type: 'GET',
        data: {ids: ids, TMTID_GPU: TMTID_GPU},
        dataType: 'json',
        success: function (data) {
            $('#modal-table-tpu').find('.modal-body').html(data);
            $('#tabletpu').html(data);
            $('div#modal-table-tpu .modal-title').html('เลือกรายการยาการค้า');
            $('.page-content').waitMe('hide');
            $('#modal-table-tpu').modal('show');
            var t = $('#datatable-tpu').DataTable({
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

            $('#datatable-tpu tbody').on('click', 'tr', function () {
                if ($(this).hasClass('warning')) {
                    $(this).removeClass('warning');
                } else {
                    $('tr.warning').removeClass('warning');
                    $(this).addClass('warning');
                }
            });
            t.on('order.dt search.dt', function () {
                t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
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

function SelectTPU(e) {
    var ids = (e.getAttribute("ids"));
    var ItemID = (e.getAttribute("itemid"));
    var POID = $('#tbpo2temp-poid').val();
    var PRTypeID = $('#tbpr2-prtypeid').val();
    LoadingClass();
    $.ajax({
        url: 'checkitem-onplan',
        type: 'POST',
        data: {ItemID: ItemID, PRTypeID: PRTypeID},
        dataType: 'json',
        success: function (result) {
            if (result === 'false') {
                swal({
                    title: "Alert Message?",
                    text: '<span style="color:#DD6B55">รหัสสินค้า ' + ItemID + ' เป็นรหัสสินค้าที่มีรหัสยาสามัญไม่มีอยู่ในแผน!<span>',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "ยืนยัน!",
                    cancelButtonText: "ยกเลิก!",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    html: true,
                    showLoaderOnConfirm: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                GetFromCreate(ids, POID, ItemID);
                            } else {
                                $('.page-content').waitMe('hide');
                                swal.close();
                            }
                        });
            } else {
                GetFromCreate(ids, POID, ItemID);
            }
        },
        error: function (xhr, status, error) {
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

function GetFromCreate(ids, POID, ItemID) {
    $.ajax({
        url: 'add-itemdetail',
        type: 'POST',
        data: {ids: ids, POID: POID, ItemID: ItemID},
        //dataType: 'json',
        success: function (result)
        {
            if (result === 'duplicate') {
                swal({
                    title: "",
                    text: "คุณเลือกตัวยาซ้ำ!",
                    type: "warning"
                });
                $('.page-content').waitMe('hide');
            } else {
                $('#formitemdetails1').trigger("reset");
                $('#modal-from').find('.modal-body').html(result);
                $('#modal-from .modal-title').html('บันทึกรายการใบสั่งซื้อ');
                $('#modalcontent').html(result);
                $('.page-content').waitMe('hide');
                $('#modal-from').modal('show');
                swal.close();
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
    $('.activity-update-type1').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-detail1',
                {
                    id: fID
                },
                function (result)
                {
                    $('#formitemdetails1').trigger("reset");
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
    /* DoubleClick Edit */
    $('table.kv-grid-table').on('dblclick', 'tr', function (e) {
        var fID = $(this).data('key');
        if (fID !== undefined) {
            LoadingClass();
            $.get(
                    'update-detail1',
                    {
                        id: fID
                    },
                    function (result)
                    {
                        $('#formitemdetails1').trigger("reset");
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
        }
    });
}
init_click_handlers(); //first run
$('#po_detail_1').on('pjax:success', function () {
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
    var POID = $('#tbpo2temp-poid').val();
    LoadingClass();
    $.ajax({
        url: 'add-itemdetail-type2',
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
                $('#formitemdetails1').trigger("reset");
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

/* Function แก้ไข,ลบ ข้อมูลที่บันทึกลงตาราง */
function init_click_handlers2() {
    /* Edit */
    $('.activity-update-type2').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-detail1',
                {
                    id: fID
                },
                function (result)
                {
                    $('#formitemdetails1').trigger("reset");
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
    $('.activity-delete-type2').click(function (e) {
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
                                'delete-detailtemp',
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
    /* DoubleClick Edit */
    $('table.kv-grid-table').on('dblclick', 'tr', function (e) {
        var fID = $(this).data('key');
        if (fID !== undefined) {
            LoadingClass();
            $.get(
                    'update-detail1',
                    {
                        id: fID
                    },
                    function (result)
                    {
                        $('#formitemdetails1').trigger("reset");
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
        }
    });
}
init_click_handlers2(); //first run
$('#po_detail_2').on('pjax:success', function () {
    init_click_handlers2(); //reactivate links in grid after pjax update
});
/* Savedraft */
$('#formpotemp').on('beforeSubmit', function (e)
{
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                $('#tbpo2temp-ponum').val(result);
                swal({
                    title: "SaveDraft Success!",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $('#formitemdetails1').trigger("reset");
                                l.ladda('stop');
                                $(".btn-sendtoverify").removeAttr("disabled");
                            }
                        });
            })
            .fail(function (xhr, status, error)
            {
                l.ladda('stop');
                swal("Oops...", error, "error");
                console.log(error);
            });
    return false;
});

/* Function ส่งใบสั่งซื้อไป verify */
$('.btn-sendtoverify').click(function (e) {
    var POID = $("#tbpo2temp-poid").val();
    var PONum = $("#tbpo2temp-ponum").val();
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
                            'sendtoverify',
                            {
                                PONum: PONum, POID: POID
                            },
                            function (result)
                            {
                                if(result === 'มีรายการที่ไม่ได้บันทึกจำนวนสั่งซื้อ!'){
                                    swal("ไม่สามารถส่งได้!", result, "error");
                                }else{
                                    window.location.replace("/km4/po/default/index");
                                }
                            }
                    ).fail(function (xhr, status, error) {
                        swal("Oops!", error, "error");
                        console.log(error);
                    });
                }
            });
});