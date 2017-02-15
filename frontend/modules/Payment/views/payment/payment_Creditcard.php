<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="well">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'model_payment_Creditcard']); ?>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รวมยอดที่ต้องชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPaid, 'rep_Amt_net', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;font-size: 30px;',
                        'value' => $modelPaid['rep_Amt_net'] == null ? '0.00' : number_format($modelPaid['rep_Amt_net'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ชำระแล้ว</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 30px;" readonly="" name="Creditcard_item_sum_paid" id="Creditcard_item_sum_paid" value="<?php echo $modelPaid['rep_item_sum_paid'] == null ? '0.00' : number_format($modelPaid['rep_item_sum_paid'], 2); ?>">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ค้างชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 30px;" readonly="" name="Creditcard_Amt_left" id="Creditcard_Amt_left" value="<?php echo $modelPaid['rep_Amt_left'] === null ? number_format($modelPaid['rep_Amt_net'], 2) : number_format($modelPaid['rep_Amt_left'], 2); ?>">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div> 
            <div class="form-group" style="margin-top: 15px;">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'paid_creditcard', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;font-size: 30px;',
                        'value' => $modelPay['paid_creditcard'] == null || $modelPay['paid_creditcard'] == 0 ? '0.00' : number_format($modelPay['paid_creditcard'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ประเภทบัตร</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'creditcard_type', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Payment\models\VwCreditcardType::find()->all(), 'creditcard_type_id', 'creditcard_type'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select Option'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เลขที่บัตร</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'creditcard_number', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99',
                        'value' => $modelPay['creditcard_number'] == null || $modelPay['creditcard_number'] == 0 ? '' : $modelPay['creditcard_number'],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ธนาคารผู้ออกบัตร</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'creditcard_issueby', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Payment\models\VwFiCreditcardname::find()->all(), 'bank_id', 'creditcard_issueby'),
                        'language' => 'en',
                        'options' => ['placeholder' => 'Select Option'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right">   <label><span class="text"></span><input type="checkbox" class="colored-success" name="other" id="other"  data-toggle="checkbox-x"><span class="text"> อื่นๆ</span></label>
                    <!-- <label style="color:#53a93f;"><input type="radio" name="other" id="other" value="yes" /><span class="text">&nbsp;อื่นๆ</span></label> -->
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: white;" readonly="" name="other_bank" id="other_bank" value="">
                </div>
            </div>
<!-- 
            <div class="form-group" style="margin-top: 15px;">
                <label class="col-lg-3 col-md-3 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">วันหมดอายุ</label>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-left: 13px">
                    <label for="select_month" style="color:#53a93f;">เดือน:</label>
                    <select name="month" id="month">
                        <?php /*foreach (range('1', '12') as $m) : ?>
                            <option value="<?php
                            if ($m < 10) {
                                echo '0' . $m;
                            } else {
                                echo $m;
                            }
                            ?>"<?php
                                    if (date('n') == $m) {
                                        echo 'selected="selected"';
                                    }
                                    ?>>
                                        <?php
                                        if ($m < 10) {
                                            echo '0' . $m;
                                        } else {
                                            echo $m;
                                        }
                                        ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <label for="select_year" style="color:#53a93f;">ปี:</label>
                    <select name="year" id="year">
                        <?php foreach (range('2016', '2021') as $y) : ?>
                            <option value="<?php echo $y; ?>" <?php
                            if (date('Y') == $y) {
                                echo 'selected="selected"';
                            }
                            ?>>
                                        <?php echo $y ?>
                            </option>
                        <?php endforeach; */?>
                    </select>
                </div>
            </div> -->
            <div class="form-group" style="margin-top: 15px;">
                <!-- <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รหัสอนุมัติ</label> -->
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'creditcard_approvedcode', ['showLabels' => false])->hiddenInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99',
                        'value' => $modelPay['creditcard_approvedcode'] == null || $modelPay['creditcard_approvedcode'] == 0 ? '' : $modelPay['creditcard_approvedcode'],
                    ])
                    ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <?=
                $form->field($modelPaid, 'rep_item_sum_paid', ['showLabels' => false])->hiddenInput([
                    'maxlength' => true,
                    'readonly' => true,
                    'style' => 'background-color:white;text-align: right;',
                    'value' => $modelPaid['rep_item_sum_paid'] == null ? '0.00' : number_format($modelPaid['rep_item_sum_paid'], 2),
                ])
                ?>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <?=
                $form->field($modelPaid, 'rep_Amt_left', ['showLabels' => false])->hiddenInput([
                    'maxlength' => true,
                    'readonly' => true,
                    'style' => 'background-color:white;text-align: right;',
                    'value' => $modelPaid['rep_Amt_left'] === null ? number_format($modelPaid['rep_Amt_net'], 2) : number_format($modelPaid['rep_Amt_left'], 2),
                ])
                ?>
            </div>
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="check_date" id="check_date" value="<?php echo $modelPay['creditcard_expdate']; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="payment_id" id="payment_id" value="<?php echo $payment_id; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="issueby" id="issueby" value="<?php echo $modelPay['creditcard_issueby']; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="check_status_Creditcard" id="check_status_Creditcard" value="<?php echo $check_edit; ?>">
            <br>
            <div class="form-group" style="text-align: right">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" id="Clear_Creditcard">Clear</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(document).ready(function(){
        var check_status_Creditcard = $('#check_status_Creditcard').val();
        if(check_status_Creditcard == 'edit'){
        var checkbanktype = $('#tbfireppaymentdetail-creditcard_issueby').val();issueby
        var issueby = $('#issueby').val();
        console.log(checkbanktype);
        if(checkbanktype == ''){
            //alert('null');
            document.getElementById("other").checked = true;
            $("#tbfireppaymentdetail-creditcard_issueby").attr('disabled', 'disabled');
            $("#other_bank").removeAttr('readonly');
            $('#other_bank').css('background-color', '#FFFF99');
            $('#other_bank').val(issueby);
            console.log('checkbox');
        }
        var expdate = $('#check_date').val();
        var arr = expdate.split('-'); 
        console.log(arr);
        var exp_year = arr[0];
        var exp_month = arr[1];
        $("#year").val(exp_year).trigger("change");
        $("#month").val(exp_month).trigger("change");
        console.log(exp_year);
        console.log(exp_month);
        var ready_paid_creditcard = parseFloat($('#tbfireppaymentdetail-paid_creditcard').val().replace(/[,]/g, ""));
        var ready_amt_left = parseFloat($('#vwitempaid-rep_amt_left').val().replace(/[,]/g, ""));
        var ready_sum_paid = parseFloat($('#vwitempaid-rep_item_sum_paid').val().replace(/[,]/g, ""));
        var after_amt_left = ready_paid_creditcard + ready_amt_left;
        var after_sum_paid = ready_sum_paid - ready_paid_creditcard;
        $("#Creditcard_Amt_left").val(addCommas(after_amt_left.toFixed(2)));
        $("#Creditcard_item_sum_paid").val(addCommas(after_sum_paid.toFixed(2)));
        }
    });
    $('#Clear_Creditcard').click(function (e) { 
        alert('Wait_Sql_Query');     
     //window.open("www.waitreport.com"+$('#payment_id').val(),'_blank');     
    });  
    $("#tbfireppaymentdetail-paid_creditcard").keyup(function () {
        $('#tbfireppaymentdetail-paid_creditcard').autoNumeric('init');
        var check_status_Creditcard = $('#check_status_Creditcard').val();
        var amtnet = parseFloat($('#vwitempaid-rep_amt_net').val().replace(/[,]/g, ""));
        var sumpaid = parseFloat($('#vwitempaid-rep_item_sum_paid').val().replace(/[,]/g, ""));
        var paidcreditcard = parseFloat($('#tbfireppaymentdetail-paid_creditcard').val().replace(/[,]/g, ""));
        var amtleft = (amtnet - sumpaid);
        var amtleft2 = parseFloat($('#Creditcard_Amt_left').val().replace(/[,]/g, ""));
        if(check_status_Creditcard =='create'){
            if(paidcreditcard>amtleft){
                swal("","ใส่เกินจำนวนค้างชำระ","warning");
                $('#tbfireppaymentdetail-paid_creditcard').val(addCommas(amtleft.toFixed(2)));;
            }
        }else{
            if(paidcreditcard>amtleft2){
                swal("","ใส่เกินจำนวนค้างชำระ","warning");
                $('#tbfireppaymentdetail-paid_creditcard').val(addCommas(amtleft2.toFixed(2)));;
            }
        }
    });
    $("input[id=other]").click(function () {
        if ($(this).is(":checked"))
        {   
            $("#tbfireppaymentdetail-creditcard_issueby").attr('disabled', 'disabled');
            $("#other_bank").removeAttr('readonly');
            $('#other_bank').css('background-color', '#FFFF99');
            console.log('checkbox');
        }else{
            $("#tbfireppaymentdetail-creditcard_issueby").removeAttr('disabled');
            $('#other_bank').val('');
            $("#other_bank").attr('readonly', 'readonly');
            $('#other_bank').css('background-color', 'white');
            console.log('not_checkbox');
        }
    });
        
    $('#model_payment_Creditcard').on('beforeSubmit', function(e){ 
            var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result){
            if(result != ''){
                $('#payment_Creditcard').modal('hide');
                $.pjax.reload({container:'#pjax_footer'});
                console.log(result);
            }else{
                console.log('else');
            }
            })
            .fail(function(){
            console.log('Function Error!!');
            })
            return false;
       
    });  
JS;
$this->registerJs($script);
?> 
<script>

</script>