<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
//print_r($dataProviderCat1);
//print_r($dataProviderCat2);
?>
<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
        <div style="text-align: center">
           <br><!-- <h4><i class="glyphicon glyphicon-hand-down"></i></h4> -->
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-default"><div class="panel-title back"><?= Html::encode('รายการสั่งซื้อ') ?></div></div>
            <?=
                 kartik\grid\GridView::widget([
                     'dataProvider' => $dataProviderCat1,
                     'bootstrap' => true,
                     'responsiveWrap' => FALSE,
                     'responsive' => true,
                     'showPageSummary' => true,
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
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => 'ลำดับ',
                                    'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รหัสสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->ItemID == null) {
                                        return '-';
                                    } else {
                                        return $model->ItemID;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รายละเอียดสินค้า',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    if ($model->ItemDetail == null) {
                                        return '-';
                                    } else {
                                        return $model->ItemDetail;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'จำนวน',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->POQty == null) {
                                        return '0.00';
                                    } else {
                                        return $model->POQty;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ราคาต่อหน่วย',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->POUnitCost == null) {
                                        return '0.00';
                                    } else {
                                        return $model->POUnitCost;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'หน่วย',
                                'pageSummary' =>'รวมเป็นเงิน',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->POUnit == null) {
                                        return '-';
                                    } else {
                                        return $model->POUnit;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ราคารวม',
                                'pageSummary' =>true,
                                //'pageSummaryOptions' => ['class' => 'bg-white'],
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->POExtenedCost == null) {
                                        return '0.00';
                                    } else {
                                        return $model->POExtenedCost;
                                    }
                                }
                         ],                
                     ],
                     
                ])
              ?>
         
        </div>
    </div>
<div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-11 col-lg-11">
        <div class="panel panel-default">
            <div class="panel-heading bg-default"><div class="panel-title back"><?= Html::encode('รายการบริจาค') ?></div></div>
            <?=
                 kartik\grid\GridView::widget([
                     'dataProvider' => $dataProviderCat2,
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
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => 'ลำดับ',
                                    'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รหัสสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->ItemID == null) {
                                        return '-';
                                    } else {
                                        return $model->ItemID;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รายละเอียดสินค้า',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    if ($model->ItemDetail == null) {
                                        return '-';
                                    } else {
                                        return $model->ItemDetail;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'จำนวน',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->POQty == null) {
                                        return '0.00';
                                    } else {
                                        return $model->POQty;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ราคาต่อหน่วย',
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->POUnitCost == null) {
                                        return '0.00';
                                    } else {
                                        return $model->POUnitCost;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'หน่วย',
                                'pageSummary' =>'รวมเป็นเงิน',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->POUnit == null) {
                                        return '-';
                                    } else {
                                        return $model->POUnit;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'ราคารวม',
                                'pageSummary' =>true,
                                'format' => ['decimal', 2],
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->POExtenedCost == null) {
                                        return '0.00';
                                    } else {
                                        return $model->POExtenedCost;
                                    }
                                }
                         ],                
                     ],
                     
                ])
              ?>
         
        </div>
    </div>