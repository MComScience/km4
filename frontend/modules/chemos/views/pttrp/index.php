<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

#register assets
CrudAsset::register($this);

$this->title = 'Patient Summary';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/chemos/pttrp/index','id' => $header->pt_visit_number]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    $('li.Patient').addClass("active");
});
JS;
$this->registerJs($script);
?>

<style>
    table.default thead tr th{
        background-color: #ddd;
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
                            บันทึกใบสั่งยาผู้ป่วยนอก
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>

        </div>
        <div class="profile-container">

            <?= $this->render('_header', ['header' => $header, 'ptar' => $ptar,]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-6 col-xs-12">
                    <div class="tabbable">
                        <?= $this->render('_tab', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-10">
                                            <div class="tbcpoe-index">
                                                <div id="ajaxCrudDatatable">

                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-2">

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div id="timeline" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">แผนการให้ยาเคมีบำบัด</div>
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

<?php /*
<div class="tbpttrp-chemo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

    <p>
        <?= Html::a('Create Tbpttrp Chemo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'pt_trp_chemo_id',
            'pt_trp_regimen_name',
            'pt_hospital_number',
            'medical_right_id',
            'credit_group_id',
            // 'pt_trp_regimen_id',
            // 'pt_trp_credit_id',
            // 'pt_trp_regimen_paycode',
            // 'pt_trp_cpr_number',
            // 'pt_trp_ocpa_number',
            // 'pt_trp_regimen_status',
            // 'pt_trp_regimen_createby',
            // 'pt_trp_comment',
            // 'pt_visit_number',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?></div>
*/?>