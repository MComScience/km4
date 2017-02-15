<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwSaList */

$this->title = 'บันทึกปรับปรุงยอดสินค้าคงคลัง';
$this->params['breadcrumbs'][] = ['label' => 'รายการสินค้าคลงคลัง', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vw-sa-list-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'appvo' => $appvo
    ])
    ?>

</div>
