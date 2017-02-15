<?php

use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'ใบโอนสินค้ารอรับเข้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_F").addClass("active");');
?>
<div class="tb-st2-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('tab_stock-recev'); ?>
        <div class="well">


            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 50000]) ?>
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
                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'STNum',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        'attribute' => 'STDate',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                          'value' => function ($model) {
                        if ($model->viewst2list['STDate'] == NULL) {
                        return '-';
                    } else {
                        return $model->viewst2list->STDate;
                    }
                    }
                    ],
                    [
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
                    [
                        'header'=>'<a>Actions</a>',
                        'class' => 'kartik\grid\ActionColumn',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {update}</div>',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'urlCreator' => function($action, $model, $key, $index) {
                    $action = 'detail';
                    return Url::to([$action, 'id' => $key, 'status' => '0']);
                },
                        'viewOptions' => [
                            'class' => 'activity-view-link',
                            'role' => 'modal-remote',
                            'title' => 'View',
                            'data-toggle' => 'tooltip',
//                        'data-target' => '#activity-modal',
                            //'data-id' => $key,
                            'data-pjax' => '0',
                            'label' => '<span class="btn btn-success btn-xs">Select</span>',
                        ],
                        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'
                            , 'label' => '
                <span class="btn btn-info btn-xs">
                            Detail
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




