<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-search">
    <div class="row">
        <div class="col-md-3">
<?php
$form = ActiveForm::begin([
            'action' => [$type],
            'method' => 'get',
            'options' => ['data-pjax' => true]
        ]);
?>

                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...','style' => 'background-color: white']) ?>
                <?php ActiveForm::end(); ?>
            </div>
    </div>
</div> 

