<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <h5 class="success">
            <span class="pull-left">
                <b><?= Html::encode('Detail'); ?></b>
            </span>
            <br>
        </h5>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'responsive' => true,
            'layout' => $layout,
            'hover' => true,
            'striped' => true,
            'condensed' => true,
            'columns' => [
                [
                    'header' => 'Cycle',
                    'attribute' => 'chemo_cycle_seq',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                    'group' => true,
                    'value' => function($model, $key, $index) {
                return empty($model->chemo_cycle_seq) ? '-' : $model->chemo_cycle_seq;
            },
                ],
                [
                    'header' => 'Q',
                    'attribute' => 'q',
                    'group' => true,
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                    'value' => function($model, $key, $index) {
                return empty($model->q) ? '-' : $model->q;
            },
                ],
                [
                    'header' => 'Day',
                    'attribute' => 'chemo_cycle_day',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                    'value' => function($model, $key, $index) {
                return !empty($model->chemo_cycle_day) ? $model->chemo_cycle_day : '-';
            },
                ],
                [
                    'header' => 'Chemo',
                    'attribute' => 'chemo_detail',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                    'value' => function($model, $key, $index) {
                return !empty($model->chemo_detail) ? $model->chemo_detail : '-';
            },
                ],
                /*
                  [
                  'header' => 'Chemo SIG',
                  'attribute' => 'chemo_sig',
                  'contentOptions' => ['class' => 'text-center'],
                  'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                  'value' => function($model, $key, $index) {
                  return empty($model->chemo_sig) ? '-' : $model->chemo_sig;
                  },
                  ], */
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                    'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                    'template' => '{detail} {copy} {edit} {delete}',
                    'noWrap' => true,
                    'header' => 'Actions',
                    'buttons' => [
                        'detail' => function ($key, $model) {
                            //$url = ['update-treatment-plan', 'id' => $model['chemo_regimen_ids']];
                            return Html::a('Detail', 'javascript:void(0);', [
                                        'title' => 'Detail',
                                        'class' => 'btn btn-success btn-xs',
                                        'data-toggle' => 'tooltip',
                            ]);
                        },
                                'copy' => function ($url, $key, $model) {
                            //$url = ['update-treatment-plan', 'id' => $model['chemo_regimen_ids']];
                            return Html::a('Copy', $url, [
                                        'title' => 'Copy',
                                        'class' => 'btn btn-warning btn-xs',
                                        'data-toggle' => 'tooltip',
                            ]);
                        },
                                'edit' => function ($key, $model) {
                            $url = ['standard-index', 'id' => $model['std_trp_chemo_id']];
                            return Html::a('Edit', $url, [
                                        'title' => 'Edit',
                                        'class' => 'btn btn-info btn-xs',
                                        'data-toggle' => 'tooltip',
                            ]);
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', 'javascript:void(0);', [
                                        'title' => 'Delete',
                                        'data-toggle' => 'tooltip',
                            ]);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
    </div>
</div>

