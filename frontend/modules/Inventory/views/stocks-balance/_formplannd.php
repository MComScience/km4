<?php

use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

//use yii\helpers\Html;
//use kartik\select2\Select2;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formplannd']); ?>
<div class="well">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รหัสสินค้า</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'ItemID', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white',
                        'readonly' => true
                    ]);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รายละเอียดสินค้า</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'ItemName', ['showLabels' => false])->textarea([
                        'style' => 'background-color: white',
                        'rows' => 5,
                        'value' => $vwmodel['ItemName'],
                        'disabled' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคาต่อหน่วยตามแผน</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PCPlanNDUnitCost', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['PCPlanNDUnitCost'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div> 
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ปริมาณตามแผน</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PCPlanNDQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['PCPlanNDQty'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อแล้ว</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PRApprovedQtySUM', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['PRApprovedQtySUM'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ขอซื้อได้</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($vwmodel, 'PRNDAvalible', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($vwmodel['PRNDAvalible'], 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right"></label>
                <div class="col-sm-4">
                    <div class="radio">
                        <label><input type="radio" name="แพค" id="แพค" value="yes"/> แพค</label>
                        <label><input type="radio" name="แพค"  id="ชิ้น" value="no"/> ชิ้น</label>
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
                        'value' => number_format($model['ItemPackCost'], 2),
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
                        'value' => number_format($model->PRQty, 2)
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
                        'value' => number_format($model['PRUnitCost'], 2),
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
                        'value' => number_format($model->PRQty * $vwmodel->PRUnitCost, 2),
                        'readonly' => true
                    ]);
                    ?>
                </div>
            </div>
            <input id="PackUnit" type="hidden" value="<?php echo $PackUnit; ?>" />
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

$('#formplannd').on('beforeSubmit', function(e) 
{
   var \$form = $(this);
    $.post(
        \$form.attr("action"), // serialize Yii2 form
        \$form.serialize()
    )
        .done(function(result) {
        if(result == 1)
        {
            $('#formplannd').trigger("reset");
            $.pjax.reload({container:'#detailplannd'});
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
        $("#vwndplandetailprselectedpocont-prextenedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwndplandetailprselectedpocont-prextenedcost").val('0.00');
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
        $("#vwndplandetailprselectedpocont-prextenedcost").val(addCommas(jj.toFixed(2)));
    } else {
        $("#vwndplandetailprselectedpocont-prextenedcost").val('0.00');
    }
});
        
//Pack
$(document).ready(function () {
        var PackUnit = $("#PackUnit").val();
        if (PackUnit == "") {
            document.getElementById("ชิ้น").checked = true;
            if ($("input[id=ชิ้น]").is(":checked"))
            {
                Chin();
            }
        } else {
            document.getElementById("แพค").checked = true;
            if ($("input[id=แพค]").is(":checked")) {
                $("#tbprselecteddetail-itempackid").val(PackUnit).trigger("change");
                Pack();
            }
        }
    });

    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost").attr('readonly', 'readonly');
        //$("#tbprselecteddetail-itempackid").attr('disabled', 'disabled');
        $("#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost').css('background-color', '#FFFF99');
        $('#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost').css('background-color', 'white');
    }
    function Pack() {
        $("#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost").removeAttr('readonly');
        //$("#tbprselecteddetail-itempackid").removeAttr('disabled');
        $("#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#tbprselecteddetail-prpackqty,#tbprselecteddetail-itempackcost').css('background-color', '#FFFF99');
        $('#tbprselecteddetail-prqty,#tbprselecteddetail-prunitcost').css('background-color', 'white');
    }
        
$(document).ready(function () {
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
        
 $('#tbprselecteddetail-itempackid').on('change', function () {
    var ItemID = $("#tbprselecteddetail-itemid").val();
    var ItemPackUnit = $(this).find("option:selected").val();
    var qty = parseFloat($("#tbprselecteddetail-prpackqty").val().replace(/[,]/g, ""));
    var PRUnitCost = parseFloat($("#tbprselecteddetail-prunitcost").val().replace(/[,]/g, ""));
    $.ajax({
        url: "index.php?r=Inventory/stocks-balance/get-qtynd",
        type: "post",
        data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit,qty:qty},
        dataType: 'json',
        success: function (data) {
          $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
          var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
          var jj = (SKUQty) * (qty);
          var Total = jj * PRUnitCost;
        if(data.qty == 0){
          $('#tbprselecteddetail-prqty').val('0.00');
        }else{
            $("#tbprselecteddetail-prqty").val(addCommas(jj.toFixed(2)));
            $("#vwndplandetailprselectedpocont-prextenedcost").val(addCommas(Total.toFixed(2)));
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
        //$("#tbprselecteddetail-prqty").val(uni);
    } else if (orq > 0){
        orq = orq.toFixed(2);
        $("#tbprselecteddetail-prqty").val(addCommas(jj.toFixed(2)));
        $("#vwndplandetailprselectedpocont-prextenedcost").val(addCommas(Total.toFixed(2)));
    }
});
$("#tbprselecteddetail-itempackcost").keyup(function () {
    $('input[id="tbprselecteddetail-itempackcost"]').priceFormat({prefix: ''});
    var qty = $("#tbprselecteddetail-prqty").val().replace(/[,]/g, "");
    var uni = parseFloat($("#tbprselecteddetail-itempackcost").val().replace(/[,]/g, ""));
    var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
    var jj = uni / orq;
    var ext = qty * jj;
    $("#vwndplandetailprselectedpocont-prextenedcost").val(addCommas(ext.toFixed(2)));
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
