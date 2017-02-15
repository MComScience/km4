<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

//$_SESSION['section_view'] = $SectionID;
/* @var $this yii\web-\View */
/* @var $searchModel ----app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "ประวัติรายการนำส่งการชำระเงิน";
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('$("#tab_B").addClass("active");');

$layout = <<< HTML
<div class="pull-right">{toggleData}{export}</div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$title = 'รายการนำส่งการชำระเงิน';
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
                <?php Pjax::begin(['id' => 'pjax_history_sc', 'timeout' => 5000]) ?>
                <?php //echo $this->render('_search_send_cash', ['model' => $searchModel,'SectionName'=>$SectionName]); ?>
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
                        'attribute' => 'rep_summary_id',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                        'vAlign' => 'middle',
                        'value' => function ($model) {
                            return (!empty($model->rep_summary_id)? $model->rep_summary_id:'-');
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\Payment\models\VwFiRepSummary::find()->all(), 'rep_summary_id', 'rep_summary_id'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'เลขที่เอกสาร'],
                        ],
                        // [   
                        //     'header' => '<font color="black">วันที่</font>',
                        //     'attribute' => 'rep_summary_date',
                        //     'format' => ['date', 'php:d/m/Y'],
                        //     'attribute' => 'rep_summary_date',
                        //     'value' => function ($model) {
                        //         return (!empty($model->rep_summary_date)? $model->rep_summary_date:'0');
                        //     },
                        //     'filterType' => \yii\jui\DatePicker::widget([
                        //                 'language' => 'th',
                        //                 'dateFormat' => 'dd/MM/yyyy',
                        //                 'clientOptions' => [
                        //                     'changeMonth' => true,
                        //                     'changeYear' => true,
                        //                 ],
                        //                 'options' => [
                        //                     'id'=>'date_search',
                        //                     'name'=> 'VwFiRepSummarySearch[rep_summary_date]',
                        //                     'class' => 'form-control',
                        //                     'style' => 'background-color: white',

                        //                 ],
                        //                 ]),
                        //     //'format' => 'html',
                        // ],
                        [
                            
                            'header' => '<font color="black">วันที่</font>',
                            'attribute' => 'rep_summary_date',
                            'options' => ['style' => 'width:240px;'],
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->rep_summary_date)? $model->rep_summary_date:'');
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
                            'attribute' => 'rep_summary_section',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->SectionDecs)? $model->SectionDecs:'0');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter' => ArrayHelper::map(\app\modules\Payment\models\TbSection::find()->where(['SectionID'=>[2013,2014]])->all(), 'SectionID', 'SectionDecs'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'ประเภท'],
                        ],
                        [   
                            'headerOptions' => ['style' => 'text-align:center;'],
                            'header' => '<font color="black">เป็นเงิน</font>',
                            'format' => ['decimal', 2],
                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                            'filter' => false,
                            'value' => function ($model) {
                                return (!empty($model->rep_summary_sum)? $model->rep_summary_sum:'0');
                            }
                        ],
                        [
                            
                            'header' => '<font color="black">สถานะ</font>',
                            'attribute' => 'rep_summary_status',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->rep_summary_status)? $model->rep_summary_status:'0');
                            },
                            'filterType' => GridView::FILTER_SELECT2,
                            'filter'=>ArrayHelper::map(\app\modules\Payment\models\VwFiRepSummary::find()->all(), 'rep_summary_status', 'rep_summary_status'),
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filterInputOptions' => ['placeholder' => 'สถานะ'],
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'options' => ['style' => 'width:160px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{select} {edit} {delete}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>','#', [
                                                    'title' => Yii::t('app', 'Select'),
                                                    'class' => 'activity-select-link',
                                                    'data-id' => $model->rep_summary_id,
                                            ]);
                                },
                                       'edit' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-info btn-xs">Edit</span>','#', [
                                                    'title' => Yii::t('app', 'Edit'),
                                                    'class' => 'activity-edit-link',
                                                    'data-id' => $model->rep_summary_id,
                                            ]);
                                },
                                    'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs">Delete</span>','#', [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        'class' => 'activity-delete-link',
                                                        'data-id' => $model->rep_summary_id,
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
                                'filename' => 'Report_summary_cash.pdf',
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
                                'filename' => 'Report_summary_cash',
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
    $('#vwfirepsummarysearch-rep_summary_date').on('change', function () {
        var dat_rep = $('#vwfirepsummarysearch-rep_summary_date').val();
        var arr = dat_rep.split('/'); 
        console.log(arr);
        var po_so = 543;
        var rep_day = arr[0];
        var rep_month = arr[1];
        var rep_year = arr[2];
        console.log(rep_day);
        console.log(rep_month);
        console.log(rep_year);
        if(rep_year=='2016'){
            var cv_year = parseInt(rep_year);
            console.log(typeof(po_so));
            console.log(typeof(rep_year));
            var chang_year = cv_year+po_so;
            var date_format = rep_day+"/"+rep_month+"/"+chang_year;
            $('#vwfirepsummarysearch-rep_summary_date').val(date_format);
        }
    });
    $('.activity-select-link').click(function (e) {
        var rep_summary_id = $(this).attr("data-id");
        $.get(
                    'index.php?r=Payment/send-cash/detail-summary',
                    {
                       rep_summary_id
                    },
                    function (data)
                    {   
                        
                    }
            );
        //console.log(rep_summary_id);
        return false;
    });
    $('.activity-edit-link').click(function (e) {
        var rep_summary_id = $(this).attr("data-id");
        alert('click edit');
        console.log(rep_summary_id);
        return false;
    });
    $('.activity-delete-link').click(function (e) {
        var rep_summary_id = $(this).attr("data-id");
        alert('click delete');
        console.log(rep_summary_id);
        return false;
    });   
    }
init_click_handlers(); //first run
$('#pjax_history_sc').on('pjax:success', function () {
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
