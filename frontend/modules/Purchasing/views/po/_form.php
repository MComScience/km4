<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use app\models\TbPostatus;
use yii\helpers\ArrayHelper;
use app\models\TbPrtype;
use app\models\TbPotype;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use frontend\assets\DataTableAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('สร้างใบสั่งซื้อ' . $modelPO->potype->POType) ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="tb-po2-temp-form">

                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'tbpo2temp_form',
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                        'formConfig' => [
                                            'labelSpan' => 4,
                                            'columns' => 6,
                                            'deviceSize' => ActiveForm::SIZE_SMALL,
                                        ],
                                        'options' => ['enctype' => 'multipart/form-data']
                            ]);
                            ?>

                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelPO, 'PONum')->textInput([
                                        'readonly' => true,
                                        'style' => 'background-color: white',
                                    ])->label('เลขที่ใบสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'PODate')->widget(DatePicker::classname(), [
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
                                    $form->field($modelPR, 'POTypeID')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(TbPotype::find()->all(), 'POTypeID', 'POType'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])->label('ประเภทการสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'POStatus')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(TbPostatus::find()->where(['POStatusID' => 1])->all(), 'POStatusID', 'POStatusDes'),
                                        'language' => 'th',
                                        //'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'disabled' => true
                                        ],
                                    ])->label('สถานะใบสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                    $form->field($modelPO, 'POID', ['showLabels' => false])->hiddenInput([
                                        'style' => 'background-color: white',
                                    ])
                                    ?>
                                </div>

                                <div class="col-xs-6 col-sm-4">
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
                                    ])->label('วันที่', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'VendorID', [
                                        'addon' => [
                                            'append' => [
                                                'content' => Html::a('เลือก','javascript:void(0);', ['class' => 'btn btn-default select-vendor','id' => 'vd1','onclick' => 'GettbVendor(this);']),
                                                'asButton' => true
                                            ]
                                        ],
                                    ])->textInput([
                                        'style' => 'background-color: #ffff99',
                                        'placeholder' => 'คลิกเพื่อเลือกผู้จำหน่าย...',
                                        'required' => true,
                                    ])->label('เลขที่ผู้จำหน่าย' . '<font color="red"> *</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label no-padding-right">ชื่อผู้จำหน่าย</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="id" id="VenderName" value="<?php echo $VenderName; ?>" readonly="" style="background-color: white" />
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelPO, 'POContID')->textInput([
                                        'style' => 'background-color: #ffff99',
                                        //'required' => true,
                                    ])->label('เลขที่สัญญาซื้อขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'PODueDate')->widget(DatePicker::classname(), [
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
                                    $form->field($modelPO, 'Menu_VendorID', [
                                        'addon' => [
                                            'append' => [
                                                'content' => Html::a('เลือก','javascript:void(0);', ['class' => 'btn btn-default select-vendor','id' => 'vd2','onclick' => 'GettbVendor(this);']),
                                                'asButton' => true
                                            ]
                                        ],
                                    ])->textInput([
                                        'style' => 'background-color: #ffff99',
                                        'placeholder' => 'คลิกเพื่อเลือกผู้ผลิต...',
                                        'required' => true,
                                    ])->label('ผู้ผลิต' . '<font color="red"> *</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label no-padding-right">ชื่อผู้ผลิต</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="id" id="Menu_VendorName" value="<?php echo empty($MenuVenderName) ? '': $MenuVenderName; ?>" readonly="" style="background-color: white" />
                                        </div>
                                    </div>

                                    <input id="ids_detail" type="hidden" name="ids" class="form-control" />
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดใบสั่งซื้อ</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <?php Pjax::begin([ 'id' => 'po_detail_listgpu']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'responsiveWrap' => FALSE,
                                            'showPageSummary' => true,
                                            'hover' => true,
                                            'bordered' => FALSE,
                                            'pjax' => true,
                                            'striped' => FALSE,
                                            'condensed' => true,
                                            'toggleData' => false,
                                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                            'layout' => "{summary}\n{items}\n{pager}",
                                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                            'columns' => [
                                                [
                                                    'class' => 'kartik\grid\SerialColumn',
                                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                    'width' => '36px',
                                                    'header' => '#',
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black']
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black'],
                                                    'expandOneOnly' => true,
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                    'detailUrl' => Url::to(['view-detail','prid' => $modelPR['PRID']]),
                                                ],
                                                [
                                                    'attribute' => 'ItemID',
                                                    'header' => 'รหัสสินค้า',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'format' => 'raw',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->ItemID) ? '<kbd>' . $model->TMTID_GPU . '</kbd>' : '<kbd>' . $model->ItemID . '</kbd>';
                                            },
                                                ],
                                                [
                                                    'attribute' => 'ItemName',
                                                    'header' => 'รายการสินค้า',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'value' => function ($model) {
                                                return $model->dataonview->ItemDetail;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRQty',
                                                    'label' => false,
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->PRQty) ? '-' : number_format($model->dataonview->PRQty, 4);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRUnitCost',
                                                    'header' => 'ขอซื้อ',
                                                    'width' => '100px',
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->PRUnitCost) ? '-' : number_format($model->dataonview->PRUnitCost, 4);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRUnit',
                                                    'label' => false,
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POQty',
                                                    'label' => false,
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->POQty) ? '-' : number_format($model->dataonview->POQty, 4);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POUnitCost',
                                                    'header' => 'สั่งซื้อ',
                                                    'noWrap' => true,
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->POUnitCost) ? '-' : number_format($model->dataonview->POUnitCost, 4);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POUnit',
                                                    'label' => false,
                                                    'noWrap' => true,
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->POUnit) ? '-' : $model->dataonview->POUnit;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POExtenedCost',
                                                    'header' => 'ราคารวม',
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'pageSummary' => true,
                                                    'format' => ['decimal', 4],
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->POExtenedCost) ? '' : $model->dataonview->POExtenedCost;
                                            }
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => 'Actions',
                                                    'noWrap' => true,
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'template' => ' {select} {editgpu}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'pageSummary' => 'บาท',
                                                    'buttons' => [
                                                        'select' => function ($url, $model, $key) {
                                                            if ($model['ItemID'] == null) {
                                                                return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
                                                                            'class' => 'activity-update-link',
                                                                            'title' => 'Select',
                                                                            'data-toggle' => 'modal',
                                                                            //'data-target' => '#getdatavendor',
                                                                            'data-id' => $key,
                                                                            'data-pjax' => '0',
                                                                ]);
                                                            } else {
                                                                return Html::a('Select', "#", [
                                                                            'title' => 'Select',
                                                                            'class' => 'btn btn-success btn-xs',
                                                                            'disabled' => true,
                                                                            'data-toggle' => 'modal',
                                                                ]);
                                                            }
                                                        },
                                                                'editgpu' => function ($url, $model) {
                                                            if ($model['ItemID'] != null) {
                                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', '#', [
                                                                            'title' => 'Edit',
                                                                            'data-toggle' => 'modal',
                                                                            'class' => 'activity-edit-link',
                                                                ]);
                                                            } else if ($model['ItemID'] == 0) {
                                                                return Html::a('Edit', "#", [
                                                                            'title' => 'Edit',
                                                                            'class' => 'btn btn-info btn-sm',
                                                                            'disabled' => true,
                                                                            'data-toggle' => 'modal',
                                                                ]);
                                                            }
                                                        },
                                                            ],
                                                        ],
                                                        [
                                                            'class' => '\kartik\grid\DataColumn',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'width' => '10px',
                                                            'hidden' => true,
                                                            'group' => true, // enable grouping
                                                            'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                                return [
                                                                    'mergeColumns' => [
                                                                        [0, 3],
                                                                        [11, 12]
                                                                    ], // columns to merge in summary
                                                                    'content' => [// content to show in each summary cell
                                                                        1 => '',
                                                                        4 => 'จำนวน',
                                                                        5 => 'ราคา/หน่วย',
                                                                        6 => 'หน่วย',
                                                                        7 => 'จำนวน',
                                                                        8 => 'ราคา/หน่วย',
                                                                        9 => 'หน่วย',
                                                                    ],
                                                                    'contentOptions' => [// content html attributes for each summary cell
                                                                        0 => ['style' => 'background-color: #ddd;color:black'],
                                                                        1 => ['style' => 'font-variant:small-caps;background-color: #ddd;color:black'],
                                                                        4 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                        5 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                        6 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                        7 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                        8 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                        9 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                        10 => ['style' => 'background-color: #ddd;color:black'],
                                                                        11 => ['style' => 'background-color: #ddd;color:black'],
                                                                    ],
                                                                    // html attributes for group summary row
                                                                    'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                                ];
                                                            }
                                                                ],
                                                            ],
                                                        ]);
                                                        ?>
                                                        <?php Pjax::end() ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="row">
                                                <h5 class="row-title before-success">รายละเอียดรายการยาแถม</h5>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group" >
                                                        <a  class="btn btn-success" id="get_vw_itemtpu_to_podetail"><i class="glyphicon glyphicon-plus"></i>เลือกรายการยาการค้า</a>
                                                        <a  class="btn btn-success" id="get_vw_itemnd_to_podetail"><i class="glyphicon glyphicon-plus"></i>เลือกรายการเวชภัณฑ์</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <?php Pjax::begin([ 'id' => 'po_detail_listgpu_potype2']) ?>
                                                <?=
                                                GridView::widget([
                                                    'dataProvider' => $postProvider,
                                                    'responsiveWrap' => FALSE,
                                                    'showPageSummary' => true,
                                                    'hover' => true,
                                                    'pjax' => true,
                                                    'striped' => false,
                                                    'condensed' => true,
                                                    'bordered' => FALSE,
                                                    'toggleData' => false,
                                                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                                    'layout' => "{summary}\n{items}\n{pager}",
                                                    'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                                    'columns' => [
                                                        [
                                                            'class' => 'kartik\grid\SerialColumn',
                                                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                            'width' => '36px',
                                                            'header' => '#',
                                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black']
                                                        ],
                                                        [
                                                            'attribute' => 'ItemID',
                                                            'header' => 'รหัสสินค้า',
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'format' => 'raw',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'value' => function ($model) {
                                                        return '<kbd>' . $model->ItemID . '</kbd>';
                                                    },
                                                        ],
                                                        [
                                                            'attribute' => 'ItemName',
                                                            'header' => 'รายการสินค้า',
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'value' => function ($model) {
                                                        return $model->dataonview->ItemDetail;
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'PRQty',
                                                            'label' => false,
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->PRQty) ? '-' : number_format($model->dataonview->PRQty, 4);
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'PRUnitCost',
                                                            'header' => 'ขอซื้อ',
                                                            'width' => '100px',
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->PRUnitCost) ? '-' : number_format($model->dataonview->PRUnitCost, 4);
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'PRUnit',
                                                            'label' => false,
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'POQty',
                                                            'label' => false,
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->POQty) ? '-' : number_format($model->dataonview->POQty, 4);
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'POUnitCost',
                                                            'header' => 'สั่งซื้อ',
                                                            'width' => '100px',
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->POUnitCost) ? '-' : number_format($model->dataonview->POUnitCost, 4);
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'POUnit',
                                                            'width' => '80px',
                                                            'label' => false,
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            //'pageSummary' => 'รวมเป็นเงิน',
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->POUnit) ? '-' : $model->dataonview->POUnit;
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'POExtenedCost',
                                                            'width' => '120px',
                                                            'header' => 'ราคารวม',
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            //'pageSummary' => true,
                                                            'format' => ['decimal', 4],
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->POExtenedCost) ? '' : $model->dataonview->POExtenedCost;
                                                    }
                                                        ],
                                                        [
                                                            'class' => 'kartik\grid\ActionColumn',
                                                            'header' => 'Actions',
                                                            'noWrap' => true,
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                            'template' => ' {editgpu} {deletegpu}',
                                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                                            //'pageSummary' => 'บาท',
                                                            'buttons' => [
                                                                'editgpu' => function ($url, $model) {
                                                                    if ($model['ItemID'] != null) {
                                                                        return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', '#', [
                                                                                    'data-toggle' => 'modal',
                                                                                    'class' => 'activity-edit-type2',
                                                                        ]);
                                                                    } else if ($model['ItemID'] == 0) {
                                                                        return Html::a('Edit', "#", [
                                                                                    'title' => 'Edit',
                                                                                    'class' => 'btn btn-info btn-sm',
                                                                                    'disabled' => true,
                                                                                    'data-toggle' => 'modal',
                                                                        ]);
                                                                    }
                                                                },
                                                                        'deletegpu' => function ($url, $model) {
                                                                    return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                                                'title' => 'Delete',
                                                                                'data-toggle' => 'modal',
                                                                                'class' => 'activity-delete-type2',
                                                                    ]);
                                                                },
                                                                    ],
                                                                ],
                                                                [
                                                                    'class' => '\kartik\grid\DataColumn',
                                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                                    'width' => '10px',
                                                                    'hidden' => true,
                                                                    'group' => true, // enable grouping
                                                                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                                        return [
                                                                            'mergeColumns' => [
                                                                                [0, 2],
                                                                                [10, 11]
                                                                            ], // columns to merge in summary
                                                                            'content' => [// content to show in each summary cell
                                                                                1 => '',
                                                                                3 => 'จำนวน',
                                                                                4 => 'ราคา/หน่วย',
                                                                                5 => 'หน่วย',
                                                                                6 => 'จำนวน',
                                                                                7 => 'ราคา/หน่วย',
                                                                                8 => 'หน่วย',
                                                                            ],
                                                                            'contentOptions' => [// content html attributes for each summary cell
                                                                                0 => ['style' => 'background-color: #ddd;color:black'],
                                                                                1 => ['style' => 'font-variant:small-caps;background-color: #ddd;color:black'],
                                                                                3 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                4 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                5 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                6 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                7 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                8 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                9 => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                                                10 => ['style' => 'background-color: #ddd;color:black'],
                                                                            ],
                                                                            // html attributes for group summary row
                                                                            'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                                        ];
                                                                    }
                                                                        ],
                                                                    ],
                                                                ]);
                                                                ?>
                                                                <?php Pjax::end() ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="text-align: right">
                                                        <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                                                        <a class="btn btn-danger" id="Clear">Clear</a>
                                                        <?= Html::submitButton($modelPO->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $modelPO->isNewRecord ? 'btn btn-primary ladda-button' : 'btn btn-primary ladda-button', 'data-style' => 'expand-left']) ?>
                                                        <a class="btn btn-info" id="SendtoVerify" onclick="SendtoVerify();">Save & Send To Verify</a>
                                                    </div>

                                                    <?php ActiveForm::end(); ?>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="horizontal-space"></div>
                                    </div>
                                </div>

                                <?php
                                Modal::begin([
                                    'id' => 'getdatavendor',
                                    'header' => '<h4 class="modal-title">เลือกผู้จำหน่าย</h4>',
                                    'size' => 'modal-lg modal-primary',
                                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                                    'closeButton' => false,
                                    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                                ]);
                                ?>
                                <div id="datavendor">
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                </div>
                                <?php Modal::end(); ?>

                                <?php
                                Modal::begin([
                                    'id' => 'SelectTableTpu',
                                    'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                                    'size' => 'modal-lg modal-primary',
                                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                                    'closeButton' => false,
                                    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                                ]);
                                ?>
                                <div id="data">
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                </div>
                                <?php Modal::end(); ?>


                                <?php
                                Modal::begin([
                                    'id' => 'modaledit',
                                    'header' => '<h4 class="modal-title"></h4>',
                                    'size' => 'modal-lg modal-primary',
                                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                                    'closeButton' => false,
                                ]);
                                ?>
                                <div id="datamodaledit">
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                    <h1><p> </p></h1><br>
                                </div>
                                <?php Modal::end(); ?>



                                <?php
                                $script = <<< JS
