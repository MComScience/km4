<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

$this->title = 'ปรับปรุงแผนจัดชื้อยาการค้า';
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PCPlanNum, 'url' => ['view', 'id' => $model->PCPlanNum]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-pcplan-update">
    <?= $this->render('_form', [
        'model' => $model,
        'section'=> $section,
        'tbpcplangpu'=>$tbpcplangpu,
        'types'=>''
    ]);
        ?>

</div>
