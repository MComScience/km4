<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
?>
<div class="tb-pr-temp-view">
    <div class="col-sm-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h5 class="panel-title">
                    <?= Html::encode('Lot Number Detail') ?>   
                </h5>
            </div>
            <?=
                 kartik\grid\GridView::widget([
                     'dataProvider' => $dataProvider,
                     'bootstrap' => true,
                     'responsiveWrap' => FALSE,
                     'responsive' => true,
                     'showPageSummary' => true,
                     'hover' => true,
                     'pjax' => true,
                     'striped' => true,
                     'condensed' => true,
                     'toggleData' => false,
                     'pageSummaryRowOptions' => ['class' => 'default'],
                     'layout' => "\n{items}\n{pager}",
                     'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                     //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                     'columns' => [
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'Internal',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->ItemInternalLotNum != null) {
                                            return $model->datasubdetail->ItemInternalLotNum;
                                        } else {
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'หมายเลขการผลิต',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->ItemExternalLotNum != null) {
                                            return $model->datasubdetail->ItemExternalLotNum;
                                        } else {
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'วันหมดอายุ',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                //'format' => ['date', 'php:d/m/Y'],
                                'value' => function ($model) {
                                        if ($model->datasubdetail->ItemExpDate != null) {
                                            return $model->datasubdetail->ItemExpDate;
                                        } else {
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'จำนวนแพค',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->STPackQty != null) {
                                            return $model->datasubdetail->STPackQty;
                                        } else {
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'หน่วยแพค',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->STPackUnit != null) {
                                            return $model->datasubdetail->STPackUnit;
                                        }else{    
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ราคา/แพค',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'pageSummary' => 'รวม',
                                'value' => function ($model) {
                                        if ($model->datasubdetail->STPackUnitCost != null) {
                                            return $model->datasubdetail->STPackUnitCost;
                                        }else{    
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'จำนวน',
                                'format' => ['decimal', 2],
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'pageSummary' => TRUE,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->STItemQty != null) {
                                            return $model->datasubdetail->STItemQty;
                                        }else{    
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'หน่วย',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->DispUnit != null) {
                                            return $model->datasubdetail->DispUnit;
                                        }else{    
                                            return '-';
                                        }
                                }
                               ],
                               [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ราคา/หน่วย',
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->STItemUnitCost != null) {
                                            return $model->datasubdetail->STItemUnitCost;
                                        }else{    
                                            return '-';
                                        }
                                }
                               ],
                               [
                               'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รวมเป็นเงิน',
                                'format' => ['decimal', 2],
                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                        if ($model->datasubdetail->STExtenedCost != null) {
                                            return $model->datasubdetail->STExtenedCost;
                                        }else{    
                                            return '-';
                                        }
                                }
                               ],
                     ],
                     
                 ])
              ?>
         
        </div>
    </div>
    
</div>

