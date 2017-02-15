<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

if ($modelST['STStatus']== 1){
    $this->title = "บันทึกใบจ่ายสินค้า";
}
else if ($modelST['STStatus']== 2){
    $this->title = "ใบจ่ายสินค้ารอรับเข้า";
}
else if ($modelST['STStatus']== 20 || $modelST['STStatus']== 21 ){
    $this->title = "ประวัติใบจ่ายสินค้า";
}
else{
  $this->title = "บันทึกใบจ่ายสินค้า";
}
//$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'จ่ายสินค้ารายวัน', 'url' => ['index']];
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
