<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use fedemotta\datatables\DataTables;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\modules\drugorder\models\Tbcpoescheduletype;
use app\models\TbSection;
use app\modules\drugorder\models\Tbcpoestatus;
use yii\bootstrap\Modal;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<style>
    table#datatables_w2 thead tr th{
        background-color: white;
        text-align: center;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php if ($type == 1) { ?>
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="cpoe_num" class="col-sm-2 control-label no-padding-right">หมายเลขชองยา</label>
                    <div class="col-sm-3">
                        <input type="text" id="cpoe_num" onkeypress="return runScript(event)" class="form-control" >
                    </div>
                </div>
            </div>
        <?php } else if ($type == 3) { ?>
            <div class="form-horizontal">
                <div class="form-group">
                    <label for="cpoe_num" class="col-sm-2 control-label  no-padding-right">หมายเลขชองยา</label>
                    <div class="col-sm-3">
                        <input type="text" id="cpoe_num" onkeypress="return runScript2(event)" class="form-control" >
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'action' => Url::to(['save-cpoe']),
                    'id' => 'fromcpoe',
        ]);
        ?>
        <div class="form-group">

            <?= Html::activeLabel($model, 'cpoe_num', ['label' => 'ใบสั่งยา เลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'cpoe_num', ['showLabels' => false])->textInput(['readonly' => true]); ?>
            </div>

            <?= Html::activeLabel($model, 'pt_trp_chemo_id', ['label' => 'Treatment Plan No.', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'pt_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
            </div>

            <?= Html::activeLabel($model, 'chemo_cycle_seq', ['label' => 'Cycle', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'chemo_cycle_seq', ['showLabels' => false])->textInput(['readonly' => true]); ?>
            </div>
        </div>

        <div class="form-group">

            <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'วันที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?=
                $form->field($model, 'cpoe_date', ['showLabels' => false])->widget(DatePicker::classname(), [
                    'language' => 'th',
                    'dateFormat' => 'dd/MM/yyyy',
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'style' => 'background-color: #ffff99',
                        'disabled' => true
                    ],
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'pt_trp_regimen_name', ['label' => 'Regimen ', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'pt_trp_regimen_name', ['showLabels' => false])->textInput(['readonly' => true]); ?>
            </div>

            <?= Html::activeLabel($model, 'chemo_cycle_day', ['label' => 'Day', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
            <div class="col-sm-2">
                <?= $form->field($model, 'chemo_cycle_day', ['showLabels' => false])->textInput(['readonly' => true]); ?>
            </div>

        </div>

        <?php ActiveForm::end(); ?>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="well">

                    <?php Pjax::begin(['id' => 'pjax-tbcpoedetails']); ?>
                    <?php
                    // echo $this->render('_search', ['model' => $searchModel, 'id' => $model->cpoe_id]);
                    ?>
                    <?php
                    if ($type == 1) {
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'showPageSummary' => true,
                            'id' => 'table_list_drug',
                            'responsive' => true,
                            'layout' => $layout,
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'tableOptions' => [
                                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                            ],
                            'rowOptions' => function ($model) {
                        if ($model->cpoe_issueby != null) {
                            return ['class' => 'success'];
                        } else {
                            return [];
                        }
                    },
                            'columns' => [
                                [
                                    'class' => '\kartik\grid\SerialColumn',
                                    'width' => '25px',
                                ],
                                [
                                    'header' => 'cpoe_itemtype_decs',
                                    'attribute' => 'cpoe_itemtype_decs',
                                    'contentOptions' => ['class' => 'text-left'],
                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                            },
                                    'group' => true, // enable grouping,
                                    'groupedRow' => true, // move grouped column to a single grouped row
                                    'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                                ],
//                                [
//                                    'class' => 'kartik\grid\ExpandRowColumn',
//                                    'value' => function ($model, $key, $index, $column) {
//                                        return GridView::ROW_COLLAPSED;
//                                    },
//                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
//                                    'expandOneOnly' => true,
//                                    'detailAnimationDuration' => 'slow', //fast
//                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                                    'detailUrl' => Url::to(['rxdetails']),
//                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'attribute' => 'ItemID',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemID) ? '-' : $model->ItemID;
                            },
                                ],
                                [
                                    'header' => 'รายการ',
                                    'attribute' => 'ItemDetail',
                                    'headerOptions' => ['class' => 'text-center'],
                                    'contentOptions' => ['class' => 'text-left'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                            },
                                ],
                                [
                                    'header' => 'จำนวน',
                                    'attribute' => 'ItemQty1',
                                    'contentOptions' => ['class' => 'text-right'],
                                    'noWrap' => true,
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                            },
                                ],
                                [
                                    'header' => 'ราคา/หน่วย',
                                    'attribute' => 'ItemPrice',
                                    'contentOptions' => ['class' => 'text-right'],
                                    'noWrap' => true,
                                    'format' => ['decimal', 2],
                                    'pageSummary' => 'รวม',
                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->ItemPrice) ? '' : $model->ItemPrice;
                            },
                                ],
                                [
                                    'header' => 'จำนวนเงิน',
                                    'attribute' => 'Item_Amt',
                                    'contentOptions' => ['class' => 'text-right'],
                                    'noWrap' => true,
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->Item_Amt) ? '' : $model->Item_Amt ;
                            },
                                ],
                                [
                                    'header' => 'เบิกได้',
                                    'attribute' => 'Item_Cr_Amt_Sum',
                                    'contentOptions' => ['class' => 'text-right'],
                                    'noWrap' => true,
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                            },
                                ],
                                [
                                    'header' => 'เบิกไม่ได้',
                                    'attribute' => 'Item_Pay_Amt_Sum',
                                    'contentOptions' => ['class' => 'text-right'],
                                    'noWrap' => true,
                                    'format' => ['decimal', 2],
                                    'pageSummary' => true,
                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                    'value' => function($model, $key, $index) {
                                return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
                            },
                                ],
                                /*   [
                                  'header' => 'Request',
                                  'attribute' => 'Item_Amt',
                                  'format' => 'raw',

                                  'contentOptions' => ['class' => 'text-center','id'=>'request'],
                                  'value'=>function ($model,$key) {
                                  return '<div class="checkbox"><label><input type="checkbox" name="selected[]" value="'.$key.'"><span class="text"></span></label></div>';
                                  },
                                  ], */
                                [
                                    'class' => '\kartik\grid\ActionColumn',
                                    //'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8',],
                                    'header' => 'Actions',
                                    // 'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{issue} {notespayable}',
                                    'noWrap' => true,
                                    'buttons' => [

                                        'issue' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-warning btn-xs btn-group"> Adjust Request </span>', 'javascript:void(0)', [
                                                        'title' => Yii::t('app', 'ISSU'),
                                                        'data-toggle' => 'modal_cpoenote',
                                                        'data-id' => $key,
                                                        'onclick' => 'showorderadjast(' . $key . ')'
                                            ]);
                                        },
                                                'notespayable' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-warning btn-xs btn-group">บันทึกค้างจ่าย</span>', 'javascript:void(0)', [
                                                        'title' => Yii::t('app', 'ISSU'),
                                                        'data-toggle' => 'modal_cpoenote',
                                                        'data-id' => $key,
                                                        'onclick' => 'showorderadjast(' . $key . ')'
                                            ]);
                                        },
                                            ],
                                        ],
                                    ],
                                ]);
                            } else if ($type == 2) {
                                echo GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'showPageSummary' => true,
                                    'id' => 'table_list_drug',
                                    'responsive' => true,
                                    'layout' => $layout,
                                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                    'tableOptions' => [
                                        'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                                    ],
                                    /*   'rowOptions' => function ($model){
                                      if($model->cpoe_issueby != null){
                                      return ['class' => 'success'];
                                      }else{
                                      return [];
                                      }
                                      }, */
                                    'columns' => [
                                        [
                                            'class' => '\kartik\grid\SerialColumn',
                                            'width' => '25px',
                                        ],
                                        [
                                            'header' => 'cpoe_itemtype_decs',
                                            'attribute' => 'cpoe_itemtype_decs',
                                            'contentOptions' => ['class' => 'text-left'],
                                            'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                                    },
                                            'group' => true, // enable grouping,
                                            'groupedRow' => true, // move grouped column to a single grouped row
                                            'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                                            'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                                        ],
//                                        [
//                                            'class' => 'kartik\grid\ExpandRowColumn',
//                                            'value' => function ($model, $key, $index, $column) {
//                                                return GridView::ROW_COLLAPSED;
//                                            },
//                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
//                                            'expandOneOnly' => true,
//                                            'detailAnimationDuration' => 'slow', //fast
//                                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                                            'detailUrl' => Url::to(['rxdetails']),
//                                        ],
                                        [
                                            'header' => 'รหัสสินค้า',
                                            'attribute' => 'ItemID',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemID) ? '-' : $model->ItemID;
                                    },
                                        ],
                                        [
                                            'header' => 'รายการ',
                                            'attribute' => 'ItemDetail',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-left'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                                    },
                                        ],
                                        [
                                            'header' => 'จำนวน',
                                            'attribute' => 'ItemQty1',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'noWrap' => true,
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                                    },
                                        ],
                                        [
                                            'header' => 'ราคา/หน่วย',
                                            'attribute' => 'ItemPrice',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'noWrap' => true,
                                            'pageSummary' => 'รวม',
                                            'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->ItemPrice) ? '-' : number_format($model->ItemPrice, 2);
                                    },
                                        ],
                                        [
                                            'header' => 'จำนวนเงิน',
                                            'attribute' => 'Item_Amt',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'noWrap' => true,
                                            'pageSummary' => true,
                                            'format' => ['decimal', 2],
                                            'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                                    },
                                        ],
                                        [
                                            'header' => 'เบิกได้',
                                            'attribute' => 'Item_Cr_Amt_Sum',
                                            'contentOptions' => ['class' => 'text-right'],
                                            'noWrap' => true,
                                            'pageSummary' => true,
                                            'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->Item_Cr_Amt_Sum) ? '-' : $model->Item_Cr_Amt_Sum;
                                    },
                                        ],
                                        [
                                            'header' => 'เบิกไม่ได้',
                                            'attribute' => 'Item_Pay_Amt_Sum',
                                            'contentOptions' => ['class' => 'text-center'],
                                            'noWrap' => true,
                                            'pageSummary' => true,
                                            'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                            'value' => function($model, $key, $index) {
                                        return empty($model->Item_Pay_Amt_Sum) ? '-' : $model->Item_Pay_Amt_Sum;
                                    },
                                        ],
                                        [
                                            'class' => '\kartik\grid\ActionColumn',
                                            'headerOptions' => ['style' => 'text-align:center;'],
                                            'header' => 'Actions',
                                            'noWrap' => true,
                                            'template' => '{ok} {issue}',
                                            'buttons' => [
                                                'ok' => function ($url, $model, $key) {
                                                    if ($model->cpoe_ItemStatus == 2) {
                                                        $dis = 'disabled';
                                                    } else {
                                                        $dis = '';
                                                    }
                                                    return Html::a('<span class="btn btn-success ' . $dis . ' btn-xs btn-group">OK</span>', 'javascript:void(0)', [
                                                                'title' => Yii::t('app', 'ok'),
                                                                'data-toggle' => 'modal_cpoenote',
                                                                'data-id' => $key,
                                                                'onclick' => 'confirmOk(' . $key . ')'
                                                    ]);
                                                },
                                                        'issue' => function ($url, $model, $key) {
                                                    return Html::a('<span class="btn btn-warning btn-xs btn-group"> Adjust Request </span>', 'javascript:void(0)', [
                                                                'title' => Yii::t('app', 'ISSU'),
                                                                'data-toggle' => 'modal_cpoenote',
                                                                'data-id' => $key,
                                                                'onclick' => 'showorderadjast(' . $key . ')'
                                                    ]);
                                                },
                                                    ],
                                                ],
                                            ],
                                        ]);
                                    } else if ($type == 3) {
                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'showPageSummary' => true,
                                            'id' => 'table_list_drug',
                                            'responsive' => true,
                                            'layout' => $layout,
                                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                            'tableOptions' => [
                                                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                                            ],
                                            'rowOptions' => function ($model) {
                                        if ($model->cpoe_checkby != null) {
                                            return ['class' => 'success'];
                                        } else {
                                            return [];
                                        }
                                    },
                                            'columns' => [
                                                [
                                                    'class' => '\kartik\grid\SerialColumn',
                                                    'width' => '25px',
                                                ],
//                                                [
//                                                    'class' => 'kartik\grid\ExpandRowColumn',
//                                                    'value' => function ($model, $key, $index, $column) {
//                                                        return GridView::ROW_COLLAPSED;
//                                                    },
//                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
//                                                    'expandOneOnly' => true,
//                                                    'detailAnimationDuration' => 'slow', //fast
//                                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                                                    'detailUrl' => Url::to(['rxdetails']),
//                                                ],
                                                [
                                                    'header' => 'cpoe_itemtype_decs',
                                                    'attribute' => 'cpoe_itemtype_decs',
                                                    'contentOptions' => ['class' => 'text-left'],
                                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                                            },
                                                    'group' => true, // enable grouping,
                                                    'groupedRow' => true, // move grouped column to a single grouped row
                                                    'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                                                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                                                ],
                                                [
                                                    'header' => 'รหัสสินค้า',
                                                    'attribute' => 'ItemID',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'contentOptions' => ['class' => 'text-center'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->ItemID) ? '-' : $model->ItemID;
                                            },
                                                ],
                                                [
                                                    'header' => 'รายการ',
                                                    'attribute' => 'ItemDetail',
                                                    'headerOptions' => ['class' => 'text-center'],
                                                    'contentOptions' => ['class' => 'text-left'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                                            },
                                                ],
                                                [
                                                    'header' => 'จำนวน',
                                                    'attribute' => 'ItemQty1',
                                                    'contentOptions' => ['class' => 'text-right'],
                                                    'noWrap' => true,
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                                            },
                                                ],
                                                [
                                                    'header' => 'ราคา/หน่วย',
                                                    'attribute' => 'ItemPrice',
                                                    'contentOptions' => ['class' => 'text-right'],
                                                    'noWrap' => true,
                                                    'pageSummary' => 'รวม',
                                                    'format' => ['decimal', 2],
                                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->ItemPrice) ? '' : $model->ItemPrice;
                                            },
                                                ],
                                                [
                                                    'header' => 'จำนวนเงิน',
                                                    'attribute' => 'Item_Amt',
                                                    'contentOptions' => ['class' => 'text-right'],
                                                    'noWrap' => true,
                                                    'pageSummary' => TRUE,
                                                    'format' => ['decimal', 2],
                                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                                            },
                                                ],
                                                [
                                                    'header' => 'เบิกได้',
                                                    'attribute' => 'Item_Cr_Amt_Sum',
                                                    'contentOptions' => ['class' => 'text-right'],
                                                    'noWrap' => true,
                                                    'pageSummary' => TRUE,
                                                    'format' => ['decimal', 2],
                                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                                            },
                                                ],
                                                [
                                                    'header' => 'เบิกไม่ได้',
                                                    'attribute' => 'Item_Pay_Amt_Sum',
                                                    'contentOptions' => ['class' => 'text-right'],
                                                    'noWrap' => true,
                                                    'pageSummary' => true,
                                                    'format' => ['decimal', 2],
                                                    'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                                    'value' => function($model, $key, $index) {
                                                return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
                                            },
                                                ],
                                                /*   [
                                                  'header' => 'Request',
                                                  'attribute' => 'Item_Amt',
                                                  'format' => 'raw',

                                                  'contentOptions' => ['class' => 'text-center','id'=>'request'],
                                                  'value'=>function ($model,$key) {
                                                  return '<div class="checkbox"><label><input type="checkbox" name="selected[]" value="'.$key.'"><span class="text"></span></label></div>';
                                                  },
                                                  ], */
                                                [
                                                    'class' => '\kartik\grid\ActionColumn',
                                                    //'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8',],
                                                    'header' => 'Actions',
                                                    'noWrap' => true,
                                                    // 'contentOptions' => ['class' => 'text-center'],
                                                    'template' => '{issue}',
                                                    'buttons' => [

                                                        'issue' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-warning btn-xs btn-group"> Adjust Request </span>', 'javascript:void(0)', [
                                                                        'title' => Yii::t('app', 'ISSU'),
                                                                        'data-toggle' => 'modal_cpoenote',
                                                                        'data-id' => $key,
                                                                        'onclick' => 'showorderadjast(' . $key . ')'
                                                            ]);
                                                        },
                                                            ],
                                                        ],
                                                    ],
                                                ]);
                                            }
                                            ?>
                                            <?php Pjax::end(); ?>
                                            <br/>
                                        </div>
                                    </div>

                                </div>
                                <?php
                                $form = ActiveForm::begin([
                                            'type' => ActiveForm::TYPE_VERTICAL,
                                            'action' => Url::to(['save-cpoe']),
                                            'id' => 'fromcpoe',
                                ]);
                                ?>
                                <div class="row"></div>

                                <div class="form-group">
                                    <div class="col-sm-offset-0 col-sm-3">
                                        <?= $form->field($model, 'cpoe_comment')->textarea(['rows' => 3, 'style' => 'background-color: #ffff99'])->label('หมายเหตุ') ?>
                                    </div>
                                    <?= $form->field($model, 'cpoe_id')->hiddenInput()->label(false) ?>
                                </div>

                                <div class="form-group" style="text-align: right">
                                    <div class="col-sm-12">
                                        <?php if ($type == 1) { ?>
                                            <?= Html::a('Close', ['list-wait-dispense'], ['class' => 'btn btn-default']) ?>
                                            <?= Html::a('Call patient', 'javascript:adjrequest(1)', ['class' => 'btn btn-success disabled']); ?>
                                            <?= Html::a('Order Complete Issue', 'javascript:ordercompleteissue()', ['class' => 'btn btn-info disabled']); ?>
                                        <?php } else if ($type == 2) { ?>
                                            <?= Html::a('Close', ['list-wait-pharmacy'], ['class' => 'btn btn-default']) ?> 
                                            <?= Html::a('Adj Requestion', 'javascript:adjrequest(1)', ['class' => 'btn btn-warning']); ?>
                                            <?= Html::a('Order Verify', 'javascript:adjrequest(2)', ['class' => 'btn btn-success disabled']); ?>
                                            <?= Html::a('Order Printing', Url::to('index'), ['class' => 'btn btn-info disabled']); ?>
                                        <?php } else if ($type == 3) { ?>
                                            <?= Html::a('Close', ['list-check-drug'], ['class' => 'btn btn-default']) ?> 
                                            <?= Html::a('Adj Requestion', 'javascript:adjrequest(1)', ['class' => 'btn btn-warning']); ?>
                                            <?= Html::a('Save Draf', 'javascript:void(0)', ['class' => 'btn btn-success disabled', 'id' => 'draf_order_check']); ?>
                                            <?= Html::a('Order Check', 'javascript:cmd_cpoe_rx_check()', ['class' => 'btn btn-info disabled', 'id' => 'order_check']); ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                        <?php
                        $script = <<< JS
function runScript(e) {
    if (e.keyCode == 13) {
       var cpoe_num = $('#cpoe_num').val(); 
      if(cpoe_num !== ""){
  $.ajax({
                    url: 'index.php?r=dispense/dispense/cmd-cpoe-rx-itemissue',
                    type: 'post',
                    data:{cpoe_num:cpoe_num},
                    success: function (data) { 
                        if(data == 1){
                        $.pjax.reload({container: '#pjax-tbcpoedetails'});
                       }else{
                        swal("","ไม่พบข้อมูล", "warning");
                       }
                    }
                });
      }else{
swal("","กรุณาใส่ข้อมูล", "warning");
      }
    }
}
function runScript2(e) {
    if (e.keyCode == 13) {
       var cpoe_num = $('#cpoe_num').val(); 
      if(cpoe_num !== ""){
  $.ajax({
                    url: 'index.php?r=dispense/dispense/cmd-cpoe-rx-itemcheck',
                    type: 'post',
                    data:{cpoe_num:cpoe_num},
                    success: function (data) { 
                        if(data == 1){
                        $.pjax.reload({container: '#pjax-tbcpoedetails'});
                        $('#draf_order_check').removeClass('disabled');
                        $('#cpoe_num').val('');
                        $('#cpoe_num').focus();
                       }else{
                        swal("","ไม่พบข้อมูล", "warning");
                       }
                    }
                });
      }else{
        swal("","กรุณาใส่ข้อมูล", "warning");
      }
    }
}

function confirmOk(id){
$.ajax({
                    url: 'index.php?r=dispense/dispense/cmd-cpoe-item-rxverify',
                    type: 'post',
                    data:{cpoe_id:id},
                    success: function (data) { 
                        if(data == 1){
                        $.pjax.reload({container: '#pjax-tbcpoedetails'});
                            swal("","OK เรียบร้อยแล้ว", "success");
                       }else{
                            swal("","ไม่พบข้อมูล", "warning");
                       }
                    }
                });
}
function cmd_cpoe_rx_check(){
swal({
        title: "คุณยืนยันคำสั่งหรือไม่?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "Yes",
        cancelButtonText: "Close",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
          var cpoe_id =  $('#vwcpoerxheader-cpoe_id').val();
             $.ajax({
                    url: 'index.php?r=dispense/dispense/cmd-cpoe-rx-check',
                    type: 'post',
                    data:{cpoe_id:cpoe_id},
                    success: function (data) { 
                        if(data == 1){
                        swal("", "บันทึกข้อมูลแล้ว", "success");
                       }
                    }
                });
        } else {
            
        }
    });
}
function ordercompleteissue(){
 swal({
        title: "คุณยืนยันคำสั่งหรือไม่?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "Yes",
        cancelButtonText: "Close",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
          var cpoe_id =  $('#vwcpoerxheader-cpoe_id').val();
             $.ajax({
                    url: 'index.php?r=dispense/dispense/order-complete-issue',
                    type: 'post',
                    data:{cpoe_id:cpoe_id},
                    success: function (data) { 
                        if(data == 1){
                        swal("", "บันทึกข้อมูลแล้ว", "success");
                       }
                    }
                });
        } else {
            
        }
    });
}
function showorderadjast(cpoe_ids){
    $('#modal_cpoenote').modal('show');
    $('#cpoe_ids').val(cpoe_ids);
}
function adjrequest(type) {
    swal({
        title: "คุณยืนยันคำสั่งหรือไม่?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#5cb85c",
        confirmButtonText: "Yes",
        cancelButtonText: "Close",
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
          var cpoe_id =  $('#vwcpoerxheader-cpoe_id').val();
             $.ajax({
                    url: 'index.php?r=dispense/dispense/adj-request',
                    type: 'post',
                    data:{cpoe_id:cpoe_id,type:type},
                    success: function (data) { 
                        if(data == 1){
                        swal("", "บันทึกข้อมูลแล้ว", "success");
                       }
                    }
                });
        } else {
            
        }
    });
}     
$('#request input:checkbox').change(function () {
    $(this).closest('tr').toggleClass("danger", this.checked);
});
$('#modal_cpoenote_save').click(function(){
   var cpoe_ids =  $('#cpoe_ids').val();
   var cpoe_adj_note =  $('#cpoe_adj_note').val();
if(cpoe_adj_note !== ""){
  $.ajax({
                    url: 'index.php?r=dispense/dispense/order-adjust-request',
                    type: 'post',
                    data:{cpoe_adj_note:cpoe_adj_note,cpoe_ids:cpoe_ids},
                    success: function (data) { 
                        if(data == 1){
                        swal("", "บันทึกข้อมูลแล้ว", "success");
                        $.pjax.reload({container: '#pjax-tbcpoedetails'});
                       }
                    }
                });
}else{
swal("","กรุณาใส่ข้อมูล", "warning");
}
});
function save_draf_order_check(){
     $.ajax({
                    url: 'index.php?r=dispense/dispense/order-adjust-request',
                    type: 'post',
                    data:{cpoe_adj_note:cpoe_adj_note,cpoe_ids:cpoe_ids},
                    success: function (data) { 
                        if(data == 1){
                       
                       }
                    }
                });
}
JS;
                        $this->registerJs($script, \yii\web\View::POS_END, 'index');
                        ?>

                        <?php
                        Modal::begin([
                            'id' => 'modal_cpoenote',
                            'header' => '<h4>Order Adjust Request</h4>',
                            //  'size' => 'modal-lg modal-primary',
                            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                            'closeButton' => FALSE,
                        ]);
                        ?> 
                        <input type="hidden" id="cpoe_ids" />
                        <textarea rows="3"  style="background-color:#ffff99" class="form-control" name="cpoe_adj_note" id="cpoe_adj_note">
                        </textarea>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <a href="javascript:void(0)" id="modal_cpoenote_save" class="btn btn-warning">Save</a>
                        </div>
                        <?php
                        Modal::end();
                        ?>
