<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
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
                    //'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hideIfEmpty' => true,
                    'enableEditMode' => false,
//            'panel' => [
//                'heading' => 'รายละเอียดแผนจัดซื้อ',
//                'type' => DetailView::TYPE_PRIMARY,
//            ],
                    'attributes' => [
//                            [
//                                'group' => true,
//                                'label' => 'รหัสยาสามัญ #' . $model['TMTID_GPU'],
//                                'rowOptions' => ['class' => 'success']
//                            ],
                        [
                            'attribute' => 'PCPlanNum',
                            'label' => 'เลขที่แผนจัดซื้อ',
                            'format' => 'raw',
                            'value' =>  $model->PCPlanNum != null ? '<kbd>' . $model->PCPlanNum . '</kbd>' : '-',
                            //'value' => '<kbd>' . $model->PCPlanNum . '</kbd>',
                            'valueColOptions' => ['style' => 'width:50%'],
                        //'valueColOptions'=>['style'=>'text-align:center']
                        ],
                        [
                            'attribute' => 'PRItemStdCost',
                            'label' => 'ราคากลาง',
                            'value' =>  $model->PRItemStdCost != null ? $model->PRItemStdCost: '-',
                            //'format' => ['decimal', 2],
                            
                            
                        //'valueColOptions'=>['style'=>'text-align:center']
                        ],
                        [
                            'attribute' => 'PRItemUnitCost',
                            'label' => 'ราคาต่อหน่วยตามแผน',
                            'value' =>  $model->PRItemUnitCost != null ? $model->PRItemUnitCost: '-',
                        ],
                        [
                            'attribute' => 'PRItemOrderQty',
                            'label' => 'ปริมาณตามแผน',
                            'value' =>  $model->PRItemOrderQty != null ? $model->PRItemOrderQty: '-',
                        ],
                        [
                            'attribute' => 'PRApprovedOrderQtySum',
                            'label' => 'ปริมาณขอซื้อแล้ว',
                            'value' =>  $model->PRApprovedOrderQtySum != null ? $model->PRApprovedOrderQtySum: '-',
                        ],
                        [
                            'attribute' => 'PRItemAvalible',
                            'label' => 'ปริมาณขอซื้อได้',
                            'value' =>  $model->PRApprovedOrderQtySum != null ? $model->PRApprovedOrderQtySum: '-',
                        ],
                        [
                            'attribute' => 'DispUnit',
                            'value' => $model->detail->DispUnit != null ? $model->detail->DispUnit : '-',
                            'label' => 'หน่วย',
                            'format' => 'html',
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
            <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดแพค') ?></div></div>
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
//                            'heading' => 'รายละเอียดแพค',
//                            'type' => DetailView::TYPE_PRIMARY,
//                        ],
                    'attributes' => [
//                            [
//                                'group' => true,
//                                'label' => 'รหัสยาสามัญ #' . $model['TMTID_GPU'],
//                                'rowOptions' => ['class' => 'info']
//                            ],
                        [
                            'attribute' => 'ItemPackSKUQty',
                            'label' => 'ปริมาณ/แพค',
                            'format' => 'raw',
                            //'value' => $packunit['ItemPackSKUQty'],
                            'value' => $packunit['ItemPackSKUQty'] != null ? number_format($packunit['ItemPackSKUQty'],2) : '-',
                            //'format' => ['decimal', 2],
                            'valueColOptions' => ['style' => 'width:50%'],
                        ],
                        [
                            'attribute' => 'DispUnit',
                            'value' => $model->detail->DispUnit != null ? $model->detail->DispUnit : '-',
                            'label' => 'หน่วย',
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'PackUnit',
                            'label' => 'หน่วยแพค',
                            //'value' => 'GGWP',
                            'value' => $pack['PackUnit'] != null ? $pack['PackUnit'] : '-',
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>

