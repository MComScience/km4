<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwQuPricelist */

$this->title = 'Update Vw Qu Pricelist: ' . ' ' . $model->ids_qu;
$this->params['breadcrumbs'][] = ['label' => 'Vw Qu Pricelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ids_qu, 'url' => ['view', 'id' => $model->ids_qu]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vw-qu-pricelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
