<?php

//echo $_SESSION['section_view'];
use yii\helpers\Html;
$countRep= app\modules\Payment\models\VwFiRepList::find()
        ->where(['rep_create_section'=>$_SESSION['section_view'],'rep_summary_id'=>'0'])
        ->count();
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
$countHistory = app\modules\Payment\models\VwFiRepSummary::find()
        ->count();    
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('รายการรอนำส่งการชำระเงิน ') ?><span > <?php  echo '(' . $countRep . ')'; ?></span>
        </a>
    </li>

    <li class="tab-success" id="tab_B">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('ประวัติรายการนำส่งการชำระเงิน ') ?> <span > <?php  echo '(' . $countHistory . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) { 
    window.location.replace("index.php?r=Payment/send-cash/index");
});
$("#tab_B").click(function (e) {               
    window.location.replace("index.php?r=Payment/send-cash/history");
});
JS;
$this->registerJs($script);
?>
