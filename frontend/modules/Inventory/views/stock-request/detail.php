<?php

use kartik\widgets\Select2;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\Tbpackunit;

$form = ActiveForm::begin([ 'id' => 'formdetail']);
?>

<div class="well">
    <div class="row">
        <div class="form-group">
            <input type="hidden" id="itempack1" name="itempack1" value="<?php echo $itempackid->ItemPackID ?>"/>
            <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'SRNum', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'SRID', ['showLabels' => false])->hiddenInput() ?>
            <?= Html::activeLabel($model, 'ItemID', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
            <div class="col-sm-8">
                <?=
                $form->field($model, 'ItemID', ['showLabels' => false])->textInput([
                    'maxlength' => true,
                    'readonly' => true,
                ])
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label no-padding-right">รายละเอียดยา</label>
            <div class="col-sm-8">
                <?=
                $form->field($model, 'ItemName', ['showLabels' => false])->textarea([
                    'rows' => 3,
                    'readonly' => true,
                    'style' => 'background-color:white',
                    'value' => $model->sr2detail->ItemDetail
                ])
                ?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left"></label>
                <div class="col-sm-8">
                    <div class="radio">
                        <label><input type="radio" name="แพค" disabled="" id="แพค" value="yes"/><span class="text">แพค</span> </label>
                        <label><input type="radio" checked="checked" disabled="" name="ชิ้น" id="ชิ้น" value="no"/> <span class="text">ชิ้น</span></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'SRPackQty', ['showLabels' => false])->textInput([
                        'readonly' => 'readonly',
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($model['SRPackQty'], 2),
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($itempackid, 'ItemPackUnit', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbpackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                        'language' => 'en',
                        'disabled' => true,
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        ],
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">ปริมาณ/แพค</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        <input type="text" class="form-control" readonly="" value="<?php
                        if ($itempackid->ItemPackSKUQty != null) {
                            echo $itempackid->ItemPackSKUQty;
                        } else {
                            echo '0.00';
                        }
                        ?>" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                               />
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">จำนวนขอเบิก </label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'SRItemOrderQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'readonly' => 'readonly',
                        'value' => number_format($model['SRItemOrderQty'], 2),
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">หน่วย</label>
                <div class="col-sm-8">
                    <input type="text" readonly="true" class="form-control" style="background-color: white;text-align:center" value="<?php echo$itempackid->DispUnit; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left"></label>
                <div class="col-sm-8">
                    <div class="radio">
                        <label><input type="radio"  name="แพค2" id="แพค2" value="yes"/> <span class="text">แพค</span></label>
                        <label><input type="radio"  checked="checked" name="ชิ้น2" id="ชิ้น2" value="no"/> <span class="text">ชิ้น</span></label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'SRPackQtyApprove', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($model['SRPackQtyApprove'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($model, 'SRItemPackIDApprove', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbpackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                        'language' => 'en',
                        'pluginOptions' => [

                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        //'disabled' => true
                        ],
                    ])
                    ?>
                    <?php echo!empty($btn) ? $btn : '' ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/แพค</label>
                <div class="col-sm-8">
                    <div class="form-group field-vwsr2detail2-srapproveqty">
                        <input type="text" class="form-control" readonly="" id="ItemPackSKUQty2" name="ItemPackSKUQty2" style="background-color: white;text-align: right"  
                               value="<?php
                               if ($itempackid->ItemPackSKUQty != null) {
                                   echo $itempackid->ItemPackSKUQty;
                               } else {
                                   echo '0.00';
                               }
                               ?>"/>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">จำนวนอนุมัติ <a id="checkชิ้น"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($model, 'SRItemOrderQtyApprove', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => $model['SRItemOrderQtyApprove'] == null ? number_format($model['SRItemOrderQty'], 2) :number_format($model['SRItemOrderQtyApprove'], 2),
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">หน่วย</label>
                <div class="col-sm-8">
                    <input type="text" readonly="true" class="form-control" style="background-color: white;text-align:center" value="<?php echo$itempackid->DispUnit; ?>"/>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <br>
            <div style="text-align: right;margin-top: 10px">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <button href="#" class="btn btn-danger" data-dismiss="modal">Clear</button>
                <button class="btn btn-success ladda-button" data-style ='expand-left' type="submit">Save</button>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
$(document).ready(function () {
    $('#tbsritemdetail2-sritemorderqtyapprove').autoNumeric('init');
        var itempack1 = $('#itempack1').val();
        if(itempack1 != ""){
        $('#ชิ้น').removeAttr('checked', 'checked');
        $('#แพค').attr('checked', 'checked');
        $('#ชิ้น2').removeAttr('checked', 'checked');
        $('#แพค2').attr('checked', 'checked');
        }
        
    if($("#ชิ้น2").is(':checked'))
    {
        $('#checkชิ้น').html('<font color=red>*</font>');
         $('#tbsritemdetail2-sritemorderqtyapprove').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-sritemorderqtyapprove').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqtyapprove').attr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqtyapprove').css('background-color', '#FFFFFF');
         $('#tbsritemdetail2-sritempackidapprove').attr('disabled', 'disabled');
    }
    if($("#แพค2").is(':checked')){
         $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color=red>*</font>');
         $('#tbsritemdetail2-srpackqtyapprove').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-srpackqtyapprove').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqtyapprove').attr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqtyapprove').css('background-color', '#FFFFFF');
        
    }
        
        
         $("#tbsritemdetail2-sritempackidapprove").val($('#vwitempack-itempackunit').val()).trigger("change");
         $("#vwsr2detail2-srapproveqty").keyup(function () {
         $("#vwsr2detail2-srapproveqty").priceFormat({prefix: ''});
    });
      //<---คำนวนแพค  -->
        $("#tbsritemdetail2-srpackqtyapprove").keyup(function () {
        $("#tbsritemdetail2-srpackqtyapprove").priceFormat({prefix: ''});
        
        var uni = parseFloat($("#tbsritemdetail2-srpackqtyapprove").val().replace(/[,]/g, "")); 
        var orq = parseFloat($("#ItemPackSKUQty2").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#tbsritemdetail2-sritemorderqtyapprove").val(addCommas(jj.toFixed(2)));
        } else {
            $("#tbsritemdetail2-sritemorderqtyapprove").val('0.00');
        }
           
        var num1 = parseFloat($("#tbsritemdetail2-srpackqtyapprove").val().replace(/[,]/g, "")); 
        var num2 = parseFloat($("#tbsritemdetail2-srpackqty").val().replace(/[,]/g, ""));
        
      // if (num1 > num2) {
      //    swal("", "คุณใส่ข้อมูลเกิน", "warning");
      //       $("#tbsritemdetail2-srpackqtyapprove").val(addCommas(num2.toFixed(2)));
      //       var sum1 = parseFloat($("#tbsritemdetail2-srpackqtyapprove").val().replace(/[,]/g, "")); 
      //       var sum2 = parseFloat($("#ItemPackSKUQty2").val().replace(/[,]/g, ""));
      //       var sum3 = sum1 * sum2;
      //       $("#tbsritemdetail2-sritemorderqtyapprove").val(addCommas(sum3.toFixed(2)));
        
      //   } 
        
        
    });
         //<---คำนวนแพค  -->
    $("#tbsritemdetail2-sritemorderqtyapprove").keyup(function () {
      // $("#tbsritemdetail2-sritemorderqtyapprove").priceFormat({prefix: ''});
        var uni = parseFloat($("#tbsritemdetail2-sritemorderqtyapprove").val().replace(/[,]/g, "")); 
        var un2 = parseFloat($("#tbsritemdetail2-sritemorderqty").val().replace(/[,]/g, ""));
        
        // if (uni > un2) {
        //     swal("", "คุณใส่จำนวนเกินที่ขอเบิก", "warning");
        //     $("#tbsritemdetail2-sritemorderqtyapprove").val(addCommas(un2.toFixed(2)));
        // } 
    });
     
        
    $('#แพค2').on('change', function() {
         $('#tbsritemdetail2-sritempackidapprove').removeAttr('disabled', 'disabled');
         $('#ชิ้น2').removeAttr('checked', 'checked');
         $('#แพค2').attr('checked', 'checked');
         $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color=red>*</font>');
         $('#checkชิ้น').html('');
         $('#tbsritemdetail2-srpackqtyapprove').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-srpackqtyapprove').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqtyapprove').attr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqtyapprove').css('background-color', '#FFFFFF');
              
   });
    $('#ชิ้น2').on('change', function() {
        $('#แพค2').removeAttr('checked', 'checked');
        $('#ชิ้น2').attr('checked', 'checked');
         $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
         $('#checkชิ้น').html('<font color=red>*</font>');
         $('#tbsritemdetail2-srpackqtyapprove,#ItemPackSKUQty2').val('0.00');
         $('#tbsritemdetail2-sritempackidapprove').val('').trigger("change");
         $('#tbsritemdetail2-sritempackidapprove').attr('disabled', 'disabled');
         $('#tbsritemdetail2-sritemorderqtyapprove').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-sritemorderqtyapprove').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqtyapprove').attr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqtyapprove').css('background-color', '#FFFFFF');
               
   });
        
          //เลือกแพค
        $('#tbsritemdetail2-sritempackidapprove').on('change', function() { 
        var item_ids =  $('#tbsritemdetail2-itemid').val();
        var item_packid_unit =  $('#tbsritemdetail2-sritempackidapprove').val();
        $.get(
                        'index.php?r=Inventory/stock-request/select-box',
                        {
                        item_ids:item_ids,item_packid_unit:item_packid_unit   
                        },
                function (data)
                {
                    $('#ItemPackSKUQty2').val(data);
        var tbsritemdetail2tempsrpackqty_ = $('#tbsritemdetail2-srpackqtyapprove').val().replace(/[,]/g, "");
        var ItemPackSKUQty_ = $('#ItemPackSKUQty2').val().replace(/[,]/g, "");
        var sumpack = tbsritemdetail2tempsrpackqty_*ItemPackSKUQty_;
       
        $('#tbsritemdetail2-sritemorderqtyapprove').val(addCommas(sumpack.toFixed(2)));
        
                }
                );   
        });
        
//On Save
    $('#formdetail').on('beforeSubmit', function(e)
    {
       if($("#แพค2").is(':checked')){
           if($('#tbsritemdetail2-srpackqtyapprove').val()<1){
                swal("", "กรุณาใส่จำนวนแพค", "warning");
                 return false;
            }else{
                var \$form = $(this);
        run_waitMe(1);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 1)
            {
            $(\$form).trigger("reset");
       
                    
                   $('#formdetail').modal('hide');
                   $('#tpu_sr2_detail_list2').modal('hide');
                   swal("Save Complete!", "", "success");
        waitMe_hide(1);
                   $.pjax.reload({container:'#sr2_detail_'});
            } else
            {
        waitMe_hide(1);
            $("#message").html(result);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
            }
        } else if($("#ชิ้น2").is(':checked')){
            if($('#tbsritemdetail2-sritemorderqtyapprove').val() < 1){
                swal("", "กรุณาใส่จำนวนขอเบิก", "warning");
                return false;
            }else{
                var \$form = $(this);
       run_waitMe(1);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 1)
            {
            $(\$form).trigger("reset");
       
                   $('#formdetail').modal('hide');
                   $('#tpu_sr2_detail_list2').modal('hide');
                   swal("Save Complete!", "", "success");
                   waitMe_hide(1);
                   $.pjax.reload({container:'#sr2_detail_'});
      
            } else
            {
             waitMe_hide(1);
             $("#message").html(result);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
            }
   }
    
    });
        
});
JS;
$this->registerJs($script);
?>