<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwStkrefillStatus */

$this->title = 'Create Vw Stkrefill Status';
$this->params['breadcrumbs'][] = ['label' => 'Vw Stkrefill Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-stkrefill-status-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
