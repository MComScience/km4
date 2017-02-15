<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pharmacy\models\TbPtTrpChemo */

$this->title = 'Create Tb Pt Trp Chemo';
$this->params['breadcrumbs'][] = ['label' => 'Tb Pt Trp Chemos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pt-trp-chemo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
