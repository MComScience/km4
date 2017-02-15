<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

$this->title = 'Update Tb Gr2 Temp: ' . ' ' . $model->GRID;
$this->params['breadcrumbs'][] = ['label' => 'Tb Gr2 Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GRID, 'url' => ['view', 'id' => $model->GRID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-gr2-temp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
