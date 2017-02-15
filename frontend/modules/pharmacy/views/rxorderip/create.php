<?php

use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\WaitMeAsset;

CrudAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
WaitMeAsset::register($this);

$this->title = 'ใบสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/ip/index']];
$this->params['breadcrumbs'][] = ['label' => 'Rx Order : ผู้ป่วยใน', 'url' => ['create', 'data' => $model['cpoe_id'], 'vn' => $header['pt_visit_number']]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
    $(document).ready(function () {
        $('li.order').addClass("active");
    });

     $('#btn-savedraft-cpoe').click(function (e) {
        var order_by = $('#tbcpoe-cpoe_order_by :selected').val();
        if (order_by == '') {
            //swal("Message Alert", "กรุณากรอกข้อมูลด้านบนให้ครบ", "warning");
            swal({
                title: "Message Alert",
                text: "กรุณาเลือกแพทย์",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.pjax({container: '#cpoedetail-pjax'});
                        }
                    });
        } else {
            SaveDraftCpoe();
        }
    });
JS;
$this->registerJs($script);
?>

<style>
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
    table.kv-grid-table thead tr th{
        text-align: center;
        background-color: white;
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
                        <?php echo $this->render('_tab', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12">
                                    <?php
                                    echo $this->render('_form', [
                                        'model' => $model,
                                        'modelChemo' => $modelChemo,
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12">
                                    <?php
                                    echo $this->render('_grid_cpoe_details', [
                                        'dataProvider' => $dataProvider,
                                        'searchModel' => $searchModel,
                                        'model' => $model,
                                        'header' => $header,
                                        'modelChemo' => $modelChemo,
                                    ]);
                                    ?>
                                </div>
                            </div>
                            <br/>
                            <p style="text-align: right;">
                                <?= Html::a('Close', ['/pharmacy/ip/treatment', 'data' => $model['pt_vn_number']], ['class' => 'btn btn-default']); ?>
                                <?= Html::button('SaveDraft', [ 'class' => 'btn btn-success ladda-button', 'id' => 'btn-savedraft-cpoe','data-style' => 'expand-left']); ?>
                                <?= Html::button('Order Sign', [ 'class' => 'btn btn-primary', 'id' => 'btn-order-sign',]); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title">' . 'IV Solution' . ' <span class="pull-right"> ' . $headermodal . ' </span> ' . '</h4>',
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

<script>
    function GetmodalIVSolution() {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        $.ajax({
            url: 'index.php?r=pharmacy/rxorderip/ivsolution',
            type: 'get',
            data: {cpoeid: cpoeid},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');

            }
        });
    }

    function EditIVSolution(id) {
        $.ajax({
            url: 'index.php?r=pharmacy/rxorderip/edit-ivsolution',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');
            }
        });
    }
    
    function GetmodalIVSolutionPremed() {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        $.ajax({
            url: 'index.php?r=pharmacy/rxorderip/ivsolution-premed',
            type: 'get',
            data: {cpoeid: cpoeid},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');

            }
        });
    }
    
   
    
    function SaveDraftCpoe() {
        var frm = $('#form-header-cpoe');
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.ajax({
            type: 'POST',
            url: 'index.php?r=pharmacy/rxorderip/savedraft-cpoe',
            data: frm.serialize(),
            success: function (data) {
                $('#tbcpoe-cpoe_num').val(data);
                swal({
                    title: "",
                    text: "SaveDraft Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                            }
                        });
            }
        });
    }
</script>

