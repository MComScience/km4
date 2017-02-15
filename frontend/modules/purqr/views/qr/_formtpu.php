<?php

use kartik\widgets\ActiveForm;
use kartik\helpers\Html;
use kartik\widgets\Select2;
use app\modules\purqr\models\TbPackunit;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right"></label>
    <div class="col-sm-4">
        <div class="radio">
            <label><input type="radio" name="pack"><span class="text">แพค</span></label>
            <label><input type="radio" name="pack"><span class="text">ชิ้น</span></label>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($model, 'QROrderQty', ['label' => 'ขอซื้อ', 'class' => 'col-sm-4 control-label no-padding-right']) ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'QROrderQty', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right">หน่วย</label>
    <div class="col-sm-4">
        <input class="form-control" value="<?= $query['DispUnit']; ?>"/>
    </div>
</div>
<p></p>
<div class="form-group">
    <?= Html::activeLabel($model, 'QRPackQty', ['label' => 'จำนวนแพค', 'class' => 'col-sm-4 control-label no-padding-right']) ?>
    <div class="col-sm-4">
        <?= $form->field($model, 'QRPackQty', ['showLabels' => false])->textInput(); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($model, 'ItemPackID', ['label' => 'หน่วยแพค', 'class' => 'col-sm-4 control-label no-padding-right']) ?>
    <div class="col-sm-4">
        <?=
        $form->field($model, 'ItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => yii\helpers\ArrayHelper::map(TbPackunit::find()->where(['PackUnitID' => $unitid])->all(), 'PackUnitID', 'PackUnit'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select Option'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])
        ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right">ปริมาณบรรจุต่อแพค</label>
    <div class="col-sm-4">
        <input class="form-control" id="ItemPackSKUQty"/>
    </div>
</div>
<?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput(['value' => $query['ItemID']]); ?>
<?= $form->field($model, 'QRID', ['showLabels' => false])->hiddenInput(['value' => $QRID]); ?>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
 $(document).ready(function () {
        $('#tbqritemdetail2new-itempackid').on('change', function () {
            var itemid = $('#tbqritemdetail2new-itemid').val();
            var PackUnitID = $(this).find("option:selected").val();
            if (PackUnitID != '') {
                $.ajax({
                    url: "index.php?r=purqr/qr/getqty",
                    type: "post",
                    data: {PackUnitID: PackUnitID, itemid: itemid},
                    dataType: 'json',
                    success: function (data) {
                        $('#ItemPackSKUQty').val(data);
                    }
                });
            }
        });
    });       
JS;
$this->registerJs($script);
?>
<script>
    
</script>