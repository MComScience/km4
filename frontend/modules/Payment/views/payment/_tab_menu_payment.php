<?php
use yii\helpers\Html;
$countInv = app\modules\Payment\models\VwInvForRepList::find()
        ->where(['inv_status' => 2])
        ->count();
$countRep = app\modules\Payment\models\VwFiRepHeader::find()
        ->where(['rep_status' => 1])
        ->count();        
$countHitory = app\modules\Payment\models\VwFiRepHeader::find()
        ->where(['rep_status' => [2,3]])
        ->count();        
//echo $rep_create_section;
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('รายการใบแจ้งค่าใช้จ่าย') ?> <span ><?php  echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success" id="tab_B">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('ร่างบันทึกการชำระเงิน') ?> <span ><?php  echo '(' . $countRep . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success" id="tab_C">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('ประวัติชำระเงิน') ?> <span ><?php  echo '(' . $countHitory . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {
    window.location.replace("index.php?r=Payment/payment/index");
});
$("#tab_B").click(function (e) {
    window.location.replace("index.php?r=Payment/payment/rep-create");
});     
$("#tab_C").click(function (e) {
    window.location.replace("index.php?r=Payment/payment/history");
});

JS;
$this->registerJs($script);
?>