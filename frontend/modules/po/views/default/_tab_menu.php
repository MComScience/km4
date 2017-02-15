<?php
use yii\helpers\Html;

$action = Yii::$app->controller->action->id;
$PRList = $model->getCountStatus('PRList');
$ST1 = $model->getCountStatus(1);
$ST2 = $model->getCountStatus(2);
$ST4 = $model->getCountStatus(4);
$ST10 = $model->getCountStatus(10);
$ST6 = $model->getCountStatus(6);
$ST11 = $model->getCountStatus(11);
?>
<ul class="nav nav-tabs" id="myTab">
    <li class="tab_A tab-success <?= $action == 'index' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $PRList.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('รายการใบขอซื้อ'); ?> 
            <strong style="font-size: 11pt;"><?php echo '( ' . $PRList . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_B tab-success <?= $action == 'draft' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST1.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ร่างใบสั่งซื้อ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST1 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_C tab-success <?= $action == 'waiting-verify' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST2.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('รอการทวนสอบ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST2 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_D tab-success <?= $action == 'reject-verify' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST4.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ไม่ผ่านการทวนสอบ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST4 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_E tab-success <?= $action == 'waiting-approve' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST10.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('รอการอนุมัติ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST10 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_F tab-success <?= $action == 'reject-approve' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST6.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ไม่ผ่านการอนุมัติ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST6 . ' )' ?></strong>
        </a>
    </li>
    <li class="tab_G tab-success <?= $action == 'approve' ? 'active' : ''; ?>" data-toggle="tooltip" title="<?= $ST11.' รายการ' ?>">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('ผ่านการอนุมัติ'); ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . $ST11 . ' )' ?></strong>
        </a>
    </li>
</ul>
<?php $this->registerJsFile(Yii::getAlias('@web') . '/js/po/tab_menu.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>