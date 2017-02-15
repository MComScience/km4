<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

$this->title = 'ปรับปรุงแผนจัดชื้อเวชภัณฑ์' . ' '; $model->PCPlanNum;
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PCPlanNum];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-pcplan-update">
    <?= $this->render('_form', [
        'model' => $model,
         'section'=> $section,
         'tbpcplangpu'=>$tbpcplangpu,
        'types'=>''
    ]) ?>

</div>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#addnondrugms").addClass("active");
     $("#effectivedate").datepicker({});
    '); ?>
