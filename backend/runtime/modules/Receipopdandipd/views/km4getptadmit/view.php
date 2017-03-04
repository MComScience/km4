<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTADMIT */

$this->title = $model->PT_HOSPITAL_NUMBER;
$this->params['breadcrumbs'][] = ['label' => 'Km4 Getptadmits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="km4-getptadmit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PT_HOSPITAL_NUMBER], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PT_HOSPITAL_NUMBER], [
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
            'PT_HOSPITAL_NUMBER',
            'PT_TITLENAME_ID',
            'PT_FNAME_TH',
            'PT_LNAME_TH',
            'PT_DOB',
            'PT_SEX_ID',
            'PT_NATION_ID',
            'PT_CID',
            'PT_ADMISSION_NUMBER',
            'PT_REGISTRY_DATE',
            'PT_REGISTRY_TIME',
            'PT_REGISTRY_BY',
            'PT_SERVICE_SECTION_ID',
            'PT_SERVICE_FROM_SECTION_ID',
        ],
    ]) ?>

</div>
