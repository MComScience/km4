<?php
use yii\helpers\Html;

$this->title = 'บันทึกสัญญาจะชื้อจะขายยา';
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