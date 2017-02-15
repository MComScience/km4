<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\chemo\models\VwUserprofile;

$script1 = <<< JS
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=pharmacy/rxorder/delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#cpoedetail-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#cpoedetail-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});  
 
JS;
$this->registerJs($script1);
?>
<style>
    table.default thead tr th{
        background-color: white;
        text-align: center;
    }
</style>
<div class="tb-cpoe-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_rxorder', 'action' => Url::to(['save-rxorder']),]); ?>

    <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput() ?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'ใบสั่งยาเลขที่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-2">
            <?= $form->field($model, 'cpoe_num', ['showLabels' => false])->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>

        <?= Html::activeLabel($model, 'cpoe_date', ['label' => 'วันที่', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
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

        <?= Html::activeLabel($model, 'cpoe_order_by', ['label' => 'แพทย์', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
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

    <div class="form-group">
        <?= Html::activeLabel($model, 'cpoe_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-5">
            <?= $form->field($model, 'cpoe_comment', ['showLabels' => false])->textarea(['rows' => 2]); ?>
        </div>
    </div>
    
    <?= $form->field($model, 'pt_vn_number', ['showLabels' => false])->hiddenInput(); ?>

    <?php ActiveForm::end(); ?>

</div>
