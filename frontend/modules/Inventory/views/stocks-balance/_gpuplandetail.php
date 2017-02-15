<?php

use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
?>

<br>
<div class="gpuplandetail-index">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <?php if ($checkgpu != null) { ?>
                        <li class="active">
                            <a data-toggle="tab" href="#ยาสามัญ">
                                <h5 class="panel-title">แผนการจัดซื้อยาสามัญ</h5>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($TypeIDTPU == '7' or $TypeIDTPU == '8') { ?>
                        <li class="tab-blue">
                            <a data-toggle="tab" href="#ยาการค้า">
                                <h5 class="panel-title">แผนการจัดซื้อยาการค้า</h5>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($PlanTypeID3 == '3' or $PlanTypeID4 == '4') { ?>
                        <li class="tab-blue">
                            <a data-toggle="tab" href="#เวชภัณฑ์ฯ">
                                <h5 class="panel-title">แผนการจัดซื้อเวชภัณฑ์ฯ</h5>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($TypeIDTPU == '5') { ?>
                        <li class="tab-blue">
                            <a data-toggle="tab" href="#ยาสัญญาจะซื้อจะขาย">
                                <h5 class="panel-title">แผนการจัดซื้อยาสัญญาจะซื้อจะขาย</h5>
                            </a>
                        </li>
                    <?php } ?>
                    <?php if ($PlanTypeID6 == '6') { ?>
                        <li class="tab-blue">
                            <a data-toggle="tab" href="#เวชภัณฑ์สัญญาจะซื้อจะขาย">
                                <h5 class="panel-title">แผนการจัดซื้อเวชภัณฑ์สัญญาจะซื้อจะขาย</h5>
                            </a>
                        </li>
                    <?php } ?>

                </ul>
                <div class="tab-content">

                    <?php if ($checkgpu != null) { ?>
                        <div id="ยาสามัญ" class="tab-pane in active">
                            <div style="text-align: right">
                                <button class="btn btn-success edit" >Send to PR</button>  
                            </div>

                            <?php Pjax::begin([]); ?>
                            <?=
                            GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                //'panel' => ['type' => 'info', 'heading' => 'Grid Grouping Example'],
                                'export' => false,
                                //'id' =>'grid1',
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                //'showPageSummary' => true,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => "{summary}\n{items}\n{pager}",
                                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'rowOptions' => function ($model, $key, $index, $grid) {
                            $vwmodel = app\modules\Purchasing\models\Tbpritemdetail2temp::findAll([
                                        'PCPlanNum' => $model['PCPlanNum'],
                                        'TMTID_GPU' => $model['TMTID_GPU']
                            ]);
                            if ($vwmodel != null) {
                                return ['class' => 'warning'];
                            }
                            //return ['data-id' => $model->ids];
                        },
                                //'rowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
                                'toolbar' => [
                                    ['content' =>
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Send to PR'), ['class' => 'btn btn-success edit', 'id' => 'btn-select']) . ' ' .
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-print"></i> Print'), ['class' => 'btn btn-default', 'id' => 'btn-select'])
                                    ],
                                    '{export}',
                                    '{toggleData}',
                                ],
//                                'panel' => [
//                                    'type' => 'success',
//                                    'heading' => yii\helpers\Html::encode('สถานะแผนการจัดซื้อยาสามัญ'),
//                                    //'before'=>Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success pullleft', 'id' => 'btn-delete']),
//                                    'footer' => false,
//                                    'headingOptions' => ['style' => 'text-align:left'],
//                                ],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn',
                                        'header' => false,
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                        'content' => function ($model, $key, $index, $column) {
                                    
                                }
                                    ],
                                    [
                                        'header' => 'เลขที่แผนจัดซื้อ',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PCPlanNum',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รหัสยาสามัญ',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'TMTID_GPU',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รายละเอียดยาสามัญ',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'FSN_GPU',
                                        'value' => 'fsngpu1.FSN_GPU'
                                    ],
                                    [
                                        'header' => 'ราคาต่อหน่วย',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'GPUUnitCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'จำนวน',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'GPUOrderQty',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    //'format'=>['decimal', 2],
                                    //'pageSummary' => true,
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
                                    [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'DispUnit',
                                        'value' => 'fsngpu1.DispUnit'
                                    //'hAlign' => 'right',
                                    //'format' => ['decimal', 2],
                                    //'pageSummary' => true,
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
                                    [
                                        'header' => 'รวมเป็นเงิน',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'GPUExtendedCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'ขอซื้อแล้ว',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PRApprovedOrderQty',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                        'value' => 'prpprovedqty.PRApprovedOrderQty',
                                        //'vAlign' => GridView::ALIGN_CENTER,
                                        'width' => '120px',
                                    //'format' => ['decimal', 2],
                                    //'pageSummary' => 'รวมเป็นเงินทั้งสิ้น',
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
                                    [
                                        'header' => 'ขอซื้อได้',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PRGPUAvalible',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                        'value' => 'prpprovedqty.PRGPUAvalible',
                                    //'format' => ['decimal', 2],
                                    //'pageSummary' => true,
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
//                                [
//                                    'class' => 'kartik\grid\ActionColumn',
//                                    //'contentOptions' => ['style' => 'width:260px;'],
//                                    'options' => ['style' => 'width:100px;'],
//                                    'header' => 'Actions',
//                                    'hAlign' => GridView::ALIGN_CENTER,
//                                    'headerOptions' => ['style' => 'text-align:center;'],
//                                    'template' => ' {view}',
//                                    'buttonOptions' => ['class' => 'btn btn-default'],
//                                    'buttons' => [
//                                        'view' => function ($url, $model) {
//                                            return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
//                                                        //'title' => Yii::t('app', 'view'),
//                                                        'id' => 'activity-view-link',
//                                                        //'role' => 'modal-remote',
//                                                        'title' => 'Select',
//                                                        'data-toggle' => 'modal',
//                                                        'data-target' => '#activity-modal',
//                                                            //'data-id' => $key,
//                                                            //'data-pjax' => '0',
//                                            ]);
//                                        },
//                                            ],
//                                        ],
//            [
//                'class' => 'kartik\grid\FormulaColumn',
//                'header' => '',
//                'mergeHeader' => true,
//                'width' => '150px',
//                'hAlign' => 'right',
//                'pageSummary' => 'บาท'
//            ],
                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    <?php } ?>
                    <?php if ($TypeIDTPU == '7' or $TypeIDTPU == '8') { ?>

                        <div id="ยาการค้า" class="tab-pane">
                            <div style="text-align: right">
                                <button class="btn btn-success delete" >Send to PR</button>  
                            </div>
                            <?php Pjax::begin([ 'timeout' => 5000]) ?>
                            <?php
//                        $dataProvider = new ActiveDataProvider([
//                            'query' => \app\modules\Inventory\models\VwTpuplanDetailAvalible::find()->where(['ItemID' => $model->ItemID,'PCPlanTypeID' => [7,8]]),
//                            'pagination' => [
//                                'pageSize' => 20,
//                            ],
//                        ]);
                            $searchModel = new app\modules\Inventory\models\TbPcplantpudetailSearch();
                            $searchModel->TMTID_TPU = $model->TMTID_TPU;
                            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                //'panel' => ['type' => 'info', 'heading' => 'Grid Grouping Example'],
                                'export' => false,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                //'id' =>'grid2',
                                //'showPageSummary' => true,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => "{summary}\n{items}\n{pager}",
                                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'rowOptions' => function ($model, $key, $index, $grid) {
                            $vwmodel = \app\modules\Inventory\models\TbPrSelectedDetail::findAll([
                                        'PCPlanNum' => $model['PCPlanNum'],
                                        'TMTID_TPU' => $model['TMTID_TPU']
                            ]);
                            if ($vwmodel != null) {
                                return ['class' => 'warning'];
                            }
                        },
                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
                                'toolbar' => [
                                    ['content' =>
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success delete', 'id' => 'btn-select']) . ' ' .
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-print"></i> Print'), ['class' => 'btn btn-default', 'id' => 'btn-select'])
                                    ],
                                    '{export}',
                                    '{toggleData}',
                                ],
//                                'panel' => [
//                                    'type' => 'success',
//                                    'heading' => yii\helpers\Html::encode('สถานะแผนการจัดซื้อยาการค้า'),
//                                    //'before'=>Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success pullleft', 'id' => 'btn-delete']),
//                                    'footer' => false,
//                                    'headingOptions' => ['style' => 'text-align:left'],
//                                ],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn',
                                        'header' => '',
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                    ],
                                    [
                                        'header' => 'เลขที่แผนจัดซื้อ',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PCPlanNum',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รหัสยาการค้า',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'TMTID_TPU',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รายละเอียดยาสามัญ',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemName',
                                        'value' => 'data.ItemName'
                                    ],
                                    [
                                        'header' => 'ราคาต่อหน่วย',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'TPUUnitCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'จำนวน',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'TPUOrderQty',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    //'format'=>['decimal', 2],
                                    //'pageSummary' => true,
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
                                    [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'DispUnit',
                                        'value' => 'data.DispUnit'
                                    //'hAlign' => 'right',
                                    //'format' => ['decimal', 2],
                                    //'pageSummary' => true,
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
                                    [
                                        'header' => 'รวมเป็นเงิน',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'TPUExtendedCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'ขอซื้อแล้ว',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PRApprovedOrderQty',
                                        'hAlign' => 'right',
                                        'value' => 'data.PRApprovedOrderQty',
                                        //'vAlign' => GridView::ALIGN_CENTER,
                                        'width' => '120px',
                                        'format' => ['decimal', 2],
                                    //'format' => ['decimal', 2],
                                    //'pageSummary' => 'รวมเป็นเงินทั้งสิ้น',
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
                                    [
                                        'header' => 'ขอซื้อได้',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PRTPUAvalible',
                                        'value' => 'data.PRTPUAvalible',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    //'format' => ['decimal', 2],
                                    //'pageSummary' => true,
                                    //'pageSummaryFunc' => GridView::F_AVG
                                    ],
//                                        [
//                                            'class' => 'kartik\grid\ActionColumn',
//                                            //'contentOptions' => ['style' => 'width:260px;'],
//                                            'options' => ['style' => 'width:100px;'],
//                                            'header' => 'Actions',
//                                            'hAlign' => GridView::ALIGN_CENTER,
//                                            'headerOptions' => ['style' => 'text-align:center;'],
//                                            'template' => ' {view}',
//                                            'buttonOptions' => ['class' => 'btn btn-default'],
//                                            'buttons' => [
//                                                'view' => function ($url, $model) {
//                                                    return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
//                                                                //'title' => Yii::t('app', 'view'),
//                                                                'id' => 'activity-view-link1',
//                                                                //'role' => 'modal-remote',
//                                                                'title' => 'Select',
//                                                                'data-toggle' => 'modal',
//                                                                'data-target' => '123',
//                                                                //'data-id' => $key,
//                                                                //'data-pjax' => '0',
//                                                    ]);
//                                                },
//                                                    ],
//                                                ],
//            [
//                'class' => 'kartik\grid\FormulaColumn',
//                'header' => '',
//                'mergeHeader' => true,
//                'width' => '150px',
//                'hAlign' => 'right',
//                'pageSummary' => 'บาท'
//            ],
                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    <?php } ?>
                    <?php if ($PlanTypeID3 == '3' or $PlanTypeID4 == '4') { ?>
                        <div id="เวชภัณฑ์ฯ" class="tab-pane">
                            <div style="text-align: right">
                                <button class="btn btn-success save" >Send to PR</button>  
                            </div>
                            <?php Pjax::begin([ 'timeout' => 5000]) ?>
                            <?php
//                        $dataProvider = new ActiveDataProvider([
//                            'query' => \app\modules\Inventory\models\VwNdplanDetailAvalible::find()->where(['ItemID' => $model->ItemID]),
//                            'pagination' => [
//                                'pageSize' => 20,
//                            ],
//                        ]);
                            $searchModel1 = new app\modules\Inventory\models\TbPcplannddetailSearch();
                            $searchModel1->ItemID = $model->ItemID;
                            $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);

                            echo GridView::widget([
                                'dataProvider' => $dataProvider1,
                                //'filterModel' => $searchModel,
                                //'panel' => ['type' => 'info', 'heading' => 'Grid Grouping Example'],
                                'export' => false,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                //'id' =>'grid3',
                                //'showPageSummary' => true,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => "{summary}\n{items}\n{pager}",
                                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'rowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
                                'toolbar' => [
                                    ['content' =>
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success save', 'id' => 'btn-select']) . ' ' .
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-print"></i> Print'), ['class' => 'btn btn-default', 'id' => 'btn-select'])
                                    ],
                                    '{export}',
                                    '{toggleData}',
                                ],
//                                'panel' => [
//                                    'type' => 'success',
//                                    'heading' => yii\helpers\Html::encode('สถานะแผนการจัดซื้อเวชภัณฑ์ฯ'),
//                                    //'before'=>Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success pullleft', 'id' => 'btn-delete']),
//                                    'footer' => false,
//                                    'headingOptions' => ['style' => 'text-align:left'],
//                                ],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn',
                                        'header' => '',
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                    ],
                                    [
                                        'header' => 'เลขที่แผนจัดซื้อ',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PCPlanNum',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รหัสสินค้า',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รายละเอียดสินค้า',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemName',
                                        'value' => 'plantype.ItemName'
                                    ],
                                    [
                                        'header' => 'ราคาต่อหน่วย',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PCPlanNDUnitCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    //'value' => 'plantype.PCPlanNDUnitCost'
                                    ],
                                    [
                                        'header' => 'จำนวน',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PCPlanNDQty',
                                        'hAlign' => 'right',
                                        //'value' => 'plantype.PCPlanNDQty',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'DispUnit',
                                        'value' => 'plantype.DispUnit',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รวมเป็นเงิน',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PCPlanNDExtendedCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    //'value' => 'plantype.PCPlanNDExtendedCost'
                                    ],
                                    [
                                        'header' => 'ขอซื้อแล้ว',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PRApprovedQtySUM',
                                        'hAlign' => 'right',
                                        'value' => 'plantype.PRApprovedQtySUM',
                                        'width' => '120px',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'ขอซื้อได้',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PRNDAvalible',
                                        'hAlign' => 'right',
                                        'value' => 'plantype.PRNDAvalible',
                                        'format' => ['decimal', 2],
                                    ],
                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    <?php } ?>
                    <?php if ($TypeIDTPU == '5') { ?>
                        <div id="ยาสัญญาจะซื้อจะขาย" class="tab-pane">
                            <div style="text-align: right">
                                <button class="btn btn-success pencil" >Send to PR</button>  
                            </div>
                            <?php Pjax::begin([ 'timeout' => 5000]) ?>
                            <?php
//                        $dataProvider = new ActiveDataProvider([
//                            'query' => \app\modules\Inventory\models\VwTpuplanDetailAvalible::find()->where(['ItemID' => $model->ItemID]),
//                            'pagination' => [
//                                'pageSize' => 20,
//                            ],
//                        ]);
                            $searchModel = new app\modules\Inventory\models\TbPcplantpudetailSearch();
                            $searchModel->TMTID_TPU = $model->TMTID_TPU;
                            $dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'id' => 'grid4',
                                //'filterModel' => $searchModel,
                                //'panel' => ['type' => 'info', 'heading' => 'Grid Grouping Example'],
                                'export' => false,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                //'showPageSummary' => true,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => "{summary}\n{items}\n{pager}",
                                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'rowOptions' => function ($model, $key, $index, $grid) {
                            $vwmodel = \app\modules\Inventory\models\TbPrSelectedDetail::findAll([
                                        'PCPlanNum' => $model['PCPlanNum'],
                                        'TMTID_TPU' => $model['TMTID_TPU']
                            ]);
                            if ($vwmodel != null) {
                                return ['class' => 'warning'];
                            }
                        },
                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
                                'toolbar' => [
                                    ['content' =>
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Send to PR'), ['class' => 'btn btn-success pencil', 'id' => 'btn-select']) . ' ' .
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-print"></i> Print'), ['class' => 'btn btn-default', 'id' => 'btn-select'])
                                    ],
                                    '{export}',
                                    '{toggleData}',
                                ],
//                                'panel' => [
//                                    'type' => 'success',
//                                    'heading' => yii\helpers\Html::encode('สถานะแผนการจัดซื้อยาสัญญาจะซื้อจะขาย'),
//                                    //'before'=>Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success pullleft', 'id' => 'btn-delete']),
//                                    'footer' => false,
//                                    'headingOptions' => ['style' => 'text-align:left'],
//                                ],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn',
                                        'header' => '',
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                    ],
                                    [
                                        'header' => 'เลขที่แผนจัดซื้อ',
                                        'attribute' => 'PCPlanNum',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รหัสยาการค้า',
                                        'attribute' => 'TMTID_TPU',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รายละเอียดยาสามัญ',
                                        'attribute' => 'ItemName',
                                        'value' => 'data.ItemName'
                                    ],
                                    [
                                        'header' => 'ราคาต่อหน่วย',
                                        'attribute' => 'TPUUnitCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'จำนวน',
                                        'attribute' => 'TPUOrderQty',
                                        'hAlign' => 'right',
                                    ],
                                    [
                                        'header' => 'หน่วย',
                                        'attribute' => 'DispUnit',
                                        'value' => 'data.DispUnit'
                                    ],
                                    [
                                        'header' => 'รวมเป็นเงิน',
                                        'attribute' => 'TPUExtendedCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'ขอซื้อแล้ว',
                                        'attribute' => 'PRApprovedOrderQty',
                                        'hAlign' => 'right',
                                        'value' => 'data.PRApprovedOrderQty',
                                        'width' => '120px',
                                    ],
                                    [
                                        'header' => 'ขอซื้อได้',
                                        'attribute' => 'PRTPUAvalible',
                                        'hAlign' => 'right',
                                        'value' => 'data.PRTPUAvalible',
                                    ],
//            [
//                'class' => 'kartik\grid\FormulaColumn',
//                'header' => '',
//                'mergeHeader' => true,
//                'width' => '150px',
//                'hAlign' => 'right',
//                'pageSummary' => 'บาท'
//            ],
                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    <?php } ?>
                    <?php if ($PlanTypeID6 == '6') { ?>
                        <div id="เวชภัณฑ์สัญญาจะซื้อจะขาย" class="tab-pane">
                            <div style="text-align: right">
                                <button class="btn btn-success check" >Send to PR</button>  
                            </div>
                            <?php Pjax::begin([ 'timeout' => 5000]) ?>
                            <?php
                            //                        $dataProvider = new ActiveDataProvider([
                            //                            'query' => \app\modules\Inventory\models\VwNdplanDetailAvalible::find()->where(['ItemID' => $model->ItemID]),
                            //                            'pagination' => [
                            //                                'pageSize' => 20,
                            //                            ],
                            //                        ]);
                            $searchModel2 = new app\modules\Inventory\models\TbPcplannddetailSearch();
                            $searchModel2->ItemID = $model->ItemID;
                            $dataProvider = $searchModel2->searchplannd(Yii::$app->request->queryParams);
                            echo GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'id' => 'grid5',
                                //'filterModel' => $searchModel,
                                //'panel' => ['type' => 'info', 'heading' => 'Grid Grouping Example'],
                                'export' => false,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                //'showPageSummary' => true,
                                'responsive' => true,
                                'hover' => true,
                                //'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => "{summary}\n{items}\n{pager}",
                                'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'rowOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary warning'],
                                'toolbar' => [
                                    ['content' =>
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Send to PR'), ['class' => 'btn btn-success check', 'id' => 'btn-select']) . ' ' .
                                        Html::button(Yii::t('app', '<i class="glyphicon glyphicon-print"></i> Print'), ['class' => 'btn btn-default', 'id' => 'btn-select'])
                                    ],
                                    '{export}',
                                    '{toggleData}',
                                ],
//                                'panel' => [
//                                    'type' => 'success',
//                                    'heading' => yii\helpers\Html::encode('สถานะแผนการจัดซื้อเวชภัณฑ์สัญญาจะซื้อจะขาย'),
//                                    //'before'=>Html::button(Yii::t('app', '<i class="glyphicon glyphicon-ok"></i> Select'), ['class' => 'btn btn-success pullleft', 'id' => 'btn-delete']),
//                                    'footer' => false,
//                                    'headingOptions' => ['style' => 'text-align:left'],
//                                ],
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\CheckboxColumn',
                                        'header' => '',
                                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                                    ],
                                    [
                                        'header' => 'เลขที่แผนจัดซื้อ',
                                        'attribute' => 'PCPlanNum',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รหัสยาการค้า',
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => 'รายละเอียดยาสามัญ',
                                        'attribute' => 'ItemName',
                                        'value' => 'plantype.ItemName'
                                    ],
                                    [
                                        'header' => 'ราคาต่อหน่วย',
                                        'attribute' => 'PCPlanNDUnitCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'จำนวน',
                                        'attribute' => 'PCPlanNDQty',
                                        'hAlign' => 'right',
                                    ],
                                    [
                                        'header' => 'หน่วย',
                                        'attribute' => 'DispUnit',
                                        'value' => 'plantype.DispUnit'
                                    ],
                                    [
                                        'header' => 'รวมเป็นเงิน',
                                        'attribute' => 'PCPlanNDExtendedCost',
                                        'hAlign' => 'right',
                                        'format' => ['decimal', 2],
                                    ],
                                    [
                                        'header' => 'ขอซื้อแล้ว',
                                        'attribute' => 'PRApprovedQtySUM',
                                        'hAlign' => 'right',
                                        'value' => 'plantype.PRApprovedQtySUM',
                                        'width' => '120px',
                                    ],
                                    [
                                        'header' => 'ขอซื้อได้',
                                        'attribute' => 'PRNDAvalible',
                                        'value' => 'plantype.PRNDAvalible',
                                        'hAlign' => 'right',
                                    ],
                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
</div>
<br>
<?php if ($checkgpu != null) { ?>
    <script>
        function init_click_handlers() {
            $(".btn-success.edit").click(function (e) {
                var selected = new Array();
                var prtype = "1";
                $("input[type=checkbox]").each(function () {
                    if ($(this).is(":checked"))
                    {
                        selected.push($(this).val());
                    }
                });
                if (selected == "") {
                    Notify("ยังไม่ได้เลือกรายการใด!", "top-right", "2000", "danger", "fa-exclamation", true);
                } else {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.ajax({
                                type: "POST",
                                url: "index.php?r=Inventory/stocks-balance/gendata", // your controller action
                                dataType: "json",
                                data: {keylist: selected, prtype: prtype},
                                success: function (d) {
                                    Notify("ส่งรายการที่เลือกเรียบร้อย!", "top-right", "2000", "success", "fa-check", true);
                                }
                            });
                        }
                    });
                }
            });
        }
        init_click_handlers(); //first run
        $("#detailgpu").on("pjax:success", function () {
            // $.pjax.reload({container});
            init_click_handlers(); //reactivate links in grid after pjax update
        });
    </script>
<?php } ?>
<?php if ($TypeIDTPU == '7' or $TypeIDTPU == '8') { ?>
    <script>
        function init_click_handlers() {
            $(".btn-success.delete").click(function (e) {
                var selected = new Array();
                var prtype = "2";
                $("input[type=checkbox]").each(function () {
                    if ($(this).is(":checked"))
                    {
                        selected.push($(this).val());
                    }
                });
                if (selected == "") {
                    Notify("ยังไม่ได้เลือกรายการใด2!", "top-right", "2000", "danger", "fa-exclamation", true);
                } else {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.ajax({
                                type: "POST",
                                url: "index.php?r=Inventory/stocks-balance/gendata", // your controller action
                                dataType: "json",
                                data: {keylist: selected, prtype: prtype},
                                success: function (d) {
                                    Notify("ส่งรายการที่เลือกเรียบร้อย!", "top-right", "2000", "success", "fa-check", true);
                                }
                            });
                        }
                    });
                }
            });
        }
        init_click_handlers(); //first run
        $("#detailgpu").on("pjax:success", function () {
            // $.pjax.reload({container});
            init_click_handlers(); //reactivate links in grid after pjax update
        });
    </script>
<?php } ?>
<?php if ($PlanTypeID3 == '3' or $PlanTypeID4 == '4') { ?>
    <script>
        function init_click_handlers() {
            $(".btn-success.save").click(function (e) {
                var selected = new Array();
                var prtype = "3";
                $("input[type=checkbox]").each(function () {
                    if ($(this).is(":checked"))
                    {
                        selected.push($(this).val());
                    }
                });
                if (selected == "") {
                    Notify("ยังไม่ได้เลือกรายการใด!", "top-right", "2000", "danger", "fa-exclamation", true);
                } else {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.ajax({
                                type: "POST",
                                url: "index.php?r=Inventory/stocks-balance/gendata", // your controller action
                                dataType: "json",
                                data: {keylist: selected, prtype: prtype},
                                success: function (d) {
                                    Notify("ส่งรายการที่เลือกเรียบร้อย!", "top-right", "2000", "success", "fa-check", true);
                                }
                            });
                        }
                    });
                }
            });
        }
        init_click_handlers(); //first run
        $("#detailgpu").on("pjax:success", function () {
            // $.pjax.reload({container});
            init_click_handlers(); //reactivate links in grid after pjax update
        });
    </script>
