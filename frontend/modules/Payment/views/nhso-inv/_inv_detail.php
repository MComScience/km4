<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
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
?>
<div class="col-sm-12 col-md-12 col-lg-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <!-- <div class="panel-heading bg-default"><div class="panel-title back"><?= Html::encode('รายละเอียดสินค้า') ?></div></div> -->
            <?=
                 kartik\grid\GridView::widget([
                     'dataProvider' => $dataProvider,
                     'bootstrap' => true,
                     'responsiveWrap' => FALSE,
                     'responsive' => true,
                     'showPageSummary' => true,
                     'hover' => true,
                     'pjax' => true,
                     'striped' => true,
                     'condensed' => true,
                     'toggleData' => false,
                     'pageSummaryRowOptions' => ['class' => 'default', 'id' => 'setting_summary_row'],
                     'layout' => "\n{items}\n{pager}",
                     'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                     //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                     'columns' => [
                         [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => 'ลำดับ',
                                'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'REP',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return (!empty($model->rep)? $model->rep:'-');
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'Type',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                   return (!empty($model->doc_type)? $model->doc_type:'-');
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'HN',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                     return (!empty($model->pt_hospital_number)? $model->pt_hospital_number:'-');
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'PID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return (!empty($model->pid)? $model->pid:'-');
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ชื่อ-สกุล',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return (!empty($model->pt_name)? $model->pt_name:'-');
                                }
                         ],
                         [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'วันเข้ารักษา',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_registry_datetime;
                            }
                         ],
                         [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'วันจำหน่าย',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_discharge_datetime;
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชดเชยสุทธิสปสช.',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->fpnhso_piad)? $model->fpnhso_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชดเชยสุทธิจ้นสังกัด',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->affiliation_piad)? $model->affiliation_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'สถานะ',
                            'attribute' => 'itemstatus',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->itemstatus)? $model->itemstatus:'-');
                            }
                        ],
                         // [
                         //        'class' => 'kartik\grid\ActionColumn',
                         //        //'contentOptions' => ['style' => 'width:260px;'],
                         //        'options' => ['style' => 'width:90px;'],
                         //        'header' => 'Actions',
                         //        'hAlign' => GridView::ALIGN_CENTER,
                         //        'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                         //        'template' => '{edit}',
                         //        'buttons' => [
                         //            'edit' => function ($url, $model) {
                         //                return Html::a('<span class="btn btn-info btn-xs">Edit</span>','#', [
                         //                            'title' => Yii::t('app', 'Edit'),
                         //                            'onclick' => "fn_edit($model->ItemInternalLotNum)",
                         //               ]); 
                         //            },
                                    
                         //        ],
                         // ],
                    ],
                     
                ])
              ?>
         
        </div>
        <input type="hidden" id="nhso_inv_id" value="<?php echo $nhso_inv_id; ?>">
        <div class="form-group" style="text-align: right">
            <?= Html::a('พิมพ์หนังสือเรียกเก็บ','#',['class'=>'btn btn-info','onclick'=>"fn_print_inv($nhso_inv_id);"]) ?>
            <?= Html::a('พิมพ์เอกสารแนบ REP','#',['class'=>'btn btn-info','onclick'=>"fn_print_inv_rep($nhso_inv_id);"]) ?>
        </div>
    </div>
    
    <script>
    function wait(){
        var current_effect = 'ios'; 
        run_waitMe(current_effect);
        function run_waitMe(effect){
            $('.page-content').waitMe({
            effect: 'ios',
            text: 'กำลังโหลดข้อมูล...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {}
            });
        }
    }  
    function fn_print_inv($key){
        alert($key);
    }
    function fn_print_inv_rep($key){
        alert($key);
    }
    </script>
