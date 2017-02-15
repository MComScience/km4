<?php

use kartik\helpers\Html;
use app\modules\Inventory\models\Vwsr2listdraf;
use app\modules\Inventory\models\Vwsr2list;
use app\modules\Inventory\models\Tbsr2;
use app\modules\Inventory\models\Vwsr2list1;
use app\modules\Inventory\models\TbSt2Temp;
use app\modules\Inventory\models\TbSt2;
$array_stk = \app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all();
     if ($array_stk != null) {
        foreach ($array_stk as $data) {
            $StkID[] = $data['StkID'];
    }
}
if(!empty($StkID)){
$statusReq = Vwsr2listdraf::find()->where(['SRReceive_stkID'=>$StkID])->count();
$statusWait_req = Vwsr2list::find()->where(['SRStatus' => '2'])->andwhere(['SRReceive_stkID'=>$StkID])->count();
$statusApprove = Tbsr2::find()->where(['SRStatus'=>'2'])->andwhere(['SRIssue_stkID'=>$StkID])->count();
$statusHistory_req = Vwsr2list::find()->where(['SRStatus' => '4'])->andwhere(['SRReceive_stkID'=>$StkID])->count();
$statusTranfer = Vwsr2list1::find()->where(['SRStatus' => '4'])->andwhere(['SRIssue_stkID'=>$StkID])->count();
$statusHistory_tranfer = TbSt2Temp::find()->where(['STTypeID' => '1'])->andwhere(['STIssue_StkID'=>$StkID])->count();
$statusSt_wait = TbSt2::find()->where(['STStatus'=> ['5','6','2','3','4','20']])->andwhere(['STTypeID' => '1'])->andWhere(['STIssue_StkID'=> $StkID])->count();
$statusSt = TbSt2::find()->where(['STStatus'=> ['2','3','4','20']])->andwhere(['STTypeID' => '1'])->andWhere(['STRecieve_StkID'=> $StkID])->count();
$statusHistory_st = TbSt2::find()->where(['STStatus' => ['5','6']])->andwhere(['STTypeID' => '1'])->andwhere(['STRecieve_StkID'=>$StkID])->count();
}else{ 
$statusReq = Vwsr2listdraf::find()->count();
$statusWait_req = Vwsr2list::find()->where(['SRStatus' => '2'])->count();
$statusApprove = Tbsr2::find()->where(['SRStatus'=>'2'])->count();
$statusHistory_req = Vwsr2list::find()->where(['SRStatus' => '4'])->count();
$statusTranfer = Vwsr2list1::find()->where(['SRStatus' => '4'])->count();
$statusHistory_tranfer = TbSt2Temp::find()->where(['STTypeID' => '1'])->count();
$statusSt_wait = TbSt2::find()->where(['STStatus'=> ['5','6','2','3','4','20']])->andwhere(['STTypeID' => '1'])->count();
$statusSt = TbSt2::find()->where(['STStatus'=> ['2','3','4','20']])->andwhere(['STTypeID' => '1'])->count();
$statusHistory_st = TbSt2::find()->where(['STStatus' => ['5','6']])->andwhere(['STTypeID' => '1'])->count();
}
?>
<ul class="nav nav-tabs " id="myTab">
    <li id="tab_A">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("บันทึกขอเบิก (".$statusReq.")") ?>
        </a>
    </li>  
    <li id="tab_B">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("รออนุมัติ (".$statusWait_req.")") ?> 
        </a>
    </li>
    <?php if(Yii::$app->user->can('ApproveSR')){ ?>
    <li id="tab_C">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("อนุมัติขอเบิก (".$statusApprove.")") ?> 
        </a>
    </li>
    <?php } ?>
    <li id="tab_D">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("ประวัติขอเบิก (".$statusHistory_req.")") ?> 
        </a>
    </li>  
    <li id="tab_E">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("ใบเบิกรอจัด (".$statusTranfer.")") ?> 
		</a>
    </li>  
    <li id="tab_F">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("โอนสินค้า (".$statusHistory_tranfer.")") ?> 
       </a>
    </li>
    <li id="tab_X">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("ประวัติการโอน (".$statusSt_wait.")") ?> 
        </a>
    </li>
    <li id="tab_G">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("รับสินค้า (".$statusSt.")") ?> 
        </a>
    </li>
    <li id="tab_H">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("ประวัติการรับ (".$statusHistory_st.")") ?> 
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("/km4/Inventory/stock-request/index");
});
$("#tab_B").click(function (e) {               
window.location.replace("/km4/Inventory/stock-request/wait-approve");
});
$("#tab_C").click(function (e) {               
window.location.replace("/km4/Inventory/stock-request/approve-sr");
});
$("#tab_D").click(function (e) {               
window.location.replace("/km4/Inventory/stock-request/history");
});
$("#tab_E").click(function (e) {               
window.location.replace("/km4/Inventory/tb-st2-temp/spicking");
});
$("#tab_F").click(function (e) {               
window.location.replace("/km4/Inventory/tb-st2-temp/index");
});
$("#tab_X").click(function (e) {               
window.location.replace("/km4/Inventory/tbst2/stock-wait");
});
$("#tab_G").click(function (e) {               
window.location.replace("/km4/Inventory/tbst2/stock-receive");
});
$("#tab_H").click(function (e) {               
window.location.replace("/km4/Inventory/tbst2/stock-receive-history");
});
JS;
$this->registerJs($script);
?>
