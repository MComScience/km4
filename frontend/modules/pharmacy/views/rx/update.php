<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pharmacy\models\TbCpoe */

$this->title = 'Update Tb Cpoe: ' . $model->cpoe_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Cpoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cpoe_id, 'url' => ['view', 'id' => $model->cpoe_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-cpoe-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
