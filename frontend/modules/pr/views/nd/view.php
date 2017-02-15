<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pr\models\TbPr2Temp */

$this->title = $model->PRID;
$this->params['breadcrumbs'][] = ['label' => 'Tb Pr2 Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pr2-temp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PRID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PRID], [
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
            'PRID',
            'PRNum',
            'PRDate',
            'DepartmentID',
            'SectionID',
            'PRTypeID',
            'PRReasonNote',
            'POTypeID',
            'POContactNum',
            'PRExpectDate',
            'VendorID',
            'PRSubtotal',
            'PRVat',
            'PRTotal',
            'PRSummitted',
            'PRSummitedBy',
            'PRSummitedDate',
            'PRSummitedTime',
            'PRStatusID',
            'PRApprovalID',
            'PRRejectID',
            'PRCreatedBy',
            'PRCreatedDate',
            'PRCreatedTime',
            'PRRejectDate',
            'PRApprovaDate',
            'PRApprovatime',
            'PRStatus',
            'PRRejectReason',
            'PRRejectTime',
            'PCPlanNum',
            'ids_PR_selected',
            'PRVerifyNote',
            'PRbudgetID',
        ],
    ]) ?>

</div>
