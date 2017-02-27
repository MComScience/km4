<?php
use yii\helpers\Html;
?>

<ul class="nav nav-tabs" id="myTab">
    <li id="tab_nk" class="<?= Yii::$app->controller->id=='import-excel-nk'?'active':''; ?>">
        <a data-toggle="tab" href="#tab">
            <?= Html::encode('นำเข้าไฟล์ นค.1') ?> <span ><?php  //echo '(' . $countInv . ')'; ?></span>
        </a>
    </li>
    
</ul>
<?php
$script = <<< JS
$("#tab_nk").click(function (e) {
   window.location.replace("/km4/Payment/import-excel-nk/index");      
});
JS;
$this->registerJs($script);
?>