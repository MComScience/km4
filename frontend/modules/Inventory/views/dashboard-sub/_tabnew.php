<?php

use yii\bootstrap\Html;
?>
<ul class="nav nav-tabs " id="myTab5">
    <li id="tab_A">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('ยาการค้า') ?> 
        </a>
    </li>  
    <li id="tab_B">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('เวชภัณฑ์มิใช่ยา') ?> 
        </a>
    </li>
    <li id="tab_D">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('วัสดุการแพทย์') ?> 
        </a>
    </li>
    <li id="tab_E">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('งานจ่ายกลาง') ?> 
        </a>
    </li>
    <li id="tab_F">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('วัสดุวิทยาศาสตร์') ?> 
        </a>
    </li>
    <li id="tab_C">
        <a data-toggle="tab" href="#home5">
<?= Html::encode('งานพัสดุ') ?> 
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
        window.location.replace("index.php?r=Inventory/dashboard-sub/list-drugnew");
    });
    $("#tab_B").click(function (e) {               
        window.location.replace("index.php?r=Inventory/dashboard-sub/list-nondrugnew");
    });
    $("#tab_C").click(function (e) {               
        window.location.replace("index.php?r=Inventory/dashboard-sub/list-parcel");
    });
    $("#tab_D").click(function (e) {               
        window.location.replace("index.php?r=Inventory/dashboard-sub/list-biomaterial");
    });
    $("#tab_E").click(function (e) {               
        window.location.replace("index.php?r=Inventory/dashboard-sub/list-cssd");
    });
    $("#tab_F").click(function (e) {               
        window.location.replace("index.php?r=Inventory/dashboard-sub/list-sciencematerials");
    });
    $("#tab_G").click(function (e) {               
        window.location.replace("index.php?r=Inventory/dashboard-sub/report");
    });
JS;
$this->registerJs($script);
?>
