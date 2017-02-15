<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

$script = <<< JS
var dateBefore = null;
$('#tbitemidprice-itempriceeffectivedate').datepicker({
    dateFormat: "dd/mm/yy",
    // constrainInput: true,
    //showOn: 'button',
    // buttonImageOnly: false,
    changeYear: true,
    changeMonth: true,
    //buttonImage: "asset/webengine/images/icons/b_calendar.png",
    dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
    monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
    beforeShow: function () {
        $(this).val('');
        if ($(this).val() != "") {
            var arrayDate = $(this).val().split("/");
            arrayDate[2] = parseInt(arrayDate[2]) - 543;
            $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
        }
        setTimeout(function () {
            $.each($(".ui-datepicker-year option"), function (j, k) {
                var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                $(".ui-datepicker-year option").eq(j).text(textYear);
            });
        }, 50);
    },
    onChangeMonthYear: function () {
        setTimeout(function () {
            $.each($(".ui-datepicker-year option"), function (j, k) {
                var textYear = parseInt($(".ui-datepicker-year option").eq(j).val()) + 543;
                $(".ui-datepicker-year option").eq(j).text(textYear);
            });
        }, 50);
    },
    onClose: function () {
        if ($(this).val() != "" && $(this).val() == dateBefore) {
            var arrayDate = dateBefore.split("/");
            arrayDate[2] = parseInt(arrayDate[2]) + 543;
            $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
        }
    },
    onSelect: function (dateText, inst) {
        dateBefore = $(this).val();
        var arrayDate = dateText.split("/");
        arrayDate[2] = parseInt(arrayDate[2]) + 543;
        $(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
    }
});

$('#from_additemprice').on('beforeSubmit', function(e)
    {
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'success')
            {
                    Gettableitemprice();
                    swal("Save Complete!", "", "success");
                    $('#from_additemprice').trigger('reset');
                    $('#modaladditem').modal('hide');
                    l.ladda('stop');
                    $.pjax.reload({container: '#tb_item_pjax_pricelisttpu'});
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    }); 
        
$("#tbitemidprice-itemprice").keyup(function () {
        $('input[id="tbitemidprice-itemprice"]').priceFormat({prefix: ''});
    });
JS;
$this->registerJs($script);
?>
<div class="well">
    <div class="tb-itemprice-form">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'from_additemprice']); ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'ItemID', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white',
                    'readonly' => true,
                ]);
                ?>
            </div>
        </div>    
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">รายละเอียด</label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="3" readonly="" style="background-color: white" id="tbitemprice-itemname"><?php echo $ItemName ?></textarea>
            </div>
        </div>
        <br>
        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemPrice', ['label' => 'ราคาขาย', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'ItemPrice', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right',
                    'value' => $itemprice,
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">หน่วย</label>
            <div class="col-sm-4">
                <input class="form-control" readonly="" id="tbitemprice-dispunit" style="background-color: white" value="<?php echo $DispUnit ?>"/>
            </div>
        </div>
        <br>
        <div class="form-group">
            <?= Html::activeLabel($model, 'ItemPriceEffectiveDate', ['label' => 'วันที่เริ่มใช้', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'ItemPriceEffectiveDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                    'language' => 'th',
                    'dateFormat' => 'dd/MM/yyyy',
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'style' => 'background-color: #ffff99',
                    ],
                ])
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10" style="text-align: right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>