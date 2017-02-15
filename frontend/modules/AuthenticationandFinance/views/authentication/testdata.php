<style media="all" type="text/css">
    .alignLeft { text-align: left; }
    .alignCenter { text-align: center; }
    .alignRight { text-align: right; }
</style>
<div class="container">
	<div class="well">	
     <table id="example" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
           <tr>
              <th style="text-align:center">ลำดับสิทธิ์</th>
              <th style="text-align:center">กลุ่มสิทธิ์</th>
              <th style="text-align:center">ประเภทสิทธิ์</th>
              <th style="text-align:center">ชื่อหน่วยงานต้นสิทธิ์</th>
              <th style="text-align:center">Action</th>
          </tr>
      </thead>
  </table>
</div>
</div>

<?php
$script = <<< JS

$(document).ready(function() {
    var table =	$('#example').DataTable( {
      "processing": true,
      "serverSide": true,
      "ajax": "index.php?r=AuthenticationandFinance%2Fauthentication/get-ar-list",
      "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
      "pageLength": 5,

      "language": {
        "lengthMenu": " _MENU_ ",
        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
        "search": "ค้นหา "
    },
    "aLengthMenu": [
    [5, 10, 15, 20, 100, -1],
    [5, 10, 15, 20, 100, "All"]
    ],
    "aoColumns" : [   
    {sWidth: '10%',sClass: "alignCenter" },   
    { sClass: "alignCenter" } ,
    { sClass: "alignCenter" }  ,
    { sClass: "alignLeft" }   ,
    {sClass: "alignCenter","mRender": function ( data, type, row ) {
        return '<a class="btn btn-success btn-xs" href="javascript:editdata('+row[0]+')">Edit</a> <a class="btn btn-danger btn-xs" href="javascript:deletedata('+row[0]+')">delete</a>';}
    }

    ] ,
} );


});


JS;
$this->registerJs($script);
?>
<script type="text/javascript">
    function deletedata(id){
        alert(id);
    }
    function editdata(id){
alert(id);
    }
</script>