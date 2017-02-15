<?php

use yii\bootstrap\Modal;
use app\modules\Inventory\models\Tbstk;
//use yii\bootstrap\ActiveForm;
use kartik\form\ActiveForm;
use yii\jui\DatePicker;

$r = Tbstk::find()->all();
$this->registerJs('$("#tab_C").addClass("active");');
?>
<div class="row">
    <div class="col-md-12">
        <div class="profile-container">
            <?= $this->render('header'); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?= $this->render('_tab'); ?>
                        <div class="tab-content tabs-flat">
                            <div class="row profile-overview">
                                <div class="col-xs-12 col-md-12">
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="widget">
                                            <div class="widget-header bordered-bottom bordered-palegreen">
                                                <span class="widget-caption">รายงานสินค้าคงคลัง</span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <strong>ยา</strong>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a  target="_blank" href="index.php?r=Report/report-inventory/balancetotaldrug&ItemCatID=1">รายงานยอดคงเหลือรวม</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="sum_all" href="javascript:void(0)">รายงานยอดคงเหลือแยกตามคลังสินค้า</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="sum_allcount" href="javascript:void(0)">รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="summont" href="javascript:void(0)">รายงานปริมาณการขายสินค้า สรุปรายเดือน</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/balancelotnumber&ItemCatID=1">รายงานยอดคงเหลือแยกตาม Lot </a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="movment_" href="javascript:void(0)">รายงานเคลื่อนไหวคลังสินค้า</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="lastmovment_" href="javascript:void(0)">รายงานสินค้าที่ไม่มีการเคลื่อนไหว</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/reportexpired&ItemCatID=1">รายงานสินค้าหมดอายุ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/reportreorderpoint&ItemCatID=1">รายงานสินค้าต่ำกว่าจัดสั่งชื้อ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/reportoverstock&ItemCatID=1">รายงานสินค้าสูงกว่าระดับการเก็บ</a>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <strong>เวชภัณฑ์</strong>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a  target="_blank" href="index.php?r=Report/report-inventory/balancetotaldrug&ItemCatID=2">รายงานยอดคงเหลือรวม</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="sum_all2" href="javascript:void(0)">รายงานยอดคงเหลือแยกตามคลังสินค้า</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="sum_allcount2" href="javascript:void(0)">รายงานยอดคงเหลือแยกตามคลังสินค้าเพื่อตรวจนับ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="summont2" href="javascript:void(0)">รายงานปริมาณการขายสินค้า สรุปรายเดือน</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/balancelotnumber&ItemCatID=2">รายงานยอดคงเหลือแยกตาม Lot </a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="movment_2" href="javascript:void(0)">รายงานเคลื่อนไหวคลังสินค้า</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="lastmovment_2" href="javascript:void(0)">รายงานสินค้าที่ไม่มีการเคลื่อนไหว</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/reportexpired&ItemCatID=2">รายงานสินค้าหมดอายุ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/reportreorderpoint&ItemCatID=2">รายงานสินค้าต่ำกว่าจัดสั่งชื้อ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-inventory/reportoverstock&ItemCatID=2">รายงานสินค้าสูงกว่าระดับการเก็บ</a>
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="widget">
                                            <div class="widget-header bordered-bottom bordered-palegreen">
                                                <span class="widget-caption">รายงานการจัดชื้อ</span>
                                            </div>
                                            <div class="widget-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <!--<strong>ยา</strong>-->
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="" href="javascript:void(0)">รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a target="_blank" id="historyreportorderitemmedicinedrug" href="javascript:void(0)">ยา </a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a target="_blank" id="historyreportorderitemmedicinenondrug" href="javascript:void(0)">เวชภัณฑ์ </a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="statuspoforgr" href="javascript:void(0)">รายงานสถานะการสั่งชื้อ</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a target="_blank" href="index.php?r=Report/report-purchasing/senditemschangescenarios">รายงานสถานะการณ์ส่งเปลี่ยนคืนสินค้า</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a  target="_blank" href="index.php?r=Report/report-inventory/assessmentreportdeliveredbysupplier">รายงานการประเมินการส่งมอบสินค้าจากผู้จำหน่าย</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="pocompareplan" href="javascript:void(0)">รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a  id="pocompareplangenerics" href="javascript:void(0)">ยาสามัญ</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a  id="pocompareplandrugtrad" href="javascript:void(0)">ยาการค้า</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a  id="pocompareplannondrug" href="javascript:void(0)">เวชภัณฑ์</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="" href="javascript:void(0)">รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a target="_blank" id="comparedtheagreementtoselldrugtrade" href="javascript:void(0)">ยาการค้า</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a target="_blank" id="comparedtheagreementtosellnondrug" href="javascript:void(0)">เวชภัณฑ์</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="historyapprovethedrugoffplannew" href="javascript:void(0)">ประวัติการอนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="historynoapprovethedrugoffplannew" href="javascript:void(0)">ประวัติการไม่อนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)</a>
                                                        <br><i class="menu-icon fa fa-circle-thin"></i> <a id="" href="javascript:void(0)">(Price List)</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a target="_blank" id="" href="index.php?r=Report/report-purchasing/price-list-qu&ItemCatID=1">ราคายา (Price List)</a>
                                                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a target="_blank" id="" href="index.php?r=Report/report-purchasing/price-list-qu&ItemCatID=2">ราคาเวชภัณฑ์ (Price List)</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'report_id',
    'header' => '<h4 class="modal-title">เงื่อนไขรายงาน :</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div class="form-group field-inputEmail3 required ">
    <label class="control-label col-sm-3" for="inputEmail3">เลือกคลังสินค้า</label>
    <div class="col-sm-6">
        <select id="stk_id"  name="stk_name" class="form-control">
            <?php foreach ($r as $result) { ?>
                <option value="<?php echo $result->StkID ?>"><?php echo $result->StkName ?></option>
            <?php } ?>
        </select>
        <div class="help-block help-block-error "></div>
        <input type="hidden" id="catid_"/>
    </div>
    <a id="searchreport" href="javascript:void(0)" class="btn btn-primary">Report</a>
    <a id="searchreportcount" href="javascript:void(0)" class="btn btn-primary">Report</a>