//เลือกผู้จำหน่าย
function GettbVendor(e) {
    var type = (e.getAttribute("id"));
    
    LoadingClass();
    $.ajax({
        url: 'getdata-vendor',
        type: 'GET',
        data: {type: type},
        dataType: 'json',
        success: function (data) {
            $('#getdatavendor').find('.modal-body').html(data);
            $('#datavendor').html(data);
            $('.modal-title').html('เลือกผู้จำหน่าย');
            $('.page-content').waitMe('hide');
            $('#getdatavendor').modal('show');
            $('#getdatavendortable').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]],
            });
        }
    });
}

//Loading

function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'ios',//roundBounce
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}
//GetTPU
$('#get_vw_itemtpu_to_podetail').click(function (e) {
    LoadingClass();
    $.ajax({
        url: 'getdata-tpu',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('.modal-body').waitMe('hide');
            $('#getdatavendor').find('.modal-body').html(data);
            $('#datavendor').html(data);
            $('.modal-title').html('เลือกรายการยาการค้า');
            $('.page-content').waitMe('hide');
            $('#getdatavendor').modal('show');
            $('#getvw_itemtpu_to_podetail').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]],
            });
        }
    });
});
//GetND
$('#get_vw_itemnd_to_podetail').click(function (e) {
    LoadingClass();
    $.ajax({
        url: 'getdata-nd',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('.modal-body').waitMe('hide');
            $('#getdatavendor').find('.modal-body').html(data);
            $('#datavendor').html(data);
            $('.modal-title').html('เลือกรายการเวชภัณฑ์');
            $('.page-content').waitMe('hide');
            $('#getdatavendor').modal('show');
            $('#getvw_itemnd_to_podetail').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]],
            });
        }
    });
});

