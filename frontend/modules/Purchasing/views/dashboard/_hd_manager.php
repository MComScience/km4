<?php
//use common\components\beyondadmin\assets\AvatarAsset;
use dektrium\user\assets\AvatarAsset;
use yii\helpers\Html;

AvatarAsset::register($this);
//$Count = app\modules\Purchasing\models\VwdashbaordInvpur::find()->all();
$avatar = ($userAvatar = Yii::$app->user->identity->getAvatar('large',Yii::$app->user->identity->id)) ? $userAvatar : AvatarAsset::getDefaultAvatar('admin');
?>

<div class="profile-header row">
    <div class="col-lg-2 col-md-4 col-sm-12 text-center">
        <img class="header-avatar" src="<?= $avatar ?>">
    </div>
    <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
        <div class="header-fullname"><?= Html::encode('ผู้บริหาร') ?></div>
        <div class="header-information">
            <?= Html::encode('User ID : ') . Yii::$app->user->identity->profile->user_id ?>
        </div>
        <div class="header-information">
            <?= Html::encode('User Name : ') . Yii::$app->user->identity->profile->VenderName ?>
        </div>
    </div>
    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 inlinestats-col success">

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 inlinestats-col success">

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 inlinestats-col success">

            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats-col">
                <div class="stats-value pink"></div>
                <div class="stats-title"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats-col">
                <div class="stats-value pink"><?php // echo $Count[0]['PROnProcess']; ?></div>
                <div class="stats-title">PR On Process</div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats-col">
                <div class="stats-value pink"><?php // echo $Count[0]['Purchasing']; ?></div>
                <div class="stats-title">Purchase Order</div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats-col">
                <div class="stats-value pink"><?php // echo $Count[0]['ItemBelowReorderpoint']; ?></div>
                <div class="stats-title">Item Below Re-Order Point</div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats-col">
                <div class="stats-value pink"><?php // echo $Count[0]['PRForPO']; ?></div>
                <div class="stats-title">PR For PO</div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 stats-col">
                <div class="stats-value pink"><?php // echo $Count[0]['PuchasingOverDueDate']; ?></div>
                <div class="stats-title">Over Due Date</div>
            </div>
        </div>

    </div>
</div>