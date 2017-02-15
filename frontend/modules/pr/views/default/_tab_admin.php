<?php

use yii\helpers\Html;
$url = substr(Yii::$app->request->url, 4);
?>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li class="tab-success tab_A <?= $url == '/pr/default/list-approve' ? 'active' : ''; ?>">
        <a data-toggle="tab" href="#overview">
            <?= Html::encode('อนุมัติใบขอซื้อ') ?> 
            <strong style="font-size: 11pt;"><?php echo '( ' . Yii::$app->countstatus->CountPr(10) . ' )'; ?></strong>
        </a>
    </li>
    <li class="tab-success tab_B <?= $url == '/po/default/list-approve' ? 'active' : ''; ?>">
        <a data-toggle="tab" href="#timeline">
            <?= Html::encode('อนุมัติใบสั่งซื้อ') ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . Yii::$app->countstatus->CountPo(10) . ' )'; ?></strong>
        </a>
    </li>
    <li class="tab-success tab_C <?= $url == '/Purchasing/tbpcplan/wailt-manager-approve' ? 'active' : ''; ?>">
        <a data-toggle="tab"  href="#dashboard">
            <?= Html::encode('อนุมัติแผนจัดซื้อ') ?>
            <strong style="font-size: 11pt;"><?php echo '( ' . Yii::$app->countstatus->CountPlan(6) . ' )'; ?></strong>
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$(document).ready(function ($) {
    $("li.tab_A").click(function (e) {
        window.location.replace("/km4/pr/default/list-approve");
    });
    $("li.tab_B").click(function (e) {
        window.location.replace("/km4/po/default/list-approve");
    });
    $("li.tab_C").click(function (e) {
        window.location.replace("/km4/Purchasing/tbpcplan/wailt-manager-approve");
    });
});
JS;
$this->registerJs($script);
?>
