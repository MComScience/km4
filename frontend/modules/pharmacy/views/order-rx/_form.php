<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\pharmacy\models\VwUserprofile;
?>

<div class="tb-cpoe-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-header-cpoe']); ?>

    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_num', ['label' => 'ใบสั่งยาเลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'cpoe_num', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'วันที่', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
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

        <?= Html::activeLabel($model, 'cpoe_order_by', ['label' => 'แพทย์', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-3">
            <?=
            $form->field($model, 'cpoe_order_by', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(VwUserprofile::find()->select(['user_id', 'User_name'])->where(['User_position' => '6'])->all(), 'user_id', 'User_name'),
                'pluginOptions' => ['allowClear' => true],
                'options' => ['placeholder' => 'เลือกแพทย์...',]
            ]);
            ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_comment', ['showLabels' => false])->hiddenInput() ?>
            
        </div>
    </div>
    <?php if ($model['cpoe_type'] == '1012') : ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'pt_trp_regimen_paycode', ['label' => 'รหัสเบิกจ่าย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?=
                $form->field($model, 'pt_trp_regimen_paycode', [
                    'showLabels' => false,
                    'addon' => [
                        'append' => [
                            'content' => Html::a('Select', ['select-protocol'], ['class' => 'btn btn-default protocal', 'role' => 'modal-remote']),
                            'asButton' => true
                        ]
                    ]
                ])->textInput([]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'chemo_cycle_seq', ['label' => 'Cycle', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'chemo_cycle_seq', ['showLabels' => false])->textInput([]); ?>
            </div>

            <?= Html::activeLabel($model, 'chemo_cycle_day', ['label' => 'Day', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'chemo_cycle_day', ['showLabels' => false])->textInput([]); ?>
            </div>

            <div class="col-sm-1">
                
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'pt_trp_regimen_name', ['label' => 'Regimen', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'pt_trp_regimen_name', ['showLabels' => false])->textInput([]); ?>
            </div>


            <?= Html::activeLabel($model, 'pt_cpr_number', ['label' => 'CPR', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'pt_cpr_number', ['showLabels' => false])->textInput([]); ?>
            </div>

            <?= Html::activeLabel($model, 'pt_ocpa_number', ['label' => 'OCPA', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'pt_ocpa_number', ['showLabels' => false])->textInput([]); ?>
            </div>
        </div>
    <?php endif; ?>


    <div class="form-group">
        <div class="col-sm-12">
            <?= $form->field($model, 'pt_vn_number', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_type', ['showLabels' => false])->hiddenInput() ?>
            <?php // Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])  ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>