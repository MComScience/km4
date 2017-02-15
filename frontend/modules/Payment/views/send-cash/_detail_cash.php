<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'detail_summary']); ?>
                <div class="form-group">
                <div class="col-lg-offset-2 col-md-offset-2 col-lg-5 col-md-5 col-sm-12 col-xs-12"><h5 class="row-title before-success">ธนาบัตร</h5></div>
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12"><h5 class="row-title before-success">เหรียญ</h5></div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">1,000 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'banknote1000', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['banknote1000'] == null ? '0' : $modelSummary['banknote1000'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_1000">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">10 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'coin10bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['coin10bt'] == null ? '0' : $modelSummary['coin10bt'],
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
                    $form->field($modelSummary, 'banknote500', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['banknote500'] == null ? '0' : $modelSummary['banknote500'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_500">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">5 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'coin5bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['coin5bt'] == null ? '0' : $modelSummary['coin5bt'],
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
                    $form->field($modelSummary, 'banknote100', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['banknote100'] == null ? '0' : $modelSummary['banknote100'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_100">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">2 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'coin2bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['coin2bt'] == null ? '0' : $modelSummary['coin2bt'],
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
                    $form->field($modelSummary, 'banknote50', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['banknote50'] == null ? '0' : $modelSummary['banknote50'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_50">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">1 บาท</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'coin1bt', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['coin1bt'] == null ? '0' : $modelSummary['coin1bt'],
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
                    $form->field($modelSummary, 'banknote20', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['banknote20'] == null ? '0' : $modelSummary['banknote20'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_20">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">50 สตางค์</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'coin50cn', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['coin50cn'] == null ? '0' : $modelSummary['coin50cn'],
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
                    $form->field($modelSummary, 'banknote10', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['banknote10'] == null ? '0' : $modelSummary['banknote10'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="bank_10">ใบ = 0.00 บาท</p>
                </div>
                <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right" style="color:#53a93f;">25 สตางค์</label>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <?=
                    $form->field($modelSummary, 'coin25cn', ['showLabels' => false])->textInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white;text-align: right;',
                        'value' => $modelSummary['coin25cn'] == null ? '0' : $modelSummary['coin25cn'],
                    ])
                    ?>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px;font-size:18px;">
                    <p id="coin_25cn">เหรียญ = 0.00 บาท</p>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
<?php
$script = <<< JS
    $(document).ready(function(){
    //-------------------banknote1000----------------------------- 
    var banknote1000 = $('#vwfirepsummary-banknote1000').val();
    var sum_1000 = banknote1000 * 1000;
    var result_1000 = addCommas(sum_1000.toFixed(2));
    document.getElementById("bank_1000").innerHTML = 'ใบ' + '&nbsp;=&nbsp;' + result_1000 + '&nbsp;บาท';
    //-------------------banknote500-----------------------------  
    var banknote500 = $('#vwfirepsummary-banknote500').val();
    var sum_500 = banknote500 * 500;
    var result_500 = addCommas(sum_500.toFixed(2));
    document.getElementById("bank_500").innerHTML = 'ใบ' + '&nbsp;=&nbsp;' + result_500 + '&nbsp;บาท';
    //-------------------banknote100-----------------------------
    var banknote100 = $('#vwfirepsummary-banknote100').val();
    var sum_100 = banknote100 * 100;
    var result_100 = addCommas(sum_100.toFixed(2));
    document.getElementById("bank_100").innerHTML = 'ใบ' + '&nbsp;=&nbsp;' + result_100 + '&nbsp;บาท';
    //-------------------banknote50-----------------------------
    var banknote50 = $('#vwfirepsummary-banknote50').val();
    var sum_50 = banknote50 * 50;
    var result_50 = addCommas(sum_50.toFixed(2));
    document.getElementById("bank_50").innerHTML = 'ใบ' + '&nbsp;=&nbsp;' + result_50 + '&nbsp;บาท';
    //-------------------banknote20-----------------------------
    var banknote20 = $('#vwfirepsummary-banknote20').val();
    var sum_20 = banknote20 * 20;
    var result_20 = addCommas(sum_20.toFixed(2));
    document.getElementById("bank_20").innerHTML = 'ใบ' + '&nbsp;=&nbsp;' + result_20 + '&nbsp;บาท';
    //-------------------banknote10-----------------------------
    var banknote10 = $('#vwfirepsummary-banknote10').val();
    var sum_10 = banknote10 * 10;
    var result_10 = addCommas(sum_10.toFixed(2));
    document.getElementById("bank_10").innerHTML = 'ใบ' + '&nbsp;=&nbsp;' + result_10 + '&nbsp;บาท';
    //-------------------coin10bt-----------------------------
    var coin10bt = $('#vwfirepsummary-coin10bt').val();
    var sum_10bt = coin10bt * 10;
    var result_10bt = addCommas(sum_10bt.toFixed(2));
    document.getElementById("coin_10bt").innerHTML = 'เหรียญ' + '&nbsp;=&nbsp;' + result_10bt + '&nbsp;บาท';
    //-------------------coin5bt-----------------------------
    var coin5bt = $('#vwfirepsummary-coin5bt').val();
    var sum_5bt = coin5bt * 5;
    var result_5bt = addCommas(sum_5bt.toFixed(2));
    document.getElementById("coin_5bt").innerHTML = 'เหรียญ' + '&nbsp;=&nbsp;' + result_5bt + '&nbsp;บาท';
    //-------------------coin2bt-----------------------------
    var coin2bt = $('#vwfirepsummary-coin2bt').val();
    var sum_2bt = coin2bt * 2;
    var result_2bt = addCommas(sum_2bt.toFixed(2));
    document.getElementById("coin_2bt").innerHTML = 'เหรียญ' + '&nbsp;=&nbsp;' + result_2bt + '&nbsp;บาท';
    //-------------------coin1bt-----------------------------
    var coin1bt = $('#vwfirepsummary-coin1bt').val();
    var sum_1bt = coin1bt*1;
    var result_1bt = addCommas(sum_1bt.toFixed(2));
    document.getElementById("coin_1bt").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_1bt+'&nbsp;บาท';
    //-------------------coin50cn-----------------------------
    var coin50cn = $('#vwfirepsummary-coin50cn').val();
    var sum_50cn = coin50cn*0.50;
    var result_50cn = addCommas(sum_50cn.toFixed(2));
    document.getElementById("coin_50cn").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_50cn+'&nbsp;บาท';
    //-------------------coin50cn-----------------------------
    var coin25cn = $('#vwfirepsummary-coin25cn').val();
    var sum_25cn = coin25cn*0.25;
    var result_25cn = addCommas(sum_25cn.toFixed(2));
    document.getElementById("coin_25cn").innerHTML = 'เหรียญ'+'&nbsp;=&nbsp;'+result_25cn+'&nbsp;บาท';
    });    
    
    
JS;
$this->registerJs($script);
?>
