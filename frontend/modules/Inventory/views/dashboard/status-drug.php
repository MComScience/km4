<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

CrudAsset::register($this);

$layout = <<< HTML
<div class="pull-right">{toolbar}</div>
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
        
        var table = $('#datatables_w1').DataTable();
        $('#min, #max').keyup(function () {
            table.draw();
        });
        $("input[id=ต่ำกว่าReorderPonit]").click(function () {
            if ($(this).is(':checked')) {
                $('#ItemROPDiff').val('0');
                table.draw();
            } else {
                $('#ItemROPDiff').val('');
                table.draw();
            }
        });
        $("input[id=ต่ำกว่าระดับจัดเก็บ]").click(function () {
            if ($(this).is(':checked')) {
                $('#target_stk_diff').val('0');
                table.draw();
            } else {
                $('#target_stk_diff').val('');
                table.draw();
            }
        });
        $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = parseInt($('#target_stk_diff').val(), 10);
                    var max = parseInt($('#ItemROPDiff').val(), 10);
                    var target_stk_diff = parseFloat(data[9].replace(/[,]/g, "")) || 0; // use data for the age column
                    var ItemROPDiff = parseFloat(data[7].replace(/[,]/g, "")) || 0;
                    if (
                            (isNaN(min) && isNaN(max)) ||
                            (target_stk_diff < 0 && isNaN(max)) ||
                            (ItemROPDiff < 0 && isNaN(min))
                            //(min < Item_Cr_Amt && isNaN(max)) ||
                            //(min < Item_Cr_Amt && ItemQtyAvalible < max)
                            )
                    {
                        return true;
                    }
                    return false;
                }
        );
});
JS;
$this->registerJs($script);

$sort = '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="ต่ำกว่าReorderPonit" type="checkbox" /><span class="text"></span> ต่ำกว่า Reorder Ponit</label>'
        . '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'
        . '<label><input id="ต่ำกว่าระดับจัดเก็บ" type="checkbox" /><span class="text"></span> ต่ำกว่าระดับจัดเก็บ</label>';

$btnprint = '<div class="btn-group">
    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100"><i class="glyphicon glyphicon-export"></i><b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li>
            <a href="index.php?r=Inventory/dashboard/export-pdf&type=2" target="_blank" data-pjax="0"><i class="text-danger fa fa-file-pdf-o"></i> PDF</a>
        </li>
        <li>
            <a href="index.php?r=Inventory/dashboard/export-excel&type=2" target="_blank" data-pjax="0"><i class="text-success fa fa-file-excel-o"></i> Excel</a>
        </li>
    </ul>
</div>';

$this->title = 'INVENTORY STATUS';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    table.tb1 tr td{
        text-align: center;
        background-color: white;
        height: 50px;
    }
    table.kv-grid-table thead tr th{
        background-color: white;
    }
    div#ajaxCrudModal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
    .modal-body{
        background-color: #DFF0D8;
    }
