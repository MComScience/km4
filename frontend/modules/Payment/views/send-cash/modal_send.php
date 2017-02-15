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
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'model_form_send']); ?>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">ยอดรวมเงินสด</label>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'sum_cash1', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;font-size: 18px;',
                        'value' => $modelSummary['sum_cash1'] == null ? '0.00' : $modelSummary['sum_cash1'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;color:#53a93f;">บาท</div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-md-offset-2 col-lg-5 col-md-5 col-sm-12 col-xs-12"><h5 class="row-title before-success">ธนาบัตร</h5></div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h5 class="row-title before-success">เหรียญ</h5></div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">1,000 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'banknote1000', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['banknote1000'] == null ? '0' : $modelSend['banknote1000'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_1000">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">10 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'coin10bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['coin10bt'] == null ? '0' : $modelSend['coin10bt'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_10bt">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">500 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'banknote500', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['banknote500'] == null ? '0' : $modelSend['banknote500'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_500">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">5 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'coin5bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['coin5bt'] == null ? '0' : $modelSend['coin5bt'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_5bt">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">100 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'banknote100', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['banknote100'] == null ? '0' : $modelSend['banknote100'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_100">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">2 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'coin2bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['coin2bt'] == null ? '0' : $modelSend['coin2bt'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_2bt">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">50 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'banknote50', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['banknote50'] == null ? '0' : $modelSend['banknote50'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_50">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">1 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'coin1bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['coin1bt'] == null ? '0' : $modelSend['coin1bt'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_1bt">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">20 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'banknote20', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['banknote20'] == null ? '0' : $modelSend['banknote20'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_20">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">50 สตางค์</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'coin50cn', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['coin50cn'] == null ? '0' : $modelSend['coin50cn'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_50cn">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">10 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'banknote10', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['banknote10'] == null ? '0' : $modelSend['banknote10'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_10">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">25 สตางค์</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSend, 'coin25cn', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        //'readonly' => true,
                        'style' => 'background-color:#FFFF99;text-align: right;',
                        'value' => $modelSend['coin25cn'] == null ? '0' : $modelSend['coin25cn'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_25cn">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">เป็นเงิน</label>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" style="background-color: white;text-align:right;font-size: 18px;" readonly="" name="summary_cash" id="summary_cash" value="0.00">
                </div><p id="icon_alert"></p>
            </div>
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="rep_summary_id" id="rep_summary_id" value="<?php echo $rep_summary_id; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="rep_summary_date" id="rep_summary_date" value="<?php echo $rep_summary_date; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="rep_summary_section" id="rep_summary_section" value="<?php echo $rep_summary_section; ?>">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="rep_summary_remark" id="rep_summary_remark" value="<?php echo $rep_summary_remark; ?>">
            <div class="form-group" style="text-align: right">
                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-danger" id="Clear">Clear</a>
                <button class="btn btn-success" type="submit">Save</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    $(document).ready(function(){    
         // document.getElementById("icon_alert").innerHTML = '<i class="glyphicon glyphicon-remove" style="color:#d73d32;font-size:25px;margin-top: 2px;"></i>';
       //document.getElementById("icon_alert").innerHTML = '<i class="fa fa-check" style="color:#53a93f;margin-top: 8px;"></i>';
    });    
    $("#tbfirepsummary-banknote1000").keyup(function () {
        //$('input[id="tbfirepsummary-banknote1000"]').priceFormat({prefix: ''});
        var banknote1000 = $('#tbfirepsummary-banknote1000').val();
        //console.log(banknote1000);
        var sum_1000 = banknote1000*1000;
        var result_1000 = addCommas(sum_1000.toFixed(2));
        document.getElementById("bank_1000").innerHTML = 'ใบ'+'&nbsp;=&nbsp;'+result_1000+'&nbsp;บาท';
        console.log(result_1000);
        calculate_summary();
    });
    $("#tbfirepsummary-banknote500").keyup(function () {
        //$('input[id="tbfirepsummary-banknote500"]').priceFormat({prefix: ''});
        var banknote500 = $('#tbfirepsummary-banknote500').val();
        //console.log(banknote500);
        var sum_500 = banknote500*500;
        var result_500 = addCommas(sum_500.toFixed(2));
        document.getElementById("bank_500").innerHTML = 'ใบ'+'&nbsp;=&nbsp;'+result_500+'&nbsp;บาท';
        console.log(result_500);
        calculate_summary();
    });
    $("#tbfirepsummary-banknote100").keyup(function () {
        //$('input[id="tbfirepsummary-banknote100"]').priceFormat({prefix: ''});
        var banknote100 = $('#tbfirepsummary-banknote100').val();
        //console.log(banknote100);
        var sum_100 = banknote100*100;
        var result_100 = addCommas(sum_100.toFixed(2));
        document.getElementById("bank_100").innerHTML = 'ใบ'+'&nbsp;=&nbsp;'+result_100+'&nbsp;บาท';
        console.log(result_100);
        calculate_summary();
    });
    $("#tbfirepsummary-banknote50").keyup(function () {
        //$('input[id="tbfirepsummary-banknote50"]').priceFormat({prefix: ''});
        var banknote50 = $('#tbfirepsummary-banknote50').val();
        //console.log(banknote50);
        var sum_50 = banknote50*50;
        var result_50 = addCommas(sum_50.toFixed(2));
        document.getElementById("bank_50").innerHTML = 'ใบ'+'&nbsp;=&nbsp;'+result_50+'&nbsp;บาท';
        console.log(result_50);
        calculate_summary();
    });
    $("#tbfirepsummary-banknote20").keyup(function () {
        //$('input[id="tbfirepsummary-banknote20"]').priceFormat({prefix: ''});
        var banknote20 = $('#tbfirepsummary-banknote20').val();
        //console.log(banknote20);
        var sum_20 = banknote20*20;
        var result_20 = addCommas(sum_20.toFixed(2));
        document.getElementById("bank_20").innerHTML = 'ใบ'+'&nbsp;=&nbsp;'+result_20+'&nbsp;บาท';
        console.log(result_20);
        calculate_summary();
    });
    $("#tbfirepsummary-banknote10").keyup(function () {
        //$('input[id="tbfirepsummary-banknote10"]').priceFormat({prefix: ''});
        var banknote10 = $('#tbfirepsummary-banknote10').val();
        //console.log(banknote10);
        var sum_10 = banknote10*10;
        var result_10 = addCommas(sum_10.toFixed(2));
        document.getElementById("bank_10").innerHTML = 'ใบ'+'&nbsp;=&nbsp;'+result_10+'&nbsp;บาท';
        console.log(result_10);
        calculate_summary();
    });
    $("#tbfirepsummary-coin10bt").keyup(function () {
        //$('input[id="tbfirepsummary-coin10bt"]').priceFormat({prefix: ''});
        var coin10bt = $('#tbfirepsummary-coin10bt').val();
        //console.log(coin10bt);
        var sum_10bt = coin10bt*10;
        var result_10bt = addCommas(sum_10bt.toFixed(2));
        document.getElementById("coin_10bt").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_10bt+'&nbsp;บาท';
        console.log(result_10bt);
        calculate_summary();
    });
    $("#tbfirepsummary-coin5bt").keyup(function () {
        //$('input[id="tbfirepsummary-coin5bt"]').priceFormat({prefix: ''});
        var coin5bt = $('#tbfirepsummary-coin5bt').val();
        //console.log(coin5bt);
        var sum_5bt = coin5bt*5;
        var result_5bt = addCommas(sum_5bt.toFixed(2));
        document.getElementById("coin_5bt").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_5bt+'&nbsp;บาท';
        console.log(result_5bt);
        calculate_summary();
    });
    $("#tbfirepsummary-coin2bt").keyup(function () {
        //$('input[id="tbfirepsummary-coin2bt"]').priceFormat({prefix: ''});
        var coin2bt = $('#tbfirepsummary-coin2bt').val();
        //console.log(coin2bt);
        var sum_2bt = coin2bt*2;
        var result_2bt = addCommas(sum_2bt.toFixed(2));
        document.getElementById("coin_2bt").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_2bt+'&nbsp;บาท';
        console.log(result_2bt);
        calculate_summary();
    });
    $("#tbfirepsummary-coin1bt").keyup(function () {
        //$('input[id="tbfirepsummary-coin1bt"]').priceFormat({prefix: ''});
        var coin1bt = $('#tbfirepsummary-coin1bt').val();
        //console.log(coin2bt);
        var sum_1bt = coin1bt*1;
        var result_1bt = addCommas(sum_1bt.toFixed(2));
        document.getElementById("coin_1bt").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_1bt+'&nbsp;บาท';
        console.log(result_1bt);
        calculate_summary();
    });
    $("#tbfirepsummary-coin50cn").keyup(function () {
        //$('input[id="tbfirepsummary-coin50cn"]').priceFormat({prefix: ''});
        var coin50cn = $('#tbfirepsummary-coin50cn').val();
        //console.log(coin50cn);
        var sum_50cn = coin50cn*0.50;
        var result_50cn = addCommas(sum_50cn.toFixed(2));
        document.getElementById("coin_50cn").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_50cn+'&nbsp;บาท';
        console.log(result_50cn);
        calculate_summary();
    });
    $("#tbfirepsummary-coin25cn").keyup(function () {
        //$('input[id="tbfirepsummary-coin25cn"]').priceFormat({prefix: ''});
        var coin25cn = $('#tbfirepsummary-coin25cn').val();
        //console.log(coin25cn);
        var sum_25cn = coin25cn*0.25;
        var result_25cn = addCommas(sum_25cn.toFixed(2));
        document.getElementById("coin_25cn").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_25cn+'&nbsp;บาท';
        console.log(result_25cn);
        calculate_summary();
    });
    function calculate_summary(){
        var banknote_1000 = $('#tbfirepsummary-banknote1000').val();
        var banknote_500 = $('#tbfirepsummary-banknote500').val();
        var banknote_100 = $('#tbfirepsummary-banknote100').val();
        var banknote_50 = $('#tbfirepsummary-banknote50').val();
        var banknote_20 = $('#tbfirepsummary-banknote20').val();
        var banknote_10 = $('#tbfirepsummary-banknote10').val();
        var coin_10baht = $('#tbfirepsummary-coin10bt').val();
        var coin_5baht = $('#tbfirepsummary-coin5bt').val();
        var coin_2baht = $('#tbfirepsummary-coin2bt').val();
        var coin_1baht = $('#tbfirepsummary-coin1bt').val();
        var coin_0_50baht = $('#tbfirepsummary-coin50cn').val();
        var coin_0_25baht = $('#tbfirepsummary-coin25cn').val();
        var sum_banknote_1000 = banknote_1000*1000;
        var sum_banknote_500 = banknote_500*500;
        var sum_banknote_100 = banknote_100*100;
        var sum_banknote_50 = banknote_50*50;
        var sum_banknote_20 = banknote_20*20;
        var sum_banknote_10 = banknote_10*10;
        var sum_coin_10baht = coin_10baht*10;
        var sum_coin_5baht = coin_5baht*5;
        var sum_coin_2baht = coin_2baht*2;
        var sum_coin_1baht = coin_1baht*1;
        var sum_coin_0_50baht = coin_0_50baht*0.50;
        var sum_coin_0_25baht = coin_0_25baht*0.25;
        var summary_cash = sum_banknote_1000+sum_banknote_500+sum_banknote_100+sum_banknote_50+sum_banknote_20+sum_banknote_10+sum_coin_10baht+sum_coin_5baht+sum_coin_2baht+sum_coin_1baht+sum_coin_0_50baht+sum_coin_0_25baht;
        $('#summary_cash').val(addCommas(summary_cash.toFixed(2)));
        var sum_cash1 = parseFloat($('#vwfireplistsumcash-sum_cash1').val().replace(/[,]/g, ""));
        if(summary_cash == sum_cash1){
            document.getElementById("icon_alert").innerHTML = '<i class="glyphicon glyphicon-ok" style="color:#53a93f;font-size:25px;margin-top: 2px;"></i>';
        }else{
             document.getElementById("icon_alert").innerHTML = '<i class="glyphicon glyphicon-remove" style="color:#d73d32;font-size:25px;margin-top: 2px;"></i>';
        }
    }
    $('#model_form_send').on('beforeSubmit', function(e){
                var \$form = $(this);
                var sum_cash1 = parseFloat($('#vwfireplistsumcash-sum_cash1').val().replace(/[,]/g, ""));
                console.log(sum_cash1);
                var summary_cash = parseFloat($('#summary_cash').val().replace(/[,]/g, ""));
                 console.log(summary_cash);
                if(summary_cash>sum_cash1){
                	var btn_confirm = false;
                    var summary_cash_over = summary_cash-sum_cash1;
                    var result_over = addCommas(summary_cash_over.toFixed(2))
                    var title = "ใส่เงินเกินจำนวน?";
                    var text = "จำนวนเงินที่นำส่งเกิน "+result_over+" บาท";
                    var btn_cancel = "OK";
                    swal (title,text,"warning");
                }else if (summary_cash<sum_cash1){
                	var btn_confirm = false;
                    var summary_cash_deficient = sum_cash1-summary_cash;
                    var result_deficient = addCommas(summary_cash_deficient.toFixed(2))
                    var title = "จำนวนเงินไม่ครบ?";
                    var text = "จำนวนเงินนำส่งไม่ครบ "+result_deficient+" บาท";
                    var btn_cancel = "OK";
                    swal (title,text,"warning");
                }else{
                	var btn_confirm = true;
                    var title = "ยืนยันคำสั่ง?";
                    var text = "ต้องการที่จะบันทึกข้อมูลใช่หรือไม่";
                    var btn_cancel = "Cancel";
                    swal({  
                               title: title,   
                               text: text,   
                               type: "warning",   
                               showCancelButton: true,
                               showConfirmButton : btn_confirm,
                               confirmButtonColor: "#53a93f",   
                               confirmButtonText: "Confirm",
                               cancelButtonText : btn_cancel,
                               closeOnConfirm: false
                    },function(){
                        $.post(
                                \$form.attr('action'), // serialize Yii2 form
                                \$form.serialize()
                                )
                        .done(function(result){
                        if(result != ''){
                            $('#form_send').modal('hide');
                            //setTimeout(print_report(result), 8000);
                            print_report(result);
                            console.log(result);
                        }else{
                            console.log('else');
                        }
                        })
                        .fail(function(){
                        console.log('Function Error!!');
                        })
                        
                    });
                        // swal({  
		                //        title: title,   
		                //        text: text,   
		                //        type: "warning",   
		                //        showCancelButton: true,
		                //        showConfirmButton : btn_confirm,
		                //        confirmButtonColor: "#53a93f",   
		                //        confirmButtonText: "Confirm",
		                //        cancelButtonText : btn_cancel,
		                //        closeOnConfirm: false
		                // },function(){
		                // $.post(
		                //         \$form.attr('action'), // serialize Yii2 form
		                //         \$form.serialize()
		                //         )
		                // .done(function(result){
		                // if(result != ''){
		                //     $('#form_send').modal('hide');
		                //     swal("","Saved","success");
		                //     $.pjax.reload({container:'#pjax_PSC'});
		                //     console.log(result);
		                // }else{
		                //     console.log('else');
		                // }
		                // })
		                // .fail(function(){
		                // console.log('Function Error!!');
		                // })
		                // });
                }
               
                return false;
            
        });
        function print_report(result){
            var result = result;
            swal({  
                title:"",   
                text: "ต้องการปริ้นใช่หรือไม่?",   
                type: "warning",   
                showCancelButton: true,
                showConfirmButton : true,
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Print",
                cancelButtonText : "Cancel",
                closeOnConfirm: true,   
                closeOnCancel: true
                },
                function(isConfirm){   
                	if (isConfirm) {
                		window.open("http://www.udcancer.org/km4d/frontend/web/index.php?r=Payment/send-cash/summary&id="+result,'_blank');     
                		$.pjax.reload({container:'#pjax_PSC'});   
                	} else {     
                		 $.pjax.reload({container:'#pjax_PSC'}); 
                	} 
                });
        }     
        
JS;
$this->registerJs($script);
?>        