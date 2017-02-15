<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pharmacy\models\TbPtTrpChemo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-pt-trp-chemo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pt_trp_regimen_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_hospital_number')->textInput() ?>

    <?= $form->field($model, 'medical_right_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'credit_group_id')->textInput() ?>

    <?= $form->field($model, 'pt_trp_regimen_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_trp_credit_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_trp_regimen_paycode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_trp_cpr_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_trp_ocpa_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_trp_regimen_status')->textInput() ?>

    <?= $form->field($model, 'pt_trp_regimen_createby')->textInput() ?>

    <?= $form->field($model, 'pt_trp_comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_visit_number')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
