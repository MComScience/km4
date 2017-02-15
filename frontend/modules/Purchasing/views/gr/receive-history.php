<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = Yii::t('app', 'ประวัติใบรับสินค้า');
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_C').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
    <div class="tabbable">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="tab-content">
            <div id="tab" class="tab-pane in active ">
                <div class="tb-gr2-temp-index">
                    <?php Pjax::begin(['id' => 'list_history']) ?>
                    <?php echo $this->render('_search_list_history', ['model' => $searchModel]); ?>

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        'hover' => true,
                        'striped' => true,
                        'condensed' => true,
                        'toggleData' => false,
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '#',
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GRNum',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->GRNum == null) {
                                return '-';
                            } else {
                                return $model->GRNum;
                            }
                        }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GRDate',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PONum',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->PONum == null) {
                                return '-';
                            } else {
                                return $model->PONum;
                            }
                        }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'VenderID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->VenderID == null) {
                                return '-';
                            } else {
                                return $model->VenderID;
                            }
                        }
                            ],
                            [
                                'header' => '<a>ชื่อผู้ขาย</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'VenderName',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->detailhistory->VenderName == null) {
                                return '-';
                            } else {
                                return $model->detailhistory->VenderName;
                            }
                        }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'POType',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->detailhistory->POType == null) {
                                return '-';
                            } else {
                                return $model->detailhistory->POType;
                            }
                        }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PODueDate',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->detailhistory->PODueDate == null) {
                                return '';
                            } else {
                                return $model->detailhistory->PODueDate;
                            }
                        }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GRStatusID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->detailhistory->GRStatusDesc == null) {
                                return '-';
                            } else {
                                return $model->detailhistory->GRStatusDesc;
                            }
                        }
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => '<a>Actions</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'options' => ['style' => 'width:160px;'],
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'template' => '{detail} {update}',
                                'buttons' => [
                                    'detail' => function ($url, $model, $key) {
                                        return Html::a('<span class="btn btn-success btn-xs">Detail</span>', $url, [
                                                        //'class' => 'activity-delete-link',
//                                                    'title' => 'Detail',
//                                                    'data-toggle' => 'modal',
//                                                    'data-id' => $key,
//                                                    'data-pjax' => '0',
                                        ]);
                                    },
                                            'update' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                    'title' => Yii::t('app', 'Edit'),
                                        ]);
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                    if ($action === 'update') {
                                        return Url::to(['edit-history', 'id' => $key, 'ponum' => $model['PONum'], 'view' => 'receive-history']);
                                    }
                                    //Update
                                    if ($action === 'detail') {
                                        return Url::to(['edit-history', 'id' => $key, 'ponum' => $model['PONum'], 'view' => 'detail-history']);
                                    }
                                }
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="horizontal-space"></div>
        </div>
</div>
        <?php
        $script = <<< JS
function init_click_handlers() {
        $(".activity-delete-link").click(function (e) {
            var fID = $(this).closest("tr").data("key");
            bootbox.confirm("Are you sure delete item?", function (result) {
                if (result) {
                    $.post(
                            'delete-listdraft',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#detaillistdraft'});
                        Notify('Delete Completed!', 'top-right', '2000', 'success', 'fa-check', true);
                    }
                    );
                }
            });
        });
    }
    init_click_handlers(); //first run
    $("#detaillistdraft").on("pjax:success", function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
JS;
        $this->registerJs($script);
        ?>

<script>


</script>
