<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

$this->title = 'บันทึกตั้งต้นสินค้าคงคลัง';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ตั้งต้นยอดสินค้าคงคลัง', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-gr2-temp-create">
     <?= $this->render('_form', [
                'modelGR' => $modelGR,
                'model' => $model,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'view' => $view,
                'stkname'=>$stkname,
    ]) ?>

</div>
