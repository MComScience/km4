<?php

use yii\helpers\Html;
use app\modules\Purchasing\models\TbPr2Temp;
use app\modules\Purchasing\models\TbPr2;
$statusgpu = TbPr2Temp::find()
        ->where(['PRTypeID' => [1,2,3,4,5], 'PRStatusID' => 1])
        ->count();
$Status2 = TbPr2::find()->where(['PRStatusID' => 2])->count('PRID');
$Status4 = TbPr2::find()->where(['PRStatusID' => 4])->count('PRID');
$Status10 = TbPr2::find()->where(['PRStatusID' => 10])->count('PRID');
$Status6 = TbPr2::find()->where(['PRStatusID' => 6])->count('PRID');
$Status11 = TbPr2::find()->where(['PRStatusID' => 11])->count('PRID');
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success " id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รายการใบขอซื้อ') ?> <span ><?php echo '( '.$statusgpu.' )'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบขอซื้อรอการทวนสอบ') ?> <span ><?php echo '( ' . $Status2 . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_C">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบขอซื้อไม่ผ่านการทวนสอบ') ?> <span ><?php echo '( ' . $Status4 . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_D">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบขอซื้อรอการอนุมัติ') ?> <span ><?php echo '( ' . $Status10 . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_E">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบขอซื้อไม่ผ่านการอนุมัติ') ?> <span ><?php echo '( ' . $Status6 . ' )'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_F">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ใบขอซื้อผ่านการอนุมัติ') ?> <span ><?php echo '( ' . $Status11 . ' )'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("list-verify");
});
$("#tab_C").click(function (e) {               
window.location.replace("list-reject-verify");
});
$("#tab_D").click(function (e) {               
window.location.replace("list-wating-approve");
});
$("#tab_E").click(function (e) {               
window.location.replace("list-reject-approve");
});
$("#tab_F").click(function (e) {               
window.location.replace("list-approve");
});
JS;
$this->registerJs($script);
?>