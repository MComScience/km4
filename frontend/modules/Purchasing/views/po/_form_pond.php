<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
$this->title = Yii::t('app', 'สร้างใบสั่งซื้อ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สั่งซื้อ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('สร้างใบสั่งซื้อ'.$modelPO->potype->POType) ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
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
                                    $form->field($modelPO, 'PODate')->widget(yii\jui\DatePicker::classname(), [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'value' => Yii::$app->componentdate->convertMysqlToThaiDate($modelPO['PODate']),
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white'
                                        ],
                                    ])->label('วันที่', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'POStatus')->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\models\TbPostatus::find()->where(['POStatusID' => 1])->all(), 'POStatusID', 'POStatusDes'),
                                        'language' => 'en',
                                        //'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true
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
                                    $form->field($modelPR, 'PRDate')->widget(yii\jui\DatePicker::classname(), [
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
                                    $form->field($modelPR, 'PRTypeID')->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\models\TbPrtype::find()->all(), 'PRTypeID', 'PRType'),
                                        'pluginOptions' => [
                                            'placeholder' => 'Select Option',
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])->label('ประเภทใบขอซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPR, 'POTypeID')->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\models\TbPotype::find()->all(), 'POTypeID', 'POType'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])->label('ประเภทการสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>

                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelPO, 'POContID')->textInput([
                                        'style' => 'background-color: white',
                                    ])->label('เลขที่สัญญาซื้อขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'PODueDate')->widget(yii\jui\DatePicker::classname(), [
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
                                    ])->label('กำหนดการส่งมอบ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO, 'VendorID')->textInput([
                                        'style' => 'background-color: white',
                                        'placeholder' => 'คลิกเพื่อเลือกผู้จำหน่าย...',
                                    ])->label('เลขที่ผู้จำหน่าย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label no-padding-right">ชื่อผู้จำหน่าย</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="id" id="VenderName" value="<?php echo $VenderName; ?>" readonly="" style="background-color: white" />
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
                                        <?php \yii\widgets\Pjax::begin([ 'id' => 'po_detail_listgpu']) ?>
                                        <?php
                                        //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                                        ?>
                                        <?=
                                        kartik\grid\GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            //'filterModel' => $searchModel,
                                            'bootstrap' => true,
                                            'responsiveWrap' => FALSE,
                                            'responsive' => true,
                                            'showPageSummary' => true,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => true,
                                            'condensed' => true,
                                            'toggleData' => false,
                                            'pageSummaryRowOptions' => ['class' => 'default'],
                                            'layout' => "{summary}\n{items}\n{pager}",
                                            'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_SUCCESS],
                                            'columns' => [
                                                [
                                                    'class' => 'kartik\grid\SerialColumn',
                                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                    'width' => '36px',
                                                    'header' => '<a>ลำดับ</a>',
                                                    'headerOptions' => ['class' => 'kartik-sheet-style']
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return kartik\grid\GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style'],
                                                    'expandOneOnly' => true,
                                                    //'header' => '<a>Detail</a>',
                                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                                    'detailUrl' => \yii\helpers\Url::to(['view-detailnd']),
                                                    
                                                ],
                                                [
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'attribute' => 'ItemID',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        if ($model->ItemID != null) {
                                                            return $model->ItemID;
                                                        } else {
                                                            return '-';
                                                        }
                                                    }
                                                ],
                                                [
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'attribute' => 'ItemName',
                                                    'value' => function ($model) {
                                                        return $model->dataonview->ItemDetail;
                                                    }
                                                ],
                                                [
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'attribute' => 'POPackQtyApprove',
                                                    'format' => ['decimal', 2],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                        if ($model->POPackQtyApprove != null) {
                                                            return $model->POPackQtyApprove;
                                                        } else {
                                                            return '0.00';
                                                        }
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'POItemPackID',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        if ($model->POItemPackID == NULL) {
                                                            return '-';
                                                        } else {
                                                            return $model->dataonview->PackUnit;
                                                        }
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'POPackCostApprove',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'format' => ['decimal', 2],
                                                    'value' => function ($model) {
                                                        if ($model->POPackCostApprove == NULL) {
                                                            return '0.00';
                                                        } else {
                                                            return $model->POPackCostApprove;
                                                        }
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'POApprovedOrderQty',
                                                    'format' => ['decimal', 2],
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                        if ($model->POApprovedOrderQty == NULL) {
                                                            return '0.00';
                                                        } else {
                                                            return $model->POApprovedOrderQty;
                                                        }
                                                    }
                                                ],
                                                [
                                                    'header' => '<a href="">หน่วย</a>',
                                                    'attribute' => 'DispUnit',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        if ($model->dataonview->DispUnit == NULL) {
                                                            return '-';
                                                        } else {
                                                            return $model->dataonview->DispUnit;
                                                        }
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'POApprovedUnitCost',
                                                    'hAlign' => 'right',
                                                    'format' => ['decimal', 2],
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                        if ($model->POApprovedUnitCost != null) {
                                                            return $model->POApprovedUnitCost;
                                                        } else {
                                                            return '0.00';
                                                        }
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'POExtenedCost',
                                                    'header' => '<a href="">ราคารวม</a>',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'hAlign' => 'right',
                                                    'format' => ['decimal', 2],
                                                    'pageSummary' => true,
                                                    'value' => function ($model) {
                                                        if ($model->dataonview->POExtenedCost != null) {
                                                            return $model->dataonview->POExtenedCost;
                                                        } else {
                                                            return '0.00';
                                                        }
                                                    }
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => '<a>Action</a>',
                                                    'noWrap' => true,
                                                    'options' => ['style' => 'width:100px;'],
                                                    'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                    'headerOptions' => ['style' => 'text-align:center;'],
                                                    'template' => ' {editgpu}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'pageSummary' => 'บาท',
                                                    'buttons' => [
//                                                        'update' => function ($url, $model, $key) {
//                                                            return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
//                                                                        'class' => 'activity-update-link',
//                                                                        'title' => 'Select',
//                                                                        'data-toggle' => 'modal',
//                                                                        //'data-target' => '#getdatavendor',
//                                                                        'data-id' => $key,
//                                                                        'data-pjax' => '0',
//                                                            ]);
//                                                        },
                                                                'editgpu' => function ($url, $model) {
                                                           
                                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', '#', [
                                                                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                            'title' => Yii::t('app', 'Edit'),
                                                                            'data-toggle' => 'modal',
                                                                            //'data-method' => "post",
                                                                            //'role' => 'modal-remote',
                                                                            'class' => 'activity-edit-link',
                                                                ]);
                                                           
                                                        },
                                                            ],
                                                        ],
                                                    ],
                                                ]);
                                                ?>
                                                <?php \yii\widgets\Pjax::end() ?>
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
                                        <?php \yii\widgets\Pjax::begin([ 'id' => 'po_detail_listgpu_potype2']) ?>
                                        <?php
                                        //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                                        ?>
                                        <?=
                                        kartik\grid\GridView::widget([
                                            'dataProvider' => $postProvider,
                                            //'filterModel' => $searchModel,
                                            'bootstrap' => true,
                                            'responsiveWrap' => FALSE,
                                            'responsive' => true,
                                            'showPageSummary' => true,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => true,
                                            'condensed' => true,
                                            'toggleData' => false,
                                            'pageSummaryRowOptions' => ['class' => 'default'],
                                            'layout' => "{summary}\n{items}\n{pager}",
                                            'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_SUCCESS],
                                            'columns' => [
                                                [
                                                    'class' => 'kartik\grid\SerialColumn',
                                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                    'width' => '36px',
                                                    'header' => '<a>ลำดับ</a>',
                                                    'headerOptions' => ['class' => 'kartik-sheet-style']
                                                ],
                                                [
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'attribute' => 'ItemID',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                if ($model->ItemID != null) {
                                                    return $model->ItemID;
                                                } else {
                                                    return '-';
                                                }
                                            }
                                                ],
                                                [
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'attribute' => 'ItemName',
                                                    'value' => function ($model) {
                                                return $model->dataonview->ItemDetail;
                                            }
                                                ],
                                                [
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'attribute' => 'POPackQtyApprove',
                                                    'format' => ['decimal', 2],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                if ($model->POPackQtyApprove != null) {
                                                    return $model->POPackQtyApprove;
                                                } else {
                                                    return '0.00';
                                                }
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POItemPackID',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                if ($model->POItemPackID == NULL) {
                                                    return '-';
                                                } else {
                                                    return $model->dataonview->PackUnit;
                                                }
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POPackCostApprove',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'format' => ['decimal', 2],
                                                    'value' => function ($model) {
                                                if ($model->POPackCostApprove == NULL) {
                                                    return '0.00';
                                                } else {
                                                    return $model->POPackCostApprove;
                                                }
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POApprovedOrderQty',
                                                    'format' => ['decimal', 2],
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                if ($model->POApprovedOrderQty == NULL) {
                                                    return '0.00';
                                                } else {
                                                    return $model->POApprovedOrderQty;
                                                }
                                            }
                                                ],
                                                [
                                                    'header' => '<a href="">หน่วย</a>',
                                                    'attribute' => 'DispUnit',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                if ($model->dataonview->DispUnit == NULL) {
                                                    return '-';
                                                } else {
                                                    return $model->dataonview->DispUnit;
                                                }
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POApprovedUnitCost',
                                                    'hAlign' => 'right',
                                                    'format' => ['decimal', 2],
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                if ($model->POApprovedUnitCost != null) {
                                                    return $model->POApprovedUnitCost;
                                                } else {
                                                    return '0.00';
                                                }
                                            }
                                                ],
                                                [
                                                    'attribute' => 'POExtenedCost',
                                                    'header' => '<a href="">ราคารวม</a>',
                                                    'headerOptions' => ['style' => 'text-align:center'],
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'hAlign' => 'right',
                                                    'format' => ['decimal', 2],
                                                    'pageSummary' => true,
                                                    'value' => function ($model) {
                                                if ($model->dataonview->POExtenedCost != null) {
                                                    return $model->dataonview->POExtenedCost;
                                                } else {
                                                    return '0.00';
                                                }
                                            }
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ActionColumn',
                                                    'header' => '<a>Action</a>',
                                                    'noWrap' => true,
                                                    'options' => ['style' => 'width:100px;'],
                                                    'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                    'headerOptions' => ['style' => 'text-align:center;'],
                                                    'template' => ' {editgpu} {deletegpu}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'pageSummary' => 'บาท',
                                                    'buttons' => [
                                                        'editgpu' => function ($url, $model) {
                                                            if ($model['ItemID'] != null) {
                                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', '#', [
                                                                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                            'title' => Yii::t('app', 'Edit'),
                                                                            'data-toggle' => 'modal',
                                                                            //'data-method' => "post",
                                                                            //'role' => 'modal-remote',
                                                                            'class' => 'activity-edit-type2',
                                                                ]);
                                                            } else if ($model['ItemID'] == 0) {
                                                                return Html::a('Edit', "#", [
                                                                            'title' => Yii::t('app', 'Edit'),
                                                                            'class' => 'btn btn-info btn-sm',
                                                                            'disabled' => true,
                                                                            'data-toggle' => 'modal',
                                                                ]);
                                                            }
                                                        },
                                                                'deletegpu' => function ($url, $model) {
                                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                                        //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                        'title' => Yii::t('app', 'Delete'),
                                                                        'data-toggle' => 'modal',
                                                                        //'data-method' => "post",
                                                                        //'role' => 'modal-remote',
                                                                        'class' => 'activity-delete-type2',
                                                            ]);
                                                        },
                                                            ],
                                                        ],
                                                    ],
                                                ]);
                                                ?>
                                                <?php \yii\widgets\Pjax::end() ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: right">
                                        <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                                        <a class="btn btn-danger" id="Clear">Clear</a>
                                        <?= Html::submitButton($modelPO->isNewRecord ? Yii::t('app', 'SaveDraft') : Yii::t('app', 'SaveDraft'), ['class' => $modelPO->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
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
                \yii\bootstrap\Modal::begin([
                    'id' => 'getdatavendor',
                    'header' => '<h4 class="modal-title">เลือกผู้จำหน่าย</h4>',
                    'size' => 'modal-lg modal-primary',
                ]);
                ?>
                <div id="datavendor">
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                </div>
                <?php \yii\bootstrap\Modal::end(); ?>

                <?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'SelectTableTpu',
                    'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                    'size' => 'modal-lg modal-primary',
                ]);
                ?>
                <div id="data">
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                </div>
                <?php \yii\bootstrap\Modal::end(); ?>


                <?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'modaledit',
                    'header' => '<h4 class="modal-title"></h4>',
                    'size' => 'modal-lg modal-primary',
                ]);
                ?>
                <div id="datamodaledit">
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                </div>
                <?php \yii\bootstrap\Modal::end(); ?>



                <?php
                $script = <<< JS
