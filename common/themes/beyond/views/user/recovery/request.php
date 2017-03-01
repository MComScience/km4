<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;


/*
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\RecoveryForm $model
 */

$this->title = Yii::t('user', 'Recover your password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <div class="loginbox-title"><?= Html::encode($this->title) ?></div>
        <div class="loginbox-or">
            <div class="or-line"></div>
            <div class="or">KM4</div>
        </div>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'password-recovery-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
        ]);
        ?>
        <div class="col-md-12">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder' => 'Email',])->label(false) ?> 
        </div>
        <div class="col-md-12">
            <?= Html::submitButton(Yii::t('user', 'Continue'), ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <div class="loginbox-signup">
            <br><br><br><br><br>
        </div>
    </div>
</div>