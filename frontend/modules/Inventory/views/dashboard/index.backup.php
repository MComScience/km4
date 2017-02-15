<?php

use kartik\grid\GridView;

$this->registerJs('$("#tab_A").addClass("active");');

$layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<div class="row">
    <div class="col-md-12">
        <div class="profile-container">
            <?= $this->render('header'); ?>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <?= $this->render('_tab'); ?>
                        <div class="tab-content tabs-flat">
                            <div id="tab" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <?php
                                        if (!empty($searchModel)) {
                                            //echo $this->render('_search', ['model' => $searchModel, 'type' => 'index']);
                                            ?>

                                            <div class="form-group">
                                                <?php \yii\widgets\Pjax::begin(['id' => 'dashboard_detail_']) ?>
                                                <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'index']); ?>
                                                <?=
                                                kartik\grid\GridView::widget([
                                                    'dataProvider' => $dataProvider,
                                                    'bootstrap' => true,
                                                    'responsiveWrap' => FALSE,
                                                    'responsive' => true,
                                                    'hover' => true,
                                                    'pjax' => true,
                                                    'striped' => false,
                                                    'condensed' => true,
                                                    'toggleData' => true,
                                                    'layout' => $layout,
                                                    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                                                    'columns' => [
                                                        [
                                                            'class' => 'kartik\grid\SerialColumn',
                                                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                            'width' => '36px',
                                                            'header' => '#',
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                        [
                                                            'class' => 'kartik\grid\ExpandRowColumn',
                                                            'value' => function ($model, $key, $index, $column) {
                                                                return GridView::ROW_COLLAPSED;
                                                            },
                                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black'],
                                                            'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                                            'expandOneOnly' => true,
                                                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                            'detailUrl' => \yii\helpers\Url::to(['ext-pen']), //'index.php?r=Inventory/tb-st2-temp/ext-pen',
                                                        ],
                                                        [
                                                            'header' => 'รหัสสินค้า',
                                                            'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'ItemID',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                        [
                                                            'header' => 'รายละเอียดสินค้า',
                                                           // 'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'ItemName',
                                                            'hAlign' => GridView::ALIGN_LEFT,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black;text-align:center']
                                                        ],
                                                        [
                                                            'header' => 'ยอดคงคลัง',
                                                            'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'ItemQtyBalance',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                        [
                                                            'header' => 'หน่วย',
                                                            'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'DispUnit',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                        [
                                                            'header' => 'ต่ำกว่าจุดสั่งชื้อ',
                                                            'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'ItemROPDiff',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                        [
                                                            'header' => 'กำลังสั่งชื้อ',
                                                            'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'ItemOnPO',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                        [
                                                            'header' => 'PODueDate',
                                                            'headerOptions' => ['style' => 'text-align:center'],
                                                            'attribute' => 'PODueDate',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:black']
                                                        ],
                                                    ],
                                                    'toolbar' => [
                                                        //'{toggleData}',
                                                        '{export}',
                                                    ],
                                                    'export' => [
                                                        'fontAwesome' => true,
                                                        'label' => 'Report',
                                                        'class' => 'btn btn-default',
                                                        'icon' => 'print',
                                                        'showConfirmAlert' => FALSE,
                                                        'header' => '',
                                                        'target' => '_blank',
                                                    ],
                                                    'exportConfig' => [
                                                        GridView::PDF => [
                                                            'label' => 'PDF',
                                                            //'icon' => 'floppy-disk',
                                                            'iconOptions' => ['class' => 'text-danger'],
                                                            'showHeader' => true,
                                                            'showPageSummary' => true,
                                                            'showFooter' => true,
                                                            'showCaption' => true,
                                                            'filename' => 'รายงานยอดคงเหลือสินค้าเวชภัณฑ์',
                                                            'alertMsg' => 'The PDF export file will be generated for download',
                                                            'options' => ['title' => 'Portable Document Format'],
                                                            'mime' => 'application/pdf',
                                                            'config' => [
                                                                'mode' => 'c',
                                                                'format' => 'A4-L',
                                                                'destination' => 'D',
                                                                'marginTop' => 20,
                                                                'marginBottom' => 20,
                                                                'cssInline' => '.kv-wrap{padding:20px;}' .
                                                                '.kv-align-center{text-align:center;}' .
                                                                '.kv-align-left{text-align:left;}' .
                                                                '.kv-align-right{text-align:right;}' .
                                                                '.kv-align-top{vertical-align:top!important;}' .
                                                                '.kv-align-bottom{vertical-align:bottom!important;}' .
                                                                '.kv-align-middle{vertical-align:middle!important;}' .
                                                                '.kv-page-summary{border-top:4px double #ddd;font-weight: bold;}' .
                                                                '.kv-table-footer{border-top:4px double #ddd;font-weight: bold;}' .
                                                                '.kv-table-caption{font-size:1.5em;padding:8px;border:1px solid #ddd;border-bottom:none;}',
                                                                'methods' => [
                                                                    'SetHeader' => [
                                                                        ['odd' => 'xxxxx', 'even' => 'xxx']
                                                                    ],
                                                                    'SetFooter' => [
                                                                        ['|Page {PAGENO}|']
                                                                    // ['odd' => '', 'even' => '']
                                                                    ],
                                                                ],
                                                                'options' => [
                                                                    'title' => 'title',
                                                                    'subject' => 'PDF export generated by kartik-v/yii2-grid extension',
                                                                    'keywords' => 'krajee, grid, export, yii2-grid, pdf'
                                                                ],
                                                                'contentBefore' => date("r"),
                                                                'contentAfter' => ''
                                                            ]
                                                        ],
                                                        GridView::EXCEL => FALSE
                                                    ],
//                                                    'panel' => [
//                                                        'type' => false,
//                                                        'before' => $this->render('_search', ['model' => $searchModel, 'type' => 'index']),
//                                                    // 'footer' => false
//                                                    ],
                                                    'persistResize' => false,
                                                ]);
                                                ?>
                                                <?php \yii\widgets\Pjax::end() ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div id="contacts" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">รายชื่อผู้ป่วยนอก</div>
                                </div>
                            </div>

                            <div id="settings" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">Simple Page</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>