<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\helpers\Html;
use frontend\assets\DataTableAsset;
use frontend\assets\NotifyAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\AutoNumericAsset;
use fedemotta\datatables\DataTables;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

CrudAsset::register($this);
DataTableAsset::register($this);
NotifyAsset::register($this);
LaddaAsset::register($this);
AutoNumericAsset::register($this);

$this->title = 'ใบสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/order-rx/index']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/pharmacy/order-rx/update', 'id' => $modelCpoe->cpoe_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/bootstrap-dropdownhover.min.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<style type="text/css">
    div#solution-modal .modal-body{
        overflow-y: auto;
        height: 600px;
    }
    table.default thead tr th{
        background-color: white;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <?php echo $modelCpoe->cpoetype->cpoe_type_decs == null ? 'ใบสั่งยาผู้ป่วยนอก' : $modelCpoe->cpoetype->cpoe_type_decs; ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>
        </div>

        <div class="profile-container">

            <?= $this->render('_profile', ['ptar' => $ptar, 'profile' => $profile,'model' => $modelCpoe]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="tabbable">
                        <?php echo $this->render('_tab_pharma', ['profile' => $profile, 'model' => $modelCpoe]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="tb-cpoe-create">

                                        <?php /*
                                        $this->render('_form', [
                                            'model' => $modelCpoe,
                                        ])*/
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">รายการใบสั่งยา</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="content-tabledetails">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right"><?= Html::encode('หมายเหตุ'); ?></label>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <textarea rows="3" class="form-control" name="TbCpoe[cpoe_comment]" id="cpoe_comment"><?php echo $modelCpoe['cpoe_comment']; ?></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: right;">
                                    <?= Html::a('Close', ['/pharmacy/order-rx/order-status'], ['class' => 'btn btn-default']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->render('style'); ?>
<?php echo $this->render('modal', ['TitleModal' => $TitleModal]); ?>
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
<?php echo $this->render('script'); ?>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/bootstrap-dropdownhover.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
