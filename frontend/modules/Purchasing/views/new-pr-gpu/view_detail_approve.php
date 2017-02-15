<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
?>

<div class="tb-pr-temp-view">
    <div class="col-xs-6">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดตามแผนจัดซื้อ') ?></div></div>
            <div class="panel-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'mode' => DetailView::MODE_VIEW,
                    'striped' => false,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hideIfEmpty' => true,
                    'enableEditMode' => false,
//                        'panel' => [
//                            'heading' => 'รายละเอียดตามแผนจัดซื้อ',
//                            'type' => DetailView::TYPE_DANGER,
//                        ],
                    'attributes' => [
                        [
                            'attribute' => 'PCPlanNum',
                            'label' => 'เลขที่แผนจัดซื้อ',
                            'format' => 'raw',
                            'value' => $model->PCPlanNum != null ? '<kbd>' . $model->PCPlanNum . '</kbd>' : '-',
                            'valueColOptions' => ['style' => 'width:50%'],
                            'displayOnly' => true
                        ],
                        [
                            'attribute' => 'PRItemStdCost',
                            'label' => 'ราคากลาง',
                            'format' => ['decimal', 2],
                            'value' => $model->PRItemStdCost != null ? $model->PRItemStdCost : '0.00',
                        //'valueColOptions'=>['style'=>'text-align:center']
                        ],
                        [
                            'attribute' => 'PRItemUnitCost',
                            'label' => 'ราคาต่อหน่วยตามแผน',
                            'format' => ['decimal', 2],
                            'value' => $model->PRItemUnitCost != null ? $model->PRItemUnitCost : '0.00',
                        ],
                        [
                            'attribute' => 'PRItemOrderQty',
                            'label' => 'ปริมาณตามแผน',
                            'format' => ['decimal', 2],
                            'value' => $model->PRItemOrderQty != null ? $model->PRItemOrderQty : '0.00',
                        ],
                        [
                            'attribute' => 'PRApprovedOrderQtySum',
                            'label' => 'ปริมาณขอซื้อแล้ว',
                            'format' => ['decimal', 2],
                            'value' => $model->PRApprovedOrderQtySum != null ? $model->PRApprovedOrderQtySum : '0.00',
                        ],
                        [
                            'attribute' => 'PRItemAvalible',
                            'label' => 'ปริมาณขอซื้อได้',
                            'format' => ['decimal', 2],
                            'value' => $model->PRItemAvalible != null ? $model->PRItemAvalible : '0.00',
                        ],
                        [
                            'attribute' => 'PRItemAvalible',
                            'label' => '-',
                            'value' => ''
                        ],
                        [
                            'attribute' => 'PRItemAvalible',
                            'label' => '-',
                            'value' => ''
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
    <div class="col-xs-6">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดการขอซื้อ') ?></div></div>
            <div class="panel-body">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'mode' => DetailView::MODE_VIEW,
                    'striped' => false,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hideIfEmpty' => true,
                    'enableEditMode' => false,
//                    'panel' => [
//                        'heading' => 'รายละเอียดแพค',
//                        'type' => DetailView::TYPE_DEFAULT,
//                    ],
                    'attributes' => [
                        [
                            'attribute' => 'PRPackQty',
                            'label' => 'จำนวนแพค',
                            'format' => ['decimal', 2],
                            'valueColOptions' => ['style' => 'width:50%'],
                            'displayOnly' => true,
                            'value' => $model->PRPackQty != null ? $model->PRPackQty : '0.00',
                        ],
                        [
                            'attribute' => 'PackUnit',
                            'label' => 'หน่วยแพค',
                            'format' => 'html',
                            //'value' => $pack,
                            'value' => $pack != null ? $pack : '-',
                        ],
                        [
                            'attribute' => 'ItemPackSKUQty',
                            'label' => 'ปริมาณ/แพค',
                            //'format' => 'raw',
                            'value' => $packunit['ItemPackSKUQty'] != null ? $packunit['ItemPackSKUQty'] : '0.00',
                            //'value' => $packunit['ItemPackSKUQty'],
                            'format' => ['decimal', 2],
                        ],
                        [
                            'attribute' => 'ItemPackCost',
                            'label' => 'ราคา/แพค',
                            'format' => ['decimal', 2],
                            'value' => $model->ItemPackCost != null ? $model->ItemPackCost : '0.00',
                        ],
                        [
                            'attribute' => 'PROrderQty',
                            'label' => 'จำนวนขอซื้อ',
                            'format' => ['decimal', 2],
                            'value' => $model->PROrderQty != null ? $model->PROrderQty : '0.00',
                        ],
                        [
                            'attribute' => 'DispUnit',
                            //'value' => $model->detail->DispUnit,
                            'value' => $model->detail->DispUnit != null ? $model->detail->DispUnit : '-',
                            'label' => 'หน่วย',
                        ],
                        [
                            'attribute' => 'PRUnitCost',
                            'label' => 'ราคา/หน่วย',
                            'format' => ['decimal', 2],
                            'value' => $model->PRUnitCost != null ? $model->PRUnitCost : '0.00',
                        ],
                        [
                            'attribute' => 'PRExtendedCost',
                            'label' => 'ราคารวม',
                            'format' => ['decimal', 2],
                            'value' => $model['PROrderQty'] * $model['PRUnitCost'],
                        //'rowOptions' => ['class' => 'warning kv-edit-hidden', 'style' => 'border-top: 5px double #dedede'],
                        ],
                    ],
                ])
                ?> 
            </div>
        </div>
        </div>
</div>
