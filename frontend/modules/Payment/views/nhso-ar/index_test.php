<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwFiNhsoArSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$headerGrid = ['class'=>'kv-align-middle','style' => 'text-align:center;color:#000000;','rowspan'=>'2'];
$filterGrid = ['style'=>'display:none;'];
$headerGridColspan = ['style' => 'text-align:center;color:#000000;','hidden'=>true];
$filterGridColspan = ['style' => 'text-align:center;color:#000000;background-color: #dff0d8;'];
$this->title = 'สร้างหนังสือเรียกเก็บ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="_nhso_ar" class="tabbable">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
            <?=
                    common\widgets\kartik_datatables\DataTables::widget([
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
                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                            'width' => '36px',
                            'header' => 'ลำดับ',
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;']
                        ],
                        
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'Type',
                            'attribute' => 'ar_itemtype',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->ar_itemtype)? $model->ar_itemtype:'-');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(\app\modules\Payment\models\VwFiNhsoAr::find()->all(), 'ar_itemtype', 'ar_itemtype'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'Type'],
                        ],
                       
                        
                       
                        
                                    ],


                                ]);
                                    ?>
            

            
        </div>
        <div class="form-group" style="text-align: right">
            <?= Html::a('สร้างหนังสือเรียกเก็บ','#',['class'=>'btn btn-success','onclick'=>"btn_select();"]) ?>
            <?= Html::a('Close','index.php?r=',['class'=>'btn btn-default']) ?>
        </div>
      </div>
    </div>
</div>
<!--<a href="#" id="click">click</a>-->
<?php
        \yii\bootstrap\Modal::begin([
            'id' => 'form_inv',
            'header' => '<h4 class="modal-title">สร้างหนังสือเรียกเก็บ</h4>',
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
   function btn_select(){
   	var keys = new Array();
   	$('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            keys.push($(this).val());
        }
    });
    
    swal({   
        title: "",   
        text: "ยืนยันคำสั่ง?",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#53a93f",   
        confirmButtonText: "Confirm",   
        closeOnConfirm: true
    },function(){
    wait();
    $.post(
                'create-inv',
                {
                   keys
                },
                function (data)
                {   
                    if(data != false){
                        $('#_form_inv').trigger('reset');
                        $('#_nhso_ar').waitMe('hide');
                        var nhso_inv_id = data;
                        var url = "createform?nhso_inv_id="+nhso_inv_id;
                        window.location.replace(url);
                    }else{
                        $('#_nhso_ar').waitMe('hide');
                        swal('','กรุณาเลือกโรงพยาบาลต้นสังกัดและประเภทผู้ป่วยเดียวกันหรือไม่ได้เลือก','warning');
                    }
                    
                }
        );
    });
     console.log(keys);
   }
   function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_nhso_ar').waitMe({
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

