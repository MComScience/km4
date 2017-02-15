<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbItemndmedsupply */

$this->title = 'แก้ไข: ' . ' ' . $model->ItemNDMedSupplyCatID;
$this->params['breadcrumbs'][] = ['label' => 'บันทึกเวชภัณฑ์หมวดย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ItemNDMedSupplyCatID, 'url' => ['view', 'id' => $model->ItemNDMedSupplyCatID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-itemndmedsupply-update">

   
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