</style>
<div class="row">
    <?php echo $this->render('_header_new') ?>

    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_new') ?>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?php Pjax::begin() ?>
                            <?=
                            fedemotta\datatables\DataTables::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'tableOptions' => [
                                    'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                                ],
                                'options' => [
                                    'retrieve' => true
                                ],
                                'clientOptions' => [
                                    'bSortable' => false,
                                    'bAutoWidth' => true,
                                    'ordering' => false,
                                    'pageLength' => 20,
                                    //'bFilter' => false,
                                    'language' => [
                                        'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                        'lengthMenu' => '_MENU_' . ' ' . $btnprint,
                                        'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                        'search' => '_INPUT_' . $sort
                                    ],
                                    "lengthMenu" => [[10, 20, 40, 60, -1], [10, 20, 40, 60, "All"]],
                                    "responsive" => true,
                                    "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                ],
                                'columns' => [
                                        [
                                        'class' => 'yii\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'text-center'],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;'],
                                    ],
                                        [
                                        'header' => 'รหัสสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'ItemID',
                                        'contentOptions' => ['style' => 'text-align:center;'],
                                        'value' => function ($model) {
                                            return empty($model['ItemID']) ? '-' : $model['ItemID'];
                                        }
                                    ],
                                        [
                                        'header' => 'รายละเอียดสินค้า',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'ItemName',
                                        'contentOptions' => ['style' => 'text-align:left;'],
                                        'value' => function ($model) {
                                            return empty($model['ItemName']) ? '-' : $model['ItemName'];
                                        }
                                    ],
                                        [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;'],
                                        'attribute' => 'DispUnit',
                                        'contentOptions' => ['style' => 'text-align:center;'],
                                        'value' => function ($model) {
                                            return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                                        }
                                    ],
                                        [
                                        'header' => 'คงคลัง',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;'],
                                        'attribute' => 'ItemQtyBalance',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                            return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                                        }
                                    ],
                                        [
                                        'header' => 'Reorder Point',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                        'attribute' => 'Reorderpoint',
                                        'format' => ['decimal', 2],
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'options' => ['style' => 'background-color: #d9edf7'],
                                        'value' => function ($model) {
                                            return empty($model['Reorderpoint']) ? '' : $model['Reorderpoint'];
                                        }
                                    ],
                                        [
                                        'header' => 'ส่วนต่าง Rxorder Point',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                                        'attribute' => 'ItemROPDiff',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'options' => ['style' => 'background-color: #d9edf7'],
                                        'value' => function ($model) {
                                            return empty($model['ItemROPDiff']) ? '-' : $model['ItemROPDiff'];
                                        }
                                    ],
                                        [
                                        'header' => 'ระดับการจัดเก็บ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                                        'attribute' => 'ItemTargetLevel',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'options' => ['style' => 'background-color: #fcf8e3'],
                                        'value' => function ($model) {
                                            return empty($model['ItemTargetLevel']) ? '-' : $model['ItemTargetLevel'];
                                        }
                                    ],
                                        [
                                        'header' => 'ส่วนต่างระดับการจัดเก็บ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                                        'attribute' => 'target_stk_diff',
                                        'options' => ['style' => 'background-color: #fcf8e3'],
                                        'format' => ['decimal', 2],
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'value' => function ($model) {
                                            return empty($model['target_stk_diff']) ? '' : $model['target_stk_diff'];
                                        }
                                    ],
                                        [
                                        'header' => 'กำลังขอซื้อ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #dff0d8'],
                                        'attribute' => 'pr_wip',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'options' => ['style' => 'background-color: #dff0d8'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                            return empty($model['pr_wip']) ? '' : $model['pr_wip'];
                                        }
                                    ],
                                        [
                                        'header' => 'รอส่งมอบ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #FF8F32'],
                                        'attribute' => 'po_wip',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'options' => ['style' => 'background-color: #FF8F32'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                            return empty($model['po_wip']) ? '' : $model['po_wip'];
                                        }
                                    ],
                                        [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'template' => '{view}',
                                        'buttons' => [
                                            'view' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', ['details', 'id' => $key], [
                                                            'title' => 'Rx Order',
                                                            'role' => 'modal-remote'
                                                ]);
                                            },
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                            <?php /*
                              echo GridView::widget([
                              'dataProvider' => $dataProvider,
                              //'filterModel' => $searchModel,
                              'responsive' => true,
                              'hover' => true,
                              'layout' => $layout,
                              'pjax' => true,
                              'striped' => false,
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
                              'exportConfig' => [
                              GridView::EXCEL => ['label' => 'EXCEL'],
                              GridView::PDF => [
                              'label' => Yii::t('app', 'PDF'),
                              'iconOptions' => ['class' => 'text-danger'],
                              'options' => ['title' => Yii::t('app', 'Portable Document Format')],
                              'mime' => 'application/pdf',
                              'showHeader' => true,
                              'showPageSummary' => true,
                              'showFooter' => true,
                              'showCaption' => true,
                              'config' => [
                              'mode' => 'UTF-8',
                              'format' => 'A4-L',
                              'destination' => 'D',
                              'methods' => [
                              'SetHeader' => ['InventoryStatus'],
                              'SetFooter' => ['{PAGENO}'],
                              ],
                              'options' => [
                              'title' => 'Report',
                              'defaultheaderline' => 0,
                              'defaultfooterline' => 0,
                              ],
                              ]
                              ],
                              ],
                              'columns' => [
                              [
                              'class' => '\kartik\grid\SerialColumn'
                              ],
                              [
                              'class' => 'kartik\grid\ExpandRowColumn',
                              'value' => function ($model, $key, $index, $column) {
                              return GridView::ROW_COLLAPSED;
                              },
                              'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;'],
                              'expandOneOnly' => true,
                              'detailAnimationDuration' => 'slow', //fast
                              'detailRowCssClass' => GridView::TYPE_SUCCESS,
                              'detailUrl' => Url::to(['ext-pen']),
                              ],
                              [
                              'header' => 'รหัสสินค้า',
                              'headerOptions' => ['style' => 'color:black;text-align:center;'],
                              'attribute' => 'ItemID',
                              'hAlign' => GridView::ALIGN_CENTER,
                              'value' => function ($model) {
                              return empty($model['ItemID']) ? '-' : $model['ItemID'];
                              }
                              ],
                              [
                              'header' => 'รายละเอียดสินค้า',
                              'headerOptions' => ['style' => 'color:black;text-align:center;'],
                              'attribute' => 'ItemName',
                              'hAlign' => GridView::ALIGN_LEFT,
                              'value' => function ($model) {
                              return empty($model['ItemName']) ? '-' : $model['ItemName'];
                              }
                              ],
                              [
                              'header' => 'หน่วย',
                              'headerOptions' => ['style' => 'color:black;text-align:center;'],
                              'attribute' => 'DispUnit',
                              'hAlign' => GridView::ALIGN_CENTER,
                              'value' => function ($model) {
                              return empty($model['DispUnit']) ? '-' : $model['DispUnit'];
                              }
                              ],
                              [
                              'header' => 'คงคลัง',
                              'headerOptions' => ['style' => 'color:black; text-align:center;'],
                              'attribute' => 'ItemQtyBalance',
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'format' => ['decimal', 2],
                              'value' => function ($model) {
                              return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                              }
                              ],
                              [
                              'header' => 'Reorder Point',
                              'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                              'attribute' => 'Reorderpoint',
                              'format' => ['decimal', 2],
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'options' => ['style' => 'background-color: #d9edf7'],
                              'value' => function ($model) {
                              return empty($model['Reorderpoint']) ? '' : $model['Reorderpoint'];
                              }
                              ],
                              [
                              'header' => 'ส่วนต่าง Rxorder Point',
                              'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #d9edf7'],
                              'attribute' => 'ItemROPDiff',
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'options' => ['style' => 'background-color: #d9edf7'],
                              'value' => function ($model) {
                              return empty($model['ItemROPDiff']) ? '-' : $model['ItemROPDiff'];
                              }
                              ],
                              [
                              'header' => 'ระดับการจัดเก็บ',
                              'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                              'attribute' => 'ItemTargetLevel',
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'options' => ['style' => 'background-color: #fcf8e3'],
                              'value' => function ($model) {
                              return empty($model['ItemTargetLevel']) ? '-' : $model['ItemTargetLevel'];
                              }
                              ],
                              [
                              'header' => 'ส่วนต่างระดับการจัดเก็บ',
                              'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #fcf8e3'],
                              'attribute' => 'target_stk_diff',
                              'options' => ['style' => 'background-color: #fcf8e3'],
                              'format' => ['decimal', 2],
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'value' => function ($model) {
                              return empty($model['target_stk_diff']) ? '' : $model['target_stk_diff'];
                              }
                              ],
                              [
                              'header' => 'กำลังขอซื้อ',
                              'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #dff0d8'],
                              'attribute' => 'pr_wip',
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'options' => ['style' => 'background-color: #dff0d8'],
                              'format' => ['decimal', 2],
                              'value' => function ($model) {
                              return empty($model['pr_wip']) ? '' : $model['pr_wip'];
                              }
                              ],
                              [
                              'header' => 'รอส่งมอบ',
                              'headerOptions' => ['style' => 'color:black; text-align:center;background-color: #FF8F32'],
                              'attribute' => 'po_wip',
                              'hAlign' => GridView::ALIGN_RIGHT,
                              'options' => ['style' => 'background-color: #FF8F32'],
                              'format' => ['decimal', 2],
                              'value' => function ($model) {
                              return empty($model['po_wip']) ? '' : $model['po_wip'];
                              }
                              ],
                              ],
                              ]); */
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>
<input type="hidden"  id="target_stk_diff" name="min">
<input type="hidden"  id="ItemROPDiff" name="max">
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => FALSE]
])
?>
<?php Modal::end(); ?>