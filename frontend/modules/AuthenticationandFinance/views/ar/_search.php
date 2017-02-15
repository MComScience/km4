<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\AuthenticationandFinance\models\VwArListSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-4">
        <div class="vw-ar-list-search">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
            ]);
            ?>
            <div class="form-inline">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> เพิ่มข้อมูล','#', ['class' => 'btn btn-success','id'=>'createar']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>


