<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetailnd']);
?>
<div class="well">
    <div class="row">
        <div class="col-xs-6">
            <input class="form-control " id="cmd"  name="cmd" type="hidden"/>
            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'ItemID', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white',
                        'value' => $ItemID,
                    ])
                    ?>
                </div> 
            </div>



            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ชื่อสินค้า<a id="checkName"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemName', ['showLabels' => false])->textarea([
                        'rows' => 3,
                        'readonly' => FALSE,
                        'style' => 'background-color:white',
                        //'value' => $ItemName,
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ประเภทเวซภัณฑ์ฯ<a id="checkCat"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modelsupply, 'ItemNDMedSupplyCatID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\TbItemndmedsupply::find()->all(), 'ItemNDMedSupplyCatID', 'ItemNDMedSupply'),
                        'language' => 'en',
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        //'disabled' => true
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
               <label class="col-sm-4 control-label no-padding-right"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRLastUnitCost', ['showLabels' => false])->HiddenInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($modeledit['PRLastUnitCost'], 2),
                    ])
                    ?>
                </div>
            </div>
       </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อแบบ</label>
                <div class="col-sm-8">
                    <input type="hidden" name="แพค">
                    <div class="radio">
                        <label>
                            <input name="แพค" type="radio" value="yes" id="แพค">
                            <span class="text">แพค </span>
                        </label>
                        <label>
                            <input name="แพค" type="radio" value="no" id="ชิ้น">
                            <span class="text">ชิ้น </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($modeledit['PRPackQty'], 2),
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค<a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modelpack, 'PackUnitID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->all(), 'PackUnitID', 'PackUnit'),
                        'language' => 'en',
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        //'disabled' => true
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/ต่อแพค<a id="checkปริมาณแพค"></a></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($ItemPackSKUQty == null) {
                               echo '0.00';
                           } else {
                               echo number_format($ItemPackSKUQty,2);
                           }
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคา/แพค <a id="checkราคาต่อแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemPackCost', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['ItemPackCost'], 2),
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อ <a id="checkขอซื้อ"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PROrderQty', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['PROrderQty'], 2),
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วย<a id="checkUnit"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($DispUnit, 'DispUnit', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\TbDispunit::find()->all(), 'DispUnitID', 'DispUnit'),
                        'language' => 'en',
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                            //'disabled' => true
                        ],
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRUnitCost', ['showLabels' => false])->textInput([
                        'value' => number_format($modeledit['PRUnitCost'], 2),
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeledit, 'PRExtendedCost', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'PRExtendedCost', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'value' => number_format($modeledit['PRExtendedCost'], 2),
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <input type="hidden" id="vwpritemdetail2temp-itempackunit" value="<?php echo $modeledit['ItemPackUnit']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-itemdispunit" name="VwPritemdetail2Temp[itemDispUnit]" value="<?php echo $modeledit['itemDispUnit']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-itempackid" name="VwPritemdetail2Temp[ItemPackID]" value="<?php echo $modeledit['ItemPackID']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-prid" name="VwPritemdetail2Temp[PRID]" value="<?php echo $modeledit['PRID']; ?>"/>
        
        
        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<!--JSScript/-->
