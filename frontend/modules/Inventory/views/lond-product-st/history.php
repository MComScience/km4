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
$this->title = "ประวัติส่งคืนสินค้าขอยืม";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_C').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="tabbable">
    <?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="tb-st2-temp-index">
                <?php Pjax::begin(['id'=>'lond_product_history','timeout' => 5000]) ?>
                <?php echo $this->render('_search_history', ['model' => $searchModel]); ?>
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
                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เลขที่ใบโอนสินค้า',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->STNum == null) {
                                    return '-';
                                } else {
                                    return $model->STNum;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'วันที่รับสินค้า',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->STDate == null) {
                                    return '-';
                                } else {
                                    return $model->STDate;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เลขที่ผู้ให้ยืม',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->STPerson == null) {
                                    return '-';
                                } else {
                                    return $model->STPerson;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อผู้ให้ยืม',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->STPerson == null) {
                                    return '-';
                                } else {
                                    return $model->vender->VenderName;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'กำหนดคืน',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->STDueDate == null) {
                                    return '-';
                                } else {
                                    return $model->STDueDate;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'สถานะการรับสินค้า',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->status->STStatusDesc == null) {
                                    return '-';
                                } else {
                                    return $model->status->STStatusDesc;
                                }
                            }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            //'contentOptions' => ['style' => 'width:260px;'],
                            'options' => ['style' => 'width:160px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{view} {cancel} {print}',
                            'buttons' => [
                                    'view' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Detail</span>', $url, [
                                                'title' => Yii::t('app', 'Detail'),
                                    ]);
                                },
                                        'print' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-info btn-xs">Print</span>', '#', [
                                                'title' => Yii::t('app', 'Print'),
                                    ]);
                                },
                                        'delete' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-danger btn-xs">Delete</span>', $url, [
                                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                'title' => Yii::t('app', 'Delete'),
                                                'data-method' => "post",
                                                'role' => 'modal-remote',
                                    ]);
                                },
                                'cancel' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs">Cancel</span>','#', [
                                                    'title' => Yii::t('app', 'Cancel'),
                                                    'onclick' => "fn_cancel($model->STID)",
                                       ]); 
                                },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                //Update
                                if ($action === 'view') {//Delete
                                    return Url::to(['create-history', 'STID' => $model->STID, 'view' => 'view']);
                                }
                                if ($action === 'edit') {
                                    return Url::to(['create-lond-st', 'STID' => $model->STID, 'view' => '']);
                                }
                                if ($action === 'delete') {//Delete
                                    return Url::to(['delete', 'id' => $model->STID]);
                                }
                            }
                                ],
                            ]
                        ]);
                        ?>
                        <?php Pjax::end() ?>
                    </div>
                </div>
                <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/dashboard/index" class="btn btn-default">Close</a>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
<script>
    function fn_cancel($key){
        var STID = $key;
        //alert(STID)
        swal({   
            title: "ยืนยันคำสั่ง?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: true
            },function(){
                $.ajax({
                url: "click-cancel",
                type: "POST",
                data: {STID: STID},
                dataType: 'json',
                    success: function (data) {
                        location.reload(); 
                    },
                    error:function (data){
                        console.log('server error!!');
                    }
                });
            });
    }
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