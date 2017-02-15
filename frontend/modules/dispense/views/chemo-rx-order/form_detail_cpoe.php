<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset;
use kartik\widgets\Select2;

#register assets
CrudAsset::register($this);
if ($type == 1) {
    $this->title = 'จ่ายยา';
} else if ($type == 2) {
    $this->title = 'จัดยา';
} else if ($type == 3) {
    $this->title = 'ตรวจสอบยา';
}
$this->params['breadcrumbs'][] = ['label' => 'รายละเอียดใบสั่งยา', 'url' => ['/dispense/chemo-rx-order/list-check-drug']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.default thead tr th{
        background-color: white;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>

<!-- Begin Row -->
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-sm-6 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            รายละเอียดใบสั่งยา
                        </a>
                    </li>
                </ul>
            </div>
            <div class="horizontal-space"></div>

        </div>
        <div class="profile-container">

            <?= $this->render('header', ['header' => $modelheader, 'ptar' => $ptar,]) ?>

            <div class="profile-body">
                <div class="col-lg-12 col-sm-6 col-xs-12">
                    <div class="tabbable">
                        <?= $this->render('_tab', ['header' => $modelheader]) ?>
                        <div class="tab-content tabs-flat bg-white">

                            <div id="overview" class="tab-pane active">
                                <!--     <div class="row"> -->
                                <?php
                                echo $this->render('_form', [
                                    'model' => $modelheader,
                                    'dataProvider' => $dataProvider,
                                    'searchModel' => $searchModel
                                    , 'type' => $type
                                ])
                                ?>


                                <!--    <div class="row">
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


                                </div>-->
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Row -->
<!-- Begin Modal -->

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
<!-- End Modal -->
<!-- Begin Alert -->
<?php //echo $this->render('_alert'); ?>
<!-- End Alert -->
<?php
$script = <<< JS
    $(document).ready(function() {
      $(".select2").select2();
  });
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'create');
?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Order Adjust Requisition</h4>
            </div>
            <div class="modal-body">
                <textarea name="" id="id_adj_requestion_note" rows="3" class="form-control" style="background-color:#ffff99"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="id_adj_requestion" class="btn btn-warning">Adj Requestion</button>
            </div>
        </div>
    </div>
</div>