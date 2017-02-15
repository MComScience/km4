<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\AuthenticationandFinance\models\VwPtRegistedList */
/* @var $form yii\widgets\ActiveForm */
?>

<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?=
Html::encode($this->title);            ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">

<!--<div class="vw-pt-registed-list-form">-->
        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-6">    <?= $form->field($model, 'pt_visit_number')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'pt_hospital_number')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'pt_admission_number')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'pt_name')->textInput(['maxlength' => true]) ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'pt_status')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'pt_age_registry_date')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'pt_registry_date')->textInput() ?>

</div>                <div style="text-align: right;margin-right: 10px">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