//เลือกผู้จำหน่าย
$('#tbpo2temp-vendorid').click(function (e) {
        $('#getdatavendor').modal('show');
        run_waitMe();
        $.ajax({
            url: 'index.php?r=Purchasing/po/getdata-vendor',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-body').waitMe('hide');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกผู้จำหน่าย');
                $('#getdatavendortable').DataTable({
                        "pageLength": 10,
                         responsive: true,
                });
            }
      });
 });

//Loading
function run_waitMe(effect) {
        $('.modal-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
//GetTPU
$('#get_vw_itemtpu_to_podetail').click(function (e) {
        $('#getdatavendor').modal('show');
        run_waitMe();
        $.ajax({
            url: 'index.php?r=Purchasing/po/getdata-tpu',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-body').waitMe('hide');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกรายการยาการค้า');
                $('#getvw_itemtpu_to_podetail').DataTable({
                    "pageLength": 5,
                    responsive: true,
                });
            }
        });
    });
//GetND
$('#get_vw_itemnd_to_podetail').click(function (e) {
        $('#getdatavendor').modal('show');
        run_waitMe();
        $.ajax({
            url: 'index.php?r=Purchasing/po/getdata-nd',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-body').waitMe('hide');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกรายการเวชภัณฑ์');
                $('#getvw_itemnd_to_podetail').DataTable({
                    "pageLength": 5,
                    responsive: true,
                });
            }
        });
    });

