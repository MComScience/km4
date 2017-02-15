<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepList */

$this->title = 'Update Vw Fi Rep List: ' . ' ' . $model->rep_id;
$this->params['breadcrumbs'][] = ['label' => 'Vw Fi Rep Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rep_id, 'url' => ['view', 'id' => $model->rep_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vw-fi-rep-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
