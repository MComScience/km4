<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPr2Temp */

$this->title = 'บันทึกใบขอซื้อนอกแผน';
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อนอกแผน', 'url' => ['new-pr-gpu/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pr2-temp-create">
    <?=
    $this->render('_form', [
        'modelPR' => $modelPR,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'section' => $section,
        'view' => $view,
        'htl_checkbox' => $htl_checkbox,
    ])
    ?>

</div>
