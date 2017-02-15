<?php
use yii\helpers\Html;
use app\modules\Purchasing\models\TbPr2;
$Status10 = TbPr2::find()->where(['PRStatusID' => 10])->count('PRID');
$SumPO = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 10])->count('POID');
$planwaitapprovedcount = app\models\TbPcplan::find()->where(['PCPlanStatusID'=>6])->count();
?>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#overview">
            <?= Html::encode('อนุมัติใบขอซื้อ') ?> <span><?php echo '(' . $Status10 . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success" id="tab_B">
        <a data-toggle="tab" href="#timeline">
            <?= Html::encode('อนุมัติใบสั่งซื้อ') ?> <span><?php  echo '(' . $SumPO . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success">
        <a data-toggle="tab" id="tab_I" href="#contacts">
            <?= Html::encode('อนุมัติแผนจัดชื้อ') ?> <span><?php  echo '(' . $planwaitapprovedcount . ')'; ?></span>
        </a>
    </li>
   
</ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Purchasing/addpr-gpu/detail-approve");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Purchasing/po/detail-wating-approve");
});
$("#tab_C").click(function (e) {               
window.location.replace("index.php?r=Purchasing/addpr-gpu/list-reject-verify");
});
$("#tab_D").click(function (e) {               
window.location.replace("index.php?r=Purchasing/addpr-gpu/list-wating-approve");
});
$("#tab_E").click(function (e) {               
window.location.replace("index.php?r=Purchasing/addpr-gpu/list-reject-approve");
});
$("#tab_F").click(function (e) {               
window.location.replace("index.php?r=Purchasing/addpr-gpu/list-approve");
});

$("#tab_I").click(function (e) {               
window.location.replace("index.php?r=Purchasing/tbpcplan/wailt-manager-approve");
});
JS;
$this->registerJs($script);
?>