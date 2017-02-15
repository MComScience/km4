<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\pharmacy\models\VwUserprofile;
use app\modules\pharmacy\models\TbSection;
?>

<div class="tb-cpoe-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL,'id' => 'form-header-cpoe']); ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_num', ['label' => 'ใบสั่งยาเลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'cpoe_num', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'pt_trp_chemo_id', ['label' => 'Treatment Plan No:', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'pt_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'chemo_cycle_seq', ['label' => 'Cycle:', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_cycle_seq', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'วันที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'cpoe_date', ['showLabels' => false])->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'class' => 'form-control',
                    //'disabled' => true,
                ],
            ])
            ?>  
        </div>

        <?= Html::activeLabel($modelChemo, 'pt_trp_regimen_name', ['label' => 'Regimen:', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($modelChemo, 'pt_trp_regimen_name', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'chemo_cycle_day', ['label' => 'Day:', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_cycle_day', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'cpoe_comment', ['showLabels' => false])->textarea(['rows' => 2]); ?>
        </div>
        
        <?= Html::activeLabel($model, 'cpoe_order_section', ['label' => 'แผนก'.'<span class="red">*</span>', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'cpoe_order_section', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TbSection::find()->all(), 'SectionID', 'SectionDecs'),
                'pluginOptions' => ['allowClear' => true],
                'options' => ['placeholder' => 'Select state...',]
            ]);
            ?>
        </div>

        <?= Html::activeLabel($model, 'cpoe_order_by', ['label' => 'แพทย์'.'<span class="red">*</span>', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'cpoe_order_by', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(VwUserprofile::find()->where(['User_jobid' => '3'])->all(), 'user_id', 'User_name'),
                'pluginOptions' => ['allowClear' => true],
                'options' => ['placeholder' => 'Select state...',]
            ]);
            ?>
        </div>
    </div>
    
    <?= $form->field($model, 'pt_vn_number', ['showLabels' => false])->hiddenInput(); ?>
    <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput(); ?>

    <?php ActiveForm::end(); ?>

</div>
