<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbItemndmedsupply */

$this->title = 'บันทึกหมวดเวชภัณฑ์ย่อย';
$this->params['breadcrumbs'][] = ['label' => 'รายการหมวดเวชภัณฑ์ย่อย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-itemndmedsupply-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
