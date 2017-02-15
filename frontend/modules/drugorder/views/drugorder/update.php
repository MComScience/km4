<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\drugorder\models\Tbcpoe */

$this->title = 'Update Tbcpoe: ' . $model->cpoe_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbcpoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cpoe_id, 'url' => ['view', 'id' => $model->cpoe_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbcpoe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
