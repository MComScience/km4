<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\TbCpoe */

$this->title = $model->cpoe_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Cpoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-cpoe-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cpoe_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cpoe_id], [
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
            'cpoe_id',
            'cpoe_schedule_type',
            'cpoe_type',
            'cpoe_num',
            'pt_vn_number',
            'cpoe_date',
            'cpoe_order_by',
            'cpoe_order_section',
            'cpoe_comment',
            'cpoe_status',
            'cpoe_createby',
            'pt_trp_regimen_paycode',
            'pt_trp_chemo_id',
            'chemo_regimen_ids',
            'chemo_cycle_seq',
            'chemo_cycle_day',
        ],
    ]) ?>

</div>
