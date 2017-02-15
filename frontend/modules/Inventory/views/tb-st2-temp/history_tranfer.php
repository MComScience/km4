<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\Html;
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

$this->title = 'ประวัติการโอนสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_G").addClass("active");')
?>
<div class="tb-st2-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">


            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 50000]) ?>
             <?php echo Yii::$app->finddata->alertsave() ?>
            <?php echo $this->render('_search', ['model' => $searchModel,'type'=>'stock-receive']);  ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'bootstrap' => true,
                'responsiveWrap' => FALSE,
                'responsive' => true,
                'hover' => true,
                'pjax' => true,
                'striped' => true,
                'condensed' => true,
                'toggleData' => false,
                'layout' => Yii::$app->componentdate->layoutgridview(),
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'columns' => [
                    [
                        'header' => '<a>#</a>',
                        'class' => 'yii\grid\SerialColumn'
                    ],
                    [
                          //'header'=>'<font color="black">หมายเลขใบโอนสินค้า</font>',
                        'attribute' => 'STNum',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                         // 'header'=>'<font color="black">วันที่</font>',
                        'attribute' => 'STDate',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'format' => ['date', 'php:d/m/Y'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    
                    ],
                             
                    [
                        //'header'=>'<font color="black">เบิกจากคลัง</font>',
                        'attribute' => 'STIssue_StkID',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->viewst2list['Stk_issue'] == NULL) {
                        return '-';
                    } else {
                        return $model->viewst2list->Stk_issue;
                    }
                }
                    ],
                            
                    [
                         // 'header'=>'<font color="black">รับเข้าคลังสินค้า</font>',
                        'attribute' => 'STRecieve_StkID',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->viewst2list['Stk_receive'] == NULL) {
                        return '-';
                    } else {
                        return $model->viewst2list->Stk_receive;
                    }
                }
                    ],
                    [
                         //'header'=>'<font color="black">ประเภทการขอเบิก</font>',
                        'attribute' => 'STTypeID',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->viewst2list['STTypeDesc'] == NULL) {
                        return '-';
                    } else {
                        return $model->viewst2list->STTypeDesc;
                    }
                }
                    ],
                    [
                         // 'header'=>'<font color="black">สถานะใบเบิกสินค้า</font>',
                        'attribute' => 'STStatus',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->viewst2list['STStatusDesc'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewst2list->STStatusDesc;
                            }
                        }
                    ],
                    // [
                    //       //'header'=>'<font color="black">โอนสินค้าโดย</font>',
                    //     'attribute' => 'STCreateBy',
                    //     'headerOptions' => ['style' => 'text-align:center'],
                    //     'hAlign' => GridView::ALIGN_CENTER,
                    //     'value' => function ($model) {
                    //         if ($model->viewst2list['STCreateBy'] == NULL) {
                    //             return '-';
                    //         } else {
                    //             return $model->viewst2list->STCreateBy;
                    //         }
                    //     }
                    // ],
                    // [
                    //       //'header'=>'<font color="black">โอนสินค้าโดย</font>',
                    //     'attribute' => 'STCreateBy',
                    //     'headerOptions' => ['style' => 'text-align:center'],
                    //     'hAlign' => GridView::ALIGN_CENTER,
                    //     'value' => function ($model) {
                    //         if ($model->viewst2list['STCreateBy'] == NULL) {
                    //             return '-';
                    //         } else {
                    //             return $model->viewst2list->STCreateBy;
                    //         }
                    //     }
                    // ],
                    [
                          //'header'=>'<font color="black">โอนสินค้าโดย</font>',
                        'attribute' => 'STCreateBy',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->viewst2list['STCreateBy'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewst2list->STCreateBy;
                            }
                        }
                    ],
                    [
                          //'header'=>'<font color="black">โอนสินค้าโดย</font>',
                        'attribute' => 'STRecievedBy',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->viewst2list['STRecievedBy'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewst2list->STRecievedBy;
                            }
                        }
                    ],
                    [
                       'header' => '<a>Actions</a>',
                        'class' => 'kartik\grid\ActionColumn',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => '{update} {cancel}',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                       	'urlCreator' => function($action, $model, $key, $index) {
	                        $action = 'detail';
                            return Url::to([$action, 'id' => $key, 'status' => '0']);
	                    },
	                    'buttons' => [
                                'cancel' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-danger btn-xs">Cancel</span>','#', [
                                        'title' => Yii::t('app', 'Cancel'),
                                        'onclick' => "fn_cancel($model->STID);",
                                    ]);
                                },
                        ],
                        'viewOptions' => [
                            'class' => 'activity-view-link',
                            'role' => 'modal-remote',
                            'title' => 'View',
                            'data-toggle' => 'tooltip',
//                        'data-target' => '#activity-modal',
                            //'data-id' => $key,
                            'data-pjax' => '0',
                            'label' => '<span class="btn btn-info btn-xs">Select</span>',
                        ],
                        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Select', 'data-toggle' => 'tooltip'
                            , 'label' => '
                <span class="btn btn-success btn-xs">
                            Select
                          </span>',
                        ],
                        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
                            //'data-confirm' => false, 'data-method' => false, // for overide yii data api
                            //'data-request-method' => 'post',
                            'data-toggle' => 'tooltip',
                            'data-confirm-title' => 'Are you sure?',
                            'data-confirm-message' => 'Are you sure want to delete this item'
                            , 'label' => '
                			<span class="btn btn-danger btn-xs">
                            Delete
                          </span> ',
                        ]
                    ],
                ],
            ]);
            ?>
            <?php yii\widgets\Pjax::end() ?>
            <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
            </div>
        </div>
    </div>
    <?php
    $script = <<< JS
$(document).ready(function () {
      //  setInterval(function(){ $.pjax.reload({container:'#grid-user-pjax'}); }, 10000);
});
JS;
    $this->registerJs($script);
    ?>
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
                url: "/km4/Inventory/tbst2/click-cancel",
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



