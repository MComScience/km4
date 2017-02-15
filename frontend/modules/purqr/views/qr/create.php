<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\purqr\models\tbqr2 */

$this->title = 'สร้างใบสืบราคาสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ใบสืบราคาสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbqr2-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
