<?php

use yii\helpers\Html;
$action = Yii::$app->controller->action->id;
?>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li>
        <a style="text-align: left">
            <b class="success">Drug Allergic : </b>Drug1 Drug2 Drug3 Drug4
        </a>
    </li>
    <li>
        <a style="text-align: right">
            <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Detail</button>
            <button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
        </a>

    </li>
</ul>
<ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
    <li>
        <a style="text-align: left">
            <b class="success">Last Diagnosis : </b>Dx1 Dx2 Dx3 Dx4
        </a>
    </li>
    <li>
        <a style="text-align: right">
            <b class="success">Last Dx Date : </b>10/04/2559 &nbsp;
            <button class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt"></i> Detail</button>
            <button class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Dx</button>
        </a>

    </li>
</ul>
<ul class="nav nav-tabs tabs-flat  nav-justified bg-white" id="myTab11">
    <li class="tab-success history <?php echo $action == 'order-history' ? 'active' : ''?>">
        <a data-toggle="tab" id="Patient" href="#Patient">
            <?= Html::encode('ประวัติการสั่งยา'); ?>
        </a>
    </li>
    <li class="tab-success orderchemo <?php echo $action == 'order-chemo' ? 'active' : ''?>">
        <a data-toggle="tab" href="#settings" id="orderset">
            <?= Html::encode('ใบสั่งยา'); ?>
        </a>
    </li>
    <?php /*
    <li class="tab-success order">
        <a data-toggle="tab" href="#settings" id="orderset">
            <?= Html::encode('ใบสั่งยา'); ?>
        </a>
    </li>
    */?>
    <li class="tab-success">
        <a data-toggle="tab" href="#settings">
            <?= Html::encode('สถานะใบสั่งยา'); ?>
        </a>
    </li>

</ul>
<?php
$script = <<< JS
$("li.history").click(function (e) {               
    window.location.replace("index.php?r=pharmacy/rx/order-history&data=$profile->pt_visit_number");
});
$("li.orderchemo").click(function (e) {               
    location.reload();
});
$("#orderset").click(function (e) {               
    location.reload();
});
JS;
$this->registerJs($script);
?>