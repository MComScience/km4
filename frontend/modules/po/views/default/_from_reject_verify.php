<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use app\modules\pr\models\TbPotype;
use kartik\widgets\Select2;
use kartik\icons\Icon;
use app\modules\pr\models\TbPrtype;
use frontend\assets\DataTableAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;

DataTableAsset::register($this);
SweetAlertAsset::register($this);
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);

$this->title = $model->getTitle($model['POStatus'], Yii::$app->controller->action->id);
$this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['/po/default/reject-verify']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption"><h5>
                        <?= Html::encode(empty($model->potype->POType) ? 'ใบสั่งซื้อ' : 'ใบสั่งซื้อ' . $model->potype->POType) ?>
                    </h5></span>
                <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand pink"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus blue"></i>
                    </a>
                </div><!--Widget Buttons-->
            </div><!--Widget Header-->
            <div class="widget-body">
                <div class="tb-po2-temp-form">

                    <?php
                    $form = ActiveForm::begin([
                                'type' => ActiveForm::TYPE_HORIZONTAL,
                                'formConfig' => [
                                    'labelSpan' => 4,
                                    'columns' => 6,
                                    'deviceSize' => ActiveForm::SIZE_SMALL,
                                ],
                                'id' => 'formporeject',
                    ]);
                    ?>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <?=
                            $form->field($model, 'PONum')->textInput([
                                'readonly' => true,
                                'style' => 'background-color: white',
                                'value' => empty($model['PONum']) ? 'Draft' : $model['PONum'],
                            ])->label('เลขที่ใบสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right']);
                            ?>

                            <?=
                            $form->field($model, 'PODate', [
                                'addon' => [
                                    'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                                ],
                            ])->widget(DatePicker::classname(), [
                                'language' => 'th',
                                'dateFormat' => 'dd/MM/yyyy',
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'style' => 'background-color: #ffff99',
                                    'required' => true,
                                ],
                            ])->label('วันที่' . '<font color="red"> *</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'POTypeID')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbPotype::find()->all(), 'POTypeID', 'POType'),
                                'language' => 'en',
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'disabled' => true,
                                ],
                            ])->label('ประเภทการสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($modelPR, 'PRTypeID')->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbPrtype::find()->all(), 'PRTypeID', 'PRType'),
                                'language' => 'th',
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'disabled' => true
                                ],
                            ])->label('ประเภทใบขอซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'POID', ['showLabels' => false])->hiddenInput([
                                'style' => 'background-color: white',
                            ])
                            ?>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <?=
                            $form->field($modelPR, 'PRNum')->textInput([
                                'readonly' => true,
                                'style' => 'background-color: white',
                            ])->label('เลขที่ใบขอซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($modelPR, 'PRDate')->widget(DatePicker::classname(), [
                                'language' => 'th',
                                'dateFormat' => 'dd/MM/yyyy',
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'style' => 'background-color: white',
                                    'disabled' => true,
                                ],
                            ])->label('วันที่ขอซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'VendorID', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('เลือก', ['get-vendor', 'type' => 1, 'action' => 'reject'], ['class' => 'btn btn-default', 'role' => 'modal-remote',]),
                                        'asButton' => true
                                    ]
                                ],
                            ])->textInput([
                                'style' => 'background-color: #ffff99',
                                'placeholder' => 'คลิกเพื่อเลือกผู้จำหน่าย...',
                                'required' => true,
                            ])->label('เลขที่ผู้จำหน่าย' . '<font color="red"> *</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'VendorName')->textInput([
                                'readonly' => true,
                                'style' => 'background-color: white',
                            ])->label('ชื่อผู้จำหน่าย', ['class' => 'col-sm-4 control-label no-padding-right']);
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <?=
                            $form->field($model, 'POContID')->textInput([
                                'style' => 'background-color: #ffff99',
                                    //'required' => true,
                            ])->label('เลขที่สัญญาซื้อขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'PODueDate')->widget(DatePicker::classname(), [
                                'language' => 'th',
                                'dateFormat' => 'dd/MM/yyyy',
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'style' => 'background-color: #ffff99',
                                    'required' => true,
                                ],
                            ])->label('กำหนดการส่งมอบ' . '<font color="red"> *</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'Menu_VendorID', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('เลือก', ['get-vendor', 'type' => 2, 'action' => 'reject'], ['class' => 'btn btn-default', 'role' => 'modal-remote',]),
                                        'asButton' => true
                                    ]
                                ],
                            ])->textInput([
                                'style' => 'background-color: #ffff99',
                                'placeholder' => 'คลิกเพื่อเลือกผู้ผลิต...',
                                'required' => true,
                            ])->label('ผู้ผลิต' . '<font color="red"> *</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                            ?>

                            <?=
                            $form->field($model, 'MenuVendorName')->textInput([
                                'readonly' => true,
                                'style' => 'background-color: white',
                            ])->label('ชื่อผู้ผลิต', ['class' => 'col-sm-4 control-label no-padding-right']);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <?php echo $this->render('grid_details', ['dataProvider1' => $dataProvider1, 'dataProvider2' => $dataProvider2, 'modelPR' => $modelPR]); ?>
                        </div>
                    </div>

                    <div class="form-group" style="text-align: right;">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <?= Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['reject-verify'], ['class' => 'btn btn-default']) ?>
                            <?php if (Yii::$app->controller->action->id == 'reject') : ?>
                                <?= Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . 'Savedraft' : Icon::show('floppy-disk', [], Icon::BSG) . 'Savedraft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'slide-down']) ?>
                                <?= Html::a(Icon::show('share-alt', [], Icon::BSG) . 'Save & Send To Verify', false, ['class' => 'btn btn-primary btn-sendtoverify', 'disabled' => true]) ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>
</div>
<?php echo $this->render('script'); ?>
<?php echo $this->render('modal'); ?>