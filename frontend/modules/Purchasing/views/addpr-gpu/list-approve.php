<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\widgets\ActiveForm;

$this->title = 'ใบขอซื้อผ่านการอนุมัติ';
$this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$fullExportMenu = ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'target' => ExportMenu::TARGET_BLANK,
            'fontAwesome' => true,
                //'asDropdown' => false, // this is important for this case so we just need to get a HTML list    
//    'dropdownOptions' => [
//        'label' => '<i class="glyphicon glyphicon-export"></i> Full'
//    ],<div class="pull-right">{toolbar}</div><div class="clearfix"></div><p></p>
        ]);
$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$script = <<< JS
$(document).ready(function () {
        $('#list-approve').addClass("active");
        $('#tab_F').addClass("active");
 });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content">
                <div id="รายการใบขอซื้อ" class="tab-pane in active">
                    <?php Pjax::begin(['timeout' => 5000]) ?>
                    <?php echo $this->render('_search_detail', ['model' => $searchModel, 'action' => 'list-approve']); ?>
                    <p></p>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => false,
                        'condensed' => true,
                        'toggleData' => false,
                        'exportContainer' => ['class' => 'btn-group-sm'],
                        'toolbar' => [
                            '{export}',
                        //'{toggleData}'
                        ],
                        'exportConfig' => [
                            GridView::PDF => [
                                'label' => 'PDF',
                                'iconOptions' => ['class' => 'text-danger'],
                                'showHeader' => true,
                                'showPageSummary' => true,
                                'showFooter' => true,
                                'showCaption' => true,
                                'filename' => 'ใบขอซื้อที่ผ่านการอนุมัติ',
                                'options' => ['title' => 'Portable Document Format'],
                                'config' => [
                                    'mode' => 'c',
                                    'format' => 'A4-L',
                                    'destination' => 'D',
//                                    'marginRight' => 20,
//                                    'marginLeft' => 4,
//                                    'marginTop' => 20,
//                                    'marginBottom' => 20,
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
                                                ['odd' => 'xxx', 'even' => 'xxx']
                                        ],
                                        'SetFooter' => [
                                                ['odd' => 'zzz', 'even' => 'zzz']
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
                            //'mime' => 'application/pdf',
                            ],
                            GridView::CSV => [],
                        ],
                        'export' => [
                            'fontAwesome' => true,
                            'label' => '<b>Reports</b>',
                            'class' => 'btn btn-default',
                            'icon' => 'print',
                            'showConfirmAlert' => FALSE,
                            'header' => '',
                            'stream' => false,
                            'target' => '_blank',
                            'showColumnSelector' => true
                        ],
                        //'summary' => "Showing {begin} - {end} of {totalCount} items",
                        'layout' => $layout,
//                        'layout' => "
//                                <div align='right'>{toolbar}</div>                               
//                                <p></p>{items}\n{summary}\n<div align='center'>{pager}</div>
//                                ",
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'columns' => [
                                [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '#',
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;']
                            ],
                                [
                                'header' => 'เลขที่ใบขอซื้อ',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'PRNum',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'format' => 'raw',
//                                'value' => function ($model, $key, $index, $widget) {
//                                    return Html::a($model->PRNum, '#', []);
//                                },
                            ],
                                [
                                'header' => 'วันที่',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'PRDate',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                                [
                                'header' => 'ประเภทใบขอซื้อ',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'PRTypeID',
                                'value' => 'prtype.PRType',
                                'hAlign' => GridView::ALIGN_CENTER,
//                                        'filterType' => GridView::FILTER_SELECT2,
//                                        'filter' => yii\helpers\ArrayHelper::map(\app\models\TbPrtype::find()->orderBy('PRTypeID')->asArray()->all(), 'PRTypeID', 'PRType'),
//                                        'filterWidgetOptions' => [
//                                            'pluginOptions' => ['allowClear' => true],
//                                        ],
//                                        'filterInputOptions' => ['placeholder' => 'ประเภทใบขอซื้อ'],
                            ],
                                [
                                'header' => 'ประเภทการสั่งซื้อ',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'POTypeID',
                                'value' => 'potype.POType',
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                                [
                                'header' => 'กำหนดเวลาการส่งมอบ',
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'attribute' => 'PRExpectDate',
                                //'format' => 'raw',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function($model) {
                                    return 'ภายใน ' . $model->PRExpectDate . ' วัน';
                                }
                            ],
                                [
                                'class' => 'kartik\grid\ActionColumn',
                                'header' => 'Actions',
                                'noWrap' => true,
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'template' => '{view} {print} {printnew}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    'print' => function ($url, $model, $key) {
                                        /*if ($model->PRTypeID == 1 || $model->PRTypeID == 2 || $model->PRTypeID == 4 || $model->PRTypeID == 6 || $model->PRTypeID == 7) {
                                            $url = 'index.php?r=Report/report-purchasing/pr-approve&data=' . $key;
                                        } else if ($model->PRTypeID == 3 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {
                                            $url = 'index.php?r=Report/report-purchasing/prreportnondrug&PRID=' . $key;
                                        }*/
                                        return Html::a('Print', 'javascript:void(0)', [
                                                    'title' => 'Print',
                                                    //'target' => '_blank',
                                                    'onclick' => 'Print('.$model['PRID'].');',
                                                    'data-pjax' => 0,
                                                    'class' => 'btn btn-info btn-xs btn-group',
                                        ]);
                                    },
                                    'printnew' => function ($url, $model, $key) {
                                        if ($model->PRTypeID == 1 || $model->PRTypeID == 2 || $model->PRTypeID == 4 || $model->PRTypeID == 6 || $model->PRTypeID == 7) {
                                            $url = 'index.php?r=Report/report-purchasing/prreport2&PRID=' . $key;
                                        } else if ($model->PRTypeID == 3 || $model->PRTypeID == 5 || $model->PRTypeID == 8) {
                                            $url = 'index.php?r=Report/report-purchasing/prreportnondrug2&PRID=' . $key;
                                        }
                                        return Html::a('<span class="btn btn-info btn-xs btn-group"> Print New</span>', $url, [
                                                    'title' => 'print',
                                                    'target' => '_blank',
                                                    'data-pjax' => 0
                                        ]);
                                    },
                                    //view button
                                    'view' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-success btn-xs btn-group"> Select </span>', $url, [
                                                    'title' => 'view',
                                                    'data-pjax' => 0,
                                        ]);
                                    },
                                ],
                                'urlCreator' => function ($action, $model, $key, $index) {
                                    if ($model->PRTypeID == 1 || $model->PRTypeID == 6) {//ยาสามัญ
                                        if ($action === 'view') {
                                            return Url::to(['update-detail-approve', 'id' => $key, 'view' => 'approve']);
                                        }
                                    } elseif ($model->PRTypeID == 2 || $model->PRTypeID == 7) {//ยาการค้า
                                        if ($action === 'view') {
                                            return Url::to(['addpr-tpu/update-detail-approve', 'id' => $key, 'view' => 'approve']);
                                        }
                                    } elseif ($model->PRTypeID == 3 || $model->PRTypeID == 8) {//เวชภัณฑ์
                                        if ($action === 'view') {
                                            return Url::to(['addpr-nd/update-detail-approve', 'id' => $key, 'view' => 'approve']);
                                        }
                                    } elseif ($model->PRTypeID == 4) {
                                        if ($action === 'view') {
                                            return Url::to(['addpr-tpu-cont/update-detail-approve', 'id' => $key, 'view' => 'approve']);
                                        }
                                    } elseif ($model->PRTypeID == 5) {
                                        if ($action === 'view') {
                                            return Url::to(['addpr-nd-cont/update-detail-approve', 'id' => $key, 'view' => 'approve']);
                                        }
                                    }
                                }
                            ],
                        ],
                    ]);
                    ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-space"></div>
</div>
<script type="text/javascript">
        function Print(PRID) {
            //event.preventDefault();
            var myWindow = window.open("/km4/Report/report-purchasing/pr-approve?data=" + PRID, "", "top=100,left=auto,width="+ screen.width +",height=550");
            myWindow.window.print();
        }
</script>

