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

$this->title = 'ใบสั่งยาเคมีบำบัด';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/ip/index']];
$this->params['breadcrumbs'][] = ['label' => 'Create Order Set', 'url' => ['orderset', 'chemoid' => $modelChemo['pt_trp_chemo_id'], 'drugsetid' => $modelDrugset['drugset_id']]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
    $(document).ready(function () {
        $('li.orderset').addClass("active");
        var status = $("#tbdrugset-drugset_status").val();
        if (status == '1' || status == '') {
            document.getElementById("btn-save-drugset").disabled = true;
        } else {
            document.getElementById("btn-savedraft-drugset").disabled = true;
        }
    });
    
    $('#btn-savedraft-drugset').click(function (e) {
        var cycle = $('#tbdrugset-chemo_cycle_seq').val();
        var day = $('#tbdrugset-chemo_cycle_day').val();
        var frequency = $('#tbdrugset-chemo_regimen_freq_value').val();
        var frequencyunit = $('#tbdrugset-chemo_regimen_freq_unit :selected').val();
        if (day == '' || cycle == '' || frequency == '' || frequencyunit == '') {
            //swal("Message Alert", "กรุณากรอกข้อมูลด้านบนให้ครบ", "warning");
            swal({
                title: "Message Alert",
                text: "กรุณากรอกข้อมูลด้านบนที่มี * ให้ครบ",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.pjax({container: '#drugdetdetail-pjax'});
                        }
                    });
        } else {
            SaveDraftOrderSet();
        }
    });

    $('#btn-save-drugset').click(function (e) {
        var cycle = $('#tbdrugset-chemo_cycle_seq').val();
        var day = $('#tbdrugset-chemo_cycle_day').val();
        var frequency = $('#tbdrugset-chemo_regimen_freq_value').val();
        var frequencyunit = $('#tbdrugset-chemo_regimen_freq_unit :selected').val();
        if (day == '' || cycle == '' || frequency == '' || frequencyunit == '') {
            //swal("Message Alert", "กรุณากรอกข้อมูลด้านบนให้ครบ", "warning");
            swal({
                title: "Message Alert",
                text: "กรุณากรอกข้อมูลด้านบนที่มี * ให้ครบ",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.pjax({container: '#drugdetdetail-pjax'});
                        }
                    });
        } else {
            SaveOrderSet();
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
                        <?= $this->render('_tab_pharma', ['header' => $header]) ?>
                        <div class="tab-content tabs-flat bg-white">
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12">
                                    <?php
                                    echo $this->render('_form_order_drugset', [
                                        'modelDrugset' => $modelDrugset,
                                        'modelChemo' => $modelChemo,
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12">
                                    <?php
                                    echo $this->render('_grid_drugset_details', [
                                        'dataProvider' => $dataProvider,
                                        'searchModel' => $searchModel,
                                        'modelDrugset' => $modelDrugset,
                                        'modelChemo' => $modelChemo,
                                    ])
                                    ?>
                                </div>
                            </div>
                            <br/>
                            <p style="text-align: right;">
                                <?= Html::a('Close', ['treatment', 'data' => $modelChemo['pt_visit_number']], ['class' => 'btn btn-default']); ?>
                                <?= Html::button('SaveDraft', [ 'class' => 'btn btn-success', 'id' => 'btn-savedraft-drugset']); ?>
                                <?= Html::button('Save', [ 'class' => 'btn btn-success', 'id' => 'btn-save-drugset']); ?>
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
    'options' => ['tabindex' => FALSE]
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
        var drugset_id = <?= "'" . $modelDrugset->drugset_id . "'" ?>;
        var vn = <?= "'" . $modelChemo->pt_visit_number . "'" ?>;
        $.ajax({
            url: 'index.php?r=pharmacy/ip/ivsolution',
            type: 'get',
            data: {drugset_id: drugset_id, vn: vn},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');

            }
        });
    }

    function GetmodalIVSolutionPremed() {
        var drugset_id = <?= "'" . $modelDrugset->drugset_id . "'" ?>;
        var vn = <?= "'" . $modelChemo->pt_visit_number . "'" ?>;
        $.ajax({
            url: 'index.php?r=pharmacy/ip/ivsolution-premed',
            type: 'get',
            data: {drugset_id: drugset_id, vn: vn},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');

            }
        });
    }

    function EditIVSolution(e) {
        var drugset_id = (e.getAttribute("data-id"));
        var drugset_ids = (e.getAttribute("id"));
        var vn_number = <?= "'" . $modelChemo->pt_visit_number . "'" ?>;
        $.ajax({
            url: 'index.php?r=pharmacy/ip/edit-ivsolution',
            type: 'post',
            data: {drugset_id: drugset_id, drugset_ids: drugset_ids, vn_number: vn_number},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');
            }
        });
    }

    function SaveDraftOrderSet() {
        var frm = $('#form_drugset_header');
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=pharmacy/ip/savedraft-orderset',
            data: frm.serialize(),
            success: function (data) {
                swal({
                    title: "",
                    text: "Save Complete!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                document.getElementById("btn-save-drugset").disabled = false;
                            }
                        });

            }
        });
    }

    function SaveOrderSet() {
        var frm = $('#form_drugset_header');
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=pharmacy/ip/save-orderset',
            data: frm.serialize(),
            success: function (data) {
                swal({
                    title: "",
                    text: "Save Complete!",
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
