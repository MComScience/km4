<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use app\models\TbPostatus;
use yii\helpers\ArrayHelper;
use app\models\TbPotype;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use yii\widgets\Pjax;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);

if ($view == 'false') {
    $this->title = 'อนุมัติใบสั่งซื้อ';
    $this->params['breadcrumbs'][] = ['label' => 'ผู้อำนวยการ', 'url' => ['detail-wating-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'wating-approve') {
    $this->title = 'ใบสั่งซื้อรอการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-wating-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['list-wating-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'reject-approve') {
    $this->title = 'ใบสั่งซื้อไม่ผ่านการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-reject-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['list-reject-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'approve') {
    $this->title = 'ใบสั่งซื้อผ่านการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['list-approve']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<style type="text/css">
    table.kv-grid-table thead tr th{
        white-space: nowrap;
    }
</style>
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
                        <div class="tb-po2-form">
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'form_update_detail_approve',
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
                                    $form->field($modelPO2, 'PONum')->textInput([
                                        'readonly' => true,
                                        'style' => 'background-color: white',
                                    ])->label('เลขที่ใบสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO2, 'PODate')->widget(DatePicker::classname(), [
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
                                    $form->field($modelPO2, 'POStatus')->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(TbPostatus::find()->all(), 'POStatusID', 'POStatusDes'),
                                        'language' => 'th',
                                        //'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])->label('สถานะใบสั่งซื้อ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO2, 'POID', ['showLabels' => false])->hiddenInput([
                                        'style' => 'background-color: white',
                                    ])
                                    ?>
                                </div>

                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelPO2, 'PRNum')->textInput([
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
                                    $form->field($modelPO2, 'VendorID')->textInput([
                                        'style' => 'background-color: white',
                                        'placeholder' => 'คลิกเพื่อเลือกผู้จำหน่าย...',
                                        'readonly' => true,
                                    ])->label('เลขที่ผู้จำหน่าย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label no-padding-right">ชื่อผู้จำหน่าย</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="id" id="VenderName" value="<?php echo $VendorName; ?>" readonly="" style="background-color: white" />
                                        </div>
                                    </div>

                                </div>

                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelPO2, 'POContID')->textInput([
                                        'style' => 'background-color: white',
                                        'readonly' => true,
                                    ])->label('เลขที่สัญญาซื้อขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO2, 'PODueDate')->widget(DatePicker::classname(), [
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
                                    ])->label('กำหนดการส่งมอบ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <?=
                                    $form->field($modelPO2, 'Menu_VendorID')->textInput([
                                        'style' => 'background-color: white',
                                        //'placeholder' => 'คลิกเพื่อเลือกผู้จำหน่าย...',
                                        'readonly' => true,
                                    ])->label('เลขที่ผู้ผลิต', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>

                                    <div class="form-group">
                                        <label class="col-xs-4 control-label no-padding-right">ชื่อผู้ผลิต</label>
                                        <div class="col-xs-8">
                                            <input type="text" class="form-control" name="id" id="VenderName" value="<?php echo $MenuVendorName; ?>" readonly="" style="background-color: white" />
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดใบสั่งซื้อ</h5>                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <?php Pjax::begin(['id' => 'detail_verify_po2_type1']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'responsiveWrap' => FALSE,
                                            'showPageSummary' => true,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => false,
                                            'condensed' => true,
                                            'toggleData' => false,
                                            'bordered' => FALSE,
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
                                                    'detailUrl' => \yii\helpers\Url::to(['view-detail-verify', 'prid' => $modelPR['PRID']]),
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
                                                    'label' => FALSE,
                                                    'noWrap' => TRUE,
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
                                                    'noWrap' => TRUE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        return empty($model->dataonview->PRUnitCost) ? '-' : number_format($model->dataonview->PRUnitCost, 4);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'PRUnit',
                                                    'label' => FALSE,
                                                    'noWrap' => TRUE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'POQty',
                                                    'label' => FALSE,
                                                    'noWrap' => TRUE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        return empty($model->dataonview->POQty) ? '-' : number_format($model->dataonview->POQty, 4);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'POUnitCost',
                                                    'header' => 'สั่งซื้อ',
                                                    'width' => '100px',
                                                    'noWrap' => TRUE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        return empty($model->dataonview->POUnitCost) ? '-' : number_format($model->dataonview->POUnitCost, 4);
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'POUnit',
                                                    'label' => FALSE,
                                                    'noWrap' => TRUE,
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                        return empty($model->dataonview->POUnit) ? '-' : $model->dataonview->POUnit;
                                                    }
                                                ],
                                                    [
                                                    'attribute' => 'POExtenedCost',
                                                    'header' => 'ราคารวม',
                                                    'noWrap' => TRUE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'format' => ['decimal', 4],
                                                    'pageSummary' => true,
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
                                                    'template' => '{edit}',
                                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                                    'pageSummary' => 'บาท',
                                                    'buttons' => [
                                                        'edit' => function ($url, $model) {
                                                            if ($model->dataonview->POQty == $model->ChkReceived($model['ids'])) {
                                                                return '<span class="label label-success">รับครบแล้ว!</span>';
                                                            } else {
                                                                return Html::a('Edit', '#', [
                                                                            'title' => 'Edit',
                                                                            'data-toggle' => 'modal',
                                                                            'class' => 'btn btn-primary btn-xs activity-edit-link',
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
                                                                    [0, 2],
                                                                    [10, 12]
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
                            <br>
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดรายการยาแถม</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group" >
                                        <p>
                                            <a  class="btn btn-success" id="get_vw_itemtpu_to_podetail"><i class="glyphicon glyphicon-plus"></i>เลือกรายการยาการค้า</a>
                                            <a  class="btn btn-success" id="get_vw_itemnd_to_podetail"><i class="glyphicon glyphicon-plus"></i>เลือกรายการเวชภัณฑ์</a>
                                        <p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php Pjax::begin(['id' => 'detail_verify_po2_type2']) ?>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $postProvider,
                                    'responsiveWrap' => FALSE,
                                    'showPageSummary' => FALSE,
                                    'hover' => true,
                                    'pjax' => true,
                                    'striped' => FALSE,
                                    'condensed' => true,
                                    'bordered' => FALSE,
                                    'toggleData' => false,
                                    'pageSummaryRowOptions' => ['class' => 'default'],
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
                                            'label' => FALSE,
                                            'noWrap' => TRUE,
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
                                            'noWrap' => TRUE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                                return empty($model->dataonview->PRUnitCost) ? '-' : number_format($model->dataonview->PRUnitCost, 4);
                                            }
                                        ],
                                            [
                                            'attribute' => 'PRUnit',
                                            'label' => FALSE,
                                            'noWrap' => TRUE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                                return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                            }
                                        ],
                                            [
                                            'attribute' => 'POQty',
                                            'label' => FALSE,
                                            'noWrap' => TRUE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                                return empty($model->dataonview->POQty) ? '-' : number_format($model->dataonview->POQty, 4);
                                            }
                                        ],
                                            [
                                            'attribute' => 'POUnitCost',
                                            'header' => 'สั่งซื้อ',
                                            'width' => '100px',
                                            'noWrap' => TRUE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                                return empty($model->dataonview->POUnitCost) ? '-' : number_format($model->dataonview->POUnitCost, 4);
                                            }
                                        ],
                                            [
                                            'attribute' => 'POUnit',
                                            'label' => FALSE,
                                            'noWrap' => TRUE,
                                            'width' => '100px',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'pageSummary' => 'รวมเป็นเงิน',
                                            'value' => function ($model) {
                                                return empty($model->dataonview->POUnit) ? '-' : $model->dataonview->POUnit;
                                            }
                                        ],
                                            [
                                            'attribute' => 'POExtenedCost',
                                            'header' => 'ราคารวม',
                                            'noWrap' => TRUE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'format' => ['decimal', 4],
                                            'pageSummary' => true,
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
                                            'template' => ' {editgpu} {delete}',
                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                            'buttons' => [
                                                'editgpu' => function ($url, $model) {
                                                    return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', '#', [
                                                                'title' => 'Edit',
                                                                'data-toggle' => 'modal',
                                                                'class' => 'activity-edit-type2',
                                                    ]);
                                                },
                                                'delete' => function ($url, $model) {
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
                                                            [9, 11]
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
                                                        9 => ['style' => 'background-color: #ddd;color:black'],
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
                                <br/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="text-align: right">

                        <?php if ($view == 'false') { ?>
                            <?= Html::a('Close', ['detail-wating-approve'], ['class' => 'btn btn-default']) ?>
                            <a class="btn btn-warning" id="RejectApprove">Reject</a>
                            <a class="btn btn-success" id="ApprovePO">Approve</a>
                        <?php } elseif ($view == 'wating-approve') { ?>
                            <?= Html::a('Close', ['list-wating-approve'], ['class' => 'btn btn-default']) ?>
                        <?php } elseif ($view == 'reject-approve') { ?>
                            <?= Html::a('Close', ['list-reject-approve'], ['class' => 'btn btn-default']) ?>
                        <?php } elseif ($view == 'approve') { ?>
                            <?= Html::a('Close', ['list-approve'], ['class' => 'btn btn-default']) ?>
                        <?php } ?>
                        <?= Html::a('ยกเลิกใบสั่งซื้อ', false, ['class' => 'btn btn-warning', 'onclick' => 'CancelPO(this);']) ?>
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
    'header' => '<h4 class="modal-title"></h4>',
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
    'id' => 'Reject_Approve',
    'size' => 'modal-dialog modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
    'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Approve</h4></font>',
    //'headerOptions' => ['class' => 'bg-azure'],
    'footer' => '<div class="col-xs-9 col-xs-offset-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="SaveRejectApprove" class="btn btn-warning ladda-button" data-style="expand-left">Rejected Approve</button>
                </div>',
]);
?>
<div class="row">
    <div class="col-xs-12">
        <textarea type="text" class="form-control" id="PORejfromAppNote" name="PORejfromAppNote" cols="100" rows="5" cols="10" style="background-color: #ffff99;"></textarea>
    </div>
</div>

<?php
Modal::end();
?>
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
//GetTPU
$('#get_vw_itemtpu_to_podetail').click(function (e) {
    LoadingClass();
    $.ajax({
        url: 'getdata-tpu',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#getdatavendor').find('.modal-body').html(data);
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
$('#SaveRejectApprove').click(function (e) {
    var POID = $("#tbpo2-poid").val();
    var PORejfromAppNote = $("#PORejfromAppNote").val();
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    if (PORejfromAppNote == "") {
        swal({
            title: "",
            text: "กรุณากรอกเหตุผล!",
            type: "warning",
            showCancelButton: false,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        l.ladda('stop');
                    }
                });
    } else {
        $.post(
                'rejected-approve',
                {
                    POID: POID, PORejfromAppNote: PORejfromAppNote
                },
        function (data)
        {

        }
        );
    }
}); 
//Approve
$('#ApprovePO').click(function (e) {
    var POID = $("#tbpo2-poid").val();
    swal({
        title: "ยืนยันการอนุมัติใบสั่งซื้อ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        //confirmButtonColor: "#DD6B55",
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'approve',
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
//Reject Approve
$('#RejectApprove').click(function (e) {
    $('#Reject_Approve').modal('show');
});
function init_click_handlers() {
//แก้ไขข้อมูล
    $('.activity-edit-link').click(function (e) {
    var ids = $(this).closest('tr').data('key');
            LoadingClass();
            $.get(
                    'editpo-detail-approve',
            {
            ids: ids
            },
                    function (data)
                    {
                            $('#form_edit_po_detail_verify1').trigger('reset');
                            $('#modaledit').find('.modal-body').html(data);
                            $('#datamodaledit').html(data);
                            $('.modal-title').html('แก้ไขรายการใบสั่งซื้อ');
                            $('.page-content').waitMe('hide');
                            $('#modaledit').modal('show');
                    }
            );
    });
//แก้ไขข้อมูล type2
    $('.activity-edit-type2').click(function (e) {
        var ids = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'editpo-detail-verifytype2',
                {
                    ids: ids
                },
        function (data)
        {
            $('#form_edit_po_detail_verify2').trigger('reset');
            $('#modaledit').find('.modal-body').html(data);
            $('#datamodaledit').html(data);
            $('.modal-title').html('แก้ไขรายการใบสั่งซื้อ');
            $('.page-content').waitMe('hide');
            $('#modaledit').modal('show');
        }
        );
    });
//Delete
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
                            'delete-detail-verify',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#detail_verify_po2_type2'});
                    }
                    );
                }
            });
});
//OK
    $('.activity-ok-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
    swal({
        title: "Are you sure ok verify",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: false,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'ok-verify',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#detail_verify_po2_type1'});
                        swal("OK Complete!", "", "success");
                        $('#Verify').removeClass("disabled", "disabled");
                    }
                    );
                }
            });
});
 }
