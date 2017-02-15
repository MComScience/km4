<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwQuPricelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-qu-pricelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ids_qu')->textInput() ?>

    <?= $form->field($model, 'VendorID')->textInput() ?>

    <?= $form->field($model, 'ItemCatID')->textInput() ?>

    <?= $form->field($model, 'ItemNDMedSupplyCatID')->textInput() ?>

    <?= $form->field($model, 'TMTID_TPU')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ItemName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itemContVal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itemContUnit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'itemDispUnit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUMQO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUPackQty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUPackCost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUOrderQty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUUnitCost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUValidDate')->textInput() ?>

    <?= $form->field($model, 'QULeadtime')->textInput() ?>

    <?= $form->field($model, 'QUQty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUUnit')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'QUUnitCost2')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
