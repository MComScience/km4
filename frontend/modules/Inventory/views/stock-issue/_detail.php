<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\Tbstk;
use app\modules\Inventory\models\Tbsrtype;
use yii\jui\DatePicker;
use app\modules\Inventory\models\TbStstatus;
use kartik\grid\GridView;

$this->title = 'บันทึกใบรับสินค้า';
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
        <!--<div class="tb-st2-form">-->
        <div class="well">
            <?php $form = ActiveForm::begin(['id' => 'form_recive', 'layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'STNum')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>

                    <?php
                    echo $form->field($model, 'STRecieve_StkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'STTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrtype::find()->all(), 'SRTypeID', 'SRType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo
                    $form->field($model, 'STDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                        ],
                    ])
                    ?>
                    <?php
                    echo $form->field($model, 'STIssue_StkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'STStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStstatus::find()->all(), 'STStatusID', 'STStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php
                    echo
                    $form->field($model, 'STRecievedDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'value' => date('d-m-Y'),
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div style="margin: 20px">
                <br>
                <?php
                if (!empty($searchModel)) {
                    $ids = '';
                    ?>
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
                            'filterPosition' => \kartik\grid\GridView::FILTER_POS_BODY,
                            'tableOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd']
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'width' => '50px',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => 'index.php?r=Inventory/tbst2/ext-pen',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd'],
                                    'expandOneOnly' => true,
                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [

                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'attribute' => 'ItemName',
                                    'header' => 'รายการสินค้า',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => 'ขอเบิก',
                                    'width' => '150px',
                                    'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                    'attribute' => 'SRQty',
                                    'format' => ['decimal', 2],
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->SRQty == NULL) {
                                    return '0.00';
                                } else {
                                    return $model->SRQty;
                                }
                            }
                                ],
                                [
                                    'header' => '',
                                    'attribute' => 'SRUnit',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->SRUnit == NULL) {
                                    return '-';
                                } else {
                                    return $model->SRUnit;
                                }
                            }
                                ],
                                [
                                    'header' => 'อนุมัติ',
                                    'width' => '150px',
                                    'attribute' => 'STQty',
                                    'format' => ['decimal', 2],
                                    'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->STQty == NULL) {
                                    return '0.00';
                                } else {
                                    return $model->STQty;
                                }
                            }
                                ],
                                [
                                    'header' => '',
                                    'attribute' => 'SRUnit',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->SRUnit == NULL) {
                                    return '-';
                                } else {
                                    return $model->SRUnit;
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
                                                [7, 8]
                                            ], // columns to merge in summary
                                            'content' => [// content to show in each summary cell
                                                1 => '',
                                                4 => 'จำนวน',
                                                5 => 'หน่วย',
                                                6 => 'จำนวน',
                                                7 => 'หน่วย',
                                            ],
                                            'contentOptions' => [// content html attributes for each summary cell
                                                0 => ['style' => 'background-color: #ddd'],
                                                1 => ['style' => 'background-color: #ddd'],
                                                3 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                4 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                5 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                6 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                7 => ['style' => 'color:green;text-align:center;background-color: #ddd']
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
                        <?= $form->field($model, 'STNote')->textarea(['maxlength' => true, 'row' => 6]) ?>
                    </div>

                    <div style="text-align: right;margin-right: 10px">

                        <?php if ($status == '0') { ?>
                            <a class="btn btn-default" href="index.php?r=Inventory/stock-issue/stock-receive">Close</a>
                            <?php Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                            <a class="btn btn-primary" id="_stock_receive" href="#">Stock Receive</a>
                        <?php } else { ?>
                            <a class="btn btn-default" href="index.php?r=Inventory/stock-issue/stock-receive-history">Close</a>
                        <?php } ?>
                    </div>

                    <br>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php
        $s = <<< JS
    $('#_stock_receive').click(function (e) {
            var tbst2strecieveddate = $('#tbst2-strecieveddate').val();
                if(tbst2strecieveddate !== ""){
          $.ajax({
            url: 'index.php?r=Inventory/stock-issue/recive-data',
            type: 'POST',
            data:$("#form_recive").serialize(),
            success: function (data) {
              Notify('Saved Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
               window.location.replace("index.php?r=Inventory/stock-issue/stock-receive");
            }
      });
                }else{
               alert('วันที่รับเข้าสินค้า'); 
   }
    });
JS;
        $this->registerJs($s);
        ?>