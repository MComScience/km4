<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\Inventory\models\Tbpackunit;
?>
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetail']);
?>
<input type="hidden" value="<?php echo $balance ?>" id="_balance"/>
<div class="well">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <input id="sritempackid" type="hidden" value="<?php
                if (!empty($sritempackid)) {
                    echo $sritempackid;
                }
                ?>" name="sritempackid"/>
                       <?=
                       $form->field($modeledit, 'ids', ['showLabels' => false])->hiddenInput([
                           'maxlength' => true,
                           'readonly' => true,
                           'style' => 'background-color: white;text-align:right',
                       ])
                       ?>
                       <?= Html::activeLabel($modeledit, 'ItemID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color: white;',
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right">รายละเอียดยา</label>
                <div class="col-sm-9">
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
        <div id="wait2" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='/km4/images/712.gif' width="64" height="64" /><br>Loading..</div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group" style="margin-top:8px;">
                <label class="col-sm-2 control-label no-padding-right">
                    <div class="control-group">
                        <div class="radio">
                            <label>แพค <input name="แพค" id="แพค" value="yes" type="radio" class="colored-success"><span class="text"></span></label>
                        </div>
                    </div>
                </label>
                <!-- <label class="col-sm-1 control-label no-padding-right no-padding-left">จำนวนแพค <a id="checkจำนวนแพค"></a></label> -->
                <div class="col-sm-3">
                    <?=
                    $form->field($modeledit, 'SRPackQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        'value' => $modeledit['SRPackQty'],
                        //'onkeypress' => "return isNumberKey(event)",
                    ])
                    ?>
                </div>
                <div class="col-sm-3">
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
                <div class="col-sm-3">
                    <input type="text" class="form-control" value="<?php
                    if (isset($ItemPackSKUQty)) {
                        echo $ItemPackSKUQty;
                    } else {
                        echo'0.00';
                    }
                    ?>" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="0.00"/>
                </div>
            </div>
            <div class="form-group" style="margin-top:8px;">
                <label class="col-sm-2 control-label no-padding-right">
                    <div class="control-group">
                        <div class="radio">
                            <label>ชิ้น <input name="แพค" id="ชิ้น" value="no" type="radio" class="colored-success"><span class="text"></span></label>
                        </div>
                    </div>
                </label>
                <div class="col-sm-3">
                    <?=
                    $form->field($modeledit, 'SRItemOrderQty', ['showLabels' => false])->textInput([
                        'style' => 'background-color: white;text-align:right',
                        //'onkeypress' => "return isNumberKey(event)",
                        'value' => $modeledit['SRItemOrderQty'],
                    ])
                    ?>
                </div>
                <!-- <label class="col-sm-1 control-label no-padding-right no-padding-left">หน่วย</label> -->
                <div class="col-sm-3">
                    <input type="text" readonly="true" class="form-control" style="background-color: white;text-align:left" value="<?php echo!empty($DispUnit) ? $DispUnit : ''; ?>"/>
                </div>
            </div>
            <!-- <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right no-padding-left">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
            </div>

            <div class="form-group" >
                <label class="col-sm-1 control-label no-padding-right">ปริมาณ/แพค</label>
            </div>
            <br>
            <div class="form-group" >
                <label class="col-sm-1 control-label no-padding-right no-padding-left">จำนวนขอเบิก <a id="checkชิ้น"></a></label>
            </div>
            <div class="form-group" >
                <label class="col-sm-1 control-label no-padding-right no-padding-left">หน่วย</label>
            </div> -->
            <br>
            <div style="text-align-last: right">
                <input type="hidden"  class="form-control" name="Tbsritemdetail2temp[SRID]"  value="<?php echo $SRID; ?>">
                <input type="hidden" class="form-control" id="chk_boxcomfirm" value="defult">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-success ladda-button" data-style="expand-left" type="submit">Save</button>   
            </div>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
     
