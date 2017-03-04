<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\std\TbStdTrpChemo */

$this->title = $model->std_trp_chemo_id;
$this->params['breadcrumbs'][] = ['label' => 'Tb Std Trp Chemos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-std-trp-chemo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->std_trp_chemo_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->std_trp_chemo_id], [
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
            'std_trp_chemo_id',
            'std_trp_regimen_name',
            'medical_right_id',
            'credit_group_id',
            'std_trp_regimen_id',
            'std_trp_credit_id',
            'std_trp_regimen_paycode',
            'std_trp_comment',
            'std_trp_regimen_createby',
            'std_trp_regimen_date',
            'std_trp_regimen_status',
            'dx_code',
            'ca_stage_code',
            'regimen_for_cr',
            'std_trp_for_op',
            'std_trp_for_ip',
        ],
    ]) ?>

</div>
