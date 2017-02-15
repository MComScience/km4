<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use app\modules\pr\models\TbDepartment;
use kartik\icons\Icon;
use frontend\assets\WaitMeAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use app\modules\pr\models\TbPcplan;

WaitMeAsset::register($this);
DataTableAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);

$this->title = Yii::t('app', '{modelClass} ', [
            'modelClass' => 'ใบขอซื้อยาการค้าจะซื้อจะขาย ไม่ผ่านการทวนสอบ',
        ]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchasing'), 'url' => ['/pr/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ขอซื้อรายการบัญชี รพ.'), 'url' => ['/pr/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.dataTable th{
        white-space: nowrap;
        background-color: white;
    }
    tr.kv-page-summary{
        background-color: #f5f5f5;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header">
                <span class="widget-caption"><h5><?= Html::encode($this->title) ?></h5></span>
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

                <div class="tb-pr2-temp-form">

                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-verify']); ?>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PRNum', ['label' => 'เลขที่ใบขอซื้อ', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PRNum', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                /* 'readonly' => true, */
                                'style' => 'background-color:#ffff99',
                                'value' => empty($model['PRNum']) ? 'Draft' : $model['PRNum'],
                            ])
                            ?>
                        </div>

                        <?= Html::activeLabel($model, 'DepartmentID', ['label' => 'ฝ่าย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'DepartmentID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'),
                                'language' => 'en',
                                'options' => ['placeholder' => '----- เลือกฝ่าย -----'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group" >
                        <?= Html::activeLabel($model, 'PRDate', ['label' => 'วันที่' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PRDate', [
                                'showLabels' => false,
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
                                ],
                            ]);
                            ?>
                        </div>

                        <?= Html::activeLabel($model, 'SectionID', ['label' => 'แผนก' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'SectionID', ['showLabels' => false])->widget(DepDrop::classname(), [
                                'data' => [$section],
                                'options' => ['placeholder' => 'เลือกแผนก ...'],
                                'type' => DepDrop::TYPE_SELECT2,
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['tbpr2-departmentid'],
                                    'url' => Url::to(['child-department']),
                                    'loadingText' => 'Loading...',
                                ]
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PRTypeID', ['label' => 'ประเภทใบขอซื้อ', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3"> 
                            <?php
                            echo $form->field($model, 'PRTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ['4' => 'ขอซื้อสัญญาจะซื้อจะขายยา']/* ArrayHelper::map(TbPrtype::find()->where(['PRTypeID' => '1'])->all(), 'PRTypeID', 'PRType') */,
                                'language' => 'en',
                                'options' => ['placeholder' => '----- ประเภทใบขอซื้อ -----', 'disabled' => true],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>
                        </div>

                        <?= Html::activeLabel($model, 'POTypeID', ['label' => 'ประเภทการสั่งซื้อ' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'POTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ['3' => 'สั่งซื้อตามสัญญาจะซื้อจะขาย']/* ArrayHelper::map(TbPotype::find()->where(['POTypeID' => [1, 2]])->all(), 'POTypeID', 'POType') */,
                                'language' => 'en',
                                'options' => ['placeholder' => '----- ประเภทการสั่งซื้อ -----'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'POContactNum', ['label' => 'เลขที่สัญญาจะซื้อจะขาย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?=
                            $form->field($model, 'POContactNum', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbPcplan::find()->where(['PCPlanTypeID' => 5])->all(), 'PCPOContactID', 'PCPOContactID'),
                                'language' => 'en',
                                'options' => ['placeholder' => '----- เลขที่สัญญาจะซื้อจะขาย -----'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>
                        </div>

                        <?= Html::activeLabel($model, 'PRExpectDate', ['label' => 'กำหนดเวลาการส่งมอบ(วัน)' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'PRExpectDate', ['showLabels' => false])->input('number', ['min' => 0, 'style' => 'background-color:#ffff99', 'required' => true,]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'VendorName', ['label' => 'ชื่อผู้ขาย', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'VendorName', ['showLabels' => false])->widget(DepDrop::classname(), [
                                'data' => [$vendorname],
                                'options' => ['placeholder' => 'ชื่อผู้ขาย ...', 'disabled' => true,],
                                'type' => DepDrop::TYPE_SELECT2,
                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                'pluginOptions' => [
                                    'depends' => ['tbpr2temp-pocontactnum'],
                                    'url' => Url::to(['child-vendorname']),
                                    'loadingText' => 'Loading...',
                                    'placeholder' => 'ชื่อผู้ขาย...',
                                ]
                            ]);
                            ?>
                        </div>

                        <?= Html::activeLabel($model, 'PRStatusID', ['label' => 'สถานะใบขอซื้อ', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3"> 
                            <?php
                            echo $form->field($model, 'PRStatusID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ['4' => 'Rejected From Verify'],
                                'language' => 'en',
                                'options' => ['placeholder' => '----- สถานะใบขอซื้อ -----'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'disabled' => true,
                                ],
                            ])
                            ?>
                        </div>
                    </div>

                    <?php echo $this->render('grid_details', ['dataProvider' => $dataProvider, 'type' => $type]); ?>

                    <div class="form-group">
                        <?= Html::label('เหตุผลการขอซื้อ', 'reason', ['class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-8">
                            <?php echo $reason; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PRReasonNote', ['label' => 'อื่นๆ', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PRReasonNote', ['showLabels' => false])->textarea([
                                'rows' => 3,
                                'style' => 'background-color:#ffff99',
                            ])
                            ?>
                        </div>
                        <?= Html::activeLabel($model, 'PRRejectReason', ['label' => 'เหตุผลการ Reject', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PRRejectReason', ['showLabels' => false])->textarea([
                                'rows' => 3,
                                'style' => 'background-color:white',
                                'readonly' => true,
                            ])
                            ?>
                        </div>
                    </div>

                    <?= $form->field($model, 'PRID', ['showLabels' => false])->hiddenInput() ?>

                    <div class="form-group" style="text-align: right;">
                        <div class="col-sm-12">
                            <?= Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/pr/default/reject-verify'], ['class' => 'btn btn-default', 'title' => 'Close']); ?>
                            <?php if ($type == 'new' || $type == 'edit') : ?>
                                <?= Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . Yii::t('app', 'Save Draft') : Icon::show('floppy-disk', [], Icon::BSG) . Yii::t('app', 'Save Draft'), ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'slide-down', 'title' => Yii::t('app', 'Save Draft')]) ?>
                                <?= Html::button(Icon::show('share-alt', [], Icon::BSG) . 'Save and Send To Verify', ['class' => 'btn btn-primary sendtoverify', 'type' => 'button', 'disabled' => empty($model['PRNum']) ? true : false, 'title' => 'Save and Send To Verify']); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>

            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>
</div>

<?php echo $this->render('modal'); ?>

<?php echo $this->render('script', ['model' => $model]); ?>
