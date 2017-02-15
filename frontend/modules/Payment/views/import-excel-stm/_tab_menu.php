<?php

use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success" id="tab_A">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('STM_UDCANCER') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
</ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {
   window.location.replace("index.php?r=Payment/import-excel-stm/index");      
});
JS;
$this->registerJs($script);
?>