<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
?>
<div class="tabbable">
        <div class="col-sm-12">
                <div class="detail_rep">
                                    <?php Pjax::begin(['id' => 'detail_pjax', 'timeout' => 5000]) ?>
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
                                        'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'ลำดับ',
                                                'hAlign' => GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                    if ($model->rep_seq == null) {
                                                        return '-';
                                                    } else {
                                                        return $model->rep_seq;
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
                                                'header' => 'AN',
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
                                                'header' => 'ชื่อ-นามสกุล',
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
                                                'header' => 'รพ.หลัก',
                                                'hAlign' => GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                    if ($model->hmain == null) {
                                                        return '-';
                                                    } else {
                                                        return $model->hmain;
                                                    }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'วันที่เข้ารักษา',
                                                //'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                    if ($model->pt_registry_datetime == null) {
                                                        return '-';
                                                    } else {
                                                        return $model->pt_registry_datetime;
                                                    }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'วันที่จำหน่าย',
                                                //'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                    if ($model->pt_discharge_datetime == null) {
                                                        return '-';
                                                    } else {
                                                        return $model->pt_discharge_datetime;
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