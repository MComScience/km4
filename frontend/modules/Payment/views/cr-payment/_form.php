<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiInvCrList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-fi-inv-cr-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'inv_id')->textInput() ?>

    <?= $form->field($model, 'inv_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'invdate')->textInput() ?>

    <?= $form->field($model, 'pt_hospital_number')->textInput() ?>

    <?= $form->field($model, 'VN:AN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inv_Amt_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pt_ar_id')->textInput() ?>

    <?= $form->field($model, 'medical_right_group')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'medical_right_desc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ar_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cpoe_status')->textInput() ?>

    <?= $form->field($model, 'cr_summary_id')->textInput() ?>

    <?= $form->field($model, 'cr_summary_section')->textInput() ?>

    <?= $form->field($model, 'cr_summary_date')->textInput() ?>

    <?= $form->field($model, 'cr_summary_remark')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
