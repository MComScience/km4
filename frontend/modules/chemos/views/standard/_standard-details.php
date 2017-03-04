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
<?php if($select == false) :  ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h5 class="success">
            <span class="pull-left">
                <b><?= Html::encode('Details'); ?></b>
            </span>
            <?php if($modelChemo['drugset_type'] == 'CHEMO') : ?>
            <span class="pull-right">
                <?=
                Html::a('<i class="glyphicon glyphicon-plus"></i> Add Cycle', ['create-std-detail', 'id' => $modelChemo['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm']) . ' ' .
                Html::a('Duplicate', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm duplicate','data-id' => $modelChemo['std_trp_chemo_id'],]);
                ?>
            </span>
            <?php endif; ?>
        </h5>
    </div>
</div>
<?php endif; ?>
<p></p>
<?php if($select == false) :  ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
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
                    'template' => '{detail} {edit} {delete}',
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
                            if ($model['drugset_type'] == 'CHEMO') {
                                $url = ['create-regimen-cycle', 'chemo_id' => $model['std_trp_chemo_id'],'drugset_id' => $model['drugset_id']];
                            } else {
                                $url = ['drugset', 'id' => $model['std_trp_chemo_id'], 'drugsetid' => $model['drugset_id']];
                            }
                            return Html::a('Edit', $url, [
                                        'title' => 'Edit',
                                        'class' => 'btn btn-info btn-xs',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                            ]);
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', 'javascript:void(0);', [
                                        'title' => 'Delete',
                                        'data-toggle' => 'tooltip',
                                        'class' => 'activity-delete-drugset',
                            ]);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
    </div>
</div>
<?php endif; ?>

<?php if($select == true) :  ?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
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
                    'template' => '',
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
                            if ($model['drugset_type'] == 'CHEMO') {
                                $url = ['create-regimen-cycle', 'chemo_id' => $model['std_trp_chemo_id'],'drugset_id' => $model['drugset_id']];
                            } else {
                                $url = ['drugset', 'id' => $model['std_trp_chemo_id'], 'drugsetid' => $model['drugset_id']];
                            }
                            return Html::a('Edit', $url, [
                                        'title' => 'Edit',
                                        'class' => 'btn btn-info btn-xs',
                                        'data-toggle' => 'tooltip',
                                        'data-pjax' => '0',
                            ]);
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', 'javascript:void(0);', [
                                        'title' => 'Delete',
                                        'data-toggle' => 'tooltip',
                                        'class' => 'activity-delete-drugset',
                            ]);
                        },
                            ],
                        ],
                    ],
                ]);
                ?>
    </div>
</div>
<?php endif; ?>
<script>
    function init_click_handlers() {
        /* Delete */
        $('.activity-delete-drugset').click(function (e) {
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
                                    'index.php?r=chemos/standard/delete-drugset',
                                    {
                                        id: fID
                                    },
                                    function (data)
                                    {
                                        $.pjax.reload({container: '#stdtrp-chemo-index'});
                                    }
                            );
                        }
                    });
        });

    }
    init_click_handlers(); //first run
    $('#stdtrp-chemo-index').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
    
    $(".duplicate").click(function () {
        var std_trp_chemo_id = (this.getAttribute("data-id"));
        $("#duplicateModal").modal('show');
        $('#duplicate_form').trigger('reset');
        $('input[id=std_trp_chemo_id]').val(std_trp_chemo_id);
    });
    
    
</script>

