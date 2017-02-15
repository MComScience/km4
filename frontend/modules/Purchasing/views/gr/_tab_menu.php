<?php

use yii\helpers\Html;
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบสั่งซื้อ') ?> <span ><?php // echo '(' . $VwPo2Postatuscount[0]['POStatusCount'] . ')'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบรับสินค้า') ?> <span ><?php // echo '(' . $VwPo2Postatuscount[0]['POStatusCount'] . ')'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_C">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติใบรับสินค้า') ?> <span ><?php // echo '(' . $VwPrStatusCount[3]['PRStatusCount'] . ')'; ?></span>
            </a>
        </li>
        
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Purchasing/gr/index");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Purchasing/gr/list-draft");
});
$("#tab_C").click(function (e) {               
window.location.replace("index.php?r=Purchasing/gr/receive-history");
});
JS;
$this->registerJs($script);
?>