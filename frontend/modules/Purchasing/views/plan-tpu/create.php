<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

$this->title = 'บันทึกแผนการจัดชื้อยาการค้า';
$this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pcplan-create">
    <?= $this->render('_form', [
        'model' => $model,
        'section'=> [],
        'tbpcplangpu'=>$tbpcplangpu,
        'types'=>$types
    ]) ?>

</div>

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