<?php
$script = <<< JS
$(document).ready(function () {
        $('#vwpritemdetail2temp-prlastunitcost').css('background-color', '#FFFF99');
        $('#checkName,#checkCat,#checkUnit,#ราคาซื้อครั้งล่าสุด').html('<font color="red">*</font>');
        //คำนวณ on chang หน่วยแพค
        $('#vwpritemdetail2temp-itempackid').on('change', function () {
            var TMTID_GPU = $("#vwpritemdetail2temp-tmtid_gpu").val();
            var ItemPackUnit = $(this).find("option:selected").val();
            var qty = parseFloat($("#vwpritemdetail2temp-prpackqty").val().replace(/[,]/g, ""));
            var PRUnitCost = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));
            $.ajax({
                url: "index.php?r=Purchasing/new-pr-nd/get-qtygpu",
                type: "post",
                data: {TMTID_GPU: TMTID_GPU, ItemPackUnit: ItemPackUnit, qty: qty},
                dataType: 'json',
                success: function (data) {
                    $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                    var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
                    var jj = (SKUQty) * (qty);
                    var Total = jj * PRUnitCost;
                    if (data.qty == 0) {
                        $('#vwpritemdetail2temp-prorderqty').val('0.00');
                    } else {
                        $("#vwpritemdetail2temp-prorderqty").val(addCommas(jj.toFixed(2)));
                        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(Total.toFixed(2)));
                        //var PackID = $(this).find("option:selected").text();
                        //alert( this.value ); // or $(this).val()
                    }
                }
            });
        });

        $('#vwpritemdetail2temp-pcplannum').on('change', function () {
                    var TMTID_GPU = $("#vwpritemdetail2temp-tmtid_gpu").val();
                    var PCPlanNum = $(this).find("option:selected").text();
                    $.ajax({
                        url: 'index.php?r=Purchasing/new-pr-nd/getdata-pcplangpu',
                        type: 'POST',
                        dataType: 'json',
                        data: {PCPlanNum: PCPlanNum, TMTID_GPU: TMTID_GPU},
                        success: function (data) {
                            $('#vwpritemdetail2temp-itemname').val(data.FSN_GPU);
                            $('#vwpritemdetail2temp-pritemstdcost').val(data.GPUStdCost);
                            $('#vwpritemdetail2temp-pritemunitcost').val(data.GPUUnitCost);
                            $('#vwpritemdetail2temp-pritemorderqty').val(data.GPUOrderQty);
                            $('#vwpritemdetail2temp-prapprovedorderqtysum').val(data.PRApprovedOrderQty);
                            $('#vwpritemdetail2temp-pritemavalible').val(data.PRGPUAvalible);
                        }
                    });
                });
                });
    //คำนวณขอซื้อ
    $("#vwpritemdetail2temp-prorderqty").keyup(function () {
        $('input[id="vwpritemdetail2temp-prorderqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwpritemdetail2temp-prextendedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2temp-prextendedcost").val('0.00');
        }
    });
    //คำนวณราคาต่อหน่วย
    $("#vwpritemdetail2temp-prunitcost").keyup(function () {
        $('input[id="vwpritemdetail2temp-prunitcost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwpritemdetail2temp-prextendedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2temp-prextendedcost").val('0.00');
        }
    });
//คำนวณจำนวนแพค
    $("#vwpritemdetail2temp-prpackqty").keyup(function () {
        $('input[id="vwpritemdetail2temp-prpackqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwpritemdetail2temp-prpackqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var prunitcost = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        var Total = jj * prunitcost;
        if (orq == 0) {
            $("#vwpritemdetail2temp-prorderqty").val(addCommas(uni.toFixed(2)));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
            $("#vwpritemdetail2temp-prorderqty").val(addCommas(jj.toFixed(2)));
        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(jj.toFixed(2)));
        }
    });
