<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\TbpttrpChemo */

$this->title = 'Update Tbpttrp Chemo: ' . $model->pt_trp_chemo_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbpttrp Chemos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pt_trp_chemo_id, 'url' => ['view', 'id' => $model->pt_trp_chemo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tbpttrp-chemo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
