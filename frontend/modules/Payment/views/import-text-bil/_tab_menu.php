<?php

use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_text" class="<?= Yii::$app->controller->id=='import-text-bil'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('นำเข้าไฟล์ สกส.') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_text").click(function (e) {
   window.location.replace("index");      
});
JS;
$this->registerJs($script);
?>