<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTADMIT */

$this->title = 'Update Km4 Getptadmit: ' . ' ' . $model->PT_HOSPITAL_NUMBER;
$this->params['breadcrumbs'][] = ['label' => 'Km4 Getptadmits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PT_HOSPITAL_NUMBER, 'url' => ['view', 'id' => $model->PT_HOSPITAL_NUMBER]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="km4-getptadmit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
