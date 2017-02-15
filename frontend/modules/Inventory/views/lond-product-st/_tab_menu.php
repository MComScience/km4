<?php

use yii\helpers\Html;
$statusGR = app\modules\Inventory\models\VwGr2ListForSt2Loan::find()
        ->where(['GRTypeID' => 3])
        ->count();
$statusSTTemp = app\modules\Inventory\models\TbSt2Temp::find()
        ->where(['STTypeID' => 3])
        ->count();
$statusST = app\modules\Inventory\models\TbSt2::find()
        ->where(['STTypeID' => 3])
        ->count();          
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รายการใบรับสินค้ายืม') ?> <span ><?php  echo '(' . $statusGR . ')'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบส่งสินค้าขอยืม') ?> <span ><?php  echo '(' . $statusSTTemp . ')'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_C">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติใบส่งสินค้าขอยืม') ?> <span ><?php  echo '(' . $statusST . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("lond-st");
});
$("#tab_C").click(function (e) {               
window.location.replace("history");
});
JS;
$this->registerJs($script);
?>