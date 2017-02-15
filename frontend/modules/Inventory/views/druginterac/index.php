<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
use frontend\assets\DataTableAsset;
use frontend\assets\WaitMeAsset;
use frontend\assets\ToastrAsset;
use frontend\assets\BootboxAsset;
DataTableAsset::register($this);
WaitMeAsset::register($this);
ToastrAsset::register($this);
BootboxAsset::register($this);

$this->title = 'Drug Interaction';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ความไม่เข้ากันทางยา', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
    Qureydruginter();
});
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        Drug Interaction
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <a class="btn btn-success"><i class="glyphicon glyphicon-plus" onclick="Getmodal(this);">เพิ่มข้อมูล</i></a>
                    <p></p>
                    <div id="table_druginterac"></div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modaldata',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
    'header' => '<h4 class="modal-title"></h4>'
    . '<div style="text-align:right">'
    . '<text id="textalert" style="font-size: 20px"></text>'
    . '</div>',
    'size' => 'modal-lg modal-primary',
    'footer' => '
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
    . '<a class="btn btn-success" onclick="Clear(this);">Reset</a>',
]);
?>
<input id="checkloading" type="hidden"/>
<div id="datatpu">           
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
<?php \yii\bootstrap\Modal::end(); ?>


<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modalformcreate',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
]);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php
        $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_druginterac']);
        ?>
        <div class="well">
            <div class="form-group" >
                <div class="col-sm-3">
                    <?=
                    $form->field($modeldrug, 'DDI_id', ['showLabels' => false])->hiddenInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white'
                    ])
                    ?>
                </div>
            </div>
            <input class="form-control" type="hidden" id="druginteraction-drug1" name="druginteraction-drug1"/>
            <div class="form-group" >
                <?= Html::activeLabel($modeldrug, 'Drug1', ['label' => 'รหัสตัวยา VTM1', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeldrug, 'Drug1', ['showLabels' => false])->textInput([
                        'style' => 'background-color:white',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label no-padding-right">ชื่อตัวยา</label>
                <div class="col-sm-7">
                    <textarea class="form-control" style="background-color: white"  rows="3" readonly="" id="fsn_vtm1"></textarea>
                </div>
            </div>

            <p></p>

            <div class="form-group" >
                <?= Html::activeLabel($modeldrug, 'Drug2', ['label' => 'รหัสตัวยา VTM2', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeldrug, 'Drug2', ['showLabels' => false])->textInput([
                        'style' => 'background-color:white',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label no-padding-right">ชื่อตัวยา</label>
                <div class="col-sm-7">
                    <textarea class="form-control" style="background-color: white" id="fsn_vtm2" rows="3" readonly=""></textarea>
                </div>
            </div>
            <p></p>

            <div class="form-group">
                <?= Html::activeLabel($modeldruglevel, 'DDI_Serverity', ['label' => 'ระดับผลกระทบ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeldruglevel, 'DDI_Serverity', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\Tbddiserverity::find()->all(), 'ids', 'DDI_Serverity_decs'),
                        'pluginOptions' => [
                            'placeholder' => '--- Select Option ---',
                            'allowClear' => true,
                        ],
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeldruglevel, 'DDI_Effect_decs', ['label' => 'ผลกระทบ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-7">
                    <?=
                    $form->field($modeldruglevel, 'DDI_Effect_decs', ['showLabels' => false])->textarea([
                        'style' => 'background-color: #ffff99',
                        'rows' => 2,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeldruglevel, 'DDI_instruction', ['label' => 'วิธีการแก้ไข' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-7">
                    <?=
                    $form->field($modeldruglevel, 'DDI_instruction', ['showLabels' => false])->textarea([
                        'style' => 'background-color: #ffff99',
                        'rows' => 2,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10" style="text-align: right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton($modeldrug->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $modeldrug->isNewRecord ? 'btn btn-primary ladda-button' : 'btn btn-primary ladda-button', 'data-style' => 'expand-left']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php \yii\bootstrap\Modal::end(); ?>



<?php
$script = <<< JS
function Qureydruginter() {
    $.ajax({
        url: 'querydruginterac',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#table_druginterac').html(data);
            $('#tb_druginteraction').DataTable({
                "pageLength": 10,
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล"
                        },
                "aLengthMenu": [
                    [5, 10, 15, 20, 100, -1],
                    [5, 10, 15, 20, 100, "All"]
                ],
                responsive: true,
            });
        }
    });
}

/* Save */
$('#form_druginterac').on('beforeSubmit', function(e)
    {
    var l = $( '.ladda-button' ).ladda();
    l.ladda( 'start' );
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'duplicate')
            {
                    swal({
                    title: "",
                    text: "Druginteraction นี้ถูกบันทึกไว้แล้ว!",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $('#modalformcreate').modal('hide');
                                l.ladda('stop');
                                Clear();
                            }
                        });
            } else
            {
                    Qureydruginter();
                    Notify('Save Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
                    $('#form_druginterac').trigger('reset');
                    $('#modalformcreate').modal('hide');
                    $('#modaldata').modal('hide');
                    $("#druginteraction-drug1").val('');
                    $("#druginteraction-drug2").val('');
                    $("#druginteraction-drug1").val('');
                    swal("Save Complete!", "", "success");
                    l.ladda('stop');
            }
            })
            .fail(function()
            {
                console.log('server error');
                swal("OOPS !", "เกิดข้อผิดพลาด! :)", "error");
                l.ladda('stop');
            });
            return false;
    });
        
/* Get Modal */
function updateDataTableSelectAllCtrl(table){
   var table             = table.table().node();
   var chkbox_all        = $('tbody input[type="checkbox"]', table);
   var chkbox_checked    = $('tbody input[type="checkbox"]:checked', table);
   var chkbox_select_all  = $('thead input[name="select_all"]', table).get(0);

   // If none of the checkboxes are checked
   if(chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if (chkbox_checked.length === chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}


$('#alert').click(function (e) {
       
        var selected = new Array();
        $("input[type=checkbox]").each(function () {
            if ($(this).is(":checked"))
            {
               selected.push($(this).closest('tr').data('key'));
            }
        });
        alert(selected);
    });

JS;
$this->registerJs($script);
?>
<script>
    function SelectandPostdata(d) {
        $('#tb_itemlisttpu tbody tr').removeClass('selected');
        var fsn = (d.getAttribute("id"));
        $('#tb_itemlisttpu tbody tr').removeClass('selected');
        $('#tb_itemlisttpu tbody tr[data-key="' + fsn + '"]').addClass('selected');

        var id = (d.getAttribute("data-id"));
        var drug1 = $("#druginteraction-drug1").val();

        $.ajax({
            url: 'getdataonselect',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                if (drug1 == '') {
                    $('#tb_itemlisttpu tbody tr').removeClass('selected');
                    $('#tbdruginteraction-drug1').val(data.TMTID_VTM);
                    $('#druginteraction-drug1').val(data.TMTID_VTM);
                    $('#fsn_vtm1').val(data.fsn_vtm);
                    $('.modal-title').html('เลือกตัวยา 2');
                    $('#textalert').html('<i class="fa fa-check-circle-o"></i> ตัวยาที่ 1 <i class="fa fa-circle-o"></i> ตัวยาที่ 2');
                    Notify('เลือกตัวยาที่ 2', 'top-right', '2000', 'success', 'fa-check-circle', true);
                } else {
                    $('#tb_itemlisttpu tbody tr').removeClass('selected');
                    $('#tbdruginteraction-drug2').val(data.TMTID_VTM);
                    $('#fsn_vtm2').val(data.fsn_vtm);
                    var tradename1 = $("#tbdruginteraction-drug1").val();
                    var tradename2 = $("#tbdruginteraction-drug2").val();
                    var fsn_vtm1 = $("#fsn_vtm1").val();
                    var fsn_vtm2 = $("#fsn_vtm2").val();
                    if (tradename1 == tradename2) {
                        swal({
                            title: "",
                            text: "เลือกตัวยาซ้ำ กรุณาเลือกยาตัวใหม่!",
                            type: "warning"
                        });
                        // Notify('เลือกตัวยาซ้ำ กรุณาเลือกยาตัวใหม่!', 'top-right', '3000', 'danger', 'fa-exclamation', true);
                    } else {
                        $('#textalert').html('<i class="fa fa-check-circle-o"></i> ตัวยาที่ 1 <i class="fa fa-check-circle-o"></i> ตัวยาที่ 2');
                        run_waitMe();
                        bootbox.dialog({
                            message: "\
                                    <i class='fa fa-check-square-o'></i> ตัวยาที่ 1 " + "<code style='font-size: 14px'>" + fsn_vtm1 + "</code>" + "<p></p>" +
                                    "<i class='fa fa-check-square-o'></i> ตัวยาที่ 2 " + "<code style='font-size: 14px'>" + fsn_vtm2 + "</code>",
                            title: "ยืนยันการเลือกตัวยา",
                            buttons: {
                                success: {
                                    label: "Cancel",
                                    className: "btn-default",
                                    callback: function () {
                                        /* $('#modaldata > div').waitMe('hide'); */
                                        $('.page-container').waitMe('hide');
                                    }
                                },
                                danger: {
                                    label: "OK",
                                    className: "btn-success",
                                    callback: function () {
                                        $('.page-container').waitMe('hide');
                                        $('#modalformcreate').modal('show');
                                        $('#modalformcreate > div .modal-title').html('กำหนดรายละเอียด Drug Interaction');
                                    }
                                },
                            }
                        });
                    }
                }

            }
        });
    }

    function run_waitMe() {
        $('.page-container').waitMe({
            effect: 'none',
            text: '',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
    /* Loading */
    function run_waitMe1(effect) {
        $('.modal-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
    function Getmodal() {
        var check = $('#checkloading').val();
        if (check != '1') {
            $('#modaldata').modal('show');
            $('.modal-title').html('เลือกตัวยา 1');
            run_waitMe1();
            $.ajax({
                url: 'tpudata',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#datatpu').html(data.table);
                    $('#checkloading').val('1');
                    $('.modal-title').html('เลือกตัวยา 1');
                    $('#form_druginterac').trigger("reset");
                    $("#druginteraction-drug1").val('');
                    $("#druginteraction-drug2").val('');
                    $("#druginteraction-drug1").val('');
                    $('#textalert').html('<i class="fa fa-circle-o"></i> ตัวยาที่ 1 <i class="fa fa-circle-o"></i> ตัวยาที่ 2');
                    $('#tb_itemlisttpu').DataTable({
                        "pageLength": 5,
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล"
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
                        ],
                        responsive: true,
                    });
                    $('.modal-body').waitMe('hide');
                }
            });
        } else {
            $('#modaldata').modal('show');
            $('.modal-title').html('เลือกตัวยา 1');
            $("#druginteraction-drug1").val('');
            $("#druginteraction-drug2").val('');
            $("#druginteraction-drug1").val('');
            $('#textalert').html('<i class="fa fa-circle-o"></i> ตัวยาที่ 1 <i class="fa fa-circle-o"></i> ตัวยาที่ 2');
        }

    }

    function Clear() {
        $("#druginteraction-drug1").val('');
        $("#druginteraction-drug1").val('');
        $("#druginteraction-drug2").val('');
        $('#form_druginterac').trigger("reset");
        $('#textalert').html('<i class="fa fa-circle-o"></i> ตัวยาที่ 1 <i class="fa fa-circle-o"></i> ตัวยาที่ 2');
        $('.modal-title').html('เลือกตัวยา 1');
        Notify('Clear Success!', 'top-right', '500', 'success', 'fa-check-circle', true);
    }

    function Editdruginterac(d) {
        var id = (d.getAttribute("data-id"));
        $.ajax({
            url: 'editdruginterac',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#tbdruginteraction-ddi_id').val(id);
                $('#tbdruginteraction-drug1').val(data.drug1);
                $('#fsn_vtm1').val(data.detaildrug1);
                $('#tbdruginteraction-drug2').val(data.drug2);
                $('#fsn_vtm2').val(data.detaildrug2);
                $('#tbdruginteractionlevel-ddi_effect_decs').val(data.effectdecs);
                $('#tbdruginteractionlevel-ddi_instruction').val(data.DDI_instruction);
                $("#tbdruginteractionlevel-ddi_serverity").val(data.serverity).trigger("change");
                $('.modal-title').html('แก้ไขข้อมูล');
                $('#modalformcreate').modal('show');
            }
        });
    }

    function Delete(d) {
        var id = (d.getAttribute("data-id"));
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'deletedrug',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    $.ajax({
                                        url: 'querydruginterac',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function (data) {
                                            $('#table_druginterac').html(data);
                                            $('#tb_druginteraction').DataTable({
                                                "pageLength": 10,
                                                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                                "pageLength": 5,
                                                "language": {
                                                    "lengthMenu": "_MENU_",
                                                    "infoEmpty": "No records available",
                                                    "search": "_INPUT_ ",
                                                    "sSearchPlaceholder": "ค้นหาข้อมูล"
                                                },
                                                "aLengthMenu": [
                                                    [5, 10, 15, 20, 100, -1],
                                                    [5, 10, 15, 20, 100, "All"]
                                                ],
                                                responsive: true,
                                            });
                                        }
                                    });
                                }
                        );
                    }
                });
    }
</script>
