<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model firdows\menu\models\MenuCategory */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-palegreen">
                <div class="widget-caption"><div class="panel-title"><i class="widget-icon fa fa-tasks themeprimary"></i><?= Html::encode($this->title) ?></div></div>
            </div>
            <div class="widget-body">
                <div class="menu-category-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'discription')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'status')->dropDownList([ 1 => '1', 0 => '0',], ['prompt' => '']) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('menu', 'Create') : Yii::t('menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

