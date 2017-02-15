<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\plan\models\TbPcplan */
$action = Yii::$app->controller->action->id;
if (($action == 'update') || ($action == 'view')) {
    $this->title = 'บันทึกแผนการจัดซื้อยาสามัญ: ' . $model->PCPlanNum;
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['/plan/default/index']];
    $this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['/plan/default/index']];
}
if ($action == 'verify') {
    $this->title = 'ทวนสอบแผนจัดซื้อ';
    $this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['/plan/default/waiting-verify']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pcplan-update">

    <?=
    $this->render('_form', [
        'model' => $model,
        'section' => $section,
    ])
    ?>

</div>
