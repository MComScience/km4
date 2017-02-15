<?php

use yii\helpers\Html;

//$VwPo2Postatuscount = app\modules\Purchasing\models\VwPo2Postatuscount::find()->all();
?>

    <ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('Price List : เวซภัณฑ์') ?> <span ><?php // echo '(' . $VwPo2Postatuscount[0]['POStatusCount'] . ')'; ?></span>
            </a>
        </li>
    </ul>

<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index");
});
JS;
$this->registerJs($script);
?>