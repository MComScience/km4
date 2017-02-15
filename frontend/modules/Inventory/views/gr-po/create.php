<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */

$this->title = 'บันทึกใบรับสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'รับสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-gr2-temp-create">
     <?= $this->render('_form', [
        'POID'=>$POID,
        'modelST'=>$modelST,
        'modelGR' => $modelGR,
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'dataProviderCat2'=>$dataProviderCat2,
        'view' => $view,
        'vendername'=>$vendername,
        'summarypo'=>'0.00',
        'summarypocat2'=>'0.00',
    ]) ?>

</div>
