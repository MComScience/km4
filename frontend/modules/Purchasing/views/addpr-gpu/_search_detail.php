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
                        'action' => [$action],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="form-group">
                <div class="col-sm-3">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color:white']) ?>
                </div>
                <?php if ($action == 'list-approve') { ?>
                <div class="col-sm-3">
                    <?=
                    $form->field($model, 'PRTypeID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(\app\models\TbPrtype::find()->all(), 'PRTypeID', 'PRType'),
                        'pluginOptions' => [
                            'placeholder' => 'ประเภทใบขอซื้อ',
                            'allowClear' => true,
                        ],
                    ])
                    ?>
                </div>

                
                    <div class="col-sm-3">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    </div>
                <?php } ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div> 
</div>

