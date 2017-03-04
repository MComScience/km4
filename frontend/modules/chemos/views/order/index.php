<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

#register assets
CrudAsset::register($this);

$this->title = 'Rx Order';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งจ่ายยาผู้ป่วยนอก', 'url' => ['/chemos']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    $('li.order').addClass("active");
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
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <?php echo $this->render('_form', ['model' => $model,'dataProvider' => $dataProvider]); ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="tbcpoe-index">
                                            <div id="ajaxCrudDatatable">
                                                <div class="tb-cpoe-index">

                                                    
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
