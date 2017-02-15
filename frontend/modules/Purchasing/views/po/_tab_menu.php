<?php

use yii\helpers\Html;
$SumDraft = app\modules\Purchasing\models\VwPr2ListForPo2::find()->count('PRID');
$SumPO1 = app\modules\Purchasing\models\TbPo2Temp::find()->where(['POStatus' => 1])->count('POID');
$SumPO2 = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 2])->count('POID');
$SumPO4 = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 4])->count('POID');
$SumPO6 = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 6])->count('POID');
$SumPO10 = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 10])->count('POID');
$SumPO11 = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 11])->count('POID');
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รายการใบขอซื้อ') ?> <span ><?php echo '('.$SumDraft.')'; // echo '(' . $VwPo2Postatuscount[0]['POStatusCount'] . ')'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบสั่งซื้อ') ?> <span ><?php echo '('.$SumPO1.')'; // echo '( ' . $VwPo2Postatuscount[0]['POStatusCount'] . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_C">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รอการทวนสอบ') ?> <span ><?php echo '('.$SumPO2.')'; //  echo '( ' . $VwPo2Postatuscount[1]['POStatusCount'] . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_D">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ไม่ผ่านการทวนสอบ') ?> <span ><?php echo '('.$SumPO4.')'; // echo '( ' . $VwPo2Postatuscount[3]['POStatusCount'] . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_E">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รอการอนุมัติ') ?> <span ><?php echo '('.$SumPO10.')'; // echo '( ' . $VwPo2Postatuscount[9]['POStatusCount'] . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_F">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ไม่ผ่านการอนุมัติ') ?> <span ><?php echo '('.$SumPO6.')';  // echo '( ' . $VwPo2Postatuscount[5]['POStatusCount'] . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_G">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ผ่านการอนุมัติ') ?> <span ><?php echo '('.$SumPO11.')'; //  echo '( ' . $VwPo2Postatuscount[10]['POStatusCount'] . ' )'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("detail-draft");
});
$("#tab_C").click(function (e) {               
window.location.replace("list-verify");
});
$("#tab_D").click(function (e) {               
window.location.replace("list-reject-verify");
});
$("#tab_E").click(function (e) {               
window.location.replace("list-wating-approve");
});
$("#tab_F").click(function (e) {               
window.location.replace("list-reject-approve");
});
$("#tab_G").click(function (e) {               
window.location.replace("list-approve");
});
JS;
$this->registerJs($script);
?>