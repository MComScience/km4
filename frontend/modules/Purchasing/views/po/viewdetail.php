<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
?>
<div class="tb-pr-temp-view">
    <div class="row">
        <div class="col-md-3 col-md-offset-1">
            <div style="text-align: center">
                <p></p>
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
                                'value' => $model->PRPackQtyApprove != 0.00 ? number_format($model->PRPackQtyApprove,2) : '-',
                            ],
                            [
                                'attribute' => 'PackUnit',
                                'label' => 'หน่วยแพค',
                                'value' => $model->detail->PackUnit != null ? $model->detail->PackUnit : '-',
                            ],
                            [
                                'attribute' => 'ItemPackSKUQty',
                                'label' => 'ปริมาณ/แพค',
                                'value' => $model->detail->ItemPackSKUQty != 0.00 ? number_format($model->detail->ItemPackSKUQty,2) : '-',
                                'valueColOptions' => ['style' => 'width:50%'],
                            ],
                            [
                                'attribute' => 'PRPackCostApprove',
                                'label' => 'ราคา/แพค',
                                'value' => $model->PRPackCostApprove != 0.00 ? number_format($model->PRPackCostApprove,2) : '-',
                            ],
                            [
                                'attribute' => 'PRApprovedOrderQty',
                                'label' => 'จำนวนขอซื้อ',
                                'value' => $model->PRApprovedOrderQty != 0.00 ? number_format($model->PRApprovedOrderQty,2) : '-',
                            ],
                            [
                                'attribute' => 'DispUnit',
                                'value' => $model->detail->DispUnit != null ? $model->detail->DispUnit : '-',
                                'label' => 'หน่วย',
                                'format' => 'html',
                            ],
                            [
                                'attribute' => 'PRApprovedUnitCost',
                                'label' => 'ราคา/หน่วย',
                                'value' => $model->PRApprovedUnitCost != 0.00 ? number_format($model->PRApprovedUnitCost,2) : '-',
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

        <div class="col-xs-8 col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('Price List') ?></div></div>
                <div class="panel-body">
                    <?php if ($pricelist != null) { ?>
                        <div class="table-responsive">
                            <table class="table table-striped  table-bordered dt-responsive " cellspacing="0" width="100%" >
                                <thead class="bordered-success">
                                    <tr>
                                        <th style="text-align: center;">ชื่อผู้ขาย</th>
                                        <th  style="text-align: center;">รายการสินค้า</th>
                                        <th  style="text-align: center;">ราคา/หน่วย</th>
                                        <th  style="text-align: center;">หน่วย</th>
                                        <th  style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pricelist as $record): ?>
                                        <tr>
                                            <td style="text-align: center;"><?php echo $record['VenderName']; ?></td>
                                            <td><?php echo $record['ItemName']; ?></td>
                                            <td style="text-align: center;"><?php echo number_format($record['QUUnitCost'], 2); ?></td>
                                            <td style="text-align: center;"><?php echo $record['itemDispUnit']; ?></td>
                                            <td style="text-align: center;"><a class="btn btn-success btn-xs">Select</a></td>
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
</div>

