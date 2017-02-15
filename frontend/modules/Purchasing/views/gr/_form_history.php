<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'ประวัติใบรับสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'บันทึกรับจากการสั่งซื้อ'), 'url' => ['receive-history']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode($this->title) ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-gr2-form">
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'tbgr2-form',
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
                                    $form->field($modelGR, 'GRNum')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color: white',
                                    ])->label('หมายเลขรับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'GRDate')->widget(yii\jui\DatePicker::classname(), [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white'
                                        ],
                                    ])->label('วันที่รับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'GRTypeID')->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\modules\Purchasing\models\TbGrtype::find()->where(['GRTypeID' => $modelGR['GRTypeID']])->all(), 'GRTypeID', 'GRType'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('ประเภทการรับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'GRStatusID')->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\modules\Purchasing\models\TbGrstatus::find()->where(['GRStatusID' => $modelGR['GRStatusID']])->all(), 'GRStatusID', 'GRStatusDesc'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])->label('สถานะ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>

                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelGR, 'PONum')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color: white',
                                    ])->label('หมายเลขใบสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'PODate')->widget(yii\jui\DatePicker::classname(), [
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
                                    ])->label('วันที่สั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'POType')->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\models\TbPotype::find()->where(['POTypeID' => $modelGR->POType])->all(), 'POTypeID', 'POType'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ])->label('ประเภทการสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'VenderID')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color: white',
                                    ])->label('รหัสผู้ขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>

                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelGR, 'PRNum')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color: white',
                                    ])->label('เลขที่ใบขอซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'PODueDate')->widget(yii\jui\DatePicker::classname(), [
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
                                    ])->label('กำหนดส่งมอบ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelGR, 'VenderInvoiceNum')->textInput([
                                        'maxlength' => true,
                                        'style' => 'background-color: white',
                                    ])->label('หมายเลขใบส่งสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label no-padding-right">ชื่อผู้จำหน่าย</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="id" id="VenderName" value="<?php echo $VenderName; ?>" readonly="" style="background-color: white" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดสินค้า</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <?php if ($view == 'receive-history') { ?>
                                        <div class="form-group">
                                            <?php Pjax::begin(['timeout' => 5000]) ?>
                                            <?=
                                            GridView::widget([
                                                'dataProvider' => $dataProvider,
                                                'bootstrap' => true,
                                                'showPageSummary' => true,
                                                'responsiveWrap' => FALSE,
                                                'responsive' => true,
                                                'hover' => true,
                                                //'pjax' => true,
                                                'striped' => false,
                                                'condensed' => true,
                                                'toggleData' => false,
                                                'filterPosition' => GridView::FILTER_POS_BODY,
                                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                                'columns' => [
                                                    [
                                                        'class' => 'kartik\grid\SerialColumn',
                                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                        'width' => '36px',
                                                        'header' => '#',
                                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                                    ],
                                                    [
                                                        'class' => '\kartik\grid\DataColumn',
                                                        //'attribute' => 'PRNum',
                                                        'hAlign' => GridView::ALIGN_CENTER,
                                                        'width' => '10px',
                                                        'hidden' => true,
                                                        'value' => function ($model, $key, $index, $widget) {
                                                            return '-';
                                                        },
                                                        'group' => true, // enable grouping
                                                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                            return [
                                                                'mergeColumns' => [
                                                                    //[0, 1],
                                                                    [11, 12]
                                                                ], // columns to merge in summary
                                                                'content' => [// content to show in each summary cell
                                                                    1 => '',
                                                                    2 => 'จำนวน',
                                                                    3 => 'ราคาต่อหน่วย',
                                                                    4 => 'หน่วย',
                                                                    5 => 'จำนวน',
                                                                    6 => 'จำนวน',
                                                                    7 => 'ราคาต่อหน่วย',
                                                                    8 => 'หน่วย',
                                                                    9 => 'ราคารวม',
                                                                    10 => 'จำนวน',
                                                                ],
                                                                'contentOptions' => [// content html attributes for each summary cell
                                                                    1 => ['style' => 'font-variant:small-caps'],
                                                                    2 => ['style' => 'text-align:center'],
                                                                    3 => ['style' => 'text-align:center'],
                                                                    4 => ['style' => 'text-align:center'],
                                                                    5 => ['style' => 'text-align:center'],
                                                                    6 => ['style' => 'text-align:center'],
                                                                    7 => ['style' => 'text-align:center'],
                                                                    8 => ['style' => 'text-align:center'],
                                                                    9 => ['style' => 'text-align:center'],
                                                                    10 => ['style' => 'text-align:center'],
                                                                ],
                                                                // html attributes for group summary row
                                                                'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                            ];
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                                'attribute' => 'ItemID',
                                                                'header' => 'รหัสสินค้า',
                                                                'hAlign' => GridView::ALIGN_CENTER,
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                'attribute' => 'POQty',
                                                                'hAlign' => 'right',
                                                                'format' => ['decimal', 2],
                                                                'header' => '',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->POQty != null) {
                                                                return $model->detailview->POQty;
                                                            } else {
                                                                return '0.00';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                'attribute' => 'POUnitCost',
                                                                'hAlign' => 'right',
                                                                'format' => ['decimal', 2],
                                                                'header' => 'สั่งซื้อ',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->POUnitCost != null) {
                                                                return $model->detailview->POUnitCost;
                                                            } else {
                                                                return '0.00';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                'attribute' => 'POUnit',
                                                                'hAlign' => 'center',
                                                                'header' => '',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->POUnit != null) {
                                                                return $model->detailview->POUnit;
                                                            } else {
                                                                return '-';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center'],
                                                                'attribute' => 'GRReceivedQty',
                                                                'hAlign' => 'right',
                                                                'format' => 'html',
                                                                'header' => 'รับแล้ว',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->GRReceivedQty != null) {
                                                                return $model->detailview->GRReceivedQty;
                                                            } else {
                                                                return '-';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                'attribute' => 'GRQty',
                                                                'hAlign' => 'right',
                                                                'header' => '',
                                                                //'format' => ['decimal', 2],
                                                                'value' => function ($model) {
                                                            if ($model->detailview->GRQty != null) {
                                                                return number_format($model->detailview->GRQty, 2);
                                                            } else {
                                                                return '-';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                                                'attribute' => 'GRUnitCost',
                                                                'hAlign' => 'right',
                                                                //'format' => ['decimal', 2],
                                                                'header' => 'รับครั้งนี้',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->GRUnitCost != null) {
                                                                return number_format($model->detailview->GRUnitCost, 2);
                                                            } else {
                                                                return '-';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                'attribute' => 'GRUnit',
                                                                'hAlign' => 'center',
                                                                'header' => '',
                                                                'pageSummary' => 'ราคารวม',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->GRUnit != null) {
                                                                return $model->detailview->GRUnit;
                                                            } else {
                                                                return '-';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                'attribute' => 'GRExtenedCost',
                                                                'hAlign' => 'right',
                                                                'format' => ['decimal', 2],
                                                                'header' => '',
                                                                'pageSummary' => true,
                                                                'value' => function ($model) {
                                                            return $model->detailview->GRQty * $model->detailview->GRUnitCost;
                                                        }
                                                            ],
                                                            [
                                                                'headerOptions' => ['style' => 'text-align:center'],
                                                                'attribute' => 'GRLeftQty',
                                                                'hAlign' => 'right',
                                                                'format' => 'html',
                                                                'header' => 'ค้างส่ง',
                                                                'pageSummary' => 'บาท',
                                                                'value' => function ($model) {
                                                            if ($model->detailview->GRLeftQty != null) {
                                                                return $model->detailview->GRLeftQty;
                                                            } else {
                                                                return '0.00';
                                                            }
                                                        }
                                                            ],
                                                            [
                                                                'class' => '\kartik\grid\ActionColumn',
                                                                'noWrap' => true,
                                                                // 'options' => ['style' => 'width:100px;'],
                                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                                'template' => '{edit}',
                                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                                'buttons' => [
                                                                            'edit' => function ($url, $model) {
                                                                        if ($model->detailview->GRQty != NULL) {
                                                                            return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', $url, [
                                                                                        'title' => Yii::t('app', 'Edit'),
                                                                                        'data-toggle' => 'modal',
                                                                                        'class' => 'activity-edit-link',
                                                                            ]);
                                                                        } else {
                                                                            return Html::a('Edit', "#", [
                                                                                        'title' => Yii::t('app', 'Edit'),
                                                                                        'class' => 'btn btn-info btn-xs',
                                                                                        'disabled' => true,
                                                                                        'data-toggle' => 'modal',
                                                                            ]);
                                                                        }
                                                                    },
                                                                        ],
                                                                        'urlCreator' => function ($action, $model, $key, $index) {
                                                                    //Edit
                                                                    if ($action === 'edit') {
                                                                        return Url::to(['assign-lot-receive', 'id' => $key, 'ponum' => $model['PONum'],'view' => 'edit']);
                                                                    }
                                                                }
                                                                    ]
                                                                ],
                                                            ]);
                                                            ?>
                                                            <?php Pjax::end() ?>
                                                        </div>
                                                    <?php } ?>
                                                    <?php if ($view == 'detail-history') { ?>
                                                        <div class="form-group">
                                                            <?php Pjax::begin(['timeout' => 5000]) ?>
                                                            <?=
                                                            GridView::widget([
                                                                'dataProvider' => $dataProvider,
                                                                'bootstrap' => true,
                                                                'showPageSummary' => true,
                                                                'responsiveWrap' => FALSE,
                                                                'responsive' => true,
                                                                'hover' => true,
                                                                //'pjax' => true,
                                                                'striped' => false,
                                                                'condensed' => true,
                                                                'toggleData' => false,
                                                                'filterPosition' => GridView::FILTER_POS_BODY,
                                                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                                                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                                                'columns' => [
                                                                    [
                                                                        'class' => 'kartik\grid\SerialColumn',
                                                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                                        'width' => '36px',
                                                                        'header' => '#',
                                                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                                                    ],
                                                                    [
                                                                        'class' => '\kartik\grid\DataColumn',
                                                                        //'attribute' => 'PRNum',
                                                                        'hAlign' => GridView::ALIGN_CENTER,
                                                                        'width' => '10px',
                                                                        'hidden' => true,
                                                                        'value' => function ($model, $key, $index, $widget) {
                                                                            return '-';
                                                                        },
                                                                        'group' => true, // enable grouping
                                                                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                                            return [
                                                                                'mergeColumns' => [
                                                                                    //[0, 1],
                                                                                    [11, 12]
                                                                                ], // columns to merge in summary
                                                                                'content' => [// content to show in each summary cell
                                                                                    1 => '',
                                                                                    2 => 'จำนวน',
                                                                                    3 => 'ราคาต่อหน่วย',
                                                                                    4 => 'หน่วย',
                                                                                    5 => 'จำนวน',
                                                                                    6 => 'จำนวน',
                                                                                    7 => 'ราคาต่อหน่วย',
                                                                                    8 => 'หน่วย',
                                                                                    9 => 'ราคารวม',
                                                                                    10 => 'จำนวน',
                                                                                ],
                                                                                'contentOptions' => [// content html attributes for each summary cell
                                                                                    1 => ['style' => 'font-variant:small-caps'],
                                                                                    2 => ['style' => 'text-align:center'],
                                                                                    3 => ['style' => 'text-align:center'],
                                                                                    4 => ['style' => 'text-align:center'],
                                                                                    5 => ['style' => 'text-align:center'],
                                                                                    6 => ['style' => 'text-align:center'],
                                                                                    7 => ['style' => 'text-align:center'],
                                                                                    8 => ['style' => 'text-align:center'],
                                                                                    9 => ['style' => 'text-align:center'],
                                                                                    10 => ['style' => 'text-align:center'],
                                                                                ],
                                                                                // html attributes for group summary row
                                                                                'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                                            ];
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                                                'attribute' => 'ItemID',
                                                                                'header' => 'รหัสสินค้า',
                                                                                'hAlign' => GridView::ALIGN_CENTER,
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                                'attribute' => 'POQty',
                                                                                'hAlign' => 'right',
                                                                                'format' => ['decimal', 2],
                                                                                'header' => '',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->POQty != null) {
                                                                                return $model->detailview->POQty;
                                                                            } else {
                                                                                return '0.00';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                                'attribute' => 'POUnitCost',
                                                                                'hAlign' => 'right',
                                                                                'format' => ['decimal', 2],
                                                                                'header' => 'สั่งซื้อ',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->POUnitCost != null) {
                                                                                return $model->detailview->POUnitCost;
                                                                            } else {
                                                                                return '0.00';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                                'attribute' => 'POUnit',
                                                                                'hAlign' => 'center',
                                                                                'header' => '',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->POUnit != null) {
                                                                                return $model->detailview->POUnit;
                                                                            } else {
                                                                                return '-';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center'],
                                                                                'attribute' => 'GRReceivedQty',
                                                                                'hAlign' => 'right',
                                                                                'format' => 'html',
                                                                                'header' => 'รับแล้ว',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->GRReceivedQty != null) {
                                                                                return $model->detailview->GRReceivedQty;
                                                                            } else {
                                                                                return '-';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                                'attribute' => 'GRQty',
                                                                                'hAlign' => 'right',
                                                                                'header' => '',
                                                                                //'format' => ['decimal', 2],
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->GRQty != null) {
                                                                                return number_format($model->detailview->GRQty, 2);
                                                                            } else {
                                                                                return '-';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                                                                'attribute' => 'GRUnitCost',
                                                                                'hAlign' => 'right',
                                                                                //'format' => ['decimal', 2],
                                                                                'header' => 'รับครั้งนี้',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->GRUnitCost != null) {
                                                                                return number_format($model->detailview->GRUnitCost, 2);
                                                                            } else {
                                                                                return '-';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                                'attribute' => 'GRUnit',
                                                                                'hAlign' => 'center',
                                                                                'header' => '',
                                                                                'pageSummary' => 'ราคารวม',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->GRUnit != null) {
                                                                                return $model->detailview->GRUnit;
                                                                            } else {
                                                                                return '-';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                                                'attribute' => 'GRExtenedCost',
                                                                                'hAlign' => 'right',
                                                                                'format' => ['decimal', 2],
                                                                                'header' => '',
                                                                                'pageSummary' => true,
                                                                                'value' => function ($model) {
                                                                            return $model->detailview->GRQty * $model->detailview->GRUnitCost;
                                                                        }
                                                                            ],
                                                                            [
                                                                                'headerOptions' => ['style' => 'text-align:center'],
                                                                                'attribute' => 'GRLeftQty',
                                                                                'hAlign' => 'right',
                                                                                'format' => 'html',
                                                                                'header' => 'ค้างส่ง',
                                                                                'pageSummary' => 'บาท',
                                                                                'value' => function ($model) {
                                                                            if ($model->detailview->GRLeftQty != null) {
                                                                                return $model->detailview->GRLeftQty;
                                                                            } else {
                                                                                return '0.00';
                                                                            }
                                                                        }
                                                                            ],
                                                                            [
                                                                                'class' => '\kartik\grid\ActionColumn',
                                                                                'noWrap' => true,
                                                                                // 'options' => ['style' => 'width:100px;'],
                                                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                                                'headerOptions' => ['style' => 'text-align:center;'],
                                                                                'template' => '{detail}',
                                                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                                                'buttons' => [

                                                                                    'detail' => function ($url, $model) {
                                                                                        return Html::a('<span class="btn btn-success btn-xs"> Detail </span> ', $url, [
                                                                                                    'title' => Yii::t('app', 'Detail'),
                                                                                                    'data-toggle' => 'modal',
                                                                                                    'class' => 'activity-edit-link',
                                                                                        ]);
                                                                                    },
                                                                                        ],
                                                                                        'urlCreator' => function ($action, $model, $key, $index) {
                                                                                    //Detail
                                                                                    if ($action === 'detail') {
                                                                                        return Url::to(['assign-lot-receive', 'id' => $key, 'ponum' => $model['PONum'],'view' => 'detail']);
                                                                                    }
                                                                                }
                                                                                    ]
                                                                                ],
                                                                            ]);
                                                                            ?>
                                                                            <?php Pjax::end() ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            <?= $form->field($modelGR, 'GRID', ['showLabels' => false])->hiddenInput(['maxlength' => true]) ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="text-align: right">
                                                        <?= Html::a('Close', ['receive-history'], ['class' => 'btn btn-default']) ?>
                                                        <?php if ($view == 'receive-history') { ?>
                                                            <?= Html::button('Clear', ['class' => 'btn btn-danger', 'id' => 'Clear']) ?>
                                                            <?= Html::submitButton($modelGR->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $modelGR->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>   
                                                        <?php } ?>
                                                    </div>
                                                    <?php ActiveForm::end(); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="horizontal-space"></div>
                                    </div>
                                </div>
                                <?php
                                $script = <<< JS

//Clear
    $('#Clear').click(function (e) {
        var grid = $("#tbgr2temp-grid").val();
        var grnum = $("#tbgr2-grnum").val();
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $.post(
                        'clear-gr2',
                        {
                            id: grid,grnum:grnum
                        },
                function (data)
                {

                }
                );
            }
        });
    });
//On Save
    $('#tbgr2-form').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == "success")
            {
            Notify('Save Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
JS;
                                $this->registerJs($script);
                                ?>