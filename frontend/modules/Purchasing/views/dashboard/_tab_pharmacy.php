<?php
use yii\helpers\Html;
//$VwPrStatusCount = app\modules\Purchasing\models\VwPr2Prstatuscount::find()->all();
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
$SumPR = \app\modules\Purchasing\models\TbPr2::find()->where(['PRStatusID' => 2])->count('PRID');
$SumPO = app\modules\Purchasing\models\TbPo2::find()->where(['POStatus' => 2])->count('POID');
$vwsrwaitapprovecount = \app\modules\Inventory\models\Vwsr2list::find()->where(['SRStatus'=>2])->count();
$vwsawaitapprovecount = \app\modules\Inventory\models\VwSaList::find()->where(['SAStatus'=>2])->count();
$vwpcwaitapprovecount = app\models\TbPcplan::find()->where(['PCPlanStatusID'=>4])->count();
?>
<audio id="notif_audio"><source src="/km4/sounds/notify.ogg" type="audio/ogg"><source src="/km4/sounds/notify.mp3" type="audio/mpeg"><source src="/km4/sounds/notify.wav" type="audio/wav"></audio>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#overview">
            <?= Html::encode('ทวนสอบใบขอซื้อ') ?> <span ><?php echo '('.$SumPR.')'; // echo '(' . $VwPrStatusCount[1]['PRStatusCount'] . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success" id="tab_B">
        <a data-toggle="tab" href="#timeline">
            <?= Html::encode('ทวนสอบใบสั่งซื้อ') ?> <span ><?php echo '('.$SumPO.')'; //  echo '(' . $VwPo2Postatuscount[1]['POStatusCount'] . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success" id="dashboard">
        <a data-toggle="tab"  href="#dashboard">
            <?= Html::encode('Dash Board') ?>
        </a>
    </li>
    <?php /*
    <li class="tab-success" id="tab_H">
        <a data-toggle="tab"  href="#contacts">
            <?= Html::encode('อนุมัติการขอเบิก') ?> <span ><?php  echo '(' . $vwsrwaitapprovecount . ')' '-'; ?></span>
        </a>
    </li>
    */?>
    <li class="tab-success" id="tab_G">
        <a data-toggle="tab"  href="#setting">
            <?= Html::encode('อนุมัติการปรับปรุงสินค้า') ?> <span ><?php  echo '(' . $vwsawaitapprovecount . ')'; ?></span>
        </a>
    </li>
	 <li class="tab-success" id="tab_I">
        <a data-toggle="tab"  href="#setting">
            <?= Html::encode('อนุมัติแผนจัดชื้อ') ?> <span ><?php  echo '(' . $vwpcwaitapprovecount. ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
/*
setInterval(function(){ 
 $.ajax({
                url: "/km4/Inventory/stock-request/getsrwait-approv",
                success: function (result) {
                    if(result.srcount != 0){
                        $('#notif_audio')[0].play();
                        javascript: Notify('คุณมีรายการใบขอเบิกที่ยังไม่อนุมัติ', 'top-right', '5000', 'warning', 'fa-warning', true); return false;
                    }else if(result.sacount != 0){
                        $('#notif_audio')[0].play();
                        javascript: Notify('คุณมีรายการปรับสต็อกที่ยังไม่อนุมัติ', 'top-right', '5000', 'warning', 'fa-warning', true); return false;
                    }else if(result.plancount != 0){
                        $('#notif_audio')[0].play();
                         javascript: Notify('คุณมีรายการแผนที่ยังไม่อนุมัติ', 'top-right', '5000', 'warning', 'fa-warning', true); return false;
                    }
                }
            });
 }, 60000);*/
$("#tab_A").click(function (e) {               
window.location.replace("/km4/Purchasing/addpr-gpu/detail-verify");
});
$("#tab_B").click(function (e) {               
window.location.replace("/km4/Purchasing/po/detail-verify");
});
$("#tab_C").click(function (e) {               
window.location.replace("/km4/Purchasing/addpr-gpu/list-reject-verify");
});
$("#tab_D").click(function (e) {               
window.location.replace("/km4/Purchasing/addpr-gpu/list-wating-approve");
});
$("#tab_E").click(function (e) {               
window.location.replace("/km4/Purchasing/addpr-gpu/list-reject-approve");
});
$("#tab_F").click(function (e) {               
window.location.replace("/km4/Purchasing/addpr-gpu/list-approve");
});
$("#tab_G").click(function (e) {               
window.location.replace("/km4/Inventory/sa-list/wait-approve-prarmacy");
});
$("#tab_I").click(function (e) {               
window.location.replace("/km4/Purchasing/tbpcplan/wailt-approve");
});
$("#tab_H").click(function (e) {               
window.location.replace("/km4/Inventory/stock-request/wait-approve-pharmacys");
});
$("#dashboard").click(function (e) {               
window.location.replace("/km4/Purchasing/addpr-gpu/dashboard");
});
JS;
$this->registerJs($script);
?>