<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPr2Temp */

$this->title = 'Update Tb Pr2 Temp: ' . ' ' . $model->PRID;
$this->params['breadcrumbs'][] = ['label' => 'Tb Pr2 Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PRID, 'url' => ['view', 'id' => $model->PRID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-pr2-temp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'view' => $view,
        'ids_PR_selected' => $ids_PR_selected,
    ]) ?>

</div>
