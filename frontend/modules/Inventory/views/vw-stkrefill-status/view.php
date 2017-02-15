<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwStkrefillStatus */

$this->title = $model->StkID;
$this->params['breadcrumbs'][] = ['label' => 'Vw Stkrefill Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-stkrefill-status-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->StkID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->StkID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'StkID',
            'StkName',
            'ItemID',
            'ItemNDMedSupply',
            'ItemName',
            'DispUnit',
            'ItemQtyBalance',
            'ItemTargetLevel',
            'target_stk_diff',
        ],
    ]) ?>

</div>
