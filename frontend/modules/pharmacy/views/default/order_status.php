<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use fedemotta\datatables\DataTables;

$this->title = 'สถานะใบสั่งยา';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
    $(document).ready(function () {
        $('#tabB').addClass("active");
    });
JS;
$this->registerJs($script);

$script1 = <<< JS
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=chemos/rxorder/delete',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#cpoeindex-pjax'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#cpoeindex-pjax').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});        
JS;
$this->registerJs($script1);
?>
<style>
    table#datatables_w0 thead tr th{
        background-color: white;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab'); ?>
            <div class="tab-content">
                <div id="tabB" class="tab-pane in active">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-xs-12">
                            <?php Pjax::begin(['id' => 'cpoeindex-pjax']); ?>    
                            <?=
                            DataTables::widget([
                                'dataProvider' => $dataProvider,
                                'tableOptions' => [
                                    'class' => 'default kv-grid-table table table-hover table-bordered table-striped table-condensed',
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
                                        'lengthMenu' => '_MENU_',
                                        'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                        'search' => '_INPUT_'
                                    ],
                                    "lengthMenu" => [[10, -1], [10, "All"]],
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
                                        'attribute' => 'cpoe_num',
                                        'header' => 'เลขที่ใบสั่งยา',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                    return empty($model->cpoe_num) ? '-' : $model->cpoe_num;
                                }
                                    ],
                                    [
                                        'attribute' => 'HNVN',
                                        'header' => 'HN:VN',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                    return empty($model->HNVN) ? '-' : $model->HNVN;
                                }
                                    ],
                                    [
                                        'attribute' => 'pt_name',
                                        'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                    return empty($model->pt_name) ? '-' : $model->pt_name;
                                }
                                    ],
                                    [
                                        'attribute' => 'pt_age_registry_date',
                                        'header' => 'อายุ',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                    return empty($model->pt_age_registry_date) ? '-' : $model->pt_age_registry_date . ' ปี';
                                }
                                    ],
                                    [
                                        'attribute' => 'cpoe_order_by',
                                        'header' => 'แพทย์',
                                        'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                    return empty($model->User_name) ? '-' : $model->User_name;
                                }
                                    ],
                                    [
                                        'attribute' => 'cpoe_status',
                                        'header' => 'สถานะใบสั่งยา',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'value' => function ($model) {
                                    return empty($model->cpoe_status_decs) ? '-' : $model->cpoe_status_decs;
                                }
                                    ],
                                    [
                                        'class' => 'yii\grid\ActionColumn',
                                        'header' => 'Actions',
                                        'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                        'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                        'template' => '{update} {delete} ',
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                if ($model['drugset_id'] != null) {
                                                    return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', Url::to(['/pharmacy/rxorder/create', 'data' => $key, 'vn' => $model['pt_vn_number']]), [
                                                                'title' => 'Edit',
                                                                'data-pjax' => 0,
                                                    ]);
                                                } else {
                                                    return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', Url::to(['/pharmacy/order/index', 'id' => $key]), [
                                                                'title' => 'Edit',
                                                                'data-pjax' => 0,
                                                    ]);
                                                }
                                            },
                                                    'delete' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                            'title' => 'Delete',
                                                            'data-toggle' => 'modal',
                                                            'class' => 'activity-delete-link',
                                                ]);
                                            },
                                                ]
                                            ],
                                        ],
                                    ]);
                                    ?>
                                    <?php Pjax::end(); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-6 col-xs-12">

                                    <p>
                                        <?= Html::a('Close', ['/'], ['class' => 'btn btn-default pull-right', 'data-dismiss' => 'modal']) ?>
                            </p>

                        </div>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>

