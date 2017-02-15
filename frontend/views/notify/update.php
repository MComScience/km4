<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbProblem */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Tb Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-problem-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
        'initialPreview' => $initialPreview,
        'initialPreviewConfig' => $initialPreviewConfig,
    ])
    ?>

</div>
