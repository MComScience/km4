<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use frontend\assets\DataTableAsset;
use frontend\assets\AutoNumericAsset;
DataTableAsset::register($this);
AutoNumericAsset::register($this);

$btn1 = '  ' . Html::a('<i class="glyphicon glyphicon-plus"></i>เลือกรายการยาสามัญ', 'javascript:void(0);', ['class' => 'btn btn-success', 'onclick' => 'GettbGPU(this);']) . ' ' .
        Html::a('<i class="glyphicon glyphicon-plus"></i>เลือกรายการยาการค้า', 'javascript:void(0);', ['class' => 'btn btn-success', 'onclick' => 'GettbTPU(this);']) . ' ' .
        Html::a('<i class="glyphicon glyphicon-plus"></i>เลือกเวชภัณฑ์', 'javascript:void(0);', ['class' => 'btn btn-success', 'onclick' => 'GettbND(this);']);
$btn2 = '  ' . Html::a('<i class="glyphicon glyphicon-plus"></i>เลือกผู้ขาย', 'javascript:void(0);', ['class' => 'btn btn-success', 'onclick' => 'Gettbvendor(this);']);

$script = <<< JS
$(document).ready(function () {
        Gettable1();
        Gettable2();
    });

    function Gettable1() {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "querytb1",
            type: "post",
            data: {QRID: QRID},
            dataType: 'json',
            success: function (result) {
                $('#detailtb1').html(result);
                $('#tb1').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "info": "แสดง _START_ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_' + '$btn1',
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    function Gettable2() {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "querytb2",
            type: "post",
            data: {QRID: QRID},
            dataType: 'json',
            success: function (result) {
                $('#detailtb2').html(result);
                $('#tb2').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "info": "แสดง _START_ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_' + '$btn2',
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    } 
        
$('#tbqr2').on('beforeSubmit', function(e) 
{
   var \$form = $(this);
    $.post(
        \$form.attr("action"), // serialize Yii2 form
        \$form.serialize()
    )
        .done(function(result) {
        if(result != null)
        {
           $('#tbqr2-qrnum').val(result);
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

                }
            });
        }else
        {        
            
        }
        }).fail(function() 
        {
            console.log("server error");
        });
    return false;
});
$("#tab_A").click(function (e) {               
    location.reload();
});
$("#tab_B").click(function (e) {               
    window.location.replace("index");
});
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'create');
?>


