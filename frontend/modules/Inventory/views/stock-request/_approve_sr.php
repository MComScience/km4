<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'อนุมัติใบเบิกสินค้า';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("#tab_C").addClass("active");');
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="well">
                <div id="overview" class="tab-pane active">
                    <div class="row profile-overview">
                        <div class="col-xs-12 col-md-12">
                        <?php Pjax::begin([ 'timeout' => 5000]) ?>
                        <?php echo Yii::$app->finddata->alertsave() ?>
                        <?php echo $this->render('search_detail', ['model' => $searchModel,'type' => 'approve-sr']); ?>
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
                                'layout' => Yii::$app->componentdate->layoutgridview2(),
                                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],

                                'columns' => [
                                    [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'header' => '<a>#</a>',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']
                                    ],

                                    [
                                    'attribute' => 'SRNum',
                                    'hAlign' => 'center'
                                    ],

                                    [
                                    'attribute' => 'SRDate',
                                    'hAlign' => 'center',
                                    'format' => ['date', 'php:d/m/Y'],
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

                                    [
                                    'attribute' => 'SRCreateBy',
                                    'headerOptions' => ['style' => 'color:black'],
                                    'hAlign' => 'center',
                                    'value' => function ($model) {
                                        if ($model->viewsr2->SRCreateBy == NULL) {
                                            return '-';
                                        } else {
                                            return $model->viewsr2->SRCreateBy;
                                        }
                                    }
                                    ],

                                    [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => '<a>Actions</a>',
                                    'noWrap' => true,
                                    'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {update}</div>',
                                    'dropdown' => false,
                                    'vAlign' => 'middle',
                                    'urlCreator' => function($action, $model, $key, $index) {
                                            return Url::to(["approvereq", 'id' => $key]);
                                        },
                                    'updateOptions' => ['role' => 'modal-remote', 'title' => 'Select', 'data-toggle' => 'tooltip'
                                        , 'label' => '
                                        <span class="btn btn-success btn-xs">
                                            Select
                                           
                                          </span>',
                                        ]
                                    ],  
                                ],
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
        </div>
    </div>
</div>


