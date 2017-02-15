<?php

use yii\helpers\Html;
use yii\helpers\Url;

$action = Yii::$app->controller->action->id;
$ST1 = Yii::$app->countstatus->CountPrTemp(1);
$ST2 = Yii::$app->countstatus->CountPr(2);
$ST4 = Yii::$app->countstatus->CountPr(4);
$ST10 = Yii::$app->countstatus->CountPr(10);
$ST6 = Yii::$app->countstatus->CountPr(6);
$ST11 = Yii::$app->countstatus->CountPr(11);
?>
<ul class="nav nav-tabs" id="myTab">
    <li class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            รายการใบขอซื้อ
            <b class="caret"></b>
        </a>

        <ul class="dropdown-menu dropdown-success">
            <li class="<?= $action == 'index' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['/pr/default/index']); ?>" style="font-size: 11pt;">
                    <?= Html::encode('ร่างใบขอซื้อ'); ?> 
                    <strong style="font-size: 11pt;"><?php echo '( ' . $ST1 . ' )' ?></strong>
                </a>
            </li>

            <li class="<?= $action == 'waiting-verify' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['/pr/default/waiting-verify']); ?>" style="font-size: 11pt;">
                    <?= Html::encode('รอการทวนสอบ'); ?>
                    <strong style="font-size: 11pt;"><?php echo '( ' . $ST2 . ' )' ?></strong>
                </a>
            </li>
            <li class="<?= $action == 'reject-verify' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['/pr/default/reject-verify']); ?>" style="font-size: 11pt;">
                    <?= Html::encode('ไม่ผ่านการทวนสอบ'); ?>
                    <strong style="font-size: 11pt;"><?php echo '( ' . $ST4 . ' )' ?></strong>
                </a>
            </li>
            <li class="<?= $action == 'waiting-approve' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['/pr/default/waiting-approve']); ?>" style="font-size: 11pt;">
                    <?= Html::encode('รอการอนุมัติ'); ?>
                    <strong style="font-size: 11pt;"><?php echo '( ' . $ST10 . ' )' ?></strong>
                </a>
            </li>
            <li class="<?= $action == 'reject-approve' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['/pr/default/reject-approve']); ?>" style="font-size: 11pt;">
                    <?= Html::encode('ไม่ผ่านการอนุมัติ'); ?>
                    <strong style="font-size: 11pt;"><?php echo '( ' . $ST6 . ' )' ?></strong>
                </a>
            </li>
            <li class="<?= $action == 'approve' ? 'active' : ''; ?>">
                <a href="<?= Url::to(['/pr/default/approve']); ?>" style="font-size: 11pt;">
                    <?= Html::encode('ผ่านการอนุมัติ'); ?>
                    <strong style="font-size: 11pt;"><?php echo '( ' . $ST11 . ' )' ?></strong>
                </a>
            </li>
        </ul>
    </li>
    <?php /*
    <li class="tab_A tab-success <?= $action == 'index' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST1 . ' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ร่างใบขอซื้อ'); ?> 
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST1 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_B tab-success <?= $action == 'waiting-verify' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST2 . ' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ใบขอซื้อรอการทวนสอบ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST2 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_C tab-success <?= $action == 'reject-verify' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST4 . ' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ใบขอซื้อไม่ผ่านการทวนสอบ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST4 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_D tab-success <?= $action == 'waiting-approve' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST10 . ' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ใบขอซื้อรอการอนุมัติ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST10 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_E tab-success <?= $action == 'reject-approve' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST6 . ' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ใบขอซื้อไม่ผ่านการอนุมัติ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST6 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_F tab-success <?= $action == 'approve' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST11 . ' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ใบขอซื้อผ่านการอนุมัติ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST11 . ' )' ?></strong>
        </a>
    </li>*/?>
</ul>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/pr/tab_menu.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

