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
            "search": "ค้นหา : _INPUT_ " + '<a href="javascript:GetModalTableTPU(this)" class="btn btn-success ladda-button"  data-style= "expand-left"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการยาการค้า</a>'
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
/* เรียกใช้ Modal เลือกยาการค้า */
function GetModalTableTPU() {
    LoadingClass();
    $.ajax({
        url: 'get-table-tpu',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#modal-table-tpu').find('.modal-body').html(data);
            $('#contenttabletpu').html(data);
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
function AdditemDetail(TMTID_TPU) {
    LoadingClass();
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    $.ajax({
        url: 'add-itemdetail',
        type: 'GET',
        data: {TMTID_TPU: TMTID_TPU, PCPlanNum: PCPlanNum},
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
                $('#tpu-modal').find('.modal-body').html(result);
                $('#tpu-modal .modal-title').html('บันทึกรายการยาการค้า แผนจัดซื้อ');
                $('#contentfrom').html(result);
                $('.page-content').waitMe('hide');
                $('#tpu-modal').modal('show');
                $('#tbpcplantpudetail-pcplannum').val(PCPlanNum);
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
            $('#tpu-modal').find('.modal-body').html(result);
            $('#tpu-modal .modal-title').html('แก้ไขรายการยาการค้า แผนจัดซื้อ');
            $('#contentfrom').html(result);
            $('.page-content').waitMe('hide');
            $('#tpu-modal').modal('show');
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
function Approved() {
    var frm = $('#fromheader');
    swal({
        title: "ยืนยันการอนุมัติ?",
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
                    $.ajax({
                        type: frm.attr('method'),
                        url: 'approve',
                        data: frm.serialize(),
                        success: function (result) {
                            window.location.replace("/km4/plan/default/waiting-verify");
                        },
                        error: function (xhr, status, error) {
                            swal({
                                title: error,
                                text: "",
                                type: "error",
                                confirmButtonText: "OK"
                            });
                        },
                    });
                }
            });
}
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