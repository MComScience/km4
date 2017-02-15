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
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#pcplanbydrug").addClass("active");
    $("#effectivedate").datepicker({});
    ');
?>
<?php
if ($model->PCPlanNum == "") {
    $result = TbPcplan::find()->count();
    $auto = $result + 1;
    $dat = substr(date('Y') + 543, 2, 4);
    $auto = sprintf("%04d", $auto);
    $auto = 'PC' . $dat . '-' . $auto;
} else {
    $auto = $model->PCPlanNum;
}
?>
<style>
    .ui-datepicker{ z-index:1151 !important;}
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
            <?php Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php
            $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_main']);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'value' => $auto, 'readonly' => true]) ?>
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
                    ])->label('วันที่ <font color=red>*</font>');
                    ?>
                    <?php
                    echo $form->field($model, 'PCPlanTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [1, 2]])->all(), 'PCPlanTypeID', 'PCPlanType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    $form->field($model, 'PCPlanTypeID')->dropdownList(
                            ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [1, 2]])->all(), 'PCPlanTypeID', 'PCPlanType'), [
                        'prompt' => 'SELECT OPTION',
                    ])->label('ประเภทแผนจัดชื้อ <font color=red>*</font>');
                    ?> 

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
                            'url' => Yii::$app->request->baseUrl . '/index.php?r=Purchasing/tbpcplan/getsection'
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
        <a href="javascript:showselectdata()" class="btn btn-success ladda-button"  data-style= "expand-left"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการยาสามัญ</a>
        <?php
        Modal::begin([
            "id" => "tb_pcplan",
            'header' => '<h4 class="modal-title">เลือกยาสามัญ</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="dataread">
        </div>
        <?php Modal::end(); ?>
        <hr>
        <br>

        <div id="food">
            <?php
            if ($tbpcplangpu != "") {
                $htl = '';
                $htl .= Yii::$app->headertable->headertablepcplandetail();
                $no = 1;
                $cost = 0;
                foreach ($tbpcplangpu as $result) {
                    $htl .='<tr>';
                    $htl .= '<td align="center">' . $no . '</td>';
                    $htl .= '<td align="center">' . $result['TMTID_GPU'] . '</td>';
                    $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['GPUUnitCost'], 2) . '</td>';
                    $htl .= '<td align="right">' . number_format($result['GPUOrderQty'], 2) . '</td>';
                    $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['GPUUnitCost'] * $result['GPUOrderQty'], 2) . '</td>';
                    $htl .='<td style="text-align:center"><a href="javascript:editlistdrugpcplan(' . $result['ids'] . ')"  class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletelistdrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
                    $htl .='</tr>';
                    $no++;
                    $cost = $cost + ($result['GPUUnitCost'] * $result['GPUOrderQty']);
                }
                $htl .='</tr></tbody><tfoot>
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
        <div align="right">
            <a class="btn btn-default" id="bootbox-confirm" href="index.php?r=Purchasing/tbpcplan/index">Close</a>
            <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?>
            <a id="actives" class="btn btn-info disabled ladda-button" data-style="expand-left" href="javascript:sendtoapprove()">Send To Apprrove</a>
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
        }
        else if ($('#ddl-department').val() == "") {
            swal('', "กรุณาเลือกฝ่ายก่อน", "warning");
        } else if ($('#ddl-section').val() == "") {
            swal('', "กรุณาเลือกแผนกก่อน", "warning");
        } else if ($('#tbpcplan-pcplanbegindate').val() == "") {
            swal('', "กรุณาเลือกวันที่เริ่มแผนก่อน", "warning");
        } else if ($('#tbpcplan-pcplanenddate').val() == "") {
            swal('', "กรุณาเลือกวันที่สิ้นสุดแผนก่อน", "warning");
        }
        else {
            $('#dataread').html("<div style='text-align:center'><img src='images/712.gif'><br>Loading..</div>");
            $('#tb_pcplan').modal('show');
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            $.ajax({
                url: "index.php?r=Purchasing/tbpcplan/form_main",
                type: "post",
                data: $('#form_main').serialize(),
                success: function (result) {
                }
            });

            $.ajax({
                url: "index.php?r=Purchasing/tbpcplan/datapcplanbydrug",
                type: "post",
                success: function (d) {
                    $('#dataread').html(d);
                    $('#tb_pcplan').modal('show');
                    $("#pcplanbydrugtable").DataTable({
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
                    l.ladda('stop');
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
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            $.ajax({
                url: "index.php?r=Purchasing/tbpcplan/savedata",
                type: "post",
                data: $('#formtmtgpu').serialize(),
                dataType: 'json',
                success: function (d) {
                    $("#ids").val("");
                    $("input[name=tmtgpu]").val("");
                    $('#food').html(d.htn);
                    $('#tb_pcplan').modal('hide');
                    $('#mmm').modal('hide');
                    $('#formtmtgpu').trigger("reset");
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
                    l.ladda('stop');
                    swal("", d.ff, "success");
                }
            });
        }
    }
    function myFunpcplanbydrug(id) {
        var prnums = $("#inputEmail3").val();
        $.ajax({
            url: "index.php?r=Purchasing/tbpcplan/getdata",
            type: "post",
            data: {id: id, prnums: prnums},
            dataType: 'json',
            success: function (result) {
                if (result.TMTID_GPU != null) {
                    $("input[name=tmtgpu]").val(result.TMTID_GPU);
                    $("#fsngpu").val(result.FSN_GPU);
                    $("#noii").val(result.itemDispUnit);
                    $("#prnum").val($('#inputEmail3').val());
                    $('#mmm').modal('show');
                    $('#effectivedate').val($('#tbpcplan-pcplanbegindate').val());
                } else {
                    swal("", result.ale, "warning");
                }
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
                var l = $('.ladda-button').ladda();
                l.ladda('start');
                $.ajax({
                    url: "index.php?r=Purchasing/tbpcplan/send-to-approve",
                    type: "post",
                    data: {id: id},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '2') {
                            $('#status_').val('WaitAprrove');
                            l.ladda('stop');
                        }
                        setTimeout("location.href = 'index.php?r=Purchasing/tbpcplan';", 2000);
                    }
                });
            }
        }
        );
    }

    function deletelistdrug(ids) {
        swal({
            title: message_confirmdelete,
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                var prnums = $("#inputEmail3").val();
                $.ajax({
                    url: "index.php?r=Purchasing/tbpcplan/deletelistdrug",
                    type: "post",
                    data: {ids: ids, prnums: prnums},
                    dataType: 'json',
                    success: function (result) {
                        $('#formtmtgpu').trigger("reset");
                        $("#ids").val("");
                        $("input[name=tmtgpu]").val("");
                        $('#food').html(result.htn);
                        $("#tabledata").DataTable({
                            "dom": '<"pull-left"f><"pull-right"l>tip',
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
                    }
                });
            }
        });
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
        $.ajax({
            url: "index.php?r=Purchasing/tbpcplan/editlistdrug",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (r) {
                $("#ids").val(r.ids);
                $("input[name=tmtgpu]").val(r.TMTID_GPU);
                $("#fsngpu").val(r.fsngpu);
                $("#gpuunitCost").val(r.GPUUnitCost);
                $("#gpuorderqty").val(r.GPUOrderQty);
                $("#gpuextended").val(r.GPUExtendedCost);
                $("#effectivedate").val(r.PCPlanGPUItemEffectDate);
                $("#pclanitemstatus").val(r.PCPlanGPUItemStatusID);
                $("#noii").val(r.noii);
                $("#prnum").val($('#inputEmail3').val());
                $('#mmm').modal('show');
            }
        });
    }

</script>
<?php
Modal::begin([
    "id" => "mmm",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">บันทึกแผนจัดชื้อ</h4>',
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
                    <label for="recipient-name" class="col-sm-7 control-label">รหัสยาสามัญ:</label>
                    <input type="text" name="tmtgpu" readonly="true" class="form-control" id="recipient-name">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="message-text" class="col-sm-7 control-label">รายละเอียดยาสามัญ:</label>
                    <textarea class="form-control" readonly="true" rows="2" name="fsngpu" id="fsngpu"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">ราคาต่อหน่วย:</label>
                    <input type="text" style="background-color: #FFFF99;text-align:right" onchange ="JavaScript:chkNum(this)" oncanplay="calculate()" onkeypress="return isNumberKey(event)"  class="form-control" style="background-color:#ffff99" id="gpuunitCost" name="gpuunitCost">
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">จำนวน:</label>
                    <input type="text" onchange ="JavaScript:chkNum(this)" style="background-color: #FFFF99;text-align:right" class="form-control" oncanplay="calculate()"  onkeypress="return isNumberKey(event)" id="gpuorderqty" style="background-color:#ffff99" name="gpuorderqty">
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
                    <label for="recipient-name" class="col-sm-12 control-label">รวมเป็นเงิน:</label>
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
    <a class="btn btn-danger ladda-button" href="javascript:crear();" data-style = 'expand-left'> Clear</a>
    <a class="btn btn-default ladda-button" href="javascript:cleartable();" data-style = 'expand-left' data-dismiss="modal">Close</a>
    <a href="javascript:saveprdetail()" class="btn btn-success ladda-button" data-style = 'expand-left'> save</a>
</div>
<?php Modal::end(); ?>
<?php
$script = <<< JS
        
$('#form_main').on('beforeSubmit', function(e) 
{
   var l = $('.ladda-button').ladda();
   l.ladda('start');
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
        l.ladda('stop');
        swal("Save Complete!", "", "success");
        $('#actives').removeClass("disabled");
    }else
    {        
        l.ladda('stop');
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
  });
JS;
$this->registerJs($s);
?>
