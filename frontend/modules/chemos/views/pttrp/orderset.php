<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use kartik\grid\GridView;

#register assets
CrudAsset::register($this);

$this->title = 'ใบสั่งยาเคมีบำบัด';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'Create Order Set', 'url' => ['orderset', 'ids' => $detailmodel['chemo_regimen_ids'], 'id' => $headermodel['pt_trp_chemo_id']]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
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

    div#solution-modal .modal-content {
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
                            <?= Html::encode('Create Order Set'); ?>
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
                            <?php
                            echo $this->render('_form_ordersetdetail', [
                                'model' => $detailmodel,
                                'keepProvider' => $keepProvider, #เปิดเส้น
                                'premedProvider' => $premedProvider, #Premed
                                'ivProvider' => $ivProvider,
                                'medicatProvider' => $medicatProvider, #Medical
                                'header' => $header,
                                'drugsetid' => $drugsetid,
                                'drugset_ids' => $drugset_ids,
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




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
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => FALSE]
])
?>
<?php Modal::end(); ?>


