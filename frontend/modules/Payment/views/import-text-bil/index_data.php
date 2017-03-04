<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use frontend\assets\WaitMeAsset;
use frontend\assets\SweetAlertAsset;
SweetAlertAsset::register($this);
WaitMeAsset::register($this);
//print_r($primary_key);
//$check_count = count($primary_key);
//$index_pk = ( --$check_count);
//for($i=0,$i<=$check_count,$i++){
//    
//}
$header_style = ['style' => 'text-align:center;color:#000000;'];
$content_style = ['style' => 'text-align:center;'];
$this->title = "นำเข้าไฟล์ สกส.";
$this->params['breadcrumbs'][] = $this->title;
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
<style>
 
</style> 

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
                        'name' => 'text_file',
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'overwriteInitial' => true,
                            'showPreview' => FALSE,
                            'showCaption' => true,
                            'showRemove' => FALSE,
                            'showUpload' => FALSE,
                            'allowedFileExtensions' => ['xls', 'xlsx', 'xlsm', 'xlsb', 'csv', 'BIL', 'rep'],
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
            <?php Pjax::begin(['id' => 'cs_pjax', 'timeout' => 5000]) ?>
            <?=
                    common\widgets\kartik_datatables\DataTables::widget([
                    'dataProvider' => $dataProvider,
                    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                    'tableOptions' => [
                            'class' => 'default kv-grid-table 
                            table table-hover table-bordered  
                            table-condensed',
                    ],
                    'clientOptions' => [
                    'bSortable' => false,
                    'bAutoWidth' => true,
                    'ordering' => true,
                    'pageLength' => 40,
                    'bFilter' => true,
                    'language' => [
                        'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                        'lengthMenu' => '_MENU_',
                        'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                        'search' => '_INPUT_'
                    ],
                                    "lengthMenu" => [[10, 20, 40, 60, -1], [10, 20, 40, 60, "All"]],
                                    "responsive" => true,
                                    "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                    ],
                                    'columns' => [
                                        
                                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'contentOptions' => $content_style,
                            'width' => '36px',
                            'header' => 'ลำดับ',
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;']
                        ],
                        [
                            'class' => 'kartik\grid\ExpandRowColumn',

                            'value' => function ($model, $key, $index, $column) {
                                return kartik\grid\GridView::ROW_COLLAPSED;
                            },
                                //'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                                'headerOptions' => $header_style,
                                'contentOptions' => $content_style,
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
                            'header' => 'เลขที่ตอบรับ',
                            'contentOptions' => $content_style,
                            'value' => function ($model) {
                                if ($model->rep == null) {
                                    return '-';
                                } else {
                                    return $model->rep;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'งวดส่งของ รพ.',
                            'contentOptions' => $content_style,
                            'value' => function ($model) {
                                if ($model->claim_num == null) {
                                    return '-';
                                } else {
                                    return $model->claim_num;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'เอกสาร',
                            'contentOptions' => $content_style,
                            'value' => function ($model) {
                                if ($model->report_filename == null) {
                                    return '-';
                                } else {
                                    return $model->report_filename;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'นำเข้าโดย',
                            'contentOptions' => $content_style,
                            'value' => function ($model) {
                                if ($model->user_name == null) {
                                    return '-';
                                } else {
                                    return $model->user_name;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'นำเข้า',
                            'format' => ['date', 'php:d/m/Y'],
                            'contentOptions' => $content_style,
                            'value' => function ($model) {
                                return $model->Import_date;
                            }
                        ],
                                     [
                            'class' => 'kartik\grid\ActionColumn',
                            //'options' => ['style' => 'width:200px;'],
                            'header' => 'Actions',
                            'contentOptions' => ['style' => 'white-space: nowrap;'],
                            'headerOptions' => $header_style,
                            'template' => '{ar} {delete}',
                            'buttons' => [
                                'ar' => function ($url, $model) {
                                    if($model->rep == "รอบันทึกลูกหนี้"){
                                        return Html::a('<span class="btn btn-info btn-xs">บันทึกลูกหนี้</span>',false, [
                                                    'title' => Yii::t('app', 'บันทึกลูกหนี้'),
                                                    'onclick' => "select_rep($model->nhso_rep_id)"
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
                                                    'onclick' => "fn_delete($model->rep)"
                                            ]);
                                },
                            ], 
                        ],
                                    ],


                                ]
                                    );
                                    ?>
            <?php Pjax::end() ?>
        </div>
        <div class="form-group" style="text-align: right">
            <?= Html::a('Close',['index'],['class'=>'btn btn-default']) ?>
        </div>
    </div>
</div>
                               
<?php echo $this->render('/config/alert.php');  ?>
<?php 
$script = <<< JS
$(".file-caption-name").text('ชื่อไฟล์.BIL');
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
function fn_delete(key) {
    console.log(key);
}
 //   function select_rep(key) {
 //     swal({   
 //                title:"ยืนยันคำสั่ง?",   
 //                text: "",   
 //                type: "warning",   
 //                showCancelButton: true,   
 //                confirmButtonColor: "#53a93f",   
 //                confirmButtonText: "Confirm",   
 //                closeOnConfirm: false
 //    },function(){
 //    $.get(
 //                'save-ar',
 //                {
 //                   key
 //                },
 //                function (data)
 //                {   
 //                   location.reload();
 //                }
 //        );
 //    });
 // }   
</script>
