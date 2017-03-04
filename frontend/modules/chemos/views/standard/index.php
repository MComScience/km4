<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use app\modules\chemo\models\TbMedicalRigth;
use yii\helpers\ArrayHelper;
use app\modules\chemos\models\TbDrugsetType;

#register assets
CrudAsset::register($this);

$this->title = 'Standard Regimen';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/pt/index']];
$this->params['breadcrumbs'][] = ['label' => 'ห้องจ่ายยาผู้ป่วยนอก', 'url' => ['/pharmacy/pt/index']];
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
    table.kv-grid-table thead tr th{
        background-color: white;
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
                <li class="tab-warning active">
                    <a data-toggle="tab" href="#content1">
                        <?= Html::encode('Standard Regimen'); ?>
                    </a>
            </ul>
            <div class="tab-content">
                <div id="content1" class="tab-pane in active">
                    <div class="tb-std-trp-chemo-index">
                        <?php Pjax::begin(['id' => 'stdtrp-chemo-index']); ?> 
                        <p>
                            <?= Html::a('New Standard Regimen', ['new-regimen'], ['role' => 'modal-remote', 'class' => 'btn btn-warning', 'data-toggle' => 'tooltip', 'title' => 'New Regimen']) ?>
                            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                        </p>

                        <?=
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'responsive' => true,
                            'layout' => $layout,
                            'condensed' => true,
                            'striped' => false,
                            'bordered' => true,
                            'hover' => true,
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'expandOneOnly' => true,
                                    'detailAnimationDuration' => 'slow', //fast
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => Url::to(['standard-details']),
                                ],
                                [
                                    'attribute' => 'std_trp_chemo_id',
                                    'header' => 'เลขที่',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                return empty($model->std_trp_chemo_id) ? '-' : $model->std_trp_chemo_id;
                            }
                                ],
                                [
                                    'attribute' => 'drugset_type',
                                    'width' => '180px',
                                    'header' => 'ประเภท',
                                    'value' => function ($model, $key, $index, $widget) {
                                        return $model['drugset_type'];
                                    },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map(TbDrugsetType::find()->all(), 'drugset_type_id', 'drugset_type_decs'),
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'ทุกประเภท'],
                                //'format' => 'raw'
                                ],
                                [
                                    'attribute' => 'std_trp_regimen_name',
                                    'header' => 'Regimen Name',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'value' => function ($model) {
                                return empty($model->std_trp_regimen_name) ? '-' : $model->std_trp_regimen_name;
                            }
                                ],
                                [
                                    'attribute' => 'std_trp_chemo_name',
                                    'header' => 'Chemo Name',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'value' => function ($model) {
                                return empty($model->chemo->std_trp_chemo_name) ? '-' : $model->chemo->std_trp_chemo_name;
                            }
                                ],
                                [
                                    'attribute' => 'dx_code',
                                    'header' => 'Dx',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                return empty($model->dx_code) ? '-' : $model->dx_code;
                            }
                                ],
                                [
                                    'attribute' => 'ca_stage_code',
                                    'header' => 'Stage',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                return empty($model->ca_stage_code) ? '-' : $model->ca_stage_code;
                            }
                                ],
                                [
                                    'attribute' => 'medical_right_id',
                                    'header' => 'medical_right_id',
                                    'contentOptions' => ['class' => 'text-left'],
                                    'value' => function ($model) {
                                return empty($model->chemo->medical_right_desc) ? '-' : $model->chemo->medical_right_desc;
                            },
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map(TbMedicalRigth::find()->all(), 'medical_right_id', 'medical_right_desc'),
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'ทุกสิทธิ'],
                                ],
                                [
                                    'attribute' => 'std_trp_regimen_paycode',
                                    'header' => 'std_trp_regimen_paycode',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($model) {
                                return empty($model->std_trp_regimen_paycode) ? '-' : $model->std_trp_regimen_paycode;
                            }
                                ],
                                [
                                    'attribute' => 'cpoe_status_decs',
                                    'header' => 'cpoe_status_decs',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'value' => function ($model) {
                                return empty($model->cpoe_status_decs) ? '-' : $model->cpoe_status_decs;
                            }
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'template' => '{edit} {delete}',
                                    'buttons' => [
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

                                <p>
                                    <?= Html::a('Close', ['/'], ['class' => 'btn btn-default pull-right']) ?>
                                </p>
                                <br><br>
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
                'header' => '<h4 class="modal-title white">Edit Regimen</h4>',
                'size' => 'modal-lg',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                'options' => ['tabindex' => FALSE]
            ]);
            ?>
            <div id="data"></div>
            <?php Modal::end(); ?>

            <?php echo $this->render('_modal_duplicate') ?>


            <?php
            $script1 = <<< JS
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $.get(
                'update',
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
                                'delete',
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
                                'index.php?r=chemos/std/select-std',
                                {
                                    stdid:stdid
                                },
                        function (data)
                        {
                            window.location.replace("index.php?r=/chemo/pttrp/treatmentindex&hn=&vn=");
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
                    

JS;
            $this->registerJs($script1);
            ?>

    <script>
        function Duplicate() {
            var frm = $('#duplicate_form');
            $.ajax({
                type: 'POST',
                url: 'duplicate',
                data: frm.serialize(),
                dataType: "JSON",
                success: function () {
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
                                    location.reload();
                                }
                            });
                }
            });
        }
    </script>
