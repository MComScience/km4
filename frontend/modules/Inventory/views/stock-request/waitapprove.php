<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'ใบขอเบิกสินค้ารออนุมัติ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_B").addClass("active");');
?>
<div class="tbsr2-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel,'type'=>'index']); ?>
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
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                        'header' => '#',
                        'headerOptions' => ['class' => 'kartik-sheet-style']
                    ],
                    [
                        'attribute' => 'SRNum',
                        'hAlign' => 'center'
                    ],
                    [
                        'attribute' => 'SRDate',
                        'hAlign' => 'center',
                        
                    ],
                    [
                        'header' => '<a>เบิกจากคลัง</a>',
                        'attribute' => 'stk_issue',
                        'hAlign' => 'center',
                        
                    ],
                    [
                        'header' => '<a>รับเข้าคลัง</a>',
                        'attribute' => 'stk_receive',
                        'hAlign' => 'center',
                        
                    ],
                    [
                        'attribute' => 'SRType',
                        'hAlign' => 'center',
                       
                    ],
                    [
                        'attribute' => 'SRStatusDesc',
                        'hAlign' => 'center',
                        
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<a>Actions</a>',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => ' {update} {delete}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'update' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-primary btn-xs"> Detail </span>', $url.'&type=index', [
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
     
       bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.post(
                        'index.php?r=Inventory/tbsr2/delete',
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
