<?php
use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_ar" class="<?= Yii::$app->controller->id=='nhso-ar-rep'?'active':''; ?>">
        <a href="index">
            <?= Html::encode('บันทึกรับชำระเรียกเก็บ') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
   <li id="tab_inv" class="<?= Yii::$app->controller->id=='nhso-ar-repx'?'active':''; ?>">
       <a href="index">
            <?= Html::encode('ประวัติการชำระ') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>
