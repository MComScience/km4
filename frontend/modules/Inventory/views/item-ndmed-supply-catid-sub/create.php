<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbItemndmedsupplycatidSub */

$this->title = 'บันทึกหมวดเวชภัณฑ์หลัก';
$this->params['breadcrumbs'][] = ['label' => 'รายการหมวดเวชภัณฑ์หลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-itemndmedsupplycatid-sub-create">
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
					//'modelsItemndmedsupply'=>$modelsItemndmedsupply,
					'type'=>$type
					]) ?>
				</div>
			</div>
		</div>
	</div>
