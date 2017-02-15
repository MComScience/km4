<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbDrugclass */

$this->title = 'Update Tb Drugclass: ' . ' ' . $model->DrugClassID;
$this->params['breadcrumbs'][] = ['label' => 'หมวดรายการยาหลัก', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->DrugClassID, 'url' => ['view', 'id' => $model->DrugClassID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tb-drugclass-update">
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
						//'modelsDrugsubclass'=>$modelsDrugsubclass
						]) ?>
					</div>
				</div>
			</div>
		</div>
	</div>
