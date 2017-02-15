<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-6">
        <div class="user-search">

            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> บันทึกสัญญาจะชื้อจะขายยา', ['create-plan-gpu-header'], ['class' => 'btn btn-success']) ?>
                </span>
            </div>
            <?php ActiveForm::end(); ?>

        </div> 
    </div>

</div>
