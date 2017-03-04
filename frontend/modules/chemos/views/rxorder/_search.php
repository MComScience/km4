<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\TbCpoeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-cpoe-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'cpoe_id') ?>

    <?= $form->field($model, 'cpoe_schedule_type') ?>

    <?= $form->field($model, 'cpoe_type') ?>

    <?= $form->field($model, 'cpoe_num') ?>

    <?= $form->field($model, 'pt_vn_number') ?>

    <?php // echo $form->field($model, 'cpoe_date') ?>

    <?php // echo $form->field($model, 'cpoe_order_by') ?>

    <?php // echo $form->field($model, 'cpoe_order_section') ?>

    <?php // echo $form->field($model, 'cpoe_comment') ?>

    <?php // echo $form->field($model, 'cpoe_status') ?>

    <?php // echo $form->field($model, 'cpoe_createby') ?>

    <?php // echo $form->field($model, 'pt_trp_regimen_paycode') ?>

    <?php // echo $form->field($model, 'pt_trp_chemo_id') ?>

    <?php // echo $form->field($model, 'chemo_regimen_ids') ?>

    <?php // echo $form->field($model, 'chemo_cycle_seq') ?>

    <?php // echo $form->field($model, 'chemo_cycle_day') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
