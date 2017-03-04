<?php
use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_ipop" class="<?= Yii::$app->controller->id=='import-excel-ipop'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('UC : OP/IP') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    <li id="tab_orf" class="<?= Yii::$app->controller->id=='import-excel-orf'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('UC : OP/IP Refer') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    <li id="tab_oplgo" class="<?= Yii::$app->controller->id=='import-excel-oplgo'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('UC : OP/IP LGO') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    <li id="tab_opcs" class="<?= Yii::$app->controller->id=='import-excel-opcs'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('UC : OP/IP CS') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_ipop").click(function (e) {
   window.location.replace("/km4/Payment/import-excel-ipop/index");      
});
$("#tab_orf").click(function (e) {
   window.location.replace("/km4/Payment/import-excel-orf/index");      
});
$("#tab_oplgo").click(function (e) {
   window.location.replace("/km4/Payment/import-excel-oplgo/index");      
});
$("#tab_opcs").click(function (e) {
   window.location.replace("/km4/Payment/import-excel-opcs/index");      
});
JS;
$this->registerJs($script);
?>