<?php

use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\pr\models\VwTpuplanDetailAvalible;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use app\modules\pr\models\TbPackunit;
use kartik\icons\Icon;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formitemdetails', 'action' => Url::to(['save-itemdetails']),]); ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TMTID_TPU', ['label' => 'รหัสยาการค้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'TMTID_TPU', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'value' => !empty($model['TMTID_TPU']) ? $model['TMTID_TPU'] : $itemList['TMTID_TPU'],
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
                <?php // echo $this->render('config', ['action' => 'update-detail-tpu']); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PCPlanNum', ['label' => 'เลขที่แผนจัดซื้อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PCPlanNum', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(VwTpuplanDetailAvalible::find()->where(['TMTID_TPU' => !empty($model['TMTID_TPU']) ? $model['TMTID_TPU'] : $itemList['TMTID_TPU']])->all(), 'PCPlanNum', 'PCPlanNum'),
                    'language' => 'en',
                    'pluginOptions' => [
                        'placeholder' => 'เลือกแผน',
                        'allowClear' => true,
                    ],
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'PRPackQty', ['label' => 'จำนวนแพค' . '<span id="checkจำนวนแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRPackQty', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white;text-align:right',
                ])
                ?>
            </div>
            <div class="col-sm-2">

            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemName', ['label' => 'รายละเอียดยา', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-8">
                <?=
                $form->field($model, 'ItemName', ['showLabels' => false])->textarea([
                    'rows' => 3,
                    'readonly' => true,
                    'style' => 'background-color:#f9f9f9',
                    'value' => $itemList['FSN_TMT'],
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
            <div class="col-sm-1">
                <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
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
            <div class="col-sm-1">
                <?= $form->field($model, 'PRID', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
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
                ])
                ?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, 'PRItemOnPCPlan', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
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
                ])
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'PackID', ['showLabels' => false])->hiddenInput(['value' => !empty($model['ItemPackID']) ? $model['ItemPackID'] : null]); ?>
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
            <div class="col-sm-2">
                <?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput(['value' => !empty($model['ItemID']) ? $model['ItemID'] : $itemList['ItemID']]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRLastUnitCost', ['label' => 'ราคาซื้อครั้งล่าสุด' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRLastUnitCost', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right',
                    'required' => true,
                ])
                ?>
            </div>

            <?= Html::activeLabel($model, 'PRUnitCost', ['label' => 'ราคาต่อหน่วย' . '<span id="checkราคาต่อหน่วย"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRUnitCost', ['showLabels' => false])->textInput([
                    'required' => true,
                    'style' => 'background-color: white;text-align:right',
                ])
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'TMTID_GPU', ['showLabels' => false])->hiddenInput(['value' => $itemList['TMTID_GPU']]); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-2">
                <?= Html::input('text', 'formsubmit', 'formsubmit', ['type' => 'hidden', 'id' => 'checkform-submit', 'value' => '', 'class' => 'form-control']) ?>
            </div>
            <?= Html::activeLabel($model, 'PRExtendedCost', ['label' => 'รวมเป็นเงิน', 'class' => 'col-sm-5 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRExtendedCost', ['showLabels' => false])->textInput([
                    /* 'readonly' => true, */
                    'style' => 'background-color: #ffff99;text-align:right',
                        /* 'value' => number_format($model['PROrderQty'] * $model['PRUnitCost'], 2), */
                ])
                ?>
            </div>
            <div class="col-sm-2">
                <?php // Html::button(Icon::show('remove', [], Icon::BSG) . 'Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
                <?php // Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . 'Save' : Icon::show('floppy-disk', [], Icon::BSG) . 'Save', ['class' => $model->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'data-style' => 'slide-down']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="modal-footer">
                    <?php echo Html::button(Icon::show('remove', [], Icon::BSG) . 'Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
                    <?php echo Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . 'Save' : Icon::show('floppy-disk', [], Icon::BSG) . 'Save', ['class' => $model->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'data-style' => 'slide-down']) ?>
                </div>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tbpritemdetail2temp-prextendedcost').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2temp-prunitcost').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2temp-prorderqty').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2temp-itempackcost').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2temp-prpackqty').autoNumeric('init', {mDec: '4'});
        $('#tbpritemdetail2temp-prlastunitcost').autoNumeric('init', {mDec: '4'});
        GetSKU();
    });

    /* คำนวณขอซื้อ */
    $("#tbpritemdetail2temp-prorderqty").keyup(function () {
        var prorderqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//ขอซื้อ
        var prunitcost = parseFloat($("#tbpritemdetail2temp-prunitcost").val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var total = prorderqty * prunitcost;
        addTotal(total);
    });

    /* คำนวณราคาต่อหน่วย */
    $("#tbpritemdetail2temp-prunitcost").keyup(function () {
        var prunitcost = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var prorderqty = parseFloat($("#tbpritemdetail2temp-prorderqty").val().replace(/[,]/g, "")) || 0;//ขอซื้อ
        var total = prunitcost * prorderqty;
        addTotal(total);
    });

    function addTotal(total) {
        if (total > 0) {
            $("#tbpritemdetail2temp-prextendedcost").val(addCommas(total.toFixed(4)));//รวมเป็นเงิน
        } else {
            $("#tbpritemdetail2temp-prextendedcost").val('0.0000');//รวมเป็นเงิน
        }
    }
    //คำนวณจำนวนแพค
    $("#tbpritemdetail2temp-prpackqty").keyup(function () {
        var prpackqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;
        var itempackskuqty = parseFloat($("#tbpritemdetail2temp-itempackskuqty").val().replace(/[,]/g, "")) || 0;
        var prunitcost = parseFloat($("#tbpritemdetail2temp-prunitcost").val().replace(/[,]/g, "")) || 0;
        var prorderqty = prpackqty * itempackskuqty;
        var Total = prorderqty * prunitcost;
        if (isNaN(prorderqty)) {
            $("#tbpritemdetail2temp-prorderqty").val(addCommas(prpackqty.toFixed(4)));
        } else {
            $("#tbpritemdetail2temp-prorderqty").val(addCommas(prorderqty.toFixed(4)));
        }
        if (!isNaN(Total)) {
            $("#tbpritemdetail2temp-prextendedcost").val(addCommas(Total.toFixed(4)));
        }
    });

    //คำนวณราคาต่อแพค
    $("#tbpritemdetail2temp-itempackcost").keyup(function () {/* ราคา/แพค */
        var itempackcost = $(this).val().replace(/[,]/g, "") || 0;
        var itempackskuqty = parseFloat($("#tbpritemdetail2temp-itempackskuqty").val().replace(/[,]/g, "")) || 0; //ปริมาณต่อแพค
        var prorderqty = parseFloat($("#tbpritemdetail2temp-prorderqty").val().replace(/[,]/g, "")) || 0;/* ขอซื้อ */
        // var prunitcost = parseFloat($("#tbpritemdetail2temp-prunitcost").val().replace(/[,]/g, ""));//ราคาต่อหน่วย
        var pritemunitcost = parseFloat($("#tbpritemdetail2temp-pritemunitcost").val().replace(/[,]/g, "")) || 0;

        var prunitcost = itempackcost / itempackskuqty;//หาราคาต่อหน่วย
        var prextendedcost = prunitcost * prorderqty; //หาราคารวม
        if (!isNaN(prunitcost)) {
            $("#tbpritemdetail2temp-prunitcost").val(addCommas(prunitcost.toFixed(4)));
        }

        if (!isNaN(prextendedcost)) {
            $("#tbpritemdetail2temp-prextendedcost").val(addCommas(prextendedcost.toFixed(4)));
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

    $('#tbpritemdetail2temp-pcplannum').on('change', function () {
        var TMTID_TPU = $("#tbpritemdetail2temp-tmtid_tpu").val();
        var PCPlanNum = $(this).find("option:selected").text() || null;
        if ((PCPlanNum !== null) && (PCPlanNum !== 'เลือกแผน')) {
            $.ajax({
                url: '<?= Url::to(['get-datapcplan']); ?>',
                type: 'POST',
                dataType: 'json',
                data: {PCPlanNum: PCPlanNum, TMTID_TPU: TMTID_TPU},
                success: function (data) {
                    $('#tbpritemdetail2temp-itemname').val(data.FSN_TMT);
                    $('#tbpritemdetail2temp-pritemstdcost').val(data.GPUStdCost);
                    $('#tbpritemdetail2temp-pritemunitcost').val(data.TPUUnitCost);
                    $('#tbpritemdetail2temp-pritemorderqty').val(data.TPUOrderQty);
                    $('#tbpritemdetail2temp-prapprovedorderqtysum').val(data.PRApprovedOrderQty);
                    $('#tbpritemdetail2temp-pritemavalible').val(data.PRTPUAvalible);
                }
            });
        } else {
            $('#tbpritemdetail2temp-pritemstdcost').val(null);
            $('#tbpritemdetail2temp-pritemunitcost').val(null);
            $('#tbpritemdetail2temp-pritemorderqty').val(null);
            $('#tbpritemdetail2temp-prapprovedorderqtysum').val(null);
            $('#tbpritemdetail2temp-pritemavalible').val(null);
        }
    });

    $(document).ready(function () {
        var prpackqty = $("#tbpritemdetail2temp-prpackqty").val();
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
        $("#tbpritemdetail2temp-prpackqty,#tbpritemdetail2temp-itempackcost").removeAttr('readonly');
        $("#tbpritemdetail2temp-itempackid").removeAttr('disabled');

        $("#tbpritemdetail2temp-prorderqty,#tbpritemdetail2temp-prunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#tbpritemdetail2temp-prpackqty,#tbpritemdetail2temp-itempackcost').css('background-color', '#FFFF99');
        $('#tbpritemdetail2temp-prorderqty,#tbpritemdetail2temp-prunitcost').css('background-color', '#f9f9f9');
    }
    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#tbpritemdetail2temp-prpackqty,#tbpritemdetail2temp-itempackcost").attr('readonly', 'readonly');
        $("#tbpritemdetail2temp-itempackid").attr('disabled', 'disabled');
        $("#tbpritemdetail2temp-prorderqty,#tbpritemdetail2temp-prunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#tbpritemdetail2temp-prorderqty,#tbpritemdetail2temp-prunitcost').css('background-color', '#FFFF99');
        $('#tbpritemdetail2temp-prpackqty,#tbpritemdetail2temp-itempackcost').css('background-color', '#f9f9f9');
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
                                        $.pjax.reload({container: '#detail_tpu_pjax'});
                                        $('#tpu-modal').modal('hide');
                                        //$('#modal-table-tpu').modal('hide');
                                    }
                                });
                    } else {
                        PostformDetailsToSave(form, l, result);
                    }
                }).fail(function ()
        {
            l.ladda('stop');
            swal("Error!", "", "error");
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
                                $.pjax.reload({container: '#detail_tpu_pjax'});
                                $('#tpu-modal').modal('hide');
                                // $('#modal-table-tpu').modal('hide');
                            }
                        });
            }
        }
        ).fail(function ()
        {
            l.ladda('stop');
            swal("Error!", "", "error");
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

    /* คำนวณ on chang หน่วยแพค */
    $('#tbpritemdetail2temp-itempackid').on('change', function () {
        var ItemPackUnit = $(this).find("option:selected").val() || null;
        var TMTID_GPU = $("#tbpritemdetail2temp-tmtid_gpu").val();
        var ItemID = $("#tbpritemdetail2temp-itemid").val();
        var PRPackQty = parseFloat($("#tbpritemdetail2temp-prpackqty").val().replace(/[,]/g, "")) || 0;
        var ItemPackCost = parseFloat($("#tbpritemdetail2temp-itempackcost").val().replace(/[,]/g, "")) || 0;
        var Type = 'OnChange';
        if (ItemPackUnit !== null) {
            $.ajax({
                url: '<?= Url::to(['get-skuqty']); ?>',
                type: "POST",
                data: {ItemPackUnit: ItemPackUnit, TMTID_GPU: TMTID_GPU, PRPackQty: PRPackQty, ItemPackCost: ItemPackCost, Type: Type, ItemID: ItemID},
                dataType: 'json',
                success: function (result) {
                    $('#tbpritemdetail2temp-packid').val(result.ItemPackID);
                    $('#tbpritemdetail2temp-itempackskuqty').val(result.ItemPackSKUQty);//ปริมาณต่อแพค
                    $('#tbpritemdetail2temp-prorderqty').val(addCommas((result.PROrderQty).toFixed(4)));
                    $("#tbpritemdetail2temp-prunitcost").val(addCommas((result.PRUnitCost).toFixed(4)));
                    $("#tbpritemdetail2temp-prextendedcost").val(addCommas((result.Total).toFixed(4)));
                }
            });
        } else {
            $('#tbpritemdetail2temp-packid').val(null);
            $('#tbpritemdetail2temp-itempackskuqty').val(null);//ปริมาณต่อแพค
            $('#tbpritemdetail2temp-prorderqty').val(addCommas((0).toFixed(4)));
            $("#tbpritemdetail2temp-prunitcost").val(addCommas((0).toFixed(4)));
            $("#tbpritemdetail2temp-prextendedcost").val(addCommas((0).toFixed(4)));
        }
    });

    function GetSKU() {
        var PackID = $("#tbpritemdetail2temp-packid").val();
        var Type = 'OnEdit';
        if (PackID !== '') {
            $.ajax({
                url: '<?= Url::to(['get-skuqty']); ?>',
                type: "POST",
                data: {PackID: PackID, Type: Type},
                dataType: 'json',
                success: function (result) {
                    $('#tbpritemdetail2temp-itempackskuqty').val(result.ItemPackSKUQty);//ปริมาณต่อแพค
                    $("#tbpritemdetail2temp-itempackid").val(result.ItemPackUnit).trigger("change");
                }
            });
        }
    }
    /* กำหนดสถานะเกินแผน */
    function SetStatusOnPlan(result) {
        if ((result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p>')) {
            $('#tbpritemdetail2temp-pritemonpcplan').val('1');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p>') {
            $('#tbpritemdetail2temp-pritemonpcplan').val('2');
        } else if (result === '<p style="color:#DD6B55;">1.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2temp-pritemonpcplan').val('3');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p> <p style="color:#DD6B55;">3.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2temp-pritemonpcplan').val('4');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ราคาต่อหน่วยขอซื้อ เกิน ราคาต่อหน่วยในแผน!</p>') {
            $('#tbpritemdetail2temp-pritemonpcplan').val('5');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคากลางในแผน!</p> <p style="color:#DD6B55;">2.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2temp-pritemonpcplan').val('6');
        } else if (result === '<p style="color:#DD6B55;">1.ราคาต่อหน่วยขอซื้อ เกิน  ราคาต่อหน่วยในแผน!</p> <p style="color:#DD6B55;">2.ปริมาณขอซื้อ เกิน ปริมาณที่ขอซื้อได้!</p>') {
            $('#tbpritemdetail2temp-pritemonpcplan').val('7');
        } else {
            $('#tbpritemdetail2temp-pritemonpcplan').val('8');
        }
    }
    $("#tbpritemdetail2temp-pcplannum").val('<?= $model['PCPlanNum']; ?>').trigger("change");
</script>
