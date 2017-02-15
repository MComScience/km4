<?php

use kartik\grid\GridView;
use yii\helpers\Url;


$this->title = 'รายการขอเบิกสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_B").addClass("active");')
?>
<div class="tbsr2-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menustockissu'); ?>
        <div class="well">
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
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'SRNum',
                        'hAlign' => 'center'
                    ],
                    [
                        'attribute' => 'SRDate',
                        'hAlign' => 'center'
                    ],
                    [
                        'attribute' => 'stk_issue',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['stk_issue'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->stk_issue;
//                            }
//                        }
                    ],
                    [
                        'attribute' => 'stk_receive',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['stk_receive'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->stk_receive;
//                            }
//                        }
                    ],
                    [
                        'attribute' => 'SRType',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['SRType'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->SRType;
//                            }
//                        }
                    ],
                    [
                        'attribute' => 'SRStatusDesc',
                        'hAlign' => 'center',
//                        'value' => function ($model) {
//                            if ($model->viewsr2['SRStatusDesc'] == NULL) {
//                                return '-';
//                            } else {
//                                return $model->viewsr2->SRStatusDesc;
//                            }
//                        }
                    ],
                    [
                        'header'=>'<a>Actions</a>',
                        'class' => 'kartik\grid\ActionColumn',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {view}{update}</div>',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'urlCreator' => function($action, $model, $key, $index) {
                    if ($action == 'view') {
                        $action = 'createheader';
                    } else if ($action == 'update') {
                        $action = 'detail1';
                    }
                    return Url::to([$action, 'id' => $key]);
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
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
