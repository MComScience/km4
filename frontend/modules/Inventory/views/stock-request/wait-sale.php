<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'รอการจ่ายสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_C").addClass("active");');
?>
<div class="tbsr2-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'wait-sale(']); ?>
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
                        'width' => '36px',
                        'header' => '#',
                         'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']
                    ],
                    [
                        'header' => 'เลขที่ใบเบิกสินค้า',
                        'attribute' => 'SRNum',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ],
                    [

                        'header' => 'วันที่',
                        'attribute' => 'SRDate',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ],
                    [
                        'header' => 'ขอเบิกจากคลัง',
                        'attribute' => 'stk_issue',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ]
                    ,
                    [

                        'header' => 'รับเข้าคลัง',
                        'attribute' => 'stk_receive',
                        'hAlign' => 'center',
                        'headerOptions' => ['style' => 'color:black'],
                    ]
                    , [
                        'header' => 'ประเภทการขอเบิก',
                        'headerOptions' => ['style' => 'color:black'],
                        'attribute' => 'SRType',
                        'hAlign' => 'center',
                    ],
                    [
                        'header' => 'สถานะใบขอเบิกสินค้า',
                        'attribute' => 'SRStatusDesc',
                        'headerOptions' => ['style' => 'color:black'],
                        'hAlign' => 'center',
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                         'header' => '<font color="black">Actions</font>',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => ' {update} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                         $url = 'index.php?r=Inventory/stock-request/view-wait&id=' . $key;
                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url.'&type=waitsale', [
                                            'title' => 'Detail',
                                            'data-pjax' => 0
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
                                ],
                            ],
                        ],
                    ]);
                    ?>
                    <?php yii\widgets\Pjax::end() ?>
                </div>
            </div>
            <?php
            $script = <<< JS
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
     
       swal({
             title: "Are you sure?",
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
                       'index.php?r=Inventory/stock-request/delete2',
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
