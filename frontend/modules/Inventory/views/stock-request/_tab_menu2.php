<?php

use kartik\helpers\Html;
?>
<ul class="nav nav-tabs " id="myTab">
    <li id="tab_B">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("ใบขอเบิกสินค้ารออนุมัติ") ?> 
        </a>
    </li>  

    <li id="tab_E">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("ประวัติใบขอเบิกสินค้า") ?> 
        </a>
    </li>  
</ul>
<?php
$script = <<< JS

$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Inventory/stock-request/wait-approve-pharmacy");
});

$("#tab_E").click(function (e) {               
window.location.replace("index.php?r=Inventory/stock-request/history-pharmacy");
});

JS;
$this->registerJs($script);
?>
