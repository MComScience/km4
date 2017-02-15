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
                <b><?= Html::encode('Details'); ?></b>
            </span>

            <span class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-chemoadd', 'chemoid' => $chemoid], ['class' => 'btn-xs btn btn-purple']); ?> 
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
                    'headerOptions' => ['style' => 'color:black;'],
                    //'group' => true,
                    'value' => function($model, $key, $index) {
                return empty($model->chemo_cycle_seq) ? '-' : $model->chemo_cycle_seq;
            },
                ],
                [
                    'header' => 'Q',
                    'attribute' => 'q',
                    //  'group' => true,
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->q) ? '-' : $model->q;
            },
                ],
                [
                    'header' => 'Day',
                    'attribute' => 'chemo_cycle_day',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return !empty($model->chemo_cycle_day) ? $model->chemo_cycle_day : '-';
            },
                ],
                [
                    'header' => 'Chemo',
                    'attribute' => 'chemo_detail',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return !empty($model->chemo_detail) ? $model->chemo_detail : '-';
            },
                ],
                [
                    'header' => 'Treatment Plan',
                    'attribute' => 'trplan',
                    'contentOptions' => ['class' => 'text-center'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->trplan) ? '-' : $model->trplan;
            },
                ],
                [
                    'header' => 'Progress',
                    'attribute' => 'progress',
                    'contentOptions' => ['class' => 'text-left'],
                    'headerOptions' => ['style' => 'color:black;'],
                    'value' => function($model, $key, $index) {
                return empty($model->progress) ? '-' : $model->progress;
            },
                ],
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                    'template' => '{rxorder} {duplicate} {detail} {edit} {delete}',
                    'noWrap' => true,
                    'header' => 'Actions',
                    'buttons' => [
                        'rxorder' => function ($key, $model) {
                            if ($model['pt_trp_regimen_status'] == 2) {
                                $url = ['create-rxorder', 'drugset_id' => $model['drugset_id'], 'chemoid' => $model['std_trp_chemo_id']];
                                return Html::a('Chemo Rx', $url, [
                                            'title' => 'Chemo Rx',
                                            'class' => 'btn btn-purple btn-xs',
                                            'data-toggle' => 'tooltip',
                                            'data-pjax' => 0,
                                ]);
                            } else {
                                return Html::button('Chemo Rx', ['class' => 'btn btn-purple btn-xs', 'disabled' => true]);
                            }
                        },
                                'duplicate' => function ($key, $model) {
                            return Html::a('Duplicate', 'javascript:void(0);', [
                                        'title' => 'Duplicate',
                                        'class' => 'btn btn-warning btn-xs duplicate',
                                        'data-id' => $model['std_trp_chemo_id'],
                                        'id' => $model['chemo_cycle_seq'],
                            ]);
                        },
                                'detail' => function ($url, $key, $model) {
                            //$url = ['update-treatment-plan', 'id' => $model['chemo_regimen_ids']];
                            return Html::a('Detail', $url, [
                                        'title' => 'Detail',
                                        'class' => 'btn btn-success btn-xs',
                            ]);
                        },
                                'edit' => function ($key, $model) {
                            $url = ['orderset', 'chemoid' => $model['std_trp_chemo_id'], 'drugsetid' => $model['drugset_id']];
                            return Html::a('Edit', $url, [
                                        'title' => 'Detail',
                                        'class' => 'btn btn-info btn-xs',
                                        'data-pjax' => 0,
                            ]);
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', 'javascript:void(0);', [
                                        'title' => 'Delete',
                                        'onclick' => 'DeleteChemoDetails(' . $model['drugset_id'] . ');',
                            ]);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
    </div>
</div>
<br>

<script>
    $(".duplicate").click(function () {
        var chemoid = (this.getAttribute("data-id"));
        var seq = (this.getAttribute("id"));
        $("#duplicateModal").modal('show');
        $('#duplicate_form').trigger('reset');
        $('input[id=pt_trp_chemo_id]').val(chemoid);
        $('input[id=chemo_cycle_seq]').val(seq);
    });
</script>