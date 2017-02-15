<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TbprSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => [$action],
                        'method' => 'post',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="form-group">
                <div class="col-sm-3">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...','style' => 'background-color: White']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div> 
</div>

