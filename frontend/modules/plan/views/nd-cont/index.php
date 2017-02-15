<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\plan\models\TbPcplanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tb Pcplans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pcplan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tb Pcplan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'PCPlanNum',
            'PCPOContactID',
            'PCPlanDate',
            'DepartmentID',
            'SectionID',
            // 'PCPlanTypeID',
            // 'PCPlanBeginDate',
            // 'PCPlanEndDate',
            // 'PCPlanStatusID',
            // 'PCPlanCreatedBy',
            // 'PCPlanCreatedDate',
            // 'PCPlanCreatedTime',
            // 'Pcplandrugandnondrug',
            // 'PCVendorID',
            // 'PCPlanTotal',
            // 'PCPlanApproveBy',
            // 'PCPlanApproveDate',
            // 'PCPlanApproveTime',
            // 'PCPlanManagerApproveBy',
            // 'PCPlanManagerApproveDate',
            // 'PCPlanManagerApproveTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
