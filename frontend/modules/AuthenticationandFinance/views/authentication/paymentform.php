<?php

use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;
use yii\jui\DatePicker;
?>
<div id="payment_div" style="margin:10px">
<div class="form-group">
    <div class="col-sm-4"> <?php
    $form2 = ActiveForm::begin(); 
        echo $form2->field($modelpaymentcondition, 'ar_opd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการรักษาผู้ป่วยนอก',
                'position' => CheckboxX::LABEL_RIGHT,
            ],
            'disabled' => true
        ]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_opd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_opd_budgetlimit_amt; ?></label>
                <label class="control-label">บาท</label>
            </div>
            <div class="col-sm-5">

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form2->field($modelpaymentcondition, 'ar_ipd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินรักษาผู้ป่วยใน',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'disabled' => true]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_ipd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_ipd_budgetlimit_amt; ?></label>
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
            <div class="col-sm-5">

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form2->field($modelpaymentcondition, 'ar_year_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการรักษารายปี',
                'position' => CheckboxX::LABEL_RIGHT,
            ],
            'disabled' => true]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_year_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_year_budgetlimit_amt; ?></label>
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
            <div class="col-sm-5">

            </div>
        </div>
    </div>
</div>
<?php
echo $form2->field($modelpaymentcondition, 'ar_drug_ned_allowed', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
        'label' => 'จำกัดการใช้ยา NED',
        'position' => CheckboxX::LABEL_RIGHT
    ],
    'disabled' => true]);
?>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form2->field($modelpaymentcondition, 'ar_drug_ned_limit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการใช้ยา NED',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'disabled' => true]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_drug_ned_limit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_drug_ned_limit_amt; ?></label>
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
            <div class="col-sm-5">
                <?php
                echo $form2->field($modelpaymentcondition, 'ar_drug_ned_period')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\modules\AuthenticationandFinance\models\TbTimePeriod::find()->all(), 'ids', 'time_period'),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'disabled' => true
                    ],
                ])->label('');
                ?>
            </div>

        </div>
    </div>
</div>
</div>