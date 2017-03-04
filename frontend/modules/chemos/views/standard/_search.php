<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'post',
                        'options' => ['data-pjax' => true],
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>
                <span class="input-group-btn">
                    <button class="btn btn-default" id="you_button_id" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    <?= Html::a('New Standard Regimen', ['new-regimen'], ['role' => 'modal-remote', 'class' => 'btn btn-warning', 'data-toggle' => 'tooltip', 'title' => 'New Regimen']) ?>
                </span>
                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div> 
</div>

