<?php
use yii\helpers\Html;
$countInv = app\modules\Payment\models\VwInvForRepList::find()
        ->where(['inv_status' => 2])
        ->count();
$countRep = app\modules\Payment\models\VwFiRepHeader::find()
        ->where(['rep_status' => 1])
        ->count();        
$countHitory = app\modules\Payment\models\VwFiRepHeader::find()
        ->where(['rep_status' => [2,3]])
        ->count();        
//echo $rep_create_section;
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_A" class="<?= Yii::$app->controller->action->id=='index'?'active':''; ?>">
        <a href="index">
            <?= Html::encode('รายการใบแจ้งค่าใช้จ่าย') ?> <span style="font-weight: bold;"><?php  echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    <li id="tab_B" class="<?= Yii::$app->controller->action->id=='rep-create'?'active':''; ?>">
        <a href="rep-create">
            <?= Html::encode('ร่างบันทึกการชำระเงิน') ?> <span style="font-weight: bold;"><?php  echo '(' . $countRep . ')'; ?></span>
        </a>
    </li>                     
    <li id="tab_C" class="<?= Yii::$app->controller->action->id=='history'?'active':''; ?>">
        <a href="history">
            <?= Html::encode('ประวัติชำระเงิน') ?> <span style="font-weight: bold;"><?php  echo '(' . $countHitory . ')'; ?></span>
        </a>
    </li>
</ul>
