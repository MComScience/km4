<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$iconplus = '<i class="glyphicon glyphicon-plus"></i>';

$script1 = <<< JS
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=chemos/std/delete-drugsetdetail',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#drugdetdetail-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#drugdetdetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
$this->registerJs($script1);
?>

<style>
    div#solution-modal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>


<?php Pjax::begin(['id' => 'drugdetdetail-pjax']); ?>
<div class="form-group">
    <div class="col-lg-12 col-sm-6 col-xs-12">

        <h5 class="success">
            <b><?= Html::encode('เปิดเส้น :'); ?></b>
            <?= Html::a($iconplus . 'เปิดเส้น', ['create-keep-vein', 'drugset_id' => $drugset_id, 'chemo_ids' => $model->std_trp_chemo_ids, 'chemo_id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]); ?>
            <?= Html::a($iconplus . 'Premedication', ['create-premedication', 'drugset_id' => $drugset_id, 'chemo_ids' => $model->std_trp_chemo_ids, 'chemo_id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]); ?>
            <?=
            Html::a($iconplus . 'Chemo IV', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm', 'onclick' => 'GetmodalIVSolution(this);']) . ' ' .
            Html::a($iconplus . 'Chemo Inj', ['create-inj', 'drugset_id' => $drugset_id, 'chemo_ids' => $model->std_trp_chemo_ids, 'chemo_id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
            ?>
            <b><?= Html::encode('Home med :'); ?></b>
            <?=
            Html::a($iconplus . 'Drug', ['create-medication', 'drugset_id' => $drugset_id, 'chemo_ids' => $model->std_trp_chemo_ids, 'chemo_id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-success btn-sm', 'role' => 'modal-remote',]) . ' ' .
            Html::a($iconplus . 'Chemo P.O.', ['create-chemopo', 'drugset_id' => $drugset_id, 'chemo_ids' => $model->std_trp_chemo_ids, 'chemo_id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm', 'role' => 'modal-remote',]);
            ?>
        </h5>

        <?=
        GridView::widget([
            'dataProvider' => $keepProvider,
            'layout' => $layout,
            'showPageSummary' => true,
            'striped' => true,
            'condensed' => true,
            'hover' => true,
            'bordered' => true,
            'pjax' => true,
            'headerRowOptions' => [
                'class' => GridView::TYPE_DEFAULT
            ],
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'columns' => [
                [
                    'class' => '\kartik\grid\SerialColumn',
                    'width' => '35px',
                ],
                [
                    'header' => 'cpoe_itemtype_decs',
                    'attribute' => 'cpoe_Itemtype',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->cpoe_itemtype_decs) ? '' : $model->cpoe_itemtype_decs;
            },
                    'group' => true, // enable grouping,
                    'groupedRow' => true, // move grouped column to a single grouped row
                    'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                    'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                ],
                [
                    'header' => 'รหัสสินค้า',
                    'attribute' => 'ItemID',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->ItemID) ? '' : $model->ItemID;
            },
                ],
                [
                    'header' => 'รายการ',
                    'attribute' => 'ItemDetail',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->ItemDetail) ? '' : $model->ItemDetail;
            },
                ],
                [
                    'header' => 'จำนวน',
                    'attribute' => 'ItemQty1',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->ItemQty1) ? '' : $model->ItemQty1;
            },
                ],
                [
                    'header' => 'ราคา/หน่วย',
                    'attribute' => 'ItemPrice',
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    'pageSummary' => 'รวม',
                    'value' => function($model, $key, $index) {
                return empty($model->ItemPrice) ? '' : $model->ItemPrice;
            },
                ],
                [
                    'header' => 'จำนวนเงิน',
                    'attribute' => 'Item_Amt',
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'format' => ['decimal', 2],
                    'pageSummary' => true,
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    'value' => function($model, $key, $index) {
                return empty($model->Item_Amt) ? '' : $model->Item_Amt;
            },
                ],
                [
                    'header' => 'เบิกได้',
                    'attribute' => 'Item_Cr_Amt_Sum',
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'pageSummary' => true,
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    //'format' => ['decimal', 2],
                    'value' => function($model, $key, $index) {
                return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
            },
                ],
                [
                    'header' => 'เบิกไม่ได้',
                    'attribute' => 'Item_Pay_Amt',
                    'contentOptions' => ['class' => 'text-right'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'pageSummary' => true,
                    'pageSummaryOptions' => ['style' => 'text-align:right'],
                    //'format' => ['decimal', 2],
                    'value' => function($model, $key, $index) {
                return empty($model->Item_Pay_Amt) ? '' : $model->Item_Pay_Amt;
            },
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                    'template' => '{update} {delete}',
                    'noWrap' => true,
                    'header' => 'Actions',
                    'buttons' => [
                       
                                'update' => function ($key, $model) {
                            if ($model['cpoe_Itemtype'] == 21) {
                                $url = ['edit-keep-vein', 'ids' => $model['drugset_ids']];
                                return Html::a('Edit', $url, [
                                            'title' => 'Edit',
                                            'class' => 'btn btn-info btn-xs',
                                            'role' => 'modal-remote',
                                ]);
                            }

                            if ($model['cpoe_Itemtype'] == 22) {
                                $url = ['edit-premedication', 'ids' => $model['drugset_ids']];
                                return Html::a('Edit', $url, [
                                            'title' => 'Edit',
                                            'class' => 'btn btn-info btn-xs',
                                            'role' => 'modal-remote',
                                ]);
                            }

                            if ($model['cpoe_Itemtype'] == '50') {
                                return Html::a('Edit', 'javascript:void(0);', [
                                            'title' => 'Edit',
                                            'onclick' => 'EditIVSolution(' . $model['drugset_ids'] . ');',
                                            'class' => 'btn btn-info btn-xs'
                                ]);
                            } else if ($model['cpoe_Itemtype'] == '53') {
                                $url = ['edit-inj', 'ids' => $model['drugset_ids']];
                                return Html::a('Edit', $url, [
                                            'title' => 'Edit',
                                            'class' => 'btn btn-info btn-xs',
                                            'role' => 'modal-remote',
                                ]);
                            }

                            if ($model['cpoe_Itemtype'] == 54) {
                                $url = ['edit-chemopo', 'ids' => $model['drugset_ids']];
                                return Html::a('Edit', $url, [
                                            'title' => 'Edit',
                                            'class' => 'btn btn-info btn-xs',
                                            'role' => 'modal-remote',
                                ]);
                            } else if ($model['cpoe_Itemtype'] == '10' || $model['cpoe_Itemtype'] == '20') {
                                $url = ['edit-medication', 'ids' => $model['drugset_ids']];
                                return Html::a('Edit', $url, [
                                            'title' => 'Edit',
                                            'class' => 'btn btn-info btn-xs',
                                            'role' => 'modal-remote',
                                ]);
                            }
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                        'title' => 'Delete',
                                        'data-toggle' => 'modal',
                                        'class' => 'activity-delete-link',
                            ]);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
        <?php Pjax::end(); ?>

        <script>
            function GetmodalIVSolution() {
                var drugset_id = <?= "'" . $drugset_id . "'" ?>;
                var chemo_ids = <?= "'" . $model->std_trp_chemo_ids . "'" ?>;
                var chemo_id = <?= "'" . $model->std_trp_chemo_id . "'" ?>;
                $.ajax({
                    url: 'index.php?r=chemos/std/ivsolution',
                    type: 'get',
                    data: {drugset_id: drugset_id, chemo_ids: chemo_ids, chemo_id: chemo_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#solution-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        $('#solution-modal').modal('show');

                    }
                });
            }

            function EditIVSolution(id) {
                var chemo_ids = <?= "'" . $model->std_trp_chemo_ids . "'" ?>;
                var chemo_id = <?= "'" . $model->std_trp_chemo_id . "'" ?>;
                $.ajax({
                    url: 'index.php?r=chemos/std/edit-ivsolution',
                    type: 'get',
                    data: {id: id, chemo_ids: chemo_ids, chemo_id: chemo_id},
                    dataType: 'json',
                    success: function (data) {
                        $('#solution-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        $('#solution-modal').modal('show');
                    }
                });
            }
        </script>
