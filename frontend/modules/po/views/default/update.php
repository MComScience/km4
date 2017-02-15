<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\po\models\TbPo2Temp */

$this->title = 'สร้างใบสั่งซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-po2-temp-update">

    <?=
    $this->render('_form', [
        'model' => $model,
        'modelPR' => $modelPR,
        'dataProvider1' => $dataProvider1,
        'dataProvider2' => $dataProvider2,
    ])
    ?>
</div>
<?php echo $this->render('modal'); ?>
<?php echo $this->render('script'); ?>
