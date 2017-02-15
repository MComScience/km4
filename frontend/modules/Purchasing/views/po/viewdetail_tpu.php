<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
?>
<div class="tb-pr-temp-view">
    <div class="col-xs-6 col-sm-4">
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
                    //'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'hideIfEmpty' => true,
                    'enableEditMode' => false,
                    'attributes' => [
                        [
                            'attribute' => 'PRPackQtyApprove',
                            'label' => 'จำนวนแพค',
                            'format' => ['decimal', 2],
                            'value' => $model->PRPackQtyApprove != null ? $model->PRPackQtyApprove : '0.00',
                        ],
                        [
                            'attribute' => 'PackUnit',
                            'label' => 'หน่วยแพค',
                            'value' => $model->detail->PackUnit != null ? $model->detail->PackUnit : '-',
                        ],
                        [
                            'attribute' => 'ItemPackSKUQty',
                            'label' => 'ปริมาณ/แพค',
                            'value' => $model->detail->ItemPackSKUQty != null ? $model->detail->ItemPackSKUQty : '0.00',
                            'format' => ['decimal', 2],
                            'valueColOptions' => ['style' => 'width:50%'],
                        ],
                        [
                            'attribute' => 'PRPackCostApprove',
                            'label' => 'ราคา/แพค',
                            'format' => ['decimal', 2],
                            'value' => $model->PRPackCostApprove != null ? $model->PRPackCostApprove : '0.00',
                        ],
                        [
                            'attribute' => 'PRApprovedOrderQty',
                            'label' => 'จำนวนขอซื้อ',
                            'format' => ['decimal', 2],
                            'value' => $model->PRApprovedOrderQty != null ? $model->PRApprovedOrderQty : '0.00',
                        ],
                        [
                            'attribute' => 'DispUnit',
                            'value' => $model->dispunit->DispUnit_TMT != null ? $model->dispunit->DispUnit_TMT : '-',
                            'label' => 'หน่วย',
                            'format' => 'html',
                        ],
                        [
                            'attribute' => 'PRApprovedUnitCost',
                            'label' => 'ราคา/หน่วย',
                            'format' => ['decimal', 2],
                            'value' => $model->PRApprovedUnitCost != null ? $model->PRApprovedUnitCost : '0.00',
                        ],
                        [
                            'attribute' => 'PRExtendedCost',
                            'label' => 'ราคารวม',
                            'format' => ['decimal', 2],
                            'value' => $model['PRApprovedOrderQty'] * $model['PRApprovedUnitCost'],
                        //'rowOptions' => ['class' => 'warning kv-edit-hidden', 'style' => 'border-top: 5px double #dedede'],
                        ],
                        
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
    
    <div class="col-xs-6 col-sm-4">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('Price List') ?></div></div>
            <div class="panel-body">
                
            </div>
        </div>
    </div>
    
    <div class="col-xs-6 col-sm-4">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('ประวัติการซื้อ') ?></div></div>
            <div class="panel-body">
                
            </div>
        </div>
    </div>
</div>

