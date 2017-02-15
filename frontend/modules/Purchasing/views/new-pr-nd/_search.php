<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPr2TempSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tb-pr2-temp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'PRID') ?>

    <?= $form->field($model, 'PRNum') ?>

    <?= $form->field($model, 'PRDate') ?>

    <?= $form->field($model, 'DepartmentID') ?>

    <?= $form->field($model, 'SectionID') ?>

    <?php // echo $form->field($model, 'PRTypeID') ?>

    <?php // echo $form->field($model, 'PRReasonNote') ?>

    <?php // echo $form->field($model, 'POTypeID') ?>

    <?php // echo $form->field($model, 'POContactNum') ?>

    <?php // echo $form->field($model, 'PRExpectDate') ?>

    <?php // echo $form->field($model, 'VendorID') ?>

    <?php // echo $form->field($model, 'PRSubtotal') ?>

    <?php // echo $form->field($model, 'PRVat') ?>

    <?php // echo $form->field($model, 'PRTotal') ?>

    <?php // echo $form->field($model, 'PRSummitted') ?>

    <?php // echo $form->field($model, 'PRSummitedBy') ?>

    <?php // echo $form->field($model, 'PRSummitedDate') ?>

    <?php // echo $form->field($model, 'PRSummitedTime') ?>

    <?php // echo $form->field($model, 'PRStatusID') ?>

    <?php // echo $form->field($model, 'PRApprovalID') ?>

    <?php // echo $form->field($model, 'PRRejectID') ?>

    <?php // echo $form->field($model, 'PRCreatedBy') ?>

    <?php // echo $form->field($model, 'PRCreatedDate') ?>

    <?php // echo $form->field($model, 'PRCreatedTime') ?>

    <?php // echo $form->field($model, 'PRRejectDate') ?>

    <?php // echo $form->field($model, 'PRApprovaDate') ?>

    <?php // echo $form->field($model, 'PRApprovatime') ?>

    <?php // echo $form->field($model, 'PRStatus') ?>

    <?php // echo $form->field($model, 'PRRejectReason') ?>

    <?php // echo $form->field($model, 'PRRejectTime') ?>

    <?php // echo $form->field($model, 'PCPlanNum') ?>

    <?php // echo $form->field($model, 'ids_PR_selected') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
