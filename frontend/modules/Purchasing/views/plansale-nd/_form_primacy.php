<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use app\models\TbDepartment;
use app\modules\Purchasing\models\VwPcplantypeNd;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\TbPcplan;

$this->title = 'ปรับปรุงจะชื้อจะขายเวชภัณฑ์' . ' ';
$model->PCPlanNum;
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PCPlanNum];
$this->params['breadcrumbs'][] = 'Update';
?>
<style>
    .ui-datepicker{ z-index:1151 !important; }
</style>
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

$this->title = 'บันทึกสัญญาจะชื้อจะขายสินค้าเวชภัณฑ์มิใช่ยา';
$this->params['breadcrumbs'][] = $this->title;
?>
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
            <?php $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail13', 'value' => $auto, 'readonly' => true]) ?>
                    <?= $form->field($model, 'PCPOContactID')->textInput(['maxlength' => true, 'style' => 'background-color: #FFFF99'])->label('เลขที่สัญญาจะชื้อจะขาย <font color=red>*</font>') ?>

                    <?=
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-province',
                        'prompt' => 'เลือกฝ่าย'
                    ])->label('ฝ่าย <font color=red>*</font>');
                    ?>
                    <?=
                    $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'data' => [$section],
                        'pluginOptions' => [
                            'depends' => ['ddl-province'],
                            'placeholder' => 'เลือกแผนก...',
                            'url' => Url::to(['tbplan/get-amphur'])
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
                            ]
                    );
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
                        ]
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
                            'style' => 'background-color: #FFFF99',
                            'content' => '<i class="glyphicon glyphicon-phone"></i>'
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
                        ]
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
            <?php if ($type == 'pharmacist') { ?>
                <a href="javascript:void(0)" onclick="showselectdata()" class="btn btn-success  ladda-button" data-style = 'expand-left'><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการเวชภัณฑ์</a>
            <?php } else { ?>
                <br>
            <?php } ?>
            <hr>
            <?php
            Modal::begin([
                "id" => "tb_pcplan",
                'size' => 'modal-lg modal-primary',
                'header' => '<h4 class="modal-title">เลือกเวชภัณฑ์</h4>',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                'closeButton' => FALSE,
                'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
            ]);
            ?>
            <div id="dataread"></div>
            <?php Modal::end(); ?>
            <div id="food1">
                <?php
                if ($tbpcplangpu != "") {
                    $htl = '';
                    $htl .=Yii::$app->headertable->headertableplandetail();
                    $no = 1;
                    $cost = 0;
                    foreach ($tbpcplangpu as $result) {
                        $htl .='<tr>';
                        $htl .= '<td style="text-align:center">' . $no . '</td>';
                        //  $htl .= '<td>' . $result['PCPlanNum'] . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['ItemID'] . '</td>';
                        $htl .= '<td>' . $result['ItemName'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'], 2) . '</td>';
                        $htl .= '<td align="right">' . number_format($result['PCPlanNDQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty'], 2) . '</td>';
                        // $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanNonDrugItemEffectDate']) . '</td>';
                        if ($type == 'pharmacist') {
                            $htl .='<td style="text-align:center"><a href="javascript:editlistnondrug(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletedetailnondrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
                        } else {
                            $htl .='<td style="text-align:center"><a href="javascript:editlistnondrug(' . $result['ids'] . ')" class="btn btn-info btn-xs edit disabled"> Edit</a> <a href="javascript:deletedetailnondrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete disabled"> Delete</a></td>';
                        }
                        $htl .='</tr>';
                        $no++;
                        $cost = $cost + ($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty']);
                    }
                    $htl .='</tr></tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td>
                               </td>
                            </tr>
                        </tfoot>
                        </table>';
                    echo $htl;
                }
                ?>
            </div>                      
            <hr>
            <br>
            <div class="form-group">
                <div align="right">
                    <?php if ($type == 'pharmacist') { ?>
                        <a class="btn btn-default" id="bootbox-confirm" href="index.php?r=Purchasing/tbpcplan/wailt-approve">Close</a>
                        <a class="btn btn-info ladda-button" data-style = 'expand-left' href="javascript:approve(1)">Approve</a>
                        <?php Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                        <?php Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success', 'name' => 'aaa']) ?>
                    <?php } else { ?>
                        <a class="btn btn-default" id="bootbox-confirm" href="index.php?r=Purchasing/tbpcplan/wailt-manager-approve">Close</a>
                        <a class="btn btn-info ladda-button" data-style = 'expand-left' href="javascript:approve(2)">Approve</a>
                    <?php }
                    ?>
                </div>
            </div>
        </div><!--Widget-->
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<script>
    function showselectdata() {
        if ($('#inputEmail13').val() == "") {
            swal("กรุณาใส่ข้อมูลเลขรันก่อน");
        } else if ($('#tbpcplan2-pcplandate').val() == "") {
            swal("กรุณาใส่ข้อมูลวันที่ก่อน");
        } else if ($('#tbpcplan2-pcpocontactid').val() == "") {
            swal("กรุณาใส่ข้อมูลเลขที่สัญญาจะชื้อจะขาย");
        }
        else if ($('#ddl-province').val() == "") {
            swal("กรุณาเลือกฝ่ายก่อน");
        } else if ($('#tbpcplan2-sectionid').val() == "") {
            swal("กรุณาเลือกแผนกก่อน");
        } else if ($('#tbpcplan2-pcplanbegindate').val() == "") {
            swal("กรุณาเลือกวันที่เริ่มแผนก่อน");
        } else if ($('#tbpcplan2-pcplanenddate').val() == "") {
            swal("กรุณาเลือกวันที่สิ้นสุดแผนก่อน");
        }
        else if ($('#tbpcplan2-pcvendorid').val() == "") {
            swal("กรุณาใส่เลขประจำตัวผู้ขาย");
        }
        else {
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            $.ajax({
                url: "index.php?r=Purchasing/plan-nd/data1",
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

    function myFunselectdata(id) {
        cleartable();
        var prnums = $("#inputEmail13").val();
        $.ajax({
            url: 'index.php?r=Purchasing/plan-nd/getdata',
            type: "post",
            data: {id: id, prnums: prnums},
            dataType: 'json'
        }).success(function (result) {
            if (result.ItemID != null) {
                $("input[name=ItemID]").val(result.ItemID);
                $("#itemname").val(result.ItemName);
                $("#PCPlanNum").val($('#inputEmail13').val());
                $("#noii").val(result.itemDispUnit);
                $('#tb_pcplan').modal('hide');
                $('#effectivedate').val($('#tbpcplan2-pcplanbegindate').val());
                $('#modal1').modal('show');

            } else {
                swal("", 'รายการนี้ถูกเลือกแล้ว', "warning");
                // Notify(result.ale, 'top-right', '5000', 'warning', 'fa-warning', true);
            }
        });
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
                var id = $("#inputEmail13").val();
                var l = $('.ladda-button').ladda();
                l.ladda('start');
                $.ajax({
                    url: "index.php?r=Purchasing/plansale-nd/approve",
                    type: "post",
                    data: {id: id, type: type},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '2') {
                            $('#status_').val('Aprrove');
                        }
                        setTimeout("location.href = 'index.php?r=Purchasing/tbpcplan/wailt-approve';", 10);
                    }
                });
            }
        }
        );
    }
    function saveactive() {
        swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true, closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                var id = $("#inputEmail13").val();
                $.ajax({
                    url: "index.php?r=Purchasing/plan-nd/saveactive",
                    type: "post",
                    data: {id: id},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '1') {
                            $('#status_').val('Active');
                        }
                        //  Notify(result.data, 'top-right', '5000', 'success', 'fa-check', true);
                        swal("", result.data, "success");
                        setTimeout("location.href = 'index.php?r=Purchasing/plansale-nd';", 10);
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
                var id = $("#inputEmail13").val();
                $.ajax({
                    url: "index.php?r=Purchasing/plansale-nd/send-to-approve",
                    type: "post",
                    data: {id: id},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '2') {
                            $('#status_').val('WaitAprrove');
                        }
                        swal("", result.data, "success");
                        setTimeout("location.href = 'index.php?r=Purchasing/plansale-nd';", 10);
                    }
                });
            }
        }
        );
    }
    function  Save() {
        if ($("#NonDrugUnitCost").val() == "" || $("#NonDrugUnitCost").val() < 0.01) {
            swal('', "กรุณากรอกข้อมูลลงช่องราคาต่อหน่วย", "warning");
        } else if ($("#NonDrugOrderQty").val() == "" || $("#NonDrugOrderQty").val() < 1) {
            swal('', "กรุณากรอกข้อมูลลงช่องจำนวน", "warning");
        } else {
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            $.ajax({
                url: "index.php?r=Purchasing/plan-nd/save",
                type: "post",
                data: $('#nondrug1').serialize(),
                dataType: 'json',
                success: function (d) {
                    $("#NonDrugUnitCost").val("");
                    $("#NonDrugOrderQty").val("");
                    $("#NonDrugExtendedCost").val("");
                    $('#tb_pcplan').modal('hide');
                    $("#datepicker").val("");
                    $('#food1').html(d.htn);
                    $('#nondrug1').trigger("reset");
                    $("#modal1").modal("hide");
                    $("#tablenondrug1").DataTable({
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

    function editlistnondrug(id) {
        $.ajax({
            url: "index.php?r=Purchasing/plan-nd/editlistnondrug",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (result) {
                $("#PCDetailID").val(result.PCDetailID);
                $("input[name=PCPlanNum]").val(result.PCPlanNum);
                $("#itemname").val(result.ItemName);
                $("#ItemID").val(result.ItemID);
                $("#noii").val(result.itemDispUnit);
                $("#NonDrugUnitCost").val(result.NonDrugUnitCost);
                $("#NonDrugOrderQty").val(result.NonDrugOrderQty);
                $("#NonDrugExtendedCost").val(result.NonDrugExtendedCost);
                $("#noii").val(result.itemDispUnit);
                $("#effectivedate").val(result.PCPlanNonDrugItemEffectDate);
                $('#modal1').modal('show');
            }
        });
    }
    function deletedetailnondrug(ids) {
        swal({
            title: message_confirmdelete,
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true, closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                var prnums = $("#inputEmail13").val();
                $.ajax({
                    url: "index.php?r=Purchasing/plan-nd/deletedetailnondrug",
                    type: "post",
                    data: {ids: ids, prnums: prnums},
                    dataType: 'json',
                    success: function (result) {
                        $("#ids").val("");
                        $("input[name=tmtgpu]").val("");
                        $('#food1').html(result.htl);
                        // $('#nondrug1').trigger("reset");
                        $("#tablenondrug1").DataTable({"dom": '<"pull-left"f><"pull-right"l>tip'}
                        );

                        //Notify(result.ff, 'top-right', '5000', 'danger', 'fa-bolt', true);
                    }
                });
            }
        }
        );
    }
    function cleartable() {
        $("#NonDrugExtendedCost").val("");
        $("#PCDetailID").val("");
        $("#NonDrugOrderQty").val("");
        $("#NonDrugUnitCost").val("");

    }


</script>
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
$.validate();
JS;
$this->registerJs($script);
//$(\$form).trigger("reset");$.pjax.reload({container:'#branchesGrid'});alert("Saved!");
?>

<?php
Modal::begin([
    'id' => 'modal1',
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">บันทึกแผนจะชื้อจะขาย</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE
]);
?>

<div class="modal-body">
    <form id="nondrug1"  method="post">
        <input type="hidden" value="<?= !empty($types) ? $types : '' ?>" id="types"/>
        <input type="hidden" id="PCDetailID" name="PCDetailID" value="">
        <input  type="hidden"  class="form-control" id="PCPlanNum" name="PCPlanNum" readonly=""/>
        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group">
                    <label class="col-sm-7 control-label">รหัสสินค้า</label>
                    <input  type="text" readonly="" class="form-control" name="ItemID" id="ItemID"/>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label class="col-sm-7 control-label">ชื่อสินค้า</label>
                    <textarea class="form-control" id="itemname" name="itemname" rows="2" readonly=""></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label class="col-sm-12 control-label">ราคาต่อหน่วย</label>
                    <input style="background-color: #FFFF99;text-align:right"  onkeypress="return isNumberKey(event)" type="text" class="form-control" name="NonDrugUnitCost" id="NonDrugUnitCost" placeholder="0" />
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label class="col-sm-12 control-label">จำนวน</label>
                    <input style="background-color: #FFFF99;text-align:right" onkeypress="return isNumberKey(event)"  type="text" class="form-control" name="NonDrugOrderQty" id="NonDrugOrderQty" placeholder="0"/>
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
                    <label class="col-sm-7 control-label">รวมเป็นเงิน</label>
                    <input  type="text" style="text-align:right" name="NonDrugExtendedCost" id="NonDrugExtendedCost" class="form-control" readonly=""/>
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <label class="col-sm-9 control-label">วันที่เริ่มใช้งาน</label>
                    <input style="background-color: #FFFF99" data-validation="required" id="effectivedate"  type="text" data-mask="99/99/9999" class="form-control calendar"   value="" name="PCPlanNonDrugItemEffectDate">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <a class="btn btn-danger" onclick="crear();"> Clear</a>
    <a class="btn btn-default" onclick="cleartable();" data-dismiss="modal">Close</a>
    <button type="submit"  onclick="Save();" class="btn btn-success ladda-button" data-style = 'expand-left'> save</button>
</div>
<?php
Modal::end();
?>
<?php
Modal::begin([
    "id" => "tb_venderrs",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">เลือกผู้ขาย</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE
]);
?>
                <!--<table id="pcplandrugtable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">-->
<table id="vender_select" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr style="white-space: nowrap; overflow: hidden; text-overflow:ellipsis;">
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
$s = <<< JS
$(document).ready(function() {     
   $("#tablenondrug1").DataTable({ bInfo: false,
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
