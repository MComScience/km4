<?php

use yii\helpers\Html;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */
$this->title = 'บันทึกใบรับสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'รับสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-gr2-temp-create">
     <?= $this->render('_form', [
        'modelGR' => $modelGR,
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'view' => $view,
        'vendername'=>$vendername,
    ]) ?>

</div>
