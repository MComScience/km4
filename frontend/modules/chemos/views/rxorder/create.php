<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

CrudAsset::register($this);

$this->title = 'ใบสั่งยาเคมีบำบัด';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/chemos/rxorder/create', 'id' => $model->cpoe_id, 'vn' => $header->pt_visit_number]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    $('li.Patient').removeClass("active");
    $('li.orderset').addClass("active");
});
JS;
$this->registerJs($script);
?>
<style>
    table.kv-grid-table thead tr th{
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
                            <?= Html::encode('Chemo Rx Order : ผู้ป่วยนอก'); ?>
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
                                                <div class="tb-cpoe-create">
                                                    <?=
                                                    $this->render('_form', [
                                                        'model' => $model,
                                                        'header' => $header,
                                                        'ptar' => $ptar,
                                                        'dataProvider' => $dataProvider,
                                                        'premedProvider' => $premedProvider,
                                                        'ivProvider' => $ivProvider,
                                                        'medicatProvider' => $medicatProvider,
                                                    ])
                                                    ?>
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
</div>


x

<?php
$title = '<i class="glyphicon glyphicon-user"></i>' . $header->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
        $header->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
        ' <span class="success">HN</span> ' . $header->pt_hospital_number . ' | ' .
        ' <span class="success">VN</span> ' . $header->pt_visit_number . ' | ' .
        ' <span class="success">AN</span> ' . $header->pt_admission_number . '&nbsp;&nbsp;';
Modal::begin([
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title">' . 'IV Solution' . ' <span class="pull-right"> ' . $title . ' </span> ' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        //'closeButton' => false,
]);
?>
<div id="data"></div>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title">' . 'IV Solution' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        //'closeButton' => false,
]);
?>
<div id="data"></div>
<?php Modal::end(); ?>