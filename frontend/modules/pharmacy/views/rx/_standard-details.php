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
        <p></p>
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
                    //'group' => true,
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
                    [
                    'class' => '\kartik\grid\ActionColumn',
                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                    'headerOptions' => ['style' => 'color:black;background-color: #ddd;text-align:center;'],
                    'template' => '{detail} {edit}',
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
                        'edit' => function ($key, $model) {
                            return Html::a('Select', 'javascript:void(0);', [
                                        'title' => 'Select',
                                        'class' => 'btn btn-info btn-xs select',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                                        'data-id' => $model['drugset_id'],
                            ]);
                        },
                    ],
                ],
            ],
        ]);
        ?>
    </div>
</div>

<script>
    $(".select").click(function (e) {
        var drugset_id = (this.getAttribute("data-id"));
        var cpoeid = $('input[id="cpoeid"]').val();
        var drugset_type = $('input[id="drugset_type"]').val();
        swal({
            title: "ยืนยัน?",
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
                                'index.php?r=pharmacy/rx/save-select-package',
                                {
                                    drugset_id: drugset_id, cpoeid: cpoeid,drugset_type:drugset_type
                                },
                                function (data)
                                {
                                    
                                }
                        );
                    }
                });
    });
</script>

