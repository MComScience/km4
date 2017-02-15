<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
?>
<div class="user-search">
    <div class="row">
        <div class="col-md-12">
            <div class="user-search">
                <?php
                $form = ActiveForm::begin([
                            'action' => [$action],
                            'method' => 'get',
                            'options' => ['data-pjax' => true]
                ]);
                ?>
                <div class="form-group">
                    <div class="col-sm-2">
                        <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                    </div>
                    <div class="col-sm-3">
                        <?=
                        $form->field($model, 'StkID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                            'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\Tbstk::find()->all(), 'StkID', 'StkName'),
                            'pluginOptions' => [
                                'placeholder' => 'คลังยา',
                                'allowClear' => true,
                            ],
                        ])
                        ?>
                    </div>
                
                    <div class="col-sm-3">
                        
                        <?php
                        echo CheckboxX::widget([
                            'name' => 'ItemQtyBalance',
                            'options' => ['id' => 'ItemQtyBalance'],
                            'pluginOptions' => ['threeState' => false]
                        ]);
                        ?>
                        <label class="cbx-label" for="s_1">แสดงเฉพาะยอดคงคลังเท่ากับศูนย์</label>
                    </div>
                       <div class="col-sm-3">
                        <?php
                        echo CheckboxX::widget([
                            'name' => 'ItemROPDiff',
                            'options' => ['id' => 'ItemROPDiff'],
                            'pluginOptions' => ['threeState' => false]
                        ]);
                        ?>
                           <label class="cbx-label" for="s_1">แสดงเฉพาะต่ำกว่าจุดสั่งชื้อ</label>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div> 