function init_click_handlers() {
//เลือกยาการค้า Where GPU
$('.activity-update-link').click(function (e) {
            var fID = $(this).closest('tr').data('key');
            $('#ids_detail').val(fID);
            $.ajax({
                url: 'index.php?r=Purchasing/po/select-table-tpu',
                type: 'POST',
                data: {id: fID},
                dataType: 'json',
                success: function (data) {
                    $('#data').html(data);
                    $('.modal-title').html('เลือกรายการยาการค้า');
                    $('#SelectTableTpu').modal('show');
                    $('#tableSelectTPU').DataTable({
                        //"dom": '<"pull-left"f><"pull-right"l>tip',
                        "pageLength": 5,
                        responsive: true,
                    }); 
                }
            });
        });
//แก้ไขข้อมูล
        $('.activity-edit-link').click(function (e) {
                var ids = $(this).closest('tr').data('key');
                $('#modaledit > div').waitMe('hide');
                $.get(
                        'index.php?r=Purchasing/po/editpo-detailnd',
                        {
                            ids: ids
                        },
                function (data)
                {
                    $('#form_edit_po_detail').trigger('reset');
                    $('#modaledit').find('.modal-body').html(data);
                    $('#datamodaledit').html(data);
                    $('.modal-title').html('แก้ไขรายการใบสั่งซื้อ');
                    $('#modaledit').modal('show');
                }
                );
            });
        //Delete
        $('.activity-delete-type2').click(function (e) {
            var fID = $(this).closest('tr').data('key');
            bootbox.confirm('Are you sure?', function (result) {
                if (result) {
                    $.post(
                            'index.php?r=Purchasing/po/delete-detail',
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
//แก้ไขข้อมูล type2
        $('.activity-edit-type2').click(function (e) {
                var ids = $(this).closest('tr').data('key');
                $('#modaledit > div').waitMe('hide');
                $.get(
                        'index.php?r=Purchasing/po/editpo-detailtype2',
                        {
                            ids: ids
                        },
                function (data)
                {
                    $('#form_edit_po_detail').trigger('reset');
                    $('#modaledit').find('.modal-body').html(data);
                    $('#datamodaledit').html(data);
                    $('.modal-title').html('แก้ไขรายการใบสั่งซื้อ');
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
//Clear
$('#Clear').click(function (e) {
        var POID = $("#tbpo2temp-poid").val();
        bootbox.confirm("Are you sure?", function (result) {
            if (result) {
                $.post(
                        'index.php?r=Purchasing/po/clear',
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
//SaveDraft
$('#tbpo2temp_form').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result != null)
            {
            //$(\$form).trigger('reset');
                    $('#tbpo2temp-ponum').val(result);
                    $('#SendtoVerify').removeClass('disabled');
                    Notify('SaveDraft Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
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
//Disabled Button SendToVerify
$(document).ready(function () {
        $('#SendtoVerify').addClass("disabled", "disabled");
});
//$(document).ready(function () {
//                    //$('#tbpo2temp-postatus').on('change', function () {
//                        var e = document.getElementById("tbpr2-potypeid");
//                        var strUser = e.options[e.selectedIndex].text;
//                        $('#text_potype').val(result);
//                    //});
//                });
JS;
                $this->registerJs($script);
                ?>
                <script>
                    function GetnameVendor(id) {
                        $.ajax({
                            url: "index.php?r=Purchasing/po/getname-vendor",
                            type: "post",
                            data: {id: id},
                            dataType: "JSON",
                            success: function (d) {
                                $("#tbpo2temp-vendorid").val(d.VendorID);
                                $("#VenderName").val(d.VenderName);
                                $('#getdatavendor').modal('hide');
                            }
                        });
                    }
                    function run_waitMe() {
                        $('#modaledit > div').waitMe({
                            effect: 'ios',
                            text: 'Loading...',
                            bg: 'rgba(255,255,255,0.7)',
                            color: '#000',
                            onClose: function () {
                            }
                        });
                    }
                    function SelectAndSavetpu(ItemID) {
                        var PRNum = $("#tbpr2-prnum").val();
                        var ids = $("#ids_detail").val();
                        //$('#modaledit').modal('show');
                        run_waitMe();
                        $.get(
                                'index.php?r=Purchasing/po/select-and-savetpu',
                                {
                                    ItemID: ItemID, ids: ids, PRNum: PRNum
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                            } else {
                                $('#form_edit_po_detail').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('บันทึกรายการใบสั่งซื้อ');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
                    }
                    function AddNewItemdetailtpu(ItemID) {
                        var PRNum = $("#tbpr2-prnum").val();
                        var ItemType = 'TPU';
                        run_waitMe();
                        $.get(
                                'index.php?r=Purchasing/po/add-new-itemdetailtpu',
                                {
                                    ItemID: ItemID, PRNum: PRNum, ItemType: ItemType
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                            } else {
                                $('#form_edit_po_detail').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('บันทึกสินค้าแถม');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
                    }
                    function AddNewItemdetailND(ItemID) {
                        var PRNum = $("#tbpr2-prnum").val();
                        var ItemType = 'ND';
                        run_waitMe();
                        $.get(
                                'index.php?r=Purchasing/po/add-new-itemdetailtpu',
                                {
                                    ItemID: ItemID, PRNum: PRNum, ItemType: ItemType
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                            } else {
                                $('#form_edit_po_detail').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('บันทึกสินค้าแถม');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
                    }
                     function SendtoVerify() {
                        var POID = $("#tbpo2temp-poid").val();
                        //var PRNum = $("#tbpr2-prnum").val();
                        bootbox.confirm("ยืนยันการส่งทวนสอบ?", function (result) {
                            if (result) {
                                $.post(
                                        'index.php?r=Purchasing/po/sendtoverify',
                                        {
                                            POID: POID
                                        },
                                function (data)
                                {

                                }
                                );
                            }
                        });
                    }
                </script>
                <?php
//
//                $autoid1 = \app\models\TbItem::find() // AQ instance
//                        ->select('max(ItemID)') // we need only one column
//                        ->scalar(); // cool, huh?
//                $autoback1 = substr($autoid1,1) + 1;
//                $autoback1 = sprintf("%05d", $autoback1);
//                echo $autoback1;
////        $autoall1 = "2" . $autoback1;
                ?>