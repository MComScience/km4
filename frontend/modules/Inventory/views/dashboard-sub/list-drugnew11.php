<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Inventory\models\VwStkBalanceItemIDSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerJs('$("#tab_A").addClass("active");');
$this->title = 'สถานะสินค้าคงคลัง';
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

$title = 'รายการสินค้าคงคลัง';
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
        <?php echo $this->render('_tabnew', ['model' => $searchModel, 'action' => 'list-drugnew']); ?>  
        <div class="well">
            <?php yii\widgets\Pjax::begin(['id' => 'grid-user-pjax', 'timeout' => 5000]) ?>
            <?php // echo $this->render('_search', ['model' => $searchModel, 'action' => 'list-drugnew']); ?>  
            <?php
            echo
            GridView::widget([
                'id' => 'grid-id',
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
              'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                        'width' => '36px',
                        'header' => '<font color="black">#</font>',
                        'headerOptions' => ['class' => 'kartik-sheet-style'],
                    ],
                    [
                        'width'=>'15%',
                        'header' => '<font color="black">คลังสินค้า</font>',
                        'attribute' => 'StkID',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                        'vAlign' => 'middle',
                        'value' => function ($model) {
                            return $model->StkName;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\Inventory\models\Tbstk::find()->all(), 'StkID', 'StkName'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => 'เลือกคลัง'],
                    ],
                    [
                        'header' => '<font color="black">รหัสสินค้า</font>',
                        'attribute' => 'ItemID',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    ],
                    [
                        'header' => '<font color="black"><span text-align:center>รายละเอียดสินค้า</span></font>',
                        'attribute' => 'ItemName',
                    ],
                    [
                        'header' => '<font color="black">ยอดคงคลัง</font>',
                        'attribute' => 'ItemQtyBalance',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                        'filter' => false
                    ],
                    [
                        'header' => '<font color="black">หน่วย</font>',
                        'attribute' => 'DispUnit',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                        'filter' => false
                    ],
                //     [
                //         'header' => '<font color="black">จุดสั่งชื้อ</font>',
                //         'attribute' => 'Reorderpoint',
                //         'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                //         'filter' => false
                //     ],
                    [

                        'attribute' => 'DispUnit',
                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                        'options' => ['style' => 'display: none'],
                        'contentOptions' => ['style' => 'display: none'],
                        'filterOptions' => ['style' => 'display: none'],
                        'headerOptions' => ['style' => 'display: none'],
                        'value' => function ($model) {
                            return $model->StkID;
                        },
                    ],
                    // [
                    //     'header' => '<font color="black">ต่ำกว่าจุดสั่งชื้อ</font>',
                    //     'attribute' => 'ItemROPDiff',
                    //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                    //     'filter' => false
                    // ],
                    // [
                    //      'width'=>'12%',
                    //     'header' => '<font color="black">ต่ำกว่าจุดสั่งชื้อ</font>',
                    //     'class' => 'kartik\grid\BooleanColumn',
                    //     'attribute' => 'ROPStatus',
                    //     'vAlign' => 'middle',
                    //     'trueLabel' => 'ไม่ต่ำกว่าจุดสั่งชื้อ',
                    //     'falseLabel' => 'ต่ำกว่าจุดสั่งชื้อ'
                    // ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => '<font color="black">Actions</font>',
                        'options' => ['style' => 'width:160px;'],
                        'width' => '200px',
                        'template' => '{stockcard}',
                        'buttonOptions' => ['class' => 'btn btn-default'],
                        'buttons' => [
                            'stockcard' => function ($url, $model, $key) {
                                return Html::a('<span class="btn btn-success btn-xs"> Stock Card </span>', '#', [
                                            'title' => 'stockcard',
                                            'data-toggle' => 'modal',
                                            'data-id' => $key,
                                            'class' => 'activity-stockcard-link',
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


                    <?php yii\widgets\Pjax::end() ?>
                    <div class="form-group" style="text-align: right">
                        <a href="<?php echo Yii::$app->request->baseUrl; ?>/index.php?r=" class="btn btn-default">Close</a>
                    </div>
                </div>
            </div>

            <script>
                function  selectdetail(itemid, stkid) {
                    $.ajax({
                        url: 'index.php?r=Inventory/dashboard/view-stockcard',
                        type: 'POST',
                        data: {itemid: itemid, stkid: stkid},
                        dataType: 'json',
                        success: function (data) {
                            $('#_result').html(data.html);
                            $('#itemid').html(data.itemid);
                            $('#itemname').html(data.itemname);
                            $('#tpu_sr2_detail_list').modal('show');
                            $('#data_tpu').DataTable({
                                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                "pageLength": 10,
                                responsive: true,
                                "language": {
                                    "lengthMenu": " _MENU_ ",
                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                    "search": "ค้นหา "
                                },
                                "aLengthMenu": [
                                    [5, 10, 15, 20, 100, -1],
                                    [5, 10, 15, 20, 100, "All"]
                                ]
                            });
                        }
                    });
                }
            </script>
            <?php
            Modal::begin([
                'id' => 'tpu_sr2_detail_list',
                'header' => '<h4 class="modal-title">Stock Card</h4>',
                'size' => 'modal-lg modal-primary',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                'closeButton' => FALSE,
                'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
            ]);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-sm-8">รหัสสินค้า:  <span id="itemid"></span></label>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="control-label col-sm-8" >ชื่อสินค้า:  <span id="itemname"></span></label> 
                    </div>
                </div>
            </div>
            <br>
            <div id="_result"></div>
            <?php Modal::end(); ?>
            <?php
            $script = <<< JS

function Waitme (){
    $('.page-content').waitMe({
        effect: 'ios', //roundBounce
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}
    $('#vwstkbalanceitemidsearch-stkid').on('change', function () {
        Waitme();
    });
    $('.form-control').keyup(function(e){
        if(e.keyCode == 13)
        {
            Waitme();
        }
    });
    
function init_click_handlers() {
    $('.activity-stockcard-link').click(function (e) {
       var stkid = $(this).closest('tr').children('td:eq(6)').text();
       var itemid = $(this).closest('tr').children('td:eq(2)').text();
              $.post(
                        'index.php?r=Inventory/dashboard-sub/view-stockcard',
                        {
                            itemid: itemid, stkid: stkid
                        },
                function (data)
                {
                     $('#_result').html(data.html);
                            $('#itemid').html(data.itemid);
                            $('#itemname').html(data.itemname);
                            $('#tpu_sr2_detail_list').modal('show');
                            $('#data_tpu').DataTable({
                                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                "pageLength": 10,
                                responsive: true,
                                "language": {
                                    "lengthMenu": " _MENU_ ",
                                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                    "search": "ค้นหา "
                                },
                                "aLengthMenu": [
                                    [5, 10, 15, 20, 100, -1],
                                    [5, 10, 15, 20, 100, "All"]
                                ]
                            });
                },
                'json'
             );
         });
  
}
init_click_handlers(); //first run
$('#grid-user-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
            $this->registerJs($script);
            ?>
