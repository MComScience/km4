<?php

use yii\helpers\Html;
$url = substr(Yii::$app->request->url, 4);
?>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li class="tab-success tab_A <?= $url == '/pr/default/list-verify' ? 'active' : ''; ?>">
        <a data-toggle="tab" href="#overview">
            <?= Html::encode('ทวนสอบใบขอซื้อ') ?> 
            <strong style="font-size: 11pt;"><?php echo '( ' .  Yii::$app->countstatus->CountPr(2) . ' )'; ?></strong>
        </a>
    </li>
    <li class="tab-success tab_B <?= $url == '/po/default/list-verify' ? 'active' : ''; ?>">
        <a data-toggle="tab" href="#timeline">
            <?= Html::encode('ทวนสอบใบสั่งซื้อ') ?>
            <strong style="font-size: 11pt;"><?php echo '( ' .  Yii::$app->countstatus->CountPo(2) . ' )'; ?></strong>
        </a>
    </li>
    <?php /*
    <li class="tab-success tab_C ">
        <a data-toggle="tab"  href="#dashboard">
            <?= Html::encode('Dash Board') ?>
        </a>
    </li>
     * 
     */?>
    <li class="tab-success tab_D <?= $url == '/Inventory/sa-list/wait-approve-prarmacy' ? 'active' : ''; ?>">
        <a data-toggle="tab" href="#settings">
            <?= Html::encode('อนุมัติการปรับปรุงสินค้า') ?>
            <strong style="font-size: 11pt;"><?php echo '( ' .  Yii::$app->countstatus->CountSalist([2,6]) . ' )'; ?></strong>
        </a>
    </li>
    <li class="tab-success tab_E <?= $url == '/Purchasing/tbpcplan/wailt-approve' ? 'active' : ''; ?>">
        <a data-toggle="tab" href="#settings">
            <?= Html::encode('อนุมัติแผนจัดซื้อ') ?>
            <strong style="font-size: 11pt;"><?php echo '( ' .  Yii::$app->countstatus->CountPlan(4) . ' )'; ?></strong>
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$(document).ready(function ($) {
    $("li.tab_A").click(function (e) {
        window.location.replace("/km4/pr/default/list-verify");
    });
    $("li.tab_B").click(function (e) {
        window.location.replace("/km4/po/default/list-verify");
    });
    $("li.tab_C").click(function (e) {
        window.location.replace("/km4/Purchasing/addpr-gpu/dashboard");
    });
    $("li.tab_D").click(function (e) {
        window.location.replace("/km4/Inventory/sa-list/wait-approve-prarmacy");
    });
    $("li.tab_E").click(function (e) {
        window.location.replace("/km4/Purchasing/tbpcplan/wailt-approve");
    });
});
JS;
$this->registerJs($script);
?>