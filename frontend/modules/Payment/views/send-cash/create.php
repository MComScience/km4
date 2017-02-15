<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepList */

$this->title = 'Create Vw Fi Rep List';
$this->params['breadcrumbs'][] = ['label' => 'Vw Fi Rep Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-fi-rep-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
