<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
#models
use app\modules\chemo\models\std\TbMedicalRigth;

$script = <<< JS
$('#formstd').on('beforeSubmit', function (e)
{
            var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )

            .done(function(result) {
            if (result == '1')
            {
                swal({
                    title: "Save Complete!",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                window.location.replace("index.php?r=chemo/std/standard-index&id=$model->std_trp_chemo_id");
                            }
                        });
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


<div class="tb-std-trp-chemo-form">

    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'id' => 'formstd',
                'action' => Url::to(['new-regimen']),
    ]);
    ?>

    <div class="form-group">
        <?= Html::activeLabel($model, 'std_trp_chemo_id', ['label' => 'เลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'std_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'dx_code', ['label' => 'Dx.', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'dx_code', ['showLabels' => false])->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'std_trp_regimen_name', ['label' => 'Regimen', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'std_trp_regimen_name', ['showLabels' => false])->textInput(); ?>
        </div>

        <?= Html::activeLabel($model, 'ca_stage_code', ['label' => 'CA Stage', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'ca_stage_code', ['showLabels' => false])->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-1"></div>
        <?= Html::activeLabel($model, 'regimen_for_cr', ['label' => 'ตามสิทธิ์การรักษา&nbsp;', 'class' => 'col-sm-2 control-label no-padding-right']) ?>

        <div class="col-sm-1">
            <?php
            if ($model->regimen_for_cr == 'Y') {
                $model->regimen_for_cr = true;
            } else {
                $model->regimen_for_cr = false;
            }
            ?>
            <?=
            $form->field($model, 'regimen_for_cr', ['showLabels' => false])->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'small', 'onText' => 'Yes', 'offText' => 'No'],
                'type' => SwitchInput::CHECKBOX,
            ]);
            ?>
        </div>
        <?php
        if ($model->std_trp_for_op == 'Y') {
            $model->std_trp_for_op = true;
        } else {
            $model->std_trp_for_op = false;
        }
        ?>
        <?= Html::activeLabel($model, 'std_trp_for_op', ['label' => 'ผู้ป่วยนอก&nbsp;', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-1">
            <?=
            $form->field($model, 'std_trp_for_op', ['showLabels' => false])->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'small', 'onText' => 'Yes', 'offText' => 'No'],
                'type' => SwitchInput::CHECKBOX,
            ]);
            ?>
        </div>
        <?php
        if ($model->std_trp_for_ip == 'Y') {
            $model->std_trp_for_ip = true;
        } else {
            $model->std_trp_for_ip = false;
        }
        ?>
        <?= Html::activeLabel($model, 'std_trp_for_ip', ['label' => 'ผู้ป่วยใน&nbsp;', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-1">
            <?=
            $form->field($model, 'std_trp_for_ip', ['showLabels' => false])->widget(SwitchInput::classname(), [
                'pluginOptions' => ['size' => 'small', 'onText' => 'Yes', 'offText' => 'No'],
                'type' => SwitchInput::CHECKBOX,
            ]);
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'medical_right_id', ['label' => 'สิทธิ์การรักษา', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($model, 'medical_right_id', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TbMedicalRigth::find()->all(), 'medical_right_id', 'medical_right_desc'),
                'language' => 'en',
                'options' => ['placeholder' => 'Select Option'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>

        <?= Html::activeLabel($model, 'std_trp_regimen_paycode', ['label' => 'Payment Code', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'std_trp_regimen_paycode', ['showLabels' => false])->textInput(); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'std_trp_comment', ['label' => 'Comment', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-9">
            <?= $form->field($model, 'std_trp_comment', ['showLabels' => false])->textarea(['rows' => 4]); ?>
        </div>
    </div>
    
    <?= $form->field($model, 'credit_group_id', ['showLabels' => false])->hiddenInput(); ?>

    <div class="form-group" style="text-align: right;">
        <div class="col-sm-12">
            <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    /*
     $(document).ready(function () {
     $('#tbstdtrpchemo-regimen_for_cr').on('switchChange.bootstrapSwitch', function (event, state) {
     if (state) {
     $('#tbstdtrpchemo-regimen_for_cr').val('Y');
     } else {
     $('#tbstdtrpchemo-regimen_for_cr').val('N');
     }
     });
     });*/
    $(document).ready(function () {
        $('#tbstdtrpchemo-medical_right_id').on('change', function () {
            var medical_right_id = $(this).find("option:selected").val();
            $.ajax({
                url: "index.php?r=chemo/std/get-creditgroup",
                type: "post",
                data: {id: medical_right_id},
                dataType: 'json',
                success: function (data) {
                    $('#tbstdtrpchemo-credit_group_id').val(data.medical_right_id);//ปริมาณต่อแพค
                }
            });
        });
    });
</script>