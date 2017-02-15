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
            'pjax' => true,
            'striped' => false,
            'layout' => $layout,
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
                    'contentOptions' => ['style' => 'background-color: #d9edf7'],
                    'value' => function ($model) {
                        return empty($model['plan_qty']) ? '' : $model['plan_qty'];
                    }
                ],
                    [
                    'header' => 'ขอซื้อแล้ว',
                    'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                    'attribute' => 'pr_qty_cum',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'contentOptions' => ['style' => 'background-color: #d9edf7'],
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
                    'contentOptions' => ['style' => 'background-color: #d9edf7'],
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
                    'contentOptions' => ['style' => 'background-color: #dff0d8'],
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
                    'contentOptions' => ['style' => 'background-color: #fcf8e3'],
                    'format' => ['decimal', 2],
                    'value' => function ($model) {
                        return empty($model['po_wip']) ? '' : $model['po_wip'];
                    }
                ],
            ],
        ]);
        ?>
    </div>
</div>

