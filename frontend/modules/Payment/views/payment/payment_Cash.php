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
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'model_payment_Cash']); ?>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รวมยอดที่ต้องชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPaid, 'rep_Amt_net', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;;font-size: 30px;',
                        'value' => $modelPaid['rep_Amt_net'] == null ? '0.00' :  number_format($modelPaid['rep_Amt_net'],2),
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
                    <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 30px;" readonly="" name="Cash_item_sum_paid" id="Cash_item_sum_paid" value="<?php echo $modelPaid['rep_item_sum_paid'] == null ? '0.00' : number_format($modelPaid['rep_item_sum_paid'], 2); ?>">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div> 
            <div class="form-group" style="margin-top: 15px;">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ค้างชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 30px;" readonly="" name="Cash_Amt_left" id="Cash_Amt_left" value="<?php echo $modelPaid['rep_Amt_left'] === null ? number_format($modelPaid['rep_Amt_net'], 2) : number_format($modelPaid['rep_Amt_left'], 2); ?>">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รับชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'paid_cash', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;font-size: 30px;',
                        'value' => $modelPay['paid_cash'] == null || $modelPay['paid_cash'] == 0 ? '0.00' :  number_format($modelPay['paid_cash'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เงินทอน</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: #5db2ff;text-align:right;font-size: 30px;color: #fbfbfb;" readonly="" name="change" id="change" value="0.00"/>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
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
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="check_status_Cash" id="check_status_Cash" value="<?php echo $check_edit; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="payment_id" id="payment_id" value="<?php echo $payment_id; ?>">
            <br>
            <div class="form-group" style="text-align: right">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" id="Clear_Cash">Clear</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(document).ready(function(){
      var check_status_Cash = $('#check_status_Cash').val();
        if(check_status_Cash == 'edit'){
            var ready_paid_cash = parseFloat($('#tbfireppaymentdetail-paid_cash').val().replace(/[,]/g, ""));
            var ready_amt_left = parseFloat($('#vwitempaid-rep_amt_left').val().replace(/[,]/g, ""));
            var ready_sum_paid = parseFloat($('#vwitempaid-rep_item_sum_paid').val().replace(/[,]/g, ""));
            var after_amt_left = ready_paid_cash + ready_amt_left;
            var after_sum_paid = ready_sum_paid - ready_paid_cash;
            $("#Cash_Amt_left").val(addCommas(after_amt_left.toFixed(2)));
            $("#Cash_item_sum_paid").val(addCommas(after_sum_paid.toFixed(2)));
        }  
   });
    $('#Clear_Cash').click(function (e) { 
        alert('Wait_Sql_Query');     
     //window.open("www.waitreport.com"+$('#payment_id').val(),'_blank');     
    });      
    $("#tbfireppaymentdetail-paid_cash").keyup(function () {
        $('#tbfireppaymentdetail-paid_cash').autoNumeric('init');
        var check_status_Cash = $('#check_status_Cash').val();
        var amtnet = parseFloat($('#vwitempaid-rep_amt_net').val().replace(/[,]/g, ""));
        var sumpaid = parseFloat($('#vwitempaid-rep_item_sum_paid').val().replace(/[,]/g, ""));
        var paidcash = parseFloat($('#tbfireppaymentdetail-paid_cash').val().replace(/[,]/g, ""));
        var amtleft = (amtnet - sumpaid);
        var amtleft2 = parseFloat($('#Cash_Amt_left').val().replace(/[,]/g, ""));
        var sum = (paidcash - amtleft);
        var sum2 = (paidcash - amtleft2);
        if(check_status_Cash == 'create'){
            if(sum < 0){
                $('#change').val('0.00');
            }else{
                $('#change').val(addCommas(sum.toFixed(2)));
            }
        }else{
            if(sum2 < 0){
                $('#change').val('0.00');
            }else{
                $('#change').val(addCommas(sum2.toFixed(2)));
            }
        }
    });
     $('#model_payment_Cash').on('beforeSubmit', function(e){
    var \$form = $(this);
    var pay = $('#tbfireppaymentdetail-paid_cash').val();
    var change_pay = $('#change').val();
    swal({
    title: "ยืนยันคำสั่ง",
            text: "ชำระ " + pay + " บาท  เงินทอน " + change_pay + " บาท",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            confirmButtonText: "Confirm",
            closeOnConfirm: false
    }, function(){
    $.post(
            \$form.attr('action'), // serialize Yii2 form
            \$form.serialize()
            )
            .done(function(result){
            if (result != ''){
            $('#payment_Cash').modal('hide');
            //sweetalert(pay,change_pay);
            swal("", "Saved", "success");
            $.pjax.reload({container:'#pjax_footer'});
            console.log(result);
            } else{
            console.log('else');
            }
            })
            .fail(function(){
            console.log('Function Error!!');
            })
    });
    return false;
    });
        function sweet(){
            var pay = $('#tbfireppaymentdetail-paid_cash').val();
            var change_pay = $('#change').val();
            swal({   
                title: "",   
                text: "",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Confirm",   
                closeOnConfirm: false
            },function(){
                
            });
        }
        function sweetalert(pay,change_pay){
            swal("","ชำระ "+pay+" บาท  เงินทอน "+change_pay+" บาท","success");
        }
JS;
$this->registerJs($script);
?> 
<script>
   
</script>    