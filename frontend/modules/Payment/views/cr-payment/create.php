<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiInvCrList */

$this->title = 'Create Vw Fi Inv Cr List';
$this->params['breadcrumbs'][] = ['label' => 'Vw Fi Inv Cr Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-fi-inv-cr-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
