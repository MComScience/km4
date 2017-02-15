<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use frontend\assets\SweetAlertAsset;
SweetAlertAsset::register($this);

$this->title = 'ร่างใบขอซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php Pjax::begin(['timeout' => 5000, 'id' => 'pjax-gpu-index']) ?>
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="tab" class="tab-pane in active ">
                    <div class="tb-pr2-temp-index">
                        <?php echo $this->render('_search', ['model' => $searchModel, 'action' => 'index']); ?>
                        <br>
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
                            'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            'columns' => [
                                    [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => '#',
                                    'headerOptions' => ['class' => 'kartik-sheet-style;', 'style' => 'color:black;']
                                ],
                                    [
                                    'header' => 'เลขที่ใบขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRNum',
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
                                    'header' => 'วันที่',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRDate',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                    [
                                    'header' => 'ประเภทใบขอซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->PRTypeID == null) {
                                            return '-';
                                        } else {
                                            return $model->prtemplist->PRType;
                                        }
                                    }
                                ],
                                    [
                                    'header' => 'ประเภทการสั่งซื้อ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'POTypeID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->POTypeID == null) {
                                            return '-';
                                        } else {
                                            return $model->prtemplist->POType;
                                        }
                                    }
                                ],
                                    [
                                    'header' => 'กำหนดเวลาการส่งมอบ',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'attribute' => 'PRExpectDate',
                                    //'format' => 'raw',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function($model) {
                                        return 'ภายใน ' . $model->PRExpectDate . ' วัน';
                                    }
                                ],
                                    [
                                    'class' => 'kartik\grid\ActionColumn',
                                    //'contentOptions' => ['style' => 'width:260px;'],
                                    'options' => ['style' => 'width:160px;'],
                                    'header' => 'Actions',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{view} {update} {delete}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        //view button
                                        'view' => function ($url, $model) {
                                            if (!empty($model->PRNum)) {
                                                return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
                                                            'title' => Yii::t('app', 'View'),
                                                            'data-pjax' => 0,
                                                            'data-toggle' => 'tooltip',
                                                ]);
                                            }
                                        },
                                        'update' => function ($url, $model) {
                                            if ($model->PRStatusID == 1 && !empty($model->PRNum)) {
                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                            'title' => Yii::t('app', 'Edit'),
                                                            'data-pjax' => 0,
                                                            'data-toggle' => 'tooltip',
                                                ]);
                                            }
                                        },
                                        'delete' => function ($url, $model) {
                                            if (!empty($model->PRNum)) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                            'title' => Yii::t('app', 'Delete'),
                                                            'data-toggle' => 'tooltip',
                                                            //'data-method' => "post",
                                                            //'role' => 'modal-remote',
                                                            'class' => 'activity-delete-link',
                                                ]);
                                            } else {
                                                return '<span class="success">กำลังทำรายการ</span>';
                                            }
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        $encode = base64_encode($model->PRID);
                                        //Update
                                        if ($model->PRTypeID == 1) {//ยาสามัญ
                                            if ($action === 'update') {
                                                return Url::to(['addpr-gpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 2) {//ยาการค้า
                                            if ($action === 'update') {
                                                return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                                            if ($action === 'update') {
                                                return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 4) {
                                            if ($action === 'update') {
                                                return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => $encode]);
                                            }
                                        } elseif ($model->PRTypeID == 5) {//เวชภัณฑ์ จะซื้อจะขาย
                                            if ($action === 'update') {
                                                return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => $encode]);
                                            }
                                        }

                                        //View//Delete
                                        if ($model->PRTypeID == 1) {//ยาสามัญ
                                            if ($action === 'view') {//View
                                                return Url::to(['create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {//Delete
                                                return Url::to(['delete-tempgpu', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 2) {//ยาการค้า
                                            if ($action === 'view') {//View
                                                return Url::to(['addpr-tpu/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {//Delete
                                                return Url::to(['addpr-tpu/delete-tempgpu', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 3) {//เวชภัณฑ์
                                            if ($action === 'view') {//View
                                                return Url::to(['addpr-nd/create', 'ids_PR_selected' => '', 'PRID' => $model['PRID'], 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {//Delete
                                                return Url::to(['addpr-nd/delete-temp', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 4) {
                                            if ($action === 'view') {//View
                                                return Url::to(['addpr-tpu-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {//Delete
                                                return Url::to(['addpr-tpu-cont/delete-temp', 'id' => $model->PRID]);
                                            }
                                        } elseif ($model->PRTypeID == 5) {//เวชภัณฑ์ จะซื้อจะขาย
                                            if ($action === 'view') {//View
                                                return Url::to(['addpr-nd-cont/create', 'ids_PR_selected' => '', 'PRID' => $model->PRID, 'view' => 'view']);
                                            }
                                            if ($action === 'delete') {//Delete
                                                return Url::to(['addpr-nd-cont/delete-temp', 'id' => $model->PRID]);
                                            }
                                        }
//                                    if ($action === 'delete') {//Delete
//                                        return Url::to(['delete-tempgpu', 'id' => $model->PRID]);
//                                    }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                        <?php
                        $script = <<< JS
                        $(document).ready(function () {
                           $('#tab_A').addClass("active");
                        });
JS;
                        $this->registerJs($script);
                        ?>
                        <?php Pjax::end() ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>

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
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
    swal({
        title: "ยืนยันการลบ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'delete-tempgpu',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#pjax-gpu-index'});
                    }
                    );
                }
            });
});
}
init_click_handlers(); //first run
$('#pjax-gpu-index').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($script);
?>


