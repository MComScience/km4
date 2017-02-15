<?php
use yii\helpers\Html;
?>            
<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success" id="tabA">
        <a data-toggle="tab" href="#tabA">
            <?= Html::encode('ราชื่อผู้ป่วยนอก') ?>
        </a>
    </li>
    <li class="tab-success" id="tabB">
        <a data-toggle="tab" href="#tabB">
            <?= Html::encode('สถานะใบสั่งยา') ?>
        </a>
    </li>
    <li class="tab-success" id="tabC">
        <a data-toggle="tab" href="#tabC">
            <?= Html::encode('ใบสั่งยารออนุมัติ') ?>
        </a>
    </li>
</ul>
<?php
$script = <<< JS
$("#tabA").click(function (e) {               
window.location.replace("index.php?r=cpoes");
});
$("#tabB").click(function (e) {               
window.location.replace("index.php?r=cpoes/default/order-status");
});
$("#tabC").click(function (e) {               
//window.location.replace("index.php?r=/#");
});
JS;
$this->registerJs($script);
?>