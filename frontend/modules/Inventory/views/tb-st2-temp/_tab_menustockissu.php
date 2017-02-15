<?php

use kartik\helpers\Html;
?>
<ul class="nav nav-tabs " id="myTab">
    <li id="tab_B">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("รายการใบขอเบิกสินค้า") ?> 
        </a>
    </li>  

    <li id="tab_E">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("ร่างใบโอนสินค้า") ?> 
        </a>
    </li>
    <li id="tab_F">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("ใบโอนสินค้ารอรับเข้า") ?> 
        </a>
    </li>
    <li id="tab_T">
        <a data-toggle="tab" href="#tab" >
            <?= Html::encode("ประวัติใบโอนสินค้า") ?> 
        </a>
    </li>  
</ul>
<?php
$script = <<< JS

$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Inventory/tb-st2-temp/spicking");
});

$("#tab_E").click(function (e) {               
window.location.replace("index.php?r=Inventory/tb-st2-temp/");
});

$("#tab_F").click(function (e) {               
window.location.replace("index.php?r=Inventory/tbst2/stock-receive");
});

$("#tab_T").click(function (e) {               
window.location.replace("index.php?r=Inventory/tbst2/stock-receive-history");
});
JS;
$this->registerJs($script);
?>
