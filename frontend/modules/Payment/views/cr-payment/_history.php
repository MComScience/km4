<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
$header_style = ['style' => 'text-align:center;color:#000000;'];
echo $this->render('/config/Asset_Js.php');
//$_SESSION['section_view'] = $SectionID;
/* @var $this yii\web-\View */
/* @var $searchModel ----app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "ประวัติการนำส่งใบแจ้งค่าใช้จ่าย";
$this->params['breadcrumbs'][] = $this->title;

$layout = <<< HTML
<div class="pull-right">{toggleData}{export}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$title = 'รายการนำส่งใบแจ้งค่าใช้จ่าย';
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
<!-- <span style="font-size:20px;color:#d73d32;text-align:center;"># <i class="glyphicon glyphicon-wrench" style="color:#d73d32;font-size:25px;"></i>ขออภัย หน้าเว็บไซต์นี้อยู่ระหว่างการปรับปรุง #<br></span> -->
<div class="tabbable" id="wait">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-summary-index">
                <?php Pjax::begin(['id' => 'pjax_history_cr', 'timeout' => 5000]) ?>
                <?=
                GridView::widget([
                    'id' => 'grid-view-exp',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'export' => [
                        'showConfirmAlert' => false,
                        'target' => [GridView::TARGET_SELF],
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
                            'width' => '36px',
                            'header' => 'ลำดับ',
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                        ],
                        [
                        'header' => '<font color="black">เลขที่เอกสาร</font>',
                        'attribute' => 'cr_summary_id',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                        'vAlign' => 'middle',
                        'value' => function ($model) {
                            return (!empty($model->cr_summary_id)? $model->cr_summary_id:'-');
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\Payment\models\VwFiCrSummary::find()->all(), 'cr_summary_id', 'cr_summary_id'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'เลขที่เอกสาร'],
                        ],
                        [
                            
                            'header' => '<font color="black">วันที่</font>',
                            'attribute' => 'cr_summary_date',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->cr_summary_date;
                            },
                            'filterType' => GridView::FILTER_DATE,
                            'filterWidgetOptions' => [
                                        'language' => 'th',
                                        //'format' => 'dd/MM/yyyy',
                                        'pluginOptions' => [
                                            'format' => 'dd/mm/yyyy',
                                            'todayHighlight' => true
                                        ],
                                        ],
                        ],
                        [
                            
                            'header' => '<font color="black">ประเภท</font>',
                            'attribute' => 'cr_summary_pt_visit_type',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->cr_summary_pt_visit_type)? $model->cr_summary_pt_visit_type:'0');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(\app\modules\Payment\models\TbPtVisitType::find()->all(), 'pt_visit_type_code', 'pt_visit_type_desc'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'ประเภท'],
                        ],
                        [   
                            'headerOptions' => ['class'=>'kv-align-middle','style' => 'text-align:center;color:#000000;','rowspan'=>'2'],
                            'filterOptions' => ['style'=>'display:none;'],
                            'header' => '<font color="black">เป็นเงิน</font>',
                            //'attribute' => 'ItemID',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'filter' => false,
                            'value' => function ($model) {
                                return (!empty($model->cr_summary_sum)? $model->cr_summary_sum:'0');
                            }
                        ],
                        [
                            
                            'header' => '<font color="black">สถานะ</font>',
                            'attribute' => 'cr_summary_status',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->cr_summary_status)? $model->cr_summary_status:'0');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter'=>ArrayHelper::map(\app\modules\Payment\models\VwFiCrSummary::find()->all(), 'cr_summary_status', 'cr_summary_status'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'สถานะ'],
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'noWrap' => true,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => $header_style,
                            'template' => '{select} {edit} {delete}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>',false, [
                                                    'title' => Yii::t('app', 'Select'),
                                                    'class' => 'activity-select-link',
                                                    'data-id' => $model->cr_summary_id,
                                            ]);
                                },
                                       'edit' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-info btn-xs">Edit</span>',false, [
                                                    'title' => Yii::t('app', 'Edit'),
                                                    'class' => 'activity-edit-link',
                                                    'data-id' => $model->cr_summary_id,
                                            ]);
                                },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs">Delete</span>',false, [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        'class' => 'activity-delete-link',
                                                        'data-id' => $model->cr_summary_id,
                                                ]);
                                    },
                                        ],
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
                                'filename' => 'report_cr_summary.pdf',
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
                                'filename' => 'cr_summary',
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
                <div class="form-group" style="text-align: right;margin-right: 10px">
                    <?= Html::a('Close', ['history'], ['class' => 'btn btn-default']) ?>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
   function init_click_handlers() {
    $('#vwficrsummarysearch-cr_summary_date').on('change', function () {
        var dat_cr = $('#vwficrsummarysearch-cr_summary_date').val();
        var arr = dat_cr.split('/'); 
        console.log(arr);
        var po_so = 543;
        var cr_day = arr[0];
        var cr_month = arr[1];
        var cr_year = arr[2];
        console.log(cr_day);
        console.log(cr_month);
        console.log(cr_year);
        if(cr_year=='2016'){
            var cv_year = parseInt(cr_year);
            console.log(typeof(po_so));
            console.log(typeof(cr_year));
            var chang_year = cv_year+po_so;
            var date_format = cr_day+"/"+cr_month+"/"+chang_year;
            $('#vwficrsummarysearch-cr_summary_date').val(date_format);
        }
    });
    $('.activity-select-link').click(function (e) {
        var cr_summary_id = $(this).attr("data-id");
        console.log(cr_summary_id);
        $.get(
                    'detail-summary',
                    {
                       cr_summary_id
                    },
                    function (data)
                    {   
                        
                    }
        );
       //console.log(cr_summary_id);
        return false;
    });
    $('.activity-edit-link').click(function (e) {
        var cr_summary_id = $(this).attr("data-id");
        alert('click edit');
        console.log(cr_summary_id);
        return false;
    });
    $('.activity-delete-link').click(function (e) {
        var cr_summary_id = $(this).attr("data-id");
        alert('click delete');
        console.log(cr_summary_id);
        return false;
    });   
    }
init_click_handlers(); //first run
$('#pjax_history_cr').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});

   function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#wait').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                    onClose: function () {}
                });
            }
    }     
JS;
$this->registerJs($script);
?>
