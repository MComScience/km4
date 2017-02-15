<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\icons\Icon;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 <?= $action == 'index' ? 'col-md-4' : 'col-md-4' ?>">
        <div class="tb-pr-search">
            <?php
            $form = ActiveForm::begin([
                        'action' => [$action],
                        'method' => 'post',
                        'options' => ['data-pjax' => true],
            ]);
            ?>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>
                <span class="input-group-btn">
                    <?= Html::submitButton(Icon::show('search', [], Icon::BSG) . Yii::t('app', 'Search'), ['class' => 'btn btn-success']); ?>
                </span>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div> 
</div>

