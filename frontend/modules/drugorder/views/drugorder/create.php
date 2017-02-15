<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\drugorder\models\Tbcpoe */

$this->title = 'Create Tbcpoe';
$this->params['breadcrumbs'][] = ['label' => 'Tbcpoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbcpoe-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
