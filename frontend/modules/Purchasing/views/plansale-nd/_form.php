<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use app\models\TbDepartment;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\TbPcplan;
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
<style>
    .ui-datepicker{ z-index:1151 !important; }
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
            <?php $form = ActiveForm::begin(['id' => 'form_main', 'layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail13', 'readonly' => true]) ?>
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
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="" value="<?php
                            if ($model->PCPlanStatusID == 1) {
                                echo 'Draft';
                            } else {
                                echo 'Active';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->PCPlanStatusID; ?>" name="TbPcplan2[PCPlanStatusID]" />

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
            <a href="javascript:void(0)" onclick="showselectdata()" class="btn btn-success ladda-button" data-style="expand-left"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการเวชภัณฑ์</a>
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

                        $htl .='<td style="text-align:center"><a href="javascript:editlistnondrug(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletedetailnondrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
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
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left','id'=>'drafsave']) ?>
                    <a id="actives" class="btn btn-info disabled ladda-button" data-style="expand-left" href="javascript:sendtoapprove()">Send To Apprrove</a>
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
            swal('', "กรุณาใส่ข้อมูลเลขรันก่อน", "warning");
        } else if ($('#tbpcplan2-pcplandate').val() == "") {
            swal('', "กรุณาใส่ข้อมูลวันที่ก่อน", "warning");
        } else if ($('#tbpcplan2-pcpocontactid').val() == "") {
            swal('', "กรุณาใส่ข้อมูลเลขที่สัญญาจะชื้อจะขาย", "warning");
        }
        else if ($('#ddl-province').val() == "") {
            swal('', "กรุณาเลือกฝ่ายก่อน", "warning");
        } else if ($('#tbpcplan2-sectionid').val() == "") {
            swal('', "กรุณาเลือกแผนกก่อน", "warning");
        } else if ($('#tbpcplan2-pcplanbegindate').val() == "") {
            swal('', "กรุณาเลือกวันที่เริ่มแผนก่อน", "warning");
        } else if ($('#tbpcplan2-pcplanenddate').val() == "") {
            swal('', "กรุณาเลือกวันที่สิ้นสุดแผนก่อน", "warning");
        }
        else if ($('#tbpcplan2-pcvendorid').val() == "") {
            swal('', "กรุณาใส่เลขประจำตัวผู้ขาย", "warning");
        }
        else {
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            //waitMe_Running_show(1);
            $.ajax({
                url: "/km4/Purchasing/plansale-nd/form_main",
                type: "post",
                data: $('#form_main').serialize(),
                success: function (result) {

                }
            });
            $.ajax({
                url: "/km4/Purchasing/plan-nd/data1",
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
                    //waitMe_Running_hide(1);
                }
            });
        }
    }
    function myFunselectdata(id) {
        cleartable();
        var prnums = $("#inputEmail13").val();
       // waitMe_Running_show(1);
        $.ajax({
            url: '/km4/Purchasing/plan-nd/getdata',
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
                waitMe_Running_hide(1);
            } else {
                swal("", 'รายการนี้ถูกเลือกแล้ว', "warning");
                waitMe_Running_hide(1);
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
            closeOnConfirm: true, closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                var id = $("#inputEmail13").val();
                $.ajax({
                    url: "/km4/Purchasing/plan-nd/saveactive",
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
               // waitMe_Running_show(2);
                $.ajax({
                    url: "/km4/Purchasing/plansale-nd/send-to-approve",
                    type: "post",
                    data: {id: id},
                    dataType: 'json',
                    success: function (result) {
                        if (result.status == '2') {
                            $('#status_').val('WaitAprrove');
                        }

                        setTimeout("location.href = '/km4/Purchasing/plansale-nd/index';", 10);
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
           // waitMe_Running_show(1);
            $.ajax({
                url: "/km4/Purchasing/plan-nd/save",
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
                    waitMe_Running_hide(1);
                    $('#drafsave').removeAttr("disabled");
                }
            });

        }
    }

    function editlistnondrug(id) {
       // waitMe_Running_show(2);
        $.ajax({
            url: "/km4/Purchasing/plan-nd/editlistnondrug",
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
                waitMe_Running_hide(2);
            }
        });
    }
    function deletedetailnondrug(ids) {
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
                var prnums = $("#inputEmail13").val();
                $.ajax({
                    url: "/km4/Purchasing/plan-nd/deletedetailnondrug",
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

$('#form_main').on('beforeSubmit', function(e) 
{
         var l = $('.ladda-button').ladda();
            l.ladda('start');
        //waitMe_Running_show(2);
   var \$form = $(this);
   $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
   if(result == 1)
   {
swal("", "Save Complete!", "success");
$('#actives').removeClass("disabled");
            l.ladda('stop');
         //waitMe_Running_hide(2);

 }else
  {        
        // waitMe_Running_hide(2);
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
        <input type="hidden" value="<?= $types ?>" id="types"/>
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
<script>
    function test(e) {
    	var id = (e.getAttribute("id"));
        $.ajax({
            url: "getvender",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (r) {
                $('#tbpcplan2-pcvendorid').val(r.venderid);
                $('#vendername').val(r.vendername);
                $('#tb_venderrs').modal('hide');
            }
        });
    }
</script>
<?php
Modal::begin([
    "id" => "tb_venderrs",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">เลือกผู้ขาย</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE
]);
?>
<div id="_vender">

</div>
<?php Modal::end(); ?>
<?php
$s = <<< JS
$(document).ready(function () {
    $("#tablenondrug1").DataTable({bInfo: false,
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
    $("#tbpcplan2-pcvendorid").click(function () {
        $.ajax({
            url: "datavender",
            type: "post",
            dataType: 'json',
            success: function (r) {
                $('#tb_venderrs').modal('show');
                $('#_vender').html(r.data);
                $('#tb_venderrs').modal('show');
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
            }
        });
    });
});
JS;
$this->registerJs($s);
?>
<?php
$this->registerJsFile(Yii::getAlias('@web') . '/js/jquery.form-validator.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
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
    
    function waitMe_Running_show(type) {
        if (type === 1) {
            var idnaclass = '.modal-content';
        } else if (type === 2) {
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
    function waitMe_Running_hide(type) {
        if (type === 1) {
            $('.modal-content').removeClass('waitMe_container');
            $('.waitMe').html('');
        } else if (type === 2) {
            $('.main-container').removeClass('waitMe_container');
            $('.waitMe').html('');
        }
    }
</script>
<?php
$s1 = <<< JS
$(document).ready(function() {
    $("#NonDrugUnitCost").keyup(function () {
        $(this).autoNumeric('init');
        //**************************************ค่าเสียหาย***************************** 
        var sum1 = 0;
        var sum2 = 0;
        if ($('input[id="NonDrugUnitCost"]').val() != '') {

            sum1 = parseFloat($('input[id="NonDrugUnitCost"]').val().replace(/[,]/g, ""));
            sum2 = parseFloat($('input[id="NonDrugOrderQty"]').val().replace(/[,]/g, ""));
            sum1 = sum1 * sum2;
            if (sum1 > 0) {
                var num = parseFloat(sum1);
                sum1 = num.toFixed(2);
                $('#NonDrugExtendedCost').val(addCommas(sum1));
            } else {
                $('#NonDrugExtendedCost').val('0.00');
            }
        }
    });
        
    //บวกเลขแผนจัดชื้อยาสามัญ
    $("#NonDrugOrderQty").keyup(function () {
        $(this).autoNumeric('init');
        var sum1 = 0;
        var sum2 = 0;
        sum1 = parseFloat($('input[id="NonDrugUnitCost"]').val().replace(/[,]/g, ""));
        sum2 = parseFloat($('input[id="NonDrugOrderQty"]').val().replace(/[,]/g, ""));
        sum1 = sum2 * sum1;
        sum1 = sum1.toFixed(2);
        $('#NonDrugExtendedCost').val(addCommas(sum1));

    });
});
JS;
$this->registerJs($s1);
?>
