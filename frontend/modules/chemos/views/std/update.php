<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\std\TbStdTrpChemo */

$this->title = 'Update Tb Std Trp Chemo: ' . $model->std_trp_chemo_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Std Trp Chemos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->std_trp_chemo_id, 'url' => ['view', 'id' => $model->std_trp_chemo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-std-trp-chemo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
