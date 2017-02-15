<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbDrugclass;
use app\modules\Inventory\models\TbDrugsubclass;
use app\modules\Inventory\models\TbIsed;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
DataTableAsset::register($this);

$this->title = 'ยาการค้า';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'จัดการราคาสินค้า', 'url' => ['pricelist']];
$this->params['breadcrumbs'][] = $this->title;


$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
{custom}
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$TbDrugclass = ArrayHelper::map(TbDrugclass::find()->all(), 'DrugClassID', 'DrugClass');
?>
<style>
    table.kv-grid-table th{
        background-color: white;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('ราคาสินค้า-ยาการค้า'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tb-item-index">
                        <?php Pjax::begin(['id' => 'tb_item_pjax_pricelisttpu']); ?>
                        <?php // echo $this->render('_search', ['model' => $searchModel, 'action' => 'pricelisttpu']); ?>
                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel'=>$searchModel,
                            //'pjax' => true,
                            'striped' => false,
                            'hover' => true,
                            'layout' => $layout,
                            //'export' => false,
                            'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'replaceTags' => [
                                '{custom}' => $this->render('_search', ['model' => $searchModel, 'action' => 'pricelist']),
                            ],
                            'columns' => [
                                [
                                    'header' => 'รหัสสินค้า',
                                    'attribute' => 'ItemID',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;',],
                                    'value' => function ($model, $key, $index, $widget) {
                                        return $model->ItemID;
                                    },
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'Working Code',
                                    'attribute' => 'Item_workingcode',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;',],
                                    'contentOptions' => ['style' => 'text-align:center;',],
                                    'value' => function($model) {
                                        return $model['Item_workingcode'];
                                    },
                                    'editableOptions' => function ($model, $key, $index) {
                                        return [
                                            'header' => 'Working Code',
                                            'size' => 'md',
                                            'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
                                            'options' => [
                                                'rows' => 5,
                                            ],
                                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                                echo $form->field($widget->model, 'ItemID', [
                                                    'options' => ['hidden' => true],
                                                ]);
                                            },
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                                "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                                "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                            ],
                                            'submitButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                                'class' => 'btn btn-sm btn-primary',
                                                'label' => 'Save',
                                            ],
                                            'resetButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                                'class' => 'btn btn-sm btn-default',
                                                'label' => 'Reset',
                                            ],
                                        ];
                                    },
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'รายละเอียดสินค้า',
                                    'attribute' => 'ItemName',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;',],
                                    'contentOptions' => ['style' => 'text-align:left;',],
                                    'value' => function($model) {
                                        return $model['ItemName'];
                                    },
                                    'editableOptions' => function ($model, $key, $index) {
                                        return [
                                            'header' => 'รายละเอียดสินค้า',
                                            'size' => 'md',
                                            'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
                                            'options' => [
                                                'rows' => 5,
                                            ],
                                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                                echo $form->field($widget->model, 'ItemID', [
                                                    'options' => ['hidden' => true],
                                                ]);
                                            },
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                                "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                                "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                            ],
                                            'submitButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                                'class' => 'btn btn-sm btn-primary',
                                                'label' => 'Save',
                                            ],
                                            'resetButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                                'class' => 'btn btn-sm btn-default',
                                                'label' => 'Reset',
                                            ],
                                        ];
                                    },
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'กลุ่มยา',
                                    'attribute' => 'DrugClass',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;',],
                                    'contentOptions' => ['style' => 'text-align:left;',],
                                    'value' => function ($model) {
                                        return empty($model['DrugClass']) ? '-' : $model['DrugClass'];
                                    },
                                    //'group' => true,
                                    'editableOptions' => function ($model, $key, $index) use ($TbDrugclass) {
                                        return [
                                            /* 'asPopover' => false, */
                                            'header' => 'กลุ่มยา',
                                            'size' => 'md',
                                            'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                                            'options' => [
                                                'data' => $TbDrugclass,
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'options' => ['placeholder' => '----- เลือกกลุ่มยา -----', 'value' => $model['Class_GP']],
                                            ],
                                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                                echo $form->field($widget->model, 'TMTID_GP', [
                                                    'options' => ['hidden' => true],
                                                ]);
                                            },
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) { swal('Saved!', '', 'success');location.reload();}",
                                                "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                                "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                            ],
                                            'submitButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                                'class' => 'btn btn-sm btn-primary',
                                                'label' => 'Save',
                                            ],
                                            'resetButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                                'class' => 'btn btn-sm btn-default',
                                                'label' => 'Reset',
                                            ],
                                        ];
                                    },
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'กลุ่มยาย่อย',
                                    'attribute' => 'DrugSubClass',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;',],
                                    'contentOptions' => ['style' => 'text-align:center;',],
                                    'value' => function ($model) {
                                        return empty($model['DrugSubClass']) ? '-' : $model['DrugSubClass'];
                                    },
                                    //'group' => true,
                                    'editableOptions' => function ($model, $key, $index) {
                                        return [
                                            'header' => 'กลุ่มยาย่อย',
                                            'size' => 'md',
                                            'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                                            'options' => [
                                                'data' => ArrayHelper::map(TbDrugsubclass::find()->where(['DrugClassID' => $model['Class_GP']])->all(), 'DrugSubClassID', 'DrugSubClass'),
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'options' => ['placeholder' => '----- เลือกกลุ่มยาย่อย -----', 'value' => $model['SubClass_GP']],
                                            ],
                                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                                echo $form->field($widget->model, 'TMTID_GP', [
                                                    'options' => ['hidden' => true],
                                                ]);
                                            },
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) { swal('Saved!', '', 'success');location.reload();}",
                                                "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                                "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                            ],
                                            'submitButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                                'class' => 'btn btn-sm btn-primary',
                                                'label' => 'Save',
                                            ],
                                            'resetButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                                'class' => 'btn btn-sm btn-default',
                                                'label' => 'Reset',
                                            ],
                                        ];
                                    },
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'ISED',
                                    'attribute' => 'ISED',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;',],
                                    'contentOptions' => ['style' => 'text-align:left;',],
                                    'value' => function ($model) {
                                        return empty($model['ISED']) ? '-' : $model['ISED'];
                                    },
                                    //'group' => true,
                                    'editableOptions' => function ($model, $key, $index) {
                                        /* $editable = Editable::begin([
                                          'model' => $model,
                                          'attribute' => 'address',
                                          'asPopover' => true,
                                          'size' => 'md',
                                          'displayValue' => '15th Main, OK, 10322',
                                          'options' => ['placeholder' => 'Enter location...']
                                          ]);
                                          $form = $editable->getForm();
                                          echo Html::hiddenInput('kv-complex', '1');
                                          $editable->afterInput = $form->field($model, 'state_1')->widget(\kartik\widgets\Select2::classname(), [
                                          'data' => ArrayHelper::map(TbIsed::find()->all(), 'ISEDID', 'ISED'), // any list of values
                                          'options' => ['placeholder' => 'Enter state...'],
                                          'pluginOptions' => ['allowClear' => true]
                                          ]) . "\n" .
                                          $form->field($model, 'zip_code')->textInput(['placeholder' => 'Enter zip code...']);
                                          Editable::end(); */
                                        return [
                                            /* 'asPopover' => false, */
                                            'header' => 'ISED',
                                            'size' => 'md',
                                            'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                                            'options' => [
                                                'data' => ArrayHelper::map(TbIsed::find()->all(), 'ISEDID', 'ISED'),
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                                'options' => ['placeholder' => '----- เลือก ISED -----', 'value' => $model['ISEDID'],],
                                            ],
                                            'afterInput' => function ($form, $widget) use ($model, $index) {
                                                echo $form->field($widget->model, 'TMTID_GP', [
                                                    'options' => ['hidden' => true],
                                                ]);
                                            },
                                            'pluginEvents' => [
                                                "editableSuccess" => "function(event, val, form, data) { swal('Saved!', '', 'success');}",
                                                "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                                "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                            ],
                                            'submitButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                                'class' => 'btn btn-sm btn-primary',
                                                'label' => 'Save',
                                            ],
                                            'resetButton' => [
                                                'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                                'class' => 'btn btn-sm btn-default',
                                                'label' => 'Reset',
                                            ],
                                        ];
                                    },
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'ราคา',
                                    'attribute' => 'ItemPrice',
                                    'format' => ['decimal', 2],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['style' => 'text-align:right;',],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => '',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'header' => 'หน่วย',
                                    'attribute' => 'DispUnit',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'contentOptions' => ['style' => 'text-align:center;',],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'หลักประกันสุขภาพถ้วนหน้า',
                                    'attribute' => 'crgrp1_op',
                                    'format' => ['decimal', 2],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;', 'colspan' => 2],
                                    'contentOptions' => ['style' => 'background-color: #f5f5f5;text-align:right;',],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'หลักประกันสุขภาพถ้วนหน้า OP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'ข้าราชการ/อปท.',
                                    'attribute' => 'crgrp1_ip',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;', 'colspan' => 2],
                                    'contentOptions' => ['style' => 'background-color: #f5f5f5;text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'หลักประกันสุขภาพถ้วนหน้า IP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'รัฐวิสาหกิจ',
                                    'attribute' => 'crgrp2_op',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;', 'colspan' => 2],
                                    'contentOptions' => ['style' => 'text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'ข้าราชการ/อปท. OP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'header' => 'ประกันสังคม',
                                    'attribute' => 'crgrp2_ip',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;', 'colspan' => 5],
                                    'contentOptions' => ['style' => 'text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'ข้าราชการ/อปท. IP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'label' => false,
                                    'attribute' => 'crgrp3_op',
                                    'headerOptions' => ['class' => 'kv-grid-hide skip-export','colspan' => 5],
                                    'contentOptions' => ['style' => 'background-color: #f5f5f5;text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'รัฐวิสาหกิจ OP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'label' => false,
                                    'attribute' => 'crgrp3_ip',
                                    'headerOptions' => ['class' => 'kv-grid-hide skip-export',],
                                    'contentOptions' => ['style' => 'background-color: #f5f5f5;text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'รัฐวิสาหกิจ IP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'label' => false,
                                    'attribute' => 'crgrp4_op',
                                    'headerOptions' => ['class' => 'kv-grid-hide skip-export',],
                                    'contentOptions' => ['style' => 'text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'ประกันสังคม OP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                    'class' => 'kartik\grid\EditableColumn',
                                    'label' => false,
                                    'attribute' => 'crgrp4_ip',
                                    'headerOptions' => ['class' => 'kv-grid-hide skip-export', 'colspan' => 2],
                                    'contentOptions' => ['style' => 'text-align:right;'],
                                    'editableOptions' => [
                                        'asPopover' => false,
                                        'header' => 'ประกันสังคม IP',
                                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                                        'pluginEvents' => [
                                            "editableSuccess" => "function(event, val, form, data) { swal('Saved!', val, 'success');}",
                                            "editableError" => "function(event, val, form, data) { swal('Error!', '', 'error'); }",
                                            "editableAjaxError" => "function(event, jqXHR, status, message) { swal('Error!', message, 'error'); }",
                                        ],
                                        'submitButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-floppy-disk"></i>',
                                            'class' => 'btn btn-sm btn-primary',
                                            'label' => 'Save',
                                        ],
                                        'resetButton' => [
                                            'icon' => '<i class="glyphicon glyphicon-refresh"></i>',
                                            'class' => 'btn btn-sm btn-default',
                                            'label' => 'Reset',
                                        ],
                                    ],
                                ],
                                [
                                   // 'class' => '\kartik\grid\DataColumn',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'width' => '10px',
                                    'headerOptions' => ['class' => 'kv-grid-hide skip-export', 'hidden' => true],
                                    'contentOptions' => ['style' => 'text-align:right;', 'hidden' => true],
                                    'hidden' => true,
                                    'hiddenFromExport' => true,
                                    'group' => true, // enable grouping
                                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                        return [
                                            'mergeColumns' => [
                                                [1, 7],
                                                [15, 16]
                                            ], // columns to merge in summary
                                            'content' => [// content to show in each summary cell
                                                //1 => '',
                                                #2 => 'รหัสยาสามัญ',
                                                #3 => 'รายละเอียดยา',
                                                //4 => 'จำนวน',
                                                //5 => 'ราคา/หน่วย',
                                                //6 => 'หน่วย',
                                                // 6 => 'OP',
                                                // 7 => 'IP',
                                                8 => 'OP',
                                                9 => 'IP',
                                                10 => 'OP',
                                                11 => 'IP',
                                                12 => 'OP',
                                                13 => 'IP',
                                                14 => 'OP',
                                                15 => 'IP',
                                            //16 => '',
                                            ],
                                            'contentOptions' => [// content html attributes for each summary cell
                                                //0 => ['style' => 'background-color: white'],
                                                //1 => ['style' => 'font-variant:small-caps;background-color: white;color:black;'],
                                                2 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                3 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                4 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                5 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                6 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                7 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                8 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                9 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                10 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                11 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                12 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                13 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                                14 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                            //15 => ['style' => 'text-align:center;background-color: white;color:black;'],
                                            //16 => ['hidden' => true]
                                            ],
                                            // html attributes for group summary row
                                            'options' => ['class' => 'defalut', 'style' => 'font-weight:bold;']
                                        ];
                                    }
                                ],
                            ],
                        ]);
                        ?>
                        <?php
                        $script = <<< JS
$('input.kv-editable-input').autoNumeric('init');
//$(document).ready(function() {
//    $('table.kv-grid-table').DataTable();
//} );
JS;
                        $this->registerJs($script);
                        ?>
                        <?php Pjax::end(); ?>
                        <br/>
                        <br/>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space" </div>

    </div>
</div>


