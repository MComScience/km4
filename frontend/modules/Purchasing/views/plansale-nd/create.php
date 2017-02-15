<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

$this->title = 'บันทึกแผนการสั่งซื้อสินค้าเวชภัณฑ์มิใช่ยา';
$this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pcplan-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'section' => [],
        'tbpcplangpu' => $tbpcplangpu,
        'types' => $types
    ])
    ?>

</div>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#sale").addClass("active");
    $("#effectivedate").datepicker({});
    '); ?>

<?php
$script = <<< JS
$(document).ready(function() {
        var myDate = new Date();
    var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
            (myDate.getFullYear() + 543);
   $("#tbpcplan-pcplandate").val(prettyDate);
        });
JS;
$this->registerJs($script);
?>