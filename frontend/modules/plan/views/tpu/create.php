<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\plan\models\TbPcplan */

$this->title = 'Create Tb Pcplan';
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pcplan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
