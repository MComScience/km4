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
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'model_payment_Banktrans']); ?>
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
                    <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 30px;" readonly="" name="Banktransfer_item_sum_paid" id="Banktransfer_item_sum_paid" value="<?php echo $modelPaid['rep_item_sum_paid'] == null ? '0.00' : number_format($modelPaid['rep_item_sum_paid'], 2); ?>">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group" style="margin-top:15px;">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ค้างชำระ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                     <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 30px;" readonly="" name="Banktransfer_Amt_left" id="Banktransfer_Amt_left" value="<?php echo $modelPaid['rep_Amt_left'] === null ? number_format($modelPaid['rep_Amt_net'], 2) : number_format($modelPaid['rep_Amt_left'], 2); ?>">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div> 
            <div class="form-group" style="margin-top:15px;">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">จำนวนเงิน</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'piad_banktransfer', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;font-size: 30px;',
                        'value' => $modelPay['piad_banktransfer'] == null || $modelPay['piad_banktransfer'] == 0 ? '0.00' :  number_format($modelPay['piad_banktransfer'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ธนาคาร</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'piad_banktransfer_bankname', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Payment\models\VwFiBankname::find()->all(), 'bank_id', 'Bankname'),
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

                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เลขที่บัญชี</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'bankaccount_number', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99',
                        'value' => $modelPay['bankaccount_number'] == null || $modelPay['bankaccount_number'] == 0 ? '' : $modelPay['bankaccount_number'],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">วันที่</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelPay, 'paid_banktransfer_date', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'style' => 'background-color: #FFFF99',
                        ],
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
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="check_status_Bank" id="check_status_Bank" value="<?php echo $check_edit; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="payment_id" id="payment_id" value="<?php echo $payment_id; ?>">
            <br>
            <div class="form-group" style="text-align: right">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" id="Clear_Banktrans">Clear</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
   $(document).ready(function(){
      var check_status_Bank = $('#check_status_Bank').val();
        if(check_status_Bank == 'edit'){
            var ready_paid_banktransfer = parseFloat($('#tbfireppaymentdetail-piad_banktransfer').val().replace(/[,]/g, ""));
            var ready_amt_left = parseFloat($('#vwitempaid-rep_amt_left').val().replace(/[,]/g, ""));
            var ready_sum_paid = parseFloat($('#vwitempaid-rep_item_sum_paid').val().replace(/[,]/g, ""));
            var after_amt_left = ready_paid_banktransfer + ready_amt_left;
            var after_sum_paid = ready_sum_paid - ready_paid_banktransfer;
            $("#Banktransfer_Amt_left").val(addCommas(after_amt_left.toFixed(2)));
            $("#Banktransfer_item_sum_paid").val(addCommas(after_sum_paid.toFixed(2)));
        }  
   });
   $('#Clear_Banktrans').click(function (e) { 
        alert('Wait_Sql_Query');     
     //window.open("www.waitreport.com"+$('#payment_id').val(),'_blank');     
    });   
   $("#tbfireppaymentdetail-piad_banktransfer").keyup(function () {
        $('#tbfireppaymentdetail-piad_banktransfer').autoNumeric('init');
        var check_status_Bank = $('#check_status_Bank').val();
        var amtnet = parseFloat($('#vwitempaid-rep_amt_net').val().replace(/[,]/g, ""));
        var sumpaid = parseFloat($('#vwitempaid-rep_item_sum_paid').val().replace(/[,]/g, ""));
        var piadbanktransfer = parseFloat($('#tbfireppaymentdetail-piad_banktransfer').val().replace(/[,]/g, ""));
        var amtleft = (amtnet - sumpaid);
        var amtleft2 = parseFloat($('#Banktransfer_Amt_left').val().replace(/[,]/g, ""));
        if(check_status_Bank == 'create'){
            if(piadbanktransfer > amtleft){
                swal("","ใส่เกินจำนวนค้างชำระ","warning");
                $('#tbfireppaymentdetail-piad_banktransfer').val(addCommas(amtleft.toFixed(2)));;
            }
        }else{
            if(piadbanktransfer > amtleft2){
                swal("","ใส่เกินจำนวนค้างชำระ","warning");
                $('#tbfireppaymentdetail-piad_banktransfer').val(addCommas(amtleft2.toFixed(2)));;
            }
        }
    });    
    $('#model_payment_Banktrans').on('beforeSubmit', function(e){ 
            var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result){
            if(result != ''){
                $('#payment_Banktrans').modal('hide');
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