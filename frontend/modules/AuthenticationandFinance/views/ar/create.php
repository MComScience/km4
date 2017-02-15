<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\AuthenticationandFinance\models\VwArList */

$this->title = 'Create Vw Ar List';
$this->params['breadcrumbs'][] = ['label' => 'Vw Ar Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-ar-list-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modelpaymentcondition'=>$modelpaymentcondition,
         'modelardetail' => $modelardetail,
         'amphur' => [],
        'district' => []
    ]) ?>

</div>
