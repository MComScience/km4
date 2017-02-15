<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\TbpttrpChemo */

$this->title = $model->pt_trp_chemo_id;
$this->params['breadcrumbs'][] = ['label' => 'Tbpttrp Chemos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbpttrp-chemo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->pt_trp_chemo_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->pt_trp_chemo_id], [
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
            'pt_trp_chemo_id',
            'pt_trp_regimen_name',
            'pt_hospital_number',
            'medical_right_id',
            'credit_group_id',
            'pt_trp_regimen_id',
            'pt_trp_credit_id',
            'pt_trp_regimen_paycode',
            'pt_trp_cpr_number',
            'pt_trp_ocpa_number',
            'pt_trp_regimen_status',
            'pt_trp_regimen_createby',
            'pt_trp_comment',
            'pt_visit_number',
        ],
    ]) ?>

</div>
