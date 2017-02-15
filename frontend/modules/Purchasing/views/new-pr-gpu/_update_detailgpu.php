<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;

?>
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetailgpu']);
?>
<div class="well">
    <div class="row">
        <div class="col-xs-6">
            <input class="form-control " id="cmd"  name="cmd" type="hidden"/>
            <div class="form-group">
                <?= Html::activeLabel($modeledit, 'TMTID_GPU', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'TMTID_GPU', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white'
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
                        'value' => $ItemName,
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
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-8">

                    <?=
                    $form->field($modeledit, 'ItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(\app\models\TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                        'language' => 'en',
                        'pluginOptions' => [
                            'placeholder' => 'Select Option',
                            'allowClear' => true,
                        //'disabled' => true
                        ],
                    ])
                    ?>
                    <div id="notpack"><?php echo $btn ?></div>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/ต่อแพค</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                           value="<?php
                           if ($modeledit->ItemPackSKUQty == null) {
                               echo '0.00';
                           } else {
                               echo number_format($modeledit->ItemPackSKUQty,2);
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

            <div class="form-group" >
                <?= Html::activeLabel($modeledit, 'DispUnit', ['class' => 'col-sm-4 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?=
                    $form->field($modeledit, 'DispUnit', ['showLabels' => false])->textInput([
                        'readonly' => true,
                        'style' => 'background-color: white;text-align:right',
                        'value' => $DispUnit
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
        <input type="hidden" id="vwpritemdetail2temp-ids_pr_selected" name="VwPritemdetail2Temp[ids_PR_selected]" value="<?php echo $modeledit['ids_PR_selected']; ?>"/>
        <input type="hidden" id="vwpritemdetail2temp-prid" name="VwPritemdetail2Temp[PRID]" value="<?php echo $modeledit['PRID']; ?>"/>
        <input type="hidden" id="vvwpritemdetail2temp-ids" name="VwPritemdetail2Temp[ids]" value="<?php echo $modeledit['ids']; ?>"/>
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
        $('#ราคาซื้อครั้งล่าสุด').html('<font color="red">*</font>');
        //คำนวณ on chang หน่วยแพค
        $('#vwpritemdetail2temp-itempackid').on('change', function () {
            var TMTID_GPU = $("#vwpritemdetail2temp-tmtid_gpu").val();
            var ItemPackUnit = $(this).find("option:selected").val();
            var qty = parseFloat($("#vwpritemdetail2temp-prpackqty").val().replace(/[,]/g, ""));
            var PRUnitCost = parseFloat($("#vwpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));
            $.ajax({
                url: "index.php?r=Purchasing/new-pr-gpu/get-qtygpu",
                type: "post",
                data: {TMTID_GPU: TMTID_GPU, ItemPackUnit: ItemPackUnit, qty: qty},
                dataType: 'json',
                success: function (data) {
                    $('#ItemPackSKUQty').val(data.ItemPackSKUQty);
                    var SKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
                    var jj = (SKUQty) * (qty);
                    var Total = jj * PRUnitCost;
                    if (data.qty == 0) {
                        $('#vwpritemdetail2temp-prorderqty').val();
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
                        url: 'index.php?r=Purchasing/new-pr-gpu/getdata-pcplangpu',
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
    $("#vwpritemdetail2temp-prlastunitcost").keyup(function () {
        $('input[id="vwpritemdetail2temp-prlastunitcost"]').priceFormat({prefix: ''});
        
    });
    //On Save
    $('#formdetailgpu').on('beforeSubmit', function(e)
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
                    $.pjax.reload({container:'#gpu_detail_id'});
                    $('#gpu-modal').modal('hide');
                    $('#getdatagpumodal').modal('hide');
                    $('#formdetailgpu').trigger("reset");
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
        var checkd2 = $('#vwpritemdetail2temp-itempackunit').val();
        $("#vwpritemdetail2temp-itempackid").val(checkd2).trigger("change");
        
        var checkd1 = $('#vwpritemdetail2temp-prpackqty').val();    
            if (checkd1 == '' ||checkd1 == '0.00'){
        document.getElementById("ชิ้น").checked = true;
        }else{
              document.getElementById("แพค").checked = true;         
        } 
      
        if ($("input[id=ชิ้น]").is(":checked"))
        {
             $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").attr('readonly', 'readonly');
             $("#vwpritemdetail2temp-itempackid").attr('readonly', 'readonly');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").removeAttr('readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', 'white');
        }else{
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").removeAttr('readonly');
             $("#vwpritemdetail2temp-itempackid").removeAttr('disabled');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").attr('readonly', 'readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
             $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', 'white');
            }
    //});
        
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").removeAttr('readonly');
             $("#vwpritemdetail2temp-itempackid").removeAttr('disabled');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").attr('readonly', 'readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
             $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', 'white');
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
            $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
             $("#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost").attr('readonly', 'readonly');
             $("#vwpritemdetail2temp-itempackid").attr('readonly', 'readonly');
             $("#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost").removeAttr('readonly');
             $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
             $('#vwpritemdetail2temp-prorderqty,#vwpritemdetail2temp-prunitcost').css('background-color', '#FFFF99');
             $('#vwpritemdetail2temp-prpackqty,#vwpritemdetail2temp-itempackcost').css('background-color', 'white');
        }
    });
});
JS;
$this->registerJs($script);
?>

