<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
#models
use app\modules\pharmacy\models\TbCpoePeriodUnit;
?>
<?php

$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'action' => Url::to(['save-orderset']),
            'method' => 'post',
            'id' => 'form_drugset_header',
        ]);
?>
<div class="form-group">
    <?= Html::activeLabel($modelDrugset, 'drugset_id', ['label' => 'Regimen ID', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'drugset_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>
    
    <?= Html::activeLabel($modelDrugset, 'chemo_cycle_seq', ['label' => 'Cycle', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'chemo_cycle_seq', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;']); ?>
    </div>
    
    <?= Html::activeLabel($modelDrugset, 'chemo_cycle_day', ['label' => 'Day', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'chemo_cycle_day', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;']); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($modelChemo, 'pt_trp_regimen_name', ['label' => 'Regimen Name', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelChemo, 'pt_trp_regimen_name', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>
    
    <?= Html::activeLabel($modelDrugset, 'chemo_regimen_freq_value', ['label' => 'Frequency', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'chemo_regimen_freq_value', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;']); ?>
    </div>
    
    <?= Html::activeLabel($modelDrugset, 'chemo_regimen_freq_unit', ['label' => 'หน่วย', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?=
        $form->field($modelDrugset, 'chemo_regimen_freq_unit', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbCpoePeriodUnit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
            'pluginOptions' => ['allowClear' => true],
            'options' => ['placeholder' => 'Select state...']
        ]);
        ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($modelChemo, 'pt_trp_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-5">
        <?= $form->field($modelChemo, 'pt_trp_comment', ['showLabels' => false])->textarea(['rows' => 2,'style' => 'background-color: #ffff99;']); ?>
    </div>
</div>

<?= $form->field($modelChemo, 'pt_visit_number', ['showLabels' => false])->hiddenInput(); ?>
<?= $form->field($modelDrugset, 'drugset_status', ['showLabels' => false])->hiddenInput(); ?>
<?= $form->field($modelChemo, 'pt_trp_chemo_id', ['showLabels' => false])->hiddenInput(); ?>
<?php ActiveForm::end(); ?>
