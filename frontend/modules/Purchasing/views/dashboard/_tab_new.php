<?php 
use yii\helpers\Html;
?>
<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success TabA">
        <a data-toggle="tab" href="#home">
            <?= Html::encode('สถานะคงคลัง : ยา'); ?>
        </a>
    </li>

    <li class="tab-success TabB">
        <a data-toggle="tab" href="#profile">
            <?= Html::encode('สถานะคงคลัง : เวชภัณฑ์'); ?>
        </a>
    </li>
    
    <li class="tab-success TabC">
        <a data-toggle="tab" href="#profile">
            <?= Html::encode('รายงาน'); ?>
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$("li.TabA").click(function (e) {               
    window.location.replace("index.php?r=Purchasing/dashboard/prstatus");
});
$("li.TabB").click(function (e) {               
    window.location.replace("index.php?r=Purchasing/dashboard/status-drug");
});
$("li.TabC").click(function (e) {               
    window.location.replace("index.php?r=Purchasing/dashboard/report");
});        
JS;
$this->registerJs($script);
?>