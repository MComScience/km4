<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\AuthenticationandFinance\models\VwArList */

$this->title = 'Update Vw Ar List: ' . ' ' . $model->ar_id;
$this->params['breadcrumbs'][] = ['label' => 'Vw Ar Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ar_id, 'url' => ['view', 'id' => $model->ar_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vw-ar-list-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'modelpaymentcondition' => $modelpaymentcondition,
        'modelardetail' => $modelardetail,
        'amphur' => $amphur,
        'district' => $district
    ])
    ?>

</div>
