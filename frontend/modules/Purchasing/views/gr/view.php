<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbGr2Temp */

$this->title = $model->GRID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Gr2 Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-gr2-temp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->GRID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->GRID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'GRID',
            'GRNum',
            'GRDate',
            'GRTypeID',
            'PONum',
            'PODate',
            'POType',
            'PRNum',
            'VenderID',
            'PODueDate',
            'GRSubtotal',
            'GRVat',
            'GRTotal',
            'GRStatusID',
            'GRCreatedBy',
            'GRCreatedDate',
            'GRCreatedTime',
            'VenderInvoiceNum',
        ],
    ]) ?>

</div>
