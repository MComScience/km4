<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
$this->title = 'ยาการค้า';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'จัดการรายการสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        ข้อมูลรายการสินค้ายา
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tb-item-index">

                        <?php Pjax::begin(['id' => 'tb_item_pjax']); ?> 
                        <?=
                        fedemotta\datatables\DataTables::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'tableOptions' => [
                                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed'
                            ],
                            'clientOptions' => [
                                'bSortable' => false,
                                'bAutoWidth' => true,
                                'ordering' => false,
                                'pageLength' => 10,
                                //'bFilter' => false,
                                'language' => [
                                    'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                    'lengthMenu' => '', //_MENU_
                                    'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                    'search' => '_INPUT_ <a class="btn btn-success" href="create?gpu=&itemid=&edit=yes" data-pjax="0"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการสินค้า</a>'
                                ],
                                "lengthMenu" => [[10, -1], [10, Yii::t('app', "All")]],
                                "responsive" => true,
                                "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                "tableTools" => [
                                    "aButtons" => [
                                        [
                                            "sExtends" => "copy",
                                            "sButtonText" => Yii::t('app', "Copy to clipboard")
                                        ], [
                                            "sExtends" => "csv",
                                            "sButtonText" => Yii::t('app', "Save to CSV")
                                        ], [
                                            "sExtends" => "xls",
                                            "oSelectorOpts" => ["page" => 'current']
                                        ], [
                                            "sExtends" => "pdf",
                                            "sButtonText" => Yii::t('app', "Save to PDF")
                                        ], [
                                            "sExtends" => "print",
                                            "sButtonText" => Yii::t('app', "Print")
                                        ],
                                    ]
                                ]
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;width: 25px;background-color: #DFF0D8'],
                                ],
                                [
                                    'header' => 'รหัสสินค้า',
                                    'attribute' => 'ItemID',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;width: 100px;background-color: #DFF0D8'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'header' => 'รหัสยาการค้า',
                                    'attribute' => 'TMTID_TPU',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;width: 100px;background-color: #DFF0D8'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'header' => 'รหัสยาสามัญ',
                                    'attribute' => 'TMTID_GPU',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;width: 100px;background-color: #DFF0D8'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'header' => 'ชื่อสินค้า',
                                    'attribute' => 'ItemName',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
                                    'value' => function($model) {
                                        return $model['ItemName'];
                                    }
                                ],
                                [
                                    'header' => 'ชื่อยาการค้า',
                                    'attribute' => 'ItemName',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
                                    'value' => function($model) {
                                        return $model['TradeName_TMT'];
                                    }
                                ],
                                //columns
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;width: 210px;background-color: #DFF0D8',],
                                    'header' => 'Actions',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{detail} {edit} {discontinus} {delete}',
                                    'buttons' => [
//                                        'status' => function ($url, $model) {
//                                            if ($model['ItemStatusID'] == 2) {
//                                                return Html::a('A', $url, [
//                                                            'title' => Yii::t('app', 'Detail'),
//                                                            'class' => 'btn btn-default'
//                                                ]);
//                                            } else {
//                                                return '';
//                                            }
//                                        },
                                        /* Edit */
                                        'detail' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-success btn-xs btn-group tooltip-lg"> Detail </span>', $url, [
                                                        'title' => Yii::t('app', 'Detail'),
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'top',
                                                        'data-original-title' => 'detail',
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                        /* Edit */
                                        'edit' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-info btn-xs btn-group"> Edit </span>', $url, [
                                                        'title' => Yii::t('app', 'Edit'),
                                                        'data-pjax' => 0,
                                            ]);
                                        },
                                        'discontinus' => function ($url, $model, $key) {
                                            if ($model['ItemStatusID'] == 2) {
                                                return Html::a('<span class="btn btn-warning btn-xs btn-group tooltip-lg"> Discontinus </span>', '#', [
                                                            'title' => Yii::t('app', 'Discontinus'),
                                                            'class' => 'activity-discontinus',
                                                            'data-toggle' => 'modal',
                                                            'data-id' => $key,
                                                            'data-pjax' => '0',
                                                ]);
                                            } elseif ($model['ItemStatusID'] == 3) {
                                                return Html::a('<span class="btn btn-default btn-xs btn-group tooltip-lg"> UnDiscontinus </span>', '#', [
                                                            'title' => Yii::t('app', 'UnDiscontinus'),
                                                            'class' => 'activity-discontinus',
                                                            'data-toggle' => 'modal',
                                                            'data-id' => $key,
                                                            'data-pjax' => '0',
                                                ]);
                                            }
                                        },
                                        //view button
                                        'delete' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-danger btn-xs btn-group"> Delete </span>', $url, [
                                                        'title' => Yii::t('app', 'Delete'),
                                                        'class' => 'activity-view-delete',
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                        },
                                    ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                                        if ($action === 'detail') {
                                            return Url::to(['createitem', 'itemid' => $key, 'true' => 'view']);
                                        }
                                        if ($action === 'edit') {
                                            return Url::to(['createitem', 'itemid' => $key, 'true' => 'edit']);
                                        }
                                    }
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end(); ?>
                    </div>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 0, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 1000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>
<?php
$script = <<< JS
function init_click_handlers() {
    $(".activity-view-delete").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                "delete",
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#tb_item_pjax'});
                        }
                        );
                    }
                });
    });
    
    $(".activity-discontinus").click(function (e) {
        var fID = $(this).closest("tr").data("key");
        swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                "discontinus",
                                {
                                    ItemID: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#tb_item_pjax'});
                        }
                        );
                    }
                });
    });

}
init_click_handlers(); //first run
$("#tb_item_pjax").on("pjax:success", function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
$this->registerJs($script, \yii\web\View::POS_END, 'additem');
?>
