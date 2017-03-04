<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\chemo\models\std\TbStdTrpChemo */

$this->title = 'Create Tb Std Trp Chemo';
$this->params['breadcrumbs'][] = ['label' => 'Tb Std Trp Chemos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-std-trp-chemo-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
