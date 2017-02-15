<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\controllers\VwStkrefillStatusSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4"  style="margin-left: -14px;">
    <?php
        $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'action' => ['index'],
            'method' => 'get',
            'options' => ['data-pjax' => true]
                ]);
        ?>
        <div class="input-group" >
            <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                <span class="input-group-btn ">
                    <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                </span>
        </div>
    <?php ActiveForm::end(); ?>
</div>

