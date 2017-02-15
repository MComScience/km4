<?php

use yii\helpers\Html;
$statusGRST= app\modules\Inventory\models\VwSt2ListForGr2::find()
        ->where(['STTypeID' => 4])
        ->count();
$statusGRTemp = app\modules\Inventory\models\TbGr2Temp::find()
        ->where(['GRTypeID' => 4])
        ->count();
$statusGR = app\modules\Inventory\models\TbGr2::find()
        ->where(['GRTypeID' => 4])
        ->count();       
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบส่งสินค้าให้ยืม') ?> <span ><?php  echo '(' . $statusGRST . ')'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบรับสินค้าให้ยืม') ?> <span ><?php  echo '(' . $statusGRTemp . ')'; ?></span>
            </a>
        </li>
        
        <li class="tab-success" id="tab_C">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติใบรับสินค้าให้ยืม') ?> <span ><?php  echo '(' . $statusGR . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("gr-temp");
});
$("#tab_C").click(function (e) {               
window.location.replace("history");
});        
JS;
$this->registerJs($script);
?>