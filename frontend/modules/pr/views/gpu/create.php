<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pr\models\TbPr2Temp */

$this->title = Yii::t('app', 'Create Tb Pr2 Temp');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tb Pr2 Temps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pr2-temp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
