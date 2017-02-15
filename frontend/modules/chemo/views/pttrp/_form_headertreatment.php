<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\modules\chemo\models\TbMedicalRigth;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <?= Html::a('Select Regiment', ['/chemo/std/index','vn' => $model['pt_visit_number'],'ptid' => $model['pt_trp_chemo_id']], ['class' => 'btn btn-purple']); ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-12">
        <br>
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-treatment-header','action' => Url::to(['savetreatment-header']),]); ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'pt_trp_chemo_id', ['label' => 'แผนเลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'pt_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
            </div>

            <?= Html::activeLabel($model, 'pt_trp_cpr_number', ['label' => 'CPR No.', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'pt_trp_cpr_number', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'pt_trp_regimen_name', ['label' => 'Regimen', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'pt_trp_regimen_name', ['showLabels' => false])->textInput(); ?>
            </div>

            <?= Html::activeLabel($model, 'pt_trp_ocpa_number', ['label' => 'OCPA No.', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'pt_trp_ocpa_number', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'medical_right_id', ['label' => 'สิทธิ์การรักษา', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($model, 'medical_right_id', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TbMedicalRigth::find()->all(), 'medical_right_id', 'medical_right_desc'),
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Select state...']
                ]);
                ?>
            </div>

            <?= Html::activeLabel($model, 'pt_trp_regimen_paycode', ['label' => 'Payment Code', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?= $form->field($model, 'pt_trp_regimen_paycode', ['showLabels' => false])->textInput(); ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'pt_trp_comment', ['label' => 'Comment', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-8">
                <?= $form->field($model, 'pt_trp_comment', ['showLabels' => false])->textarea(['rows' => '4']); ?>
            </div>
        </div>

        <div class="form-group" style="text-align: right;">
            <div class="col-sm-10">
                <?= Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
                <?= Html::submitButton('Save', ['class' => 'btn btn-success ladda-button','data-style' => 'expand-left']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$script = <<< JS
$('#form-treatment-header').on('beforeSubmit', function (e)
    {
        var l = $('.ladda-button').ladda();
        l.ladda('start');
                var \$form = $(this);
                $.post(
                        \$form.attr('action'), // serialize Yii2 form
                        \$form.serialize()
                        )

                .done(function(result) {
                if (result == "success")
                {
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
                                    $.pjax.reload({container: '#treatmentindex-pjaxid'});
                                    $('#ajaxCrudModal').modal('hide');
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