</div>
<br>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'movment',
    'header' => '<h4 class="modal-title">เงื่อนไขรายงาน :</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<?php $form = ActiveForm::begin(); ?>
<div class="form-group field-inputEmail3 required ">
    <div class="col-sm-12">
        <div class="form-inline">
            <label class="control-label col-sm-3" for="inputEmail3">เลือกคลังสินค้า</label>    
            <?php
            echo
            $form->field($model, 'PCPlanBeginDate')->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'id' => 'date_start_movment',
                    'class' => 'form-control',
                    'placeholder' => 'Select  date ...',
                    'style' => 'background-color: #FFFF99'
                ],
            ])->label('วันที่เริ่ม');
            ?>
            <?php
            echo
            $form->field($model, 'PCPlanEndDate')->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'id' => 'date_end_movment',
                    'class' => 'form-control',
                    'placeholder' => 'Select  date ...',
                    'style' => 'background-color: #FFFF99'
                ],
            ])->label('วันที่สิ้นสุด');
            ?>
            <input type="hidden" id="catid3"/>
            <a id="searchreportmovment" href="javascript:void(0)" class="btn btn-primary">Report</a>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<br>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => '_lastmovment',
    'header' => '<h4 class="modal-title">เงื่อนไขรายงาน :</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<?php $form3 = ActiveForm::begin(); ?>

