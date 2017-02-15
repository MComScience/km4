<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

$this->title = 'บันทึกใบรับสินค้าเคลม';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'รับสินค้าเคลม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-gr2-temp-create">
     <?= $this->render('_form', [
        'STID'=>$STID,
        'modelST'=>$modelST, 
        'modelGR' => $modelGR,
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'view' => $view,
        'vendername'=>$vendername,
        'summaryclaimst'=>'0.00',
    ]) ?>

</div>
