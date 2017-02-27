<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="text-align: center">
           <br><!-- <h4><i class="glyphicon glyphicon-hand-down"></i></h4> -->
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:#dff0d8;"><div class="panel-title back"><?= Html::encode('รายละเอียด') ?></div></div>
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
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        if ($model->hmain2 == null) {
                                            return '-';
                                        } else {
                                            return $model->hmain2;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'เลขที่ใบส่งตัว',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        if ($model->refer_hsender_doc_id == null) {
                                            return '-';
                                        } else {
                                            return $model->refer_hsender_doc_id;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'วันที่เข้ารักษา',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        return $model->pt_registry_datetime;
                                    }
                                ],
                                // [
                                //     'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                //     'header' => 'วันที่จำหน่าย',
                                //     //'format' => ['date', 'php:d/m/Y'],
                                //     'hAlign' => GridView::ALIGN_CENTER,
                                //     'value' => function ($model) {
                                //         if ($model->pt_discharge_datetime == null) {
                                //             return '-';
                                //         } else {
                                //             return $model->pt_discharge_datetime;
                                //         }
                                //     }
                                // ],
                            ],
                        ]);
                        ?>
          </div> 
        </div>