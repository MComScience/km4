<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

$this->title = 'ปรับปรุงจะชื้อจะขายเวชภัณฑ์' . ' '; $model->PCPlanNum;
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PCPlanNum];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-pcplan-update">

    <?= $this->render('_form', [
        'model' => $model,
         'section'=> $section,
         'tbpcplangpu'=>$tbpcplangpu,
        'types'=>'',
        'vendername'=>$vendername
    ]) ?>

</div>
<?php $this->registerJs('
       $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#sale").addClass("active");
     $("#effectivedate").datepicker({});
    '); ?>
