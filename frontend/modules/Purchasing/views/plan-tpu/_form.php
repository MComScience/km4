<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TbPcplan;
use app\modules\Purchasing\models\VwPcplantypeDrug;
use app\models\TbDepartment;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\SweetAlertAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
SweetAlertAsset::register($this);
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#tbplandrug").addClass("active");
    $("#effectivedate").datepicker({});
    '); ?>

<style type="text/css">
    .ui-datepicker{ z-index:1151 !important;}
    th{
        white-space: nowrap;
    }
</style>
<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php
            $form = ActiveForm::begin(['id' => 'form_main', 'layout' => 'horizontal'
            ]);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'readonly' => true]) ?>
                    <?=
                    $form->field($model, 'PCPlanDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่ <font color=red>*</font>')
                    ?>
                    <?php
                    echo $form->field($model, 'PCPlanTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [7, 8]])->all(), 'PCPlanTypeID', 'PCPlanType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('ประเภทแผนจัดชื้อ <font color=red>*</font>');
                    ?>
                    <div style="margin-left:150px;" id="plancssid"  class="hidden"><font color="red">ประเภทแผนจัดชื้อ ต้องไม่ว่างเปล่า</font></div>
                    <br>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                    echo Yii::$app->finddata->statusplan($model->PCPlanStatusID)
                    ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->PCPlanStatusID; ?>" name="TbPcplan[PCPlanStatusID]" />
                </div>

                <div class="col-sm-6">
                    <?=
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-department',
                        'prompt' => 'เลือกฝ่าย'
                    ])->label('ฝ่าย <font color=red>*</font>');
                    ?>

                    <?=
                    $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'ddl-section'],
                        'data' => [$section],
                        'pluginOptions' => [
                            'depends' => ['ddl-department'],
                            //  'placeholder' => 'เลือกอำเภอ...',
                            'url' => Yii::$app->request->baseUrl . '/Purchasing/tbpcplan/getsection'
                        ]
                    ])->label('แผนก <font color=red>*</font>');
                    ?>
                    <?=
                    $form->field($model, 'PCPlanBeginDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่เริ่มแผน <font color=red>*</font>')
                    ?>
                    <?=
                    $form->field($model, 'PCPlanEndDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่สิ้นสุดแผน <font color=red>*</font>')
                    ?>
                </div>
            </div>
        </div>
        <hr>
        <a href="javascript:showselectdata()" class="btn btn-success ladda-button" data-style = 'expand-left'><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการยาการค้า</a>
        <?php
        Modal::begin([
            "id" => "tb_pcplan",
            'size' => 'modal-lg modal-primary',
            'header' => '<h4 class="modal-title">เลือกยาการค้า</h4>',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="dataread"></div>
        <?php Modal::end(); ?>
        <hr>
        <br>
        <div id="food">
            <?php
            if ($tbpcplangpu != "") {
                $htl = Yii::$app->headertable->headertableplandrugdetail();
                $no = 1;
                $cost = 0;
                foreach ($tbpcplangpu as $result) {
                    $htl .= '<tr>';
                    $htl .= '<td align="center">' . $no . '</td>';
                    $htl .= '<td align="center">' . $result['TMTID_TPU'] . '</td>';
                    $htl .= '<td>' . $result['FSN_TMT'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['TPUUnitCost'], 2) . '</td>';
                    $htl .= '<td align="right">' . number_format($result['TPUOrderQty'], 2) . '</td>';
                    $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['TPUUnitCost'] * $result['TPUOrderQty'], 2) . '</td>';
                    $htl .= '<td align="center"><a href="javascript:void(0)" onclick="editlistdrugpcplan(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:void(0)" onclick="deletelistdrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete"> Delete</a></td>';
                    $htl .= '</tr>';
                    $no++;
                    $cost = $cost + ($result['TPUUnitCost'] * $result['TPUOrderQty']);
                }
                $htl .= '</tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td></td> 
                            </tr>
                        </tfoot>
                    </table>';
                echo $htl;
            }
            ?>
        </div>
    </div>
    <div class="form-group">
        <div align="right" style="margin-right: 10px">
            <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
            <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left', 'id' => 'drafsave', 'disabled' => 'disabled']) ?>
            <a class="btn btn-info disabled ladda-button" data-style = 'expand-left' id="actives" href="javascript:sendtoapprove()">Send To Apprrove</a>
        </div>
    </div>
</div>  
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<script>

    function showselectdata() {
        if ($('#inputEmail3').val() == "") {
            swal('', "กรุณาใส่ข้อมูลเลขรันก่อน", "warning");
        } else if ($('#tbpcplan-pcplandate').val() == "") {
            swal('', "กรุณาใส่ข้อมูลวันที่ก่อน", "warning");
        } else if ($('#tbpcplan-pcplantypeid').val() == "") {
            swal('', "กรุณาเลือกประเภทแผนจัดชื้อก่อน", "warning");
        } else if ($('#ddl-department').val() == "") {
            swal('', "กรุณาเลือกฝ่ายก่อน", "warning");
        } else if ($('#ddl-section').val() == "") {
            swal('', "กรุณาเลือกแผนกก่อน", "warning");
        } else if ($('#tbpcplan-pcplanbegindate').val() == "") {
            swal('', "กรุณาเลือกวันที่เริ่มแผนก่อน", "warning");
        } else if ($('#tbpcplan-pcplanenddate').val() == "") {
            swal('', "กรุณาเลือกวันที่สิ้นสุดแผนก่อน", "warning");
        } else {
            run_waitMe(2);
            $.ajax({
                url: "form_main",
                type: "post",
                data: $('#form_main').serialize(),
                success: function (result) {
                }
            });
            $.ajax({
                url: "datapcplandrug",
                type: "post",
                success: function (d) {
                    $('#dataread').html(d);
                    $('#tb_pcplan').modal('show');
                    $("#pcplandrugtable").DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 5,
                        responsive: true,
                        "language": {
                            "lengthMenu": " _MENU_ ",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                            "search": "ค้นหา "
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
                        ]
                    });
                    waitMe_hide(2);
                }
            });
        }
    }
    function saveprdetail() {
        if ($("#gpuunitCost").val() == "" || $("#gpuunitCost").val() < 0.01) {
            swal('', "กรุณากรอกข้อมูลลงช่องราคาต่อหน่วย", "warning");
        } else if ($("#gpuorderqty").val() == "" || $("#gpuorderqty").val() < 1) {
            swal('', "กรุณากรอกข้อมูลลงช่องจำนวน", "warning");
        } else {
            run_waitMe(1);
            $.ajax({
                url: "savedata",
                type: "post",
                data: $('#formtmtgpu').serialize(),
                dataType: 'json',
                success: function (d) {
                    $("#ids").val("");
                    $("input[name=tmtgpu]").val("");
                    $('#food').html(d.htn);
                    $('#mmm').modal('hide');
                    $('#tb_pcplan').modal('hide');
                    $("#tabledata").DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 5,
                        responsive: true,
                        "language": {
                            "lengthMenu": " _MENU_ ",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                            "search": "ค้นหา "
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
                        ]
                    });
                    $('#formtmtgpu').trigger("reset");
                    swal("", d.ff, "success");
                    waitMe_hide(1);
                    $('#drafsave').removeAttr("disabled");
                }
            });
        }
    }
    function myFunpcplanbydrug(id) {
        var prnums = $("#inputEmail3").val();
        run_waitMe(1);
        $.ajax({
            url: "getdata",
            type: "post",
            data: {id: id, prnums: prnums},
            dataType: 'json',
            success: function (result) {
                if (result.TMTID_GPU != null) {
                    $("input[name=tmtgpu]").val(result.TMTID_GPU);
                    $("#fsngpu").val(result.FSN_GPU);
                    $("#prnum").val($('#inputEmail3').val());
                    $('#mmm').modal('show');
                    $("#noii").val(result.itemDispUnit);
                    $('#effectivedate').val($('#tbpcplan-pcplanbegindate').val());
                    waitMe_hide(1);
                } else {
                    swal("", result.ale, "warning");
                    waitMe_hide(1);
                }
            }
        });
    }
    function savepcplanbymainform() {
        $.ajax({
            url: "index.php?r=Purchasing/pcplanbydrug/savedaff",
            type: "post",
            data: $('#mainform').serialize(),
            success: function (result) {
                swal("", result, "success");
            }
        });
    }
    function saveactive() {
        swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var id = $("#inputEmail3").val();
                        $.ajax({
                            url: "saveactive",
                            type: "post",
                            data: {id: id},
                            dataType: 'json',
                            success: function (result) {
                                if (result.status == '1') {
                                    $('#status_').val('Active');
                                }
                                swal("", result.data, "success");
                                setTimeout("location.href = 'index.php?r=Purchasing/plan-tpu';", 10);
                            }
                        });
                    }
                });
    }
    function sendtoapprove() {
        swal({
            title: "ยืนยันการส่งอนุมัติ ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#53a93f",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var id = $("#inputEmail3").val();
                        run_waitMe(2);
                        $.ajax({
                            url: "send-to-approve",
                            type: "post",
                            data: {id: id},
                            dataType: 'json',
                            success: function (result) {
                                if (result.status == '2') {
                                    $('#status_').val('WaitAprrove');
                                }
                                setTimeout("location.href = '/km4/Purchasing/plan-tpu/index';", 10);
                                waitMe_hide(2);
                            }
                        });
                    }
                }
        );
    }
    function deletelistdrug(ids) {
        swal({
            title: "ยืนยันการลบ",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        }, function (isConfirm) {
            if (isConfirm) {
                var prnums = $("#inputEmail3").val();
                run_waitMe(2);
                $.ajax({
                    url: "deletelistdrug",
                    type: "post",
                    data: {ids: ids, prnums: prnums},
                    dataType: 'json',
                    success: function (result) {
                        $('#formtmtgpu').trigger("reset");
                        $("#ids").val("");
                        $("input[name=tmtgpu]").val("");
                        $('#food').html(result.htn);
                        $("#tabledata").DataTable({
                            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                            "pageLength": 5,
                            responsive: true,
                            "language": {
                                "lengthMenu": " _MENU_ ",
                                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                "search": "ค้นหา "
                            },
                            "aLengthMenu": [
                                [5, 10, 15, 20, 100, -1],
                                [5, 10, 15, 20, 100, "All"]
                            ]
                        }
                        );
                        waitMe_hide(2);
                    }
                });
            }
        }
        );
    }
    function crear() {
        $("#gpuunitCost").val("0");
        $("#gpuorderqty").val("0");
        $("#gpuextended").val("0");
    }
    function cleartable() {
        $('#formtmtgpu').trigger("reset");
    }
    function editlistdrugpcplan(id) {
        run_waitMe(2);
        $.ajax({
            url: "editlistdrug",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (r) {
                $("#ids").val(r.ids);
                $("input[name=tmtgpu]").val(r.TMTID_GPU);
                $("#fsngpu").val(r.fsngpu);
                $("#noii").val(r.itemDispUnit);
                $("#gpuunitCost").val(r.GPUUnitCost);
                $("#gpuorderqty").val(r.GPUOrderQty);
                $("#gpuextended").val(r.GPUExtendedCost);
                $("#effectivedate").val(r.PCPlanGPUItemEffectDate);
                $("#pclanitemstatus").val(r.PCPlanGPUItemStatusID);
                $("#prnum").val($('#inputEmail3').val());
                $('#mmm').modal('show');
            }
        });
        waitMe_hide(2);
    }
    function run_waitMe(type) {
        if (type == '1') {
            var idnaclass = '.modal-content';
        } else if (type == '2') {
            var idnaclass = '.main-container';
        }
        $(idnaclass).waitMe({
            effect: 'ios',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }
    function waitMe_hide(type) {
        if (type == '1') {
            $('.modal-content').removeClass('waitMe_container');
            $('.waitMe').html('');
        } else if (type == '2') {
            $('.main-container').removeClass('waitMe_container');
        }
    }
</script>
<?php
Modal::begin([
    "id" => "mmm",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">บันทึกแผนจัดชื้อยาการค้า</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
]);
?>
<div class="modal-body">
    <form id="formtmtgpu">
        <input type="hidden" value="<?= $types ?>" id="types"/>
        <input type="hidden" id="ids" name="ids" value="">
        <input type="hidden" value="" name="prnum" id="prnum">
        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-7 control-label">รหัสยาการค้า:</label>
                    <input type="text" name="tmtgpu" readonly="true" class="form-control" id="recipient-name">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="message-text" class="col-sm-7 control-label">รายละเอียดยาการค้า</label>
                    <textarea class="form-control" readonly="true" rows="3" name="fsngpu" id="fsngpu"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">ราคาต่อหน่วย:</label>
                    <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" onkeypress="return isNumberKey(event)" style="background-color:#ffff99" id="gpuunitCost" name="gpuunitCost">
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">จำนวน:</label>
                    <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" onkeypress="return isNumberKey(event)" id="gpuorderqty" style="background-color:#ffff99" name="gpuorderqty">
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">หน่วย:</label>
                    <input id="noii" type="text" readonly class="form-control"  id="gpuorderqty" >
                </div>
            </div>
            <!-- Add the extra clearfix for only the required viewport -->
            <div class="clearfix visible-xs-block"></div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">ราคารวม:</label>
                    <input type="text" style="text-align: right" class="form-control" id="gpuextended" readonly="" name="gpuextended">
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">วันที่เริ่มใช้:</label>
                    <input type="text" class="form-control calendar" id="effectivedate" name="effectivedate" style="background-color:#ffff99">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <a class="btn btn-danger" onclick="crear();"> Clear</a>
    <a class="btn btn-default" onclick="cleartable();" data-dismiss="modal">Close</a>
    <button type="submit"  onclick="saveprdetail();" class="btn btn-success ladda-button" data-style = 'expand-left'> save</button>
</div>
<?php Modal::end(); ?>
<?php
$script = <<< JS
$('#form_main').on('beforeSubmit', function(e) 
{
   run_waitMe(2);
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
 swal("Save Complete!", "", "success");
      waitMe_hide(2);  
$('#actives').removeClass("disabled");
    }else
    {      
        waitMe_hide(2);
        $("#message").html(result);
    }
}).fail(function() 
{
    console.log("server error");
});
return false;
});

