<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbGr2Temp */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tb Gr2 Temp',
]) . ' ' . $model->GRID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Gr2 Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GRID, 'url' => ['view', 'id' => $model->GRID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tb-gr2-temp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
