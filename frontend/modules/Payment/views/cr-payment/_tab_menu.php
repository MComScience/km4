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
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('รายการใบแจ้งค่าใช้จ่าย') ?> <span ><?php  echo '(' . $countCr . ')'; ?></span>
        </a>
    </li>

    <li class="tab-success" id="tab_B">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('ประวัติการนำส่งใบแจ้งค่าใช้จ่าย ') ?> <span ><?php  echo '(' . $coountHistory_cr . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
    // $(document).ready(function(){
    //     var type_pt = $('#vwfiinvcrlistsearch-pt_visit_type').val();
    //     alert(type_pt);
    // });

$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Payment/cr-payment/index");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Payment/cr-payment/history");
});
JS;
$this->registerJs($script);
?>