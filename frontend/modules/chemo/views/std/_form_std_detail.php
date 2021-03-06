<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemo\models\std\TbCpoePeriodUnit;
use yii\helpers\Url;

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
            url: 'index.php?r=chemo/std/savechemo-orderset',
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
<div class="well">
    <div class="form-group">
        <?= Html::activeLabel($model, 'chemo_cycle_seq', ['label' => 'Cycle', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_cycle_seq', ['showLabels' => false])->textInput(['style' => 'background-color: #ffffff;']); ?>
        </div>

        <?= Html::activeLabel($model, 'chemo_cycle_day', ['label' => 'Day', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_cycle_day', ['showLabels' => false])->textInput(['style' => 'background-color: #ffffff;']); ?>
        </div>

        <?= Html::activeLabel($model, 'chemo_regimen_freq_value', ['label' => 'Frequency', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_regimen_freq_value', ['showLabels' => false])->textInput(['style' => 'background-color: #ffffff;']); ?>
        </div>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'chemo_regimen_freq_unit', ['showLabels' => false])->widget(Select2::classname(), [
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
</div>
<?php
echo $this->render('_grid_details', [
    'keepProvider' => $keepProvider,
    'premedProvider' => $premedProvider,
    'ivProvider' => $ivProvider,
    'medicatProvider' => $medicatProvider,
    'model' => $model,
    'drugset_id' => $drugset_id,
]);
?> 
<br/>
<div class="form-group">
    <?= Html::activeLabel($model, 'std_trp_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'std_trp_comment', ['showLabels' => false])->textarea(['rows' => 4]); ?>
    </div>
</div>

<div class="form-group" style="text-align: right">
    <div class="col-sm-12">
        <?= Html::a('Close', ['/chemo/std/standard-index','id' => $model['std_trp_chemo_id']], ['class' => 'btn btn-default']); ?>
        <?= Html::submitButton($model->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
        <?= Html::button('Add Order Set', [ 'class' => 'btn btn-success', 'id' => 'btn-addorderset']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
