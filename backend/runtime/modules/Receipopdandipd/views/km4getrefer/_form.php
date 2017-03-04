<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETREFER */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="km4-getrefer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'REFER_HRECIEVE_DOC_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'REFER_HRECIEVE_DOC_DATE')->textInput() ?>

    <?= $form->field($model, 'REFER_HSENDER_DOC_ID')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DISEASE_CONDITION_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'REFER_HSENDER_CODE')->textInput() ?>

    <?= $form->field($model, 'REFER_HSENDER_SENT_TYPEID')->textInput() ?>

    <?= $form->field($model, 'REFER_HSENDER_DOC_START')->textInput() ?>

    <?= $form->field($model, 'REFER_HSENDER_DOC_EXPDATE')->textInput() ?>

    <?= $form->field($model, 'PT_HOSPITAL_NUMBER')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
