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
<style>
    table#table-chemodetail thead tr th{
        text-align: center;
        background-color: #ddd;
    }
</style>
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <h5 class="success">
            <span class="pull-left">
                <b><?= Html::encode('Detail'); ?></b>
            </span>

            <span class="pull-right">
                <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-chemoadd', 'chemoid' => $chemoid], ['class' => 'btn-xs btn btn-purple']); ?> 
            </span>
            <br>
        </h5>
        <?php /*
          <table class="table table-bordered table-condensed flip-content table-hover" id="table-chemodetail">
          <thead>
          <tr>
          <th><?= Html::encode('Cycle'); ?></th>
          <th><?= Html::encode('Q'); ?></th>
          <th><?= Html::encode('Day'); ?></th>
          <th><?= Html::encode('Chemo'); ?></th>
          <th><?= Html::encode('Treatment Plan'); ?></th>
          <th><?= Html::encode('Progress'); ?></th>
          <th><?= Html::encode('Action'); ?></th>
          </tr>
          </thead>
          <tbody>
          <?php if (!empty($model)) : ?>
          <?php foreach ($model as $detail) : ?>
          <tr>
          <td><?= empty($detail['chemo_cycle_seq']) ? '-' : $detail['chemo_cycle_seq']; ?></td>
          <td><?= empty($detail['q']) ? '-' : $detail['q']; ?></td>
          <td><?= empty($detail['chemo_cycle_day']) ? '-' : $detail['chemo_cycle_day']; ?></td>
          <td><?= empty($detail['chemo_detail']) ? '-' : $detail['chemo_detail']; ?></td>
          <td><?= empty($detail['trplan']) ? '-' : $detail['trplan']; ?></td>
          <td><?= empty($detail['progress']) ? '-' : $detail['progress']; ?></td>
          <td class="text-center">
          <?= Html::a('Chemo Rx', ['create-rxorder', 'ids' => $detail['chemo_regimen_ids'], 'vn' => $detail['pt_visit_number']], ['class' => 'btn-xs btn btn-purple']); ?>
          <?= Html::a('Detail', 'javascript:void(0);', ['class' => 'btn-xs btn btn-success']); ?>
          <?= Html::a('Edit', ['orderset', 'ids' => $detail['chemo_regimen_ids'], 'id' => $detail['pt_trp_chemo_id'], 'drugsetid' => $detail['drugset_id']], ['class' => 'btn-xs btn btn-info']); ?>
          <?= Html::a('Delete', 'javascript:void(0);', ['class' => 'btn-xs btn btn-danger', 'onclick' => 'DeleteChemoDetails(' . $detail['chemo_regimen_ids'] . ');']); ?>
          </td>
          </tr>
          <?php endforeach; ?>
          <?php else : ?>
          <tr>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          <td>-</td>
          </tr>
          <?php endif; ?>
          </tbody>
          </table>
         * 
         */ ?>
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
                    'template' => '{duplicate} {detail} {edit} {delete}',
                    'noWrap' => true,
                    'header' => 'Actions',
                    'buttons' => [
                        'duplicate' => function ($key, $model) {
                            //$url = ['update-treatment-plan', 'id' => $model['chemo_regimen_ids']];
                            return Html::a('Duplicate', 'javascript:void(0);', [
                                        'title' => 'Duplicate',
                                        'class' => 'btn btn-purple btn-xs duplicate',
                                        'data-id' => $model['chemo_regimen_ids'],
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
                            $url = ['orderset', 'ids' => $model['chemo_regimen_ids'], 'id' => $model['pt_trp_chemo_id'], 'drugsetid' => $model['drugset_id']];
                            return Html::a('Edit', $url, [
                                        'title' => 'Detail',
                                        'class' => 'btn btn-info btn-xs',
                            ]);
                        },
                                'delete' => function ($url, $model) {
                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', 'javascript:void(0);', [
                                        'title' => 'Delete',
                                        'onclick' => 'DeleteChemoDetails(' . $model['chemo_regimen_ids'] . ');',
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
    function DeleteChemoDetails(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=chemo/pttrp/delete-chemodetails',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#treatmentindex-pjaxid'});
                                }
                        );
                    }
                });
    }
    $(".duplicate").click(function () {
        var regimen_ids = (this.getAttribute("data-id"));
        var seq = (this.getAttribute("id"));
        $("#duplicateModal").modal('show');
        $('#duplicate_form').trigger('reset');
        $('input[id=chemo_regimen_ids]').val(regimen_ids);
        $('input[id=chemo_cycle_seq]').val(seq);
    });
    $("#maxcycleqty").click(function () {
        var qty = $("#chemo_cycle_qty").val();
        var qtyplus = parseInt(qty) + parseInt("1");
        $("#chemo_cycle_qty").val(qtyplus);
    });
    $("#mincycleqty").click(function () {
        var qty = $("#chemo_cycle_qty").val();
        var qtyplus = parseInt(qty) - parseInt("1");
        $("#chemo_cycle_qty").val(qtyplus);
    });
    $("#maxseq").click(function () {
        var qty = $("#chemo_cycle_seq").val();
        var qtyplus = parseInt(qty) + parseInt("1");
        $("#chemo_cycle_seq").val(qtyplus);
    });
    $("#minseq").click(function () {
        var qty = $("#chemo_cycle_seq").val();
        var qtyplus = parseInt(qty) - parseInt("1");
        $("#chemo_cycle_seq").val(qtyplus);
    });

    function Duplicate() {
        var frm = $('#duplicate_form');
        $.ajax({
            type: 'POST',
            url: 'index.php?r=chemo/pttrp/duplicate',
            data: frm.serialize(),
            dataType: "JSON",
            success: function (data) {
                swal({
                    title: "",
                    text: "Duplicate Completed!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $('#duplicateModal').modal('hidden');
                                $.pjax({container: '#treatmentindex-pjaxid'});
                            }
                        });
            }
        });
    }

</script>