//คำนวณราคาต่อแพค
    $("#vwpritemdetail2temp-itempackcost").keyup(function () {
        $('input[id="vwpritemdetail2temp-itempackcost"]').priceFormat({prefix: ''});
        var qty = $("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwpritemdetail2temp-itempackcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwpritemdetail2temp-prextendedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwpritemdetail2temp-prunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwpritemdetail2temp-prunitcost").val('0.00');
        }
    });
    
  $("#ItemPackSKUQty").keyup(function () {
        $('input[id="ItemPackSKUQty"]').priceFormat({prefix: ''});
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var uni = parseFloat($("#vwpritemdetail2temp-prpackqty").val().replace(/[,]/g, ""));
        var itempackcost = parseFloat($("#vwpritemdetail2temp-itempackcost").val().replace(/[,]/g, ""));
        var prunitcost = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));
        var prorderqty = parseFloat($("#vwpritemdetail2temp-prorderqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        var qq = itempackcost / orq;
        var total = prorderqty * prunitcost;
        if (orq == 0) {
            $("#vwpritemdetail2temp-prorderqty").val(addCommas(uni.toFixed(2)));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
           $("#vwpritemdetail2temp-prorderqty").val(addCommas(jj.toFixed(2)));
           $("#vwpritemdetail2temp-prunitcost").val(addCommas(qq.toFixed(2)));
           $("#vwpritemdetail2temp-prextendedcost").val(addCommas(total.toFixed(2)));
        }
        });
    $("#vwpritemdetail2temp-prlastunitcost").keyup(function () {
        $('input[id="vwpritemdetail2temp-prlastunitcost"]').priceFormat({prefix: ''});
    });   
    //On Save
    $('#formdetailnd').on('beforeSubmit', function(e)
    {
    wait();  
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 1)
            {
            $(\$form).trigger("reset");
                    $.pjax.reload({container:'#nd_detail_id'});
                    $('#formdetailnd').trigger("reset");
                    $('#nd-modal').modal('hide');
                    $('#home').waitMe('hide');
                    swal("Saved","", "success");
            } else
            {
            $("#message").html(result);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });
    $(document).ready(function () {
        var checkd2 = $('#vwpritemdetail2temp-itemdispunit').val();
        var checkd3 = $('#vwpritemdetail2temp-itempackunit').val();
        $("#tbdispunit-dispunit").val(checkd2).trigger("change");
        $("#tbpackunit-packunitid").val(checkd3).trigger("change");
        
        var checkd1 = $('#vwpritemdetail2temp-prpackqty').val();    
            if (checkd1 == '' ||checkd1 == '0.00'){
        document.getElementById("ชิ้น").checked = true;
        }else{
              document.getElementById("แพค").checked = true;         
        } 
        if ($("input[id=ชิ้น]").is(":checked"))
        {    
             $('#tbpackunit-packunitid').attr('disabled','disabled');
             $('#ItemPackSKUQty').attr('readonly', 'readonly');
             $('#tbpackunit-packunitid').attr('disabled','disabled');
             $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").attr('readonly', 'readonly');
             $("#vwpritemdetail2temp-itempackid").attr('readonly', 'readonly');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").removeAttr('readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณแพค').html('');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', 'white');
        }else{
            
             $('#tbpackunit-packunitid').removeAttr('disabled');
             $('#ItemPackSKUQty').removeAttr('readonly');
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").removeAttr('readonly');
             $("#vwpritemdetail2temp-itempackid").removeAttr('disabled');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").attr('readonly', 'readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณแพค').html('<font color="red">*</font>');
             $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost,#ItemPackSKUQty').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', 'white');
            }
    //});
        
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {      
            
             $('#tbpackunit-packunitid').removeAttr('disabled');
             $('#ItemPackSKUQty').removeAttr('readonly');
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").removeAttr('readonly');
             $("#vwpritemdetail2temp-itempackid").removeAttr('disabled');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").attr('readonly', 'readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณแพค').html('<font color="red">*</font>');
             $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost,#ItemPackSKUQty').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', 'white');
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {   $('#ItemPackSKUQty').attr('readonly', 'readonly');
            $('#tbpackunit-packunitid').attr('disabled','disabled');
            $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
            $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").attr('readonly', 'readonly');
            $("#vwpritemdetail2temp-itempackid").attr('readonly', 'readonly');
            $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").removeAttr('readonly');
            $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค,#checkปริมาณแพค').html('');
            $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', '#FFFF99');
            $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost,#ItemPackSKUQty').css('background-color', 'white');
        }
    });
});
function wait(){
    var current_effect = 'ios'; 
    run_waitMe(current_effect);
    function run_waitMe(effect){
    $('#home').waitMe({
    effect: 'ios',
    text: 'กำลังโหลดข้อมูล...',
    bg: 'rgba(255,255,255,0.7)',
    color: '#000',
    sizeW: '',
    sizeH: '',
    source: '',
        onClose: function () {}
         });
    }
}
JS;
$this->registerJs($script);
?>

