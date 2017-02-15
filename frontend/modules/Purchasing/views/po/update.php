<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPo2Temp */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Tb Po2 Temp',
]) . ' ' . $model->POID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Po2 Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->POID, 'url' => ['view', 'id' => $model->POID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tb-po2-temp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
