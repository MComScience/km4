<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2TempSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-5">
        <div class="tb-st2-temp-search">

            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    <?= Html::a('บันทึกใบให้ยืมสินค้า', ['create-lend'], ['class' => 'btn btn-success']) ?>
                </span>
                 </div>
                <?php ActiveForm::end(); ?>
         </div>
    </div> 
</div>
