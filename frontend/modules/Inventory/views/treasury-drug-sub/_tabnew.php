<?php

use yii\bootstrap\Html;
?>
<ul class="nav nav-tabs " id="myTab5">
    <li id="tab_A">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('สถานะสินค้าคงคลัง : ยา') ?> 
        </a>
    </li>  
    <li id="tab_B">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('สถานะสินค้าคงคลัง : เวชภันฑ์') ?> 
        </a>
    </li> 
    <li id="tab_C">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('บัญชียาโรงพยาบาล') ?> 
        </a>
    </li> 
    <li id="tab_D">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('บัญชีเวชภันฑ์โรงพยาบาล') ?> 
        </a>
    </li> 
</ul>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Inventory/treasury-drug-sub/list-drugnew");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Inventory/treasury-drug-sub/list-nondrugnew");
});
        $("#tab_C").click(function (e) {               
window.location.replace("index.php?r=Inventory/status-inventory");
});
         $("#tab_D").click(function (e) {               
window.location.replace("index.php?r=Inventory/status-inventory/list-ndgroup");
});
JS;
$this->registerJs($script);
?>
