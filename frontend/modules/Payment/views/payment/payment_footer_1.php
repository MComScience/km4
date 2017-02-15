<?php

use yii\helpers\Html;
?>
<div class="tabbable">
    <div class="tab-content tabs-flat">
        <div id="body_payment" class="tab-pane active">
            <?php \yii\widgets\Pjax::begin([ 'id' => 'pjax_footer','timeout' => 5000 ]) ?>
            <div class="row profile-overview">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group" >
                        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">วิธีการชำระเงิน</label>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">เงินสด</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_piad_cash', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_piad_cash']==null? '0.00':$modelPaid['rep_piad_cash'],
                            ])
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                            <a class="btn btn-success btn-sm" id="Cash" style="margin-top: 5px;margin-left: 20px">ชำระ</a>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รวมเป็นเงิน</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_Amt_total', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_Amt_total']==null? '0.00':$modelPaid['rep_Amt_total'],
                            ])
                            ?>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;"></label>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">บัตรเครดิต</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_piad_creditcard', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_piad_creditcard']==null? '0.00':$modelPaid['rep_piad_creditcard'],
                            ])
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                            <a class="btn btn-success btn-sm" id="Creditcard" style="margin-top: 5px;margin-left: 20px">ชำระ</a>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ส่วนลด</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_Amt_discount', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_Amt_discount']==null? '0.00':$modelPaid['rep_Amt_discount'],
                            ])
                            ?>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;"></label>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">โอนเงินธนาคาร</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_piad_banktransfer', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_piad_banktransfer']==null? '0.00':$modelPaid['rep_piad_banktransfer'],
                                
                            ])
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                            <a class="btn btn-success btn-sm" id="Banktrans" style="margin-top: 5px;margin-left: 20px">ชำระ</a>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">รวมยอดที่ต้องชำระ</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_Amt_net', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_Amt_net']==null? '0.00':$modelPaid['rep_Amt_net'],
                            ])
                            ?>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;"></label>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">เช็คธนาคาร</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_piad_cheque', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_piad_cheque']==null? '0.00':number_format($modelPaid['rep_piad_cheque'],2),
                            ])
                            ?>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                            <a class="btn btn-success btn-sm" id="Cheque" style="margin-top: 5px;margin-left: 20px">ชำระ</a>
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ชำระแล้ว</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_item_sum_paid', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_item_sum_paid']==null? '0.00':number_format($modelPaid['rep_item_sum_paid'],2),
                            ])
                            ?>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        </div>
                        <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ค้างชำระ</label>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_Amt_left', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;text-align: right;',
                                'value' => $modelPaid['rep_Amt_left']==null? '0.00':number_format($modelPaid['rep_Amt_left'],2),
                            ])
                            ?>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <label class="control-label no-padding-left">บาท</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">หมายเหตุ : </label>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelHD, 'rep_comment', ['showLabels' => false])->textarea([
                                'rows' => 3,
                                'style' => 'background-color:#FFFF99',
                            ])
                            ?>
                        </div>
                    </div>
                     <div class="form-group">
                         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($modelPaid, 'rep_id', ['showLabels' => false])->hiddenInput([
                                'readonly' => true,
                                'style' => 'background-color:white',
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:30px;text-align: right">
                        <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                        <?= Html::button('Clear', ['class' => 'btn btn-danger', 'id' => 'Clear']) ?>
                        <button class="btn btn-success" type="submit">Draft</button>
                        <?= Html::button('Save', ['class' => 'btn btn-info', 'id' => 'Save']) ?>
                        <?= Html::button('Print', ['class' => 'btn btn-info', 'id' => 'Print']) ?>
                    </div>    
                </div>
            </div>
            <?php \yii\widgets\Pjax::end() ?>
        </div>
    </div>
</div>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'payment_Cash',
    'header' => '<h4 class="modal-title">ชำระเงินสด</h4>',
    'size' => 'modal-md modal-primary',
]);
?>
<div id="data_Cash">
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
<?php \yii\bootstrap\Modal::end(); ?>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'payment_Creditcard',
    'header' => '<h4 class="modal-title">ชำระบัตรเครดิต</h4>',
    'size' => 'modal-md modal-primary',
]);
?>
<div id="data_Creditcard">
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
<?php \yii\bootstrap\Modal::end(); ?>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'payment_Banktrans',
    'header' => '<h4 class="modal-title">ชำระโดยเข้าบัญชีธนาคาร</h4>',
    'size' => 'modal-md modal-primary',
]);
?>
<div id="data_Banktrans">
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
<?php \yii\bootstrap\Modal::end(); ?>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'payment_Cheque',
    'header' => '<h4 class="modal-title">ชำระโดยเช็คธนาคาร</h4>',
    'size' => 'modal-md modal-primary',
]);
?>
<div id="data_Cheque">
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
<?php \yii\bootstrap\Modal::end(); ?>
<?php
$script = <<< JS
function init_click_handlers() {
    $('#Cash').click(function (e) {
        console.log('Cash');
        wait();
        var cash = $('#vwitempaid-rep_piad_cash').val();
        console.log(cash);
        if(cash != '0.00'){
            var check_edit = 'edit';
        }else{
            var check_edit = 'create';
        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        wait();
        $.get(
                'cash',
                {
                    rep_id,check_edit
                },
                function (data)
                {   
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Cash').find('.modal-body').html(data);
                    $('#data_Cash').html(data);
                    $('#payment_Cash').modal('show');
                }
        );
    });
    $('#Creditcard').click(function (e) {
        console.log('Creditcard');
        wait();
        var creditcard = $('#vwitempaid-rep_piad_creditcard').val();
        if(creditcard != '0.00'){
            var check_edit = 'edit';
        }else{
            var check_edit = 'create';
        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        $.get(
                'creditcard',
                {
                    rep_id,check_edit
                },
                function (data)
                {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Creditcard').find('.modal-body').html(data);
                    $('#data_Creditcard').html(data);
                    $('#payment_Creditcard').modal('show');
                }
        );
    });
$('#Banktrans').click(function (e) {
        console.log('Banktrans');
        wait();
        var banktransfer = $('#vwitempaid-rep_piad_banktransfer').val();
        if(banktransfer != '0.00'){
            var check_edit = 'edit';
        }else{
            var check_edit = 'create';
        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        $.get(
                'banktrans',
                {
                   rep_id,check_edit
                },
                function (data)
                {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Banktrans').find('.modal-body').html(data);
                    $('#data_Banktrans').html(data);
                    $('#payment_Banktrans').modal('show');
                }
        );
});
$('#Cheque').click(function (e) {
        wait();
        var cheque = $('#vwitempaid-rep_piad_cheque').val();
        if(cheque != '0.00'){
            var check_edit = 'edit';
        }else{
            var check_edit = 'create';
        }
        var rep_id = $('#vwitempaid-rep_id').val();
        console.log(rep_id);
        $.get(
                'cheque',
                {
                    rep_id,check_edit
                },
                function (data)
                {
                    $('#_form_payment').waitMe('hide');
                    $('#payment_Cheque').find('.modal-body').html(data);
                    $('#data_Cheque').html(data);
                    $('#payment_Cheque').modal('show');
                }
        );
});
}
    init_click_handlers(); //first run
    $('#pjax_footer').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_form_payment').waitMe({
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
    $('#form_payment').on('beforeSubmit', function(e){ 
            var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result){
            if(result != ''){
                $('#vwfirepheader-rep_num').val(result);
                console.log(result);
                swal("","Draft","success");
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