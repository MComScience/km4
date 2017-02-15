<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

CrudAsset::register($this);

$this->title = 'ประวัติการสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx/index']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/pharmacy/rx/order-history', 'data' => $header->pt_visit_number]];
$this->params['breadcrumbs'][] = $this->title;


?>
<style>
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
                            Chemo Order : ผู้ป่วยนอก
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>

        </div>
        <div class="profile-container">

            <?= $this->render('_header', ['header' => $header, 'ptar' => $ptar,]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <div class="tabbable">
                        <?php echo $this->render('_tab_pharma', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-2">
                                    
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
