<?php
$array_stk = \app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all();
    if ($array_stk != null) {
        foreach ($array_stk as $data) {
            $StkID[] = $data['StkID'];
     }
}
use yii\helpers\Html;
if(!empty($StkID)){
    $statusSTTemp = app\modules\Inventory\models\TbSt2Temp::find()
            ->where(['STTypeID' => 6])
            ->andwhere(['STIssue_StkID'=>$StkID])
            ->count();
    $statusST = app\modules\Inventory\models\TbSt2::find()
            ->where(['STTypeID' => 6])
            ->andwhere(['STIssue_StkID'=>$StkID])
            ->count(); 
}else{
    $statusSTTemp = app\modules\Inventory\models\TbSt2Temp::find()
        ->where(['STTypeID' => 6])
        ->count();
$statusST = app\modules\Inventory\models\TbSt2::find()
        ->where(['STTypeID' => 6])
        ->count(); 
}
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ร่างใบจ่ายสินค้า ') ?>  <span ><?php  echo '(' . $statusSTTemp . ')'; ?></span>
            </a>
        </li>
        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ประวัติใบจ่ายสินค้า ') ?>  <span ><?php  echo '(' . $statusST . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("/km4/Inventory/daily-issue/index");
});
$("#tab_B").click(function (e) {               
window.location.replace("/km4/Inventory/daily-issue/history-daily");
});

JS;
$this->registerJs($script);
?>