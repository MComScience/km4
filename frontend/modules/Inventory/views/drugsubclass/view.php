<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbDrugsubclass */

$this->title = $model->DrugSubClassID;
$this->params['breadcrumbs'][] = ['label' => 'Tb Drugsubclasses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-drugsubclass-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->DrugSubClassID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->DrugSubClassID], [
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
            'DrugSubClassID',
            'DrugClassID',
            'DrugSubClass',
            'DrugSubClassDesc',
        ],
    ]) ?>

</div>
