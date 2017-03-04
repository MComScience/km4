<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
$header_style = ['style' => 'text-align:center;color:#000000;'];
echo $this->render('/config/Asset_Js.php');
?>
<div class="col-sm-12 col-md-12 col-lg-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <!-- <div class="panel-heading bg-default"><div class="panel-title back"><?= Html::encode('รายละเอียดสินค้า') ?></div></div> -->
            <?php Pjax::begin(['id' => 'rep_pjax', 'timeout' => 5000]) ?>
            <?=
                 kartik\grid\GridView::widget([
                    'id' => 'ar_rep',
                     'dataProvider' => $dataProvider,
                     'bootstrap' => true,
                     'responsiveWrap' => FALSE,
                     'responsive' => true,
                     'showPageSummary' => true,
                     'hover' => true,
                     'pjax' => FALSE,
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
                                'headerOptions' => $header_style,
                                'header' => 'REP',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return (!empty($model->rep)? $model->rep:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'Type',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                   return (!empty($model->doc_type)? $model->doc_type:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'HN',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                     return (!empty($model->pt_hospital_number)? $model->pt_hospital_number:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'PID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return (!empty($model->pid)? $model->pid:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'ชื่อ-สกุล',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return (!empty($model->pt_name)? $model->pt_name:'-');
                                }
                         ],
                         [
                            'headerOptions' => $header_style,
                            'header' => 'วันเข้ารักษา',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_registry_datetime;
                            }
                         ],
                         [
                            'headerOptions' => $header_style,
                            'header' => 'วันจำหน่าย',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_discharge_datetime;
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชดเชยสุทธิสปสช.',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->fpnhso_piad)? $model->fpnhso_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชดเชยสุทธิจ้นสังกัด',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->affiliation_piad)? $model->affiliation_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'สถานะ',
                            'attribute' => 'itemstatus',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->itemstatus)? $model->itemstatus:'-');
                            }
                        ],
                        // [
                        //     'class' => '\kartik\grid\CheckboxColumn',
                        //     'options' => ['style' => 'width:150px;'],
                        //     'headerOptions' => ['style' => 'text-align:center;color:#000000;width:200px;'],
                        //     'header' => Html::checkBox('selection_all', false, [
                        //         //'class' => 'select-on-check-all',
                        //         'label' => '<span class="text"></span>',
                        //         'value' => 'chk_all'
                        //     ]),

                        //     'checkboxOptions' => ['label' => '<span class="text"></span>',],
                        //     'rowSelectedClass' => GridView::TYPE_SUCCESS,
                        // ],
                         // [
                         //        'class' => 'kartik\grid\ActionColumn',
                         //        //'contentOptions' => ['style' => 'width:260px;'],
                         //        'options' => ['style' => 'width:90px;'],
                         //        'header' => 'Actions',
                         //        'hAlign' => GridView::ALIGN_CENTER,
                         //        'headerOptions' => $header_style,
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
            <?php Pjax::end() ?>
        </div>
        <input type="hidden" id="nhso_inv_id" value="<?php echo $nhso_inv_id; ?>">
    </div>
