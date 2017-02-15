<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
?>
<div class="well">
    <div class="tb-stk_levelinfo-form">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'from_addstklevel']); ?>
        <div class="form-group">
            <?= Html::activeLabel($modelstk, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelstk, 'ItemID', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white',
                    'readonly' => true,
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">รายละเอียด</label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="3" readonly="" style="background-color: white" id="fsn_gpu"></textarea>
            </div>
        </div>
        <br>

        <div class="form-group">
            <?= Html::activeLabel($modelstk, 'StkID', ['label' => 'คลังสินค้า' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <?php if ($edit == 'true') { ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelstk, 'StkID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(\app\models\Tbstk::find()->where(['StkID' => $modelstk['StkID']])->all(), 'StkID', 'StkName'),
                    'pluginOptions' => [
                        'placeholder' => '--- Select Option ---',
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <?php } else { ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modelstk, 'StkID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(\app\models\Tbstk::find()->all(), 'StkID', 'StkName'),
                        'pluginOptions' => [
                            'placeholder' => '--- Select Option ---',
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            <?php } ?>

        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelstk, 'ItemTargetLevel', ['label' => 'เป้าหมายการจัดเก็บ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelstk, 'ItemTargetLevel', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right',
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelstk, 'ItemReorderLevel', ['label' => 'จุดสั่งซื้อสินค้า' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelstk, 'ItemReorderLevel', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right',
                ]);
                ?>
            </div>
        </div>



        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">หน่วย</label>
            <div class="col-sm-4">
                <input class="form-control" id="dispunit" readonly="" style="background-color: white"/>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-sm-7" style="text-align: right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton($modelstk->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $modelstk->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$script = <<< JS
$('#from_addstklevel').on('beforeSubmit', function(e)
    {
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'false')
            {
                    swal({
                    title: "",
                    text: "จุดสั่งซื้อสินค้าต้องต่ำกว่าเป้าหมายการจัดเก็บ!",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                            }
                        });
            } else if(result == 'duplicate'){
                swal({
                    title: "",
                    text: "ไม่สามารถบันทึกข้อมูลการจัดเก็บซ้ำได้!",
                    type: "warning",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                            }
                        });
            }else{
                    GettableStklevel();
                    swal("Save Complete!", "", "success");
                    $('#from_addstklevel').trigger('reset');
                    $('#modaladditem').modal('hide');
                    l.ladda('stop');
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
$(function () {

    $("#tbstklevelinfo-itemreorderlevel").keyup(function () {
        $('input[id="tbstklevelinfo-itemreorderlevel"]').priceFormat({prefix: ''});
        var itemreorderlevel = parseFloat($("#tbstklevelinfo-itemreorderlevel").val().replace(/[,]/g, ""));
        var itemtargetlevel = parseFloat($("#tbstklevelinfo-itemtargetlevel").val().replace(/[,]/g, ""));
        if (itemtargetlevel != "") {
            if (itemreorderlevel > itemtargetlevel) {
                swal({
                    title: "",
                    text: "จุดสั่งซื้อสินค้าต้องต่ำกว่าเป้าหมายการจัดเก็บ!",
                    type: "warning",
                });
            }
        }
    });

    $("#tbstklevelinfo-itemtargetlevel").keyup(function () {
        $('input[id="tbstklevelinfo-itemtargetlevel"]').priceFormat({prefix: ''});
    });

}); 
        
//$('#tbstklevelinfo-stkid').on('change', function () {
//    var ItemID = $("#tbstklevelinfo-itemid").val();
//    var StkID = $(this).find("option:selected").val();
//    var StkText = $(this).find("option:selected").text();
//    if (StkID != '') {
//        $.ajax({
//            url: "index.php?r=Inventory/additem/checkdupstk",
//            type: "post",
//            data: {StkID: StkID, ItemID: ItemID},
//            dataType: 'json',
//            success: function (data) {
//                if (data != '') {
//                    swal({
//                        title: "",
//                        text: "คลังสินค้า> " + StkText + " <ถูกบันทึกไว้แล้ว!",
//                        type: "warning",
//                        showCancelButton: false,
//                        closeOnConfirm: true,
//                        closeOnCancel: true,
//                    },
//                            function (isConfirm) {
//                                if (isConfirm) {
//
//                                }
//                            });
//                }
//            }
//        });
//    }
//});
JS;
$this->registerJs($script);
?>
