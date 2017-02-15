<?php 
use yii\helpers\Html;
?>
<ul class="nav nav-tabs nav-justified" id="myTab">
    <li class="tab-success TabA">
        <a data-toggle="tab" href="#TabA">
            <?= Html::encode('สถานะสินค้าคงคลัง : ยา'); ?>
        </a>
    </li>
    <li class="tab-success TabB">
        <a data-toggle="tab" href="#TabB">
            <?= Html::encode('สถานะสินค้าคงคลัง : เวชภัณฑ์'); ?>
        </a>
    </li>
    <li class="tab-success TabC">
        <a data-toggle="tab" href="#TabC">
            <?= Html::encode('รายงาน'); ?>
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$("li.TabA").click(function (e) {               
    window.location.replace("index.php?r=Inventory/dashboard/ivstatus");
});
$("li.TabB").click(function (e) {               
    window.location.replace("index.php?r=Inventory/dashboard/status-drug");
});
$("li.TabC").click(function (e) {               
    window.location.replace("index.php?r=Inventory/dashboard/report");
});        
JS;
$this->registerJs($script);
?>
