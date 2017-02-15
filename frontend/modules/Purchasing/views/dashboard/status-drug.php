<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

CrudAsset::register($this);

$script = <<< JS
$(document).ready(function () {
        $('li.TabB').addClass("active");
});
JS;
$this->registerJs($script);


$btnprint = '<div class="btn-group">
    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="100"><i class="glyphicon glyphicon-export"></i><b class="caret"></b></a>
    <ul class="dropdown-menu">
        <li>
            <a href="index.php?r=Purchasing/dashboard/export-pdf&type=2" target="_blank" data-pjax="0"><i class="text-danger fa fa-file-pdf-o"></i> PDF</a>
        </li>
        <li>
            <a href="index.php?r=Purchasing/dashboard/export-excel&type=2" target="_blank" data-pjax="0"><i class="text-success fa fa-file-excel-o"></i> Excel</a>
        </li>
    </ul>
</div>';

$this->title = 'PURCHASING PLAN STATUS';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
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
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_new'); ?>
            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <?php Pjax::begin(); ?>
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
                                    'pageLength' => 10,
                                    //'bFilter' => false,
                                    'language' => [
                                        'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                        'lengthMenu' => '_MENU_' . ' ' . $btnprint,
                                        'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                        'search' => '_INPUT_',
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
                                        'headerOptions' => ['style' => 'color:black;text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'ItemID',
                                        'contentOptions' => ['style' => 'text-align:center;',],
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
                                        'header' => 'ยอดคงคลัง',
                                        'headerOptions' => ['style' => 'color:black;text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'ItemQtyBalance',
                                        'format' => ['decimal', 2],
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'value' => function ($model) {
                                            return empty($model['ItemQtyBalance']) ? '' : $model['ItemQtyBalance'];
                                        }
                                    ],
                                        [
                                        'header' => 'หน่วย',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'DispUnit',
                                        'contentOptions' => ['style' => 'text-align:center;'],
                                        'value' => function ($model) {
                                            return empty($model['DispUnit']) ? '' : $model['DispUnit'];
                                        }
                                    ],
                                        [
                                        'header' => 'ต่ำกว่าจุดสั่งชื้อ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'ItemROPDiff',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'format' => ['decimal', 2],
                                        'value' => function ($model) {
                                            return empty($model['ItemROPDiff']) ? '' : $model['ItemROPDiff'];
                                        }
                                    ],
                                        [
                                        'header' => 'กำลังสั่งชื้อ',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'ItemOnPO',
                                        'format' => ['decimal', 2],
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'value' => function ($model) {
                                            return empty($model['ItemOnPO']) ? '' : $model['ItemOnPO'];
                                        }
                                    ],
                                        [
                                        'header' => 'DueDate',
                                        'headerOptions' => ['style' => 'color:black; text-align:center;', 'noWrap' => true,],
                                        'attribute' => 'PODueDate',
                                        'contentOptions' => ['style' => 'text-align:right;'],
                                        'value' => function ($model) {
                                            return empty($model['PODueDate']) ? '-' : $model['PODueDate'];
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
                                                return Html::a('<span class="btn btn-success btn-xs"> Detail </span>', ['details-drug', 'id' => $key], [
                                                            'title' => 'Rx Order',
                                                            'role' => 'modal-remote'
                                                ]);
                                            },
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end(); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: right;">
                            <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
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