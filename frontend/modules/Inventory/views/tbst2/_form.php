<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSt2 */
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

<!--<div class="tb-st2-form">-->
        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-6">    <?= $form->field($model, 'STID')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STDate')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STNum')->textInput(['maxlength' => true]) ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STTypeID')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'SRNum')->textInput(['maxlength' => true]) ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STCreateBy')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STCreateDate')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STIssue_StkID')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STRecieve_StkID')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STRecievedDate')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STRecievedBy')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STStatus')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STPerson')->textInput() ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STNote')->textInput(['maxlength' => true]) ?>

</div><div class="col-sm-6">    <?= $form->field($model, 'STDueDate')->textInput() ?>

</div>                <div style="text-align: right;margin-right: 10px">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
