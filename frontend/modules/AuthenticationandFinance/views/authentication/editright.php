<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
?>
<?php Pjax::begin(['id' => 'pjax_form_editright']); ?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_editright','options' => ['data-pjax' => true ]]); ?> 

<label style="font-size: 16pt" >รายละเอียดสิทธิ์</label><br>
    <label><b>กลุ่มของสิทธิ์</b> </label> <label> <?php echo $ar->medical_right_group ?></label> <label ><b>ประเภทของสิทธิ์</b></label> <label><?php echo $ar->medical_right_desc ?></label><br>

    <label  ><b>ชื่อหน่วยงานต้นสิทธิ์</b> </label> <label> <?php echo $ar->ar_name ?></label><br><br>

<hr>
<label style="font-size:150%;" class="control-label">เงื่อนไขการใช้สิทธิ์</label><br>
<div class="form-group">
    <div class="col-sm-4"> <?php
echo $form->field($modelpaymentcondition, 'ar_opd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
        'label' => 'จำกัดวงเงินการรักษาผู้ป่วยนอก',
        'position' => CheckboxX::LABEL_RIGHT
]]);
?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_opd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_opd_budgetlimit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99;text-align:right']); ?>
            </div>
            <div class="col-sm-5">
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4"> <?php
                echo $form->field($modelpaymentcondition, 'ar_ipd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                        'label' => 'จำกัดวงเงินรักษาผู้ป่วยใน',
                        'position' => CheckboxX::LABEL_RIGHT
                ]]);
                ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_ipd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_ipd_budgetlimit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99;text-align:right']); ?>
            </div>
            <div class="col-sm-5">
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4"> <?php
                echo $form->field($modelpaymentcondition, 'ar_year_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                        'label' => 'จำกัดวงเงินการรักษารายปี',
                        'position' => CheckboxX::LABEL_RIGHT
                ]]);
                ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_year_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_year_budgetlimit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99;text-align:right']); ?>
            </div>
            <div class="col-sm-5">
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
        </div>
    </div>
</div>
<?php
echo $form->field($modelpaymentcondition, 'ar_drug_ned_allowed', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
        'label' => 'จำกัดการใช้ยา NED',
        'position' => CheckboxX::LABEL_RIGHT
]]);
?>
<div class="form-group">
    <div class="col-sm-4"> <?php
echo $form->field($modelpaymentcondition, 'ar_drug_ned_limit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
        'label' => 'จำกัดวงเงินการใช้ยา NED',
        'position' => CheckboxX::LABEL_RIGHT
]]);
?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_drug_ned_limit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_drug_ned_limit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99;text-align:right']); ?> 
            </div>
            <div class="col-sm-5">
                <?php
                echo $form->field($modelpaymentcondition, 'ar_drug_ned_period')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\modules\AuthenticationandFinance\models\TbTimePeriod::find()->all(), 'ids', 'time_period'),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('บาท');
                ?>
            </div>

        </div>
    </div>
</div>
<hr>
<div style="text-align: right;margin-right: 10px">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
</div>
<?= $form->field($model, 'ar_id',['showLabels'=>false])->hiddenInput() ?>
<?= $form->field($modelpaymentcondition, 'ar_paymentcondition_id',['showLabels'=>false])->hiddenInput()?>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$script = <<< JS
        
$('#form_editright').on('beforeSubmit', function(e) 
{

 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
     var ar_id = $('#vwarlist-ar_id').val();
        swal("Save Complete!", "", "success");
        $('#modal_edit_right_payment').modal('hide'); 
       $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/viewpayment',
                    type: 'get',
                    data:{id:ar_id},
                    success: function (data) {
                        $('#payment_div').html(data);
                    }
                });
       
    }else
    {        
        l.ladda('stop');
        $("#message").html(result);
    }
}).fail(function() 
{
    console.log("server error");
});
return false;
});

JS;
$this->registerJs($script, $this::POS_READY);
?>