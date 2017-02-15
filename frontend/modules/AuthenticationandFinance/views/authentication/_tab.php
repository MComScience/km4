<?php 
use yii\helpers\Html;

?>
<ul class="nav nav-tabs" id="myTab">
    <li id="opd_tab" class="<?= Yii::$app->controller->action->id=='list-opd-wait-register'?'active':''; ?>">
          <?= Html::a('รายชื่อผู้ป่วยนอก รอลงทะเบียน', ['list-opd-wait-register'] ) ?>
        </a>
    </li>
      <li id="ipd_tab" class="<?= Yii::$app->controller->action->id=='list-ipd-wait-register'?'active':''; ?>">
        <?= Html::a('รายชื่อผู้ป่วยใน รอลงทะเบียน', ['list-ipd-wait-register']) ?>
        </a>
    </li>
</ul>
