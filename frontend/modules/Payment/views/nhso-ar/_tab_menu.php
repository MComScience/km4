<?php
use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_ar" class="<?= Yii::$app->controller->id=='nhso-ar'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('สร้างหนังสือเรียกเก็บ') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
   <li id="tab_inv" class="<?= Yii::$app->controller->id=='nhso-inv'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('สถานะหนังสือเรียกเก็บ') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_ar").click(function (e) {
   window.location.replace("/km4/Payment/nhso-ar/index");      
});
$("#tab_inv").click(function (e) {
   window.location.replace("/km4/Payment/nhso-inv/index");      
});
JS;
$this->registerJs($script);
?>