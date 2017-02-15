<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-md-4">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'action' => ['create'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true],
                        'id' => 'your_form_id',
                        //'enableAjaxValidation' => true,
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" id="you_button_id" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>

                </span>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div> 
</div>

