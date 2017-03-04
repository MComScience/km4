<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\TbCpoe */

$this->title = 'Create Tb Cpoe';
$this->params['breadcrumbs'][] = ['label' => 'Tb Cpoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-cpoe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
