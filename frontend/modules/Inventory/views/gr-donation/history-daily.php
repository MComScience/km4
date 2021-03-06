<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\TbGr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "ประวัติใบจ่ายสินค้า";
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
                <div class="tb-st2-temp-index">
                    <?php Pjax::begin(['id'=>'daily_issue_history','timeout' => 5000]) ?>
                    <?php echo $this->render('_search_daily', ['model' => $searchModel]); ?>
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
                                'header' => 'วันที่',
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
                                'header' => 'เบิกจากคลัง',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->STIssue_StkID == null) {
                                        return '-';
                                    } else {
                                        return $model->datastk->StkName;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ประเภทการขอเบิก',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->sttype->STTypeDesc == null) {
                                        return '-';
                                    } else {
                                        return $model->sttype->STTypeDesc;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'สถานะใบโอนสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->STStatus == null) {
                                        return '-';
                                    } else {
                                        return $model->datastatus->STStatusDesc;
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
                                'template' => '{view} {cancel}',
                                'buttons' => [
                                    'view' => function ($url, $model) {
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
                                                    'onclick' => "fn_cancel($model->STID)",
                                       ]); 
                                    },
                                        ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                    //Update
                                        if ($action === 'view') {//Delete
                                            return Url::to(['create-history', 'STID' => $model->STID,'view'=>'view']);
                                        }
                                        if ($action === 'update') {
                                                return Url::to(['create-history', 'STID' => $model->STID,'view' => '']);
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
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
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
                wait();
                $.ajax({
                url: "index.php?r=Inventory/daily-issue/click-cancel",
                type: "POST",
                data: {STID: STID},
                dataType: 'json',
                    success: function (data) {
                        $('#history').waitMe('hide');
                        location.reload(); 
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