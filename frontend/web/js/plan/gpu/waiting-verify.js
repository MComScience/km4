$(document).ready(function () {
    var t = $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ],
        "language": {
            "search": "ค้นหา : _INPUT_ ",
            /*"searchPlaceholder": "ค้นหาข้อมูล...",*/
            "lengthMenu": "_MENU_",
            "infoEmpty": "No records available",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
    });
    $('table.default tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            t.$('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
    });
    t.on('order.dt search.dt', function () {
        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});