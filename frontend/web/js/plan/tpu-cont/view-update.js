$(document).ready(function () {
    GettableDetails();
    GetVendorName();
});
function GettableDetails() {
    var PCPlanNum = $('#tbpcplan-pcplannum').val();
    var type = 'view';
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
            "search": "ค้นหา : _INPUT_ "
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
        };
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
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