<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
#models
use app\modules\chemo\models\TbCpoePeriodUnit;

$script = <<< JS
/* Savedraft */
    $('#form_chemodetail').on('beforeSubmit', function (e)
    {
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        var form = $(this);
        $.post(
                form.attr('action'), // serialize Yii2 form
                form.serialize()
                )

                .done(function (result) {
                    if (result != "")
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
                                        //swal("Save Complete!", "", "success");
                                    }
                                });
                    }
                })
                .fail(function ()
                {
                    console.log('server error');
                })
        return false;
    });   

    $('#btn-addorderset').click(function (e) {
        var frm = $('#form_chemodetail');
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=chemos/pttrp/savechemo-orderset',
            data: frm.serialize(),
            success: function (data) {
                swal({
                    title: "",
                    text: "Add Order Set Complete!",
                    type: "success",
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
    });
JS;
$this->registerJs($script);
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'action' => Url::to(['save-chemodetail']),
            'method' => 'post',
            'id' => 'form_chemodetail',
        ]);
?>
<div class="form-group">
    <?= Html::activeLabel($model, 'chemo_regimen_ids', ['label' => 'Regimen ID', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'chemo_regimen_ids', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>

    <?= Html::activeLabel($model, 'chemo_cycle_seq', ['label' => 'Cycle', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'chemo_cycle_seq', ['showLabels' => false])->textInput(); ?>
    </div>

    <?= Html::activeLabel($model, 'chemo_cycle_day', ['label' => 'Day', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'chemo_cycle_day', ['showLabels' => false])->textInput(); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($model, 'pt_trp_regimen_name', ['label' => 'Regimen Name', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'pt_trp_regimen_name', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>

    <?= Html::activeLabel($model, 'chemo_regimen_freq_value', ['label' => 'Frequency', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'chemo_regimen_freq_value', ['showLabels' => false])->textInput(); ?>
    </div>

    <?= Html::activeLabel($model, 'chemo_regimen_freq_unit', ['label' => 'หน่วย', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?=
        $form->field($model, 'chemo_regimen_freq_unit', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(TbCpoePeriodUnit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
            'pluginOptions' => ['allowClear' => true],
            'options' => ['placeholder' => 'Select state...']
        ]);
        ?>
    </div>
</div>

<?php
echo $this->render('_grid-detail', [
    'model' => $model,
    'keepProvider' => $keepProvider, #เปิดเส้น
    'premedProvider' => $premedProvider, #Premed
    'ivProvider' => $ivProvider,
    'medicatProvider' => $medicatProvider, #Medical
    'drugsetid' => $drugsetid,
    'header' => $header,
])
?>
<p></p>
<div class="form-group">
    <?= Html::activeLabel($model, 'pt_trp_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'pt_trp_comment', ['showLabels' => false])->textarea(['rows' => 4]); ?>
    </div>
</div>

<?= $form->field($model, 'pt_visit_number', ['showLabels' => false])->hiddenInput(); ?>
<?= $form->field($model, 'drugset_id', ['showLabels' => false])->hiddenInput(['value' => $drugsetid]); ?>
<?= $form->field($model, 'drugset_ids', ['showLabels' => false])->hiddenInput(['value' => $drugset_ids]); ?>

<div class="form-group" style="text-align: right">
    <div class="col-sm-12">
        <?= Html::a('Close', ['treatmentindex', 'hn' => $header['pt_hospital_number'], 'vn' => $header['pt_visit_number']], ['class' => 'btn btn-default']); ?>
        <?= Html::submitButton($model->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
        <?= Html::button('Add Order Set', [ 'class' => 'btn btn-success', 'id' => 'btn-addorderset']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<script>
    
</script>