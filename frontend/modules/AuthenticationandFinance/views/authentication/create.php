<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\AuthenticationandFinance\models\VwPtRegistedList */

$this->title = 'Create Vw Pt Registed List';
$this->params['breadcrumbs'][] = ['label' => 'Vw Pt Registed Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-pt-registed-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
