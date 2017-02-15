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
$this->title = "ประวัติใบรับสินค้าบริจาค";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
    });
JS;
$this->registerJs($script);
?>
    <div id="history" class="tabbable">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="tab-content">
            <div id="tab" class="tab-pane in active ">
                <div class="tb-gr2-temp-index">
                    <?php Pjax::begin(['id'=>'history-pjax','timeout' => 5000]) ?>
                    <?php echo $this->render('_search-history', ['model' => $searchModel]); ?>
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
                                'header' => 'เลขที่ใบรับสินค้า',
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
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'วันที่รับสินค้า',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->GRDate == null) {
                                        return '-';
                                    } else {
                                        return $model->GRDate;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ประเภทการรับสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->grtype->GRType == null) {
                                        return '-';
                                    } else {
                                        return $model->grtype->GRType;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รหัส',
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
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ชื่อ',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->VenderID == null) {
                                        return '-';
                                    } else {
                                        return $model->datavender->VenderName;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'สถานะการรับสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->status->GRStatusDesc == null) {
                                        return '-';
                                    } else {
                                        return $model->status->GRStatusDesc;
                                    }
                                }
                            ],
                                     [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:200px;'],
                                'header' => 'Actions',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'template' => '{detail} {cancel} {print}',
                                'buttons' => [
                                    'print' => function ($url, $model,$key) {
                                     $url = "/km4/Report/report-inventory/grreportrecive?GRID=".$key;
                                        return Html::a('<span class="btn btn-info btn-xs">ใบรับสินค้า</span>', $url, [
                                                    'title' => Yii::t('app', 'ใบรับสินค้า'),
                                                    'target'=>'blank',
                                                    'data-pjax'=>0
                                        ]);
                                    },
                                    'detail' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-success btn-xs">Detail</span>', $url, [
                                                    'title' => Yii::t('app', 'Detail'),
                                        ]);
                                    },
                                    'update' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-info btn-xs">Edit</span>', $url, [
                                                    'title' => Yii::t('app', 'Edit'),
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
                                                    'onclick' => "fn_cancel($model->GRID)",
                                       ]); 
                                    },
                                        ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                        if ($action === 'detail') {//Delete
                                            return Url::to(['create-history', 'GRID' => $model->GRID,'view'=>'view']);
                                        }
                                        if ($action === 'update') {
                                                return Url::to(['create-history', 'GRID' => $model->GRID,'view' => '']);
                                        }
                                        
                                        if ($action === 'delete') {//Delete
                                            return Url::to(['delete', 'id' => $model->GRID]);
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
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
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
<script>
    function fn_cancel($key){
        var GRID = $key;
        swal({   
            title: "ยืนยันคำสั่ง?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: true
            },function(){
                wait();
                $.ajax({
                url: "click-cancel",
                type: "POST",
                data: {GRID: GRID},
                dataType: 'json',
                    success: function (data) {
                        $('#history').waitMe('hide');
                        if(data=='6213624557568926'){
                           location.reload(); 
                        }else{
                           swal('','ไม่สามารถยกเลิกได้','warning');
                        }
                    },
                    error:function (data){
                        $('#history').waitMe('hide');
                        console.log('server error!!');
                    }
                });
            });
    }
    function wait(){
            var current_effect = 'ios'; 
            run_waitMe(current_effect);
            function run_waitMe(effect){
                $('#history').waitMe({
                effect: 'ios',
                text: 'กำลังโหลดข้อมูล...',
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                onClose: function () {}
                });
            }
    }  
</script>