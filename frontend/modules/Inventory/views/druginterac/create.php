<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\Tbdruginteraction */

$this->title = Yii::t('app', 'Create Tbdruginteraction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tbdruginteractions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbdruginteraction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
