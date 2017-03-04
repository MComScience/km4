<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use kartik\widgets\ActiveForm;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/**
 * @var yii\web\View 				$this
 * @var dektrium\user\models\User 	$user
 */
$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
     $('.active>a').css('background', '#65b951');
});        
JS;
$this->registerJs($script);
?>

<?=
$this->render('/_alert', [
    'module' => Yii::$app->getModule('user'),
])
?>

<?php // $this->render('_menu')  ?>

<div class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <?=
                Nav::widget([
                    'options' => [
                        'class' => 'nav-pills nav-stacked',
                    ],
                    'items' => [
                            ['label' => Yii::t('user', 'Account details'), 'url' => ['/user/admin/create']],
                            ['label' => Yii::t('user', 'Profile details'), 'options' => [
                                'class' => 'disabled',
                                'onclick' => 'return false;',
                            ]],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php /*
                  <div class="alert alert-info">
                  <?= Yii::t('user', 'Credentials will be sent to the user by email') ?>.
                  <?= Yii::t('user', 'A password will be generated automatically if not provided') ?>.
                  </div>
                 * 
                 */ ?>
                <?php
                $form = ActiveForm::begin([
                            'type' => 'horizontal',
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'fullSpan' => 8,
                            'formConfig' => [
                                'labelSpan' => 3,
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'showHints' => FALSE,
                            ]
                ]);
                ?>

                <?= $this->render('_user', ['form' => $form, 'user' => $user, 'scenario' => $scenario]) ?>

                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9" style="text-align: right">
                        <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
