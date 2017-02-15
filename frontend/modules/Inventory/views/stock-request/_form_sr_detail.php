<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\Inventory\models\Tbpackunit;
?>
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_detail']);
?>
<input type="hidden" value="<?php echo!empty($balance) ? $balance : '' ?>" id="_balance"/>
<div class="well">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <?=
                $form->field($modeledit, 'ids', ['showLabels' => false])->hiddenInput([
                    'maxlength' => true,
                    'readonly' => true,
                    'style' => 'background-color: white;text-align:right',
                ])
                ?>
                <?= Html::activeLabel($modeledit, 'ItemID', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: white;text-align:right',
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รายละเอียดยา</label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'ItemName', ['showLabels' => false])->textarea([
                        'rows' => 3,
                        'readonly' => true,
                        'style' => 'background-color:white',
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left"></label>
                <div class="col-sm-8">
                    <div class="radio">
                        <label><input type="radio" name="แพค1" id="แพค1" value="yes"/><span class="text">แพค</span> </label>
                        <label><input type="radio"  name="แพค1" id="ชิ้น1" value="no"/><span class="text"> ชิ้น</span></label>   
                    </div>

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'SRPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => number_format($modeledit['SRPackQty'], 2),
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right no-padding-left">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modeledit, 'SRItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbpackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
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
            <div id="wait2" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='images/712.gif' width="64" height="64" /><br>Loading..</div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/แพค</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="0.00"/>
                </div>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">จำนวนขอเบิก <a id="checkชิ้น"></a></label>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'SRItemOrderQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                      //  'value' => number_format($modeledit['SRItemOrderQty'], 2),
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right no-padding-left">หน่วย</label>
                <div class="col-sm-8">
                    <input type="text" readonly="true" class="form-control" style="background-color: white;text-align:center" value="<?php echo!empty($DispUnit) ? $DispUnit : ''; ?>"/>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden"  class="form-control" name="Tbsritemdetail2[SRID]"  value="<?php echo $SRID; ?>">
    <br>
    <div style="text-align: right">

        <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
        <a class="btn btn-danger" href="javascript::void(0)" id="_clear">Clear</a>
        <button class="btn btn-success" type="submit">Save</button>

    </div>
</div>
</div>
<?php ActiveForm::end(); ?>
<?php
$script = <<< JS
     
$(document).ready(function () {
    $('#tbsritemdetail2-sritemorderqty').autoNumeric('init');
     var tbsritemdetail2sritempackid = $('#tbsritemdetail2-sritempackid').val();
    if(tbsritemdetail2sritempackid == ""){
        $('#checkชิ้น').html('<font color=red>*</font>');
        $('#tbsritemdetail2-srpackqty').attr('readonly', 'readonly');
         //$('#tbsritemdetail2-sritemorderqty').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-sritemorderqty').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqty').attr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqty').css('background-color', '#FFFFFF');
         $('#tbsritemdetail2-sritempackid').attr('disabled', 'disabled');
         $('#ชิ้น1').attr('checked', 'checked');
   }

    if($("#ชิ้น1").is(':checked'))
       {
         $('#checkชิ้น').html('<font color=red>*</font>');
         $('#tbsritemdetail2-sritemorderqty').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-sritemorderqty').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqty').attr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqty').css('background-color', '#FFFFFF');
         $('#tbsritemdetail2-sritempackid').attr('disabled', 'disabled');
    }
    if($("#แพค1").is(':checked')){
         $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color=red>*</font>');
         $('#tbsritemdetail2-srpackqty').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-srpackqty').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqty').attr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqty').css('background-color', '#FFFFFF');
    }
        
    $('#แพค1').on('change', function() {
         $('#tbsritemdetail2-srpackqty').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-srpackqty').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqty').attr('readonly', 'readonly');
         $('#tbsritemdetail2-sritemorderqty').css('background-color', '#FFFFFF');
         $('#checkจำนวนแพค').html('<font color=red>*</font>');
         $('#tbsritemdetail2-sritempackid').removeAttr('disabled', 'disabled');
         $('#checkชิ้น').html('');
              
   });
    $('#ชิ้น1').on('change', function() {
         $('#tbsritemdetail2-sritempackid').attr('disabled', 'disabled');
         $("#tbsritemdetail2-srpackqty,#ItemPackSKUQty").val('0.00');
         $('#tbsritemdetail2-sritemorderqty').css('background-color', '#FFFF99');
         $('#tbsritemdetail2-sritemorderqty').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqty').attr('readonly', 'readonly');
         $('#tbsritemdetail2-srpackqty').css('background-color', '#FFFFFF');
         $('#checkชิ้น').html('<font color=red>*</font>');
         $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
               
   });
        
     $('#tbsritemdetail2-sritempackid').on('change', function() {
            $('#tbsritemdetail2-srpackqty').removeAttr('readonly', 'readonly');
            $('#tbsritemdetail2-srpackqty').css('background-color', '#FFFF99');
            $('#tbsritemdetail2-sritemorderqty').css('background-color', '#FFFFFF');
            $('#ชิ้น1').removeAttr('checked', 'checked');
            $('#แพค1').attr('checked', 'checked');
        
          var item_ids =  $('#tbsritemdetail2-itemid').val();
          var item_packid_unit =  $('#tbsritemdetail2-sritempackid').val();
        $.get(
                        'index.php?r=Inventory/stock-request/select-box',
                        {
                        item_ids:item_ids,item_packid_unit:item_packid_unit   
                        },
                function (data)
                {
                    $('#ItemPackSKUQty').val(data);
                }
                );   
        });
        
        
    $("#tbsritemdetail2-srpackqty").keyup(function () {
        $("#tbsritemdetail2-srpackqty").priceFormat({prefix: ''});
        
        var uni = parseFloat($("#tbsritemdetail2-srpackqty").val().replace(/[,]/g, "")); 
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        var balance = parseFloat($('#_balance').val());
        var jj = uni * orq;
        if (orq > 0) {
        if(jj > balance){
             $("#tbsritemdetail2-sritemorderqty").val(addCommas(balance.toFixed(2)));
             var   sumpackqty =  balance / orq;
            $('#tbsritemdetail2-srpackqty').val(addCommas(sumpackqty.toFixed(2)));
          }else{
           uni = uni.toFixed(2);
            $("#tbsritemdetail2-sritemorderqty").val(addCommas(jj.toFixed(2))); 
          }
            
        } else {
            $("#tbsritemdetail2-sritemorderqty").val('0.00');
        }
        
    });
        $("#tbsritemdetail2-sritemorderqty").keyup(function () {
        //$("#tbsritemdetail2-sritemorderqty").priceFormat({prefix: ''});
         var uni = parseFloat($("#tbsritemdetail2-sritemorderqty").val().replace(/[,]/g, "")); 
        var balance = parseFloat($('#_balance').val());
        if(uni>balance){
         swal("","คุณคียเกินจำนวนคงเหลือ", "warning");
         $("#tbsritemdetail2-sritemorderqty").val(addCommas(balance.toFixed(2)));
        } 
        
    });
        
         //On Save
    $('#form_detail').on('beforeSubmit', function(e)
    {
        if($("#แพค1").is(':checked')){
          if($('#tbsritemdetail2-srpackqty').val()< 1){
              swal("","กรุณาใส่จำนวนแพค", "warning");
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
                   $('#save_detail').modal('hide');
                   $('#tpu_sr2_detail_list').modal('hide');
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
      }else if($("#ชิ้น1").is(':checked')){
        if($('#tbsritemdetail2-sritemorderqty').val() < 1){
              swal("","กรุณาใส่จำนวนขอเบิก", "warning");
           // Notify('กรุณาใส่จำนวนขอเบิก', 'top-right', '5000', 'warning', 'fa-warning', true);
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
                $('#save_detail').modal('hide');
                $('#tpu_sr2_detail_list').modal('hide');
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

