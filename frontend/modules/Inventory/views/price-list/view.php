<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwQuPricelist */

$this->title = $model->ids_qu;
$this->params['breadcrumbs'][] = ['label' => 'Vw Qu Pricelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-qu-pricelist-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ids_qu], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ids_qu], [
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
            'ids_qu',
            'VendorID',
            'ItemCatID',
            'ItemNDMedSupplyCatID',
            'TMTID_TPU',
            'ItemName',
            'itemContVal',
            'itemContUnit',
            'itemDispUnit',
            'QUMQO',
            'QUPackQty',
            'QUPackCost',
            'QUOrderQty',
            'QUUnitCost',
            'QUValidDate',
            'QULeadtime:datetime',
            'QUQty',
            'QUUnit',
            'QUUnitCost2',
        ],
    ]) ?>

</div>
