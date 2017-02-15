<?php

use kartik\grid\GridView;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="clearfix"></div>
HTML;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: center;">
        <span >สถานะสินค้าคงคลังยา</span>
    </div>
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'responsive' => true,
            'hover' => true,
            'layout' => $layout,
            'pjax' => true,
            'striped' => false,
            'columns' => [
                    [
                    'class' => '\kartik\grid\SerialColumn'
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
                    'header' => 'คงคลัง',
                    'headerOptions' => ['style' => 'color:black; text-align:center;'],
                    'attribute' => 'ItemQtyBalance',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'format' => ['decimal', 2],
                    'value' => function ($model) {
                        return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                    }
                ],
                    [
                    'header' => 'Reorder Point',
                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                    'attribute' => 'Reorderpoint',
                    'format' => ['decimal', 2],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'options' => ['style' => 'background-color: #d9edf7'],
                    'value' => function ($model) {
                        return empty($model['Reorderpoint']) ? '' : $model['Reorderpoint'];
                    }
                ],
                    [
                    'header' => 'ส่วนต่าง Rxorder Point',
                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                    'attribute' => 'ItemROPDiff',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'options' => ['style' => 'background-color: #d9edf7'],
                    'value' => function ($model) {
                        return empty($model['ItemROPDiff']) ? '-' : $model['ItemROPDiff'];
                    }
                ],
                    [
                    'header' => 'ระดับการจัดเก็บ',
                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                    'attribute' => 'ItemTargetLevel',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'options' => ['style' => 'background-color: #fcf8e3'],
                    'value' => function ($model) {
                        return empty($model['ItemTargetLevel']) ? '-' : $model['ItemTargetLevel'];
                    }
                ],
                    [
                    'header' => 'ส่วนต่างระดับการจัดเก็บ',
                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                    'attribute' => 'target_stk_diff',
                    'options' => ['style' => 'background-color: #fcf8e3'],
                    'format' => ['decimal', 2],
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'value' => function ($model) {
                        return empty($model['target_stk_diff']) ? '' : $model['target_stk_diff'];
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
                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #FF8F32'],
                    'attribute' => 'po_wip',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'options' => ['style' => 'background-color: #FF8F32'],
                    'format' => ['decimal', 2],
                    'value' => function ($model) {
                        return empty($model['po_wip']) ? '' : $model['po_wip'];
                    }
                ],
            ]
        ]);
        ?>
    </div>
</div>