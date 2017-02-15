<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\VwSaList */

$this->title = 'อนุมัติปรับปรุงยอดสินค้าคงคลัง';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>
<div class="vw-sa-list-update">
	<?=
    $this->render('_form_approve', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'appvo' => $appvo
    ])
    ?>

</div>
