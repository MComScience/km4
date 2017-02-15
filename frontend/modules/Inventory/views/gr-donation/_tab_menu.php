<?php

use yii\helpers\Html;
$statusGRTemp = app\modules\Inventory\models\TbGr2Temp::find()
        ->where(['GRTypeID' => [5,7,8]])
        ->count();
$statusGR = app\modules\Inventory\models\TbGr2::find()
        ->where(['GRTypeID' => [5,7,8]])
        ->count(); 
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบรับสินค้า') ?> <span ><?php  echo '(' . $statusGRTemp . ')'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติใบรับสินค้า') ?> <span ><?php  echo '(' . $statusGR . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("history-grdonate");
});
JS;
$this->registerJs($script);
?>