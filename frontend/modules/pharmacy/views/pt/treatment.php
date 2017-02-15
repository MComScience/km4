<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

CrudAsset::register($this);

$this->title = 'แผนการให้ยาเคมีบำบัด';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/pt/index']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/pharmacy/pt/treatment', 'data' => $header->pt_visit_number]];
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$script = <<< JS
$(document).ready(function () {
    $('li.Patient').removeClass("active");
    $('li.treatment').addClass("active");
    $(".modal-content").addClass('animated fadeInDown');
});
JS;
$this->registerJs($script);
?>

<style>
    table.kv-grid-table thead tr th{
        background-color:  white;
        text-align: center;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <?= Html::encode('Treatment Plan Chemo : ผู้ป่วยนอก'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>

        </div>
        <div class="profile-container">

            <?= $this->render('_header', ['header' => $header, 'ptar' => $ptar]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-6 col-xs-12">
                    <div class="tabbable">
                        <?= $this->render('_tab_pharma', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="tbpttrp-chemo-index">
                                            <div id="ajaxCrudDatatable">
                                                <?php Pjax::begin(['id' => 'treatment-pjax']); ?>
                                                <?php if ($checkplan == 'True') : ?>
                                                    <?= Html::button('New Treatment Plan', ['class' => 'btn btn-purple', 'disabled' => true]) ?>
                                                <?php endif; ?>
                                                <?php if ($checkplan == 'False') : ?>
                                                    <?= Html::a('New Treatment Plan', ['new-treatment-plan', 'vn' => $header['pt_visit_number']], ['role' => 'modal-remote', 'title' => 'New Treatment Plan', 'class' => 'btn btn-purple']); ?>
                                                <?php endif; ?>

                                                <?= Html::a('Custom Chemo Rx Order', 'javascript:void(0);', ['class' => 'btn btn-purple']); ?>
                                                <p></p>                                                   
                                                <?=
                                                GridView::widget([
                                                    'dataProvider' => $dataProvider,
                                                    'responsive' => true,
                                                    'layout' => $layout,
                                                    'bordered' => true,
                                                    'striped' => true,
                                                    'condensed' => true,
                                                    'hover' => true,
                                                    'columns' => [
                                                        [
                                                            'class' => '\kartik\grid\SerialColumn',
                                                            'width' => '25px',
                                                        ],
                                                        [
                                                            'class' => 'kartik\grid\ExpandRowColumn',
                                                            'value' => function ($model, $key, $index, $column) {
                                                                return GridView::ROW_COLLAPSED;
                                                            },
                                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
                                                            'expandOneOnly' => true,
                                                            'detailAnimationDuration' => 'slow', //fast
                                                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                            'detailUrl' => Url::to(['treatment-details']),
                                                        ],
                                                        [
                                                            'header' => 'เลขที่',
                                                            'attribute' => 'pt_trp_chemo_id',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->pt_trp_chemo_id) ? '-' : $model->pt_trp_chemo_id;
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'Regimen Name',
                                                            'attribute' => 'pt_trp_regimen_name',
                                                            'contentOptions' => ['class' => 'text-left'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->pt_trp_regimen_name) ? '-' : $model->pt_trp_regimen_name;
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'Chemo Name',
                                                            'attribute' => 'pt_trp_chemo_name',
                                                            'contentOptions' => ['class' => 'text-left'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return '-';
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'Chemo',
                                                            'attribute' => 'chemodetail',
                                                            'contentOptions' => ['class' => 'text-left'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return '-';
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'CPR No.',
                                                            'attribute' => 'pt_trp_cpr_number',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->pt_trp_cpr_number) ? '-' : $model->pt_trp_cpr_number;
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'OCPA No.',
                                                            'attribute' => 'pt_trp_ocpa_number',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->pt_trp_ocpa_number) ? '-' : $model->pt_trp_ocpa_number;
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'Status',
                                                            'attribute' => 'cpoe_status_decs',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->cpoe_status_decs) ? '-' : $model->cpoe_status_decs;
                                                    },
                                                        ],
                                                        [
                                                            'class' => '\kartik\grid\ActionColumn',
                                                            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                                            'template' => '{update} {delete}',
                                                            'noWrap' => true,
                                                            'header' => 'Actions',
                                                            'buttons' => [

                                                                'update' => function ($key, $model) {
                                                                    $url = ['update-treatment-plan', 'id' => $model['pt_trp_chemo_id']];
                                                                    return Html::a('Edit', $url, [
                                                                                'title' => 'Edit',
                                                                                'class' => 'btn btn-info btn-xs',
                                                                                'role' => 'modal-remote',
                                                                    ]);
                                                                },
                                                                        'delete' => function ($url, $model) {
                                                                    return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
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
                                                        <p></p>
                                                        <?= Html::a('Save AS Regimen', 'javascript:void(0);', ['class' => 'btn btn-purple', 'disabled' => true]); ?>
                                                        <br/>
                                                        <?= Html::a('Close', ['/'], ['class' => 'btn btn-default pull-right', 'data-dismiss' => 'modal']) ?>
                                                        <?php Pjax::end(); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

        <?php echo $this->render('_modal_duplicate') ?>

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
                                'index.php?r=pharmacy/pt/delete',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#treatment-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#treatment-pjax').on('pjax:success', function () {
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
                                'index.php?r=pharmacy/pt/delete-drugset',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    $.pjax.reload({container: '#treatment-pjax'});
                                }
                        );
                    }
                });
    }
    function Duplicate() {
        var frm = $('#duplicate_form');
        $.ajax({
            type: 'POST',
            url: 'index.php?r=pharmacy/pt/duplicate',
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
                                //$('#duplicateModal').modal('hidden');
                                //$.pjax({container: '#treatment-pjax'});
                            }
                        });
            }
        });
    }
</script>