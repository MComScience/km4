<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TbprSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => ['index'],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <div class="form-group">
                <div class="col-sm-3">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
<!--                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                </span>-->
                </div>
                <div class="col-sm-3">
                    <?php /*
                    <?=
                    $form->field($model, 'ItemCat', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\TbItemcatid::find()->orderBy('ItemCat')->asArray()->all(), 'ItemCatID', 'ItemCat'),
                        'pluginOptions' => [
                            'placeholder' => 'ประเภทสินค้า',
                            'allowClear' => true,
                        //'prompt' => 'Select ...',
                        //'multiple' => true
                        ],
                    ])
                    ?>
                     * 
                     */?>
                </div>
                <?php /*
                <div class="col-sm-3">
                    <?= Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>0, 'class'=>'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')]).' '.
                    Html::submitButton('<i class="glyphicon glyphicon-search"></i>' . 'ค้นหา', ['class' => 'btn btn-success'])?>
                </div>
                 * 
                 */?>
            </div>
            <div class="form-group">

            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div> 
</div>

