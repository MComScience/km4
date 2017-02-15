<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TbItem */

$this->title = $model->ItemID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->ItemID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->ItemID], [
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
            'ItemID',
            'ItemCatID',
            'ItemNDMedSupplyCatID',
            'ItemName',
            'TMTID_TPU',
            'TMTID_GPU',
            'TMTID_GP',
            'ItemSpecPrep',
            'ItemStdUnitPrice',
            'ItemDateUpdateStdPrice',
            'ItemDateEffectiveStdPrice',
            'ItemPackPrice',
            'ItemPackSize',
            'ItemUpdateFlag',
            'ItemDateChange',
            'ItemAutoLotNum',
            'ItemExpDateControl',
            'ItemReorderLevel',
            'ItemTargetLevel',
            'ItemMinOrderQty',
            'ItemStatusID',
            'itemdosageform',
            'itemstmum',
            'itemstrunit',
            'itemstrdeno',
            'itemstrdennounit',
            'itemContVal',
            'itemContUnit',
            'itemDispUnit',
            'itemPackSizeUnit',
            'itempBarcodeNum',
            'itemMinOrderLeadtime:datetime',
            'ref',
            'ItemPic1',
            'ItemPic2',
            'ItemPic3',
            'ItemPic4',
            'ItemPackVal',
        ],
    ]) ?>

</div>
