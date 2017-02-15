<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\SearchTbSt2Temp */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ร่างใบโอนสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_E").addClass("active");')
?>
<div class="tb-st2-temp-index">
    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tab_menustockissu'); ?>
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'index']); ?>
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
                    'STNum',
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STDate',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->vwstlistdraf['STDate'] == NULL) {
                        return '-';
                    } else {
                        return $model->vwstlistdraf->STDate;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STIssue_StkID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->vwstlistdraf['Stk_issue'] == NULL) {
                        return '-';
                    } else {
                        return $model->vwstlistdraf->Stk_issue;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STRecieve_StkID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->vwstlistdraf['Stk_receive'] == NULL) {
                        return '-';
                    } else {
                        return $model->vwstlistdraf->Stk_receive;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STTypeID',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->vwstlistdraf['STTypeDesc'] == NULL) {
                        return '-';
                    } else {
                        return $model->vwstlistdraf->STTypeDesc;
                    }
                }
                    ],
                    [
                        'headerOptions' => ['style' => 'text-align:center'],
                        'attribute' => 'STStatus',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                    if ($model->vwstlistdraf['STStatusDesc'] == NULL) {
                        return '-';
                    } else {
                        return $model->vwstlistdraf->STStatusDesc;
                    }
                }
                    ],
                    [
                        'header' => '<a>Actions</a>',
                        'class' => 'kartik\grid\ActionColumn',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => '<div class="btn-group btn-group-justified text-center" role="group">  {update}{view}{delete}</div>',
                        'dropdown' => false,
                        'vAlign' => 'middle',
                        'urlCreator' => function($action, $model, $key, $index) {
                    if ($action == 'view') {
                        $action = 'update';
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
                            'label' => '<span class="btn btn-info btn-xs">Detail</span> ',
                        ],
                        'updateOptions' => [
                            'role' => 'modal-remote',
                            'title' => 'Update',
                            'data-toggle' => 'tooltip'
                            , 'label' => '<span class="btn btn-success btn-xs">Edit</span> ',
                        ],
                        'deleteOptions' => [
                            'role' => 'modal-remote',
                            'title' => 'Delete',
                            'data-toggle' => 'tooltip'
                            , 'label' => '<span class="btn btn-danger btn-xs">Delete</span>',
                      //      'data-id' => $key,
                            'class' => 'activity-delete-link',
                        ],
                    ],
                ],
            ]);
            ?>
            <?php yii\widgets\Pjax::end() ?>
        </div>
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

