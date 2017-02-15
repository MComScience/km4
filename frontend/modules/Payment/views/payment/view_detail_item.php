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
                <div class="col-sm-8">
                <label style="color:#53a93f;text-align:left;">รายละเอียด</label>
                    <div class="tb-st2-temp-index">
                                    <?php Pjax::begin(['id' => 'item_detail_pjax', 'timeout' => 5000]) ?>
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
                                            
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ชื่อหน่วยงาน(ลูกหนี้)',
                                                'hAlign' => kartik\grid\GridView::ALIGN_LEFT,
                                                'value' => function ($model) {
                                            if ($model->ar_name1 == NULL) {
                                                return '-';
                                            } else {
                                                return $model->ar_name1;
                                            }
                                        }
                                            ],
                                                 
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ใช้สิทธิ',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'format'=> 'html',
                                                'value' => function ($model) {
                                            if ($model->pt_ar_usage == 'ใช้สิทธิ์') {
                                                return  '<i class="glyphicon glyphicon-ok" style="color:#53a93f;"></i>';
                                            } else {
                                                return '<i class="glyphicon glyphicon-remove" style="color:#d73d32;"></i>';
                                            }
                                        }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ขอเบิกได้',
                                                //'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                            if ($model->Item_Amt == NULL) {
                                                return '-';
                                            } else {
                                                return $model->Item_Amt;
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