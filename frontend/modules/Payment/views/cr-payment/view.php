<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiInvCrList */

$this->title = $model->inv_id;
$this->params['breadcrumbs'][] = ['label' => 'Vw Fi Inv Cr Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-fi-inv-cr-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->inv_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->inv_id], [
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
            'inv_id',
            'inv_num',
            'invdate',
            'pt_hospital_number',
            'VN:AN',
            'pt_name',
            'inv_Amt_total',
            'pt_ar_id',
            'medical_right_group',
            'medical_right_desc',
            'ar_name',
            'cpoe_status',
            'cr_summary_id',
            'cr_summary_section',
            'cr_summary_date',
            'cr_summary_remark',
        ],
    ]) ?>

</div>
