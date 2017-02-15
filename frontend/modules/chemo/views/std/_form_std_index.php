<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemo\models\std\TbMedicalRigth;
?>
<div class="well">


    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
    ]);
    ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'std_trp_chemo_id', ['label' => 'เลขที่', 'class' => 'col-sm-2 control-label no-padding-right success']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'std_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true,'style' => 'background-color: #ddd']); ?>
        </div>

        <?= Html::activeLabel($model, 'medical_right_id', ['label' => 'สิทธิ์การรักษา', 'class' => 'col-sm-1 control-label no-padding-right success']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'medical_right_id', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TbMedicalRigth::find()->all(), 'medical_right_id', 'medical_right_desc'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select Option',],
                'pluginOptions' => [
                    'allowClear' => true,
                    'disabled' => true
                ],
            ])
            ?>
        </div>

        <?= Html::activeLabel($model, 'dx_code', ['label' => 'Dx.', 'class' => 'col-sm-1 control-label no-padding-right success']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'dx_code', ['showLabels' => false])->textInput(['readonly' => true,'style' => 'background-color: #ddd']); ?>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::activeLabel($model, 'std_trp_regimen_name', ['label' => 'Regimen', 'class' => 'col-sm-2 control-label no-padding-right success']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'std_trp_regimen_name', ['showLabels' => false])->textInput(['readonly' => true,'style' => 'background-color: #ddd']); ?>
        </div>
        
        <?= Html::activeLabel($model, 'std_trp_regimen_paycode', ['label' => 'Payment Code', 'class' => 'col-sm-1 control-label no-padding-right success']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'std_trp_regimen_paycode', ['showLabels' => false])->textInput(['readonly' => true,'style' => 'background-color: #ddd']); ?>
        </div>
        
        <?= Html::activeLabel($model, 'ca_stage_code', ['label' => 'Stage', 'class' => 'col-sm-1 control-label no-padding-right success']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'ca_stage_code', ['showLabels' => false])->textInput(['readonly' => true,'style' => 'background-color: #ddd']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>