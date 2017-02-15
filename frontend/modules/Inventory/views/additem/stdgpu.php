<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use frontend\assets\DataTableAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
DataTableAsset::register($this);
WaitMeAsset::register($this);
AutoNumericAsset::register($this);

$this->title = 'ราคากลางยาสามัญ';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['dashboard/index']];
$this->params['breadcrumbs'][] = ['label' => 'จัดการราคาสินค้า', 'url' => ['stdgpu']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class = "row">
    <div class = "col-lg-12 col-sm-12 col-xs-12">
        <div class = "tabbable">
            <ul class = "nav nav-tabs" id = "myTab">
                <li class = "active">
                    <a data-toggle = "tab" href = "#home">
                        ราคากลางยาสามัญ
                    </a>
                </li>
            </ul>

            <div class = "tab-content">
                <div class="text-align-right">
                </div>
                <div id = "home" class = "tab-pane in active">
                    <a href="javascript:void(0);" class="btn btn-success" id="getdatatpu"><i class="glyphicon glyphicon-plus"></i>เพิ่มข้อมูล</a>
                    <p></p><div id="query_gpu"></div>
                </div>
                <div class="text-align-right">
                    <?= Html::a('Close', ['/Inventory/dashboard/index'], ['class' => 'btn btn-default']) ?>
                </div>

            </div>

        </div>
        <div class="horizontal-space"></div>

    </div>

</div>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modaladd_gpu',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div id="from_gpu"></div>
<div id="suga"> 
</div>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'fromupdategpu']); ?>
<div class="row">
    <div class="col-xs-12 col-sm-12">
        <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput(['style' => 'background-color: white', 'readonly' => true,]); ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TMTID_GPU', ['label' => 'รหัสยาสามัญ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?= $form->field($model, 'TMTID_GPU', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true,]); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">ชื่อยาสามัญ</label>
            <div class="col-sm-8">
                <input class="form-control" readonly="" id="FNSGPU"/>
            </div>
        </div>
        <p></p>
        <div class="form-group">
            <?= Html::activeLabel($model, 'GPUStdCost', ['label' => 'ราคากลาง' . '<font color="red">*</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?= $form->field($model, 'GPUStdCost', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;text-align:right',]) . '<div id="หน่วย"></div>'; ?> 
            </div>
        </div>
        
        <div class="form-group">
            <?= Html::activeLabel($model, 'cost_ref', ['label' => 'ราคาอ้างอิง' . '<font color="red">*</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?= $form->field($model, 'cost_ref', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;text-align:right',]); ?> 
            </div>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'cost_ref_from', ['label' => 'ที่มา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?= $form->field($model, 'cost_ref_from', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;text-align:right',]); ?> 
            </div>
        </div>

        <div class="form-group" >
            <div class="col-sm-11" style="text-align: right">
                <a href="javascript:void(0);" class="btn btn-default" data-dismiss="modal">Close</a>
                <text id="Clear"></text>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>   
            </div>
        </div>

    </div>
</div>
<?php ActiveForm::end(); ?>
<?php \yii\bootstrap\Modal::end(); ?>
<?php
$script = <<< JS
$(document).ready(function () {
        GettableGpu();/* เรียกใช้ function */
}); 
function GettableGpu() {
        $.ajax({
            url: "gpustdcostlist",
            type: "post",
            dataType: "JSON",
            success: function (result) {
                $("#query_gpu").html(result);
                $('#vw_gpustdcost_list').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>tip',
                    /* "paging": false, */
                    "pageLength": 10,
                    "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                        "aLengthMenu": [
                            [5,10, 15, 20, 100, -1],
                            [5,10, 15, 20, 100, "All"]
                        ],
                });
            }
        });
    }   
        
$('#getdatatpu').click(function (e) {
        $("#tbgpustdcost-ids").val('');
        var kara = $("#suga").val();
        if (kara != '') {
            $('#modaladd_gpu').modal('show');
            $('#fromupdategpu').trigger('reset');

        } else {
            $('#modaladd_gpu').modal('show');
            $("#Clear").html('<button type="reset" href="javascript:void(0);" class="btn btn-danger" >Clear</button>');
            $('.modal-title').html('เลือกยาสามัญ');
            run_waitMe();
            $.ajax({
                url: 'gpu',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#from_gpu').html(data);
                    $("#suga").val('1');
                    $('#fromupdategpu').trigger('reset');
                    $('#vw_item_list_gpu').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>tip',
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                        "aLengthMenu": [
                            [5, 15, 20, 100, -1],
                            [5, 15, 20, 100, "All"]
                        ],
                    });
                    $('.modal-body').waitMe('hide');
                }
            });
        }
    });
        
$('#fromupdategpu').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'success')
            {
                $('#fromupdategpu').trigger('reset');
                swal({
    title: "Save Complete!",
    text: "",
    type: "success"
});
                GettableGpu();
                $('#modaladd_gpu').modal('hide');
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
        
$('#tbgpustdcost-gpustdcost').autoNumeric('init');
$('#tbgpustdcost-cost_ref').autoNumeric('init');
JS;
$this->registerJs($script);
?>
<script>
    
    function run_waitMe(effect) {
        $('.modal-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
    function Selectitem(id) {
        $.ajax({
            url: "selectitem",
            type: "post",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                if (result.check == 'true') {
                    Notify('รหัส ' + id + ' ถูกบันทึกแล้ว', 'top-right', '2000', 'danger', 'fa- exclamation', true);
                } else {
                    $("#tbgpustdcost-tmtid_gpu").val(id);
                    $("#FNSGPU").val(result.FSN_GPU);
                    //$("#หน่วย").html(result.DispUnit);
                }
            }
        });
    }

    function Edit(id) {
        $.ajax({
            url: "editgpucost",
            type: "post",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $('#fromupdategpu').trigger('reset');
                //$("#suga").val('1');
                $("#Clear").html('<button onclick="Clear(this);" href="javascript:void(0);" class="btn btn-danger" >Clear</button>');
                //$("#from_gpu").html('');
                $("#tbgpustdcost-ids").val(id);
                $("#tbgpustdcost-tmtid_gpu").val(result.TMTID_GPU);
                $("#FNSGPU").val(result.FSN_GPU);
                //$("#หน่วย").html(result.DispUnit);
                $("#tbgpustdcost-gpustdcost").val(result.GPUStdCost);
                $("#tbgpustdcost-cost_ref").val(result.cost_ref);
                $("#tbgpustdcost-cost_ref_from").val(result.cost_ref_from);
                $('.modal-title').html('แก้ไขข้อมูล');
                $('#modaladd_gpu').modal('show');
            }
        });
    }

    function Delete(id) {
        swal({
            title: "ยืนยันการลบ ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true},
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-stdgpucost',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    $.ajax({
                                        url: "gpustdcostlist",
                                        type: "post",
                                        dataType: "JSON",
                                        success: function (result) {
                                            $("#query_gpu").html(result);
                                            $('#vw_gpustdcost_list').DataTable({
                                                "dom": '<"pull-left"f><"pull-right"l>tip',
                                                /* "paging": false, */
                                                "pageLength": 10,
                                                "language": {
                                                    "lengthMenu": "_MENU_",
                                                    "infoEmpty": "No records available",
                                                    "search": "_INPUT_ ",
                                                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                                },
                                                "aLengthMenu": [
                                                    [5, 15, 20, 100, -1],
                                                    [5, 15, 20, 100, "All"]
                                                ],
                                            });
                                        }
                                    });
                                }
                        );
                    }
                });
    }

    function Clear() {
        $("#tbgpustdcost-gpustdcost").val('');
    }
</script>