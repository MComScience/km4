<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwSaList */

$this->title = 'บันทึกปรับปรุงยอดสินค้าคงคลัง';
$this->params['breadcrumbs'][] = ['label' => 'บันทึกปรับปรุงยอดสินค้าคงคลัง', 'url' => ['index']];
?>
<div class="vw-sa-list-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'appvo' => $appvo
    ])
    ?>

</div>
