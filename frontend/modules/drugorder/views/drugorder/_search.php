<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\drugorder\models\TbcpoeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbcpoe-search">

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

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
