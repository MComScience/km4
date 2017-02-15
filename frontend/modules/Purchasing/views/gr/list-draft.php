<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Purchasing\models\TbGr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'รับสินค้าจากการสั่งซื้อ');
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
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
                        <?php Pjax::begin(['id' => 'detaillistdraft']) ?>
                        <?php echo $this->render('_search_list_draft', ['model' => $searchModel]); ?>

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
                                    'format' => ['html'],
                                    'value' => function ($model) {
                                if ($model->detaildraft->VenderName == null) {
                                    return '-';
                                } else {
                                    return $model->detaildraft->VenderName;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'POType',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->detaildraft->POType == null) {
                                    return '-';
                                } else {
                                    return $model->detaildraft->POType;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'PODueDate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                return $model->detaildraft->PODueDate;
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    'attribute' => 'GRStatusID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->detaildraft->GRStatusDesc == null) {
                                    return '-';
                                } else {
                                    return $model->detaildraft->GRStatusDesc;
                                }
                            }
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => '<a>Actions</a>',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'options' => ['style' => 'width:160px;'],
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'template' => '{update} {delete}',
                                    'buttons' => [
                                        'update' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-primary btn-xs"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                            ]);
                                        },
                                                'delete' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-danger btn-xs">Delete</span>', '#', [
                                                        'class' => 'activity-delete-link',
                                                        'title' => 'Delete',
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        //Update
                                        if ($action === 'update') {
                                            return Url::to(['create', 'poid' => $model->detaildraft->POID, 'ponum' => $model['PONum'], 'view' => 'list-draft']);
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
                            'index.php?r=Purchasing/gr/delete-listdraft',
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