<div class="form-group field-inputEmail3 required ">
    <div class="col-sm-12">
        <div class="form-inline">
            <label class="control-label col-sm-3" for="inputEmail3">เลือกวันที่</label>    
            <?php
            echo
            $form3->field($model, 'PCPlanBeginDate')->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'id' => 'date_start_lastmovment',
                    'class' => 'form-control',
                    'placeholder' => 'Select  date ...',
                    'style' => 'background-color: #FFFF99'
                ],
            ])->label('วันที่เริ่ม');
            ?>
            <?php
            echo
            $form3->field($model, 'PCPlanEndDate')->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'id' => 'date_end_lastmovment',
                    'class' => 'form-control',
                    'placeholder' => 'Select  date ...',
                    'style' => 'background-color: #FFFF99'
                ],
            ])->label('วันที่สิ้นสุด');
            ?>
            <input type="hidden" id="pcpalntype" />
            <input type="hidden" id="catid4" />
            <a id="searchreportlastmovment" href="javascript:void(0)" class="btn btn-primary">Report</a>
            <a id="searchpocompareplan" href="javascript:void(0)" class="btn btn-primary">Report</a>
            <a id="searchhistorynoapprovethedrugoffplannew" href="javascript:void(0)" class="btn btn-primary">Report</a>
            <a id="searchhistoryapprovethedrugoffplannew" href="javascript:void(0)" class="btn btn-primary">Report</a>
            <a id="searchcomparedtheagreementtoselldrugtrade" href="javascript:void(0)" class="btn btn-primary">Report</a>
            <a id="searchhistoryreportorderitemmedicinedrug" href="javascript:void(0)" class="btn btn-primary">Report</a>
            <a id="searchpocompareplangenerics" href="javascript:void(0)" class="btn btn-primary">Report</a>

        </div> 
    </div>
</div>
<?php ActiveForm::end(); ?>
<br>
<br>
<br>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => 'stk_yearcut',
    'header' => '<h4 class="modal-title">เงื่อนไขรายงาน :</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<?php $form2 = ActiveForm::begin(); ?>
<div class="form-group field-inputEmail3 required ">
    <div class="form-inline">
        <div style="text-align: center">
            <!--<label class="control-label col-sm-3" for="inputEmail3">เลือกปี</label>-->   
            <?php
            
            $form2->field($model, 'PCPlanBeginDate')->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'id' => 'stk_yearcut_',
                    'class' => 'form-control',
                    'placeholder' => 'Select  date ...',
                    'style' => 'background-color: #FFFF99'
                ],
            ])->label('เลือกปี');
            ?>
			  <label class="control-label col-sm-3" for="inputEmail3">เลือกปี</label>
            <div class="col-sm-6">
                <select id="stk_yearcut_"  name="stk_yearcut_" class="form-control">
                    <?php foreach ($year as $result) { ?>
                        <option value="<?php echo $result->YEAR ?>"><?php echo $result->YEAR ?></option>
                    <?php } ?>
                </select>
                <div class="help-block help-block-error "></div>
            </div>
            <input type="hidden" id="catid2"/>
            <a id="searchstk_yearcut" href="javascript:void(0)" class="btn btn-primary">Report</a>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<br>
<?php Modal::end(); ?>
<?php
$s = <<< JS
 $('#comparedtheagreementtosellnondrug').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").removeClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
        $("#pcpalntype").val('6');
});         
$('#pocompareplannondrug').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").removeClass("hidden");
        $("#pcpalntype").val('3');
});
$('#pocompareplandrugtrad').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").removeClass("hidden");
        $("#pcpalntype").val('2');
});
$('#pocompareplangenerics').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").removeClass("hidden");
        $("#pcpalntype").val('1');
});
$('#historyreportorderitemmedicinedrug').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").removeClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
        $("#pcpalntype").val('1');
});
$('#historyreportorderitemmedicinenondrug').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").removeClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
        $("#pcpalntype").val('2');
});
$('#comparedtheagreementtoselldrugtrade').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").removeClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
        $("#pcpalntype").val('5');
});        
$('#historyapprovethedrugoffplannew').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").removeClass("hidden");
         $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
});
$('#historynoapprovethedrugoffplannew').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").removeClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
});
$('#pocompareplan').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").removeClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
});
$('#statuspoforgr').click(function (e) {
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").addClass("hidden");
        $("#searchpocompareplan").removeClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
         $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
});        
$('#sum_allcount').click(function (e) {
        $("#searchreport").addClass("hidden");
        $("#searchreportcount").removeClass("hidden");
        $('#catid_').val('1');
        $('#report_id').modal({show: 'true'}); 
});
$('#sum_allcount2').click(function (e) {
        $("#searchreport").addClass("hidden");
        $("#searchreportcount").removeClass("hidden");
        $('#catid_').val('2');
        $('#report_id').modal({show: 'true'}); 
});
 $('#summont').click(function (e) {
        $('#catid2').val('1');
        $('#stk_yearcut').modal({show: 'true'}); 
   });
