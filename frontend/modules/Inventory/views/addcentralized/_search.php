<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-4">
        <div class="druggroup-search">

            <?php
            $form = ActiveForm::begin([
                        'action' => [$action],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...','style' => 'background-color: white',]) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    <?php if($action == 'index') { ?>
                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app', 'เพิ่มรายการสินค้า'), ['create-itemnew'], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                    
                    <?php if($action != 'pricelistnondrug') { ?>
                    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('app', 'เพิ่มข้อมูล'), ['create-itemnew'], ['class' => 'btn btn-success']) ?>
                    <?php } ?>
                </span>
            </div>
            <?php ActiveForm::end(); ?>

        </div>   
    </div>   
</div>
<br>