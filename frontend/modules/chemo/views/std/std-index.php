<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'New Standard Regimen';
$this->params['breadcrumbs'][] = ['label' => 'แพทย์', 'url' => ['/chemo']];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#content1">
                        <?= Html::encode('New Standard Regimen'); ?>
                    </a>
            </ul>
            <div class="tab-content">
                <div id="content1" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <?php echo $this->render('_form_std_index', ['model' => $model]); ?> 
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-12">
                            <span class="success"><b>Detail</b></span>
                            <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create-std-detail', 'id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm']) ?>
                            <?= Html::a('Duplicate', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm']) ?>
                            <p></p>
                            <?php Pjax::begin(['id' => 'stdtrp-details-pjax']); ?> 
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                'responsive' => true,
                                'layout' => $layout,
                                'condensed' => true,
                                'bordered' => true,
                                'hover' => true,
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;background-color: #ddd;'],
                                    ],
//                                    [
//                                        'class' => 'kartik\grid\ExpandRowColumn',
//                                        'value' => function ($model, $key, $index, $column) {
//                                            return GridView::ROW_EXPANDED;
//                                        },
//                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;background-color: #ddd'],
//                                        'expandOneOnly' => true,
//                                        'detailAnimationDuration' => 'slow', //fast
//                                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
//                                        'detailUrl' => Url::to(['std-details']),
//                                    ],
                                    [
                                        'attribute' => 'chemo_cycle_seq',
                                        'header' => 'Cycle',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_cycle_seq) ? '-' : $model->chemo_cycle_seq;
                                }
                                    ],
                                    [
                                        'attribute' => 'chemo_cycle_day',
                                        'header' => 'Day',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_cycle_day) ? '-' : $model->chemo_cycle_day;
                                }
                                    ],
                                    [
                                        'attribute' => 'chemo_detail',
                                        'header' => 'Chemo',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_detail) ? '-' : $model->chemo_detail;
                                }
                                    ],
                                    [
                                        'attribute' => 'chemo_sig',
                                        'header' => 'Chemo SIG',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_sig) ? '-' : $model->chemo_sig;
                                }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                        'template' => '{detail} {edit} {delete}',
                                        'buttons' => [
                                            'detail' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                                                            'title' => 'Detail',
                                                            'data-toggle' => 'tooltip'
                                                ]);
                                            },
                                                    'edit' => function ($key, $model) {
                                                $url = ['create-std-regimen', 'ids' => $model['std_trp_chemo_ids'],'id' => $model['std_trp_chemo_id'],'drugset_id' => $model['drugset_id']];
                                                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', $url, [
                                                            'title' => 'Edit',
                                                            'data-toggle' => 'tooltip',
                                                ]);
                                            },
                                                    'delete' => function ($model, $key) {
                                                return Html::a('<span class="btn btn-danger btn-xs">Delete</span>', '#', [
                                                            'title' => 'Delete',
                                                            'data-toggle' => 'modal',
                                                            'class' => 'activity-delete-link',
                                                ]);
                                            },
                                                ],
                                            ],
                                        ],
                                    ]);
                                    ?>
                                    <?php Pjax::end(); ?>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>

            </div>
        </div>
        <?php
        $script1 = <<< JS
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=chemo/std/delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#stdtrp-details-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#stdtrp-details-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
        $this->registerJs($script1);
        ?>