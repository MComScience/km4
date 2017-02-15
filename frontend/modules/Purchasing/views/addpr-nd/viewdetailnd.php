<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
?>
<br>

<div class="tb-pr-temp-view">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div style="text-align: center">
                <p></p>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดตามแผนจัดซื้อ') ?></div></div>
                <div class="panel-body">
                    <?php if ($model1['PCPlanNum'] != null) { ?>
                        <?=
                        DetailView::widget([
                            'model' => $model1,
                            'mode' => DetailView::MODE_VIEW,
                            'striped' => false,
                            'condensed' => true,
                            'responsive' => true,
                            'hover' => true,
                            'hideIfEmpty' => true,
                            'enableEditMode' => false,
                            'attributes' => [
                                [
                                    'attribute' => 'PCPlanNum',
                                    'label' => 'เลขที่แผนจัดซื้อ',
                                    'format' => 'raw',
                                    'value' => $model1->PCPlanNum != null ? '<kbd>' . $model1->PCPlanNum . '</kbd>' : '-',
                                    'valueColOptions' => ['style' => 'width:50%'],
                                ],
                                [
                                    'attribute' => 'PRItemStdCost',
                                    'label' => 'ราคากลาง',
                                    'value' => $model1->PRItemStdCost != 0.00 ? number_format($model1->PRItemStdCost, 2) : '-',
                                ],
                                [
                                    'attribute' => 'PRItemUnitCost',
                                    'label' => 'ราคาต่อหน่วยตามแผน',
                                    'value' => $model1->PRItemUnitCost != 0.00 ? number_format($model1->PRItemUnitCost, 2) : '-',
                                ],
                                [
                                    'attribute' => 'PRItemOrderQty',
                                    'label' => 'ปริมาณตามแผน',
                                    'value' => $model1->PRItemOrderQty != 0.00 ? number_format($model1->PRItemOrderQty, 2) : '-',
                                ],
                                [
                                    'attribute' => 'PRApprovedOrderQtySum',
                                    'label' => 'ปริมาณขอซื้อแล้ว',
                                    'value' => $model1->PRApprovedOrderQtySum != 0.00 ? number_format($model1->PRApprovedOrderQtySum, 2) : '-',
                                ],
                                [
                                    'attribute' => 'PRItemAvalible',
                                    'label' => 'ปริมาณขอซื้อได้',
                                    'value' => $model1->PRItemAvalible != 0.00 ? number_format($model1->PRItemAvalible, 2) : '-',
                                ],
                                [
                                    'attribute' => 'DispUnit',
                                    'label' => 'หน่วย',
                                    'value' => $model1->DispUnit != null ? $model1->DispUnit : '-',
                                ],
                            ],
                        ])
                        ?>
                    <?php } else { ?>
                        <div style="text-align: center">
                            <code style="font-size: 15px">No data found</code>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-xs-8 col-sm-7">
            <div style="text-align: center">
                <p></p>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('ประวัติการซื้อ') ?></div></div>
                <div class="panel-body">
                    <?php if ($records != null) { ?>
                        <div class="table-responsive">
                            <table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" >
                                <thead class="bordered-success">
                                    <tr>
                                        <th style="text-align: center;">#</th>
                                        <th  style="text-align: center;">วันที่</th>
                                        <th  style="text-align: center;">ราคา/หน่วย</th>
                                        <th  style="text-align: center;">หน่วย</th>
                                        <th  style="text-align: center;">จำนวน</th>
                                        <th  style="text-align: center;">รวมเป็นเงิน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($records as $record): ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $record['PONum']; ?></td>
                                            <td style="text-align: center;"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate($record['PODate']); ?></td>
                                            <td style="text-align: center;"><?php echo number_format($record['POApprovedUnitCost'], 2); ?></td>
                                            <td style="text-align: center;"><?php echo $record['DispUnit']; ?></td>
                                            <td style="text-align: center;"><?php echo number_format($record['POApprovedOrderQty'], 2); ?></td>
                                            <td style="text-align: center;"><?php echo number_format($record['ExtentedCost'], 2); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div style="text-align: center">
                            <code style="font-size: 15px">No data found</code>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดแพค') ?></div></div>
                <div class="panel-body">
                    <?=
                    DetailView::widget([
                        'model' => $model1,
                        'mode' => DetailView::MODE_VIEW,
                        'striped' => false,
                        'condensed' => true,
                        'responsive' => true,
                        'hover' => true,
                        'hideIfEmpty' => true,
                        'enableEditMode' => true,
                        'container' => ['id' => $model1->ids],
                        'attributes' => [
                            [
                                'attribute' => 'ItemPackSKUQty',
                                'label' => 'ปริมาณบรรจุต่อแพค',
                                'valueColOptions' => ['style' => 'width:50%'],
                                'value' => $packunit['ItemPackSKUQty'] != 0.00 ? number_format($packunit['ItemPackSKUQty'], 2) : '-',
                            ],
                            [
                                'attribute' => 'DispUnit',
                                'label' => 'หน่วย',
                                'value' => $model1->DispUnit != null ? $model1->DispUnit : '-',
                            ],
                            [
                                'attribute' => 'PackUnit',
                                'label' => 'หน่วยแพค',
                                'value' => $pack['PackUnit'] != null ? $pack['PackUnit'] : '-',
                            ],
                        ],
                    ])
                    ?>
                </div>
            </div>
        </div>

        <div class="col-xs-8 col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('Price List') ?></div></div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>
</div>

