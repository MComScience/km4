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
        <div class="col-xs-8"></div>
        <div class="form-group">
            <ul  class="bordered text-center">
                <?php if ($view == 'false') { ?>
                    <a  class="btn btn-danger">Clear</a>
                    <a  class="btn btn-info edit" data-id="<?php echo $model['ids'] ?>" id="edit">Edit</a>
                    <a  class="btn btn-success" onclick="OKVerify(this);" data-id="<?php echo $model['ids'] ?>">OK Verify</a>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'verify-modal',
    'header' => '<h4 class="modal-title">บันทึกรายการยาสามัญ ใบขอซื้อ</h4>',
    'size' => 'modal-lg',
]);
?>
<div id="data"></div>
<?php \yii\bootstrap\Modal::end();
?>
<script>
    function OKVerify(d) {
        var id = (d.getAttribute("data-id"));
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.post(
                        'ok-verify',
                        {
                            id: id
                        },
                function (data)
                {
                    $.pjax.reload({container: '#verify_pjax_id'});
                    $('#SaveDraftVerify').removeClass('disabled');
                }
                );
            }
        });
    }
    function init_click_handlers() {
        $('.btn-info.edit').click(function (e) {
            var fID = $(this).attr('data-id');
            $.get(
                    'update-verify',
                    {
                        id: fID
                    },
            function (data)
            {
                $('#form_update_verify').trigger('reset');
                //$('#verify-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('.modal-header').addClass("bordered-success");
                $('.modal-title').html('ปรับปรุงรายการยาสามัญ ทวนสอบใบขอซื้อ');
                $('#verify-modal').modal('show');
            }
            );
        });
    }
    init_click_handlers(); //first run
    $('#verify_pjax_id').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
</script>
<?php
$script = <<< JS

JS;
$this->registerJs($script);
?>
<?php /*
  <?php

  use yii\helpers\Html;
  ?>
  <br>
  <?=
  kartik\grid\GridView::widget([
  'dataProvider' => $dataProvider,
  //'filterModel' => $searchModel,
  'bootstrap' => true,
  'responsiveWrap' => FALSE,
  'responsive' => true,
  'showPageSummary' => true,
  'hover' => true,
  'export' => false,
  'pjax' => true,
  'striped' => true,
  'condensed' => true,
  'toggleData' => false,
  'panel' => [
  'heading' => '<div class="panel-title" style="text-align:left">รายละเอียดขอซื้อ</div>',
  'type' => 'default',
  'after' => Html::button('Clear', [
  'type' => 'button',
  'title' => Yii::t('app', 'Clear'),
  'class' => 'btn btn-danger btn-xs',
  ]) . ' ' .
  Html::button('Edit', [
  'type' => 'button',
  'class' => 'btn btn-primary btn-xs edit',
  'title' => Yii::t('app', 'Edit'),
  'data-id' => $searchModel['ids'],
  'id' => 'el'
  ]) . ' ' .
  Html::button('OK', [
  'type' => 'button',
  'class' => 'btn btn-success btn-xs',
  'title' => Yii::t('app', 'OK'),
  ]),
  'footer' => false
  ],
  'rowOptions' => function($model) {
  return ['class' => 'default'];
  },
  'toggleDataContainer' => ['class' => 'btn-group-sm'],
  'exportContainer' => ['class' => 'btn-group-sm'],
  'layout' => "{items}\n{pager}",
  'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
  'columns' => [
  [
  'header' => 'เลขที่แผนจัดซื้อ',
  'attribute' => 'PCPlanNum',
  'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
  ],
  [
  'header' => 'ราคากลาง',
  'attribute' => 'PRItemStdCost',
  'format' => ['decimal', 2],
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  ],
  [
  'header' => 'ราคาต่อหน่วยตามแผน',
  'attribute' => 'PRItemUnitCost',
  'format' => ['decimal', 2],
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  ],
  [
  'header' => 'ปริมาณตามแผน',
  'attribute' => 'PRItemOrderQty',
  'format' => ['decimal', 2],
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  ],
  [
  'header' => 'ปริมาณขอซื้อแล้ว',
  'attribute' => 'PRApprovedOrderQtySum',
  'format' => ['decimal', 2],
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  ],
  [
  'header' => 'ปริมาณขอซื้อได้',
  'attribute' => 'PRItemAvalible',
  'format' => ['decimal', 2],
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  ],
  [
  'header' => 'ปริมาณขอซื้อได้',
  'attribute' => 'PRItemAvalible',
  'format' => ['decimal', 2],
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  ],
  [
  'header' => 'จำนวนแพคทวนสอบ',
  'attribute' => 'PRPackQtyVerify',
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  'value' => function ($model) {
  if ($model['PRPackQtyVerify'] == null) {
  return '0.00';
  }
  }
  ],
  [
  'header' => 'หน่วยแพค',
  'attribute' => 'ItemPackIDVerify',
  'value' => 'packunitverify.PackUnit'
  ],
  [
  'header' => 'ราคาต่อแพคทวนสอบ',
  'attribute' => 'ItemPackCostVerify',
  'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
  'value' => function ($model) {
  if ($model['ItemPackCostVerify'] == null) {
  return '0.00';
  }
  }
  ],
  [
  'header' => 'หน่วย',
  'attribute' => 'DispUnit',
  'value' => 'detail.DispUnit'
  ],
  [
  'header' => 'ราคาต่อหน่วยทวนสอบ',
  'attribute' => 'PRVerifyUnitCost',
  'hAlign' => 'right',
  'value' => function ($model) {
  if ($model['PRVerifyUnitCost'] == null) {
  return '0.00';
  }
  },
  'format' => ['decimal', 2],
  'pageSummary' => 'รวมเป็นเงิน',
  ],
  //        [
  //            'class' => '\kartik\grid\FormulaColumn',
  //            'header' => 'ราคารวม',
  //            'hAlign' => 'right',
  //            'format' => ['decimal', 2],
  //            'value' => function ($model, $key, $index, $widget) {
  //        $p = compact('model', 'key', 'index');
  //        // Write your formula below
  //        return $widget->col(6, $p) + $widget->col(8, $p);
  //    },
  //            'pageSummary' => true,
  //        ],
  ],
  ]);
  ?>

  <script>
  $(document).ready(function () {
  $('.btn-primary.edit').on('click', function (e) {
  var id = $(this).data('id');
  alert(id);
  //    $.ajax({
  //       url: '/path/to/action',
  //       data: {id: '<id>', 'other': '<other>'},
  //       success: function(data) {
  //           // process data
  //       }
  //    });
  });
  });
  </script>
 * 
 */
?>
