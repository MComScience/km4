<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
//print_r($primary_key);
//$check_count = count($primary_key);
//$index_pk = ( --$check_count);
//for($i=0,$i<=$check_count,$i++){
//    
//}
$this->title = "UC : OP Refer";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
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
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'bootstrap' => true,
                    'responsiveWrap' => FALSE,
                    'responsive' => true,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => false,
                    'condensed' => true,
                    'toggleData' => true,
                    'layout' => Yii::$app->componentdate->layoutgridview(),
                    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
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
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                'expandOneOnly' => true,
                                                    //'header' => '<a>Detail</a>',
                                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                'detailAnimationDuration' => 'slow', //fast
                                'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                'detailUrl' => \yii\helpers\Url::to(['detail']),
                                                    
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'REP',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->rep == null) {
                                    return '-';
                                } else {
                                    return $model->rep;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'Type',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->doc_type == null) {
                                    return '-';
                                } else {
                                    return $model->doc_type;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เอกสาร',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->invoice_eclaim_num == null) {
                                    return '-';
                                } else {
                                    return $model->invoice_eclaim_num;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'นำเข้าโดย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->User_name == null) {
                                    return '-';
                                } else {
                                    return $model->User_name;
                                }
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'นำเข้า',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->report_date == null) {
                                    return '-';
                                } else {
                                    return $model->report_date;
                                }
                            }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'options' => ['style' => 'width:200px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{ar} {delete}',
                            'buttons' => [
                                'ar' => function ($url, $model) {
                                    if($model->itemstatus == "รอบันทึกลูกหนี้"){
                                        return Html::a('<span class="btn btn-info btn-xs">บันทึกลูกหนี้</span>','#', [
                                                    'title' => Yii::t('app', 'บันทึกลูกหนี้'),
                                                    'onclick' => "select_rep($model->nhso_rep_id)"
                                        ]);
                                    }else{
                                        return Html::a('<span class="btn btn-success btn-xs">บันทึกลูกนี้แล้ว</span>','#', [
                                                    'title' => Yii::t('app', 'บันทึกลูกหนี้'),
                                                    //'onclick' => "select_rep($model->nhso_rep_id)"
                                        ]);
                                    }
                                    
                                },
                                'detail' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Detail</span>','#', [
                                                    'title' => Yii::t('app', 'Detail'),
                                                    //'onclick' => "select_rep($model->nhso_rep_id)"
                                            ]);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-danger btn-xs">Delete</span>','#', [
                                                    'title' => Yii::t('app', 'Delete'),
                                                    //'onclick' => "select_rep($model->nhso_rep_id)"
                                            ]);
                                },
                            ], 
                        ]
                    ]
                ])
            ?>
            <?php Pjax::end() ?>
        </div>
        <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=" class="btn btn-default">Close</a>
        </div>
    </div>
</div>
<!--<a href="#" id="click">click</a>-->

<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 2, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 2000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>
<?php
$script = <<< JS
$(".file-caption-name").text('eclaim_xxx_(ORF หรือ IRF)');
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
     swal({   
                title: "",   
                text: "ยืนยันคำสั่ง?",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Confirm",   
                closeOnConfirm: false
    },function(){
    $.get(
                'index.php?r=Payment/import-excel-orf/save-ar',
                {
                   key
                },
                function (data)
                {   
                   location.reload();
                }
        );
    });
 }   
</script>
