<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\pr\models\TbDepartment;
use kartik\widgets\Select2;
use yii\jui\DatePicker;
use kartik\icons\Icon;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use app\modules\plan\models\TbPcplanstatus;
use yii\widgets\Pjax;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\DataTableAsset;

DataTableAsset::register($this);
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);

$action = Yii::$app->controller->action->id;
?>
<style type="text/css">
    table#datatable-tpu thead tr th{
        white-space: nowrap;
        background-color: white;
        border-top: 1px solid #ddd;
    }
    .ui-datepicker{ z-index:1151 !important;}
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="widget radius-bordered">
            <div class="widget-header">
                <span class="widget-caption"><?= Html::label($this->title) ?></span>
                <div class="widget-buttons">
                    <a href="#" data-toggle="maximize">
                        <i class="fa fa-expand"></i>
                    </a>
                    <a href="#" data-toggle="collapse">
                        <i class="fa fa-minus"></i>
                    </a>
                </div><!--Widget Buttons-->
            </div><!--Widget Header-->
            <div class="widget-body">
                <div class="tb-pcplan-form">
                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'fromheader']); ?>
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PCPlanNum', ['label' => 'เลขที่แผนจัดชื้อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'PCPlanNum', ['showLabels' => false])->textInput(['readonly' => true]); ?>
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

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PCPlanDate', ['label' => 'วันที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PCPlanDate', [
                                'showLabels' => false,
                                'addon' => [
                                    'prepend' => ['content' => Icon::show('calendar', [], Icon::BSG)],
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
                                    'depends' => ['tbpcplan-departmentid'],
                                    'url' => Url::to(['child-department']),
                                    'loadingText' => 'Loading...',
                                ]
                            ]);
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PCPlanTypeID', ['label' => 'ประเภทแผนจัดซื้อ' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PCPlanTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ['7' => 'แผนการจัดซื้อยาการค้า ประจำปี', '8' => 'แผนการจัดซื้อยาการค้า เฉพาะกาล'],
                                'language' => 'en',
                                'options' => ['placeholder' => '----- ประเภทแผนจัดซื้อ -----'],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>
                        </div>
                        <?= Html::activeLabel($model, 'PCPlanBeginDate', ['label' => 'วันที่เริ่มแผน' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PCPlanBeginDate', [
                                'showLabels' => false,
                                'addon' => [
                                    'prepend' => ['content' => Icon::show('calendar', [], Icon::BSG)],
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
                    </div>

                    <div class="form-group">
                        <?= Html::activeLabel($model, 'PCPlanStatusID', ['label' => 'สถานะ', 'class' => 'col-sm-2 control-label no-padding-right', 'style' => 'color:black;']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PCPlanStatusID', ['showLabels' => false])->widget(Select2::classname(), [
                                'data' => ArrayHelper::map(TbPcplanstatus::find()->all(), 'PCPlanStatusID', 'PCPlanStatus'),
                                'language' => 'en',
                                'options' => ['placeholder' => '----- สถานะ -----', 'disabled' => true],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])
                            ?>
                        </div>
                        <?= Html::activeLabel($model, 'PCPlanEndDate', ['label' => 'วันที่สิ้นสุดแผน' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                        <div class="col-sm-3">
                            <?php
                            echo $form->field($model, 'PCPlanEndDate', [
                                'showLabels' => false,
                                'addon' => [
                                    'prepend' => ['content' => Icon::show('calendar', [], Icon::BSG)],
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
                    </div>


                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">รายละเอียด</h5>
                                </div>
                                <div class="panel-body">
                                    <div id="tables-content"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="text-align: right;">
                        <div class="col-sm-12">
                            <?php if ($action == 'view') : ?>
                                <?= Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/plan/default/index'], ['class' => 'btn btn-default']); ?>
                            <?php endif; ?>
                            <?php if ($action == 'update') : ?>
                                <?= Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/plan/default/index'], ['class' => 'btn btn-default']); ?>
                                <?= Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . 'Save' : Icon::show('floppy-disk', [], Icon::BSG) . 'Save', ['class' => $model->isNewRecord ? 'btn btn-success save-button ladda-button' : 'btn btn-success save-button ladda-button', 'data-style' => 'slide-down']) ?>
                                <?= Html::button(Icon::show('share-alt', [], Icon::BSG) . 'Send To Approved', ['class' => 'btn btn-primary sendtoverify', 'type' => 'button', 'disabled' => true, 'title' => 'Send To Approve']); ?>
                            <?php endif; ?>
                            <?php if ($action == 'verify') : ?>
                                <?= Html::a(Icon::show('remove', [], Icon::BSG) . 'Close', ['/plan/default/waiting-verify'], ['class' => 'btn btn-default']); ?>
                                <?= Html::a(Icon::show('share-alt', [], Icon::BSG) . 'Approve', false, ['class' => 'btn btn-primary', 'onclick' => 'Approved(this);']); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div><!--Widget Body-->
        </div><!--Widget-->
    </div>
</div>
<?php
echo $this->render('modal');
?>
<?php
$this->registerJsFile(Yii::getAlias('@web') . '/js/plan/loadding.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
if ($action == 'update') {
    $this->registerJsFile(Yii::getAlias('@web') . '/js/plan/tpu/update.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
}

if ($action == 'view') {
    $this->registerJsFile(Yii::getAlias('@web') . '/js/plan/tpu/view-update.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
}

if ($action == 'verify') {
    $this->registerJsFile(Yii::getAlias('@web') . '/js/plan/tpu/verify.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
}
?>