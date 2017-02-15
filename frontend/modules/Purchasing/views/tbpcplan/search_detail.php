<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-3">
        <div class="user-search">

            <?php
            $form = ActiveForm::begin([
                        'action' => ['wailt-approve'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
           
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
          
            <?php ActiveForm::end(); ?>

        </div> 
    </div>

</div>
