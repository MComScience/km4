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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'report_date',
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'class' => 'kartik\grid\ActionColumn',
                            'options' => ['style' => 'width:90px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{select}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>','#', [
                                                    'title' => Yii::t('app', 'Select'),
                                                    'onclick' => "select_rep($model->nhso_stm_id)"
                                            ]);
                                },
                                  
                            ], 
                        ]
                    ]
                ])
            ?>
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
