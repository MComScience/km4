<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\std\TbStdTrpChemoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-std-trp-chemo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'std_trp_chemo_id') ?>

    <?= $form->field($model, 'std_trp_regimen_name') ?>

    <?= $form->field($model, 'medical_right_id') ?>

    <?= $form->field($model, 'credit_group_id') ?>

    <?= $form->field($model, 'std_trp_regimen_id') ?>

    <?php // echo $form->field($model, 'std_trp_credit_id') ?>

    <?php // echo $form->field($model, 'std_trp_regimen_paycode') ?>

    <?php // echo $form->field($model, 'std_trp_comment') ?>

    <?php // echo $form->field($model, 'std_trp_regimen_createby') ?>

    <?php // echo $form->field($model, 'std_trp_regimen_date') ?>

    <?php // echo $form->field($model, 'std_trp_regimen_status') ?>

    <?php // echo $form->field($model, 'dx_code') ?>

    <?php // echo $form->field($model, 'ca_stage_code') ?>

    <?php // echo $form->field($model, 'regimen_for_cr') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
