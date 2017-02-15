jQuery.extend(jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function (a) {
        if (a == null || a == "") {
            return 0;
        }
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },

    "date-uk-asc": function (a, b) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },

    "date-uk-desc": function (a, b) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    },
    "currency-pre": function (a) {
        a = (a === "-") ? 0 : a.replace(/(\/.*)/i, "");
        a = (a === "-") ? 0 : a.replace(/[^\d\-\.]/g, "");
        return parseFloat(a);
    },

    "currency-asc": function (a, b) {
        return a - b;
    },

    "currency-desc": function (a, b) {
        return b - a;
    }
});
$(document).ready(function () {
    var t = $('#table1').DataTable({
        "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
        "pageLength": 20,
        "responsive": true,
        //"ordering": false,
        "columns": [
            null,
            {type: 'currency', targets: 0},
            null,
            null,
            {type: 'date-uk', targets: 0},
            null,
            null,
            null,
            null,
            {type: 'date-uk', targets: 0},
            null
        ],
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": "ค้นหา : _INPUT_ ",
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ]
    });
    
    $('#table1 tbody').on('click', 'tr', function () {
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
    
    var x = $('#table2').DataTable({
        "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
        "pageLength": 20,
        "responsive": true,
        //"ordering": false,
        "language": {
            "search": "ค้นหา : _INPUT_ ",
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ]
    });
    
    $('#table2 tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            x.$('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
    });

    x.on('order.dt search.dt', function () {
        x.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
});