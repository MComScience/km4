<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Purchasing\models\TbPr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บันทึกใบขอซื้อนอกแผน';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อนอกแผน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_index').addClass("active");
    });
JS;
$this->registerJs($script);
?>
    <div class="tabbable">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="tab-content">
            <div id="tab" class="tab-pane in active ">
                <div class="tb-pr2-temp-index">
                    <?php Pjax::begin([ 'timeout' => 5000, 'id' => 'pjax-gpu-index']) ?>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'toggleData' => true,
                        'layout' => Yii::$app->componentdate->layoutgridview(),
                        'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                            [
                               'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => 'ลำดับ',
                                'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'เลขที่ใบขอซื้อ',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->PRNum == null) {
                                        return '-';
                                    } else {
                                        return $model->PRNum;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'วันที่',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->PRDate == null) {
                                        return '-';
                                    } else {
                                        return $model->PRDate;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ประเภทใบขอซื้อ',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->PRTypeID == null) {
                                        return '-';
                                    } else {
                                        return $model->prtype->PRType;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ประเภทการสั่งซื้อ',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->POTypeID == null) {
                                        return '-';
                                    } else {
                                        return $model->potype->POType;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'กำหนดส่งสินค้า',
                                //'format' => ['date', 'php:d-m-Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->PRExpectDate == null) {
                                        return '-';
                                    } else {
                                        return "ภายใน ".$model->PRExpectDate." วัน";
                                    }
                                }
                            ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    'attribute' => 'PRStatusID',
//                                    'value' => 'prstatus.PRStatus',
//                                    'hAlign' => GridView::ALIGN_CENTER,
//                                ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:160px;'],
                                'header' => 'Actions',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'template' => '{view} {update} {delete}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    //view button
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
                                                    'title' => Yii::t('app', 'view'),
                                        ]);
                                    },
                                            'update' => function ($url, $model) {
                                        if ($model->PRStatusID == 1) {
                                            return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                        
                                            ]);
                                        } 
                                        else {
                                            return Html::a('<span class="btn btn-info btn-xs" disabled="disabled"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#gpu-modal',
                                                            //'class' => 'btn btn-primary btn-xs',
                                            ]);
                                        }
                                    },
                                            'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', $url, [
                                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data-method' => "post",
                                                    'role' => 'modal-remote',
                                        ]);
                                    },
                                        ],
                                        'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                    if ($model->PRTypeID == 6) {//ยาสามัญ
                                        if ($action === 'update') {
                                            return Url::to(['create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 7) {//ยาการค้า
                                        if ($action === 'update') {
                                            return Url::to(['new-pr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => '']);
                                        }
                                    } elseif ( $model->PRTypeID == 8) {//เวชภัณฑ์
                                        if ($action === 'update') {
                                            return Url::to(['new-pr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 11) {
                                        if ($action === 'update') {
                                            return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => '']);
                                        }
                                    } elseif ($model->PRTypeID == 12) {//เวชภัณฑ์ จะซื้อจะขาย
                                        if ($action === 'update') {
                                            return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => '']);
                                        }
                                    }

                                    //View//Delete
                                    if ($model->PRTypeID == 6) {//ยาสามัญ
                                        if ($action === 'view') {//View
                                            return Url::to(['create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                        }
                                        if ($action === 'delete') {//Delete
                                            return Url::to(['delete-pr', 'id' => $key]);
                                        }
                                    } elseif ($model->PRTypeID == 7) {//ยาการค้า
                                        if ($action === 'view') {//View
                                            return Url::to(['new-pr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                        }
                                        if ($action === 'delete') {//Delete
                                            return Url::to(['new-pr-tpu/delete-pr', 'id' => $key]);
                                        }
                                    } elseif ($model->PRTypeID == 8) {//เวชภัณฑ์
                                        if ($action === 'view') {//View
                                            return Url::to(['new-pr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                        }
                                    } elseif ($model->PRTypeID == 11) {
                                        if ($action === 'view') {//View
                                            return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                        }
                                    } elseif ($model->PRTypeID == 12) {//เวชภัณฑ์ จะซื้อจะขาย
                                        if ($action === 'view') {//View
                                            return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                        }
                                    }
                                    if ($action === 'delete') {//Delete
                                        return Url::to(['delete-pr', 'id' => $key]);
                                    }
                                }
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: right">
                    <a href="http://www.udcancer.org/km4/frontend/web/index.php?r=Purchasing/dashboard/index" class="btn btn-default">Close</a>
                    </div>
                </div>
            </div>
            <div class="horizontal-space"></div>


        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 2000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
        <?php
        $script = <<< JS
$(document).ready(function () {
    $(".btn-success.gpu").click(function (e) {
            bootbox.confirm("Are you sure?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: "index.php?r=Purchasing/new-pr-gpu/createprid-temp", // your controller action
                        dataType: "json",
                        //data: {keylist: selected, prtype: prtype},
                        success: function (data) {
                            
                        }
                    });
                }
            });
    });
    $(".btn-success.tpu").click(function (e) {
            bootbox.confirm("Are you sure?", function (result) {
                if (result) {
                    $.ajax({
                        type: "POST",
                        url: "index.php?r=Purchasing/new-pr-gpu/createprid-temp", // your controller action
                        dataType: "json",
                        //data: {keylist: selected, prtype: prtype},
                        success: function (data) {
                            
                        }
                    });
                }
            });
    });
});
               // $(".demo").overlay();
               // $(".demo").overlayout();

$(document).ready(function () {
  $('#tab_A').addClass("active");
});
JS;
        $this->registerJs($script);
        ?>
