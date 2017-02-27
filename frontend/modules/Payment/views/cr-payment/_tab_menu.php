<?php

use yii\helpers\Html;
$countCr= app\modules\Payment\models\VwFiInvCrList::find()
        ->where(['cr_summary_id'=>'0'])
        ->count();
$coountHistory_cr = \app\modules\Payment\models\VwFiCrSummary::find()
        ->count();
//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_A" class="<?= Yii::$app->controller->action->id=='index'?'active':''; ?>">
        <a href="index">
            <?= Html::encode('รายการใบแจ้งค่าใช้จ่าย') ?> <span style="font-weight: bold;"><?php  echo '(' . $countCr . ')'; ?></span>
        </a>
    </li>

    <li id="tab_B" class="<?= Yii::$app->controller->action->id=='history'?'active':''; ?>">
        <a href="history">
            <?= Html::encode('ประวัติการนำส่งใบแจ้งค่าใช้จ่าย ') ?> <span style="font-weight: bold;"><?php  echo '(' . $coountHistory_cr . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
    // $(document).ready(function(){
    //     var type_pt = $('#vwfiinvcrlistsearch-pt_visit_type').val();
    //     alert(type_pt);
    // });
JS;
$this->registerJs($script);
?>