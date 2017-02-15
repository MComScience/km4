<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\controllers\VwStkrefillStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการเติมสินค้าตามระดับจัดเก็บ';
$this->params['breadcrumbs'][] = $this->title;
$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$title = 'รายการเติมสินค้าตามระดับจัดเก็บ';
$pdfHeader = [
    'L' => [
        'content' => '',
        'font-size' => 20,
        'color' => '#333333'
    ],
    'C' => [
        'content' => $title,
        'font-size' => 20,
        'color' => '#333333'
    ],
    'R' => [
        'content' => /*'',*/'สร้างเมื่อ' . ': ' . Yii::$app->componentdate->datenow(),
        'font-size' => 10,
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
<div class="well">
    <div class="vw-stkrefill-status-index">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php Pjax::begin(['id' => 'refill_status', 'timeout' => 5000]) ?>
        <?= GridView::widget([

            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'export' => [
                                    'fontAwesome' => true,
                                    //'label' => '<b>Reports</b>',
                                    'class' => 'btn btn-default',
                                    'icon' => 'print',
                                    'showConfirmAlert' => FALSE,
                                    'header' => '',
                                    'stream' => false,
                                    'target' => '_blank',
                                    'showColumnSelector' => true
                                ],
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
            'showPageSummary' => false,
            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
            'columns' => [
                [
                    'class' => 'kartik\grid\SerialColumn',
                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                    'width' => '3.20%',
                    'header' => '#',
                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                ],
                [
                'header' => '<font color="black"><center>คลัง</center></font>',
                'attribute' => 'StkName',
                'hAlign' => kartik\grid\GridView::ALIGN_LEFT,
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return (!empty($model->StkName)? $model->StkName:'-');
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(\app\modules\Inventory\models\VwStkrefillStatus::find()->all(), 'StkName', 'StkName'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'คลัง'],
                ],

                [
                'header' => '<font color="black"><center>ประเภทเวชภัณฑ์</center></font>',
                'attribute' => 'ItemNDMedSupply',
                'hAlign' => kartik\grid\GridView::ALIGN_LEFT,
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return (!empty($model->ItemNDMedSupply)? $model->ItemNDMedSupply:'-');
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => ArrayHelper::map(\app\modules\Inventory\models\VwStkrefillStatus::find()->all(), 'ItemNDMedSupply', 'ItemNDMedSupply'),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'ประเภทเวชภัณฑ์'],
                ],

                [
                'header' => '<font color="black">รหัสสินค้า</font>',
                'attribute' => 'ItemID',
                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return (!empty($model->ItemID)? $model->ItemID:'-');
                 },
                ],

                [
                'header' => '<font color="black"><center>รายละเอียดสินค้า</center></font>',
                'attribute' => 'ItemName',
                'hAlign' => kartik\grid\GridView::ALIGN_LEFT,
                'vAlign' => 'middle',
                'value' => function ($model) {
                    return (!empty($model->ItemName)? $model->ItemName:'-');
                 },
                ],


                [
                    'mergeHeader'=>true,
                    'header' => '<font color="black"><center>หน่วย</center></font>',
                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    'width' => '7.79%',
                    'attribute' => 'DispUnit',
                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                ],

                [   
                     'mergeHeader'=>true,
                    'header' => '<font color="black"><center>คงคลัง</center></font>',
                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                    'width' => '7.79%',
                    'attribute' => 'ItemQtyBalance',
                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                ],

                [
                    'mergeHeader'=>true,
                    'header' => '<font color="black"><center>ระดับ<p>การจัดเก็บ</center></p></font>',
                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                    'width' => '7.79%',
                    'attribute' => 'ItemTargetLevel',
                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;background-color:rgb(217, 237, 247);'],
                    'options' => ['style' =>'background-color:rgb(217, 237, 247);'],
                ],

                [
                    'mergeHeader'=>true,
                    'header' => '<font color="black"><center>ส่วนต่าง<p>ระดับการจัดเก็บ</center></p></font>',
                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                    'width' => '7.79%',
                    'attribute' => 'target_stk_diff',
                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;background-color:rgb(252, 248, 227);'],
                    'options' => ['style' =>'background-color:rgb(252, 248, 227);'],
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
                        'filename' => 'Refill_Status.pdf',
                        'alertMsg' => false,
                        'options' => ['title' => 'Portable Document Format'],
                        'title' => 'test',
                        'mime' => 'application/pdf',
                        'config' => [
    //                                     'mode' => 'c',
                            'format' => 'A4-L',
                            'destination' => 'D',
                            'marginTop' => 25,
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
                                'subject' => 'PDF export generated by kartik-v/yii2-grid extension',
                                'keywords' => 'krajee, grid, export, yii2-grid, pdf'
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
                        'filename' => 'Refill_Status',
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
        <?php yii\widgets\Pjax::end() ?>
            <div class="form-group" style="text-align: right">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=Inventory/dashboard/index" class="btn btn-default">Close</a>
            </div> 
    </div>
</div>
