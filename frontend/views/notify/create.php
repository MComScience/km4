<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TbProblem */

$this->title = 'แจ้งปัญหาการใช้งาน';
//$this->params['breadcrumbs'][] = ['label' => 'Tb Problems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-problem-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'initialPreview' => [],
        'initialPreviewConfig' => [],
    ])
    ?>

</div>
