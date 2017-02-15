<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
?>
<div class="well">
    <div class="tb-drugin-form">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_drugadminstration']); ?>
        <?=$form->errorSummary($model) ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TMTID_GPU', ['label' => 'รหัสยาสามัญ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'TMTID_GPU', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white',
                    'readonly' => true,
                    'value' => $tmtid_gpu,
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">ชื่อยาสามัญ</label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="3" readonly="" id="FSN_GPU" style="background-color: white"><?php echo $fsn_gpu ?></textarea>
            </div>
        </div>

        <br>

        <div class="form-group">
            <?= Html::activeLabel($model, 'DrugRouteID', ['label' => 'วิธีการให้ยา' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'DrugRouteID', ['showLabels' => false])->dropdownList(
                        yii\helpers\ArrayHelper::map(\app\modules\Inventory\models\Tbdrugroute::find()->all(), 'DrugRouteID', 'DrugRouteName'), [
                    'id' => 'ddl-drugroute',
                    'prompt' => '--- Select Option ---'
                ])->label();
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'DrugPrandialAdviceID', ['label' => 'คำแนะนำการให้ยา' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'DrugPrandialAdviceID', ['showLabels' => false])->widget(\kartik\widgets\DepDrop::classname(), [
                    'options' => ['id' => 'ddl-drugprand'],
                    'data' => [$drugroute],
                    'pluginOptions' => [
                        'depends' => ['ddl-drugroute'],
                        'placeholder' => '--- Select Option ---',
                        'prompt' => '--- Select Option ---',
                        'url' => Url::to(['/Inventory/additem/get-drugroute'])
                    ]
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'DrugRouteNote', ['label' => 'หมายเหตุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-7">
                <?= $form->field($model, 'DrugRouteNote', ['showLabels' => false])->textarea(['style' => 'background-color: #ffff99', 'rows' => 3]); ?>
            </div>
        </div>

        <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput(['style' => 'background-color: white',]); ?>

        <div class="form-group">
            <div class="col-sm-10" style="text-align: right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button','data-style' => 'expand-left']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
$('#form_drugadminstration').on('beforeSubmit', function (e)
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
                    text: "ไม่สามารถบันทึกข้อมูลการให้ยาซ้ำได้!",
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
            } else
            {
                l.ladda('stop');
                GettableDrugadmins();
                //Notify('Save Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
                //$.pjax.reload({container: '#tb_drugadminstration'});
                $('#form_drugadminstration').trigger('reset');
                $('#modaladd_drugin').modal('hide');
                Getdruglabel();/* เรียกใช้ function */
                swal("Save Complete!", "", "success");
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
