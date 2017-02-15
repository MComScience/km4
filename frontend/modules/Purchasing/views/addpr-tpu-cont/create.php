<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPr2Temp */

$this->title = 'บันทึกใบขอซื้อยาการค้า สัญญาจะซื้อจะขาย';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pr2-temp-create">


    <?=
    $this->render('_form', [
        'modelPR' => $modelPR,
        'dataProvider' => $dataProvider,
        'searchModel' => $searchModel,
        'htl_checkbox' => $htl_checkbox,
        'htl_checkbox1' => $htl_checkbox1,
        'view' => $view,
        'section' => $section,
    ])
    ?>

</div>
