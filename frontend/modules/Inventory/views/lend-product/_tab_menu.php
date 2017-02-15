<?php

use yii\helpers\Html;
$statusSTTemp = app\modules\Inventory\models\TbSt2Temp::find()
        ->where(['STTypeID' => 4])
        ->count();
$statusST = app\modules\Inventory\models\TbSt2::find()
        ->where(['STTypeID' => 4])
        ->count(); 
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบให้ยืมสินค้า') ?> <span ><?php  echo '(' . $statusSTTemp  . ')'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติใบให้ยืมสินค้า') ?> <span ><?php  echo '(' . $statusST . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("history-lend");
});
JS;
$this->registerJs($script);
?>