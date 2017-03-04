<?php

use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_A" class="<?= Yii::$app->controller->action->id=='index'?'active':''; ?>">
        <a href="index">
            <?= Html::encode('STM_UDCANCER') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>
