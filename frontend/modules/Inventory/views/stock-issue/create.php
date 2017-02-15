<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSt2Temp */

$this->title = 'บันทึกใบโอนสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'โอนสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-st2-temp-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
          'STID' => $STID,
           'SRID'=>$SRID,
    ])
    ?>

</div>
