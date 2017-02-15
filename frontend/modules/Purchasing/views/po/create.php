<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPo2Temp */

$this->title = Yii::t('app', 'สร้างใบสั่งซื้อ');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'สั่งซื้อ'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-po2-temp-create">

    <?=
    $this->render('_form', [
        'modelPO' => $modelPO,
        'modelPR' => $modelPR,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'postProvider' => $postProvider,
        'VenderName' => $VenderName,
        'MenuVenderName' => $MenuVenderName,
    ])
    ?>

</div>
