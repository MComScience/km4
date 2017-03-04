<?php
use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_ar" class="<?= Yii::$app->controller->id=='nhso-ar'?'active':''; ?>">
        <a href="/km4/Payment/nhso-ar/index">
            <?= Html::encode('สร้างหนังสือเรียกเก็บ') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
   <li id="tab_inv" class="<?= Yii::$app->controller->id=='nhso-inv'?'active':''; ?>">
       <a href="/km4/Payment/nhso-inv/index">
            <?= Html::encode('สถานะหนังสือเรียกเก็บ') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>
