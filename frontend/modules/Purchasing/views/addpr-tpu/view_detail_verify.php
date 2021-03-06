<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
?>
<div class="tb-pr-temp-view">
    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-xs-6 col-sm-4">
            <div style="text-align: center">
                <p></p>
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
                                'value' => $model->PRItemStdCost != 0.00 ? number_format($model->PRItemStdCost,2) : '-',
                            ],
                            [
                                'attribute' => 'PRItemUnitCost',
                                'label' => 'ราคาต่อหน่วยตามแผน',
                                'value' => $model->PRItemUnitCost != 0.00 ? number_format($model->PRItemUnitCost,2) : '-',
                            ],
                            [
                                'attribute' => 'PRItemOrderQty',
                                'label' => 'ปริมาณตามแผน',
                                'value' => $model->PRItemOrderQty != 0.00 ? number_format($model->PRItemOrderQty,2) : '-',
                            ],
                            [
                                'attribute' => 'PRApprovedOrderQtySum',
                                'label' => 'ปริมาณขอซื้อแล้ว',
                                'value' => $model->PRApprovedOrderQtySum != 0.00 ? number_format($model->PRApprovedOrderQtySum,2) : '-',
                            ],
                            [
                                'attribute' => 'PRItemAvalible',
                                'label' => 'ปริมาณขอซื้อได้',
                                'value' => $model->PRItemAvalible != 0.00 ? number_format($model->PRItemAvalible,2) : '-',
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
        <div class="col-xs-6 col-sm-4">
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
                                'valueColOptions' => ['style' => 'width:50%'],
                                'displayOnly' => true,
                                'value' => $model->PRPackQty != 0.00 ? number_format($model->PRPackQty,2) : '-',
                            ],
                            [
                                'attribute' => 'PackUnit',
                                'label' => 'หน่วยแพค',
                                'format' => 'html',
                                //'value' => $pack,
                                'value' => $model->detail->PackUnit != null ? $model->detail->PackUnit : '-',
                            ],
//                        
                            [
                                'attribute' => 'ItemPackCost',
                                'label' => 'ราคา/แพค',
                                'value' => $model->ItemPackCost != 0.00 ? number_format($model->ItemPackCost,2) : '-',
                            ],
                            [
                                'attribute' => 'PROrderQty',
                                'label' => 'จำนวนขอซื้อ',
                                'value' => $model->PROrderQty != 0.00 ? number_format($model->PROrderQty,2) : '-',
                            ],
                            [
                                'attribute' => 'DispUnit',
                                'label' => 'หน่วย',
                                'value' => $model->detail->DispUnit != null ? $model->detail->DispUnit : '-',
                            ],
                            [
                                'attribute' => 'PRUnitCost',
                                'label' => 'ราคา/หน่วย',
                                'value' => $model->PRUnitCost != 0.00 ? number_format($model->PRUnitCost,2) : '-',
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
            <?php /*
              <div class="col-xs-9"></div>
              <div class="form-group">
              <ul  class="bordered text-center">
              <?php if ($view == 'false') { ?>
              <a  class="btn btn-danger">Clear</a>
              <a  class="btn btn-success" onclick="OKVerify(this);" data-id="<?php echo $model['ids'] ?>">OK Verify</a>
              <?php } ?>
              </ul>
              </div>
             * 
             */ ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-xs-6 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดแพคขอซื้อ') ?></div></div>
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
                                'attribute' => 'ItemPackSKUQty',
                                'label' => 'ปริมาณ/แพค',
                                //'format' => 'raw',
                                'value' => $packunit['ItemPackSKUQty'] != 0.00 ? number_format($packunit['ItemPackSKUQty'],2) : '-',
                            ],
                            [
                                'attribute' => 'DispUnit',
                                'value' => $packunit['DispUnit'] != null ? $packunit['DispUnit'] : '-',
                                'label' => 'หน่วย',
                            ],
                            [
                                'attribute' => 'PackUnit',
                                'label' => 'หน่วยแพค',
                                'format' => 'html',
                                //'value' => $pack,
                                'value' => $packunit['PackUnit'] != null ? $packunit['PackUnit'] : '-',
                            ],
                        ],
                    ])
                    ?> 
                </div>
            </div>
        </div>

        <div class="col-xs-6 col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading bg-palegreen"><div class="panel-title white"><?= Html::encode('รายละเอียดแพคขอซื้อทวนสอบ') ?></div></div>
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
                                'attribute' => 'ItemPackSKUQty',
                                'label' => 'ปริมาณ/แพค',
                                //'format' => 'raw',
                                'value' => $packverify['ItemPackSKUQty'] != 0.00 ? number_format($packverify['ItemPackSKUQty'],2) : '-',
                            ],
                            [
                                'attribute' => 'DispUnit',
                                //'value' => $model->detail->DispUnit,
                                'value' => $packverify['DispUnit'] != null ? $packverify['DispUnit'] : '-',
                                'label' => 'หน่วย',
                            ],
                            [
                                'attribute' => 'PackUnit',
                                'label' => 'หน่วยแพค',
                                'format' => 'html',
                                //'value' => $pack,
                                'value' => $packverify['PackUnit'] != null ? $packverify['PackUnit'] : '-',
                            ],
                        ],
                    ])
                    ?> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function OKVerify(d) {
        var id = (d.getAttribute("data-id"));
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.post(
                        'index.php?r=Purchasing/addpr-tpu/ok-verify',
                        {
                            id: id
                        },
                function (data)
                {
                    $.pjax.reload({container: '#verify_pjax_id'});
                }
                );
            }
        });
    }
</script>