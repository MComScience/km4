<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

#register assets
CrudAsset::register($this);

$this->title = 'Select Regimen';
$this->params['breadcrumbs'][] = ['label' => 'แพทย์', 'url' => ['/chemo']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/chemo/pttrp/treatmentindex', 'hn' => $data_vn->pt_hospital_number, 'vn' => $data_vn->pt_visit_number]];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<style>
    table.default thead tr th{
        background-color: #ddd;
        text-align: center;
    }
    div#ajaxCrudModal .modal-header {
        background-color: #f4b400;
    }
    div#edit-modal .modal-header {
        background-color: #f4b400;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#content1">
                        <?= Html::encode('Select Regimen'); ?>
                    </a>
            </ul>
            <div class="tab-content">
                <div id="content1" class="tab-pane in active">
                    <div class="tb-std-trp-chemo-index">
                        <p>
                            <?= Html::a('New Regimen', ['new-regimen'], ['role' => 'modal-remote', 'class' => 'btn btn-purple', 'data-toggle' => 'tooltip', 'title' => 'New Regimen']) ?>
                        </p>
                        <?php Pjax::begin(['id' => 'stdtrp-chemo-index']); ?> 

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
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_EXPANDED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;background-color: #ddd'],
                                    'expandOneOnly' => true,
                                    'detailAnimationDuration' => 'slow', //fast
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => Url::to(['std-details']),
                                ],
                                [
                                    'attribute' => 'std_trp_chemo_id',
                                    'header' => 'เลขที่',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->std_trp_chemo_id) ? '-' : $model->std_trp_chemo_id;
                            }
                                ],
                                [
                                    'attribute' => 'std_trp_regimen_name',
                                    'header' => 'Regimen Name',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->std_trp_regimen_name) ? '-' : $model->std_trp_regimen_name;
                            }
                                ],
                                [
                                    'attribute' => 'std_trp_chemo_name',
                                    'header' => 'Chemo Name',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->std_trp_chemo_name) ? '-' : $model->std_trp_chemo_name;
                            }
                                ],
                                [
                                    'attribute' => 'dx_code',
                                    'header' => 'Dx',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->dx_code) ? '-' : $model->dx_code;
                            }
                                ],
                                [
                                    'attribute' => 'ca_stage_code',
                                    'header' => 'Stage',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->ca_stage_code) ? '-' : $model->ca_stage_code;
                            }
                                ],
                                [
                                    'attribute' => 'medical_right_id',
                                    'header' => 'medical_right_id',
                                    'contentOptions' => ['class' => 'text-left'],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->medical_right_id) ? '-' : $model->medical_right_id;
                            }
                                ],
                                [
                                    'attribute' => 'std_trp_regimen_paycode',
                                    'header' => 'std_trp_regimen_paycode',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->std_trp_regimen_paycode) ? '-' : $model->std_trp_regimen_paycode;
                            }
                                ],
                                [
                                    'attribute' => 'std_trp_regimen_status',
                                    'header' => 'std_trp_regimen_status',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'value' => function ($model) {
                                return empty($model->std_trp_regimen_status) ? '-' : $model->std_trp_regimen_status;
                            }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #ddd'],
                                    'template' => '{select} {edit} {delete}',
                                    'buttons' => [
                                        'select' => function ($key, $model) {
                                            return Html::a('<span class="btn btn-success btn-xs"> Select </span>', '#', [
                                                        'title' => 'Select',
                                                        'data-toggle' => 'modal',
                                                        'class' => 'activity-select-link',
                                            ]);
                                        },
                                                'edit' => function ($key, $model) {
                                            return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                        'class' => 'activity-update-link',
                                                        'title' => 'แก้ไขข้อมูล',
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $key,
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
                    </div>
                </div>
                <div class="horizontal-space"></div>

            </div>
        </div>

        <?php
        Modal::begin([
            "id" => "ajaxCrudModal",
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            "footer" => "", // always need it for jquery plugin
            'options' => ['tabindex' => FALSE]
        ])
        ?>
        <?php Modal::end(); ?>

        <?php
        Modal::begin([
            'id' => 'edit-modal',
            'header' => '<h4 class="modal-title">Edit Regimen</h4>',
            'size' => 'modal-lg',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => false,
            'options' => ['tabindex' => FALSE]
        ]);
        ?>
        <div id="data"></div>
        <?php Modal::end(); ?>

        <?php
        $script1 = <<< JS
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $.get(
                'index.php?r=chemo/std/update',
                {
                    id: fID
                },
        function (data)
        {
            $('#edit-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('#edit-modal').modal('show');
        }
        );
    });
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
                                'index.php?r=chemo/std/delete',
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
    $('.activity-select-link').click(function (e) {
        var stdid = $(this).closest('tr').data('key');
        swal({
            title: "Selected!",
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
                                'index.php?r=chemo/std/select-std',
                                {
                                    vn: $data_vn->pt_visit_number,stdid:stdid,ptid:$ptid
                                },
                        function (data)
                        {
                            window.location.replace("index.php?r=/chemo/pttrp/treatmentindex&hn=$data_vn->pt_hospital_number&vn=$data_vn->pt_visit_number");
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
JS;
        $this->registerJs($script1);
        ?>