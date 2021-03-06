<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="user-search">
    <div class="row">
        <div class="col-md-4">
        
                <?php
                $form = ActiveForm::begin([
                            'action' => [$type],
                            'method' => 'get',
                            'options' => ['data-pjax' => true]
                ]);
                ?>
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    </span>
                </div>
                <?php ActiveForm::end(); ?>
            
        </div>
    </div>
</div> 

