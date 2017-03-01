<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = Yii::t('user', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<br/>
<br/>

<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 0, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 1000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>
<div class="login-container animated fadeInDown">
    <div class="loginbox bg-white">
        <div class="loginbox-title"><?= Html::encode($this->title) ?></div>
        <div class="loginbox-or">
            <div class="or-line"></div>
            <div class="or">KM4</div>
        </div>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                    'options' => ['autocomplete' => 'off'],
                ])
        ?>
        <div class="col-md-12">
            <?=
            $form->field($model, 'login', [
                'feedbackIcon' => [
                    'prefix' => 'fa fa-',
                    'default' => 'user',
                    'success' => 'user-plus',
                    'error' => 'user-times',
                    'defaultOptions' => ['class' => 'text-warning']
                ]
            ])->textInput([
                'placeholder' => 'Username or Email',
            ])->label(FALSE);
            ?>
            <?=
                    $form->field($model, 'password', [
                        'feedbackIcon' => [
                            'prefix' => '',
                            'default' => 'glyphicon glyphicon-lock',
                            'success' => 'fa fa-unlock',
                            'error' => 'glyphicon glyphicon-lock',
                            'defaultOptions' => ['class' => 'text-warning']
                ]])->passwordInput(['placeholder' => 'Password'])
                    ->label(FALSE)
            ?>
        </div>
        <div class="col-md-12">
            <?= $module->enablePasswordRecovery ? ' (' . Html::a(Yii::t('user', 'Forgot password?'), ['/user/recovery/request'], ['tabindex' => '5']) . ')' : ''; ?>
        </div>

        <div class="col-md-12">
            <p></p>
            <?= Html::submitButton(Yii::t('user', 'Sign in'), ['class' => 'btn btn-success btn-block', 'tabindex' => '3']) ?>
            <p></p>
        </div>
        <?php ActiveForm::end(); ?>

        <div class="loginbox-signup">


            <?=
            Connect::widget([
                'baseAuthUrl' => ['/user/security/auth'],
            ])
            ?>
        </div>

    </div>
</div>