JS;
$this->registerJs($script);
?>

<?php
$s = <<< JS
$(document).ready(function() {
    $("#gpuunitCost").keyup(function () {
        $('input[id="gpuunitCost"]').priceFormat({prefix: ''});
        //**************************************ค่าเสียหาย***************************** 
        var sum1 = 0;
        var sum2 = 0;
        if ($('input[id="gpuunitCost"]').val() != '') {

            sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
            sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
            sum1 = sum1 * sum2;
            if (sum1 > 0) {
                var num = parseFloat(sum1);
                sum1 = num.toFixed(2);
                $('#gpuextended').val(addCommas(sum1));
            } else {
                $('#gpuextended').val('0.00');
            }
        }
    });
        
    //บวกเลขแผนจัดชื้อยาสามัญ
    $("#gpuorderqty").keyup(function () {
        $('input[id="gpuorderqty"]').priceFormat({prefix: ''});
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
        sum1 = sum2 * sum1;
        sum1 = sum1.toFixed(2);
        $('#gpuextended').val(addCommas(sum1));

    });
   $("#tabledata").DataTable({
          "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 10,
                        responsive: true,
                        "language": {
                            "lengthMenu": " _MENU_ ",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                            "search": "ค้นหา "
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
             ]
           }
       );
        });
JS;
$this->registerJs($s);
?>



<script>
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            swal("", "กรุณากรอกตัวเลข", "warning");
            return false;
        } else {


            return true;
        }

    }
</script>