<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\purqr\models\tbqr2 */

$this->title = 'Update Tbqr2: ' . $model->QRID;
$this->params['breadcrumbs'][] = ['label' => 'Tbqr2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->QRID, 'url' => ['view', 'id' => $model->QRID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbqr2-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
