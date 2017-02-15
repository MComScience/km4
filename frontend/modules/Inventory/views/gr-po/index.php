<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbGr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "รับสินค้าจากการสั่งซื้อ";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="tabbable">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="tb-gr2-temp-index">
                <?php Pjax::begin(['id' => 'gr_po', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php // Html::a(Yii::t('app', 'Create Tb Po2 Temp'), ['create'], ['class' => 'btn btn-success']) ?>
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
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;']
                        ],
                            [
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'value' => function ($model, $key, $index, $column) {
                                return kartik\grid\GridView::ROW_COLLAPSED;
                            },
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                            'expandOneOnly' => true,
                            //'header' => '<a>Detail</a>',
                            //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                            //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                            'detailAnimationDuration' => 'slow', //fast
                            'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                            'detailUrl' => \yii\helpers\Url::to(['view-detail']),
                        ],
                            [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เลขที่ใบสั่งซื้อ',
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'วันที่สั่งซื้อ',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->PODate == null) {
                                    return '-';
                                } else {
                                    return $model->PODate;
                                }
                            }
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
                            'header' => 'เลขที่ผู้ขาย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->VendorID == null) {
                                    return '-';
                                } else {
                                    return $model->VendorID;
                                }
                            }
                        ],
                            [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อผู้ขาย',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                if ($model->VenderName == null) {
                                    return '-';
                                } else {
                                    return $model->VenderName;
                                }
                            }
                        ],
                            [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ผู้ผลิต',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                if ($model->MenuName == null) {
                                    return '-';
                                } else {
                                    return $model->MenuName;
                                }
                            }
                        ],
                            [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ประเภทการสั่งซื้อ',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->POType == null) {
                                    return '-';
                                } else {
                                    return $model->POType;
                                }
                            }
                        ],
                            [
                            'class' => 'kartik\grid\ActionColumn',
                            //'contentOptions' => ['style' => 'width:260px;'],
                            'options' => ['style' => 'width:140px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{receive} {manage}',
                            'buttons' => [
                                'receive' => function ($url, $model) {
                                    $chk_temp = \app\modules\Inventory\models\TbGr2Temp::findOne(['PONum' => $model->PONum]);
                                    if ($chk_temp == null) {
                                        if ($model->GRStatusID == null || $model->GRStatusID == '') {
                                            return Html::a('<span class="btn btn-success btn-xs">สร้างใบรับสินค้า</span>', '#', [
                                                        'title' => Yii::t('app', 'สร้างใบรับสินค้า'),
                                                        //'class' => 'activity-select-link',
                                                        'onclick' => "select_po($model->POID)",
                                            ]);
                                        } else {
                                            return Html::a('<span class="btn btn-info btn-xs">รับแล้วบางส่วน</span>', '#', [
                                                        'title' => Yii::t('app', 'รับแล้วบางส่วน'),
                                                        //'class' => 'activity-select-link',
                                                        'onclick' => "select_po($model->POID)",
                                            ]);
                                        }
                                    }
                                },
                                'delete' => function ($url, $model) {
                                    $chk_temp = \app\modules\Inventory\models\TbGr2Temp::findOne(['PONum' => $model->PONum]);
                                    if ($chk_temp == null) {
                                        return Html::a('<span class="btn btn-danger btn-xs">Delete</span>', $url, [
                                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data-method' => "post",
                                                    'role' => 'modal-remote',
                                        ]);
                                    }
                                },
                                'manage' => function ($url, $model) {
                                    $chk_temp = \app\modules\Inventory\models\TbGr2Temp::findOne(['PONum' => $model->PONum]);
                                    if ($chk_temp != null) {
                                        return '<span style="color:#53a93f;">อยู่ในใบร่างสินค้า</span><span class="glyphicon glyphicon-hourglass" style="color:#53a93f;"></span>';
                                    }
                                },
                            ],
                        ],
                    ]
                ]);
                ?>
                <?php Pjax::end() ?>
            </div>
        </div>
        <div class="form-group" style="text-align: right">
            <a href="<?php echo Yii::$app->request->baseUrl; ?>/Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
        </div>
    </div>
</div>
<div class="horizontal-space"></div>
<script>
    function select_po(POID) {
        $.get(
                'create-grtemp',
                {
                    POID
                },
                function (data)
                {
                    if (data != '') {
                        var GRID = data;
                        var url = "create-gr?GRID=" + GRID + "&view=";
                        //alert (url);
                        window.location.replace(url);
                    }
                }
        );

    }
    ;
</script>
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
