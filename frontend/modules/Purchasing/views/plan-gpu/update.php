<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

$this->title = 'ปรับปรุงแผนจัดชื้อยาสามัญ' . ' ';// . $model->PCPlanNum;
$this->params['breadcrumbs'][] = ['label' => 'บันทึกแผน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PCPlanNum, 'url' => ['view', 'id' => $model->PCPlanNum]];
$this->params['breadcrumbs'][] = 'ปรับปรุงแผนจัดชื้อยาสามัญ';
?>
<div class="tb-pcplan-update">

    <!--<h4><?php // Html::encode($this->title) ?></h4>-->

    <?= $this->render('_form', [
        'model' => $model,
        'section'=> $section,
        'tbpcplangpu'=>$tbpcplangpu,
        'types'=>''
    ]);
        ?>

</div>
