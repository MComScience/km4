<?php

use yii\helpers\Html;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

if ($modelST['STStatus']== 1){
    $this->title = "บันทึกใบเคลมสินค้า";
}
else if ($modelST['STStatus']== 2){
    $this->title = "ใบเคลมสินค้ารอรับเข้า";
}
else if ($modelST['STStatus']== 20 || $modelST['STStatus']== 21 ){
    $this->title = "ประวัติใบเคลมสินค้า";
}
else{
  $this->title = "บันทึกใบเคลมสินค้า";
}
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ส่งสินค้าเคลม', 'url' => ['index']];
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
