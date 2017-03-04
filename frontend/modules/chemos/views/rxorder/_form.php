<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemo\models\VwUserprofile;

$script = <<< JS
$('#form_cpoe').on('beforeSubmit', function (e)
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
                                        $('#tbcpoe-cpoe_num').val(result);
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
JS;
$this->registerJs($script);
?>
<div class="tb-cpoe-form">
    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'id' => 'form_cpoe',
                'action' => Url::to(['save-cpoe']),
    ]);
    ?>

    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_num', ['label' => 'ใบสั่งยาเลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'cpoe_num', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'pt_trp_chemo_id', ['label' => 'Treatment Paln No.', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'pt_trp_chemo_id', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'chemo_cycle_seq', ['label' => 'Cycle', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_cycle_seq', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'วันที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
            $form->field($model, 'cpoe_date', ['showLabels' => false])->widget(DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'class' => 'form-control',
                //'style' => 'background-color: #ffff99',
                ],
            ])
            ?>  
        </div>

        <?= Html::activeLabel($model, 'pt_trp_chemo_id', ['label' => 'Regimen', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'pt_trp_regimen_name', ['showLabels' => false])->textInput(['value' => $model->regimen->pt_trp_regimen_name, 'readonly' => true]); ?>
        </div>

        <?= Html::activeLabel($model, 'chemo_cycle_day', ['label' => 'Day', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'chemo_cycle_day', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_order_by', ['label' => 'แพทย์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?=
                $form->field($model, 'cpoe_order_by', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(VwUserprofile::find()->where(['User_jobid' => '3'])->all(), 'user_id', 'User_name'),
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Select state...',]
                ]);
                ?>
        </div>
    </div>

    <?=
    $this->render('_grid-detail', [
        'model' => $model,
        'header' => $header,
        'dataProvider' => $dataProvider,
        'premedProvider' => $premedProvider,
        'ivProvider' => $ivProvider,
        'medicatProvider' => $medicatProvider,
    ])
    ?>

    <p></p>
    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($model, 'cpoe_comment', ['showLabels' => false])->textarea(['rows' => 4]); ?>
        </div>
    </div>

    <?= $form->field($model, 'pt_vn_number', ['showLabels' => false])->hiddenInput(); ?>
    <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput(); ?>

    <div class="form-group" style="text-align: right">
        <div class="col-sm-12">
            <?= Html::a('Close', ['/chemos'], ['class' => 'btn btn-default']); ?>
            <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
            <?= Html::button('Order Sign', [ 'class' => 'btn btn-info']); ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    
</script>