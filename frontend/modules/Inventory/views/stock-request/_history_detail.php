<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStk;
use app\modules\Inventory\models\Tbsrtype;
use app\models\TbDepartment;
use kartik\depdrop\DepDrop;
use yii\jui\DatePicker;
use app\modules\Inventory\models\Tbsrstatus;
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
?>
<?php
$this->title = 'ประวัติขอเบิก';
$this->params['breadcrumbs'][] = ['label' => 'เบิก โอน จ่าย', 'url' => ['history']];
$this->params['breadcrumbs'][] = $this->title;
?>
<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title); ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">

        <!--<div class="tbsr2-form">-->
        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNum')->textInput(['disabled' => 'disabled']) ?>
                    <?php
                    echo $form->field($model, 'SRReceive_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'SRTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrtype::find()->all(), 'SRTypeID', 'SRType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                    <?php
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-department',
                        'prompt' => 'เลือกฝ่าย',
                        'disabled' => 'disabled'
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'ddl-section'],
                        'data' => [$section],
                        'disabled' => 'disabled',
                        'pluginOptions' => [
                            'depends' => ['ddl-department'],
                            //  'placeholder' => 'เลือกอำเภอ...',
                            'url' => Yii::$app->request->baseUrl . '/km4/Purchasing/tbpcplan/getsection'
                        ]
                    ]);
                    ?>
                    <?php
                    echo
                    $form->field($model, 'SRDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                    <?php
                    echo $form->field($model, 'SRIssue_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'disabled' => 'disabled'
                        ],
                    ]);
                    ?>

                    <?php
                    echo $form->field($model, 'SRStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrstatus::find()->all(), 'SRStatusID', 'SRStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                </div>
                <!--                 <div style="text-align:left">
                                     <h5 class="row-title before-success">รายละเอียดใบขอเบิก</h5>   
                                    </div>-->
                <div style="margin: 20px">


                    <br>
                    <?php if (!empty($searchModel)) { ?>

                        <div class="form-group">
                            <?php \yii\widgets\Pjax::begin(['id' => 'sr2_detail_']) ?>
                            <?=
                            kartik\grid\GridView::widget([
                                'dataProvider' => $dataProvider,
                                'bootstrap' => true,
                                'showPageSummary' => true,
                                'responsiveWrap' => FALSE,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => Yii::$app->componentdate->layoutgridview2(),
                                'filterPosition' => \kartik\grid\GridView::FILTER_POS_BODY,
                                'tableOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
                                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                'columns' => [
                                        [
                                        'header' => '<a>#</a>',
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'headerOptions' => ['class' => 'kartik-sheet-style',]
                                    ],
                                        [
                                        'headerOptions' => ['style' => 'text-align:center;'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                            if ($model['ItemID'] != null) {
                                                return $model['ItemID'];
                                            } else {
                                                return '-';
                                            }
                                        }
                                    ],
                                        [
                                        'headerOptions' => ['style' => 'text-align:center;'],
                                        'attribute' => 'ItemName',
                                        'value' => function ($model) {
                                            if ($model->sr2detail->ItemDetail == NULL) {
                                                return '-';
                                            } else {
                                                return $model->sr2detail->ItemDetail;
                                            }
                                        }
                                    ],
                                        [
                                        'header' => '<a>ขอเบิก</a>',
                                        'width' => '90px',
                                        'headerOptions' => ['style' => 'text-align:center;background-color:#fcf8e3;', 'colspan' => '2'],
                                        'options' => ['style' => 'background-color:#fcf8e3;'],
                                        'attribute' => 'SRPackQty',
                                        'format' => ['decimal', 2],
                                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                            if ($model->sr2detail['SRQty'] == NULL) {
                                                return '0.00';
                                            } else {
                                                return $model->sr2detail->SRQty;
                                            }
                                        }
                                    ],
                                        [
                                        'header' => '<a>อนุมัติ</a>',
                                        'width' => '90px',
                                        'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                        'attribute' => 'SRItemOrderQty',
                                        'headerOptions' => ['style' => 'text-align:center;background-color:rgb(217, 237, 247);', 'colspan' => '2'],
                                        'options' => ['style' => 'background-color:#fcf8e3;'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                            if ($model->sr2detail['DispUnit'] == NULL) {
                                                return '-';
                                            } else {
                                                return $model->sr2detail->DispUnit;
                                            }
                                        }
                                    ],
                                        [
                                        'headerOptions' => ['hidden' => true],
                                        'width' => '90px',
                                        'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                        'attribute' => 'SRPackQtyApprove',
                                        'format' => ['decimal', 2],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                            if ($model->sr2detail['SRApproveQty'] == NULL) {
                                                return '0.00';
                                            } else {
                                                return $model->sr2detail->SRApproveQty;
                                            }
                                        }
                                    ],
                                        [
                                        'headerOptions' => ['hidden' => true],
                                        'attribute' => 'SRItemOrderQty',
                                        'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                        'width' => '90px',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                            if ($model->sr2detail['DispUnit'] == NULL) {
                                                return '-';
                                            } else {
                                                return $model->sr2detail->DispUnit;
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
                                                        [1, 2],
                                                        [6, 7]
                                                ], // columns to merge in summary
                                                'content' => [// content to show in each summary cell
                                                    1 => '',
                                                    3 => '<font color="black">จำนวน</font>',
                                                    4 => '<font color="black">หน่วย</font>',
                                                    5 => '<font color="black">จำนวน</font>',
                                                    6 => '<font color="black">หน่วย</font>',
                                                ],
                                                'contentOptions' => [// content html attributes for each summary cell
                                                    0 => ['style' => 'background-color:#dff0d8'],
                                                    1 => ['style' => 'background-color:#dff0d8'],
                                                    3 => ['style' => 'text-align:center;background-color:#fcf8e3'],
                                                    4 => ['style' => 'text-align:center;background-color:#fcf8e3'],
                                                    5 => ['style' => 'text-align:center;background-color:rgb(217, 237, 247)'],
                                                    6 => ['style' => 'text-align:center;background-color:rgb(217, 237, 247)'],
                                                    7 => ['style' => 'background-color:#dff0d8']
                                                ],
                                                // html attributes for group summary row
                                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                                            ];
                                        }
                                    ],
                                ],
                            ]);
                            ?>
                            <?php \yii\widgets\Pjax::end() ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNote')->textArea(['maxlength' => true, 'rows' => '4', 'disabled' => 'disabled']) ?>
                </div>
                <div class="col-sm-12" style="text-align: right;">
                    <?php if ($type == 'index') { ?>
                        <a href="/km4/Inventory/stock-request/wait-approve" class="btn btn-default">Close</a>
                    <?php } else if ($type == 'waitsale') { ?>
                        <a href="/km4/Inventory/stock-request/wait-sale" class="btn btn-default">Close</a>
                    <?php } else if ($type == 'waitreceive') { ?>
                        <a href="/km4/Inventory/stock-request/wait-receive" class="btn btn-default">Close</a>
                    <?php } else { ?>
                        <a href="/km4/Inventory/stock-request/history" class="btn btn-default">Close</a>
                    <?php } ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
