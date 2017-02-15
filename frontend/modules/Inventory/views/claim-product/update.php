<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSt2Temp */

$this->title = 'Update Tb St2 Temp: ' . ' ' . $model->STID;
$this->params['breadcrumbs'][] = ['label' => 'Tb St2 Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->STID, 'url' => ['view', 'id' => $model->STID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-st2-temp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
