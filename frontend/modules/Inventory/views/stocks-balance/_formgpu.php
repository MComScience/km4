<?php

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

//use yii\helpers\Html;
//use kartik\select2\Select2;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formgpu']); ?>
<div class="well">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รหัสยาสามัญ</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'TMTID_GPU', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white',
                        'readonly' => true
                    ]);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รายละเอียดยาสามัญ</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'FSN_GPU', ['showLabels' => false])->textarea([
                        'style' => 'background-color: white',
                        'rows' => 3,
                        'value' => $vwmodel['FSN_GPU'],
                        'disabled' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคากลาง</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'GPUStdCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true
                    ]);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อหน่วยตามแผน</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'GPUUnitCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['GPUUnitCost'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ปริมาณตามแผน</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'GPUOrderQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['GPUOrderQty'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อแล้ว</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PRApprovedOrderQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['PRApprovedOrderQty'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อได้</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PRGPUAvalible', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['PRGPUAvalible'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อแบบ</label>
                <div class="col-sm-8">
                    <div class="radio">
                        <label><input type="radio" name="แพค" id="แพค" value="yes"/> แพค</label>
                        <label><input type="radio" name="แพค" id="ชิ้น" value="no"/> ชิ้น</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'PRPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($model['PRPackQty'], 2),
                    ]);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'ItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->where(['PackUnitID' => $ItemPackUnit])->all(), 'PackUnitID', 'PackUnit'),
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
                <label  class="col-sm-4 control-label no-padding-right">ปริมาณ/แพค</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($ItemPackSKUQty == null) {
                               echo '0.00';
                           } else {
                               echo number_format($ItemPackSKUQty, 2);
                           }
                           ?>"/>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคา/แพค <a id="checkราคาต่อแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'ItemPackCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($model->ItemPackCost, 2),
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อ <a id="checkขอซื้อ"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'PRQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($model['PRQty'], 2),
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วย</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'DispUnit', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'PRUnitCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รวมเป็นเงิน</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PRExtenedCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>

            <input id="ItemPackUnit" type="hidden" value="<?php echo $PackUnit ?>"/>
        </div>
        <div class="col-md-12">
            <div class="modal-footer" >
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
<?php
$script = <<< JS

