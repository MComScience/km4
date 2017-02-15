<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use frontend\assets\SweetAlertAsset;
SweetAlertAsset::register($this);
?>

<div class="tb-pr-temp-view">
    <div class="col-sm-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-green"><div class="panel-title white"><?= Html::encode('Lot Number Detail') ?></div></div>
                <?php
                if (!empty($searchModel)) {
                    ?>

                <?php \yii\widgets\Pjax::begin(['id' => 'sa_detail_expen']) ?>
                <?=
                kartik\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'bootstrap' => true,
                    'responsiveWrap' => FALSE,
                    'responsive' => false,
                    'showPageSummary' => true,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => true,
                    'condensed' => true,
                    'toggleData' => false,
                    'pageSummaryRowOptions' => ['class' => 'default'],
                    'layout' => "\n{items}\n{pager}",
                    'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                    'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                    'columns' => [

                        [
                            'header' => 'InternalLotNumber',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'attribute' => 'ItemInternalLotNum',
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'header' => 'หมายเลชการผลิต',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'attribute' => 'ItemExternalLotNum',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->ItemExternalLotNum == NULL) {
                            return '-';
                        } else {
                            return $model->ItemExternalLotNum;
                        }
                    }
                        ],
                        [
                            'header' => 'วันหมดอายุ',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'attribute' => 'ItemExpDate',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->ItemExpDate == NULL) {
                            return '-';
                        } else {
                            return $model->ItemExpDate;
                        }
                    }
                        ],
                        [
                            'header' => 'หน่วย',
                            'attribute' => 'DispUnit',
                            'headerOptions' => ['style' => 'text-align:center;'],
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
                            'header' => 'ยอดในคลัง',
                            'attribute' => 'OnhandLotItemQty',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'header' => 'นับได้',
                            'attribute' => 'ActualLotItemQty',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'header' => 'ส่วนต่าง',
                            'attribute' => 'AdjLotItemQty',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'header' => 'ยอดหลังจากการปรับปรุง',
                            'attribute' => 'BalanceAdjLotItemQty',
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'hAlign' => GridView::ALIGN_CENTER,
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'noWrap' => true,
                            'options' => ['style' => 'width:100px;'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => ''],
                            'template' => '{update} {deletegpu}',
                            'buttonOptions' => ['class' => 'btn btn-default'],
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="btn btn-success btn-xs">Edit</span>', '#', [
                                                'class' => 'activity-update-link',
                                                'title' => 'แก้ไขข้อมูล',
                                                'data-toggle' => 'modal',
                                                'data-target' => '#gpu-modal',
                                                'data-id' => $key,
                                                'data-pjax' => '0',
                                    ]);
                                },
                                        'deletegpu' => function ($url, $model, $key) {
                                    return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                'title' => 'Delete',
                                                'data-toggle' => 'modal',
                                                'data-id' => $key,
                                                'class' => 'activity-delete-link1',
                                    ]);
                                },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                        <?php \yii\widgets\Pjax::end() ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
        $script = <<<JS
function init_click_handlers() {
   $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var stkid = $('#tbsa2-sa_stkid').val();
        $.get(
                'edit-select',
                {
                    id: fID,stkid:stkid
                },
        function (data)
        {
                $('#form_adjitem_detail').html(data);
                $('#form_adjitem').modal('show');   
                      // $('#formdetail').trigger("reset");
                      // $('#save_detail').find('.modal-body').html(data);
                       //$('#detailitem_save').html(data);
                      // $('#save_detail').modal('show');         
        }
        );
    });                       
    $('.activity-delete-link1').click(function (e) {
        var fID = $(this).closest('tr').data('key');
       swal({
           title: "ยืนยันการคำสั่ง?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                $.post(
                'delete-detail2',
                 {
                    id: fID
                 },
                function (data)
                {
                     $.pjax.reload({container: '#sa_detail_expen'});
                }
                );
            }
        });
    });
}
init_click_handlers(); //first run
$('#sa_detail_expen').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});   
                               
JS;

        $this->registerJs($script);
        ?>

