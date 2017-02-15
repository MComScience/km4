<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="tb-pr-search">
            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => ['list-drugnew'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="form-group">
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'StkID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\Tbstk::find()->all(), 'StkID', 'StkName'),
                        'pluginOptions' => [
                            'placeholder' => 'เลือกคลัง',
                            'allowClear' => true,
                        ],
                    ])
                    ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div> 
</div>

