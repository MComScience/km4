<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
$header_style = ['style' => 'text-align:center;color:#000000;'];
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="text-align: center">
           <br><!-- <h4><i class="glyphicon glyphicon-hand-down"></i></h4> -->
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:#dff0d8;"><div class="panel-title back"><?= Html::encode('vw_nk_checkup02') ?></div></div>
                <?=
                kartik\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'bootstrap' => true,
                    'responsiveWrap' => FALSE,
                    'responsive' => true,
                    //'showPageSummary' => true,
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
                            'headerOptions' => $header_style,
                            'header' => 'ids',
                            //'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->ids == null) {
                                    return '0';
                                } else {
                                    return $model->ids;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'PV/Pap smear',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->PV == null) {
                                    return '0';
                                } else {
                                    return $model->PV;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'CBC',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->CBC == null) {
                                    return '0';
                                } else {
                                    return $model->CBC;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'UrineExam',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Urine == null) {
                                    return '0';
                                } else {
                                    return $model->Urine;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'StoolExam',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Stool == null) {
                                    return '0';
                                } else {
                                    return $model->Stool;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'Glucose',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Glucose == null) {
                                    return '0';
                                } else {
                                    return $model->Glucose;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'BUN',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->BUN == null) {
                                    return '0';
                                } else {
                                    return $model->BUN;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'Creatinine',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Creatinine == null) {
                                    return '0';
                                } else {
                                    return $model->Creatinine;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'UricAcid',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Uric == null) {
                                    return '0';
                                } else {
                                    return $model->Uric;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'Cholesterol',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Cholesterol == null) {
                                    return '0';
                                } else {
                                    return $model->Cholesterol;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'Triglyceride',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Triglyceride == null) {
                                    return '0';
                                } else {
                                    return $model->Triglyceride;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'L.F.T',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->LFT == null) {
                                    return '0';
                                } else {
                                    return $model->LFT;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'Serology',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Serology == null) {
                                    return '0';
                                } else {
                                    return $model->Serology;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'CXR',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->CXR == null) {
                                    return '0';
                                } else {
                                    return $model->CXR;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'PSA',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->PSA == null) {
                                    return '0';
                                } else {
                                    return $model->PSA;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'EKG',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->EKG == null) {
                                    return '0';
                                } else {
                                    return $model->EKG;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ThinPrep',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->Thin == null) {
                                    return '0';
                                } else {
                                    return $model->Thin;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'HPV-DNA',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->HPV == null) {
                                    return '0';
                                } else {
                                    return $model->HPV;
                                }
                            }
                        ],
                    ],
                ]);
                ?>
            </div>
    </div>