<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbDrugclass */

$this->title = 'บันทึกรายการหมวดยาหลัก';
$this->params['breadcrumbs'][] = ['label' => 'รายการหมวดยาหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-drugclass-create">
	<ul class="nav nav-tabs " id="myTab5">
		<li class="active">
			<a data-toggle="tab" href="#home5">
				<?= Html::encode($this->title); ?>
			</a>
		</li>  
	</ul>
	<div class="tab-content">
		<div id="home5" class="tab-pane in active">
			<div class="well">
				<?= $this->render('_form', [
					'model' => $model,
					'type'=>$type
					]) ?>
				</div>
			</div>
		</div>
	</div>

