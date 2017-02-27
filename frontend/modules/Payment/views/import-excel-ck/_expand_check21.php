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
            <div class="panel-heading" style="background-color:#dff0d8;"><div class="panel-title back"><?= Html::encode('vw_nk_checkup21') ?></div></div>
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
                                'header' => 'Pap smear',
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
                                'header' => 'Pap smear',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->PAP == null) {
                                        return '0';
                                    } else {
                                        return $model->PAP;
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
                                'header' => 'UA',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->UA == null) {
                                        return '0';
                                    } else {
                                        return $model->UA;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => $header_style,
                                'header' => 'Stool',
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
                                'header' => 'Sugar',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->Sugar == null) {
                                        return '0';
                                    } else {
                                        return $model->Sugar;
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
                                'header' => 'SGOT',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->SGOT == null) {
                                        return '0';
                                    } else {
                                        return $model->SGOT;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => $header_style,
                                'header' => 'SGPT',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->SGPT == null) {
                                        return '0';
                                    } else {
                                        return $model->SGPT;
                                    }
                                }
                            ],
                            [
                                'headerOptions' => $header_style,
                                'header' => 'ALK.Phoshatuse',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->ALK == null) {
                                        return '0';
                                    } else {
                                        return $model->ALK;
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
                            
                        ],
                    ]);
                    ?>
        </div>
    </div>