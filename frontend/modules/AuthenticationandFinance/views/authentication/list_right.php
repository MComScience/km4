
<style media="all" type="text/css">
  .alignLeft { text-align: left; }
  .alignCenter { text-align: center; }
  .alignRight { text-align: right; }
</style>
<div class="row">
  <div class="col-md-12">
    <table border="1" id="tabledata_right" width="100%"  class="table table-striped table-bordered dt-responsive">
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
<div id="add_right">
</div>
<?php
$script = <<< JS

$(document).ready(function() {
  var table = $('#tabledata_right').DataTable( {
    "processing": true,
    "serverSide": true,
    "type":'GET',
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
    {sClass: "alignCenter" },   
    { sClass: "alignCenter" } ,
    { sClass: "alignCenter" }  ,
    { sClass: "alignLeft" }   ,
    {sClass: "alignCenter","mRender": function ( data, type, row ) {
      return '<a class="btn btn-success btn-xs" href="javascript:selectar('+row[0]+')">Select</a>';}
    }

    ] ,
  } );


});


JS;
$this->registerJs($script);
?>
<script>
  function selectar(ar_id) {
    waitMe_Running_show(1);
    var hn = $('#hn').val();
    var vn = $('#vn').val();
    $.ajax({
      url: 'index.php?r=AuthenticationandFinance/authentication/addarto-patain-add-right',
      type: 'get',
      data: {ar_id: ar_id, hn: hn, vn: vn},
      success: function (data) {
        $('#add_right').html(data);
        waitMe_Running_hide(1);

      }
    });
  }
</script>
