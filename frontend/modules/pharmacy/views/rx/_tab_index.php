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
    <?php /*
    <li class="tab-success TabA <?php echo $action == 'index' ? 'active' : ''?>">
        <a data-toggle="tab" href="#TabA">
            <?= Html::encode('รายชื่อผู้ป่วยนอก'); ?>
        </a>
    </li>*/?>

    <li class="tab-success TabB <?php echo $action == 'order-status' ? 'active' : ''?>">
        <a data-toggle="tab" href="#TabB">
            <?= Html::encode('สถานะใบสั่งยา'); ?>
        </a>
    </li>

    <li class="tab-success <?php echo $action == 'history' ? 'active' : ''?>">
        <a href="<?= yii\helpers\Url::to(['/pharmacy/rx/history']) ?>">
            <?= Html::encode('ประวัติใบสั่งยา'); ?>
        </a>
    </li>
</ul>
