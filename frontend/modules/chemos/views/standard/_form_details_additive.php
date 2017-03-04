<?php

use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemos\models\VwCpoeDoseadviceRateUnit;
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'id' => 'form_drugsetdetail_additive',
            'method' => 'post',
            'action' => Url::to(['save-drugsetdetail']),
        ]);
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('ItemDetail :') ?></b>
        </h5>

        <ul class="list-group">
            <li class="list-group-item" style="border: 0px solid white;background-color: #fbfbfb;">
                <span class="text"><text class="itemdetail"></text></span>
            </li>
        </ul>

    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-xs-12 col-sm-6 col-md-8">
            <input type="hidden" name="drugset_type" id="drugset_type" class="form-control" value="<?= empty($drugset_type) ? null : $drugset_type;?>"/>
            <input type="hidden" id="inputroute" value="<?= !empty($route->TMTID_GPU) ? $route->TMTID_GPU : ''; ?>">
            <input type="hidden" id="inputrouteadvice" value="<?= !empty($route->DrugPrandialAdviceID) ? $route->DrugPrandialAdviceID : ''; ?>">
            <?=
            $form->field($model, 'drugset_ids', ['showLabels' => false])->hiddenInput([
                'id' => 'tbdrugsetdetail-drugset_ids1',
            ])
            ?>
            <?= $form->field($model, 'drugset_id', ['showLabels' => false])->hiddenInput(['value' => !empty($model['drugset_id']) ? $model['drugset_id'] : $drugset_id]) ?>
            <?= $form->field($model, 'chemo_regimen_ids', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'std_trp_chemo_ids', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ItemPrice', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_route_id', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_drugprandialadviceid', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_Itemtype', ['showLabels' => false])->hiddenInput(['value' => '52']) ?>
            <?= $form->field($model, 'cpoe_narcotics_confirmed', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ised', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_once', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_repeat', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_frequency', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_dayrepeat', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ised_reason', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_rxordertype', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_ItemStatus', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_seq', ['showLabels' => false])->hiddenInput(['value' => !empty($model['cpoe_seq']) ? $model['cpoe_seq'] : $seq]) ?>
            <?= $form->field($model, 'cpoe_parentid', ['showLabels' => false])->hiddenInput(['value' => !empty($model['cpoe_parentid']) ? $model['cpoe_parentid'] : $parentid]) ?>
            <?= $form->field($model, 'Item_comment1', ['showLabels' => false])->hiddenInput(['style' => 'background-color: white']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Dispense Qty : ') ?></b>
            <text style="color: red">*</text><text style="color: black"><?= Html::encode('เลือกอัตราการให้ยา เมื่อต้องการคำนวณอัตราการให้ยา'); ?></text>
            <div id="msgqty1" class="alert-error"></div><!-- Alert Message -->
        </h5>
        <!-- Begin Well -->
        <div class="well">
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_route_id', ['label' => '', 'class' => 'col-sm-1 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-2" style="text-align: right;">
                        <div class="checkbox">
                            <label><input type="checkbox" id="อัตราการให้" placeholder=""/><span class="text"><?= Html::encode('อัตราการให้'); ?></span></label>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= $form->field($model, 'cpoe_doseadvice_rate_min', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'placeholder' => 'Min']) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= $form->field($model, 'cpoe_doseadvice_rate_max', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'placeholder' => 'Max']) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?=
                        $form->field($model, 'cpoe_doseadvice_rate_unit_id', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(VwCpoeDoseadviceRateUnit::find()->all(), 'cpoe_doseadvice_rate_unit_id', 'cpoe_doseadvice_rate_unit_decs'),
                            'options' => ['placeholder' => 'Select State...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <!-- Begin Row -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <table style="width: 100%" border="0">
                            <tbody>
                                <tr>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><b><?= Html::encode('เป็นเงิน'); ?></b></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><b><?= Html::encode('เบิกได้'); ?></b></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><b><?= Html::encode('เบิกไม่ได้'); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><span id="showItem_Total_Amt" class="showItem_Total_Amt_Additive"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Cr_Amt" class="showItem_Cr_Amt_Additive"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Pay_Amt" class="showItem_Pay_Amt_Additive"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <div class="form-group">
                        <?=
                        $form->field($model, 'ItemQty', ['showLabels' => false])->textInput([
                            'style' => [
                                'height' => '40px',
                                'font-size' => '25pt',
                                'text-align' => 'right',
                                'background-color' => 'white',
                                'width' => '100%'
                            ],
                            'class' => 'form-control itemqty',
                            'id' => 'tbdrugsetdetail-drugset_itemqty1',
                            'required' => true,
                            'value' => empty($model['ItemQty']) ? null : number_format($model['ItemQty'], 2)
                        ])
                        ?>
                        <span class="pull-right disunitontableadditive"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-1">
                    <p></p>
                    <?= Html::a('Calculate', 'javascript:void(0);', ['onclick' => 'CalculateQty1(this);', 'class' => 'btn btn-sm btn-primary ladda-button','data-style' => 'slide-left','id' => 'CalculateQty1']); ?>
                </div>
            </div><!-- End Row -->
        </div><!-- End Well -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <div class="form-group" style="text-align: right;">
            <?= Html::button('<i class="glyphicon glyphicon-chevron-left"></i> ' . 'Prev', ['class' => 'btn btn-default', 'id' => 'backsteb2']) ?>
            <?= Html::button('Close', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-default']); ?>
            <?= Html::button('Save', ['type' => 'button', 'class' => 'ladda-button btn btn-success Savedrugsetdetail', 'id' => 'Savedrugsetdetail','data-style' => 'expand-left']); ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<script>

    /* FN คำนวณเม็ดยา  */
    function CalculateQty1() {
        var frm = $('#form_drugsetdetail_additive');
        var qty = $('#tbdrugsetdetail-itemqty').val();
        var l = $('#CalculateQty1').ladda();
        l.ladda('start');
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=chemos/standard/calculate-qty',
            data: frm.serialize(),
            dataType: "JSON",
            success: function (data) {
                $('#tbdrugsetdetail-drugset_itemqty1').val(data.Qty);
                $('.showItem_Total_Amt_Additive').html(data.Item_Total_Amt);//เป็นเงิน
                $('.showItem_Cr_Amt_Additive').html(data.Item_Cr_Amt);//เบิกได้
                $('.showItem_Pay_Amt_Additive').html(data.Item_Pay_Amt);//เบิกไม่ได้
                var msg = 'Calculated!';
                $('#msgqty1').addClass('alert-success').removeClass('alert-error').html(msg).show();
                l.ladda('stop');
                setTimeout(function () {
                    $('#msgqty1').addClass('alert-error').removeClass('alert-success').html('').hide();
                }, 1000);
            }
        });
    }

    function CalculateDrugprice1() {
        var ItemID = $('input[id=tbdrugsetdetail-itemid]').val();
        var ItemQty = $('input[id=tbdrugsetdetail-itemqty]').val();
        $.ajax({
            url: "index.php?r=chemos/standard/calculate-drugprice",
            type: "post",
            data: {ItemID: ItemID, ItemQty: ItemQty},
            dataType: "JSON",
            success: function (data) {
                $('.showItem_Total_Amt_Additive').html(data.Item_Total_Amt);//เป็นเงิน
                $('.showItem_Cr_Amt_Additive').html(data.Item_Cr_Amt);//เบิกได้
                $('.showItem_Pay_Amt_Additive').html(data.Item_Pay_Amt);//เบิกไม่ได้
            }
        });
    }


    //ปุ่มกลับ
    $("button[id=backsteb2]").click(function () {
        //Back to Steb 1
        $('#simplewizardstep3').removeClass('active');//AddClass Steb
        $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
        $('div[id=numbersteb3]').html(''); //Setnumber Steb
        $('.content2').removeClass('active');
        $('.content1').addClass('active');
    });

    //Submit From
    $('.Savedrugsetdetail').click(function (e) {
        var frm = $('#form_drugsetdetail_additive');
        var qty = $('#tbdrugsetdetail-itemqty').val();
        var l = $('.Savedrugsetdetail').ladda();
        if (qty == '' || qty == null) {
            swal("กรุณาคำนวณ Dispense!", "", "warning");
        } else {
            l.ladda('start');
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    GettbDrugAdditive();
                    swal({
                        title: "",
                        text: "Save Complete!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    $('#ajaxCrudModal').modal('hide');
                                }
                            });
                }
            });
        }
    });

    $("input[id=อัตราการให้]").click(function () {
        if ($(this).is(":checked"))
        {
            document.getElementById("tbdrugsetdetail-cpoe_doseadvice_rate_min").disabled = false;
            document.getElementById("tbdrugsetdetail-cpoe_doseadvice_rate_max").disabled = false;
            document.getElementById("tbdrugsetdetail-cpoe_doseadvice_rate_unit_id").disabled = false;
            $('#tbdrugsetdetail-cpoe_doseadvice_rate_min,#tbdrugsetdetail-cpoe_doseadvice_rate_max,#tbdrugsetdetail-cpoe_doseadvice_rate_unit_id').css('background-color', 'white');
            
        } else {
            document.getElementById("tbdrugsetdetail-cpoe_doseadvice_rate_min").disabled = true;
            document.getElementById("tbdrugsetdetail-cpoe_doseadvice_rate_max").disabled = true;
            document.getElementById("tbdrugsetdetail-cpoe_doseadvice_rate_unit_id").disabled = true;
            $('#tbdrugsetdetail-cpoe_doseadvice_rate_min,#tbdrugsetdetail-cpoe_doseadvice_rate_max,#tbdrugsetdetail-cpoe_doseadvice_rate_unit_id').css('background-color', '#ddd');
        }
    });
</script>