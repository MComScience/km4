<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\po\models\TbPo2Temp */

$this->title = 'Create Tb Po2 Temp';
$this->params['breadcrumbs'][] = ['label' => 'Tb Po2 Temps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-po2-temp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
