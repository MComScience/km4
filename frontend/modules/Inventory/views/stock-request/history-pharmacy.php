<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\Tbsr2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ประวัติการอนุมัติใบขอเบิกสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_E").addClass("active");');
?>
<div class="tbsr2-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu2'); ?>
        <div class="well">
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'historypharmacy']); ?>
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
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->viewsr2['SRDate'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewsr2->SRDate;
                            }
                        }
                    ],
                    [
                        'attribute' => 'SRIssue_stkID',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->viewsr2['stk_issue'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewsr2->stk_issue;
                            }
                        }
                    ],
                    [
                        'attribute' => 'SRReceive_stkID',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->viewsr2['stk_receive'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewsr2->stk_receive;
                            }
                        }
                    ],
                    [
                        'attribute' => 'SRTypeID',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->viewsr2['SRType'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewsr2->SRType;
                            }
                        }
                    ],
                    //   'SRIssue_stkID',
                    // 'SRReceive_stkID',
                    // 'DepartmentID',
                    //'SectionID',
                    //'SRTypeID',
                    // 'SRExpectDate',
                    [
                        'attribute' => 'SRStatus',
                        'hAlign' => 'center',
                        'value' => function ($model) {
                            if ($model->viewsr2['SRStatusDesc'] == NULL) {
                                return '-';
                            } else {
                                return $model->viewsr2->SRStatusDesc;
                            }
                        }
                    ],
                // 'SRStatus',
                // 'SRCreateBy',
                // 'SRCreateDate',
                // 'SRApproveBy',
                // 'SRApproveDate',
                // 'SRRejectApproveBy',
                // 'SRRejectApproveDate',
                // 'SRNote',
//                    [
//                        'class' => 'kartik\grid\ActionColumn',
//                        'options' => ['style' => 'width:160px;'],
//                        'width' => '200px',
//                        'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {update}</div>',
//                        'dropdown' => false,
//                        'vAlign' => 'middle',
//                        'urlCreator' => function($action, $model, $key, $index) {
//                    return Url::to(["updatepha", 'id' => $key]);
//                },
//                       
//                        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'
//                            , 'label' => '
//                <span class="btn btn-success btn-xs">
//                            Select
//                           
//                          </span>',
//                        ]
//                    ],
                ],
            ]);
            ?>
        </div>
    </div>
