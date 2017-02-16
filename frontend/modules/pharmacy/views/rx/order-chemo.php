<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\ModalFullScreenAsset;
use frontend\assets\DataTableAsset;

CrudAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
WaitMeAsset::register($this);
ModalFullScreenAsset::register($this);
DataTableAsset::register($this);

$this->title = 'ใบสั่งยา';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx/index']];
$this->params['breadcrumbs'][] = ['label' => 'Chemo Order : ผู้ป่วยนอก', 'url' => ['/pharmacy/rx/order-chemo', 'id' => $modelCpoe->cpoe_id, 'type' => $type]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
   $(function () {
        $("#cpoe_comment").keyup(function ()
        {
            $("#tbcpoe-cpoe_comment").val($(this).val());
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
        $('#btn-save-cpoe').click(function (e) {
            SaveCpoe();
        });

        $('.autosave').click(function (e) {
            var frm = $('#form-header-cpoe');
            $.ajax({
                type: 'POST',
                url: 'savedraft-cpoe',
                data: frm.serialize(),
                success: function (data) {
                    
                }
            });
        });
    }); 
JS;
$this->registerJs($script);
?>
<style>
    /*    div#ajaxCrudModal .modal-content {
             new custom width 
            width: 1222px;
             must be half of the width, minus scrollbar on the left (30px) 
            margin-left: -140px;
        }*/
    /*    div#solution-modal .modal-content {
             new custom width 
            width: 1222px;
             must be half of the width, minus scrollbar on the left (30px) 
            margin-left: -140px;
        }*/
    table.kv-grid-table thead tr th{
        background-color: white;
    }
    table.kv-grid-table tbody tr.kv-grid-group-row td{
        background-color: #f5f5f5;
        height: 46px;
        font-size: 13pt;
        vertical-align: middle;
        color: #53a93f
    }
    div#solution-modal .modal-body{
        overflow-y: auto;
        height: 600px;
    }

</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <?php echo $modelCpoe->cpoetype->cpoe_type_decs; ?>
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
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="tb-cpoe-create">

                                        <?=
                                        $this->render('_form', [
                                            'model' => $modelCpoe,
                                            'type' => $type,
                                        ])
                                        ?>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <?=
                                    $this->render('_grid_details', [
                                        'model' => $modelCpoe,
                                        'searchModel' => $searchModel,
                                        'dataProvider' => $dataProvider,
                                        'header' => $header,
                                        'type' => $type,
                                        'modalhd' => $headermodal,
                                        'druglistop' => $druglistop,
                                    ])
                                    ?>
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
                                    <?= Html::a('Close', ['/pharmacy/rx/order-status'], ['class' => 'btn btn-default']); ?>
                                    <?= Html::button('SaveDraft', ['class' => 'btn btn-success ladda-button', 'id' => 'btn-savedraft-cpoe', 'data-style' => 'expand-left', 'disabled' => $modelCpoe['cpoe_status'] == 2 ? true : false]); ?>
                                    <?= Html::button('Save', ['class' => 'btn btn-success ladda-button', 'id' => 'btn-save-cpoe', 'data-style' => 'expand-left', 'disabled' => empty($modelCpoe['cpoe_status']) || $modelCpoe['cpoe_status'] == 1 ? true : false]); ?>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?= Html::encode('ใบสรุปราคายา') ?> <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                 <?= Html::a('<i class="text-danger fa fa-file-pdf-o"></i> A4',['export-download','id' => $modelCpoe['cpoe_id'],'type' => 'A4'],['data-pjax' => 0,'target' => '_blank']); ?>
                                            </li>
                                            <li>
                                                 <?= Html::a('<i class="text-muted fa fa-file-text-o"></i> Slip',['export-download','id' => $modelCpoe['cpoe_id'],'type' => 'Tabloid'],['data-pjax' => 0,'target' => '_blank']); ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <?= Html::button('พิมพ์ฉลากยา', ['class' => 'btn btn-default', 'id' => 'btn-print', 'disabled' => $modelCpoe['cpoe_status'] != 2 ? true : false]); ?>
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
    'id' => 'solution-modal',
    'header' => '<h4 class="modal-title">' . 'IV Solution' . ' <span class="pull-right"> ' . $headermodal . ' </span> ' . '</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false,'class' => 'modal-fullscreen'],
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
    'options' => ['tabindex' => false,'class' => 'modal-fullscreen'],
])
?>
<?php Modal::end(); ?>

<script type="text/javascript">
    function GetmodalIVSolutionPremed() {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        $.ajax({
            url: 'ivsolution-premed',
            type: 'POST',
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
            url: 'edit-ivsolution',
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

    function GetmodalIVSolution() {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        $.ajax({
            url: 'ivsolution',
            type: 'post',
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
        var l = $('#btn-savedraft-cpoe').ladda();
        l.ladda('start');
        $.ajax({
            type: 'POST',
            url: 'savedraft-cpoe',
            data: frm.serialize(),
            success: function (data) {
                $('#tbcpoe-cpoe_num').val(data);
                swal({
                    title: "",
                    text: "SaveDraft Completed!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                document.getElementById("btn-save-cpoe").disabled = false;
                            }
                        });
            }
        });
    }

    function SaveCpoe() {
        var frm = $('#form-header-cpoe');
        var l = $('#btn-save-cpoe').ladda();
        l.ladda('start');
        $.ajax({
            type: 'POST',
            url: 'save-cpoe',
            data: frm.serialize(),
            success: function (data) {
                swal({
                    title: "",
                    text: "Save Completed!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                document.getElementById("btn-print").disabled = false;
                                //location.reload();
                            }
                        });
            }
        });
    }

</script>

