<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\chemo\models\TbCpoeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tb Cpoes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-cpoe-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tb Cpoe', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cpoe_id',
            'cpoe_schedule_type',
            'cpoe_type',
            'cpoe_num',
            'pt_vn_number',
            // 'cpoe_date',
            // 'cpoe_order_by',
            // 'cpoe_order_section',
            // 'cpoe_comment',
            // 'cpoe_status',
            // 'cpoe_createby',
            // 'pt_trp_regimen_paycode',
            // 'pt_trp_chemo_id',
            // 'chemo_regimen_ids',
            // 'chemo_cycle_seq',
            // 'chemo_cycle_day',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
