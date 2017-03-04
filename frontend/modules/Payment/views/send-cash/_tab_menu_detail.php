<?php

//echo $_SESSION['section_view'];
use yii\helpers\Html;
// $countRep= app\modules\Payment\models\VwFiRepList::find()
//         ->where(['rep_create_section'=>$_SESSION['section_view']])
//         ->count();
// //$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
// $countHistory = app\modules\Payment\models\VwFiRepSummary::find()
//         ->count();    
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('รายละเอียดใบนำส่งเงินสด ') ?><span > <?php  //echo '(' . $countRep . ')'; ?></span>
        </a>
    </li>
</ul>
