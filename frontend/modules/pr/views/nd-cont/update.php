<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pr\models\TbPr2Temp */

$this->title = 'บันทึกใบขอซื้อเวชภัณฑ์ สัญญาจะซื้อจะขาย';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchasing'), 'url' => ['/pr/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ขอซื้อรายการบัญชี รพ.'), 'url' => ['/pr/default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pr2-temp-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'section' => $section,
        'vendorname' => $vendorname,
        //'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'reason' => $reason,
        'type' => $type,
    ])
    ?>
</div>
