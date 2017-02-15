<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
?>

<?php
Modal::begin([
    "id" => "duplicateModal",
    'header' => '<h4 class="modal-title">Duplicate Chemo Cycle</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' ' . Html::a('Duplicate', 'javascript:void(0);', ['class' => 'btn btn-success', 'onclick' => 'Duplicate(this);']), // always need it for jquery plugin
    'options' => ['tabindex' => FALSE]
])
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'duplicate_form']); ?>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right"><?= Html::encode('Chemo Cycle'); ?></label>
    <div class="col-sm-5">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" id="minseq"><i class="glyphicon glyphicon-minus"></i></button>
            </span>
            <input class="form-control text-center" name="chemo_cycle_seq" required="" value="1" id="chemo_cycle_seq"/>
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" id="maxseq"><i class="glyphicon glyphicon-plus"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right"><?= Html::encode('Cycle Duplicate Qty.'); ?></label>
    <div class="col-sm-5">
        <div class="input-group">
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" id="mincycleqty"><i class="glyphicon glyphicon-minus"></i></button>
            </span>
            <input class="form-control text-center" name="chemo_cycle_qty" required="" value="1" id="chemo_cycle_qty"/>
            <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" id="maxcycleqty"><i class="glyphicon glyphicon-plus"></i></button>
            </span>
        </div>
    </div>
</div>
<input name="pt_trp_chemo_id" id="pt_trp_chemo_id" class="form-control" type="hidden"/>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>