<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TbPcplan;
use app\models\TbDepartment;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use frontend\assets\DataTableAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\AutoNumericAsset;

DataTableAsset::register($this);
LaddaAsset::register($this);
AutoNumericAsset::register($this);

$this->title = 'ปรับปรุงแผนจัดชื้อยาการค้า';
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PCPlanNum, 'url' => ['view', 'id' => $model->PCPlanNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#drugsale").addClass("active");
    $("#effectivedate").datepicker({});
    '); ?>
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

$this->title = 'บันทึกสัญญาจะชื้อจะขายยา';
$this->params['breadcrumbs'][] = $this->title;
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
            <?php yii\widgets\Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php
            $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'value' => $auto, 'readonly' => true]) ?>
                    <?= $form->field($model, 'PCPOContactID')->textInput(['maxlength' => true, 'style' => 'background-color: #FFFF99'])->label('เลขที่สัญญาจะชื้อจะขาย <font color=red>*</font>') ?>
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
                            'url' => Yii::$app->request->baseUrl . '//km4/Purchasing/tbpcplan/getsection'
                        ]
                    ])->label('แผนก <font color=red>*</font>');
                    ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                            if ($model->PCPlanStatusID == 1) {
                                echo 'Draft';
                            } else {
                                echo 'Active';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->PCPlanStatusID; ?>" name="TbPcplan[PCPlanStatusID]" />
                    <?php
                    $form->field($model, 'PCPlanStatusID')->dropdownList(
                            ArrayHelper::map(TbPcplanstatus::find()->all(), 'PCPlanStatusID', 'PCPlanStatus'), [
                        'disabled' => 'disabled'
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
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
                    <?=
                    $form->field($model, 'PCVendorID')->textInput(['maxlength' => true, 'style' => 'background-color: #FFFF99'])->label('เลขประจำตัวผู้ขาย<font color=red>*</font>')
                    ?>
                    <div class="form-group field-tbpcplan-pcvendorid">
                        <label  class="control-label col-sm-3" for="inputEmail3">ชื่อผู้ขาย</label>
                        <div class="col-sm-6">
                            <input type="text" name="vendername" id="vendername" readonly="true" class="form-control" value="<?php echo(!empty($vendername) ? $vendername : ''); ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <?php if ($type == 'pharmacist') {  ?>
            <a href="javascript:showselectdata()" class="btn btn-success ladda-button" data-style = 'expand-left'><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการยาการค้า</a>
            <?php }else{?>
            <br>
            <?php }
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
            <div id="food">
                <?php
                if ($tbpcplangpu != "") {
                    $htl = Yii::$app->headertable->headertableplandrugdetail();
                    $no = 1;
                    $cost = 0;
                    foreach ($tbpcplangpu as $result) {
                        $htl .='<tr>';
                        $htl .= '<td style="text-align:center">' . $no . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['TMTID_TPU'] . '</td>';
                        $htl .= '<td>' . $result['FSN_TMT'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['TPUUnitCost'], 2) . '</td>';
                        $htl .= '<td align="right">' . number_format($result['TPUOrderQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['TPUUnitCost'] * $result['TPUOrderQty'], 2) . '</td>';
                       if ($type == 'pharmacist') { 
                        $htl .='<td style="text-align:center"><a href="javascript:editlistdrugpcplan(' . $result['ids'] . ')"  class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletelistdrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete"> Delete</a></td>';
                       }else{
                       $htl .='<td style="text-align:center"><a href="javascript:editlistdrugpcplan(' . $result['ids'] . ')"  class="btn btn-info btn-xs edit disabled"> Edit</a> <a href="javascript:deletelistdrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete disabled"> Delete</a></td>';
                       }
                        $htl .='</tr>';
                        $no++;
                        $cost = $cost + ($result['TPUUnitCost'] * $result['TPUOrderQty']);
                    }
                    $htl .='</tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td></td> 
                            </tr>
                        </tfoot></table>';
                    echo $htl;
                }
                ?>
            </div>
            <hr>
            <br>
            <div class="form-group">
                <div align="right" style="margin-right: 10px">
                    <?php if ($type == 'pharmacist') { ?>
                        <a class="btn btn-default" id="bootbox-confirm" href="/km4/Purchasing/tbpcplan/wailt-approve">Close</a>
                        <a class="btn btn-info ladda-button" data-style = 'expand-left' href="javascript:approve(1)">Approve</a>
                        <?php Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                        <?php Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success', 'name' => 'aaa']) ?>
                    <?php } else { ?>
                        <a class="btn btn-default" id="bootbox-confirm" href="/km4/Purchasing/tbpcplan/wailt-manager-approve">Close</a>
                        <a class="btn btn-info ladda-button" data-style = 'expand-left' href="javascript:approve(2)">Approve</a>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<script>
    function showselectdata() {
        if ($('#inputEmail3').val() == "") {
            swal("กรุณาใส่ข้อมูลเลขรันก่อน");
        } else if ($('#tbpcplan2-pcpocontactid').val() == "") {
            swal("กรุณาใส่ข้อมูลเลขที่สัญญาจะชื้อจะขาย");
        } else if ($('#tbpcplan2-pcplandate').val() == "") {
            swal("กรุณาใส่ข้อมูลวันที่ก่อน");
        }
        else if ($('#tbpcplan2-pcplanbegindate').val() == "") {
            swal("กรุณาเลือกวันที่เริ่มแผนก่อน");
        } else if ($('#tbpcplan2-pcplanenddate').val() == "") {
            swal("กรุณาเลือกวันที่สิ้นสุดแผนก่อน");
        } else if ($('#tbpcplan2-pcvendorid').val() == "") {
            swal("กรุณาใส่เลขประจำตัวผู้ขาย");
        } else {
            var l = $('.ladda-button').ladda();
            l.ladda('start');
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
                url: "savedata",
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
                    }
                    );
                    swal("", d.ff, "success");
                    l.ladda('stop');
                }
            });
        }
    }
    function myFunpcplanbydrug(id) {
        var prnums = $("#inputEmail3").val();
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
                    // $('#tb_pcplan').modal('hide');
                    $('#mmm').modal('show');
                    $("#noii").val(result.itemDispUnit);
                    $('#effectivedate').val($('#tbpcplan2-pcplanbegindate').val());
                } else {
                    swal("", 'รายการนี้ถูกเลือกแล้ว', "warning");
                }
            }
        });
    }
    function savepcplanbymainform() {
        $.ajax({
            url: "/km4/Purchasing/pcplanbydrugsale/savedaff",
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
                        //Notify(result.data, 'top-right', '5000', 'success', 'fa-check', true);
                        setTimeout("location.href = '/km4/Purchasing/tbplandrugsale';", 2000);
                    }
                });
            }
        }
        );
    }
    function sendtoapprove() {
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
                    url: "send-to-approve",
                    type: "post",
                    data: {id: id},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '2') {
                            $('#status_').val('WaitAprrove');
                        }
                        swal("", result.data, "success");
                        setTimeout("location.href = '/km4/Purchasing/tbplandrugsale';", 2000);
                    }
                });
            }
        }
        );
    }
    function approve(type) {
        swal({
            title: "ยืนยันการอนุมัติ ?",
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
                    url: "approve",
                    type: "post",
                    data: {id: id,type:type},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '2') {
                            $('#status_').val('Aprrove');
                        }
                        setTimeout("location.href = '/km4/Purchasing/tbpcplan/wailt-approve';", 2000);
                    }
                });
            }
        }
        );
    }
    function deletelistdrug(ids) {
        swal({
            title: "ยืนยันการลบ!",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true, closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                var prnums = $("#inputEmail3").val();
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

                        // Notify(result.ff, 'top-right', '5000', 'danger', 'fa-bolt', true);
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
    }
    
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
    function chkNum(ele)
    {
        var num = parseFloat(ele.value);
        ele.value = addCommas(num.toFixed(2));
    }
</script>
<?php
Modal::begin([
    "id" => "mmm",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">บันทึกแผนจัดชื้อยาการค้า</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE
]);
?>
<div class="modal-body">
    <form id="formtmtgpu">
        <input type="hidden" value="<?= !empty($types) ? $types : '' ?>" id="types"/>
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
Modal::begin([
    "id" => "tb_venderrs",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">เลือกผู้ขาย</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<table id="vender_select" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>รหัสผู้ขาย</th>
            <th>ชื่อผู้ขาย</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<?php Modal::end(); ?>
<?php
$script = <<< JS
$('form#{$model->formName()}').on('beforeSubmit', function(e) 
{
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
    swal("", "Savesucessfully", "success");
$('#actives').removeAttr("class");
    }else
    {        
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
      });
        $("#tbpcplan2-pcvendorid").click(function(){
          $('#tb_venderrs').modal('show');
        });
      $('#vender_select').DataTable({
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
             ],
      
    });
});
   $("#vender_select").delegate('tr', 'click', function() { 
       $('#tbpcplan2-pcvendorid').val($(this).children(":first").text());
       $('#vendername').val($(this).children(":first").next().text());  
        $('#tb_venderrs').modal('hide');
    });
        
JS;
$this->registerJs($s);
?>
<?php
$s1 = <<< JS
$(document).ready(function() {
    $("#gpuunitCost").keyup(function () {
        $(this).autoNumeric('init');
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
        $(this).autoNumeric('init');
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="gpuunitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="gpuorderqty"]').val().replace(/[,]/g, ""));
        sum1 = sum2 * sum1;
        sum1 = sum1.toFixed(2);
        $('#gpuextended').val(addCommas(sum1));

    });
});
JS;
$this->registerJs($s1);
?>


