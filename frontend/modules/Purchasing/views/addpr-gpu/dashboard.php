<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$script = <<< JS
$(document).ready(function () {
        $('#dashboard').addClass("active");
    });
JS;
$this->registerJs($script);

$this->title = 'PURCHASING PLAN STATUS';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="profile-container">
            <?php echo $this->render('@frontend/modules/Purchasing/views/dashboard/_hd_pharmacy.php'); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?php echo $this->render('@frontend/modules/Purchasing/views/dashboard/_tab_pharmacy.php'); ?>
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php Pjax::begin([]) ?>
                                        <?php echo $this->render('_search_details', ['model' => $searchModel,'action' => 'dashboard']); ?>
                                        <?php
                                        echo GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            //'filterModel' => $searchModel,
                                            'responsive' => true,
                                            'hover' => true,
                                            'layout' => $layout,
                                            'pjax' => true,
                                            'striped' => false,
                                            'export' => [
                                                'fontAwesome' => true,
                                                //'label' => '<b>Reports</b>',
                                                'class' => 'btn btn-default',
                                                'icon' => 'print',
                                                'showConfirmAlert' => FALSE,
                                                'header' => '',
                                                'stream' => false,
                                                'target' => '_blank',
                                                'showColumnSelector' => true
                                            ],
                                            'exportConfig' => [
                                                GridView::EXCEL => ['label' => 'EXCEL'],
                                                GridView::PDF => [
                                                    'label' => Yii::t('app', 'PDF'),
                                                    'iconOptions' => ['class' => 'text-danger'],
                                                    'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                                                    'mime' => 'application/pdf',
                                                    'showHeader' => true,
                                                    'showPageSummary' => true,
                                                    'showFooter' => true,
                                                    'showCaption' => true,
                                                    'config' => [
                                                        'mode' => 'UTF-8',
                                                        'format' => 'A4-L',
                                                        'destination' => 'D',
                                                        'methods' => [
                                                            'SetHeader' => ['สถานะคงคลังยา'],
                                                            'SetFooter' => ['{PAGENO}'],
                                                        ],
                                                        'options' => [
                                                            'title' => 'Report',
                                                            'defaultheaderline' => 0,
                                                            'defaultfooterline' => 0,
                                                        ],
                                                    ]
                                                ],
                                            ],
                                            'columns' => [
                                                    [
                                                    'class' => '\kartik\grid\SerialColumn'
                                                ],
                                                    [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;'],
                                                    'expandOneOnly' => true,
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => GridView::TYPE_SUCCESS,
                                                    'detailUrl' => Url::to(['details']),
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
                                                    'header' => 'รายละเอียดสินค้า',
                                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                                    'attribute' => 'ItemName',
                                                    'hAlign' => GridView::ALIGN_LEFT,
                                                    'value' => function ($model) {
                                                        return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                                    }
                                                ],
                                                    [
                                                    'header' => 'หน่วย',
                                                    'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                                    'attribute' => 'DispUnit',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                        return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                                    }
                                                ],
                                                    [
                                                    'header' => 'คลังกลาง',
                                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
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
                                                    'format' => ['decimal', 2],
                                                    'hAlign' => GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                        return empty($model['stk_main_rop']) ? '' : $model['stk_main_rop'];
                                                    }
                                                ],
                                                    [
                                                    'header' => 'อัตราการใช้/เดือน',
                                                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                                    'attribute' => 'consume_rate',
                                                    'hAlign' => GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                        return empty($model['consume_rate']) ? '-' : $model['consume_rate'];
                                                    }
                                                ],
                                                    [
                                                    'header' => 'ยอดแผน',
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
                                                    'header' => 'กำลังสั่งซื้อ',
                                                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                                                    'attribute' => 'po_wip',
                                                    'hAlign' => GridView::ALIGN_RIGHT,
                                                    'options' => ['style' => 'background-color: #fcf8e3'],
                                                    'format' => ['decimal', 2],
                                                    'value' => function ($model) {
                                                        return empty($model['po_wip']) ? '' : $model['po_wip'];
                                                    }
                                                ],
                                            ]
                                        ]);
                                        ?>
                                        <?php Pjax::end() ?>
                                    </div>
                                    <div class="col-xs-12 col-md-12" style="text-align: right;">
                                        <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