$('#formgpu').on('beforeSubmit', function(e) 
{
   var \$form = $(this);
    $.post(
        \$form.attr("action"), // serialize Yii2 form
        \$form.serialize()
    )
        .done(function(result) {
        if(result == 1)
        {
            $('#formgpu').trigger("reset");
            $.pjax.reload({container:'#detailgpu'});
            $('#activity-modal').modal('hide');
        }else
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
$("#tbprselecteddetail-prunitcost").keyup(function () { 
        $("#tbprselecteddetail-itempackcost").attr('readonly', 'readonly');
    $('input[id="tbprselecteddetail-prunitcost"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#tbprselecteddetail-prunitcost").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#tbprselecteddetail-prqty").val().replace(/[,]/g, ""));
    var jj = uni * orq;
    if (orq > 0) {
        uni = uni.toFixed(2);
        $("#vwgpuplandetailprselected-prextenedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwgpuplandetailprselected-prextenedcost").val('0.00');
    }

});
$("#tbprselecteddetail-prqty").keyup(function () {
        $("#tbprselecteddetail-itempackcost").removeAttr('readonly');
    $('input[id="tbprselecteddetail-prqty"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#tbprselecteddetail-prunitcost").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#tbprselecteddetail-prqty").val().replace(/[,]/g, ""));
    var jj = uni * orq;
    if (uni > 0) {
        orq = orq.toFixed(2);
        $("#vwgpuplandetailprselected-prextenedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwgpuplandetailprselected-prextenedcost").val('0.00');
    }
});
//CheckPack        
$(document).ready(function () {
        var ItemPackUnit = $("#ItemPackUnit").val();
        if (ItemPackUnit == ""){
             document.getElementById("ชิ้น").checked = true;
             Chin();
        }else{
             document.getElementById("แพค").checked = true;
             $("#tbprselecteddetail-itempackid").val(ItemPackUnit).trigger("change");
             Pack();
        }
        $("input[id=แพค]").click(function () {
            if ($(this).is(":checked"))
            {
                Pack();
            }
        });
        $("input[id=ชิ้น]").click(function () {
            if ($(this).is(":checked"))
            {
                Chin();
            }
        });
    });
//OnClick ชิ้น/แพค
function Pack() {
        $("#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost").removeAttr('readonly');
        //$("#tbprselecteddetail-itempackid").removeAttr('disabled');
        $("#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost').css('background-color', '#FFFF99');
        $('#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost').css('background-color', 'white');
    }
function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost").attr('readonly', 'readonly');
        //$("#tbprselecteddetail-itempackid").attr('disabled', 'disabled');
        $("#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost').css('background-color', '#FFFF99');
        $('#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost').css('background-color', 'white');
    }
 $('#tbprselecteddetail-itempackid').on('change', function () {
    var TMTID_GPU = $("#tbprselecteddetail-tmtid_gpu").val();
    var ItemPackUnit = $(this).find("option:selected").val();
    var qty = parseFloat($("#tbprselecteddetail-prpackqty").val().replace(/[,]/g, ""));
    var PRUnitCost = parseFloat($("#tbprselecteddetail-prunitcost").val().replace(/[,]/g, ""));
    $.ajax({
        url: "index.php?r=Inventory/stocks-balance/get-qtygpu",
        type: "post",
        data: {TMTID_GPU: TMTID_GPU, ItemPackUnit: ItemPackUnit,qty:qty},
        dataType: 'json',
        success: function (data) {
          $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
          var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
          var jj = (SKUQty) * (qty);
          var Total = jj * PRUnitCost;
        if(data.qty == 0){
          $('#tbprselecteddetail-prqty').val(data.ItemPackSKUQty);
        }else{
            $("#tbprselecteddetail-prqty").val(addCommas(jj.toFixed(2)));
            $("#vwgpuplandetailprselected-prextenedcost").val(addCommas(Total.toFixed(2)));
        }
          
        }
    });
    //var PackID = $(this).find("option:selected").text();
    //alert( this.value ); // or $(this).val()
});
    $("#tbprselecteddetail-prpackqty").keyup(function () {
    $('input[id="tbprselecteddetail-prpackqty"]').priceFormat({prefix: ''});
    var uni = parseFloat($("#tbprselecteddetail-prpackqty").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
    var prunitcost = parseFloat($("#tbprselecteddetail-prunitcost").val().replace(/[,]/g, ""));
    var jj = uni * orq;
    var Total = jj * prunitcost;
    if (orq == 0) {
        $("#tbprselecteddetail-prqty").val(addCommas(uni.toFixed(2)));
    } else if (orq > 0){
        orq = orq.toFixed(2);
        $("#tbprselecteddetail-prqty").val(addCommas(jj.toFixed(2)));
        $("#vwgpuplandetailprselected-prextenedcost").val(addCommas(Total.toFixed(2)));
    }
});
$("#tbprselecteddetail-itempackcost").keyup(function () {
    $('input[id="tbprselecteddetail-itempackcost"]').priceFormat({prefix: ''});
    var qty = $("#tbprselecteddetail-prqty").val().replace(/[,]/g, "");
    var uni = parseFloat($("#tbprselecteddetail-itempackcost").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
    var jj = uni / orq;
    var ext = qty * jj;
    $("#vwgpuplandetailprselected-prextenedcost").val(addCommas(ext.toFixed(2)));
    if (uni > 0) {
        orq = orq.toFixed(2);
        $("#tbprselecteddetail-prunitcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#tbprselecteddetail-prunitcost").val('0.00');
    }
});    
JS;
$this->registerJs($script);
?>
