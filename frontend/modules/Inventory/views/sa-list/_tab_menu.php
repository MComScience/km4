<?php

use kartik\helpers\Html;
use app\modules\Inventory\models\Vwsr2list;
use app\modules\Inventory\models\VwSaList;
$array_stk = \app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all();
     if ($array_stk != null) {
        foreach ($array_stk as $data) {
            $StkID[] = $data['StkID'];
    }
}
if(!empty($StkID)){
$statusSa = VwSaList::find()->where(['SaStatus'=>'1'])->andwhere(['SA_stkID'=>$StkID])->count();
$statusSa_wait = VwSaList::find()->where(['SaStatus'=>['2','6']])->andwhere(['SA_stkID'=>$StkID])->count();
$statusSa_approve = VwSaList::find()->where(['SaStatus'=>['2','6']])->andwhere(['SA_stkID'=>$StkID])->count();
$statusSa_history = VwSaList::find()->where(['SaStatus'=>'4'])->andwhere(['SA_stkID'=>$StkID])->count();
}else{
$statusSa = VwSaList::find()->where(['SaStatus'=>'1'])->count();
$statusSa_wait = VwSaList::find()->where(['SaStatus'=>['2','6']])->count();
$statusSa_approve = VwSaList::find()->where(['SaStatus'=>['2','6']])->count();
$statusSa_history = VwSaList::find()->where(['SaStatus'=>'4'])->count();
} 
?>
<ul class="nav nav-tabs " id="myTab">
    <li id="tab_A">
        <a data-toggle="tab" href="#tab" >
<?= Html::encode("ปรับปรุงยอดสินค้าคงคลัง (".$statusSa.")") ?> 
        </a>
    </li>  
    <li id="tab_B">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("ปรับปรุงยอดสินค้าคงคลัง รออนุมัติ (".$statusSa_wait.")") ?> 
        </a>
    </li>
    <li id="tab_C">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("อนุมัติปรับปรุงยอดสินค้าคงคลัง (".$statusSa_approve.")") ?> 
        </a>
    </li>   
    <li id="tab_D">
        <a data-toggle="tab" href="#tab" >
			<?= Html::encode("ประวัติปรับปรุงยอดสินค้าคงคลัง (".$statusSa_history.")") ?> 
        </a>
    </li>  

</ul>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("wait-approve");
});
$("#tab_C").click(function (e) {               
window.location.replace("approve-sa");
});
$("#tab_D").click(function (e) {               
window.location.replace("history");
});
JS;
$this->registerJs($script);
?>
