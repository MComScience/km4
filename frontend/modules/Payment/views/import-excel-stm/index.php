<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
echo $this->render('/config/Asset_Js.php');
$header_style = ['style' => 'text-align:center;color:#000000;'];
//print_r($primary_key);
//$check_count = count($primary_key);
//$index_pk = ( --$check_count);
//for($i=0,$i<=$check_count,$i++){
//    
//}
$this->title = "STM_UDCANCER";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<?php /*
  if(!empty($notify['check_pk'])){
  echo '<li style="list-style-type: none;"> มีข้อมูลที่ตรงกับอันเดิม '. $notify['check_pk'] .' แถว</li><li style="list-style-type: none;">ได้แก่</li>';
  foreach ($primary_key as $show_key) {
  echo '<li style="list-style-type: none;"> • rep_seq '. $show_key .'</li>';
  }
  }else{
  echo '<li style="list-style-type: none;">ยังไม่มีข้อมูลซ้ำ</li>';
  }
  ?>
  <?php
  if(!empty($insert['sum'])){
  echo '<li style="list-style-type: none;"> มีข้อมูลที่เพิ่มเข้ามา '. $insert['sum'] .' แถว</li><li style="list-style-type: none;">ได้แก่</li>';
  foreach ($insert_primary_key as $show_insert_key) {
  echo '<li style="list-style-type: none;"> • rep_seq '. $show_insert_key .'</li>';
  }
  }else{
  echo '<li style="list-style-type: none;">ยังไม่มีข้อมูลที่เพิ่มเข้ามา</li>';

  }
 */ ?>

<div class="tabbable">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'import-form',
                        'options' => ['enctype' => 'multipart/form-data'],
                        'type' => ActiveForm::TYPE_HORIZONTAL
            ]);
            ?>
            <div class="form-group">
                <!--    <div class="col-sm-2">-->
                <?php // Html::a('<i class="fa fa-user-plus"></i> Add Users', ['create'], ['class' => 'btn btn-primary', 'id' => 'activity-create-link'])    ?>
                <!--    </div>-->
                <div class="col-sm-3">
                    <?=
                    kartik\file\FileInput::widget([
                        'name' => 'excel_file',
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'overwriteInitial' => true,
                            'showPreview' => FALSE,
                            'showCaption' => true,
                            'showRemove' => FALSE,
                            'showUpload' => FALSE,
                            'allowedFileExtensions' => ['xls', 'xlsx', 'xlsm', 'xlsb', 'csv'],
                            'maxFileSize' => 5000,
                            'browseLabel' => 'เลือกไฟล์...'
                        /*
                          'uploadUrl' => Url::to(['/user/admin/upload-ajax']),
                          'uploadLabel' => 'นำเข้าข้อมูล',
                          'uploadTitle' => 'นำเข้าไฟล์ข้อมูล'
                         * 
                         */
                        ]
                    ])
                    ?>
                </div>
                <div class="col-sm-2">
                    <?= Html::submitButton('นำเข้า', ['class' => 'btn btn-info btn-md', 'id' => 'Import']) ?>
                </div> 
            </div>
            <?php ActiveForm::end(); ?>
            <br>
            <?php Pjax::begin(['id' => 'stm_pjax', 'timeout' => 5000]) ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => true,
                    'condensed' => true,
                    'bordered' => true,
                    'layout' => "{items}",
                    'responsive' => false,
                    'showOnEmpty' => false,
                    'export' => false,
                    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                    'tableOptions' => ['class' => GridView::TYPE_DEFAULT,'style' => 'width:100%','id'=>'grid_index'],
                    'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                        'header' => 'ลำดับ',
                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;']
                    ],
                    [
                        'headerOptions' => $header_style,
                        'header' => 'stm_eclaim_num',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->stm_eclaim_num == null) {
                                return '-';
                            } else {
                                return $model->stm_eclaim_num;
                            }
                        }
                    ],
                    
                    [
                        'headerOptions' => $header_style,
                        'header' => 'นำเข้า',
                        'format' => ['date', 'php:d/m/Y'],
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            return $model->report_date;
                        }
                    ],
                    [
                        'headerOptions' => $header_style,
                        'header' => 'prov',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->prov == null) {
                                return '-';
                            } else {
                                return $model->prov;
                            }
                        }
                    ],
                    [
                        'headerOptions' => $header_style,
                        'header' => 'hcode',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->hcode == null) {
                                return '-';
                            } else {
                                return $model->hcode;
                            }
                        }
                    ],
                    [
                        'headerOptions' => $header_style,
                        'header' => 'นำเข้าโดย',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'value' => function ($model) {
                            if ($model->import_by == null) {
                                return '-';
                            } else {
                                return $model->import_by;
                            }
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'contentOptions' => ['style' => 'white-space: nowrap;'],
                        'header' => 'Actions',
                        'hAlign' => GridView::ALIGN_CENTER,
                        'headerOptions' => $header_style,
                        'template' => '{select}',
                        'buttons' => [
                            'select' => function ($url, $model) {
                                return Html::a('<span class="btn btn-success btn-xs">Select</span>',false, [
                                                'title' => Yii::t('app', 'Select'),
                                                'onclick' => "select_rep($model->nhso_stm_id)"
                                        ]);
                            },
                              
                        ], 
                    ]
                ]
            ])
            ?>
            <?php Pjax::end() ?>
        </div>
             <?php echo $this->render('/config/btn_close.php'); ?>
    </div>
</div>
<?php echo $this->render('/config/alert.php');  ?>
<!--<a href="#" id="click">click</a>-->
<?php
$script = <<< JS
    $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "columns": [
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ],
        "language": {
            // "search": "ค้นหา : _INPUT_ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><span class='text'></span><input type='checkbox' class='colored-success' id='chk_box'  data-toggle='checkbox-x'><span class='text'> แสดงเฉพาะรายการที่ยังไม่บันทึกลูกหนี้</span></label>",
            "search": "ค้นหา : _INPUT_ ",
            /*"searchPlaceholder": "ค้นหาข้อมูล...",*/
            "lengthMenu": "_MENU_",
            "infoEmpty": "No records available",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            //"infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        /*"paging":   false,
         "ordering": false,
         "info":     false*/
    });
$('#Import').click(function (e) {
        console.log('click');
        var current_effect = 'ios'; 
        run_waitMe(current_effect);
        function run_waitMe(effect){
        $('.page-content').waitMe({
	effect: 'ios',
	text: 'กำลังโหลดข้อมูล...',
	bg: 'rgba(255,255,255,0.7)',
	color: '#000',
	sizeW: '',
	sizeH: '',
	source: '',
	onClose: function () {}
        
	});
    }
});
JS;
$this->registerJs($script);
?>
<script>
   function select_rep(key) {
       alert(key);
 }   
</script>
