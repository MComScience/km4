/*function init_click_handlers() {
 $('.activity-delete-link').click(function (e) {
 var fID = $(this).closest('tr').data('key');
 swal({
 title: "ยืนยันการลบ?",
 text: "",
 type: "warning",
 showCancelButton: true,
 closeOnConfirm: true,
 closeOnCancel: true,
 confirmButtonText: "Yes, delete it!",
 },
 function (isConfirm) {
 if (isConfirm) {
 $.post(
 'delete-tempgpu',
 {
 id: fID
 },
 function (data)
 {
 setTimeout(function () {
 swal("Deleted!", "", "success");
 $.pjax.reload({container: '#pjax-gpu-index'});
 }, 1000);
 }
 );
 }
 });
 });
 }
 init_click_handlers(); //first run
 $('#pjax-gpu-index').on('pjax:success', function () {
 init_click_handlers(); //reactivate links in grid after pjax update
 });*/
$(document).ready(function () {
    $('table.default').DataTable({
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
            {"bSortable": false}
        ],
        "language": {
            "search": "_INPUT_ " + '<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100" >\n\
                                                สร้างใบขอซื้อ <b class="caret"></b>\n\
                                            </a>\n\
                                            <ul class="dropdown-menu dropdown-success">\n\
                                                <li><a href="/km4/pr/gpu/create" data-pjax="0"><div class="panel-title"><i class="glyphicon glyphicon-edit"></i> ยาสามัญ</div></a></li>\n\
                                                <li><a href="/km4/pr/tpu/create" data-pjax="0"><div class="panel-title"><i class="glyphicon glyphicon-edit"></i> ยาการค้า</div></a></li>\n\
                                                <li><a href="/km4/pr/nd/create" data-pjax="0"><div class="panel-title"><i class="glyphicon glyphicon-edit"></i> เวชภัณฑ์</div></a></li>\n\
                                                <li><a href="/km4/pr/tpu-cont/create" data-pjax="0"><div class="panel-title"><i class="glyphicon glyphicon-edit"></i> ยาการค้าจะซื้อจะขาย</div></a></li>\n\
                                                <li><a href="/km4/pr/nd-cont/create" data-pjax="0"><div class="panel-title"><i class="glyphicon glyphicon-edit"></i> เวชภัณฑ์จะซื้อจะขาย</div></a></li>\n\
                                            </ul>',
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
        /*"paging":   false,
         "ordering": false,
         "info":     false*/
    });
});