<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

if ($modelST['STStatus']== 1){
    $this->title = "บันทึกใบให้ยืมสินค้า";
}
else if ($modelST['STStatus']== 2){
    $this->title = "ใบให้ยืมรอคืนสินค้า";
}
else if ($modelST['STStatus']== 20 || $modelST['STStatus']== 21 ){
    $this->title = "ประวัติใบให้ยืมสินค้า";
}
else{
  $this->title = "บันทึกใบให้ยืมสินค้า";
}
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ให้ยืนสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-st2-temp-create">
     <?= $this->render('_form', [
        'modelST' => $modelST,
        'vendername'=>$vendername,
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'view' => $view,
    ]) ?>

</div>