$(document).ready(function () {
  var tbsritemdetail2tempsritempackid = $('#tbsritemdetail2temp-sritempackid').val();
      if(tbsritemdetail2tempsritempackid == ""){
          $('#checkชิ้น').html('<font color=red>*</font>');
             $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFF99');
             $('#tbsritemdetail2temp-srpackqty').attr('readonly', 'readonly');
             $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFFFF');
             $('#tbsritemdetail2temp-sritempackid').attr('disabled', 'disabled'); 
             $('#ชิ้น').attr('checked', 'checked');
   }
    if($("#ชิ้น").is(':checked'))
       {
             $('#checkชิ้น').html('<font color=red>*</font>');
             $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFF99');
             $('#tbsritemdetail2temp-srpackqty').attr('readonly', 'readonly');
             $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFFFF');
             $('#tbsritemdetail2temp-sritempackid').attr('disabled', 'disabled');
    }
     if($("#แพค").is(':checked')){
             $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color=red>*</font>');
             $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFF99');
             $('#tbsritemdetail2temp-sritemorderqty').attr('readonly', 'readonly');
             $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFFFF');
             $('#tbsritemdetail2temp-sritempackid').removeAttr('disabled', 'disabled');
       }
   $('#แพค').on('change', function() {
              $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFF99');
              $('#tbsritemdetail2temp-sritemorderqty').attr('readonly', 'readonly');
              $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFFFF');
              $('#tbsritemdetail2temp-srpackqty').removeAttr('readonly', 'readonly');
              $('#tbsritemdetail2temp-sritempackid').removeAttr('disabled', 'disabled');
              $('#checkจำนวนแพค').html('<font color=red>*</font>');
              $('#checkชิ้น').html('');
   });
    $('#ชิ้น').on('change', function() {
                $('#แพค').removeAttr('checked','checked');
                $('#ชิ้น').attr('checked', 'checked');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
                $('#checkชิ้น').html('<font color=red>*</font>');
                $('#tbsritemdetail2temp-srpackqty,#ItemPackSKUQty').val('0.00');
                $('#tbsritemdetail2temp-sritempackid').attr('disabled', 'disabled');
                $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFF99');
                $('#tbsritemdetail2temp-srpackqty').attr('readonly', 'readonly');
                $('#tbsritemdetail2temp-sritemorderqty').removeAttr('readonly', 'readonly');
                $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFFFF');       
   });
        
     $("#tbsritemdetail2temp-sritempackid").val($('#sritempackid').val()).trigger("change");
        var sritempackid = $("#sritempackid").val();
        if(sritempackid != ""){
         $('#แพค').attr('checked', 'checked');
         $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFF99');
         $('#tbsritemdetail2temp-srpackqty').removeAttr('readonly', 'readonly');
         $('#tbsritemdetail2temp-sritemorderqty').attr('readonly', 'readonly');
         $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFFFF');
         $('#tbsritemdetail2temp-sritempackid').removeAttr('disabled', 'disabled');
          $('#checkชิ้น').html('');
        $('#checkจำนวนแพค').html('<font color=red>*</font>');
         }
        //เลือกแพค
        $('#tbsritemdetail2temp-sritempackid').on('change', function() {
            $('#tbsritemdetail2temp-srpackqty').removeAttr('readonly', 'readonly');
            $('#ชิ้น').removeAttr('checked', 'checked');
            $('#tbsritemdetail2temp-sritemorderqty').attr('readonly', 'readonly');
            $('#แพค').removeAttr('disabled', 'disabled');
            $('#แพค').attr('checked', 'checked');
            $('#tbsritemdetail2temp-sritemorderqty').css('background-color', '#FFFFFF');
            $('#tbsritemdetail2temp-srpackqty').css('background-color', '#FFFF99');
        
        var item_ids =  $('#tbsritemdetail2temp-itemid').val();
        var item_packid_unit =  $('#tbsritemdetail2temp-sritempackid').val();
        $.get(
                        'select-box',
                        {
                        item_ids:item_ids,item_packid_unit:item_packid_unit   
                        },
                function (data)
                {
                    $('#ItemPackSKUQty').val(data);
        var tbsritemdetail2tempsrpackqty_ = $('#tbsritemdetail2temp-srpackqty').val().replace(/[,]/g, "");
        var ItemPackSKUQty_ = $('#ItemPackSKUQty').val().replace(/[,]/g, "");
        var sumpack = tbsritemdetail2tempsrpackqty_*ItemPackSKUQty_;
       
        $('#tbsritemdetail2temp-sritemorderqty').val(addCommas(sumpack.toFixed(2)));
        
                }
                );   
        });
        
        
        $("#tbsritemdetail2temp-srpackqty").keyup(function () {
        });
        
        $("#tbsritemdetail2temp-sritemorderqty").keyup(function () {
        $(this).autoNumeric('init');
          var uni = parseFloat($("#tbsritemdetail2temp-sritemorderqty").val().replace(/[,]/g, "")) || 0; 
          var balance = parseFloat($('#_balance').val());
          if(balance != '0'){
            if(uni>balance){
              var isConfirm = $('#chk_boxcomfirm').val();
              if(isConfirm){
                swal({   
                  title: "",   
                  text: "คุณใส่จำนวนเกินยอดคงเหลือ?",   
                  type: "warning",   
                  showCancelButton: true,   
                  confirmButtonColor: "#53a93f",   
                  confirmButtonText: "Confirm",   
                  closeOnConfirm: true
                },function(isConfirm){
                  $('#chk_boxcomfirm').val('');
                });
              }
            } 
          }
        });
        $("#tbsritemdetail2temp-srpackqty").keyup(function () {
        $(this).autoNumeric('init');
        var uni = parseFloat($("#tbsritemdetail2temp-srpackqty").val().replace(/[,]/g, "")) || 0; 
        var orq = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, "")) || 0;
        var balance = parseFloat($('#_balance').val());
        var jj = uni * orq;
        if (orq > 0) {
        if(jj > balance){
        swal("","คุณใส่จำนวนเกินยอดคงเหลือ", "warning");
            $("#tbsritemdetail2temp-sritemorderqty").val(addCommas(balance.toFixed(2)));
            var sumpackqty =  balance / orq;
            $('#tbsritemdetail2temp-srpackqty').val(addCommas(sumpackqty.toFixed(2)));
         }else{
            uni = uni.toFixed(2);
            $("#tbsritemdetail2temp-sritemorderqty").val(addCommas(jj.toFixed(2))); 
          }
            
        } else {
            $("#tbsritemdetail2temp-sritemorderqty").val('0.00');
        }
       
    });
        
        
         //On Save
$('#formdetail').on('beforeSubmit', function(e)
    {
      if($("#แพค").is(':checked')){
          if($('#tbsritemdetail2temp-srpackqty').val()< 1){
             swal("","กรุณาใส่จำนวนแพค", "warning");
              return false;
             }else{
     
run_waitMe(1);
         var \$form = $(this);
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
        
                $.pjax.reload({container:'#sr2_detail_'});
        waitMe_hide(1);
            } else
            {
                $("#message").html(result);
        waitMe_hide(1);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;  
             }
      }else if($("#ชิ้น").is(':checked')){
        if($('#tbsritemdetail2temp-sritemorderqty').val() < 1){
        swal("","กรุณาใส่จำนวนขอเบิก", "warning");
              return false;
         }else{
	 	run_waitMe(1);
             var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
    
          if (result == 1)
            {
                waitMe_hide(1);
                $(\$form).trigger("reset");
                $('#save_detail').modal('hide');
                $('#tpu_sr2_detail_list').modal('hide');
                swal("Save Complete!", "", "success");
                $.pjax.reload({container:'#sr2_detail_'});
            } else
            {
                $("#message").html(result);
                waitMe_hide(1);
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
<script>
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
