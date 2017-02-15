<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepList */

$this->title = $model->rep_id;
$this->params['breadcrumbs'][] = ['label' => 'Vw Fi Rep Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-fi-rep-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rep_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rep_id], [
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
            'rep_id',
            'inv_id',
            'rep_num',
            'pt_name',
            'repdate',
            'pt_hospital_number',
            'pt_visit_number',
            'pt_admission_number',
            'createby',
            'rep_status',
            'sum_cash',
            'sum_creditcard',
            'sum_cheque',
            'sum_banktransfer',
            'rep_Amt_total',
            'rep_Amt_discount',
            'rep_Amt_left',
            'rep_Amt_net',
            'rep_summary_id',
            'rep_create_section',
        ],
    ]) ?>

</div>
