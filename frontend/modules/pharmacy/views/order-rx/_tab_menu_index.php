<?php
use yii\helpers\Html;
use yii\helpers\Url;
$action = Yii::$app->controller->action->id;
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success TabA <?php echo $action == 'index' ? 'active' : ''?>">
        <a href="<?= Url::to(['/pharmacy/order-rx/index']); ?>">
            <?= Html::encode('รายชื่อผู้ป่วยนอก'); ?>
        </a>
    </li>

    <li class="tab-success TabB <?php echo $action == 'order-status' ? 'active' : ''?>">
        <a href="<?= Url::to(['/pharmacy/order-rx/order-status']); ?>">
            <?= Html::encode('สถานะใบสั่งยา'); ?>
        </a>
    </li>

    <li class="tab-success TabC">
        <a data-toggle="tab" href="#TabC">
            <?= Html::encode('ใบสั่งยารออนุมัติ'); ?>
        </a>
    </li>
</ul>
