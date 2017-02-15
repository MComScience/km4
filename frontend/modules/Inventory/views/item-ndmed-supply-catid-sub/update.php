<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbItemndmedsupplycatidSub */

$this->title = 'บันทึกหมวดเวชภันฑ์มิใช่ยาหลัก: ' . ' ' . $model->ItemNDMedSupplyCatID_sub_id;
$this->params['breadcrumbs'][] = ['label' => 'หมวดรายการเวชภัณฑ์มิใช่ยาหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ItemNDMedSupplyCatID_sub_id, 'url' => ['view', 'id' => $model->ItemNDMedSupplyCatID_sub_id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="tb-itemndmedsupplycatid-sub-update">
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
						'type'=>'update',
						//'modelsItemndmedsupply'=>$modelsItemndmedsupply
						]) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
