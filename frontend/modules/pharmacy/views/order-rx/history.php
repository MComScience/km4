<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use fedemotta\datatables\DataTables;
use frontend\assets\WaitMeAsset;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;

CrudAsset::register($this);
WaitMeAsset::register($this);

$this->title = 'สถานะใบสั่งยา';
$this->params['breadcrumbs'][] = $this->title;


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
                                'delete',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#cpoeindex-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#history-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
$this->registerJs($script1);
?>
<style type="text/css">
    table#datatables_w0 thead tr th{
        background-color: white;
    }
    .modal-fullscreen .modal-dialog {
        margin: 0;
        margin-top: 20px;
        margin-bottom: 20px;
        margin-right: auto;
        margin-left: auto;
        width: 100%;
    }
    @media (min-width: 768px) {
        .modal-fullscreen .modal-dialog {
            width: 750px;
        }
    }
    @media (min-width: 992px) {
        .modal-fullscreen .modal-dialog {
            width: 970px;
        }
    }
    @media (min-width: 1200px) {
        .modal-fullscreen .modal-dialog {
            width: 1170px;
        }
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu_index'); ?>
            <div class="tab-content">
                <div id="tabB" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">
                            <?php Pjax::begin(['id' => 'history-pjax']); ?>    
                            <?=
                            DataTables::widget([
                                'dataProvider' => $dataProvider,
                                'tableOptions' => [
                                    'class' => 'default kv-grid-table table table-hover table-bordered table-striped table-condensed',
                                ],
                                'options' => [
                                    'retrieve' => true
                                ],
                                'clientOptions' => [
                                    'bSortable' => false,
                                    'bAutoWidth' => true,
                                    'ordering' => false,
                                    'pageLength' => -1,
                                    //'bFilter' => false,
                                    'language' => [
                                        'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                        'lengthMenu' => '_MENU_',
                                        'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                        'search' => '_INPUT_'
                                    ],
                                    "lengthMenu" => [[10, -1], [10, "All"]],
                                    "responsive" => true,
                                    "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                ],
                                'columns' => [
                                    [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;'],
                                    ],
                                    [
                                        'attribute' => 'cpoe_num',
                                        'header' => 'เลขที่ใบสั่งยา',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->cpoe_num) ? '-' : $model->cpoe_num;
                                        }
                                    ],
                                    [
                                        'attribute' => 'HNVN',
                                        'header' => 'HN:VN',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->HNVN) ? '-' : $model->HNVN;
                                        }
                                    ],
                                    [
                                        'attribute' => 'pt_name',
                                        'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->pt_name) ? '-' : $model->pt_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'pt_age_registry_date',
                                        'header' => 'อายุ',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->pt_age_registry_date) ? '-' : $model->pt_age_registry_date . ' ปี';
                                        }
                                    ],
                                    [
                                        'attribute' => 'cpoe_order_by',
                                        'header' => 'แพทย์',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->User_name) ? '-' : $model->User_name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'cpoe_order_section',
                                        'header' => 'แผนก',
                                        'contentOptions' => ['class' => 'text-left'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->cpoe_order_section) ? '-' : $model->cpoe_order_section;
                                        }
                                    ],
                                    [
                                        'attribute' => 'pt_right',
                                        'header' => 'สิทธิการรักษา',
                                        'contentOptions' => ['class' => 'text-left'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->pt_right) ? '-' : $model->pt_right;
                                        }
                                    ],
                                    [
                                        'attribute' => 'cpoe_status',
                                        'header' => 'สถานะใบสั่งยา',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                            return empty($model->cpoe_status_decs) ? '-' : $model->cpoe_status_decs;
                                        }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'template' => '{detail} {update} {delete} ',
                                        'buttons' => [
                                            'detail' => function ($url, $model) {
                                                return Html::a('Detail', ['cpoe-details', 'cpoeid' => $model['cpoe_id']], [
                                                            'title' => 'Detail',
                                                            'role' => 'modal-remote',
                                                            'class' => 'btn btn-success btn-xs',
                                                ]);
                                            },
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', Url::to(['update', 'id' => $key]), [
                                                            'title' => 'Edit',
                                                            'data-pjax' => 0,
                                                ]);
                                            },
                                            'delete' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                            'title' => 'Delete',
                                                            'data-toggle' => 'modal',
                                                            'class' => 'activity-delete-link',
                                                ]);
                                            },
                                        ]
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">

                            <p>
                                <?= Html::a('Close', ['/'], ['class' => 'btn btn-default pull-right', 'data-dismiss' => 'modal']) ?>
                            </p>

                        </div>
                    </div>
                    <br/>
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
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
])
?>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">สร้างใบสั่งยา</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
        //'closeButton' => false,
]);
?>
<?php
$form = ActiveForm::begin([
            'id' => 'create-form',
            'options' => ['class' => 'form-horizontal'],
        ])
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title name"></h3>
    </div>
    <div class="panel-body">
        <div id="content-remedmodal"></div>
    </div>
</div>
<div class="form-group" style="text-align: right;">
    <div class="col-md-12" >
        <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => "modal"]); ?>
        <div class="btn-group dropdown">
            <a class="btn btn-success dropdown-toggle"  data-toggle="dropdown" data-hover="dropdown" data-delay="100">
                บันทึกใบสั่งยา <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-success">
                <li>
                    <?= Html::a('Rx Order', 'javascript:void(0);', ['onclick' => 'CreateRxOrder(1011,1);']) ?>
                </li>
                <li>
                    <?= Html::a('Chemo Order', 'javascript:void(0);', ['onclick' => 'CreateRxOrder(1012,1);']) ?>
                </li>
                <li>
                    <?= Html::a('Pre-Rx Order', 'javascript:void(0);', []) ?>
                </li>
                <li>
                    <?= Html::a('Pre-Chemo Order', 'javascript:void(0);', []) ?>
                </li>
                <li>
                    <?= Html::a('รับรองชื่อยานอกบัญชี รพ.', 'javascript:void(0);', []) ?>
                </li>
            </ul>
        </div>

    </div>
</div>
<div class="form-group">
    <div class="col-sm-2">
        <?= Html::input('text', 'VN', '', ['class' => 'form-control input-lg', 'id' => 'VN', 'type' => 'hidden',]) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
<?php Modal::end(); ?>