<?php } ?>
<?php if ($TypeIDTPU == '5') { ?>
    <script>
        function init_click_handlers() {
            $(".btn-success.pencil").click(function (e) {
                var selected = new Array();
                var prtype = "2";
                $("input[type=checkbox]").each(function () {
                    if ($(this).is(":checked"))
                    {
                        selected.push($(this).val());
                    }
                });
                if (selected == "") {
                    Notify("ยังไม่ได้เลือกรายการใด!", "top-right", "2000", "danger", "fa-exclamation", true);
                } else {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.ajax({
                                type: "POST",
                                url: "index.php?r=Inventory/stocks-balance/gendata", // your controller action
                                dataType: "json",
                                data: {keylist: selected, prtype: prtype},
                                success: function (d) {
                                    Notify("ส่งรายการที่เลือกเรียบร้อย!", "top-right", "2000", "success", "fa-check", true);
                                }
                            });
                        }
                    });
                }
            });
        }
        init_click_handlers(); //first run
        $("#detailgpu").on("pjax:success", function () {
            // $.pjax.reload({container});
            init_click_handlers(); //reactivate links in grid after pjax update
        });
    </script>
<?php } ?>
<?php if ($PlanTypeID6 == '6') { ?>
    <script>
        function init_click_handlers() {
            $(".btn-success.check").click(function (e) {
                var selected = new Array();
                var prtype = "3";
                $("input[type=checkbox]").each(function () {
                    if ($(this).is(":checked"))
                    {
                        selected.push($(this).val());
                    }
                });
                if (selected == "") {
                    Notify("ยังไม่ได้เลือกรายการใด!", "top-right", "2000", "danger", "fa-exclamation", true);
                } else {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.ajax({
                                type: "POST",
                                url: "index.php?r=Inventory/stocks-balance/gendata", // your controller action
                                dataType: "json",
                                data: {keylist: selected, prtype: prtype},
                                success: function (d) {
                                    Notify("ส่งรายการที่เลือกเรียบร้อย!", "top-right", "2000", "success", "fa-check", true);
                                }
                            });
                        }
                    });
                }
            });
        }
        init_click_handlers(); //first run
        $("#detailgpu").on("pjax:success", function () {
            // $.pjax.reload({container});
            init_click_handlers(); //reactivate links in grid after pjax update
        });
    </script>
<?php } ?>
