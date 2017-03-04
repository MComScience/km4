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
                    'columns' => [
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'ลำดับ',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->Line == null) {
                                            return '-';
                                        } else {
                                            return $model->Line;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'HN',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->HN == null) {
                                            return '-';
                                        } else {
                                            return $model->HN;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'บัตรประชาชน',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->BillNo == null) {
                                            return '-';
                                        } else {
                                            return $model->BillNo;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'InvNo',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                        if ($model->InvNo == null) {
                                            return '-';
                                        } else {
                                            return $model->InvNo;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'ชื่อ-นามสกุล',
                                    'hAlign' => GridView::ALIGN_CENTER,
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
                                    'header' => 'วันที่เข้ารักษา',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->DTTran == null) {
                                            return '-';
                                        } else {
                                            return $model->DTTran;
                                        }
                                    }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                    'header' => 'เป็นเงิน',
                                    'format' => ['decimal',2],
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                        if ($model->Amount_Paid == null) {
                                            return '0';
                                        } else {
                                            return $model->Amount_Paid;
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
        