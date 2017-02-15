<?php

use yii\helpers\Html;

$no = 1;
$btn = Html::a('<i class="glyphicon glyphicon-plus"></i>Base Solution', ['create-base', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success', 'role' => 'modal-remote']) . ' ' .
        Html::a('<i class="glyphicon glyphicon-plus"></i>Drug Additive', ['create-additive', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success', 'role' => 'modal-remote']) . ' ' .
        Html::a('<i class="glyphicon glyphicon-plus"></i>Instruction', ['update-instruction', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success', 'role' => 'modal-remote']);
$script = <<< JS
$(document).ready(function () {
        GettbBasesolution();
        GettbDrugAdditive();
        $('#IVItemQty').autoNumeric('init');
        /*
        $('#tbivdetails').DataTable({
            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
            "pageLength": 5,
            responsive: true,
            "bDestroy": true,
            "bAutoWidth": true,
            "bFilter": true,
            "bSort": false,
            "aaSorting": [[0]],
            "language": {
                "lengthMenu": "_MENU_",
                "infoEmpty": "No records available",
                "search": "ค้นหา _INPUT_ " + ' ' + '$btn',
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            },
            "aLengthMenu": [
                [5, 10, 15, 20, 100, -1],
                [5, 10, 15, 20, 100, "All"]
            ],
        });*/
    });     
JS;
$this->registerJs($script);
?>
<style>
    table#tbivdetails thead tr th{
        text-align: center;
    }
</style>


<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Base Solution :'); ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-base', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success', 'role' => 'modal-remote']);?>
        </h5>
        <div class="well">
          <div id="detailsBaseSolution"></div>  
        </div>
        
        <h5 class="success">
            <b><?= Html::encode('Drug Additive :') ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Add', ['create-additive', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success', 'role' => 'modal-remote']);?>
        </h5>
        <div class="well">
          <div id="detailsDrugAdditive"></div>  
        </div>
        <h5 class="success">
            <b><?= Html::encode('Schedule & Instruction :') ?></b> <?= Html::a('<i class="glyphicon glyphicon-plus"></i>Edit', ['update-instruction', 'cpoeid' => $headermodel->cpoe_id, 'vn_number' => $headermodel->pt_vn_number, 'cpoe_ids' => $cpoe_ids], ['class' => 'btn btn-success', 'role' => 'modal-remote']);?>
        </h5>
        <ul class="list-group">
            <li class="list-group-item" style="border: 0px solid white;background-color: #ddd;">
                <span class="text">Schedule :</span>
            </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item" style="border: 0px solid white;background-color: #ddd;">
                <span class="text">Instruction :</span>
            </li>
        </ul>
        <?php /*
        <div id="detailsiv">
            <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbivdetails">
                <thead>
                    <tr>
                        <th><?= Html::encode('รหัสสินค้า'); ?></th>
                        <th><?= Html::encode('ประเภท'); ?></th>
                        <th><?= Html::encode('รายการ'); ?></th>
                        <th><?= Html::encode('ปริมาณ'); ?></th>
                        <th><?= Html::encode('หน่วย'); ?></th>
                        <th><?= Html::encode('ราคา/หน่วย'); ?></th>
                        <th><?= Html::encode('เบิกได้'); ?></th>
                        <th><?= Html::encode('เบิกไม่ได้'); ?></th>
                        <th><?= Html::encode('Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invmodel as $data) : ?>
                        <tr>
                            <td><?= $data['ItemID']; ?></td>
                            <td><?= $data['cpoe_Itemtype']; ?></td>
                            <td><?= $data['ItemDetail']; ?></td>
                            <td><?= $data['ItemQty1']; ?></td>
                            <td><?= $data['DispUnit']; ?></td>
                            <td><?= $data['ItemPrice']; ?></td>
                            <td><?= $data['Item_Cr_Amt_Sum']; ?></td>
                            <td><?= $data['Item_Pay_Amt_Sum']; ?></td>
                            <td>
                                <?= Html::a('Edit', 'javascript:void(0);', ['class' => 'btn btn-xs btn-success']); ?>
                                <?= Html::a('Delete', 'javascript:void(0);', ['class' => 'btn btn-xs btn-danger']); ?>
                            </td>
                        </tr>
                        <?php $no++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>*/?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Dispense Qty : ') ?></b> <text style="color: red">*</text><text style="color: black">สามารถกำหนดปริมาณได้</text>
            <div id="msgqty" class="alert-error"></div><!-- Alert Message -->
        </h5>
        <!-- Begin Well -->
        <div class="well">
            <!-- Begin Row -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <table style="width: 100%" border="0">
                            <tbody>
                                <tr>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><b>เป็นเงิน</b></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><b>เบิกได้</b></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><b>เบิกไม่ได้</b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><span id="showItem_Total_Amt"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Cr_Amt"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Pay_Amt"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <div class="form-group">
                        <input id="IVItemQty" value="<?= number_format($detailmodel['ItemQty'],2);?>" class="form-control" height="40px" style="font-size: 25pt;text-align: right;background-color: white;width: 100%" required=""/>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-1">
                    <p></p>
                    <?= Html::a('Calculate', 'javascript:void(0);', ['onclick' => 'CalculateQty(this);', 'class' => 'btn btn-sm btn-primary']);?>
                </div>
            </div><!-- End Row -->
        </div><!-- End Well -->
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12" style="text-align: right;">
        <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
        <?= Html::a('Save', 'javascript:void(0);', ['class' => 'btn btn-success','onclick' => 'SaveIVSolutionitem('.$cpoe_ids.');']); ?>
    </div>
</div>


<script>
    function GettbBasesolution() {
        var parent = <?= "'" . $cpoe_ids . "'"; ?>;
        $.ajax({
            url: "index.php?r=cpoes/drugorder/gettb-basesolution",
            type: "POST",
            data: {parent: parent},
            dataType: "JSON",
            success: function (result) {
                $('#detailsBaseSolution').html(result.table);
                $('#tbBasesolution').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
                    "pageLength": 100,
                     responsive: true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    "bFilter": false,
                    "bSort": false,
                    "aaSorting": [[0]],
                    "info": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }
    
    function GettbDrugAdditive() {
        var parent = <?= "'" . $cpoe_ids . "'"; ?>;
        $.ajax({
            url: "index.php?r=cpoes/drugorder/gettb-drugadditive",
            type: "POST",
            data: {parent: parent},
            dataType: "JSON",
            success: function (result) {
                $('#detailsDrugAdditive').html(result.table);
                $('#tbDrugAdditive').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
                    "pageLength": 100,
                    responsive: true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    "bFilter": false,
                    "bSort": false,
                    "aaSorting": [[0]],
                    "info": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }

    function DeleteSubparent(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=cpoes/drugorder/delete-details',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    GettbBasesolution();
                                    GettbDrugAdditive();
                                }
                        );
                    }
                });
    }

    function SaveIVSolutionitem(id) {
        var ItemQty = $('#IVItemQty').val();
        $.post(
                'index.php?r=cpoes/drugorder/saveitem-ivsolution',
                {
                    id: id,ItemQty:ItemQty
                },
                function (data)
                {
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
                                $('#solution-modal').modal('hide');
                                $.pjax({container: '#pjax-tbcpoedetails'});
                            }
                        });
                }
        );
    }
</script>