init_click_handlers(); //first run
    $('#detail_verify_po2_type1').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
    $('#detail_verify_po2_type2').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
JS;
$this->registerJs($script);
?>
<script type="text/javascript">
    function AddNewItemdetailtpu(ItemID) {
        var POID = $("#tbpo2-poid").val();
        var ItemType = 'TPU';
        LoadingClass();
        $.get(
                'additem-detailtpu',
                {
                    ItemID: ItemID, POID: POID, ItemType: ItemType
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
                        $('#form_edit_po_detail_verify2').trigger('reset');
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
        var POID = $("#tbpo2-poid").val();
        var ItemType = 'ND';
        LoadingClass();
        $.get(
                'additem-detailtpu',
                {
                    ItemID: ItemID, POID: POID, ItemType: ItemType
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
                        $('#form_edit_po_detail_verify2').trigger('reset');
                        $('#modaledit').find('.modal-body').html(data);
                        $('#datamodaledit').html(data);
                        $('.modal-title').html('บันทึกสินค้าแถม');
                        $('.page-content').waitMe('hide');
                        $('#modaledit').modal('show');
                    }

                }
        );
    }
    //Loading
    function LoadingClass() {
        $('.page-content').waitMe({
            effect: 'ios', //roundBounce
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }

    function CancelPO() {
        var PONum = $('#tbpo2-ponum').val();
        var POID = $('#tbpo2-poid').val();
        swal({
            title: "Are you sure cancel?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'cancel-po',
                                {
                                    PONum: PONum, POID: POID
                                },
                                function (result)
                                {
                                    if (result === 'false') {
                                        swal("ไม่สามารถยกเลิกได้!", "ใบสั่งซื้อเลขที่ " + PONum + " มีการรับสินค้าไปแล้ว!", "error");
                                    } else {
                                        window.location.replace("list-approve");
                                    }
                                }
                        ).fail(function (xhr, status, error) {
                            swal("Oops!", error, "error");
                        });
                    }
                });
    }
</script>