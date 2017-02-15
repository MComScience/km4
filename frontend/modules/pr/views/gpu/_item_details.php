<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$layout = <<< HTML
{items}
HTML;
?>
<style type="text/css">
    table.kv-grid-table thead tr th{
        background-color: white;
    }
</style>
<p></p>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <span class="text" style="font-size: 16px"><?= Html::encode('ราคากลาง :'); ?> <?php echo $QueryGPU != null ? $QueryGPU['GPUStdCost'] : '0.00' ?>
            </div>
        </div>
    </div>  
</div>
<p></p>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-11 col-sm-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode('แผนการสั่งซื้อ') ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider1,
                        'responsive' => true,
                        'hover' => true,
                        'striped' => false,
                        'layout' => $layout,
                        'condensed' => true,
                        'bordered' => true,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                                [
                                'header' => 'ยอดแผน(รวม)',
                                'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                'attribute' => 'plan_qty',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'options' => ['style' => 'background-color: #d9edf7'],
                                'value' => function ($model) {
                                    return empty($model['plan_qty']) ? '' : $model['plan_qty'];
                                }
                            ],
                                [
                                'header' => 'ขอซื้อแล้ว',
                                'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                'attribute' => 'pr_qty_cum',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'options' => ['style' => 'background-color: #d9edf7'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['pr_qty_cum']) ? '' : $model['pr_qty_cum'];
                                }
                            ],
                                [
                                'header' => 'ขอซื้อได้',
                                'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                'attribute' => 'pr_qty_avalible',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'options' => ['style' => 'background-color: #d9edf7'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['pr_qty_avalible']) ? '' : $model['pr_qty_avalible'];
                                }
                            ],
                                [
                                'header' => 'กำลังขอซื้อ',
                                'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #dff0d8'],
                                'attribute' => 'pr_wip',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'options' => ['style' => 'background-color: #dff0d8'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['pr_wip']) ? '' : $model['pr_wip'];
                                }
                            ],
                                [
                                'header' => 'รอส่งมอบ',
                                'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                                'attribute' => 'po_wip',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'options' => ['style' => 'background-color: #fcf8e3'],
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['po_wip']) ? '' : $model['po_wip'];
                                }
                            ],
                                [
                                'header' => 'อัตราการใช้/เดือน',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'consume_rate',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['consume_rate']) ? '' : $model['consume_rate'];
                                }
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-8 col-sm-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode('ยอดคงคลัง') ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider2,
                        'responsive' => true,
                        'hover' => true,
                        'showPageSummary' => true,
                        'layout' => $layout,
                        'condensed' => true,
                        'bordered' => true,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                                [
                                'header' => 'รหัสสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                }
                            ],
                                [
                                'header' => 'รายละเอียดสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                }
                            ],
                                [
                                'header' => 'คลังกลาง',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'stk_main_balance',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['stk_main_balance']) ? '' : $model['stk_main_balance'];
                                }
                            ],
                                [
                                'header' => 'คลังย่อย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'stk_sub_balance',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['stk_sub_balance']) ? '' : $model['stk_sub_balance'];
                                }
                            ],
                                [
                                'header' => 'จุดสั่งซื้อ',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'stk_main_rop',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['stk_main_rop']) ? '' : $model['stk_main_rop'];
                                }
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-10 col-sm-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode('Price List') ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider3,
                        'responsive' => true,
                        'hover' => true,
                        'layout' => $layout,
                        'condensed' => true,
                        'bordered' => true,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                                [
                                'header' => 'ผู้จำหน่าย',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'VenderName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['VenderName']) ? '-' : $model['VenderName'];
                                }
                            ],
                                [
                                'header' => 'รหัสยาการค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'TMTID_TPU',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['TMTID_TPU']) ? '-' : $model['TMTID_TPU'];
                                }
                            ],
                                [
                                'header' => 'รหัสยาสามัญ',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'TMTID_GPU',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['TMTID_GPU']) ? '-' : $model['TMTID_GPU'];
                                }
                            ],
                                [
                                'header' => 'ชื่อสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                }
                            ],
                                [
                                'header' => 'ราคาต่อหน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'QUUnitCost',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['QUUnitCost']) ? '' : $model['QUUnitCost'];
                                }
                            ],
                                [
                                'header' => 'หน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'DispUnit',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                }
                            ],
                                [
                                'header' => 'ยืนราคา',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'QUValidDate',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['QUValidDate']) ? '' : $model['QUValidDate'];
                                }
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<p></p>
<div class="row">
    <div class="col-lg-1 col-sm-12 col-xs-12"></div>
    <div class="col-lg-11 col-sm-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode('ประวัติการสั่งซื้อ') ?></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php
                    echo GridView::widget([
                        'dataProvider' => $dataProvider4,
                        'responsive' => true,
                        'hover' => true,
                        'layout' => $layout,
                        'condensed' => true,
                        'bordered' => true,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                                [
                                'header' => 'เลขที่',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'PONum',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['PONum']) ? '-' : $model['PONum'];
                                }
                            ],
                                [
                                'header' => 'วันที่',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'PODate',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'format' => ['date', 'php:d/m/Y'],
                                'value' => function ($model) {
                                    return empty($model['PODate']) ? '-' : $model['PODate'];
                                }
                            ],
                                [
                                'header' => 'รหัสสินค้า',
                                'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                }
                            ],
                                [
                                'header' => 'ชื่อสินค้า',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'ItemName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['ItemName']) ? '' : $model['ItemName'];
                                }
                            ],
                                [
                                'header' => 'ราคาต่อหน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'POApprovedUnitCost',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['POApprovedUnitCost']) ? '' : $model['POApprovedUnitCost'];
                                }
                            ],
                                [
                                'header' => 'หน่วย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'DispUnit',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return empty($model['DispUnit']) ? '' : $model['DispUnit'];
                                }
                            ],
                                [
                                'header' => 'จำนวน',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'POApprovedOrderQty',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return empty($model['POApprovedOrderQty']) ? '' : $model['POApprovedOrderQty'];
                                }
                            ],
                                [
                                'header' => 'เป็นเงิน',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'POExtcost',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                                    return $model['POApprovedOrderQty'] * $model['POApprovedUnitCost'];
                                }
                            ],
                                [
                                'header' => 'ผู้จำหน่าย',
                                'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                'attribute' => 'VenderName',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return empty($model['VenderName']) ? '-' : $model['VenderName'];
                                }
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>