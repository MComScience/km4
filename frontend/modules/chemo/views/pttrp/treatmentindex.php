<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;

#register assets
CrudAsset::register($this);

$this->title = 'แผนการให้ยาเคมีบำบัด';
$this->params['breadcrumbs'][] = ['label' => 'แพทย์', 'url' => ['/chemo']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/chemo/pttrp/treatmentindex', 'hn' => $header->pt_hospital_number, 'vn' => $header->pt_visit_number]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    $('li.Patient').removeClass("active");
    $('li.treatment').addClass("active");
});
JS;
$this->registerJs($script);

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
                        <?= $this->render('_tab', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="tbpttrp-chemo-index">
                                            <div id="ajaxCrudDatatable">
                                                <?php Pjax::begin(['id' => 'treatmentindex-pjaxid']); ?>
                                                <?= Html::a('New Treatment Plan', ['newtreatment-plan', 'vn' => $header['pt_visit_number']], ['role' => 'modal-remote', 'title' => 'New Treatment Plan', 'class' => 'btn btn-purple']); ?>
                                                <?= Html::a('Custom Chemo Rx Order', 'javascript:void(0);', ['class' => 'btn btn-purple']); ?>
                                                <p></p>                                                   
                                                <?=
                                                GridView::widget([
                                                    'dataProvider' => $dataProvider,
                                                    'responsive' => true,
                                                    'layout' => $layout,
                                                    'tableOptions' => [
                                                        'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                                                    ],
                                                    'columns' => [
                                                        [
                                                            'class' => '\kartik\grid\SerialColumn',
                                                            'width' => '25px',
                                                        ],
                                                        [
                                                            'class' => 'kartik\grid\ExpandRowColumn',
                                                            'value' => function ($model, $key, $index, $column) {
                                                                return GridView::ROW_EXPANDED;
                                                            },
                                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
                                                            'expandOneOnly' => true,
                                                            'detailAnimationDuration' => 'slow', //fast
                                                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                            'detailUrl' => Url::to(['chemo-detail']),
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
                                                            'contentOptions' => ['class' => 'text-left'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->pt_trp_ocpa_number) ? '-' : $model->pt_trp_ocpa_number;
                                                    },
                                                        ],
                                                        [
                                                            'header' => 'Status',
                                                            'attribute' => 'pt_trp_regimen_status',
                                                            'contentOptions' => ['class' => 'text-center'],
                                                            'headerOptions' => ['style' => 'color:black;'],
                                                            'value' => function($model, $key, $index) {
                                                        return empty($model->pt_trp_regimen_status) ? '-' : $model->pt_trp_regimen_status;
                                                    },
                                                        ],
                                                        [
                                                            'class' => '\kartik\grid\ActionColumn',
                                                            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                                            'template' => '{updatetreat} {delete}',
                                                            'noWrap' => true,
                                                            'header' => 'Actions',
                                                            'buttons' => [
                                                                'updatetreat' => function ($key, $model) {
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
                                                        <?= Html::a('Save AS Regimen', 'javascript:void(0);', ['class' => 'btn btn-purple']); ?>
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

        <?php
        Modal::begin([
            "id" => "duplicateModal",
            'header' => '<h4 class="modal-title">Duplicate Chemo Cycle</h4>',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            "footer" => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' ' . Html::a('Duplicate', 'javascript:void(0);', ['class' => 'btn btn-success','onclick' => 'Duplicate(this);']), // always need it for jquery plugin
            'options' => ['tabindex' => FALSE]
        ])
        ?>
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'duplicate_form']); ?>
        <div class="form-group">
            <label class="col-sm-4 control-label no-padding-right"><?= Html::encode('Chemo Cycle'); ?></label>
            <div class="col-sm-5">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" id="minseq"><i class="glyphicon glyphicon-minus"></i></button>
                    </span>
                    <input class="form-control text-center" name="chemo_cycle_seq" required="" value="1" id="chemo_cycle_seq"/>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" id="maxseq"><i class="glyphicon glyphicon-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label no-padding-right"><?= Html::encode('Cycle Duplicate Qty.'); ?></label>
            <div class="col-sm-5">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" id="mincycleqty"><i class="glyphicon glyphicon-minus"></i></button>
                    </span>
                    <input class="form-control text-center" name="chemo_cycle_qty" required="" value="1" id="chemo_cycle_qty"/>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="button" id="maxcycleqty"><i class="glyphicon glyphicon-plus"></i></button>
                    </span>
                </div>
            </div>
        </div>
        <input name="chemo_regimen_ids" id="chemo_regimen_ids" class="form-control" type="hidden"/>
        <?php ActiveForm::end(); ?>
        <?php Modal::end(); ?>

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
                                'index.php?r=chemo/pttrp/delete',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#treatmentindex-pjaxid'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#treatmentindex-pjaxid').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
        $this->registerJs($script1);
        ?>