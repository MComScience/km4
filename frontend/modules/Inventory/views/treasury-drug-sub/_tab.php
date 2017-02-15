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
</ul>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Inventory/treasury-drug-sub/list-drug");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Inventory/treasury-drug-sub/list-nondrug");
});
JS;
$this->registerJs($script);
?>
