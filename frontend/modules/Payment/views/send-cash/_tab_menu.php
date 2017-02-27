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
    <li id="tab_A" class="<?= Yii::$app->controller->action->id=='index'?'active':''; ?>">
        <a href="index">
            <?= Html::encode('รายการรอนำส่งการชำระเงิน ') ?><span style="font-weight: bold;"><?php  echo '(' . $countRep . ')'; ?></span>
        </a>
    </li>

    <li id="tab_B" class="<?= Yii::$app->controller->action->id=='history'?'active':''; ?>">
        <a href="history">
            <?= Html::encode('ประวัติรายการนำส่งการชำระเงิน ') ?><span style="font-weight: bold;"><?php  echo '(' . $countHistory . ')'; ?></span>
        </a>
    </li>
</ul>