$('#summont2').click(function (e) {
         $('#catid2').val('2');
        $('#stk_yearcut').modal({show: 'true'}); 
});
 $('#sum_all').click(function (e) {
        $("#searchreport").removeClass("hidden");
        $("#searchreportcount").addClass("hidden");
        $('#catid_').val('1');
        $('#report_id').modal({show: 'true'}); 
   });
   $('#sum_all2').click(function (e) {
        $("#searchreport").removeClass("hidden");
        $("#searchreportcount").addClass("hidden");
        $('#catid_').val('2');
        $('#report_id').modal({show: 'true'}); 
   });
   $('#movment_').click(function (e) {
        $('#catid3').val('1');
        $('#movment').modal({show: 'true'}); 
   });
   $('#movment_2').click(function (e) {
         $('#catid3').val('2');
        $('#movment').modal({show: 'true'}); 
   });
   $('#lastmovment_').click(function (e) {
        $('#catid4').val('1');
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").removeClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
   });
$('#lastmovment_2').click(function (e) {
        $('#catid4').val('2');
        $('#_lastmovment').modal({show: 'true'}); 
        $("#searchreportlastmovment").removeClass("hidden");
        $("#searchpocompareplan").addClass("hidden");
        $("#searchhistoryapprovethedrugoffplannew").addClass("hidden");
        $("#searchhistorynoapprovethedrugoffplannew").addClass("hidden");
        $("#searchcomparedtheagreementtoselldrugtrade").addClass("hidden");
        $("#searchhistoryreportorderitemmedicinedrug").addClass("hidden");
        $("#searchpocompareplangenerics").addClass("hidden");
   });
        
$('#searchstk_yearcut').click(function (e) {
    window.open("index.php?r=Report/report-inventory/yearcut&year="+$('#stk_yearcut_').val()+"&ItemCatID="+$('#catid2').val(),'_blank');
});         
        
$('#searchreportmovment').click(function (e) {
    window.open("index.php?r=Report/report-inventory/productmovements&date_start="+$('#date_start_movment').val()+"&date_end="+$('#date_end_movment').val()+"&ItemCatID="+$('#catid3').val(),'_blank');
});
$('#searchreportlastmovment').click(function (e) {
    window.open("index.php?r=Report/report-inventory/vwstkcardlastmovement&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&ItemCatID="+$('#catid4').val(),'_blank');
});
        
$('#searchreport').click(function (e) {
    window.open("index.php?r=Report/report-inventory/balancetotalnondrug&stkid="+$('#stk_id').val()+"&ItemCatID="+$('#catid_').val(),'_blank');
});
$('#searchreportcount').click(function (e) {
    window.open("index.php?r=Report/report-inventory/balance-itemid2count-mpdf&stkid="+$('#stk_id').val()+"&ItemCatID="+$('#catid_').val(),'_blank');
});
$('#searchpocompareplan').click(function (e) {
    window.open("index.php?r=Report/report-purchasing/pocompareplan&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});
$('#searchhistorynoapprovethedrugoffplannew').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/history-noapprove-thedrugoffplannew&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});
 $('#searchhistoryapprovethedrugoffplannew').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/history-approve-thedrugoffplannew&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val(),'_blank');
});       
 
$('#searchcomparedtheagreementtoselldrugtrade').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/compared-theagreementtosell-drug-trade&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&pcplantype="+$('#pcpalntype').val(),'_blank');
}); 
$('#searchhistoryreportorderitemmedicinedrug').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/historyreport-order-itemmedicine&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&PRType="+$('#pcpalntype').val(),'_blank');
});         
$('#searchpocompareplangenerics').click(function (e) {
  window.open("index.php?r=Report/report-purchasing/pocompareplangeneric&date_start="+$('#date_start_lastmovment').val()+"&date_end="+$('#date_end_lastmovment').val()+"&type="+$('#pcpalntype').val(),'_blank');
});    
   
JS;
$this->registerJs($s);
?>

