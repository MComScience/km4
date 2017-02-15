<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiInvCrList */

$this->title = 'Update Vw Fi Inv Cr List: ' . ' ' . $model->inv_id;
$this->params['breadcrumbs'][] = ['label' => 'Vw Fi Inv Cr Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inv_id, 'url' => ['view', 'id' => $model->inv_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vw-fi-inv-cr-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
