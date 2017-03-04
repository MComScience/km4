<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\chemo\models\std\TbMedicalRigth;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemo\models\std\TbCpoePeriodUnit;
use yii\helpers\Url;

$script1 = <<< JS
function SaveDraftSatndard() {
        var chemoid = $('#tbstdtrpchemo-std_trp_chemo_id').val();
        var status = '1';
        $.ajax({
            type: 'POST',
            url: 'index.php?r=chemos/standard/std-order-savedraft',
            data: {chemoid: chemoid, status: status},
            success: function (data) {

            }
        });
    }
    
    function SaveSatndard() {
        var chemoid = $('#tbstdtrpchemo-std_trp_chemo_id').val();
        var status = '2';
        $.ajax({
            type: 'POST',
            url: 'index.php?r=chemos/standard/std-order-savedraft',
            data: {chemoid: chemoid, status: status},
            success: function (data) {

            }
        });
    }
$('#btn-savedraft-cycle').click(function (e) {
        var frm = $('#form_regimen_cycle');
        var cycle = $('#tbdrugset-chemo_cycle_seq').val();
        var day = $('#tbdrugset-chemo_cycle_day').val();
        var Frequency = $('#tbdrugset-chemo_regimen_freq_unit :selected').val();
        if (day == '' || cycle == '' || Frequency == '') {
            //swal("Message Alert", "กรุณากรอกข้อมูลด้านบนที่มี * ให้ครบ", "warning");
            swal({
                title: "Message Alert",
                text: "กรุณากรอกข้อมูลด้านบนที่มี * ให้ครบ",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.pjax({container: '#drugdetdetail-pjax'});
                        }
                    });
        } else {
            SaveDraftSatndard();
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    swal({
                        title: "",
                        text: "SaveDraft Completed!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    document.getElementById("btn-save-cycle").disabled = false;
                                }
                            });
                }
            });
        }
    });

   $('#btn-save-cycle').click(function (e) {
        var frm = $('#form_regimen_cycle');
        var cycle = $('#tbdrugset-chemo_cycle_seq').val();
        var day = $('#tbdrugset-chemo_cycle_day').val();
        var Frequency = $('#tbdrugset-chemo_regimen_freq_unit :selected').val();
        if (day == '' || cycle == '' || Frequency == '') {
            //swal("Message Alert", "กรุณากรอกข้อมูลด้านบนที่มี * ให้ครบ", "warning");
            swal({
                title: "Message Alert",
                text: "กรุณากรอกข้อมูลด้านบนที่มี * ให้ครบ",
                type: "warning",
                showCancelButton: false,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.pjax({container: '#drugdetdetail-pjax'});
                        }
                    });
        } else {
            SaveSatndard();
            $.ajax({
                type: frm.attr('method'),
                url: 'index.php?r=chemos/standard/save-cycle',
                data: frm.serialize(),
                success: function (data) {
                    swal({
                        title: "",
                        text: "Save Completed!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    //$.pjax({container: '#drugdetdetail-pjax'});
                                }
                            });
                }
            });
        }
    });
JS;
$this->registerJs($script1);
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_regimen_cycle', 'action' => Url::to(['savedraft-cycle']),]); ?>
<div class="form-group">
    <?= Html::activeLabel($modelChemo, 'std_trp_chemo_id', ['label' => 'เลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelChemo, 'std_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>

    <?= Html::activeLabel($modelChemo, 'medical_right_id', ['label' => 'สิทธิ์การรักษา', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?=
        $form->field($modelChemo, 'medical_right_id', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbMedicalRigth::find()->all(), 'medical_right_id', 'medical_right_desc'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select Option', 'disabled' => true],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])
        ?>
    </div>

    <?= Html::activeLabel($modelChemo, 'dx_code', ['label' => 'Dx.', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelChemo, 'dx_code', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($modelChemo, 'std_trp_regimen_name', ['label' => 'Regimen.', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelChemo, 'std_trp_regimen_name', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>

    <?= Html::activeLabel($modelChemo, 'std_trp_regimen_paycode', ['label' => 'Payment Code.', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelChemo, 'std_trp_regimen_paycode', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>

    <?= Html::activeLabel($modelChemo, 'ca_stage_code', ['label' => 'Stage.', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelChemo, 'ca_stage_code', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($modelDrugset, 'chemo_cycle_seq', ['label' => 'Cycle. ' . '<span class="red">*</span>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'chemo_cycle_seq', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;', 'required' => true]); ?>
    </div>

    <?= Html::activeLabel($modelDrugset, 'chemo_cycle_day', ['label' => 'Day. ' . '<span class="red">*</span>', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'chemo_cycle_day', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;', 'required' => true]); ?>
    </div>

    <?= Html::activeLabel($modelDrugset, 'chemo_regimen_freq_value', ['label' => 'Frequency. ' . '<span class="red">*</span>', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($modelDrugset, 'chemo_regimen_freq_value', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99;', 'required' => true]); ?>
    </div>
    <div class="col-sm-2">
        <?=
        $form->field($modelDrugset, 'chemo_regimen_freq_unit', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbCpoePeriodUnit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select Option',],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])
        ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($modelChemo, 'std_trp_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-5">
        <?= $form->field($modelChemo, 'std_trp_comment', ['showLabels' => false])->textarea(['style' => 'background-color: #ffff99;', 'rows' => 3]); ?>
    </div>
</div>

<?= $form->field($modelDrugset, 'drugset_id', ['showLabels' => false])->hiddenInput([]); ?>
<?= $form->field($modelDrugset, 'drugset_status', ['showLabels' => false])->hiddenInput([]); ?>
<?php ActiveForm::end(); ?>