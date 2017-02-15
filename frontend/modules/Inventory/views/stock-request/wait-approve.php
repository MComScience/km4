<?php

use yii\helpers\Html;
use kartik\grid\GridView;
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

$this->title = 'ใบขอเบิกสินค้ารออนุมัติ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_B").addClass("active");');
?>
<div class="tbsr2-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'wait-approve']); ?>
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
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'header' => '<a>#</a>',
                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']
                    ],
                    [
                        //'header' => 'เลขที่ใบเบิกสินค้า',
                        'attribute' => 'SRNum',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ],
                    [

                        //'header' => 'วันที่',
                        'attribute' => 'SRDate',
                        'hAlign' => 'center',
                        'format' => ['date', 'php:d/m/Y'],
                        'headerOptions' => ['style' => 'color:black'],
                        
                    ],
                    [
                        //'header' => 'ขอเบิกจากคลัง',
                        'attribute' => 'stk_issue',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ]
                    ,
                    [

                        //'header' => 'รับเข้าคลัง',
                        'attribute' => 'stk_receive',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ]
                    , [
                        //'header' => 'ประเภทการขอเบิก',
                        'headerOptions' => ['style' => 'color:black'],
                        'attribute' => 'SRType',
                        'hAlign' => 'center',
                    ],
                    [
                        //'header' => 'สถานะใบขอเบิกสินค้า',
                        'attribute' => 'SRStatusDesc',
                        'headerOptions' => ['style' => 'color:black'],
                        'hAlign' => 'center',
                    ],
                    [
                        //'header' => 'ขอเบิกโดย',
                        'attribute' => 'SRCreateBy',
                        'headerOptions' => ['style' => 'color:black'],
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->SRCreateBy == NULL) {
                                return '-';
                            } else {
                                return $model->SRCreateBy;
                            }
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<a>Actions</a>',
                        'noWrap' => true,
                        'template' => ' {update} {cancel} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                $url = yii\helpers\Url::to(['/Inventory/stock-request/view-wait','id' => $key]);
                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url . '&type=index', [
                                            'title' => 'Detail',
                                            'data-pjax' => 0,
                                ]);
                            },
                                    'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            'data-id' => $key,
                                            'class' => 'activity-delete-link',
                                ]);
                            },
                            'cancel' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs">Cancel</span>','#', [
                                                    'title' => Yii::t('app', 'Cancel'),
                                                    'onclick' => "fn_cancel($model->SRID)",
                                       ]); 
                            },
                                ],
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
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
     
       swal({
            title: "ยืนยันการลบ ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
                $.post(
                        '/km4/Inventory/stock-request/delete2',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#grid-user-pjax'});
                }
                );
            }
        });
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
            $this->registerJs($script);
            ?>
<script>
    function fn_cancel($key){
        var SRID = $key;
        //alert(SRID)
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
                url: "/km4/Inventory/stock-request/click-cancel",
                type: "POST",
                data: {SRID: SRID},
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