function init_click_handlers() {
    /* เลือกยาการค้า Where GPU */
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $('#ids_detail').val(fID);
        LoadingClass();
        $.ajax({
            url: 'select-table-tpu',
            type: 'POST',
            data: {id: fID},
            dataType: 'json',
            success: function (data) {
                $('#data').html(data);
                $('.modal-title').html('เลือกรายการยาการค้า');
                $('.page-content').waitMe('hide');
                $('#SelectTableTpu').modal('show');
                $('#tableSelectTPU').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "infoEmpty": "No records available",
                        "search": "_INPUT_ ",
                        "sSearchPlaceholder": "ค้นหาข้อมูล",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]],
                });
            }
        });
    });

    /* แก้ไขข้อมูล */
    $('.activity-edit-link').click(function (e) {
        var ids = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'editpo-detail',
                {
                    ids: ids
                },
        function (data)
        {
            $('#form_edit_po_detail').trigger('reset');
            $('#modaledit').find('.modal-body').html(data);
            $('#datamodaledit').html(data);
            $('.modal-title').html('แก้ไขรายการใบสั่งซื้อ');
            $('.page-content').waitMe('hide');
            $('#modaledit').modal('show');
        }
        );
    });

    /* Delete */
    $('.activity-delete-type2').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-detail',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#po_detail_listgpu_potype2'});
                        }
                        );
                    }
                });
    });

    /* แก้ไขข้อมูล type2 */
    $('.activity-edit-type2').click(function (e) {
        var ids = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'editpo-detailtype2',
                {
                    ids: ids
                },
        function (data)
        {
            $('#form_edit_po_detail').trigger('reset');
            $('#modaledit').find('.modal-body').html(data);
            $('#datamodaledit').html(data);
            $('.modal-title').html('แก้ไขรายการใบสั่งซื้อ');
            $('.page-content').waitMe('hide');
            $('#modaledit').modal('show');
        }
        );
    });
}
init_click_handlers(); //first run
$('#po_detail_listgpu').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
$('#po_detail_listgpu_potype2').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                                        
/* Clear */
$('#Clear').click(function (e) {
    var POID = $("#tbpo2temp-poid").val();
    swal({
        title: "Are you sure?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'clear',
                            {
                                POID: POID
                            },
                    function (data)
                    {

                    }
                    );
                }
            });
});
                                        
                                        
/* SaveDraft */
$('#tbpo2temp_form').on('beforeSubmit', function(e)
{
var l = $('.ladda-button').ladda();
l.ladda('start');
var \$form = $(this);
        $.post(
                \$form.attr('action'), // serialize Yii2 form
                \$form.serialize()
                )
        .done(function(result) {
        if (result != 'null')
        {
        //$(\$form).trigger('reset');
        $('#tbpo2temp-ponum').val(result);
                $('#SendtoVerify').removeClass('disabled');
                swal({
                    title: "",
                    text: "Save Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                            }
                        });
        } else
        {
            swal({
                    title: "Alert Message!",
                    text: "<span style='color:#F8BB86'>กรุณาเลือกตัวยาและระบุจำนวนสั่งซื้อให้ครบ<span>!",
                    html: true
                });
            l.ladda('stop');
        }
        })
        .fail(function()
        {
        console.log('server error');
        });
        return false;
});

