<?php

use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\pr\models\VwNdplanDetailAvalible;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\pr\models\TbPackunit;
use kartik\icons\Icon;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formitemdetails', 'action' => Url::to(['saveitem-details-verify']),]); ?>

        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'ItemID', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'value' => !empty($model['ItemID']) ? $model['ItemID'] : $itemList['ItemID'],
                ]);
                ?>
            </div>

            <?= Html::label(Html::encode('ขอซื้อแบบ'), false, ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <div class="radio">
                    <label>
                        <?= Html::input('text', 'PacCin', '', ['type' => 'radio', 'id' => 'pac', 'value' => '1']) ?>
                        <?= Html::tag('span', Html::encode('แพค'), ['class' => 'text']) ?>
                    </label>
                    <label>
                        <?= Html::input('text', 'PacCin', '', ['type' => 'radio', 'id' => 'cin', 'value' => '0']) ?>
                        <?= Html::tag('span', Html::encode('ชิ้น'), ['class' => 'text']) ?>
                    </label>
                </div>
            </div>
            <div class="col-sm-2">
                <?php // echo $this->render('config', ['action' => 'update-verify-nd']); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PCPlanNum', ['label' => 'เลขที่แผนจัดซื้อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PCPlanNum', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(VwNdplanDetailAvalible::find()->where(['ItemID' => !empty($model['ItemID']) ? $model['ItemID'] : $itemList['ItemID']])->all(), 'PCPlanNum', 'PCPlanNum'),
                    'language' => 'en',
                    'pluginOptions' => [
                        'placeholder' => 'เลือกแผน',
                        'allowClear' => true,
                    //'disabled' => true
                    ],
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'PRPackQty', ['label' => 'จำนวนแพค' . '<span id="checkจำนวนแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRPackQty', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white;text-align:right',
                    'value' => empty($model['PRVerifyQty']) ? $model['PRPackQty'] : $model['PRPackQtyVerify'],
                ])
                ?>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemName', ['label' => 'รายละเอียดยา', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-8">
                <?=
                $form->field($model, 'ItemName', ['showLabels' => false])->textarea([
                    'rows' => 3,
                    'readonly' => true,
                    'style' => 'background-color:#f9f9f9',
                    'value' => $itemList['ItemName'],
                ])
                ?>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRItemStdCost', ['label' => 'ราคากลาง', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRItemStdCost', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'ItemPackID', ['label' => 'หน่วยแพค' . '<span id="checkหน่วยแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'ItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TbPackunit::find()->where(['PackUnitID' => $ItemPackUnit])->all(), 'PackUnitID', 'PackUnit'),
                    'language' => 'en',
                    'pluginOptions' => [
                        'placeholder' => 'เลือกหน่วยแพค',
                        'allowClear' => true,
                    ],
                ])
                ?>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRItemUnitCost', ['label' => 'ราคา/หน่วย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRItemUnitCost', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'ItemPackSKUQty', ['label' => 'ปริมาณ/แพค', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'ItemPackSKUQty', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ])
                ?>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRItemOrderQty', ['label' => 'จำนวน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRItemOrderQty', ['showLabels' => false])->textInput([
                    'maxlength' => true,
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'ItemPackCost', ['label' => 'ราคา/แพค' . '<span id="checkราคาต่อแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'ItemPackCost', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white;text-align:right',
                    'value' => empty($model['PRVerifyQty']) ? $model['ItemPackCost'] : $model['ItemPackCostVerify'],
                ])
                ?>
            </div>
            <div class="col-sm-1"></div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRApprovedOrderQtySum', ['label' => 'ขอซื้อแล้ว', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRApprovedOrderQtySum', ['showLabels' => false])->textInput([
                    'maxlength' => true,
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'PROrderQty', ['label' => 'จำนวน' . '<span id="checkขอซื้อ"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PROrderQty', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white;text-align:right',
                    'required' => true,
                    'value' => empty($model['PRVerifyQty']) ? $model['PROrderQty'] : $model['PRVerifyQty'],
                ])
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRItemAvalible', ['label' => 'ขอซื้อได้', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRItemAvalible', ['showLabels' => false])->textInput([
                    'maxlength' => true,
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'DispUnit', ['label' => 'หน่วย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'DispUnit', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                    'value' => !empty($model['DispUnit']) ? $model['DispUnit'] : $itemList['DispUnit'],
                ])
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRLastUnitCost', ['label' => 'ราคาซื้อครั้งล่าสุด', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRLastUnitCost', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #f5f5f5;text-align:right',
                    'readonly' => true,
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'PRUnitCost', ['label' => 'ราคาต่อหน่วย' . '<span id="checkราคาต่อหน่วย"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRUnitCost', ['showLabels' => false])->textInput([
                    'required' => true,
                    'style' => 'background-color: white;text-align:right',
                    'value' => empty($model['PRVerifyQty']) ? $model['PRUnitCost'] : $model['PRVerifyUnitCost'],
                ])
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
                <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput([]); ?>
                <?= $form->field($model, 'PRID', ['showLabels' => false])->hiddenInput([]); ?>
                <?= $form->field($model, 'PRItemOnPCPlan', ['showLabels' => false])->hiddenInput([]); ?>
                <?= $form->field($model, 'PackID', ['showLabels' => false])->hiddenInput(['value' => !empty($model['ItemPackIDVerify']) ? $model['ItemPackIDVerify'] : $model['ItemPackID']]); ?>
                <?= Html::input('text', 'formsubmit', 'formsubmit', ['type' => 'hidden', 'id' => 'checkform-submit', 'value' => '', 'class' => 'form-control']) ?>
            </div>
            <?= Html::activeLabel($model, 'PRExtendedCost', ['label' => 'รวมเป็นเงิน', 'class' => 'col-sm-5 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRExtendedCost', ['showLabels' => false])->textInput([
                    //'readonly' => true,
                    'style' => 'background-color: #ffff99;text-align:right',
                        //'value' => empty($model['PRVerifyQty']) ? number_format($model['PROrderQty'] * $model['PRUnitCost'], 2) : number_format($model['PRVerifyQty'] * $model['PRVerifyUnitCost'], 2),
                ])
                ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="modal-footer">
                <?= Html::button(Icon::show('remove', [], Icon::BSG) . 'Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
                <?= Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . 'Save' : Icon::show('floppy-disk', [], Icon::BSG) . 'Save', ['class' => $model->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'data-style' => 'slide-down']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tbpritemdetail2-prextendedcost').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2-prunitcost').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2-prorderqty').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2-itempackcost').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2-prpackqty').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2-prlastunitcost').autoNumeric('init', {mDec: '4'});
        GetSKU();
    });

    /* คำนวณขอซื้อ */
    $("#tbpritemdetail2-prorderqty").keyup(function () {
        var prorderqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//ขอซื้อ
        var prunitcost = parseFloat($("#tbpritemdetail2-prunitcost").val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var total = prorderqty * prunitcost;
        addTotal(total);
    });

    /* คำนวณราคาต่อหน่วย */
    $("#tbpritemdetail2-prunitcost").keyup(function () {
        var prunitcost = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var prorderqty = parseFloat($("#tbpritemdetail2-prorderqty").val().replace(/[,]/g, "")) || 0;//ขอซื้อ
        var total = prunitcost * prorderqty;
        addTotal(total);
    });

    //คำนวณจำนวนแพค
    $("#tbpritemdetail2-prpackqty").keyup(function () {
        var prpackqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;
        var itempackskuqty = parseFloat($("#tbpritemdetail2-itempackskuqty").val().replace(/[,]/g, "")) || 0;
        var prunitcost = parseFloat($("#tbpritemdetail2-prunitcost").val().replace(/[,]/g, "")) || 0;
        var prorderqty = prpackqty * itempackskuqty;
        var Total = prorderqty * prunitcost;
        if (isNaN(prorderqty)) {
            $("#tbpritemdetail2-prorderqty").val(addCommas(prpackqty.toFixed(4)));
        } else {
            $("#tbpritemdetail2-prorderqty").val(addCommas(prorderqty.toFixed(4)));
        }
        if (!isNaN(Total)) {
            $("#tbpritemdetail2-prextendedcost").val(addCommas(Total.toFixed(4)));
        }
    });

    //คำนวณราคาต่อแพค
    $("#tbpritemdetail2-itempackcost").keyup(function () {/* ราคา/แพค */
        var itempackcost = $(this).val().replace(/[,]/g, "");
        var itempackskuqty = parseFloat($("#tbpritemdetail2-itempackskuqty").val().replace(/[,]/g, "")) || 0; //ปริมาณต่อแพค
        var prorderqty = parseFloat($("#tbpritemdetail2-prorderqty").val().replace(/[,]/g, "")) || 0;/* ขอซื้อ */
        // var prunitcost = parseFloat($("#tbpritemdetail2-prunitcost").val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var pritemunitcost = parseFloat($("#tbpritemdetail2-pritemunitcost").val().replace(/[,]/g, "")) || 0;

        var prunitcost = itempackcost / itempackskuqty;//หาราคาต่อหน่วย
        var prextendedcost = prunitcost * prorderqty; //หาราคารวม
        if (!isNaN(prunitcost)) {
            $("#tbpritemdetail2-prunitcost").val(addCommas(prunitcost.toFixed(4)));
        }

        if (!isNaN(prextendedcost)) {
            $("#tbpritemdetail2-prextendedcost").val(addCommas(prextendedcost.toFixed(4)));
        }
        if ((!isNaN(pritemunitcost)) && (prunitcost > pritemunitcost)) {
            swal({
                title: "",
                text: "ราคาต่อหน่วย เกิน ราคาต่อหน่วยในแผน!",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {

                        }
                    });
        }
    });

    $('#tbpritemdetail2-pcplannum').on('change', function () {
        var ItemID = $("#tbpritemdetail2-itemid").val();
        var PCPlanNum = $(this).find("option:selected").text();
        if ((PCPlanNum !== 'เลือกแผน') && (PCPlanNum !== '')) {
            $.ajax({
                url: '<?= Url::to(['get-datapcplan']); ?>',
                type: 'POST',
                dataType: 'json',
                data: {PCPlanNum: PCPlanNum, ItemID: ItemID},
                success: function (data) {
                    $('#tbpritemdetail2-itemname').val(data.ItemName);
                    $('#tbpritemdetail2-pritemstdcost').val(data.NDStdCost);
                    $('#tbpritemdetail2-pritemunitcost').val(data.PCPlanNDUnitCost);
                    $('#tbpritemdetail2-pritemorderqty').val(data.PCPlanNDQty);
                    $('#tbpritemdetail2-prapprovedorderqtysum').val(data.PRApprovedQtySUM);
                    $('#tbpritemdetail2-pritemavalible').val(data.PRNDAvalible);
                }
            });
        } else {
            $('#tbpritemdetail2-pritemstdcost').val(null);
            $('#tbpritemdetail2-pritemunitcost').val(null);
            $('#tbpritemdetail2-pritemorderqty').val(null);
            $('#tbpritemdetail2-prapprovedorderqtysum').val(null);
            $('#tbpritemdetail2-pritemavalible').val(null);
        }
    });

    $(document).ready(function () {
        var prpackqty = $("#tbpritemdetail2-prpackqty").val();
        if (prpackqty == "" || prpackqty == 0) {
            document.getElementById("cin").checked = true;
            if ($("input[id=cin]").is(":checked"))
            {
                Chin();
            }
        } else {
            document.getElementById("pac").checked = true;
            Pack();
        }

        $("input[id=pac]").click(function () {
            if ($(this).is(":checked"))
            {
                Pack();
            }
        });

        $("input[id=cin]").click(function () {
            if ($(this).is(":checked"))
            {
                Chin();
            }
        });
    });

    function Pack() {
        $("#tbpritemdetail2-prpackqty,#tbpritemdetail2-itempackcost").removeAttr('readonly');
        $("#tbpritemdetail2-itempackid").removeAttr('disabled');

        $("#tbpritemdetail2-prorderqty,#tbpritemdetail2-prunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#tbpritemdetail2-prpackqty,#tbpritemdetail2-itempackcost').css('background-color', '#FFFF99');
        $('#tbpritemdetail2-prorderqty,#tbpritemdetail2-prunitcost').css('background-color', '#f9f9f9');
    }
    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#tbpritemdetail2-prpackqty,#tbpritemdetail2-itempackcost").attr('readonly', 'readonly');
        $("#tbpritemdetail2-itempackid").attr('disabled', 'disabled');
        $("#tbpritemdetail2-prorderqty,#tbpritemdetail2-prunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#tbpritemdetail2-prorderqty,#tbpritemdetail2-prunitcost').css('background-color', '#FFFF99');
        $('#tbpritemdetail2-prpackqty,#tbpritemdetail2-itempackcost').css('background-color', '#f9f9f9');
    }

    $('#formitemdetails').on('beforeSubmit', function (e)
    {
        var form = $(this);
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.post(
                form.attr("action"), // serialize Yii2 form
                form.serialize()
                )
                .done(function (result) {

                    if ((result !== 'pass') && (result !== 'save')) {
                        AlertMessage(result, form, l);
                    } else if (result === 'save') {
                        swal({
                            title: "Save Completed!",
                            text: "",
                            type: "success",
                            showCancelButton: false,
                            confirmButtonText: "OK",
                            closeOnConfirm: true,
                            closeOnCancel: true,
                        },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        l.ladda('stop');
                                        $.pjax.reload({container: '#verify_nd_pjax'});
                                        $('#nd-modal').modal('hide');
                                        /*$('#modal-table-nd').modal('hide');*/
                                    }
                                });
                    } else {
                        PostformDetailsToSave(form, l, result);
                    }
                }).fail(function (xhr, status, error)
        {
            l.ladda('stop');
            swal(error, "", "error");
            console.log("server error");
        });
        return false;
    });

    function PostformDetailsToSave(form, l, result) {
        $('#checkform-submit').val('pass');
        SetStatusOnPlan(result);
        $.post(
                form.attr("action"), // serialize Yii2 form
                form.serialize()
                ).done(function (result)
        {
            if (result === 'save') {
                swal({
                    title: "Save Completed!",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonText: "OK",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                $('#formitemdetails').trigger("reset");
                                l.ladda('stop');
                                $.pjax.reload({container: '#verify_nd_pjax'});
                                $('#nd-modal').modal('hide');
                                /*$('#modal-table-nd').modal('hide');*/
                            }
                        });
            }
        }
        ).fail(function (xhr, status, error)
        {
            l.ladda('stop');
            swal(error, "", "error");
            console.log("server error");
        });
    }

    function AlertMessage(result, form, l) {
        swal({
            title: "ยืนยันข้อมูลขอซื้อ?",
            text: '<span style="color:#DD6B55">' + result + '</span>',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#53a93f",
            confirmButtonText: "Confirm",
            closeOnConfirm: false,
            closeOnCancel: true,
            html: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        PostformDetailsToSave(form, l, result);
                    } else {
                        l.ladda('stop');
                    }
                });
    }

    function addTotal(total) {
        if (total > 0) {
            $("#tbpritemdetail2-prextendedcost").val(addCommas(total.toFixed(4)));//รวมเป็นเงิน
        } else {
            $("#tbpritemdetail2-prextendedcost").val('0.0000');//รวมเป็นเงิน
        }
    }

    /* คำนวณ on chang หน่วยแพค */
    $('#tbpritemdetail2-itempackid').on('change', function () {
        var ItemPackUnit = $(this).find("option:selected").val() || null;
        var ItemID = $("#tbpritemdetail2-itemid").val();
        var PRPackQty = parseFloat($("#tbpritemdetail2-prpackqty").val().replace(/[,]/g, "")) || 0;
        var ItemPackCost = parseFloat($("#tbpritemdetail2-itempackcost").val().replace(/[,]/g, "")) || 0;
        var Type = 'OnChange';
        if (ItemPackUnit !== null) {
            $.ajax({
                url: '<?= Url::to(['get-skuqty']); ?>',
                type: "POST",
                data: {ItemPackUnit: ItemPackUnit, ItemID: ItemID, PRPackQty: PRPackQty, ItemPackCost: ItemPackCost, Type: Type},
                dataType: 'json',
                success: function (result) {
                    $('#tbpritemdetail2-packid').val(result.ItemPackID);
                    $('#tbpritemdetail2-itempackskuqty').val(result.ItemPackSKUQty);//ปริมาณต่อแพค
                    $('#tbpritemdetail2-prorderqty').val(addCommas((result.PROrderQty).toFixed(4)));
                    $("#tbpritemdetail2-prunitcost").val(addCommas((result.PRUnitCost).toFixed(4)));
                    $("#tbpritemdetail2-prextendedcost").val(addCommas((result.Total).toFixed(4)));
                }
            });
        } else {
            $('#tbpritemdetail2-packid').val(null);
            $('#tbpritemdetail2-itempackskuqty').val(null);//ปริมาณต่อแพค
            $('#tbpritemdetail2-prorderqty').val(null);
            $("#tbpritemdetail2-prunitcost").val(null);
            $("#tbpritemdetail2-prextendedcost").val(null);
            $("#tbpritemdetail2-itempackcost").val(null);
        }
    });

    function GetSKU() {
        var PackID = $("#tbpritemdetail2-packid").val();
        var Type = 'OnEdit';
        if (PackID != '') {
            $.ajax({
                url: '<?= Url::to(['get-skuqty']); ?>',
                type: "POST",
                data: {PackID: PackID, Type: Type},
                dataType: 'json',
                success: function (result) {
                    $('#tbpritemdetail2-itempackskuqty').val(result.ItemPackSKUQty);//ปริมาณต่อแพค
                    $("#tbpritemdetail2-itempackid").val(result.ItemPackUnit).trigger("change");
                }
            });
        }
    }
    /* กำหนดสถานะเกินแผน */
    function SetStatusOnPlan(result) {
        if ((result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p>')) {
            $('#tbpritemdetail2-pritemonpcplan').val('1');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p>') {
            $('#tbpritemdetail2-pritemonpcplan').val('2');
        } else if (result === '<p style="color:#DD6B55;">1.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2-pritemonpcplan').val('3');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p> <p style="color:#DD6B55;">3.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2-pritemonpcplan').val('4');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p>') {
            $('#tbpritemdetail2-pritemonpcplan').val('5');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2-pritemonpcplan').val('6');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคาต่อหน่วยในแผน!</p> <p style="color:#DD6B55;">2.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2-pritemonpcplan').val('7');
        } else {
            $('#tbpritemdetail2-pritemonpcplan').val('8');
        }
    }
    $("#tbpritemdetail2-pcplannum").val('<?= $model['PCPlanNum']; ?>').trigger("change");
</script>
