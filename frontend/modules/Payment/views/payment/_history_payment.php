<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
/* @var $this yii\web-\View */
/* @var $searchModel ----app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "ประวัติชำระเงิน";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_C').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="tabbable" id="wait_history">
<?php echo $this->render('_tab_menu_payment'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-list-index">
                <?php Pjax::begin(['id' => 'history_pjax', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_history', ['model' => $searchModel]); ?>
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
                    //'showPageSummary' => true,
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
                            'header' => 'ใบเสร็จรับเงิน',
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
                            'header' => 'วันที่',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->repdate == null) {
                            return '-';
                        } else {
                            return $model->repdate;
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
                        if ($model->pt_admission_number == null) {
                            return '-';
                        } else {
                            return $model->pt_admission_number;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                            //'pageSummary' => 'รวม',
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เบิกไม่ได้',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->Item_PayAmt == null) {
                            return '0.00';
                        } else {
                            return $model->Item_PayAmt;
                        }
                    }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'options' => ['style' => 'width:100px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{select}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>','#', [
                                                    'title' => Yii::t('app', 'Select'),
                                                    'onclick' => "history_rep($model->rep_id)",
                                            ]);
                                },
                                ],
                        ],
                    ]
                ]);
                ?>
                
                <?php Pjax::end() ?>
                <div class="form-group" style="text-align: right;margin-right: 10px">
                    <?= Html::a('Close', ['history'], ['class' => 'btn btn-default']) ?>
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
function history_rep(rep_id){
        $.get(
                'index.php?r=Payment/payment/history-detail',
            {
                rep_id
            },
            function (data)
            {
                        
            }
        );
}
</script>