<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPATENT */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="km4-getpatent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'PT_MAININSCL_ID')->textInput() ?>

    <?= $form->field($model, 'PT_INSCLCARD_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_INSCLCARD_STARTDATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_INSCLCARD_EXPDATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PT_PURCHASEPROVINCE_ID')->textInput() ?>

    <?= $form->field($model, 'PT_SCL_UPDATE_DATE')->textInput() ?>

    <?= $form->field($model, 'PT_SCL_UPDATE_TIME')->textInput() ?>

    <?= $form->field($model, 'PT_HOSPITAL_NUMBER')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
