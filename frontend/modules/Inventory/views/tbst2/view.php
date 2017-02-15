<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSt2 */

$this->title = $model->STID;
$this->params['breadcrumbs'][] = ['label' => 'Tb St2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-st2-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->STID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->STID], [
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
            'STID',
            'STDate',
            'STNum',
            'STTypeID',
            'SRNum',
            'STCreateBy',
            'STCreateDate',
            'STIssue_StkID',
            'STRecieve_StkID',
            'STRecievedDate',
            'STRecievedBy',
            'STStatus',
            'STPerson',
            'STNote',
            'STDueDate',
        ],
    ]) ?>

</div>
