<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Receipopdandipd\models\KM4GETPTADMIT */

$this->title = 'Create Km4 Getptadmit';
$this->params['breadcrumbs'][] = ['label' => 'Km4 Getptadmits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="km4-getptadmit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
