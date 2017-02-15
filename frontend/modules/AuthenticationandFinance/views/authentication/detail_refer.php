<?php

use kartik\widgets\ActiveForm;
use kartik\helpers\Html;
use kartik\checkbox\CheckboxX;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<label><strong>รายละเอียดสิทธิ์</strong></label> <br>
<label>กลุ่มสิทธิ์</label>  <label>ประเภทของสิทธิ์</label><br>
<label>ชื่อหน่วยงานต้นสิทธิ์</label><br>
<label><strong>รายละเอียดใบส่งตัว</strong></label><br>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <?= Html::activeLabel($model, 'refer_hrecieve_doc_date', ['label' => 'เลขที่ใบส่งตัว', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'refer_hrecieve_doc_date', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
        <div class="form-group">
            <?= Html::activeLabel($model, 'refer_hrecieve_doc_date', ['label' => 'วันที่ใบส่งตัว', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'refer_hrecieve_doc_date', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
        <div class="form-group">
            <?= Html::activeLabel($model, 'ar_card_id', ['label' => 'เลขที่บัตรสิทธิ์การรักษา', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'ar_card_id', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
        <div class="form-group">
            <?= Html::activeLabel($model, 'pt_refer_note', ['label' => 'หมายเหตุ', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'pt_refer_note', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-sm-4 control-label" for="vwptardetail-refer_hrecieve_doc_date">ประเภทการใช้สิทธิ์</label>
            <div class="col-sm-8">
                <div class="col-md-12"><input type="radio" value="" name="refer_hsender_sent_typeid"/> ระยะเวลา <input type="radio" name="refer_hsender_sent_typeid"/> จำนวนครั้ง</div>
            </div>
        </div> 
        <div class="form-group">
            <?= Html::activeLabel($model, 'refer_hrecieve_doc_date', ['label' => 'จำนวนครั้งใช้สิทธิ์', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'refer_hrecieve_doc_date', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
        <div class="form-group">
            <?= Html::activeLabel($model, 'refer_hrecieve_doc_date', ['label' => 'วันที่เริ่มใช้สิทธิ์', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'refer_hrecieve_doc_date', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
        <div class="form-group">
            <?= Html::activeLabel($model, 'refer_hrecieve_doc_date', ['label' => 'วันที่สินสุดสิทธิ์', 'class' => 'col-sm-4 control-label']) ?>
            <div class="col-sm-6">
                <?= $form->field($model, 'refer_hrecieve_doc_date', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>   
    </div>
</div>
<hr>
  <div class="form-inline">
      <strong>เงื่อนไขการใช้สิทธิ</strong><div style="text-align: right"><a class="btn btn-success" id="btn_edit_condition_right" >Edit</a></div></div>   
</div>  
<div class="form-inline">
    <input type="checkbox" value="<?php echo $modelpaymentcondition->ar_opd_budgetlimit ?>" /><label>&nbsp;จำกัดวงเงินรักษาผู้ป่วยนอก วงเงิน: <?php echo $modelpaymentcondition->ar_opd_budgetlimit_amt ?> บาท</label>   
</div>
<div class="form-inline">
    <input type="checkbox" value="<?php echo $modelpaymentcondition->ar_ipd_budgetlimit ?>" /><label>&nbsp;จำกัดวงเงินการรักษาผู้ป่วยใน วงเงิน: <?php echo $modelpaymentcondition->ar_ipd_budgetlimit_amt ?> บาท</label>   
</div>
<div class="form-inline">
    <input type="checkbox" value="<?php echo $modelpaymentcondition->ar_year_budgetlimit ?>" /><label>&nbsp;จำกัดวงเงินการรักษารายปี วงเงิน: <?php echo $modelpaymentcondition->ar_year_budgetlimit_amt ?> บาท</label>   
</div>
<div class="form-inline">
    <input type="checkbox" value="<?php echo $modelpaymentcondition->ar_drug_ned_allowed ?>" /><label>&nbsp;จำกัดการใช้ยา NED</label>   
</div>
<div class="form-inline">
    <input type="checkbox" value="<?php echo $modelpaymentcondition->ar_drug_ned_period ?>" /><label>&nbsp;จำกัดการใช้ยา NED วงเงิน: <?php echo $modelpaymentcondition->ar_drug_ned_limit_amt ?> บาท <?php echo $modelpaymentcondition->ar_drug_ned_period ?></label>   
</div>
<div class="form-group" style="text-align: right;">
    <hr>
    <div style="margin-right: 10px">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>  
    </div>  
</div>
<?php ActiveForm::end(); ?>

<?php
$s = <<< JS
        
$('#btn_edit_condition_right').click(function (e) {
    $('#modal_edit_condition_right').modal({show: 'true'}); 
         $.ajax({
                url: 'index.php?r=AuthenticationandFinance/authentication/get-ar-paymentcondition',
                type: 'POST',
                success: function (data) {
                     $('#div_edit_condition_right').html(data);
                    }
}); 
});       
JS;
$this->registerJs($s);
?>