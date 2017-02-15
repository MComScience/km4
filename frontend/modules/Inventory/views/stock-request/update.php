<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\Tbsr2temp */

$this->title = 'บันทึกใบขอเบิกสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'บันทึกใบขอเบิกสินค้า', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->SRID, 'url' => ['view', 'id' => $model->SRID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbsr2temp-update">
    <?= $this->render('_form', [
       'model' => $model,
        'section' => $section,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'SRID' => $SRID
    ]) ?>

</div>
