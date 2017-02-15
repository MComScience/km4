<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="user-search">
    <div class="row">
        <div class="col-md-8">
            <div class="form-inline">
                <?php
                $form = ActiveForm::begin([
                            'action' => [$type],
                            'method' => 'get',
                            'options' => ['data-pjax' => true]
                ]);
                ?>

                <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div> 

