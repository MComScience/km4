<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pharmacy\models\TbPtTrpChemoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-pt-trp-chemo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pt_trp_chemo_id') ?>

    <?= $form->field($model, 'pt_trp_regimen_name') ?>

    <?= $form->field($model, 'pt_hospital_number') ?>

    <?= $form->field($model, 'medical_right_id') ?>

    <?= $form->field($model, 'credit_group_id') ?>

    <?php // echo $form->field($model, 'pt_trp_regimen_id') ?>

    <?php // echo $form->field($model, 'pt_trp_credit_id') ?>

    <?php // echo $form->field($model, 'pt_trp_regimen_paycode') ?>

    <?php // echo $form->field($model, 'pt_trp_cpr_number') ?>

    <?php // echo $form->field($model, 'pt_trp_ocpa_number') ?>

    <?php // echo $form->field($model, 'pt_trp_regimen_status') ?>

    <?php // echo $form->field($model, 'pt_trp_regimen_createby') ?>

    <?php // echo $form->field($model, 'pt_trp_comment') ?>

    <?php // echo $form->field($model, 'pt_visit_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
