<?php

use kartik\grid\GridView;
use kartik\helpers\Html;

$this->registerJs('$("#tab_B").addClass("active");');
$layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$script = <<< JS
$(document).ready(function () {
        $('li.TabB').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_new'); ?>
            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <?php if (!empty($searchModel)) { ?>   
                            <?php \yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]); ?>
                            <?php echo $this->render('_search', ['model' => $searchModel, 'type' => 'status-drug']); ?>
                            <?php
                            echo GridView::widget([
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
                                        'header' => '<font color="black">#</font>',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\ExpandRowColumn',
                                        'value' => function ($model, $key, $index, $column) {
                                            return GridView::ROW_COLLAPSED;
                                        },
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;background-color: #ddd'],
                                        'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                        'expandOneOnly' => true,
                                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                        'detailUrl' => \yii\helpers\Url::to(['ext-pen']), //'index.php?r=Inventory/tb-st2-temp/ext-pen',
                                    ],
                                    [
                                        'header' => '<font color="black">รหัสสินค้า</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => '<font color="black">รายละเอียดสินค้า</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemName',
                                    // 'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => '<font color="black">ยอดคงคลัง</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemQtyBalance',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => '<font color="black">หน่วย</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'DispUnit',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->DispUnit == NULL) {
                                        return '-';
                                    } else {
                                        return $model->DispUnit;
                                    }
                                },
                                    ],
                                    [
                                        'header' => '<font color="black">ต่ำกว่าจุดสั่งชื้อ</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemROPDiff',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => '<font color="black">กำลังสั่งชื้อ</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemOnPO',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => '<font color="black">DueDate</font>',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'PODueDate',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                ],
//                                                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
//                                                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//                                                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//                                                'pjax' => true, // pjax is set to always true for this demo
                                // set your toolbar
                                'toolbar' => [
                                    //'{toggleData}',
                                    '{export}',
                                ],
                                // set export properties
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
                                        'icon' => 'floppy-disk',
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
//                                                'panel' => [
//                                                    'type' => false,
//                                                    'before' => $this->render('_search', ['model' => $searchModel, 'type' => 'status-drug']),
//                                                //  'footer' => false
//                                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php \yii\widgets\Pjax::end() ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>