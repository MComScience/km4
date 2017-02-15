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
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'model_payment_Discount']); ?>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รายการ</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelDiscount, 'ItemDetail', ['showLabels' => false])->textarea([
                        'readonly' => true,
                        'rows' => 3,
                        'style' => 'background-color:white;text-align: left;',
                        'value' => $modelDiscount['ItemDetail'] == null ? '' : $modelDiscount['ItemDetail'],
                    ])
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เบิกไม่ได้</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelDiscount, 'Item_PayAmt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;font-size: 30px;',
                        'value' => $modelDiscount['Item_PayAmt'] == null ? '0.00' : number_format($modelDiscount['Item_PayAmt'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div> 
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ส่วนลด</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelDiscount, 'Item_Discount', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;font-size: 30px;',
                        'value' => $modelDiscount['Item_Discount'] == null ? '0.00' : number_format($modelDiscount['Item_Discount'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เป็นเงิน</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelDiscount, 'Item_Amt_Net', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:#5db2ff;text-align: right;font-size: 30px;color: #Fff;',
                        'value' => $modelDiscount['Item_Amt_Net']  == null ? '0.00' : number_format($modelDiscount['Item_Amt_Net'],2),
                    ])
                    ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>
<!--            <div class="form-group">
                <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เงินทอน</label>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: white;text-align:right" readonly="" name="change" id="change" value="0.00"/>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                    <label class="control-label no-padding-left">บาท</label>
                </div>
            </div>-->
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="ids_rep" id="ids_rep" value="<?php echo $ids_rep; ?>">
            <br>
            <div class="form-group" style="text-align: right">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" id="Clear_Discount">Clear</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $("#vwfirepdetail-item_discount").keyup(function () {
       $('#vwfirepdetail-item_discount').autoNumeric('init');
       var item_payamt = parseFloat($('#vwfirepdetail-item_payamt').val().replace(/[,]/g, ""));
       var item_discount = parseFloat($('#vwfirepdetail-item_discount').val().replace(/[,]/g, ""));
       if(item_discount > item_payamt){
            swal("","ยอดส่วนลดเกินยอดเบิกไม่ได้","warning");
            $('#vwfirepdetail-item_discount').val(addCommas(item_payamt.toFixed(2)));
       }
    });
    $('#Clear_Discount').click(function (e) { 
        alert('Wait_Sql_Query');     
     //window.open("www.waitreport.com"+$('#ids_rep').val(),'_blank');     
    });
    $('#model_payment_Discount').on('beforeSubmit', function(e){ 
           var \$form = $(this);
           $.post(
                   \$form.attr('action'), // serialize Yii2 form
                   \$form.serialize()
                   )
           .done(function(result){
           console.log(result);
           if(result == 'GO'){
               $('#form_discount').modal('hide');
               $.pjax.reload({container:'#pjax_body'});
           }else{
               swal("","ยอดส่วนลดเกินยอดเบิกไม่ได้","warning");
               console.log('false!!');
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