<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTADMITSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="km4-getptadmit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PT_HOSPITAL_NUMBER') ?>

    <?= $form->field($model, 'PT_TITLENAME_ID') ?>

    <?= $form->field($model, 'PT_FNAME_TH') ?>

    <?= $form->field($model, 'PT_LNAME_TH') ?>

    <?= $form->field($model, 'PT_DOB') ?>

    <?php // echo $form->field($model, 'PT_SEX_ID') ?>

    <?php // echo $form->field($model, 'PT_NATION_ID') ?>

    <?php // echo $form->field($model, 'PT_CID') ?>

    <?php // echo $form->field($model, 'PT_ADMISSION_NUMBER') ?>

    <?php // echo $form->field($model, 'PT_REGISTRY_DATE') ?>

    <?php // echo $form->field($model, 'PT_REGISTRY_TIME') ?>

    <?php // echo $form->field($model, 'PT_REGISTRY_BY') ?>

    <?php // echo $form->field($model, 'PT_SERVICE_SECTION_ID') ?>

    <?php // echo $form->field($model, 'PT_SERVICE_FROM_SECTION_ID') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
