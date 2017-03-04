<?php
/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php
$form = ActiveForm::begin([
            //'layout' => 'horizontal',
            'type' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'fullSpan' => 8,
            'formConfig' => [
                'labelSpan' => 3,
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showHints' => FALSE,
            ],
//            'fieldConfig' => [
//                'horizontalCssClasses' => [
//                    'wrapper' => 'col-sm-5',
//                ],
//            ],
        ]);
?>

<?= $this->render('_user', ['form' => $form, 'user' => $user, 'scenario' => $scenario]) ?>

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9" style="text-align: right">
        <?php if ($user->profile->UserCatID == 2) { ?>
            <?= Html::a('Close', ['registration/index'], ['class' => 'btn btn-default']) ?>
        <?php } ?>
        <?php if ($user->profile->UserCatID == 1) { ?>
            <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
        <?php } ?>
        <?= Html::submitButton('Save', ['class' => 'btn  btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
