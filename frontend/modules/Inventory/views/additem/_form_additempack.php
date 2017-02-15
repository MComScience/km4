<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
?>
<div class="well">
    <div class="tb-itempack-form">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'from_additempack']); ?>

        <div class="form-group">
            <?= Html::activeLabel($modelitempack, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelitempack, 'ItemID', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white',
                    'readonly' => true,
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">รายละเอียด</label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="3" readonly="" style="background-color: white" id="tbitempack-fsn_gpu"><?php echo $fsn_gpu ?></textarea>
            </div>
        </div>
        <br>
        <div class="form-group">
            <?= Html::activeLabel($modelitempack, 'ItemPackSKUQty', ['label' => 'ปริมาณบรรจุต่อแพค' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelitempack, 'ItemPackSKUQty', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99',
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">หน่วยการจ่าย(SKU)</label>
            <div class="col-sm-4">
                <input class="form-control" readonly="" id="tbitempack-dispunit" style="background-color: white" value="<?php echo $DispUnit ?>"/>
            </div>
        </div>
        <br>

        <div class="form-group">
            <?= Html::activeLabel($modelitempack, 'ItemPackUnit', ['label' => 'หน่วยแพค', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($modelitempack, 'ItemPackUnit', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(app\models\TbPackunit::find()->all(), 'PackUnitID', 'PackUnit'),
                    'pluginOptions' => [
                        'placeholder' => 'Select Option',
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelitempack, 'ItemPackDefault', ['label' => 'ใช้เป็นแพคหลัก', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-7">
                <?=
                        $form->field($modelitempack, 'ItemPackDefault', ['showLabels' => false])->radioList($modelitempack->getItemPackDefault(), ['inline' => true,'item' => function($index, $label, $name, $checked, $value) {
$check = $checked ? ' checked="checked"' : '';
                                    $return = '<label class="modal-radio">';
                                    $return .= '<input type="radio"  '.$check.' name="' . $name . '" value="' . $value . '" tabindex="3">';
                                    $return .= '<i></i>';
                                    $return .= '<span class="text">' . ucwords($label) . '</span>';
                                    $return .= '</label>';

                                    return $return;
                                }]);
                        
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelitempack, 'ItemPackBarcode', ['label' => 'แพค Barcode', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-7">
                <?=
                $form->field($modelitempack, 'ItemPackBarcode', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #FFFF99',
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($modelitempack, 'ItemPackNote', ['label' => 'หมายเหตุ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-7">
                <?=
                $form->field($modelitempack, 'ItemPackNote', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #FFFF99',
                ]);
                ?>
            </div>
        </div>
        <?= $form->field($modelitempack, 'TMTID_GPU', ['showLabels' => false])->hiddenInput([]); ?>
        <?= $form->field($modelitempack, 'ItemPackID', ['showLabels' => false])->hiddenInput([]); ?>

        <div class="form-group">
            <div class="col-sm-10" style="text-align: right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton($modelitempack->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $modelitempack->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button','data-style' => 'expand-left']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$script = <<< JS
$('#from_additempack').on('beforeSubmit', function (e)
{
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var e = document.getElementById("tbitempack-itempackunit");
    var Packunit = e.options[e.selectedIndex].text;
            var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'checkpack')
            {
                swal({
                    title: "",
                    text: "มีหน่วยแพค " + Packunit + " ที่ถูกบันทึกอยู่แล้ว!",
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
            } else if (result == 'packdefault') {
                swal({
                    title: "",
                    text: "ไม่สามารถใช้เป็นแพคหลักซ้ำกันได้!",
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
            }
            else
            {
                GettableItempack();
                swal("Save Complete!", "", "success");
                //$.pjax.reload({container: '#tb_drugadminstration'});
                $('#from_additempack').trigger('reset');
                $('#modaladditem').modal('hide');
                l.ladda('stop');
            }
        })
        .fail(function ()
        {
            console.log('server error');
        });
        return false;
});
      
JS;
$this->registerJs($script);
?>
