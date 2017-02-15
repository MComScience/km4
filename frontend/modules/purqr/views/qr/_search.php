<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\purqr\models\tbqr2Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbqr2-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'QRID') ?>

    <?= $form->field($model, 'QRNum') ?>

    <?= $form->field($model, 'QRDate') ?>

    <?= $form->field($model, 'POTypeID') ?>

    <?= $form->field($model, 'QRExpectDate') ?>

    <?php // echo $form->field($model, 'QRcreateby') ?>

    <?php // echo $form->field($model, 'QRStatus') ?>

    <?php // echo $form->field($model, 'QRsenddate') ?>

    <?php // echo $form->field($model, 'QRmassage') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
