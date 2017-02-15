<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbDrugsubclass */

$this->title = 'แก้ไข: ' . ' ' . $model->DrugSubClassID;
$this->params['breadcrumbs'][] = ['label' => 'บันทึกหมวดยาย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DrugSubClassID, 'url' => ['view', 'id' => $model->DrugSubClassID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-drugsubclass-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
