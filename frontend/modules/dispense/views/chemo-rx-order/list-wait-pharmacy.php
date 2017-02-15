<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\base\View;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
$this->title = 'Chemo Rx Order List';
$this->params['breadcrumbs'][] = ['label' => 'dispense', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'จ่ายยา', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

			<ul class="nav nav-tabs" id="myTab">
				<li class="active">
					<?= Html::a('Chemo Rx Order List', ['index'] ) ?>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane in active">
				<div class="tb-item-index">
					<?php Pjax::begin(['id' => 'tb_getopd_pjax']); ?> 
					<?=
					fedemotta\datatables\DataTables::widget([
						'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
						'tableOptions' => [
						'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed'
						],
						'clientOptions' => [
						'bSortable' => false,
						'bAutoWidth' => true,
						'ordering' => false,
						'pageLength' => 10,
                                //'bFilter' => false,
						'language' => [
						'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
						'lengthMenu' => '_MENU_',
						'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
						'search' => '_INPUT_ '
						],
						"lengthMenu" => [[10, -1], [10, Yii::t('app', "All")]],
						"responsive" => true,
						"dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
						"tableTools" => [
						"aButtons" => [
						[
						"sExtends" => "copy",
						"sButtonText" => Yii::t('app', "Copy to clipboard")
						], [
						"sExtends" => "csv",
						"sButtonText" => Yii::t('app', "Save to CSV")
						], [
						"sExtends" => "xls",
						"oSelectorOpts" => ["page" => 'current']
						], [
						"sExtends" => "pdf",
						"sButtonText" => Yii::t('app', "Save to PDF")
						], [
						"sExtends" => "print",
						"sButtonText" => Yii::t('app', "Print")
						],
						]
						]
						],
						'columns' => [
						[
						'header' => 'ลำดับ',
						'class' => 'yii\grid\SerialColumn',
						'contentOptions' => ['class' => 'text-center'],
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						],
						[
						'header' => 'เลขที่ใบสั่งยา',
						'attribute' => 'cpoe_num',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-center'],
						'value'=>function($model){
							if($model->cpoe_num != null){
								return $model->cpoe_num;
							}else{
								return '-';
							}
						}
						],
						[
						'header' => 'HN:VN',
						'attribute' => 'HNVN',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-center'],
						'value'=>function($model){
							if($model->HNVN != null){
								return $model->HNVN;
							}else{
								return '-';
							}
						}

						],
						[
						'header' => 'ชื่อนามสกุลผู้ป่วย',
						'attribute' => 'pt_name',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-left'],
						'value'=>function($model){
							if($model->pt_name != null){
								return $model->pt_name;
							}else{
								return '-';
							}
						}
						],
						[
						'header' => 'อายุ',
						'attribute' => 'pt_age_registry_date',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-center'],
						'value'=>function($model){
							if($model->pt_age_registry_date != null){
								return $model->pt_age_registry_date;
							}else{
								return '-';
							}
						}
						],
						[
						'header' => 'แผนก',
						'attribute' => 'cpoe_order_section',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-center'],
						'value'=>function($model){
							if($model->cpoe_order_section != null){
								return $model->cpoe_order_section;
							}else{
								return '-';
							}
						}
						],
						[
						'header' => 'Regimen',
						'attribute' => 'chemo_detail',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-center'],
						'value'=>function($model){
							if($model->chemo_detail != null){
								return $model->chemo_detail;
							}else{
								return '-';
							}
						}
						],
						[
						'header' => 'สถานะคำสั่ง',
						'attribute' => 'cpoe_status_decs',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
						'contentOptions' => ['class' => 'text-center'],

						],
                                             
						[
						'class' => 'yii\grid\ActionColumn',
						'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8',],
						'header' => 'Actions',
						'contentOptions' => ['class' => 'text-center'],
						'template' => '{dispen-chemi}',
						'buttons' => [

						'dispen-chemi' => function ($url, $model, $key) {
							return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
								'title' => Yii::t('app', 'Select'),
								'data-toggle' => 'modal',
								'data-id' => $key,
                 // 'onclick'=>'register('.$model->PT_HOSPITAL_NUMBER.')'
								]);
						},
						],
						],
						],
						]
						);
						?>
						<?php Pjax::end(); ?>
                                     <div style="text-align: right">
                <?php echo Html::a('Close', 'index.php?r=', ['class' => 'btn btn-default']) ?>
        </div>
					</div>
				
				</div>
		
			</div>

