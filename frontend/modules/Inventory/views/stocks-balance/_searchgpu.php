<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TbprSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-4">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'action' => ['detailgpu'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>

                </span>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div> 
</div>