<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success" id="tab_B">
                    <a data-toggle="tab" href="#home">
                        สถานะใบสืบราคาสินค้า
                    </a>
                </li>

                <li class="active" id="tab_A">
                    <a data-toggle="tab" href="#profile">
                        ใบสืบราคาสินค้า
                    </a>
                </li>
            </ul>


            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tbqr2-form">
                        <?php
                        $form = ActiveForm::begin([
                                    'type' => ActiveForm::TYPE_HORIZONTAL,
                                    'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
                                    'id' => 'tbqr2'
                        ]);
                        ?>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'QRNum', ['label' => 'เลขที่ใบเสนอราคา', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?= $form->field($model, 'QRNum', ['showLabels' => false])->textInput(['readonly' => true]); ?>
                            </div>

                            <?= Html::activeLabel($model, 'QRDeliveryDay', ['label' => 'ส่งมอบสินค้า(วัน)', 'class' => 'col-sm-2 control-label no-padding-right']) ?>

                            <div class="col-sm-3">
                                <?= $form->field($model, 'QRDeliveryDay', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;',]); ?>

                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($model, 'QRDate', ['label' => 'วันที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($model, 'QRDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                    'language' => 'th',
                                    'dateFormat' => 'dd/MM/yyyy',
                                    'clientOptions' => [
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ],
                                    'options' => [
                                        'class' => 'form-control',
                                        'style' => 'background-color: #ffff99',
                                    ],
                                ])
                                ?>
                            </div>

                            <?= Html::activeLabel($model, 'QRValidDay', ['label' => 'ยืนราคา(วัน)', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?= $form->field($model, 'QRValidDay', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;',]); ?>
                            </div>

                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($model, 'POTypeID', ['label' => 'ประเภทการสั่งซื้อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($model, 'POTypeID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                    'data' => yii\helpers\ArrayHelper::map(\app\modules\purqr\models\TbPotype::find()->all(), 'POTypeID', 'POType'),
                                    'pluginOptions' => [
                                        'placeholder' => 'Select Option',
                                        'allowClear' => true,
                                    ],
                                ])
                                ?>
                            </div>

                            <?= Html::activeLabel($model, 'QRExpectDate', ['label' => 'วันที่ต้องการตอบกลับ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($model, 'QRExpectDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                    'language' => 'th',
                                    'dateFormat' => 'dd/MM/yyyy',
                                    'clientOptions' => [
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ],
                                    'options' => [
                                        'class' => 'form-control',
                                        'style' => 'background-color: #ffff99;',
                                    ],
                                ])
                                ?>
                            </div>
                        </div>
                        <?=
                        $form->field($model, 'QRID', ['showLabels' => false])->hiddenInput();
                        ?>

                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-12">
                                <style>
                                    table#tb1 thead tr th{
                                        text-align: center;
                                    }
                                </style>
                                <h5 class="row-title before-success">รายละเอียดใบสืบราคา</h5>
                                <div id="detailtb1"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-6 col-md-12">
                                <style>
                                    table#tb2 thead tr th{
                                        text-align: center;
                                    }
                                </style>
                                <h5 class="row-title before-success">รายละเอียดผู้ขาย</h5>
                                <div id="detailtb2"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, 'QRmassage', ['label' => 'รายละเอียดเพิ่มเติม', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?= $form->field($model, 'QRmassage', ['showLabels' => false])->textarea(['rows' => 5, 'style' => 'background-color: #ffff99;',]); ?>

                            </div>
                        </div>
                        <div class="form-group" style="text-align: right;">
                            <div class="col-xs-12 col-sm-6 col-md-12">
                                <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']); ?>
                                <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                                <?= Html::a('Save & Send Email', 'javascript:void(0);', ['class' => 'btn btn-info', 'onclick' => 'Sendtoemail(this);']); ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>


<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modalvendor',
    'header' => '<h4 class="modal-title">เลือกผู้ขาย</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div id="datavendor"></div>
<?php \yii\bootstrap\Modal::end(); ?>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modalgpu',
    'header' => '<h4 class="modal-title">เลือกยาสามัญ</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div id="datagpu"></div>
<?php \yii\bootstrap\Modal::end(); ?>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modalform',
    'header' => '<h4 class="modal-title">เลือกผู้ขาย</h4>',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
    . '<a  class="btn btn-danger" onclick="Clear(this);">Clear</a>'
    . '<a type="button" class="btn btn-success" onclick="Saveitem(this);">Save</a>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div id="dataform"></div>
<?php \yii\bootstrap\Modal::end(); ?>



<script>

    function Gettbvendor() {
        $.ajax({
            url: "gettbvendor",
            type: "post",
            dataType: 'json',
            success: function (result) {
                $('#modalvendor').modal('show');
                $('#datavendor').html(result);
                $('div#modalvendor .modal-title').html('เลือกผู้ขาย');
                $('#tbvendor').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "info": "แสดง _START_ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_',
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function GettbGPU() {
        $.ajax({
            url: "gettbgpu",
            type: "post",
            dataType: 'json',
            success: function (result) {
                $('#modalgpu').modal('show');
                $('.modal-title').html('เลือกยาสามัญ');
                $('#datagpu').html(result);
                $('#tbgpu').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "info": "แสดง _START_ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_',
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function GettbTPU() {
        $.ajax({
            url: "gettbtpu",
            type: "post",
            dataType: 'json',
            success: function (result) {
                $('#modalgpu').modal('show');
                $('.modal-title').html('เลือกยาการค้า');
                $('#datagpu').html(result);
                $('#tbtpu').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "info": "แสดง _START_ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_',
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function GettbND() {
        $.ajax({
            url: "gettbnd",
            type: "post",
            dataType: 'json',
            success: function (result) {
                $('#modalgpu').modal('show');
                $('.modal-title').html('เลือกเวชภัณฑ์');
                $('#datagpu').html(result);
                $('#tbnd').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "info": "แสดง _START_ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_',
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function SelectVendor(id) {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "vendor-selected",
            type: "post",
            data: {QRID: QRID, userid: id},
            dataType: 'json',
            success: function () {
                $('#modalvendor').modal('hide');
                Gettable2();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function DeleteVendor(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-vendor',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    Gettable2();
                                }
                        );
                    }
                });
    }
    function SelectItem(id) {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "select-item",
            type: "post",
            data: {id: id, QRID: QRID},
            // dataType: 'json',
            success: function (data) {
                $('#modalform .modal-title').html('บันทึกรายการ');
                $('#modalform').find('.modal-body').html(data);
                $('#dataform').html(data);
                $('#modalform').modal('show');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function SelectGPU(id) {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "select-item",
            type: "post",
            data: {id: id, QRID: QRID},
            // dataType: 'json',
            success: function (data) {
                $('#modalform .modal-title').html('บันทึกรายการ');
                $('#modalform').find('.modal-body').html(data);
                $('#dataform').html(data);
                $('#modalform').modal('show');
                $('#tbqritemdetail2new-itemtype').val('GPU');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function SelectTPU(id) {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "select-item",
            type: "post",
            data: {id: id, QRID: QRID},
            // dataType: 'json',
            success: function (data) {
                $('#modalform .modal-title').html('บันทึกรายการ');
                $('#modalform').find('.modal-body').html(data);
                $('#dataform').html(data);
                $('#modalform').modal('show');
                $('#tbqritemdetail2new-itemtype').val('TPU');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function SelectND(id) {
        var QRID = $('#tbqr2-qrid').val();
        $.ajax({
            url: "select-item",
            type: "post",
            data: {id: id, QRID: QRID},
            // dataType: 'json',
            success: function (data) {
                $('#modalform .modal-title').html('บันทึกรายการ');
                $('#modalform').find('.modal-body').html(data);
                $('#dataform').html(data);
                $('#modalform').modal('show');
                $('#tbqritemdetail2new-itemtype').val('ND');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function Saveitem() {
        var form = $('#formitem');
        var qrpackqty = $('#tbqritemdetail2new-qrpackqty').val();
        var qrorderqty = $('#tbqritemdetail2new-qrorderqty').val();
        if ($('#แพค').is(":checked")) {
            if (qrpackqty != '') {
                $.ajax({
                    url: "saveitem",
                    type: "post",
                    data: form.serialize(),
                    // dataType: 'json',
                    success: function (data) {
                        Gettable1();
                        $('#modalform').modal('hide');
                        $('#modalgpu').modal('hide');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            } else {
                sweetAlert("", "กรุณา กรอกข้อมูล", "error");
            }
        } else if ($('#ชิ้น').is(":checked")) {
            if (qrorderqty != '') {
                $.ajax({
                    url: "saveitem",
                    type: "post",
                    data: form.serialize(),
                    // dataType: 'json',
                    success: function (data) {
                        Gettable1();
                        $('#modalform').modal('hide');
                        $('#modalgpu').modal('hide');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            } else {
                sweetAlert("", "กรุณา กรอกข้อมูล", "error");
            }
        }

    }

    function EditItem(id) {
        $.ajax({
            url: "edit-item",
            type: "post",
            data: {id: id},
            // dataType: 'json',
            success: function (data) {
                $('#modalform .modal-title').html('แก้ไขรายการ');
                $('#modalform').find('.modal-body').html(data);
                $('#dataform').html(data);
                $('#modalform').modal('show');
                var qrpackqty = $('#tbqritemdetail2new-qrpackqty').val();
                var qrorderqty = $('#tbqritemdetail2new-qrorderqty').val();
                if (qrpackqty != '') {
                    $('#แพค').attr('checked', true);
                    $("#tbqritemdetail2new-qrorderqty").attr('readonly', 'readonly');
                    $("#tbqritemdetail2new-qrpackqty").removeAttr('readonly');
                    $("#tbqritemdetail2new-itempackid").removeAttr('disabled');
                } else if (qrorderqty != '') {
                    $('#ชิ้น').attr('checked', true);
                    $("#tbqritemdetail2new-qrpackqty").attr('readonly', 'readonly');
                    $("#tbqritemdetail2new-itempackid").attr('disabled', 'disabled');
                    $("#tbqritemdetail2new-qrorderqty").removeAttr('readonly');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function DeleteItem(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'deleteitem',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    Gettable1();
                                }
                        );
                    }
                });
    }
    function Clear() {
        $('#tbqritemdetail2new-qrorderqty').val(null);
        $('#ItemPackSKUQty').val(null);
        $('#tbqritemdetail2new-qrpackqty').val(null);
        $("#tbqritemdetail2new-itempackid").val(null).trigger("change");
        $('#แพค').attr('checked', false);
        $('#ชิ้น').attr('checked', false);
    }

    function run_waitMe() {
        $('.page-container').waitMe({
            effect: 'progressBar',
            text: 'Sending...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#53a93f',
            onClose: function () {
            }
        });
    }

    function Sendtoemail() {
        swal({
            title: "ยืนยันการส่งอีเมล์",
            text: "",
            type: "warning",
            showCancelButton: true,
            //confirmButtonColor: "#DD6B55",
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        run_waitMe();
                        var QRID = $('#tbqr2-qrid').val();
                        $.post(
                                'sendmail',
                                {
                                    QRID: QRID
                                },
                                function (data)
                                {
                                    swal({
                                        title: "",
                                        text: "Send E-Mail Complete!",
                                        type: "success",
                                        showCancelButton: false,
                                        closeOnConfirm: true,
                                        closeOnCancel: true,
                                    },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    $('.page-container').waitMe('hide');
                                                }
                                            });
                                }
                        );
                    }
                });
    }

</script>


