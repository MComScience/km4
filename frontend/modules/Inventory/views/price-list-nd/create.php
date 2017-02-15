<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwQuPricelist */

$this->title = 'Create Vw Qu Pricelist';
$this->params['breadcrumbs'][] = ['label' => 'Vw Qu Pricelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-qu-pricelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
