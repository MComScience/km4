<?php

use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('UC : OP/IP') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    <li class="tab-success" id="tab_B">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('UC : OP Refer') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {
   window.location.replace("index.php?r=Payment/import-excel-ipop/index");      
});
$("#tab_B").click(function (e) {
   window.location.replace("index.php?r=Payment/import-excel-orf/index");      
});
JS;
$this->registerJs($script);
?>