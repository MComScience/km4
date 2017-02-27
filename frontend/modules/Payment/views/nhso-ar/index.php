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
$headerGridColspan = ['style' => 'text-align:center;color:#000000;','hidden'=>true];
$filterGridColspan = ['style' => 'text-align:center;color:#000000;background-color: #dff0d8;'];
$this->title = 'สร้างหนังสือเรียกเก็บ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="_nhso_ar" class="tabbable">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <?php Pjax::begin(['id' => 'ar_pjax', 'timeout' => 5000]) ?>
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
                            'headerOptions' => $headerGrid,
                            'header' => 'REP',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                 return (!empty($model->rep)? $model->rep:'-');
                            }
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
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'HN',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->pt_hospital_number)? $model->pt_hospital_number:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'AN',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->pt_admission_number)? $model->pt_admission_number:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'ชื่อสกุล',
                            'filterOptions' => $filterGrid,
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                return (!empty($model->pt_name)? $model->pt_name:'-');
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'วันเข้ารักษา',
                            'filterOptions' => $filterGrid,
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_registry_datetime;
                            }
                        ],
                        [
                            'headerOptions' => $headerGrid,
                            'header' => 'วันจำหน่าย',
                            'filterOptions' => $filterGrid,
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_discharge_datetime;
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;','colspan'=>'3'],
                            'header' => 'ชดเชยสุทธิ',
                            'format' => ['decimal',2],
                            'filterOptions' => $filterGridColspan,
                            'filter'=> 'สปสช.',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                return (!empty($model->fpnhso_piad)? $model->fpnhso_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => $headerGridColspan,
                            //'header' => 'ชดเชยสุทธิต้นสังกัด',
                            'format' => ['decimal',2],
                            'filterOptions' => $filterGridColspan,
                            'filter'=> 'ต้นสังกัด',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                return (!empty($model->affiliation_piad)? $model->affiliation_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => $headerGridColspan,
                            //'header' => 'ชดเชยจาก',
                            'filterOptions' => $filterGridColspan,
                            'filter'=> 'จาก',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->paid_by)? $model->paid_by:'-');
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'รพ.ต้นสังกัด',
                            'attribute' => 'hmain',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                return (!empty($model->hmain)? $model->hname:'-');
                            },
                            'filterType'=>GridView::FILTER_SELECT2,
						    'filter'=>ArrayHelper::map(\app\modules\Payment\models\VwFiNhsoAr::find()->all(), 'hmain', 'hname'), 
						    'filterWidgetOptions'=>[
						        'pluginOptions'=>['allowClear'=>true],
						    ],
						    'filterInputOptions'=>['placeholder'=>'ต้นสังกัด'],
						],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'สถานะ',
                            'attribute' => 'itemstatus',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->itemstatus)? $model->itemstatus:'-');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(\app\modules\Payment\models\VwFiNhsoAr::find()->all(), 'itemstatus', 'itemstatus'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'สถานะ'],
                        ],
						[
		                    'class' => '\kartik\grid\CheckboxColumn',
		                    'options' => ['style' => 'width:150px;'],
		                    'headerOptions' => ['style' => 'text-align:center;color:#000000;width:200px;'],
		                    'header' => Html::checkBox('selection_all', false, [
		                        //'class' => 'select-on-check-all',
		                        'label' => '<span class="text"></span>',
		                        'value' => 'chk_all'
		                    ]),

		                    'checkboxOptions' => ['label' => '<span class="text"></span>',],
		                    'rowSelectedClass' => GridView::TYPE_SUCCESS,
		                ],
					],
                ])
            ?>
            
            <?php Pjax::end() ?>
        </div>
        <div class="form-group" style="text-align: right">
            <?= Html::a('Close',['index'],['class'=>'btn btn-default']) ?>
            <?= Html::a('สร้างหนังสือเรียกเก็บ',false,['class'=>'btn btn-success','onclick'=>"btn_select();"]) ?>
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
                'create-inv',
                {
                   keys
                },
                function (data)
                {   
                    if(data != false){
                        $('#_form_inv').trigger('reset');
                        $('#_nhso_ar').waitMe('hide');
                        // var nhso_inv_id = data;
                        // var url = "createform?nhso_inv_id="+nhso_inv_id;
                        // window.location.replace(url);
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

