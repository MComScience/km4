<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-fi-rep-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rep_id')->textInput() ?>

    <?= $form->field($model, 'inv_id')->textInput() ?>

    <?= $form->field($model, 'rep_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'repdate')->textInput() ?>

    <?= $form->field($model, 'pt_hospital_number')->textInput() ?>

    <?= $form->field($model, 'pt_visit_number')->textInput() ?>

    <?= $form->field($model, 'pt_admission_number')->textInput() ?>

    <?= $form->field($model, 'createby')->textInput() ?>

    <?= $form->field($model, 'rep_status')->textInput() ?>

    <?= $form->field($model, 'sum_cash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sum_creditcard')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sum_cheque')->textInput() ?>

    <?= $form->field($model, 'sum_banktransfer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_Amt_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_Amt_discount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_Amt_left')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_Amt_net')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_summary_id')->textInput() ?>

    <?= $form->field($model, 'rep_create_section')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
