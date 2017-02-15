<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php
$form = ActiveForm::begin([
            'id' => 'searchhn-form',
            'options' => ['class' => 'form-horizontal'],
        ])
?>
<div class="form-group">
    <label class="col-sm-1 control-label no-padding-right">ค้นหา</label>
    <div class="col-sm-4">
        <?= Html::input('text', 'HN', '', ['class' => 'form-control','placeholder' => 'กรอกรหัส HN','autofocus' => true]) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
<script type="text/javascript">
$('#searchhn-form').on('beforeSubmit', function (e){
    e.preventDefault();
    var dataArray = $(this).serializeArray(),
                dataObj = {};
        $(dataArray).each(function (i, field) {
            dataObj[field.name] = field.value;
        });
        console.log(dataObj['HN']);
    return false;
});
</script>