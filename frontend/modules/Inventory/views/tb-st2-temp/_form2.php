<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="well">
    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
    <div class="form-group">

        <?= Html::activeLabel($model, 'ItemID', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'ItemID', ['showLabels' => false])->textInput(['readonly'=>true]); ?>
        </div>
        <label class="col-sm-2 control-label">คลังสินค้า</label>
        <div class="col-sm-2">
            <input type="hidden" name="stkid" class="form-control" value="<?php echo $stkall->StkID; ?>"/>
            <input type="text"  readonly class="form-control" value="<?php echo $stkall->StkName; ?>"/>
        </div>
        <div class="col-sm-12">
            <?= $form->field($model, 'ItemName')->textarea(['maxlength' => true, 'row' => 5,'readonly'=>true]) ?>
        </div>
        <?= Html::activeLabel($model, 'SRQty', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'SRQty', ['showLabels' => false])->textInput(['readonly'=>true]); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php if (!empty($searchModel)) { ?>
    
            <?php \yii\widgets\Pjax::begin(['id' => 'lot_selects']) ?>
            <?=
            kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'bootstrap' => true,
                // 'responsiveWrap' => FALSE,
                // 'responsive' => true,
                'hover' => true,
                'pjax' => true,
                'striped' => true,
                'condensed' => true,
                'toggleData' => false,
                'pageSummaryRowOptions' => ['class' => 'default'],
                'layout' => "{summary}\n{items}\n{pager}",
                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                'columns' => [
//                [
//                    'class' => 'kartik\grid\SerialColumn',
//                    'contentOptions' => ['class' => 'kartik-sheet-style'],
//                    'width' => '36px',
//                    'header' => '#',
//                    'headerOptions' => ['class' => 'kartik-sheet-style']
//                ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'ItemInternalLotNum',
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'ItemExternalLotNum',
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'ItemExpdate',
                        'hAlign' => GridView::ALIGN_RIGHT,
                        'format' => ['date', 'php:d/m/Y'],
                    ],
                    [
                        'attribute' => 'PackQTY',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'attribute' => 'PackItemUnitCost',
                        'format' => ['decimal', 2],
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_RIGHT
                    ],
                    [
                        'attribute' => 'PackUnit',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->PackUnit == NULL) {
                        return '-';
                    } else {
                        return $model->PackUnit;
                    }
                }
                    ],
                    [
                        'attribute' => 'ItemQty',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'attribute' => 'DispUnit',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->DispUnit == NULL) {
                        return '-';
                    } else {
                        return $model->DispUnit;
                    }
                }
                    ],
                    [
                        'attribute' => 'ItemUnitCost',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<a >Actions</a>',
                        'noWrap' => true,
                        'options' => ['style' => 'width:100px;'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'headerOptions' => ['style' => 'text-align:center;'],
                        'template' => ' {view}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                $model = 'selectlot';
                                return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
                                            'class' => 'activity-view-link1',
                                            'title' => 'Select',
                                            'data-toggle' => 'modal',
                                            'data-target' => '#determinethenumber',
                                            'data-id' => $key,
                                            'data-pjax' => '0',
                                ]);
                            },
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php \yii\widgets\Pjax::end() ?>
             
            <?php } ?>
    <br>
    <div style="text-align:right">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
           
        </div>
        <?php
        $s = <<< JS
function init_click_handlers() {
      $('.activity-view-link1').click(function (e) {
        var fID = $(this).closest('tr').children('td:eq(0)').text();
        var stkid = $('#tbst2temp-stissue_stkid').val();
        var  srid = $('#srid').val();
       var itemid = $('#vwst2detailgroup-itemid').val();
        var stid = $('#stid').val();
       $.get(
                'index.php?r=Inventory/tb-st2-temp/select-num-ber',
                {
                    id: fID,
                stkid:stkid,
                    srid:srid,
              itemid:itemid,
                stid:stid
                },
        function (data)
        {
         // $.pjax.reload({container:'#lot_select'});
          $('#determinethenumber_detail').html(data);
        }
        );
    });
}
init_click_handlers(); //first run
$('#lot_selects').on('pjax:success', function () {
  init_click_handlers(); //reactivate links in grid after pjax update
}); 
JS;
        $this->registerJs($s);
        ?>


