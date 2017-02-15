<?php

use kartik\grid\GridView;
use yii\bootstrap\Html;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-1"></div>
    <div class="col-xs-12 col-sm-12 col-md-8">
        <p></p>
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'hover' => true,
            'pjax' => true,
            'striped' => false,
            'condensed' => true,
            'toggleData' => true,
            'showPageSummary' => true,
            'layout' => Yii::$app->componentdate->layoutgridview(),
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
            'columns' => [
                    [
                    'header' => '<font color="black">รหัสสินค้า</font>',
                    'attribute' => 'ItemID',
                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                ],
                    [
                    'header' => '<font color="black">คลังสินค้า</font>',
                    'attribute' => 'StkName',
                    'pageSummary' => 'รวม',
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                ],
                    [
                    'header' => '<font color="black">ยอดคงคลัง</font>',
                    'attribute' => 'ItemQtyBalance',
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    'pageSummary' => true,
                    'format' => ['decimal', 2],
                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                ],
                    [
                    'header' => '<font color="black">หน่วย</font>',
                    'attribute' => 'DispUnit',
                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                ],
                    [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => '<font color="black">Stock Card</font>',
                    'options' => ['style' => 'width:160px;'],
                    'width' => '200px',
                    'template' => ' {view}',
                    'buttonOptions' => ['class' => 'btn btn-default'],
                    'buttons' => [
                        'view' => function ($key, $model) {
                            $url = Url::to(['/Inventory/dashboard/view-stock-card2', 'itemid' => $model['ItemID'], 'stkid' => $model['StkID']]);
                            return Html::a('<span class="btn btn-success btn-xs"> Stock Card </span> ', $url, [
                                        'title' => 'Stock Card',
                                        'data-pjax' => 0,
                                        'target' => '_blank',
                            ]);
                        },
                    ],
                ],
        ]]);
        ?>
    </div>
</div>


