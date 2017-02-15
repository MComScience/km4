<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

if ($modelST['STStatus']== 1){
    $this->title = "บันทึกใบส่งสินค้าขอยืม";
}
else if ($modelST['STStatus']== 2){
    $this->title = "ร่างใบส่งสินค้าขอยืม";
}
else if ($modelST['STStatus']== 5 || $modelST['STStatus']== 6 ){
    $this->title = "ประวัติใบเคลมสินค้า";
}
else{
  $this->title = "ประวัติใบส่งสินค้าขอยืม";
}
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ส่งสินค้าขอยืม', 'url' => ['index']];
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
