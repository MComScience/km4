<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

$this->title = 'New Standard Regimen';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'ห้องจ่ายยาผู้ป่วยนอก', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'Standard Regimen', 'url' => ['/chemos/standard/index']];
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
                <li class="tab-warning active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('New Standard Regimen'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">
                            <?php echo $this->render('_form-header-newstd', ['model' => $model]); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">
                            <?php Pjax::begin(['id' => 'new-std-pjax']); ?> 
                            <p>
                                <span class="success"><b>Details :</b></span>
                                <?=
                                Html::a('<i class="glyphicon glyphicon-plus"></i> Add Cycle', ['create-std-detail', 'id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm']) . ' ' .
                                Html::a('Duplicate', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm']);
                                ?>
                            </p>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
//                                'panel' => [
//                                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Details</h3>',
//                                    'type' => GridView::TYPE_DEFAULT,
//                                    'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add Cycle', ['create-std-detail', 'id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-purple btn-sm']) . ' '
//                                    . Html::a('Duplicate', 'javascript:void(0);', ['class' => 'btn btn-purple btn-sm']),
//                                    'after' => false,
//                                ],
                                'layout' => $layout,
                                'condensed' => true,
                                'pjax' => true,
                                'bordered' => true,
                                'hover' => true,
                                'export' => [
                                    'fontAwesome' => true,
                                    'icon' => 'print',
                                    'showConfirmAlert' => FALSE,
                                    'stream' => false,
                                    'target' => '_blank',
                                    'showColumnSelector' => true
                                ],
                                'exportConfig' => [
                                    GridView::PDF => true,
                                    GridView::EXCEL => true,
                                ],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;background-color: white;'],
                                    ],
                                    [
                                        'class' => '\kartik\grid\RadioColumn',
                                        'header' => false,
                                        'radioOptions' => ['label' => '<span class="text"></span>',],
                                        'hAlign' => 'center',
                                        'headerOptions' => ['style' => 'color:black;width: 25px;background-color: white;'],
                                        'rowSelectedClass' => GridView::TYPE_SUCCESS,
                                    ],
                                    [
                                        'attribute' => 'chemo_cycle_seq',
                                        'header' => 'Cycle',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: white'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_cycle_seq) ? '-' : $model->chemo_cycle_seq;
                                },
                                        'group' => true, // enable grouping,
                                        'groupedRow' => true, // move grouped column to a single grouped row
                                        'groupOddCssClass' => 'kv-grouped-row', // configure odd group cell css class
                                        'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
                                    ],
                                    [
                                        'attribute' => 'chemo_cycle_day',
                                        'header' => 'Day',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: white'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_cycle_day) ? '-' : $model->chemo_cycle_day;
                                }
                                    ],
                                    [
                                        'attribute' => 'chemo_detail',
                                        'header' => 'Chemo',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: white'],
                                        'value' => function ($model) {
                                    return empty($model->chemo_detail) ? '-' : $model->chemo_detail;
                                }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;background-color: white'],
                                        'template' => '{detail} {edit} {delete}',
                                        'buttons' => [
                                            'detail' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', $url, [
                                                            'title' => 'Detail',
                                                            'data-toggle' => 'tooltip'
                                                ]);
                                            },
                                                    'edit' => function ($key, $model) {
                                                $url = ['create-regimen-cycle', 'chemo_id' => $model['std_trp_chemo_id'], 'drugset_id' => $model['drugset_id']];
                                                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', $url, [
                                                            'title' => 'Edit',
                                                            'data-toggle' => 'tooltip',
                                                            'data-pjax' => '0',
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
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12" style="text-align: right;">
                                    <?= Html::a('Close', ['/chemos/standard/index'], ['class' => 'btn btn-default']); ?>
                                    <?= Html::button('SaveDraft', ['type' => 'button', 'class' => 'btn btn-success', 'id' => 'btn-savedraft-standard']); ?>
                                    <?= Html::button('Save', ['type' => 'button', 'class' => 'btn btn-success', 'id' => 'btn-save-standard']); ?>
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
                                    'index.php?r=chemos/standard/delete-drugset',
                                    {
                                        id: fID
                                    },
                                    function (data)
                                    {
                                        $.pjax.reload({container: '#new-std-pjax'});
                                    }
                            );
                        }
                    });
        });

    }
    init_click_handlers(); //first run
    $('#new-std-pjax').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });

    $(document).ready(function () {
        var status = $("#tbstdtrpchemo-std_trp_regimen_status").val();
        if (status == '1' || status == '') {
            document.getElementById("btn-save-standard").disabled = true;
        } else {
            document.getElementById("btn-savedraft-standard").disabled = true;
        }
    });

    $('#btn-save-standard').click(function (e) {
        var chemoid = $('#tbstdtrpchemo-std_trp_chemo_id').val();
        var status = '2';
        $.ajax({
            type: 'POST',
            url: 'index.php?r=chemos/standard/std-order-savedraft',
            data: {chemoid: chemoid, status: status},
            success: function (data) {
                swal({
                    title: "",
                    text: "SaveDraft Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                            }
                        });
            }
        });
    });
    $('#btn-savedraft-standard').click(function (e) {
        var chemoid = $('#tbstdtrpchemo-std_trp_chemo_id').val();
        var status = '1';
        $.ajax({
            type: 'POST',
            url: 'index.php?r=chemos/standard/std-order-savedraft',
            data: {chemoid: chemoid, status: status},
            success: function (data) {
                swal({
                    title: "",
                    text: "SaveDraft Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                document.getElementById("btn-save-standard").disabled = false;
                            }
                        });
            }
        });
    });    
JS;
        $this->registerJs($script1);
        ?>