/* Disabled Button SendToVerify */
$(document).ready(function () {
        var VenderName = $("#tbpo2temp-vendorid").val();
        if (VenderName == '') {
            $("#VenderName").val('');
        }
        $('#SendtoVerify').addClass("disabled", "disabled");
    });
JS;
                                $this->registerJs($script, \yii\web\View::POS_END, 'create');
                                ?>
<script>
    function GetnameVendor(e) {
        var vdid = (e.getAttribute("id"));
        var type = (e.getAttribute("type"));
        $.ajax({
            url: "getname-vendor",
            type: "post",
            data: {id: vdid},
            dataType: "JSON",
            success: function (d) {
                if(type == 'vd1'){
                    $("#tbpo2temp-vendorid,#tbpo2temp-menu_vendorid").val(d.VendorID);
                    $("#VenderName,#Menu_VendorName").val(d.VenderName);
                }else{
                    $("#tbpo2temp-menu_vendorid").val(d.VendorID);
                    $("#Menu_VendorName").val(d.VenderName);
                }
                $('#getdatavendor').modal('hide');
            }
        });
    }
    function SelectAndSavetpu(ItemID) {
        var PRNum = $("#tbpr2-prnum").val();
        var ids = $("#ids_detail").val();
        LoadingClass();
        $.get(
                'select-and-savetpu',
                {
                    ItemID: ItemID, ids: ids, PRNum: PRNum
                },
                function (data)
                {
                    if (data == 'false') {
                        swal({
                            title: "",
                            text: "รหัสสินค้านี้ถูกบันทึกแล้ว!",
                            type: "warning"
                        });
                        $('.page-content').waitMe('hide');
                    } else {
                        $('#form_edit_po_detail').trigger('reset');
                        $('#modaledit > div').waitMe('hide');
                        $('#modaledit').find('.modal-body').html(data);
                        $('#datamodaledit').html(data);
                        $('.modal-title').html('บันทึกรายการใบสั่งซื้อ');
                        $('.page-content').waitMe('hide');
                        $('#modaledit').modal('show');
                    }

                }
        );
    }
    function AddNewItemdetailtpu(ItemID) {
        var PRNum = $("#tbpr2-prnum").val();
        var ItemType = 'TPU';
        LoadingClass();
        $.get(
                'add-new-itemdetailtpu',
                {
                    ItemID: ItemID, PRNum: PRNum, ItemType: ItemType
                },
                function (data)
                {
                    if (data == 'false') {
                        swal({
                            title: "",
                            text: "รหัสสินค้านี้ถูกบันทึกแล้ว!",
                            type: "warning"
                        });
                        $('.page-content').waitMe('hide');
                    } else {
                        $('#form_edit_po_detail').trigger('reset');
                        $('#modaledit > div').waitMe('hide');
                        $('#modaledit').find('.modal-body').html(data);
                        $('#datamodaledit').html(data);
                        $('.modal-title').html('บันทึกสินค้าแถม');
                        $('.page-content').waitMe('hide');
                        $('#modaledit').modal('show');
                    }

                }
        );
    }
    function AddNewItemdetailND(ItemID) {
        var PRNum = $("#tbpr2-prnum").val();
        var ItemType = 'ND';
        LoadingClass();
        $.get(
                'add-new-itemdetailtpu',
                {
                    ItemID: ItemID, PRNum: PRNum, ItemType: ItemType
                },
                function (data)
                {
                    if (data == 'false') {
                        swal({
                            title: "",
                            text: "รหัสสินค้านี้ถูกบันทึกแล้ว!",
                            type: "warning"
                        });
                        $('.page-content').waitMe('hide');
                    } else {
                        $('#form_edit_po_detail').trigger('reset');
                        $('#modaledit').find('.modal-body').html(data);
                        $('#datamodaledit').html(data);
                        $('.modal-title').html('บันทึกสินค้าแถม');
                        $('.page-content').waitMe('hide');
                        $('#modaledit').modal('show');
                    }

                }
        );
    }
    function SendtoVerify() {
        var POID = $("#tbpo2temp-poid").val();
        var PRNum = $("#tbpr2-prnum").val();
        swal({
            title: "ยืนยันการส่งทวนสอบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'sendtoverify',
                                {
                                    PRNum: PRNum, POID: POID
                                },
                                function (data)
                                {

                                }
                        );
                    }
                });
    }
</script>



