<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);
if ($modelST['STStatus']== 1){
    $this->title = "บันทึกใบเคลมสินค้า";
}
else if ($modelST['STStatus']== 2){
    $this->title = "ใบเคลมสินค้ารอรับเข้า";
}
else if ($modelST['STStatus']== 20 || $modelST['STStatus']== 21 ){
    $this->title = "ประวัติใบเคลมสินค้า";
}
else{
  $this->title = "บันทึกใบเคลมสินค้า";
}
/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */
/* @var $form yii\widgets\ActiveForm */
//echo $modelST->vendername->VenderName;
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
                        <?php if ($view == '') { ?>
                        <div class="tb-st2-temp-form">
                            <?php
                            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formlend']);
                            ?>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelST, 'STNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STNum', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelST, 'STDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: #FFFF99',
                                        ],
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelST, 'STTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STTypeID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelST->sttype->STTypeDesc,
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelST, 'STIssue_StkID', ['label' => 'ขอเบิกจากคลังสินค้า' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STIssue_StkID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\TbStk::find()->all(),'StkID', 'StkName'),
                                        'options' => ['placeholder' => 'เลือกคลังสินค้า...'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                            <label class="col-sm-2 control-label no-padding-right">กำหนดส่งสินค้าคืน<a id="checkDuedate"></a></label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STDueDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: #FFFF99',
                                            'placeholder' => 'กำหนดส่งสินค้าคืน...',
                                        ],
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">เลขที่ผู้ขาย<a id="checkVendername"></a></label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STPerson', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        //'readonly' => true,
                                        'style' => 'background-color:#FFFF99',
                                        'placeholder' => 'คลิกเพื่อเลือกผู้ขาย...',
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelST, 'STStatus', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STStatus', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelST->status->STStatusDesc,
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">ชื่อผู้ขาย</label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'vendername', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'style' => 'background-color:white',
                                        'value'=> $vendername,
                                        'readonly'=>true,
                                        ])
                                    ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ($view == 'view') { ?>
                            <div class="tb-st2-temp-form">
                            <?php
                            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formlend']);
                            ?>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelST, 'STNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STNum', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelST, 'STDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                        //'readonly' => true,
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white',
                                        ],
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelST, 'STTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STTypeID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelST->sttype->STTypeDesc,
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelST, 'STIssue_StkID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STIssue_StkID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelST->stk->StkName,
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                            <?= Html::activeLabel($modelST, 'STDueDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STDueDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white',
                                        ],
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">เลขที่ผู้ขาย</label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STPerson', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <?= Html::activeLabel($modelST, 'STStatus', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'STStatus', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelST->status->STStatusDesc,
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">ชื่อผู้ขาย</label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelST, 'vendername', ['showLabels' => false])->textInput([
                                        'readonly' => true,
                                        'maxlength' => true,
                                        'style' => 'background-color:white',
                                        'value'=> $vendername,
                                        ])
                                    ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?= $form->field($modelST, 'STID', ['showLabels' => false])->hiddenInput() ?>
                            <br>
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดใบโอนสินค้า</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                </div>
                            </div>
                            <?php if ($view == '') { ?>
                                <div class="form-group">
                                    <a class="btn btn-success" id="getvwitemlisttpu"><i class="glyphicon glyphicon-plus">รายการยา</i></a>
                                    <a class="btn btn-success" id="getvwitemlistnd"><i class="glyphicon glyphicon-plus">รายการเวซภัณฑ์</i></a>
                                </div>
                            <?php } ?>
                            <?php if ($view == '') { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'st_detail']) ?>
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
                                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                            ],
                                            [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return kartik\grid\GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                                    'expandOneOnly' => true,
                                                    //'header' => '<a>Detail</a>',
                                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                                    'detailUrl' => \yii\helpers\Url::to(['view-detail']),
                                                    
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รหัสสินค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->ItemID != null) {
                                                            return $model->dataviewdetail->ItemID;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รายการสินค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->ItemName != null) {
                                                            return $model->dataviewdetail->ItemName;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                                
                                               
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:right;background-color: #ddd;color:#000000;'],
                                                'header' => 'ยอดโอน',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->STQty != null) {
                                                            return $model->dataviewdetail->STQty;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->STUnit != null) {
                                                            return $model->dataviewdetail->STUnit;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'class' => 'kartik\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'noWrap' => true,
                                                //'pageSummary' => 'บาท',
                                                'options' => ['style' => 'width:100px;'],
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'template' => '{update} {delete}',
                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                'buttons' => [
                                                            'update' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                        'class' => 'activity-edit-link',
                                                                        'title' => 'Edit',
                                                                        'data-toggle' => 'modal',
                                                                        'data-id' => $key,
                                                            ]);
                                                            },
                                                            'delete' => function ($url, $model ,$key) {
                                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                                        //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                        'title' => Yii::t('app', 'Delete'),
                                                                        'data-toggle' => 'modal',
                                                                        //'data-method' => "post",
                                                                        //'role' => 'modal-remote',
                                                                        'class' => 'activity-delete-link',
                                                            ]);
                                                        }
                                                ],
                                            ],
                                            [
                                                        'class' => '\kartik\grid\DataColumn',
                                                        'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                        'width' => '10px',
                                                        'hidden' => true,
//                                                'value' => function ($model, $key, $index, $widget) {
//                                                    return '-';
//                                                },
                                                        'group' => true, // enable grouping
                                                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                            return [
                                                                'mergeColumns' => [
                                                                    [1, 3],
                                                                    [6, 7]
                                                                ], // columns to merge in summary
                                                                'content' => [// content to show in each summary cell
                                                                    1 => '',
                                                                    3 => '',
                                                                    4 => 'จำนวน',
                                                                    5 => 'หน่วย',
                                                                ],
                                                                'contentOptions' => [// content html attributes for each summary cell
                                                                    0 => ['style' => 'background-color: #ddd'],
                                                                    1 => ['style' => 'font-variant:small-caps;background-color: #ddd'],
                                                                    4 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    5 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    6 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    7 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    8 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    9 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                ],
                                                                // html attributes for group summary row
                                                                'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                            ];
                                                        }
                                                            ],             
                                            
                                            ],
                                            
                                    ]);
                                    ?>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                                <?php } ?>
                                <?php if ($view == 'view') { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'st_detail']) ?>
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
                                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                            ],
                                            [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return kartik\grid\GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                                    'expandOneOnly' => true,
                                                    //'header' => '<a>Detail</a>',
                                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                                    'detailUrl' => \yii\helpers\Url::to(['view-detail-history']),
                                                    
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รหัสสินค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->ItemID != null) {
                                                            return $model->dataviewdetail->ItemID;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รายการสินค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->ItemName != null) {
                                                            return $model->dataviewdetail->ItemName;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                                
                                               
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:right;background-color: #ddd;color:#000000;'],
                                                'header' => 'ยอดโอน',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->STQty != null) {
                                                            return $model->dataviewdetail->STQty;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataviewdetail->STUnit != null) {
                                                            return $model->dataviewdetail->STUnit;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            
                                            [
                                                        'class' => '\kartik\grid\DataColumn',
                                                        'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                        'width' => '10px',
                                                        'hidden' => true,
//                                                'value' => function ($model, $key, $index, $widget) {
//                                                    return '-';
//                                                },
                                                        'group' => true, // enable grouping
                                                        'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                            return [
                                                                'mergeColumns' => [
                                                                    [1, 3],
                                                                    [5, 6]
                                                                ], // columns to merge in summary
                                                                'content' => [// content to show in each summary cell
                                                                    1 => '',
                                                                    3 => '',
                                                                    4 => 'จำนวน',
                                                                    5 => 'หน่วย',
                                                                ],
                                                                'contentOptions' => [// content html attributes for each summary cell
                                                                    0 => ['style' => 'background-color: #ddd'],
                                                                    1 => ['style' => 'font-variant:small-caps;background-color: #ddd'],
                                                                    4 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    5 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    6 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    7 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    8 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    9 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                ],
                                                                // html attributes for group summary row
                                                                'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                            ];
                                                        }
                                                            ],             
                                            
                                            ],
                                            
                                    ]);
                                    ?>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                                <?php } ?>
                                <br><br>
                                <?php if ($view == '') { ?>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right">หมายเหตุ</label>
                                        <div class="col-sm-3">
                                                            <?=
                                                            $form->field($modelST, 'STNote', ['showLabels' => false])->textarea([
                                                                'rows' => 3,
                                                                'style' => 'background-color:#FFFF99',
                                                            ])
                                                            ?>
                                        </div>
                                </div>
                                <?php } ?>
                                <?php if ($view == 'view') { ?>
                                <div class="form-group">
                                    <label class="col-sm-1 control-label no-padding-right">หมายเหตุ</label>
                                        <div class="col-sm-3">
                                                            <?=
                                                            $form->field($modelST, 'STNote', ['showLabels' => false])->textarea([
                                                                'rows' => 3,
                                                                'style' => 'background-color:white',
                                                                'readonly'=> true,
                                                            ])
                                                            ?>
                                        </div>
                                </div>
                                <?php } ?>
                                <div class="form-group" style="text-align: right">
                                <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                                <?php if ($view == '') { ?>
                                    <a class="btn btn-danger" id="Clear" onclick="Clear();">Clear</a>
                                    <button class="btn btn-success" type="submit">Save Draft</button>
                                    <a class="btn btn-info" id="Stock" onclick="Stock();">Stock Issue</a>
                                <?php } ?>
                                </div>
                                 <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'getdatavendor',
                    'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                    'size' => 'modal-lg modal-primary',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
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
                    'closeButton' => FALSE,
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
        <!--JS-->
        <?php if ($view == '') { ?>
            <?php
            $script = <<< JS
$(document).ready(function () {
	$('#Stock').addClass("disabled", "disabled");
   	$('#checkVendername,#checkDuedate').html('<font color="red">*</font>');
});
$('#tbst2temp-stperson').click(function (e) {
        
        wait();
        $.ajax({
            url: 'getdata-vendor',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#home').waitMe('hide')
                $('#getdatavendor').modal('show');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกผู้จำหน่าย');
                $('#getdatavendortable').DataTable({
                       "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                });
            }
      });
 });                    
$('#getvwitemlisttpu').click(function (e) {
                var checkstk = $("#tbst2temp-stissue_stkid").val();
                var stk = $("#tbst2temp-stissue_stkid").val();
                if(checkstk==''||checkstk == '0'){
                	swal ("กรุณาเลือกคลังสินค้า","","warning");
                }else{
                wait();
                $.ajax({
                    url: 'getdata-tpu',
                    type: 'GET',
                    data:{stk:stk},
                    dataType: 'json',
                    success: function (data) {
                            $('#home').waitMe('hide')
                            $('#getdatavendor').find('.modal-body').html(data);
                            $('#datavendor').html(data);
                            $('.modal-title').html('เลือกรายการยาการค้า');
                            $('#getdatavendor').modal('show');
                            $('#detailgrdonatetpu').DataTable({
                              "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                            });
                    }
            });
                }
                
});
$('#getvwitemlistnd').click(function (e) {
        var checkstk = $("#tbst2temp-stissue_stkid").val();
        var stk = $("#tbst2temp-stissue_stkid").val();
        if(checkstk==''||checkstk == '0'){
            swal ("กรุณาเลือกคลังสินค้า","","warning");
        }else{
        wait();
        $.ajax({
            url: 'getdata-nd',
            type: 'GET',
            data:{stk:stk},
            dataType: 'json',
            success: function (data) {
                $('#home').waitMe('hide')
                $('#getdatavendor').modal('show');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกรายการเวชภัณฑ์');
                $('#detailgrdonatend').DataTable({
                   "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                });
            }
        });
    	}
    });
//init_click_handlers(); //first run
//$('#gr_donate_detail').on('pjax:success', function () {
//    init_click_handlers(); //reactivate links in grid after pjax update
//});
$('#formlend').on('beforeSubmit', function(e)
    {
     wait();
     var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result != null)
            {
            //$(\$form).trigger('reset');
                    $('#tbst2temp-stnum').val(result);
                    $('#Stock').removeClass('disabled');
                    $('#home').waitMe('hide');
                    swal("SaveDraft","", "success");
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
function init_click_handlers() {
$('.activity-edit-link').click(function (e) {
                        var ids = $(this).attr("data-id");
                        var stkid = $("#tbst2temp-stissue_stkid").val();
                        run_waitMe();
                        $.get(
                                'edit-lotnumber',
                                {
                                    ids: ids, stkid: stkid
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                            } else {
                                //$('#form_detail').trigger('reset');
                                $('#form_update_adjust').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('กำหนดจำนวน');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
});
$('.activity-delete-link').click(function (e) {
            var ids = $(this).closest('tr').data('key');
            wait();
            swal({   
                title: "Are you sure?",   
                //text: "You will not be able to recover this imaginary file!",   
                type: "error",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "OK",   
                closeOnConfirm: false
            },function(){
                    $.post(
                            'delete-detail',
                            {
                                ids: ids
                            },
                    function (data)
                    {
                        $('#home').waitMe('hide');
                        swal("Success","", "success");
                        $.pjax.reload({container: '#st_detail'});
                    }
                    );
            });
            $('#home').waitMe('hide');
});
}    
init_click_handlers(); //first run
    $('#st_detail').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
}); 
function wait(){
         var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#home').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                    onClose: function () {}
                    });
                }
    }          
JS;
        $this->registerJs($script);
       ?>
        <script>
            function wait(){
                var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                $('#home').waitMe({
                effect: 'ios',
                text: 'กำลังโหลดข้อมูล...',
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                sizeW: '',
                sizeH: '',
                source: '',
                onClose: function () {}
                });
                }
             }
            function run_waitMe() {
                        $('#modaledit > div').waitMe({
                            effect: 'ios',
                            text: 'กำลังโหลดข้อมูล...',
                            bg: 'rgba(255,255,255,0.7)',
                            color: '#000',
                            onClose: function () {
                            }
                        });
            }
            function GetnameVendor(id) {
                        $.ajax({
                            url: "getname-vendor",
                            type: "post",
                            data: {id: id},
                            dataType: "JSON",
                            success: function (d) {
                                $("#tbst2temp-stperson").val(d.VendorID);
                                $("#tbst2temp-vendername").val(d.VenderName);
                                $('#getdatavendor').modal('hide');
                            }
                        });
            }
            function AddNewItemdetailtpu(ItemID) {
                        var stkid = $("#tbst2temp-stissue_stkid").val();
                        var STID = $("#tbst2temp-stid").val();
                        var STNum = $("#tbst2temp-stnum").val();
                        var ItemType = 'ND';
                        run_waitMe();
                        $.get(
                                'add-new-itemdetailtpu',
                                {
                                    ItemID: ItemID, STID: STID, ItemType: ItemType, stkid:stkid, STNum:STNum
                                },
                        function (data)
                        {
                            if (data == 'false') {
                               swal("รายการนี้ถูกบันทึกแล้ว","", "warning");
                            } else {
                                $('#form_detail').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('เลือก Lot Number');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
                    }
                    function AddNewItemdetailND(ItemID) {
                        var stkid = $("#tbst2temp-stissue_stkid").val();
                        var STID = $("#tbst2temp-stid").val();
                        var STNum = $("#tbst2temp-stnum").val();
                        var ItemType = 'ND';
                        run_waitMe();
                        $.get(
                                'add-new-itemdetailtpu',
                                {
                                    ItemID: ItemID, STID: STID, ItemType: ItemType, stkid:stkid, STNum:STNum
                                },
                        function (data)
                        {
                            if (data == 'false') {
                               swal("รายการนี้ถูกบันทึกแล้ว","", "warning");
                            } else {
                                $('#form_detail').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('เลือก Lot Number');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
                    }
                    function Stock(){
                        
                        var STID = $("#tbst2temp-stid").val();
                        swal({   
                            title: "Stock Issue?",   
                            //text: "You will not be able to recover this imaginary file!",   
                            type: "warning",   
                            showCancelButton: true,   
                            confirmButtonColor: "#53a93f",   
                            confirmButtonText: "OK",   
                            closeOnConfirm: true
                        },function(){
                        		wait();
                                $.post(
                                        'stock-issue',
                                        {
                                            STID: STID
                                        },
                                function (data)
                                {
                                    $('#home').waitMe('hide');
                                }
                                );
                        });
                        
                    }
                    function Clear(){
                        var STID = $("#tbst2temp-stid").val();
                       // alert (STID);
                        $.post(
                                        'clear',
                                        {
                                            STID: STID
                                        },
                                function (data)
                                {

                                }
                        );
                    }
                    
    </script>
          
<?php } ?>
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => kartik\widgets\Growl::TYPE_SUCCESS,
                'title' => 'Well done!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => 'Save successfully.',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
            ?>
<?php endforeach; ?>