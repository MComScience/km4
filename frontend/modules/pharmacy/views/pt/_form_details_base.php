<?php

use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'id' => 'form_drugsetdetail',
            'method' => 'post',
            //'enableAjaxValidation' => true,
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
            <input name="pt_visit_number" id="pt_visit_number" value="" type="hidden"/>
            <input type="hidden" id="inputroute" value="<?= !empty($route->TMTID_GPU) ? $route->TMTID_GPU : ''; ?>">
            <input type="hidden" id="inputrouteadvice" value="<?= !empty($route->DrugPrandialAdviceID) ? $route->DrugPrandialAdviceID : ''; ?>">
            <?=
            $form->field($model, 'drugset_ids', ['showLabels' => false])->hiddenInput([
                'id' => 'tbdrugsetdetail-drugset_ids1'
            ])
            ?>
            <?= $form->field($model, 'drugset_id', ['showLabels' => false])->hiddenInput(['value' => !empty($model['drugset_id']) ? $model['drugset_id'] : $drugsetid]) ?>
            <?= $form->field($model, 'chemo_regimen_ids', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ItemPrice', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_route_id', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_drugprandialadviceid', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_Itemtype', ['showLabels' => false])->hiddenInput(['value' => '51']) ?>
            <?= $form->field($model, 'cpoe_narcotics_confirmed', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ised', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_once', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_repeat', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput(['class' => 'ItemID']) ?>
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
            <text style="color: red">*</text><text style="color: black"><?= Html::encode('สามารถกำหนดปริมาณได้'); ?></text>
            <div id="msgqty1" class="alert-error"></div><!-- Alert Message -->
        </h5>
        <!-- Begin Well -->
        <div class="well">
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
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><span id="showItem_Total_Amt" class="showItem_Total_Amt_Base"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Cr_Amt" class="showItem_Cr_Amt_Base"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Pay_Amt" class="showItem_Pay_Amt_Base"></span></td>
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
                            'required' => true,
                            'id' => 'tbdrugsetdetail-itemqty1',
                            'value' => empty($model['ItemQty']) ? null : number_format($model['ItemQty'], 2)
                        ])
                        ?>
                        <span class="pull-right disunitontablebase"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-1">
                    <p></p>
                    <?= Html::a('Calculate', 'javascript:void(0);', ['onclick' => 'CalculateQty(this);', 'class' => 'btn btn-sm btn-primary ladda-button','data-style' => 'slide-left','id' => 'CalculateQty']); ?>
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
            <?= Html::button('Save', ['type' => 'button', 'class' => 'btn btn-success ladda-button', 'id' => 'Savedrugsetdetail1','data-style' => 'expand-left']); ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<script>

    /* FN คำนวณเม็ดยา  */
    function CalculateQty() {
        var l = $('#CalculateQty').ladda();
        l.ladda('start');
        var frm = $('#form_drugsetdetail');
        var qty = $('#tbdrugsetdetail-itemqty').val();
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=pharmacy/pt/calculate-qty',
            data: frm.serialize(),
            dataType: "JSON",
            success: function (data) {
                $('input[id=tbdrugsetdetail-itemqty1]').val(data.Qty);
                $('.showItem_Total_Amt_Base').html(data.Item_Total_Amt);//เป็นเงิน
                $('.showItem_Cr_Amt_Base').html(data.Item_Cr_Amt);//เบิกได้
                $('.showItem_Pay_Amt_Base').html(data.Item_Pay_Amt);//เบิกไม่ได้
                var msg = 'Calculated!';
                $('#msgqty1').addClass('alert-success').removeClass('alert-error').html(msg).show();
                l.ladda('stop');
                setTimeout(function () {
                    $('#msgqty1').addClass('alert-error').removeClass('alert-success').html('').hide();
                }, 1000);
            }
        });
    }

    function CalculateDrugprice() {
        var ItemID = $('input[id=tbdrugsetdetail-itemid]').val();
        var ItemQty = $('input[id=tbdrugsetdetail-itemqty]').val();
        var pt_visit_number = $('input[id=tbpttrpchemo-pt_visit_number]').val();
        $.ajax({
            url: "index.php?r=pharmacy/pt/calculate-drugprice",
            type: "post",
            data: {ItemID: ItemID, ItemQty: ItemQty, pt_visit_number: pt_visit_number},
            dataType: "JSON",
            success: function (data) {
                $('.showItem_Total_Amt_Base').html(data.Item_Total_Amt);//เป็นเงิน
                $('.showItem_Cr_Amt_Base').html(data.Item_Cr_Amt);//เบิกได้
                $('.showItem_Pay_Amt_Base').html(data.Item_Pay_Amt);//เบิกไม่ได้
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
    $('#Savedrugsetdetail1').click(function (e) {
        var frm = $('#form_drugsetdetail');
        var qty = $('#tbdrugsetdetail-itemqty').val();
        var l = $('#Savedrugsetdetail1').ladda();
        if (qty == '' || qty == null) {
            swal("กรุณาคำนวณ Dispense!", "", "warning");
        } else {
            l.ladda('start');
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    GettbBasesolution();
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

</script>
