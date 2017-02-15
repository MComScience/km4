<?php

use kartik\grid\GridView;
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

$this->title = 'บันทึกใบขอเบิกสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_A").addClass("active");');
echo Yii::$app->finddata->alertsave();
?>

<div class="tb-sr2-temp-index">
    <input type="hidden" id="count_data" value="<?php echo $countdata ?>" />
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'index']); ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'bootstrap' => true,
                'responsiveWrap' => FALSE,
                'responsive' => False,
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
                        // 'header' => 'เลขที่ใบเบิกสินค้า',
                        'attribute' => 'SRNum',
                        'headerOptions' => ['style' => 'color:black'],
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->SRNum == NULL) {
                                return '-';
                            } else {
                                return $model->SRNum;
                            }
                        }
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
                        //'header' => 'สร้างโดย',
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
                        'template' => ' {update} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                            'title' => 'Edit',
                                                //'class' => 'btn btn-primary btn-xs',
                                ]);
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                            //  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'title' => 'Delete',
                                            'data-toggle' => 'modal',
                                            //'data-method' => "post",
                                            //'role' => 'modal-remote',
                                            'data-id' => $key,
                                            'class' => 'activity-delete-link',
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
            title: 'ยืนยันการลบ?',
            text: "",
            type: "error",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
     
                $.post(
                        '/km4/Inventory/stock-request/delete',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#grid-user-pjax'});
                }
                );
       }
                }
                );
    });
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($script);
?>