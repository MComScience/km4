<?php
use yii\helpers\Html;
$action = Yii::$app->controller->action->id;
$script = <<< JS
    $("li.TabA").click(function (e) {
        window.location.replace("index");
    });
    $("li.TabB").click(function (e) {
        window.location.replace("order-status");
    });
    $("li.TabC").click(function (e) {
        
    });
JS;
$this->registerJs($script);
?>

<ul class="nav nav-tabs" id="myTab">
    <li class="tab-success TabA <?php echo $action == 'index' ? 'active' : ''?>">
        <a data-toggle="tab" href="#TabA">
            <?= Html::encode('รายชื่อผู้ป่วยนอก'); ?>
        </a>
    </li>

    <li class="tab-success TabB <?php echo $action == 'order-status' ? 'active' : ''?>">
        <a data-toggle="tab" href="#TabB">
            <?= Html::encode('สถานะใบสั่งยา'); ?>
        </a>
    </li>

    <li class="tab-success TabC">
        <a data-toggle="tab" href="#TabC">
            <?= Html::encode('ใบสั่งยารออนุมัติ'); ?>
        </a>
    </li>
</ul>
