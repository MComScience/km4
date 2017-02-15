<?php
use yii\helpers\Html;
?>
<ul class="nav nav-tabs" id="myTab">
        <li class="tab-success" id="tab_A">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รายการยา') ?> <span></span>
            </a>
        </li>

        <li class="tab-success" id="tab_B">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('รายการเวชภัณฑ์') ?> <span ></span>
            </a>
        </li>
        
        <li class="tab-success" id="tab_C">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('GPU รอสร้างใบขอซื้อ') ?> <span ></span>
            </a>
        </li>
        
        <li class="tab-success" id="tab_D">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('TPU รอสร้างใบขอซื้อ') ?> <span ></span>
            </a>
        </li>
        
        <li class="tab-success" id="tab_E">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ND รอสร้างใบขอซื้อ') ?> <span ></span>
            </a>
        </li>
        
        <li class="tab-success" id="tab_F">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('TPU Cont รอสร้างใบขอซื้อ') ?> <span ></span>
            </a>
        </li>
        
        <li class="tab-success" id="tab_G">
            <a data-toggle="tab" href="#tab">
                <?= Html::encode('ND Cont รอสร้างใบขอซื้อ') ?> <span ></span>
            </a>
        </li>
    </ul>
<?php
$script = <<< JS
$("#tab_A").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/index");
});
$("#tab_B").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/list-nd");
});
$("#tab_C").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/detailgpu");
});
$("#tab_D").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/detailtpu");
});
$("#tab_E").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/detailnd");
});
$("#tab_F").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/detailplantpu");
});
$("#tab_G").click(function (e) {               
window.location.replace("index.php?r=Inventory/stocks-balance/detailplannd");
});
JS;
$this->registerJs($script);
?>
