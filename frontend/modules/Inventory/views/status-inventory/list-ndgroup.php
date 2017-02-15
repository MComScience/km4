
<?php

use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbItemndmedsupply;
$this->registerJs('$("#tab_D").addClass("active");');
$layout = <<< HTML
<div class="pull-right">{toggleData}{export}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
$this->title = 'บัญชีเวชภัณฑ์โรงพยาบาล';
$this->params['breadcrumbs'][] = $this->title;
$title = 'บัญชีเวชภัณฑ์โรงพยาบาล';
$pdfHeader = [
    'L' => [
        'content' => 'รายงาน',
        'font-size' => 8,
        'color' => '#333333'
    ],
    'C' => [
        'content' => $title,
        'font-size' => 30,
        'color' => '#333333'
    ],
    'R' => [
        'content' => 'สร้างเมื่อ' . ': ' . Yii::$app->componentdate->datenow(),
        'font-size' => 8,
        'color' => '#333333'
    ]
];
$pdfFooter = [
    'L' => [
        'content' => 'Print:' . Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') . ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname,
        'font-size' => 8,
        'font-style' => 'B',
        'color' => '#999999'
    ],
    'R' => [
        'content' => '[ {PAGENO} ]',
        'font-size' => 10,
        'font-style' => 'B',
        'font-family' => 'serif',
        'color' => '#333333'
    ],
    'line' => true,
];


?>
<meta charset="utf-8"/>
<div class="vw-stk-balance-item-id-index">

    <div class="vwsr2listdraf-index">
        <?php echo $this->render('_tabnew'); ?> 
        <div class="well">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bootstrap' => true,
                'export' => [
                    'showConfirmAlert' => false,
                    'target' => [GridView::TARGET_SELF],
                ],
                'responsiveWrap' => FALSE,
                'responsive' => true,
                'hover' => true,
                'pjax' => true,
                'striped' => false,
                'condensed' => true,
                'toggleData' => true,
                'layout' => $layout,
                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                //'panel' => ['type' => 'primary', 'heading' => 'Grid Grouping Example'],
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'ItemNDMedSupplyCatID',
                        'header' => '<font color="black">กลุ่มเวชภัณฑ์</font>',
                        'contentOptions' => ['style' => 'text-align:left'],
                        'headerOptions' => ['style' => 'text-align:center'],
                        //  'width' => '310px',
                        'value' => function ($model, $key, $index, $widget) {
                    if ($model->ItemNDMedSupplyCatID == null) {
                        return '-';
                    } else {
                        return $model->ItemNDMedSupply;
                    }
                },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(TbItemndmedsupply::find()->asArray()->all(), 'ItemNDMedSupplyCatID', 'ItemNDMedSupply'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'nonedrug class'],
                        'group' => true, // enable grouping
                    ],
                    [
                        'attribute' => 'ItemID',
                        'header' => '<font color="black">รหัสสินค้า</font>',
                        'hAlign' => 'center',
                        'filter' => false,
                    ],
                    [
                        'attribute' => 'ItemName',
                        'header' => '<font color="black">รายละเอียดสินค้า</font>',
                        'contentOptions' => ['style' => 'text-align:left'],
                        'headerOptions' => ['style' => 'text-align:center'],
                    ],
                  
                    [
                        'contentOptions' => ['style' => 'text-align:right'],
                        'headerOptions' => ['style' => 'text-align:center'],
                        'hAlign' => 'center',
                        'attribute' => 'ItemPrice',
                        'filter' => false,
                        'header' => '<font color="black">ราคา</font>',
                    ],
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
                        'filename' => 'ข้อมูลสินยอดคงคลังสินค้า.pdf',
                        'alertMsg' => false,
                        'options' => ['title' => 'Portable Document Format'],
                        'title' => 'test',
                        'mime' => 'application/pdf',
                        'config' => [
//                                     'mode' => 'c',
                            'format' => 'A4-L',
                            'destination' => 'D',
                            'marginTop' => 20,
                            'marginBottom' => 20,
                            'methods' => [
                                'SetHeader' => [
                                    ['odd' => $pdfHeader, 'even' => $pdfHeader]
                                ],
                                'SetFooter' => [
                                    ['odd' => $pdfFooter, 'even' => $pdfFooter]
                                ],
                            ],
                            'options' => [
                                'title' => $title,
                            // 'subject' => 'PDF export generated by kartik-v/yii2-grid extension',
                            //  'keywords' => 'krajee, grid, export, yii2-grid, pdf'
                            ],
                            'contentBefore' => '',
                            'contentAfter' => ''
                        ]
                    ],
                    GridView::EXCEL => [
                        'label' => 'Excel',
                        'icon' => 'floppy-remove',
                        'iconOptions' => ['class' => 'text-success'],
                        'showHeader' => true,
                        'showPageSummary' => true,
                        'showFooter' => true,
                        'showCaption' => true,
                        'filename' => 'grid-export',
                        'alertMsg' => 'The EXCEL export file will be generated for download.',
                        'options' => ['title' => 'Microsoft Excel 95+'],
                        'mime' => 'application/vnd.ms-excel',
                        'config' => [
                            'worksheet' => 'ExportWorksheet',
                            'cssFile' => ''
                        ]
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
