<?php

use yii\helpers\Html;
?>
<ul class="nav nav-tabs" id="myTab">
    <li class="active tabA">
        <a data-toggle="tab" href="#tabA">
            <?= Html::encode('รายชื่อผู้ป่วยใน'); ?>
        </a>
    </li>

    <li class="tab-success tabB">
        <a data-toggle="tab" href="#tabB">
            <?= Html::encode('สถานะใบสั่งยา'); ?>
        </a>
    </li>

    <li class="tab-success tabC">
        <a data-toggle="tab" href="#tabC">
            <?= Html::encode('ใบสั่งยารออนุมัติ'); ?>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
    $("li.tabA").click(function (e) {
        window.location.replace("index.php?r=pharmacy/ip/index");
    });
    $("li.tabB").click(function (e) {
        window.location.replace("index.php?r=pharmacy/ip/order-status");
    });
    $("li.tabC").click(function (e) {
        
    });
JS;
$this->registerJs($script);
?>
