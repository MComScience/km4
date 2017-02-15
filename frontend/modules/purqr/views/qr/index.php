<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use fedemotta\datatables\DataTables;
use yii\helpers\Url;

$this->title = 'สถานะใบสืบราคาสินค้า';
$this->params['breadcrumbs'][] = $this->title;
$btn = Html::a('<i class="glyphicon glyphicon-plus"></i>สร้างใบสืบราคา', ['createheader'], ['class' => 'btn btn-success']);

$script = <<< JS
$("#tab_B").click(function (e) {               
    window.location.replace("/km4/purqr/qr/index");
});
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active" id="tab_B">
                    <a data-toggle="tab" href="#home">
                        สถานะใบสืบราคาสินค้า
                    </a>
                </li>

                <li class="tab-red">
                    <a data-toggle="tab" href="#profile">
                        ใบสืบราคาสินค้า
                    </a>
                </li>
            </ul>


            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tbqr2-index">

                        <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

                        <p>
                        </p>
                        <?php Pjax::begin(['id' => 'pjax-index']); ?>    
                        <?=
                        DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => [
                                'class' => 'table table-bordered table-striped table-condensed flip-content table-hover',
                                'width' => '100%'
                            ],
                            'clientOptions' => [
                                'bSortable' => false,
                                'bAutoWidth' => true,
                                'ordering' => false,
                                'pageLength' => 10,
                                //'bFilter' => false
                                'language' => [
                                    'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                    'lengthMenu' => '_MENU_',
                                    //'sSearchPlaceholder' => 'ค้นหาข้อมูล....',
                                    'search' => '_INPUT_' . ' ' . $btn
                                ],
                                "lengthMenu" => [[10, -1], [10, "All"]],
                                "responsive" => true,
                                "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                ],
                                [
                                    'attribute' => 'QRNum',
                                    'header' => 'เลขที่ใบสืบราคา',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'attribute' => 'QRDate',
                                    'header' => 'วันที่',
                                    'format' => ['date', 'php:d/m/Y'],
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'attribute' => 'ItemDetail',
                                    'header' => 'รายละเอียด',
                                    'contentOptions' => ['class' => 'text-left',],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'attribute' => 'QRStatus',
                                    'header' => 'สถานะ',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Action',
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'template' => '{view} {update} {delete}',
                                    'buttons' => [
                                        //view button
                                        'view' => function ($key,$model) {
                                            $url = ['view', 'id' => $model['QRID']];
                                            return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
                                                        'title' => Yii::t('app', 'view'),
                                            ]);
                                        },
                                                'update' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                            //'class' => 'btn btn-primary btn-xs',
                                            ]);
                                        },
                                                'delete' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        'data-toggle' => 'modal',
                                                        'class' => 'activity-delete-link',
                                            ]);
                                        },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'view' || $action === 'update') {
                                            return Url::to(['create', 'id' => $key]);
                                        }
                                    }
                                        ],
                                    ],
                                ]);
                                ?>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>

            </div>
        </div>
        <?php Pjax::end(); ?>
        <?php
        $script = <<< JS
function init_click_handlers() {
        $('.activity-delete-link').click(function (e) {
            var fID = $(this).closest('tr').data('key');
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'index.php?r=purqr/qr/delete-qr',
                                    {
                                        id: fID
                                    },
                                    function (data)
                                    {
                                        Gettable2();
                                    }
                            );
                        }
                    });
        });
    }
    init_click_handlers(); //first run
    $('#pjax-index').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
JS;
        $this->registerJs($script);
        ?>