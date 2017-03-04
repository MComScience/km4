<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTOPD */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="km4-getptopd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PT_HOSPITAL_NUMBER')->textInput() ?>

    <?= $form->field($model, 'PT_TITLENAME_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_FNAME_TH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_LNAME_TH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_DOB')->textInput() ?>

    <?= $form->field($model, 'PT_SEX_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_NATION_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_CID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_REGISTRY_DATE')->textInput() ?>

    <?= $form->field($model, 'PT_REGISTRY_TIME')->textInput() ?>

    <?= $form->field($model, 'PT_REGISTRY_BY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_SERVICE_INCOMING_ID')->textInput() ?>

    <?= $form->field($model, 'PT_SERVICE_SECTION_ID')->textInput() ?>

    <?= $form->field($model, 'PT_SERVICE_DOCTOR_ID')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
