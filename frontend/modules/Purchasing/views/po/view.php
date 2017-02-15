<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPo2Temp */

$this->title = $model->POID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Po2 Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-po2-temp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->POID], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->POID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'POID',
            'PONum',
            'PRNum',
            'PODate',
            'DepartmentID',
            'SectionID',
            'POContID',
            'POTypeID',
            'PODueDate',
            'VendorID',
            'POSubtotal',
            'POVat',
            'POTotal',
            'POStatus',
            'POCreateBy',
            'POCreateDate',
            'POCreateTime',
            'POVerifyBy',
            'POVerifyDate',
            'POApproveBy',
            'POApproveDate',
            'PORejectVerifyBy',
            'PORejectVerifyDate',
            'PORejectApproveBy',
            'PORejectApproveDate',
            'PCPlanNum',
            'PRTypeID',
        ],
    ])
    ?>

</div>
<script>
    
</script>