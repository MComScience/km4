<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwInvForRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "ร่างบันทึกการชำระเงิน";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_B').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="tabbable">
    <?php echo $this->render('_tab_menu_payment'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-inv-for-rep-list-index">
                <?php Pjax::begin(['id' => 'rep_pjax', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_rep', ['model' => $searchModel]); ?>
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
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                            'expandOneOnly' => true,
                            //'header' => '<a>Detail</a>',
                            //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                            //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                            'detailAnimationDuration' => 'slow', //fast
                            'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                            'detailUrl' => \yii\helpers\Url::to(['view-detail-rep']),
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ใบแจ้งค่าใช้จ่าย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->rep_num == null) {
                            return '-';
                        } else {
                            return $model->rep_num;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'HN',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->pt_hospital_number == null) {
                            return '-';
                        } else {
                            return $model->pt_hospital_number;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'VN : AN',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->pt_hospital_number == null) {
                            return '-';
                        } else {
                            return $model->pt_hospital_number;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                        if ($model->pt_name == null) {
                            return '-';
                        } else {
                            return $model->pt_name;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'จำนวนเงิน',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->Item_Amt == null) {
                            return '0.00';
                        } else {
                            return $model->Item_Amt;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เบิกได้',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->Item_Cr_Amt_Sum == null) {
                            return '0.00';
                        } else {
                            return $model->Item_Cr_Amt_Sum;
                        }
                    }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'options' => ['style' => 'width:160px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{select} {owed}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>','#', [
                                                    'title' => Yii::t('app', 'Select'),
                                                    'onclick' => "select_rep($model->rep_id)",
                                            ]);
                                },
                                       'owed' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-warning btn-xs">บันทึกค้างชำระ</span>','#', [
                                                    'title' => Yii::t('app', 'บันทึกค้างชำระ'),
                                                    'onclick' => "select_owed($model->rep_id)",
                                            ]);
                                },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                //Update
//                                if ($action === 'select') {
//                                    return Url::to(['create', 'inv_id' => $model['inv_id']]);
//                                }
//                                if ($action === 'owed') {//Delete
//                                    return Url::to(['delete']);
//                                }
                            }
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end() ?>
                        <div class="form-group" style="margin-top:30px;text-align: right">
                                <?= Html::a('Close', ['rep-create'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $script = <<< JS
                
JS;
$this->registerJs($script);
?>
<script>
function select_rep(rep_id){
        $.get(
                'index.php?r=Payment/payment/rep-to-create',
                {
                    rep_id
                },
                function (data)
                {

        }
    );
}
function select_owed(rep_id){
  swal("", "รอออกแบบหน้าบันทึกค้างชำระ", "warning");
}  
</script>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                 <?php
                 echo \kartik\widgets\Growl::widget([
                     'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                     'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                     'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                     'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                     'showSeparator' => true,
                     'delay' => 1, //This delay is how long before the message shows
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
                               