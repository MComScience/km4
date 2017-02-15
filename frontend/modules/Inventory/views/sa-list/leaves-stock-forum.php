<?php

use yii\bootstrap\Modal;
use app\modules\Inventory\models\TbStk;

$r = TbStk::find()->all();
$this->registerJs('$("#tab_C").addClass("active");');
?>

<body onload="showmodal()">
    
</body>

<?php
Modal::begin([
    'id' => 'report_id',
    'header' => '<h4 class="modal-title">เงื่อนไขรายงาน :</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<a href="index.php?r=" class="btn btn-default" >Close</a>'
]);
?>
<div class="row">
<div class="form-inline">
    <label class="control-label col-sm-3" for="inputEmail3">เลือกคลังสินค้า</label>
    <div class="col-sm-6">
        <select id="stk_id"  name="stk_name" class="form-control">
            <?php foreach ($r as $result) { ?>
                <option value="<?php echo $result->StkID ?>"><?php echo $result->StkName ?></option>
            <?php } ?>
        </select>
          <label class="control-label col-sm-3" for="inputEmail3">เลือกประเภท</label>
        <select id="catid"  name="catid" class="form-control">
           
                <option value="1">ยา</option>
                 <option value="2">เวชภัณฑ์</option>
          
        </select>
        
    </div>
    <a id="searchreport" href="javascript:void(0)" class="btn btn-primary">Report</a>
</div>
</div>
<br>
<?php Modal::end(); ?>
<script>
    function showmodal() {
        $('#report_id').modal({
            show: 'true'
        });
    }
</script>
<?php
$s = <<< JS
 
    
$('#searchstk_yearcut').click(function (e) {
    window.open("index.php?r=Report/report-inventory/yearcut?year="+$('#stk_yearcut_').val(),'_blank');
});         
        
$('#searchreportmovment').click(function (e) {
    window.open("index.php?r=Report/report-inventory/productmovements?date_start="+$('#date_start_movment').val()+"&date_end="+$('#date_end_movment').val(),'_blank');
});
$('#searchreportlastmovment').click(function (e) {
    window.open("index.php?r=Report/report-inventory/vwstkcardlastmovement?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});
        
$('#searchreport').click(function (e) {
    window.open("index.php?r=Report/report-inventory/balance-itemid2count-mpdf?stkid="+$('#stk_id').val()+"&ItemCatID="+$('#catid').val(),'_blank');
});
$('#searchreportcount').click(function (e) {
    window.open("index.php?r=Report/report-inventory/balance-itemid2count?stkid="+$('#stk_id2').val(),'_blank');
});
$('#searchpocompareplan').click(function (e) {
    window.open("index.php?r=Report/report-purchasing/pocompareplan?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});
$('#searchhistorynoapprovethedrugoffplannew').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/history-noapprove-thedrugoffplannew?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});
 $('#searchhistoryapprovethedrugoffplannew').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/history-approve-thedrugoffplannew?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});       
 
$('#searchcomparedtheagreementtoselldrugtrade').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/compared-theagreementtosell-drug-trade?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&pcplantype="+$('#pcpalntype').val(),'_blank');
}); 
$('#searchhistoryreportorderitemmedicinedrug').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/historyreport-order-itemmedicine?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&PRType="+$('#pcpalntype').val(),'_blank');
});         
$('#searchpocompareplangenerics').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/pocompareplangeneric?date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&type="+$('#pcpalntype').val(),'_blank');
});    
   
JS;
$this->registerJs($s);
?>

