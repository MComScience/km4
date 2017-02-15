<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbItem */

$this->title = Yii::t('app', 'บันทึกรายการสินค้ายา');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'จัดการรายการสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-item-create">
    <?=
    $this->render('_form', [
        'tbgpu' => $tbgpu,
        'tbgp' => $tbgp,
        'subclassgp' => $subclassgp,
        'queryview' => $queryview,
        'querydatatpu' => $querydatatpu,
        'itemid' => $itemid,
        'edit' => $edit,
    ])
    ?>

</div>
