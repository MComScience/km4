<?php

use yii\helpers\Html;
 $array_stk = \app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all();
     if ($array_stk != null) {
        foreach ($array_stk as $data) {
            $StkID[] = $data['StkID'];
    }
}
if(!empty($StkID)){
    $statusGRTemp = app\modules\Inventory\models\TbGr2Temp::find()
        ->where(['GRTypeID' => 6])
        ->andwhere(['StkID'=> $StkID])
        ->count(); 
    $statusGR = app\modules\Inventory\models\TbGr2::find()
        ->where(['GRTypeID' => 6])
        ->andwhere(['StkID'=> $StkID])
        ->count();  
}else{
   $statusGRTemp = app\modules\Inventory\models\TbGr2Temp::find()
        ->where(['GRTypeID' => 6])
        ->count();
    $statusGR = app\modules\Inventory\models\TbGr2::find()
        ->where(['GRTypeID' => 6])
        ->count();      
}

//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างตั้งต้นสินค้าคงคลัง') ?> <span ><?php  echo '(' . $statusGRTemp  . ')'; ?></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติตั้งต้นสินค้าคงคลัง') ?> <span ><?php  echo '(' . $statusGR  . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
$("#tab_B").click(function (e) {               
window.location.replace("history-stockinitail");
});
JS;
$this->registerJs($script);
?>