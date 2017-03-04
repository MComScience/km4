<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
echo $this->render('/config/Asset_Js.php');
//print_r($primary_key);
//$check_count = count($primary_key);
//$index_pk = ( --$check_count);
//for($i=0,$i<=$check_count,$i++){
//    
//}
$header_style = ['style' => 'text-align:center;color:#000000;'];
$this->title = "นำเข้าไฟล์ นค.1-ตรวจสุขภาพ";
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
  if(!empty($notify['check_pk'])){
  echo '<li style="list-style-type: none;"> มีข้อมูลที่ตรงกับอันเดิม '. $notify['check_pk'] .' แถว</li><li style="list-style-type: none;">ได้แก่</li>';
  foreach ($primary_key as $show_key) {
  echo '<li style="list-style-type: none;"> • SEQ '. $show_key .'</li>';
  }
  }else{
  echo '<li style="list-style-type: none;">ยังไม่มีข้อมูลซ้ำ</li>';
  }
  ?>
  

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
                <div class="col-sm-4">
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
                        ]
                    ])
                    ?>
                </div>
                <div class="col-sm-2">
                    <?= Html::submitButton('นำเข้า', ['class' => 'btn btn-info btn-md', 'id' => 'Import']) ?>
                </div> 
            </div>
            <?php
              if(!empty($notify['check_pk'])){
              echo '<div class="popoverexample"><div class="popover bottom" style="max-width: 380px;margin-left: 0px;width: 380px;"><div class="arrow" style="left: 91%;"></div><p class="popover-title bordered-gold" style="font-size: 18px;font-weight: bold;"> ข้อมูลที่ไม่ถูกนำเข้าทั้งหมด '. $notify['check_pk'] .' แถว ได้แก่</p><div class="popover-content">';
              foreach ($primary_key as $show_key) {
              echo '<li style="list-style-type: none;"> • rep_seq '. $show_key .'</li>';
              }
              echo '<br><li style="list-style-type: none;"><u>เนื่องจากมี Error code</u></li>';
              echo '</div></div></div>';
              }else{
                //echo '<li style="list-style-type: none;"></li>';
              }
            ?>
            <?php ActiveForm::end(); ?>
            <br>
            <?php Pjax::begin(['id' => 'rep_pjax', 'timeout' => 5000]) ?>
            <?php /*echo $this->render('_search', ['model' => $searchModel]); */?>
            <?php echo
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
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'value' => function ($model, $key, $index, $column) {
                                return kartik\grid\GridView::ROW_COLLAPSED;
                            },
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                                'expandOneOnly' => true,
                                                    //'header' => '<a>Detail</a>',
                                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                'detailAnimationDuration' => 'slow', //fast
                                'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                'detailUrl' => \yii\helpers\Url::to(['detail']),
                                                    
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'SEQ',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->VISIT_SEQ == null) {
                                    return '-';
                                } else {
                                    return $model->VISIT_SEQ;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'HN',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->HN_NO == null) {
                                    return '-';
                                } else {
                                    return $model->HN_NO;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'บัตรประชาชน',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->HN_ID_NO == null) {
                                    return '-';
                                } else {
                                    return $model->HN_ID_NO;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชื่อ-นามสกุล',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                if ($model->FULLNAME == null) {
                                    return '-';
                                } else {
                                    return $model->FULLNAME;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'อายุ',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->AGE == null) {
                                    return '-';
                                } else {
                                    return $model->AGE;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'สิทธิการรักษา',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->PT_Right == null) {
                                    return '-';
                                } else {
                                    return $model->PT_Right;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชื่อโครงการ',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->PROJECT_NAME == null) {
                                    return '-';
                                } else {
                                    return $model->PROJECT_NAME;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'วันที่เข้ารักษา',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->VISIT_DATE;
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'เป็นเงิน',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->NOTPAY == null) {
                                    return '0';
                                } else {
                                    return $model->NOTPAY;
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
                            'headerOptions' => $header_style,
                            'header' => 'นำเข้า',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->import_date;
                            }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'contentOptions' => ['style' => 'white-space: nowrap;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => $header_style,
                            'template' => '{ar} {delete}',
                            'buttons' => [
                                'ar' => function ($url, $model) {
                                	if($model->nk_checkup_id == "1"){
                                		return Html::a('<span class="btn btn-info btn-xs">บันทึกลูกหนี้</span>',false, [
                                                    'title' => Yii::t('app', 'บันทึกลูกหนี้'),
                                                    'onclick' => "select_rep($model->nk_checkup_id)"
                                    	]);
                                	}else{
                                		return Html::a('<span class="btn btn-success btn-xs">บันทึกลูกนี้แล้ว</span>',false, [
                                                    'title' => Yii::t('app', 'บันทึกลูกหนี้'),
                                                    //'onclick' => "select_rep($model->nhso_rep_id)"
                                    	]);
                                	}
                                    
                                },
                                'detail' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">ลบข้อมูล</span>',false, [
                                                    'title' => Yii::t('app', 'ลบข้อมูล'),
                                                    //'onclick' => "select_rep($model->nhso_rep_id)"
                                            ]);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-danger btn-xs">ลบข้อมูล</span>',false, [
                                                    'title' => Yii::t('app', 'ลบข้อมูล'),
                                                    //'onclick' => "select_rep($model->nhso_rep_id)"
                                            ]);
                                },
                            ], 
                        ],
                    ],
                    // 'rowOptions' => function ($model, $index, $widget, $grid){
                    //     if($model->itemstatus == "บันทึกลูกหนี้แล้ว"){
                    //     return ['class' => 'warning'];
                    //   }else{
                    //     return [];
                    //   }
                    // },
                ])
            ?>
            <?php Pjax::end() ?>
        </div>
        <?php echo $this->render('/config/btn_close.php'); ?>
     </div>
</div>
<?php echo $this->render('/config/alert.php');  ?>
<?php 
$script = <<< JS
$(".file-caption-name").text('ไฟล์ CK_ALL_(02 หรือ 24)');
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
$(document).ready(function () {
    $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "columns": [
            null,
            {"bSortable": false},
            null,
            null,
            null,
            null,
            null,
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
});

JS;
$this->registerJs($script);
?>
<script>
   function select_rep(key) {
     swal({   
                title:"ยืนยันคำสั่ง?",   
                text: "",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Confirm",   
                closeOnConfirm: false
    },function(){
   //  $.get(
   //              'save-ar',
   //              {
   //                 key
   //              },
   //              function (data)
   //              {   
   //                 location.reload();
   //              }
   //      );
    });
 }   
</script>
