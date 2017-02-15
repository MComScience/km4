<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <div class="loginbox-title">SIGN IN</div>
        <div class="loginbox-social">
            <div class="social-title ">Connect with Your Social Accounts</div>
            <div class="social-buttons">
                <a href="" class="button-facebook">
                    <i class="social-icon fa fa-facebook"></i>
                </a>
                <a href="" class="button-twitter">
                    <i class="social-icon fa fa-twitter"></i>
                </a>
                <a href="" class="button-google">
                    <i class="social-icon fa fa-google-plus"></i>
                </a>
            </div>
        </div>
        <div class="loginbox-or">
            <div class="or-line"></div>
            <div class="or">OR</div>
        </div>


        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <div class="col-sm-12">
            <?=
                    $form
                    ->field($model, 'username', $fieldOptions1)
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('username')])
            ?>

            <?=
                    $form
                    ->field($model, 'password', $fieldOptions2)
                    ->label(false)
                    ->passwordInput(['placeholder' => $model->getAttributeLabel('password')])
            ?>

            <?php $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
        <div class="loginbox-forgot">
            <a href="">Forgot Password?</a>
        </div>
        <div class="loginbox-submit">
            <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
        </div>
        <div class="loginbox-signup">
            <a href="register.html">Sign Up With Email</a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
