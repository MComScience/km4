<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwStkrefillStatus */

$this->title = 'Update Vw Stkrefill Status: ' . $model->StkID;
$this->params['breadcrumbs'][] = ['label' => 'Vw Stkrefill Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->StkID, 'url' => ['view', 'id' => $model->StkID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vw-stkrefill-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
