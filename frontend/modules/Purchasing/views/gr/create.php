<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbGr2Temp */

$this->title = Yii::t('app', 'บันทึกใบรับสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'บันทึกรับจากการสั่งซื้อ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-gr2-temp-create">

    <?= $this->render('_form', [
        'modelGR' => $modelGR,
        'VenderName' => $VenderName['VenderName'],
    ]) ?>

</div>
