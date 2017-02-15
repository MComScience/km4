<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbDrugsubclass */

$this->title = 'บันทึกรายการหมวดยาย่อย';
$this->params['breadcrumbs'][] = ['label' => 'รายการหมวดยาย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-drugsubclass-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
