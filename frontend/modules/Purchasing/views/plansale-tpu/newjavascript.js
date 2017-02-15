$(document).ready(function () {
    $("#tablenondrug1").DataTable({bInfo: false,
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 5,
        responsive: true,
        "language": {
            "lengthMenu": " _MENU_ ",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "search": "ค้นหา "
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
    });
    $("#tbpcplan2-pcvendorid").click(function () {
        $.ajax({
            url: "index.php?r=Purchasing/tbplandrugsale/datavender",
            type: "post",
            dataType: 'json',
            success: function (r) {
                $('#tb_venderrs').modal('show');
                $('#_vender').html(r.data);
                $('#tb_venderrs').modal('show');
                $('#vender_select').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    "language": {
                        "lengthMenu": " _MENU_ ",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": "ค้นหา "
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    });
});
