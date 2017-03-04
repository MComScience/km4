<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
echo $this->render('/config/Asset_Js.php');
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwFiNhsoArSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$headerGrid = ['class'=>'kv-align-middle','style' => 'text-align:center;color:#000000;','rowspan'=>'2'];
$filterGrid = ['style'=>'display:none;'];
$this->title = 'สร้างหนังสือเรียกเก็บ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="_nhso_inv" class="tabbable">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="_home" class="tab-pane in active ">
            <?php Pjax::begin(['id' => 'inv_pjax', 'timeout' => 5000]) ?>
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <?php echo
                GridView::widget([
                	'id' => 'grid_ar',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'bootstrap' => true,
                    'responsiveWrap' => true,
                    'responsive' => true,
                    'hover' => true,
                    'pjax' => FALSE,
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
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                                'expandOneOnly' => true,
                                'enableCache'=> false,
                                                    //'header' => '<a>Detail</a>',
                                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                'detailAnimationDuration' => 'slow', //fast
                                'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                'detailUrl' => \yii\helpers\Url::to(['inv-detail']),
                                                    
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'หนังสือเรียกเก็บเลขที่',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                 return (!empty($model->nhso_inv_num)? $model->nhso_inv_num:'-');
                            },
                            
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'หนังสือออกเลขที่',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                return (!empty($model->nhso_inv_hdoc)? $model->nhso_inv_hdoc:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'วันที่',
                            'format' => ['date', 'php:d/m/Y'],
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->nhso_inv_date;
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'ประเภท',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->doc_type)? $model->doc_type:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'รพ.ต้นสังกัด',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                return (!empty($model->hmain)? $model->hname:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'เรียน',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                return (!empty($model->nhso_inv_attnname)? $model->nhso_inv_attnname:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'กำหนดชำระ(วัน)',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->nhso_inv_crdays)? $model->nhso_inv_crdays:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'ยอดเรียกเก็บ',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->nhso_inv_cramt)? $model->nhso_inv_cramt:'0.00');
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'สถานะ',
                            'attribute' => 'itemstatus',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->itemstatus)? ($model->itemstatus=="1")?"Draft":"Saved":'-');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(\app\modules\Payment\models\VwFiNhsoInv::find()->all(), 'itemstatus', 'itemstatus'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'สถานะ'],
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'noWrap' => true,
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{select}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">บันทึกรับชำระ</span>',false, [
                                                    'title' => Yii::t('app', 'บันทึกรับชำระ'),
                                                    'onclick' => "btn_select($model->nhso_inv_id)"
                                    ]);
                                },
                            ], 
                        ],
					],
                ])
            ?>
            <?php Pjax::end() ?>
        </div>
        <?php echo $this->render('/config/btn_close.php'); ?>
      </div>
    </div>
</div>
<!--<a href="#" id="click">click</a>-->
<?php
        \yii\bootstrap\Modal::begin([
            'id' => 'select_inv',
            'header' => '<h4 class="modal-title">เลือกชำระ</h4>',
            'size' => 'modal-lg modal-primary',
        ]);
        ?>
        <div id="data_inv">
        </div>
<?php \yii\bootstrap\Modal::end(); ?>
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
<script>
   function btn_select($key){
    var keys = $key;
   	swal({   
        title: "ยืนยันคำสั่ง?",   
        text: "",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#53a93f",   
        confirmButtonText: "Confirm",   
        closeOnConfirm: true
    },function(){
    wait();
    $.post(
                'select-inv',
                {
                   keys
                },
                function (data)
                {   
                    if(data != false){
                        // $('#_form_inv').trigger('reset');
                        $('#_home').waitMe('hide');
                        // var nhso_inv_id = data;
                        // var url = "editform?nhso_inv_id="+nhso_inv_id;
                        // window.location.replace(url);
                        $('#select_inv').find('.modal-body').html(data);
                        $('#data_inv').html(data);
                        $('#select_inv').modal('show');
                        $('#detail_inv').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "columns": [
                                            
                                            null,
                                            null,
                                            null,
                                            null,
                                            null,
                                            null,
                                            {"bSortable": false}
                                        ],
                                        "pageLength": 5,
                                        responsive: true,
                                        "infoEmpty": "No records available",
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                        });
                       
                    }else{
                        $('#_home').waitMe('hide');
                        swal('ไม่พบข้อมูล','','warning');
                    }
                }
        );
    });
     console.log(keys);
   }
   function btn_all(array_size){
    var chk_btn = $('#chk_all').is(':checked');
    //console.log(chk_btn);
    if(chk_btn===true){
        for (i=1;i<=array_size;i++){
            var id_chkbox = "chk_box"+i;
            document.getElementById(id_chkbox).checked = true;
        }
    }else{
        for (i=1;i<=array_size;i++){
            var id_chkbox = "chk_box"+i;
            document.getElementById(id_chkbox).checked = false;
        }
    }
   }
   function btn_create(nhso_inv_id){
    var keys = new Array();
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            keys.push($(this).val());
        }
    });
    if (keys === undefined || keys.length == 0) {
        swal('กรุณาเลือกข้อมูลที่ต้องการชำระ','','warning');
    }else{
        swal({   
            title: "ยืนยันคำสั่ง?",   
            text: "",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: true
        },function(){
            wait_modal();
            $.post(
                'create-rep',
                {
                   keys,nhso_inv_id
                },
                function (data)
                {   
                    $('.modal-content').waitMe('hide');
                }
            );
        });
    }
    console.log(keys);
   }
   function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_home').waitMe({
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
    }
    function wait_modal(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('.modal-content').waitMe({
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
    }        
</script>
<?php 
$script = <<< JS
// $('#chk_all').click(function (e) {
//    alert('all');
// });
JS;
$this->registerJs($script);
?>