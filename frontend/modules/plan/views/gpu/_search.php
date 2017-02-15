<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\plan\models\TbPcplanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-pcplan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PCPlanNum') ?>

    <?= $form->field($model, 'PCPOContactID') ?>

    <?= $form->field($model, 'PCPlanDate') ?>

    <?= $form->field($model, 'DepartmentID') ?>

    <?= $form->field($model, 'SectionID') ?>

    <?php // echo $form->field($model, 'PCPlanTypeID') ?>

    <?php // echo $form->field($model, 'PCPlanBeginDate') ?>

    <?php // echo $form->field($model, 'PCPlanEndDate') ?>

    <?php // echo $form->field($model, 'PCPlanStatusID') ?>

    <?php // echo $form->field($model, 'PCPlanCreatedBy') ?>

    <?php // echo $form->field($model, 'PCPlanCreatedDate') ?>

    <?php // echo $form->field($model, 'PCPlanCreatedTime') ?>

    <?php // echo $form->field($model, 'Pcplandrugandnondrug') ?>

    <?php // echo $form->field($model, 'PCVendorID') ?>

    <?php // echo $form->field($model, 'PCPlanTotal') ?>

    <?php // echo $form->field($model, 'PCPlanApproveBy') ?>

    <?php // echo $form->field($model, 'PCPlanApproveDate') ?>

    <?php // echo $form->field($model, 'PCPlanApproveTime') ?>

    <?php // echo $form->field($model, 'PCPlanManagerApproveBy') ?>

    <?php // echo $form->field($model, 'PCPlanManagerApproveDate') ?>

    <?php // echo $form->field($model, 'PCPlanManagerApproveTime') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
