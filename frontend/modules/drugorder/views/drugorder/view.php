<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\drugorder\models\Tbcpoe */

$this->title = $model->cpoe_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbcpoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbcpoe-view">

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
        ],
    ]) ?>

</div>
