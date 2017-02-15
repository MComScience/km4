<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
?>
<div class="tabbable">
    <div class="tab-content tabs-flat">
        <div id="body_payment" class="tab-pane active">
            <div class="row profile-overview">
                <div class="col-sm-12">
                    <div class="profile-container">
                        <div class="profile-header row">
                            <div class="col-sm-2 text-center" style="margin-top: 10px;">
                                <img src="assets/img/avatars/admin.png" alt="" class="header-avatar" />
                            </div>
                            <div class="col-sm-10" style="margin-top: 30px;">
                               <label style="color:#53a93f;">สิทธิการรักษา</label>
                                <div class="tb-st2-temp-index">
                                    <?php Pjax::begin(['id' => 'inv_detail_pjax', 'timeout' => 5000]) ?>
                                    <?=
                                    kartik\grid\GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        //'filterModel' => $searchModel,
                                        'bootstrap' => true,
                                        'responsiveWrap' => FALSE,
                                        'responsive' => true,
                                        //'showPageSummary' => true,
                                        'hover' => true,
                                        'pjax' => true,
                                        'striped' => true,
                                        'condensed' => true,
                                        'toggleData' => false,
                                        'pageSummaryRowOptions' => ['class' => 'default'],
                                        'layout' => Yii::$app->componentdate->layoutgridview(),
                                        //'layout' => "{summary}\n{items}\n{pager}",
                                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                            ],
                                        //     [
                                        //         'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                        //         'header' => 'ลำดับสิทธิ',
                                        //         'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                        //         'value' => function ($model) {
                                        //     if ($model->pt_ar_seq == NULL) {
                                        //         return '-';
                                        //     } else {
                                        //         return $model->pt_ar_seq;
                                        //     }
                                        // }
                                        //     ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'สิทธิการรักษา',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                            if ($model->medical_right_group == NULL) {
                                                return '-';
                                            } else {
                                                return $model->medical_right_group;
                                            }
                                        }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ชื่อหน่วยงาน(ลูกหนี้)',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                            if ($model->ar_name == NULL) {
                                                return '-';
                                            } else {
                                                return $model->ar_name;
                                            }
                                        }
                                            ],
                                            
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'เลขที่ใบส่งตัว',
                                                //'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                            if ($model->refer_hrecieve_doc_id == NULL) {
                                                return '-';
                                            } else {
                                                return $model->refer_hrecieve_doc_id;
                                            }
                                        }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'วันเริ่มใบส่งตัว',
                                                'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                            if ($model->refer_hsender_doc_start == NULL) {
                                                return '0';
                                            } else {
                                                return $model->refer_hsender_doc_start;
                                            }
                                        }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'วันสิ้นสุดใบส่งตัว',
                                                'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                            if ($model->refer_hsender_doc_expdate == NULL) {
                                                return '0';
                                            } else {
                                                return $model->refer_hsender_doc_expdate;
                                            }
                                        }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ใช้สิทธิ',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                            if ($model->pt_ar_usage == NULL) {
                                                return '-';
                                            } else {
                                                return $model->pt_ar_usage;
                                            }
                                        }
                                            ],
                                        ],
                                    ]);
                                    ?>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>