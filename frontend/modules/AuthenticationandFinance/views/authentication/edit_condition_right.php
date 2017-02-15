<?php

use kartik\widgets\ActiveForm;
use kartik\helpers\Html;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
?>
<label><strong>รายละเอียดสิทธิ</strong></label> <br>
<label>กลุ่มสิทธิ์</label>  <label>ประเภทของสิทธิ์</label><br>
<label>ชื่อหน่วยงานต้นสิทธิ์</label><br>
<hr>
<div class="form-inline">
    <strong>เงื่อนไขการใช้สิทธิ</strong>
</div>  
<div class="form-inline">
    <input type="checkbox" name="ar_opd_budgetlimit" value="<?php echo $modelpaymentcondition->ar_opd_budgetlimit ?>" /><label>&nbsp;จำกัดวงเงินรักษาผู้ป่วยนอก วงเงิน: <input type="text" class="form-control" value="<?php echo $modelpaymentcondition->ar_opd_budgetlimit_amt ?>"/> บาท</label>   
</div>
<div class="form-inline">
    <input type="checkbox" name="ar_ipd_budgetlimit" value="<?php echo $modelpaymentcondition->ar_ipd_budgetlimit ?>" /><label>&nbsp;จำกัดวงเงินการรักษาผู้ป่วยใน วงเงิน: <input type="text" class="form-control" value="<?php echo $modelpaymentcondition->ar_ipd_budgetlimit_amt ?>"/> บาท</label>   
</div>
<div class="form-inline">
    <input type="checkbox" name="ar_year_budgetlimit" value="<?php echo $modelpaymentcondition->ar_year_budgetlimit ?>" /><label>&nbsp;จำกัดวงเงินการรักษารายปี วงเงิน: <input type="text" class="form-control" value="<?php echo $modelpaymentcondition->ar_year_budgetlimit_amt ?>"/> บาท</label>   
</div>
<div class="form-inline">
    <input type="checkbox" name="ar_drug_ned_allowed" value="<?php echo $modelpaymentcondition->ar_drug_ned_allowed ?>" /><label>&nbsp;จำกัดการใช้ยา NED</label>   
</div>
<div class="form-inline">
    <input type="checkbox" name="ar_drug_ned_period" value="<?php echo $modelpaymentcondition->ar_drug_ned_period ?>" /><label>&nbsp;จำกัดการใช้ยา NED วงเงิน: <input type="text" class="form-control" value="<?php echo $modelpaymentcondition->ar_drug_ned_limit_amt ?>"/> บาท <input type="text" class="form-control" value="<?php echo $modelpaymentcondition->ar_drug_ned_period ?>"/></label>   
</div>
<?php  echo   $form->field($modelpaymentcondition, 'ar_paymentcondition_id')->hiddenInput()->label(false); ?>
<div class="form-group" style="text-align: right;">
    <hr>
    <div style="margin-right: 10px">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>  
    </div>  
</div>
<?php ActiveForm::end(); ?>