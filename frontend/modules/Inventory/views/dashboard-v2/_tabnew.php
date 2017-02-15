<?php

use yii\bootstrap\Html;
?>
<ul class="nav nav-tabs " id="myTab5">
    <li id="tab_A">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('Stock Banlance') ?> 
        </a>
    </li>  
    <li id="tab_G">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('รายงาน') ?> 
        </a>
    </li>  
</ul>
<?php
    $script = <<< JS
    $("#tab_A").click(function (e) {               
        window.location.replace("/km4/Inventory/dashboard-v2/cmd-listdrugnew");
    });
    $("#tab_G").click(function (e) {               
        window.location.replace("/km4/Inventory/dashboard-v2/report");
    });
JS;
$this->registerJs($script);
?>
