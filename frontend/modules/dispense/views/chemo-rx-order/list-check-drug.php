<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\base\View;
use kartik\widgets\Select2;
use app\modules\dispense\models\VwUserprofile;
use yii\helpers\ArrayHelper;
$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
$this->title = 'ใบสั่งยารอตรวจสอบ';
$this->params['breadcrumbs'][] = ['label' => 'dispense', 'url' => ['index']];
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
		<div class="form-horizontal">
			<div class="form-group">
				<label for="cpoe_num" class="col-sm-2 control-label">หมายเลขที่ใบสั่งยา</label>
				<div class="col-sm-3">
					<input type="text" id="cpoe_num" style="background-color: #ffff99" class="form-control" >
				</div>
			</div>
		</div>

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
				'header' => 'สิทธิ์การรักษา',
				'attribute' => 'pt_right',
				'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
                    //'contentOptions' => ['class' => 'text-center'],
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
				'template' => '{check-drug}',
				'buttons' => [

				'check-drug' => function ($url, $model, $key) {
					return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
						'title' => Yii::t('app', 'CHECK'),
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
	<?php
	Modal::begin([
		'id' => 'modal_pharmacy',
		'header' => '<h4 class="modal-title">เตรียมยาโดย</h4>',
		'size' => 'modal-dialog modal-primary',
		'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
		'closeButton' => FALSE,
		'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button><button type="button" class="btn btn-success" id="id_btn_ok">OK</button>'
		]);
		?>
		<div class="form-horizontal">
			<input type="hidden" name="cpoe_prepareby_id" id="cpoe_prepareby_id">
			<div class="form-group">
				<label for="" class="col-sm-4 control-label">เตรียมยาโดย</label>
				<div class="col-sm-6">
					<?php 		echo Select2::widget([
						'name' => 'cpoe_prepareby',
						'id' => 'cpoe_prepareby',
						'data' =>  ArrayHelper::map(VwUserprofile::find()->where(['User_position' =>1002])->all(), 'user_id', 'User_name2'),
						'size' => Select2::SMALL,
						'options' => ['placeholder' => 'Select a state ...'],
						'pluginOptions' => [
						'allowClear' => true
						],
						]); ?>
					</div>
				</div>
			</div>
			<?php Modal::end(); ?>
			<?php $script = <<< JS
			$('#cpoe_num').focus();
			$('#cpoe_num').on('keydown', function(e) {
				if (e.which == 13) {
					var cpoe_num = $('#cpoe_num').val();
					if(cpoe_num != ""){
						$.ajax({
							url: "index.php?r=dispense/dispense/check-barcode",
							type: "post",
							data: {cpoe_num:cpoe_num},
							success: function (result) {
								if(result=="false"){
									swal('', "ไม่พบข้อมูล", "warning");
									return false;
								}else{

									$('#cpoe_prepareby_id').val(result);
									$('#modal_pharmacy').modal('show');
									$('#modal_pharmacy').removeAttr('tabindex');
								}
							}
						});
					}else{
						swal('', "กรุณาใส่หมายเลขที่ใบสั่งยา", "warning");
						return false;
					}
				}
			});
			$('#id_btn_ok').on('click', function(e) {
				var result = $('#cpoe_prepareby_id').val();
				var cpoe_prepareby = $('#cpoe_prepareby').val();
				if(cpoe_prepareby != ""){
					location.replace("index.php?r=dispense/chemo-rx-order/check-drug&id="+result+"&user_id="+cpoe_prepareby);
				}else{
					swal('', "กรุณาเลือกผู้เตรียมยา", "warning");
				}
				
			});
JS;

			$this->registerJs($script, \yii\web\View::POS_END, 'list-check-drug');
			?> 

