<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\pr\models\TbPackunit;
use kartik\widgets\Select2;
use kartik\icons\Icon;
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formitemdetails1', 'action' => Url::to(['save-itemdetails1']),]); ?>

        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'ItemID', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'value' => empty($itemList['ItemID']) ? $model['ItemID'] : $itemList['ItemID'],
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'TMTID_TPU', ['label' => 'รหัสยาการค้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'TMTID_TPU', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'value' => !empty($model['TMTID_TPU']) ? $model['TMTID_TPU'] : $itemList['TMTID_TPU'],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemName', ['label' => 'รายละเอียด', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-8">
                <?=
                $form->field($model, 'ItemName', ['showLabels' => false])->textarea([
                    'rows' => 3,
                    'readonly' => true,
                    'style' => 'background-color:#f9f9f9',
                    'value' => !empty($itemList['FSN_TMT']) ? $itemList['FSN_TMT'] : $itemList['ItemName'],
                ])
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::label('', '', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <h5 class="row-title"><i class="fa fa-list-alt"></i><?= Html::encode('รายละเอียดขอซื้อ') ?></h5>
            </div>
            <?= Html::label('', '', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <h5 class="row-title"><i class="fa fa-list-alt"></i><?= Html::encode('รายละเอียดสั่งซื้อ') ?></h5>
            </div>
        </div>

        <div class="form-group">
            <?= Html::label('', '', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3"></div>

            <?= Html::label(Html::encode('สั่งซื้อแบบ'), false, ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <div class="radio">
                    <label>
                        <?= Html::input('text', 'PacCin', '', ['type' => 'radio', 'id' => 'pac', 'value' => '1']) ?>
                        <?= Html::tag('span', Html::encode('แพค'), ['class' => 'text']) ?>
                    </label>
                    <label>
                        <?= Html::input('text', 'PacCin', '', ['type' => 'radio', 'id' => 'cin', 'value' => '0',]) ?>
                        <?= Html::tag('span', Html::encode('ชิ้น'), ['class' => 'text']) ?>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRPackQtyApprove', ['label' => 'จำนวนแพค', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRPackQtyApprove', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'POPackQtyApprove', ['label' => 'จำนวนแพค ' . '<span id="checkจำนวนแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POPackQtyApprove', ['showLabels' => false])->textInput([
                    'style' => 'text-align:right',
                        //'value' => empty($model['POPackQtyApprove']) ? number_format($model['PRPackQtyApprove'], 4) : number_format($model['POPackQtyApprove'], 4),
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelView, 'PRPackunit', ['label' => 'หน่วยแพค', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelView, 'PRPackunit', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'POItemPackID', ['label' => 'หน่วยแพค ' . '<span id="checkหน่วยแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TbPackunit::find()->where(['PackUnitID' => $ItemPackUnit])->all(), 'PackUnitID', 'PackUnit'),
                    'language' => 'en',
                    'pluginOptions' => [
                        'placeholder' => 'เลือกหน่วยแพค',
                        'allowClear' => true,
                    ],
                ])
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'PackID', ['showLabels' => false])->hiddenInput(['value' => !empty($model['POItemPackID']) ? $model['POItemPackID'] : null]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelView, 'ItemPackSKUQty', ['label' => 'ปริมาณ/แพค', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelView, 'ItemPackSKUQty', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'POSKUQty', ['label' => 'ปริมาณ/แพค', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POSKUQty', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'TMTID_GPU', ['showLabels' => false])->hiddenInput(['value' => !empty($model['TMTID_GPU']) ? $model['TMTID_GPU'] : $itemList['TMTID_GPU']]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRPackCostApprove', ['label' => 'ราคา/แพค', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRPackCostApprove', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'POPackCostApprove', ['label' => 'ราคา/แพค ' . '<span id="checkราคาต่อแพค"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POPackCostApprove', ['showLabels' => false])->textInput([
                    'style' => 'text-align:right',
                        //'value' => empty($model['POPackCostApprove']) ? number_format($model['PRPackCostApprove'], 4) : number_format($model['POPackCostApprove'], 4),
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'POID', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRApprovedOrderQty', ['label' => 'จำนวน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRApprovedOrderQty', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'POApprovedOrderQty', ['label' => 'จำนวน ' . '<span id="checkขอซื้อ"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POApprovedOrderQty', ['showLabels' => false])->textInput([
                    'style' => 'text-align:right',
                        //'value' => empty($model['POApprovedOrderQty']) ? number_format($model['PRApprovedOrderQty'], 4) : number_format($model['POApprovedOrderQty'], 4),
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'PRNum', ['showLabels' => false])->hiddenInput(); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelView, 'DispUnit', ['label' => 'หน่วย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelView, 'DispUnit', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($modelView, 'POUnit', ['label' => 'หน่วย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelView, 'POUnit', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                    'value' => $itemList['DispUnit'],
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'POItemType', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'PRApprovedUnitCost', ['label' => 'ราคาต่อหน่วย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'PRApprovedUnitCost', ['showLabels' => false])->textInput([
                    'readonly' => true,
                    'style' => 'background-color: #f9f9f9;text-align:right',
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'POApprovedUnitCost', ['label' => 'ราคาต่อหน่วย ' . '<span id="checkราคาต่อหน่วย"></span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POApprovedUnitCost', ['showLabels' => false])->textInput([
                    'style' => 'text-align:right',
                        //'value' => empty($model['POApprovedUnitCost']) ? number_format($model['PRApprovedUnitCost'], 4) : number_format($model['POApprovedUnitCost'], 4),
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'PRTypeID', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::label('', '', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">

            </div>

            <?= Html::activeLabel($model, 'POExtenedCost', ['label' => 'ราคารวม ' . '<font color="red">*</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'POExtenedCost', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right',
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'POItemNum', ['showLabels' => false])->hiddenInput([]); ?>
            </div>
        </div>

        <div class="col-md-12">
            <div class="modal-footer">
                <?php echo Html::button(Icon::show('remove', [], Icon::BSG) . 'Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']); ?>
                <?php echo Html::submitButton($model->isNewRecord ? Icon::show('floppy-disk', [], Icon::BSG) . 'Save' : Icon::show('floppy-disk', [], Icon::BSG) . 'Save', ['class' => $model->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'data-style' => 'slide-down']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#tbpoitemdetail2temp-prtypeid').val($('#tbpr2-prtypeid').val());
        /* Decimal Input*/
        $('#tbpoitemdetail2temp-poid').val($('#tbpo2temp-poid').val());
        $('#tbpoitemdetail2temp-prnum').val($('#tbpr2-prnum').val());
        $('#tbpoitemdetail2temp-popackqtyapprove').autoNumeric('init', {mDec: '4'});//จำนวนแพค
        $('#tbpoitemdetail2temp-popackcostapprove').autoNumeric('init', {mDec: '4'});//ราคาต่อแพค
        $('#tbpoitemdetail2temp-poapprovedorderqty').autoNumeric('init', {mDec: '4'});//จำนวน
        $('#tbpoitemdetail2temp-poapprovedunitcost').autoNumeric('init', {mDec: '4'});//ราคาต่อหน่วย
        $('#tbpoitemdetail2temp-poextenedcost').autoNumeric('init', {mDec: '4'});//ราคารวม
        /*  */
        GetSKU();
        /* Check แพค/ชิ้น */
        var popackqty = $("#tbpoitemdetail2temp-popackqtyapprove").val();
        if (popackqty === "" || popackqty === 0) {
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
        $("#tbpoitemdetail2temp-popackqtyapprove,#tbpoitemdetail2temp-popackcostapprove").removeAttr('readonly');
        $("#tbpoitemdetail2temp-poitempackid").removeAttr('disabled');

        $("#tbpoitemdetail2temp-poapprovedorderqty,#tbpoitemdetail2temp-poapprovedunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#tbpoitemdetail2temp-popackqtyapprove,#tbpoitemdetail2temp-popackcostapprove').css('background-color', '#FFFF99');
        $('#tbpoitemdetail2temp-poapprovedorderqty,#tbpoitemdetail2temp-poapprovedunitcost').css('background-color', '#f5f5f5');
    }
    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#tbpoitemdetail2temp-popackqtyapprove,#tbpoitemdetail2temp-popackcostapprove").attr('readonly', 'readonly');
        $("#tbpoitemdetail2temp-poitempackid").attr('disabled', 'disabled');
        $("#tbpoitemdetail2temp-poapprovedorderqty,#tbpoitemdetail2temp-poapprovedunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#tbpoitemdetail2temp-poapprovedorderqty,#tbpoitemdetail2temp-poapprovedunitcost').css('background-color', '#FFFF99');
        $('#tbpoitemdetail2temp-popackqtyapprove,#tbpoitemdetail2temp-popackcostapprove').css('background-color', '#f5f5f5');
    }

    /* คำนวณจำนวน */
    $("#tbpoitemdetail2temp-poapprovedorderqty").keyup(function () {
        var poorderqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//จำนวน
        var pounitcost = parseFloat($("#tbpoitemdetail2temp-poapprovedunitcost").val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var prapprovedorderqty = parseFloat($("#tbpoitemdetail2temp-prapprovedorderqty").val().replace(/[,]/g, "")) || null;
        if ((poorderqty > prapprovedorderqty) && (prapprovedorderqty !== null)) {
            swal("Oops!", "เกินจำนวนขอซื้อ!", "error");
            $(this).val(prapprovedorderqty);
            addTotal(prapprovedorderqty * pounitcost);
        } else {
            var total = poorderqty * pounitcost;
            addTotal(total);
        }
    });

    /* คำนวณราคาต่อหน่วย */
    $("#tbpoitemdetail2temp-poapprovedunitcost").keyup(function () {
        var pounitcost = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var poorderqty = parseFloat($("#tbpoitemdetail2temp-poapprovedorderqty").val().replace(/[,]/g, "")) || 0;//จำนวน
        var poapprovedunitcost = parseFloat($("#tbpoitemdetail2temp-prapprovedunitcost").val().replace(/[,]/g, "")) || null;
        if ((pounitcost > poapprovedunitcost) && (poapprovedunitcost !== null)) {
            swal("Oops!", "เกินราคาต่อหน่วยขอซื้อ!", "error");
            $(this).val(poapprovedunitcost);
            addTotal(poapprovedunitcost * poorderqty);
        } else {
            var total = pounitcost * poorderqty;
            addTotal(total);
        }
    });

    function addTotal(total) {
        if (total > 0) {
            $("#tbpoitemdetail2temp-poextenedcost").val(addCommas(total.toFixed(4)));//รวมเป็นเงิน
        } else {
            $("#tbpoitemdetail2temp-poextenedcost").val('0.0000');//รวมเป็นเงิน
        }
    }

    //คำนวณจำนวนแพค
    $("#tbpoitemdetail2temp-popackqtyapprove").keyup(function () {
        var popackqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;
        var itempackskuqty = parseFloat($("#tbpoitemdetail2temp-poskuqty").val().replace(/[,]/g, "")) || 0;
        var pounitcost = parseFloat($("#tbpoitemdetail2temp-poapprovedunitcost").val().replace(/[,]/g, "")) || 0;
        var poorderqty = popackqty * itempackskuqty;
        var Total = poorderqty * pounitcost;
        if (isNaN(poorderqty)) {
            $("#tbpoitemdetail2temp-poapprovedorderqty").val(addCommas(popackqty.toFixed(4)));
        } else {
            $("#tbpoitemdetail2temp-poapprovedorderqty").val(addCommas(poorderqty.toFixed(4)));
        }
        if (!isNaN(Total)) {
            $("#tbpoitemdetail2temp-poextenedcost").val(addCommas(Total.toFixed(4)));
        }
    });

    //คำนวณราคาต่อแพค
    $("#tbpoitemdetail2temp-popackcostapprove").keyup(function () {/* ราคา/แพค */
        var itempackcost = $(this).val().replace(/[,]/g, "") || 0;
        var itempackskuqty = parseFloat($("#tbpoitemdetail2temp-poskuqty").val().replace(/[,]/g, "")) || 0; //ปริมาณต่อแพค
        var poorderqty = parseFloat($("#tbpoitemdetail2temp-poapprovedorderqty").val().replace(/[,]/g, "")) || 0;/* จำนวน */

        var pounitcost = itempackcost / itempackskuqty;//หาราคาต่อหน่วย
        var poextendedcost = pounitcost * poorderqty; //หาราคารวม
        if (!isNaN(pounitcost)) {
            $("#tbpoitemdetail2temp-poapprovedunitcost").val(addCommas(pounitcost.toFixed(4)));
        }

        if (!isNaN(poextendedcost)) {
            $("#tbpoitemdetail2temp-poextenedcost").val(addCommas(poextendedcost.toFixed(4)));
        }
    });

    /* คำนวณ on chang หน่วยแพค */
    $('#tbpoitemdetail2temp-poitempackid').on('change', function () {
        var ItemPackUnit = $(this).find("option:selected").val();
        var ItemID = $("#tbpoitemdetail2temp-itemid").val();
        var POPackQty = parseFloat($("#tbpoitemdetail2temp-popackqtyapprove").val().replace(/[,]/g, "")) || 0;
        var ItemPackCost = parseFloat($("#tbpoitemdetail2temp-popackcostapprove").val().replace(/[,]/g, "")) || 0;
        var Type = 'OnChange';
        if (ItemPackUnit !== '') {
            $.ajax({
                url: '<?= Url::to(['get-skuqty']); ?>',
                type: "POST",
                data: {ItemPackUnit: ItemPackUnit, ItemID: ItemID, POPackQty: POPackQty, ItemPackCost: ItemPackCost, Type: Type},
                dataType: 'json',
                success: function (result) {
                    $('#tbpoitemdetail2temp-packid').val(result.ItemPackID);
                    $('#tbpoitemdetail2temp-poskuqty').val(result.ItemPackSKUQty);//ปริมาณต่อแพค
                    $('#tbpoitemdetail2temp-poapprovedorderqty').val(addCommas((result.POOrderQty).toFixed(4)));
                    $("#tbpoitemdetail2temp-poapprovedunitcost").val(addCommas((result.POUnitCost).toFixed(4)));
                    $("#tbpoitemdetail2temp-poextenedcost").val(addCommas((result.Total).toFixed(4)));
                }
            });
        } else {
            $('#tbpoitemdetail2temp-packid').val(null);
            $('#tbpoitemdetail2temp-poskuqty').val(null);//ปริมาณต่อแพค
            $('#tbpoitemdetail2temp-poapprovedorderqty').val(null);
            $("#tbpoitemdetail2temp-poapprovedunitcost").val(null);
            $("#tbpoitemdetail2temp-poextenedcost").val(null);
            $("#tbpoitemdetail2temp-popackcostapprove").val(null);
        }
    });

    function GetSKU() {
        var PackID = $("#tbpoitemdetail2temp-packid").val();
        var Type = 'OnEdit';
        if (PackID !== '') {
            $.ajax({
                url: '<?= Url::to(['get-skuqty']); ?>',
                type: "POST",
                data: {PackID: PackID, Type: Type},
                dataType: 'json',
                success: function (result) {
                    $('#tbpoitemdetail2temp-poskuqty').val(result.ItemPackSKUQty);//ปริมาณต่อแพค
                    $("#tbpoitemdetail2temp-poitempackid").val(result.ItemPackUnit).trigger("change");
                }
            });
        }
    }

    $('#formitemdetails1').on('beforeSubmit', function (e)
    {
        var form = $(this);
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.post(
                form.attr("action"), // serialize Yii2 form
                form.serialize()
                )
                .done(function () {
                    swal({
                        title: "Save Completed!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: "OK",
                        closeOnConfirm: true
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $('#modal-table-tpu').modal('hide');
                                    $('#modal-from').modal('hide');
                                    swal.close();
                                    l.ladda('stop');
                                    if (<?= (empty($model->POItemType)) || ($model->POItemType == 2) ? '2' : '1' ?> === 1) {
                                        $.pjax.reload({container: '#po_detail_1'});
                                    } else {
                                        $.pjax.reload({container: '#po_detail_2'});
                                    }

                                }
                            });
                })
                .fail(function (xhr, status, error)
                {
                    l.ladda('stop');
                    swal(error, "", "error");
                    console.log(error);
                });
        return false;
    });
</script>