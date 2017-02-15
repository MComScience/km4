<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'ประวัติรับสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_H").addClass("active");');
?>
<div class="tb-st2-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menu'); ?>
        <div class="well">
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'stock-receive-history']); ?>
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
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'header' => '<a>#</a>',
                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black']

                    ],
                    [
                        //'header'=>'<font color="black">หมายเลขใบโอนสินค้า</font>',
                        'attribute' => 'STNum',
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => GridView::ALIGN_CENTER,
                    ],
                    [
                        //'header'=>'<font color="black">วันที่</font>',
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
                          //'header'=>'<font color="black">รับเข้าคลังสินค้า</font>',
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
                          //'header'=>'<font color="black">สถานะใบเบิกสินค้า</font>',
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
                          //'header'=>'<font color="black">รับสินค้าโดย</font>',
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
                        'noWrap' => true,
                        'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {update}</div>',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'urlCreator' => function($action, $model, $key, $index) {
                    $action = 'detail';
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
                            'label' => '<span class="btn btn-info btn-xs">Select</span>',
                        ],
                        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Detail', 'data-toggle' => 'tooltip'
                            , 'label' => '
                <span class="btn btn-success btn-xs">
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
            <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/dashboard-v2/cmd-listdrugnew" class="btn btn-default">Close</a>
            </div>
        </div>
    </div>
