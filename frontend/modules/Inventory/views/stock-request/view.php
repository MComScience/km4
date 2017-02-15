<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSr2Temp */

$this->title = $model->SRID;
$this->params['breadcrumbs'][] = ['label' => 'Tb Sr2 Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-sr2-temp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->SRID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->SRID], [
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
            'SRID',
            'SRDate',
            'SRNum',
            'DepartmentID',
            'SectionID',
            'SRTypeID',
            'SRExpectDate',
            'SRIssue_stkID',
            'SRReceive_stkID',
            'SRStatus',
            'SRCreateBy',
            'SRCreateDate',
            'SRApproveBy',
            'SRApproveDate',
            'SRRejectApproveBy',
            'SRRejectApproveDate',
            'SRNote',
            'SRRejectNote',
        ],
    ]) ?>

</div>
