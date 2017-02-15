<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;
use kartik\icons\Icon;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'fromdetails']); ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TMTID_TPU', ['label' => 'รหัสยาการค้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'TMTID_TPU', ['showLabels' => false])->textInput([
                    'value' => empty($model['TMTID_TPU']) ? $query['TMTID_TPU'] : $model['TMTID_TPU'],
                    'readonly' => true,
                    'style' => 'background-color: #f5f5f5;'
                ]);
                ?>
            </div>
            <div class="col-sm-2">
               
            </div>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'FSN_TMT', ['label' => 'รายละเอียดยาการค้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-8">
                <?=
                $form->field($model, 'FSN_TMT', ['showLabels' => false])->textarea([
                    'rows' => 4,
                    'value' => $query['FSN_TMT'],
                    'readonly' => true,
                    'style' => 'background-color: #f5f5f5;'
                ]);
                ?>
            </div>
        </div>
        <div class="form-group" >
            <?= Html::activeLabel($model, 'PCPlanItemEffectDate', ['label' => 'วันที่เริ่มใช้' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right',]) ?>
            <div class="col-sm-3">
                <?php
                echo $form->field($model, 'PCPlanItemEffectDate', [
                    'showLabels' => false,
                    'addon' => [
                        'prepend' => ['content' => '<i class="glyphicon glyphicon-calendar"></i>'],
                    ],
                ])->widget(DatePicker::classname(), [
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
                ]);
                ?>
            </div>
            <div class="col-sm-2">
                <?=
                $form->field($model, 'PCPlanNum', ['showLabels' => false])->hiddenInput([]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TPUOrderQty', ['label' => 'จำนวน' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'TPUOrderQty', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right;',
                    'autofocus' => true,
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TPUUnitCost', ['label' => 'ราคา/หน่วย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'TPUUnitCost', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #ffff99;text-align:right;'
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'DispUnit', ['label' => 'หน่วย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'DispUnit', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #f5f5f5;text-align:right;',
                    'value' => $query['DispUnit'],
                    'readonly' => true,
                ]);
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TPUExtendedCost', ['label' => 'รวมเป็นเงิน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'TPUExtendedCost', ['showLabels' => false])->textInput([
                    'style' => 'background-color: #f5f5f5;text-align:right;',
                    'readonly' => true,
                    'value' => number_format($model['TPUExtendedCost'], 2)
                ]);
                ?>
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
        $('#tbpcplantpudetail-tpuorderqty').autoNumeric('init');
        $('#tbpcplantpudetail-tpuunitcost').autoNumeric('init');
    });
    /* คำนวณจำนวน */
    $("#tbpcplantpudetail-tpuorderqty").keyup(function () {
        var gpuorderqty = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//จำนวน
        var gpuunitcost = parseFloat($("#tbpcplantpudetail-tpuunitcost").val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var total = (gpuorderqty * gpuunitcost);
        addTotal(total);
    });
    /* คำนวณราคาต่อหน่วย */
    $("#tbpcplantpudetail-tpuunitcost").keyup(function () {
        var gpuunitcost = parseFloat($(this).val().replace(/[,]/g, "")) || 0;//จำนวน
        var gpuorderqty = parseFloat($("#tbpcplantpudetail-tpuorderqty").val().replace(/[,]/g, "")) || 0;//ราคาต่อหน่วย
        var total = (gpuorderqty * gpuunitcost);
        addTotal(total);
    });
    function addTotal(total) {
        if (total > 0) {
            $("#tbpcplantpudetail-tpuextendedcost").val(addCommas(total.toFixed(2)));//รวมเป็นเงิน
        } else {
            $("#tbpcplantpudetail-tpuextendedcost").val('0.00');//รวมเป็นเงิน
        }
    }
    $('#fromdetails').on('beforeSubmit', function (e)
    {
        var form = $(this);
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        $.post(
                form.attr("action"), // serialize Yii2 form
                form.serialize()
                )
                .done(function (result) {
                    l.ladda('stop');
                    GettableDetails();
                    swal({
                        title: "Save Completed!",
                        text: "",
                        type: "success",
                        showCancelButton: false,
                        confirmButtonText: "OK",
                        closeOnConfirm: true,
                        closeOnCancel: true,
                        showLoaderOnConfirm: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    $('#tpu-modal').modal('hide');

                                }
                            });
                }).fail(function (xhr, status, error)
        {
            l.ladda('stop');
            swal(error, "", "error");
        });
        return false;
    });
</script>
