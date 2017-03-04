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
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => '_form_inv']); ?>
            
                <div class="form-group">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">ลำดับ</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'nhso_inv_id', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            'readonly' => true,
                            'style' => 'background-color:white;',
                            'value' => !empty($model['nhso_inv_id']) ? $model['nhso_inv_id'] : '',
                        ])
                        ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">หนังสือเรียกเก็บเลขที่</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'nhso_inv_num', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            //'readonly' => true,
                            'style' => 'background-color:#FFFF99;',
                            'value' => !empty($model['nhso_inv_num']) ? $model['nhso_inv_num'] : '',
                        ])
                        ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">หนังสือออกเลขที่</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'nhso_inv_hdoc', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            //'readonly' => true,
                            'style' => 'background-color:#FFFF99;',
                            'value' => !empty($model['nhso_inv_hdoc']) ? $model['nhso_inv_hdoc'] : '',
                        ])
                        ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">วันที่</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                            $form->field($model, 'nhso_inv_date', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
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
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">ประเภท</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'doc_type', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            'readonly' => true,
                            'style' => 'background-color:white;',
                            'value' => !empty($model['doc_type']) ? $model['doc_type'] : '',
                        ])
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">รพ.ต้นสังกัด</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'hmain', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;',
                                'value' => !empty($model['hmain']) ? $model->ar_name->ar_name : '',
                            ])
                            ?>
                        </div>
                    <label class="col-lg-2 col-md-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">เรียน</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'nhso_inv_attnname', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                //'readonly' => true,
                                'style' => 'background-color:#FFFF99;',
                                'value' => !empty($model['nhso_inv_attnname']) ? $model['nhso_inv_attnname'] : '',

                            ])
                            ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">กำหนดชำระ(วัน)</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'nhso_inv_crdays', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                //'readonly' => true,
                                'style' => 'background-color:#FFFF99;',
                                'value' => !empty($model['nhso_inv_crdays']) ? $model['nhso_inv_crdays'] : '30',
                            ])
                            ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">ยอดเรียกเก็บ</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'nhso_inv_cramt', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;',
                                'value' => !empty($model['nhso_inv_cramt']) ? number_format($model['nhso_inv_cramt'],2) : '0.00',
                            ])
                            ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">วิธีชำระเงิน</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 5px">
                            <label><input name="cash" id="cash" type="checkbox" /><span class="text"></span>&nbsp;เช็คเงินสด</label><br>
                            <label><input name="tranfer" id="tranfer" type="checkbox" /><span class="text"></span>&nbsp;โอนเงิน</label>
                            <?=
                            $form->field($model, 'nhso_inv_bank_id', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
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
                <input type="hidden" id="chk_cash" value="<?php echo $model->nhso_inv_cheqe ?>">
                <input type="hidden" id="chk_tranfer" value="<?php echo empty($model->nhso_inv_bank_id)|| $model->nhso_inv_bank_id=='0' ? '':$model->nhso_inv_bank_id ?>">  
                <div class="form-group" style="text-align: right">
                    <?= Html::a('Close','#',['class'=>'btn btn-default','data-dismiss'=>'modal']) ?>
                    <?= Html::a('Save','#',['class'=>'btn btn-success','onclick'=>"chk_empty(chk_bank,fn_save);"]) ?>
                    <?= Html::a('พิมพ์หนังสือเรียกเก็บ','#',['class'=>'btn btn-info','onclick'=>"fn_print_inv($nhso_inv_id);"]) ?>
                    <?= Html::a('พิมพ์เอกสารแนบ REP','#',['class'=>'btn btn-info','onclick'=>"fn_print_inv_rep($nhso_inv_id);"]) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<script> 
    $(document).ready(function(){
        
        var chk_cash = $('#chk_cash').val();
        if(chk_cash){
            document.getElementById("cash").checked = true;
            localStorage.checkbox_cash = 'checkbox_cash';
        }else{
            document.getElementById("cash").checked = false;
            localStorage.checkbox_cash = 'not_checkbox_cash';
        }
        var chk_tranfer = $('#chk_tranfer').val();
        if(chk_tranfer){
            document.getElementById("tranfer").checked = true;
            localStorage.checkbox_cash = 'checkbox_tranfer';
        }else{
            document.getElementById("tranfer").checked = false;
            $("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
            localStorage.checkbox_cash = 'not_checkbox_tranfer';
        }
        //$("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
    });
    $("input[id=cash]").click(function () {
        if ($(this).is(":checked"))
        {   
            // document.getElementById("tranfer").checked = false;
            // $("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
            localStorage.checkbox_cash = 'checkbox_cash';
            console.log('checkbox_cash');
        }else{
            // document.getElementById("tranfer").checked = true;
            // $("#tbfinhsoinv-nhso_inv_bank_id").removeAttr('disabled');
            localStorage.checkbox_cash = 'not_checkbox_cash';
            console.log('not_checkbox_cash');
        }
    });
    $("input[id=tranfer]").click(function () {
        if ($(this).is(":checked"))
        {   
            // document.getElementById("cash").checked = false;
            $("#tbfinhsoinv-nhso_inv_bank_id").removeAttr('disabled');
            localStorage.checkbox_tranfer = 'checkbox_tranfer';
            console.log('checkbox_tranfer');
        }else{
            //document.getElementById("cash").checked = true;
            $("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
            localStorage.checkbox_tranfer = 'not_checkbox_tranfer';
            console.log('not_checkbox_tranfer');
        }
    });
    function fn_save(){
            swal({   
            title: "",   
            text: "ยืนยันคำสั่ง?",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: true
            },function(){
                wait();
                $.ajax({
                  url: 'index.php?r=Payment/nhso-inv/save-inv',
                  type: 'POST',
                  data: $('#_form_inv').serialize(),
                  success: function (data) {
                    $('#_nhso_inv').waitMe('hide');
                    $('#form_inv').modal('hide');
                    location.reload();
                  },
                  error: function(data){
                   $('#_nhso_inv').waitMe('hide');
                  }  
                }); 
            });
    }
    function chk_bank(callback){
        var chk_tranfer = localStorage.checkbox_tranfer;
        if(chk_tranfer=="checkbox_tranfer"){
            var chk_back = $('#tbfinhsoinv-nhso_inv_bank_id').val();
            if(chk_back){
                callback();
            }else{
                swal('','กรุณากรอกข้อมูลธนาคารที่ต้องการโอน','warning');
            }
        }else{
            callback();
        }
    }
    function chk_empty(callback1,callback2){
        var chk_date = $('#tbfinhsoinv-nhso_inv_date').val();
        var chk_inv_num = $('#tbfinhsoinv-nhso_inv_num').val();
        var chk_inv_hdoc = $('#tbfinhsoinv-nhso_inv_hdoc').val();
        var chk_inv_crdays = $('#tbfinhsoinv-nhso_inv_crdays').val();
        var chk_inv_attnname = $('#tbfinhsoinv-nhso_inv_attnname').val();
        if(chk_date&&chk_inv_num&&chk_inv_hdoc&&chk_inv_crdays&&chk_inv_attnname){
            callback1(callback2);
        }else{
            swal('','กรุณากรอกข้อมูลให้ครบ','warning');
        }
    }
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_nhso_inv').waitMe({
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
</script>