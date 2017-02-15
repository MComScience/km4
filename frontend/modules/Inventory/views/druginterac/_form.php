<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\Tbdruginteraction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbdruginteraction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Drug1')->textInput() ?>

    <?= $form->field($model, 'Drug2')->textInput() ?>

    <?= $form->field($model, 'ItemStatus')->textInput() ?>

    <?= $form->field($model, 'CreateBy')->textInput() ?>

    <?= $form->field($model, 'CreateDate')->textInput() ?>

    <?= $form->field($model, 'DDI_Effect_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
