<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Purchasing\models\TbPr2TempSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tb Pr2 Temps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pr2-temp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tb Pr2 Temp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PRID',
            'PRNum',
            'PRDate',
            'DepartmentID',
            'SectionID',
            // 'PRTypeID',
            // 'PRReasonNote',
            // 'POTypeID',
            // 'POContactNum',
            // 'PRExpectDate',
            // 'VendorID',
            // 'PRSubtotal',
            // 'PRVat',
            // 'PRTotal',
            // 'PRSummitted',
            // 'PRSummitedBy',
            // 'PRSummitedDate',
            // 'PRSummitedTime',
            // 'PRStatusID',
            // 'PRApprovalID',
            // 'PRRejectID',
            // 'PRCreatedBy',
            // 'PRCreatedDate',
            // 'PRCreatedTime',
            // 'PRRejectDate',
            // 'PRApprovaDate',
            // 'PRApprovatime',
            // 'PRStatus',
            // 'PRRejectReason',
            // 'PRRejectTime',
            // 'PCPlanNum',
            // 'ids_PR_selected',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
