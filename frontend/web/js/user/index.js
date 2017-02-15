$('#Download').click(function (e) {
    window.open('/km4/frontend/web/uploads/user.xls', '_blank');
});
$('#Import').click(function (e) {
    $('.page-content').waitMe({
        effect: 'progressBar', //roundBounce
        text: 'กำลังนำเข้าข้อมูล...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#53a93f',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
});

$(document).ready(function () {
    var sum = $("#sum").val();
    if (sum == 0) {
        $('#sumalert').modal('show');
        $('#sum').val('1');
    }
    $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 20,
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
            {"bSortable": false}
        ],
        "language": {
            "search": "ค้นหา : _INPUT_ " + " <a href='create' class='btn btn-success' data-pjax='0'><i class='fa fa-user-plus'></i> Add Users</a>",
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
});

function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete',
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#pjax-users-index'});
                                }
                        );
                    }
                });
    });
    $(".activity-unblock-vendor").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "Unblock this user?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Confirm!",
            //closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get(
                                "block",
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#pjax-users-index'});
                                }
                        );
                    }
                });
    });

    $(".activity-block-vendor").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "Block this user?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            confirmButtonText: "Confirm!",
            //closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get(
                                "block",
                                {
                                    id: fID
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#pjax-users-index'});
                                }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#pjax-users-index').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});