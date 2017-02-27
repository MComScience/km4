<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwNhsoArSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="VwFiNhsoInv">
	<?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'action' => ['index'],
                'method' => 'get',
                'options' => ['data-pjax' => true]
    ]);
    ?>
    <div class="form-group" >
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="input-group">
        <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
        <span class="input-group-btn">
            <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ค้นหา', ['class' => 'btn btn-default', 'id' => 'btn_Search']) ?>
        </span>
    </div>
    </div>
  <?php ActiveForm::end(); ?>
</div>
<script>

</script>