<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwStkrefillStatus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-stkrefill-status-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'StkID')->textInput() ?>

    <?= $form->field($model, 'StkName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ItemID')->textInput() ?>

    <?= $form->field($model, 'ItemNDMedSupply')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ItemName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DispUnit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ItemQtyBalance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ItemTargetLevel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'target_stk_diff')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
