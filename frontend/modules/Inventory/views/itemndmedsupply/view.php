<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbItemndmedsupply */

$this->title = $model->ItemNDMedSupplyCatID;
$this->params['breadcrumbs'][] = ['label' => 'Tb Itemndmedsupplies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-itemndmedsupply-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ItemNDMedSupplyCatID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ItemNDMedSupplyCatID], [
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
            'ItemNDMedSupplyCatID',
            'ItemNDMedSupply',
            'ItemNDMedSupplyDesc',
            'ItemNDMedSupplyCatID_sub',
        ],
    ]) ?>

</div>
