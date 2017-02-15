<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\modules\AuthenticationandFinance\models\VwArList */

$this->title = $model->ar_id;
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียดสิทธิ์', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-ar-list-view">
<?php Pjax::begin(['id' => 'form_editright']); ?>
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_main']); ?> 
    <label style="font-size: 16pt" >รายละเอียดสิทธิ์</label><br>
    <label><b>กลุ่มของสิทธิ์</b> </label> <label> <?php echo $ar->medical_right_group ?></label> <label ><b>ประเภทของสิทธิ์</b></label> <label><?php echo $ar->medical_right_desc ?></label><br>

    <label  ><b>ชื่อหน่วยงานต้นสิทธิ์</b> </label> <label> <?php echo $ar->ar_name ?></label><br><br>
    <label style="font-size:150%;" class="control-label">เงื่อนไขการใช้สิทธิ์</label><div style="text-align: right"><a class="btn btn-success" href="javascript:editright(<?php echo $ar->ar_id ?>)">Edit</a></div>
    <div class="form-group">
        <div class="col-sm-4"> <?php
            echo $form->field($payment, 'ar_opd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                    'label' => 'จำกัดวงเงินการรักษาผู้ป่วยนอก',
                    'position' => CheckboxX::LABEL_RIGHT,
                ],
                'disabled' => true
            ]);
            ?></div>
        <div class="col-sm-7">
            <div class="form-group">
                <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($payment, 'ar_opd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
                <div class="col-sm-4">
                    <label class="control-label"><?php echo $payment->ar_opd_budgetlimit_amt; ?></label>
                    <label class="control-label">บาท</label>
                </div>
                <div class="col-sm-5">

                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-4"> <?php
            echo $form->field($payment, 'ar_ipd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                    'label' => 'จำกัดวงเงินรักษาผู้ป่วยใน',
                    'position' => CheckboxX::LABEL_RIGHT
                ],
                'disabled' => true]);
            ?></div>
        <div class="col-sm-7">
            <div class="form-group">
                <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($payment, 'ar_ipd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
                <div class="col-sm-4">
                    <label class="control-label"><?php echo $payment->ar_ipd_budgetlimit_amt; ?></label>
                    <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
                </div>
                <div class="col-sm-5">

                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4"> <?php
            echo $form->field($payment, 'ar_year_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                    'label' => 'จำกัดวงเงินการรักษารายปี',
                    'position' => CheckboxX::LABEL_RIGHT,
                ],
                'disabled' => true]);
            ?></div>
        <div class="col-sm-7">
            <div class="form-group">
                <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($payment, 'ar_year_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
                <div class="col-sm-4">
                    <label class="control-label"><?php echo $payment->ar_year_budgetlimit_amt; ?></label>
                    <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
                </div>
                <div class="col-sm-5">

                </div>
            </div>
        </div>
    </div>
    <?php
    echo $form->field($payment, 'ar_drug_ned_allowed', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
            'label' => 'จำกัดการใช้ยา NED',
            'position' => CheckboxX::LABEL_RIGHT
        ],
        'disabled' => true]);
    ?>
    <div class="form-group">
        <div class="col-sm-4"> <?php
            echo $form->field($payment, 'ar_drug_ned_limit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                    'label' => 'จำกัดวงเงินการใช้ยา NED',
                    'position' => CheckboxX::LABEL_RIGHT
                ],
                'disabled' => true]);
            ?></div>
        <div class="col-sm-7">
            <div class="form-group">
                <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($payment, 'ar_drug_ned_limit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
                <div class="col-sm-4">
                    <label class="control-label"><?php echo $payment->ar_drug_ned_limit_amt; ?></label>
                    <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
                </div>
                <div class="col-sm-5">
                    <?php
                    echo $form->field($payment, 'ar_drug_ned_period')->widget(Select2::classname(), [
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
<hr>
<div style="text-align: right;margin-right: 10px">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
