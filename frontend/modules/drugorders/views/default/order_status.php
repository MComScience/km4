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
?>
<style>
    table#datatables_w1 thead tr th{
        background-color: #DFF0D8;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab'); ?>
            <div class="tab-content">
                <div id="tabB" class="tab-pane in active">
                    <p>
                        <?php Html::a('Create Vwptservicelistop', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?php Pjax::begin(); ?>    
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
                            ],
                            [
                                'attribute' => 'cpoe_order_by',
                                'header' => 'แพทย์',
                                'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'value' => function ($model) {
                            return empty($model->cpoe_order_by) ? '-' : $model->cpoe_order_by;
                        }
                            ],
                            [
                                'attribute' => 'SectionDecs',
                                'header' => 'แผนก',
                                'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'value' => function ($model) {
                            return empty($model->SectionDecs) ? '-' : $model->SectionDecs;
                        }
                            ],
                            [
                                'attribute' => 'cpoe_status',
                                'header' => 'สถานะใบสั่งยา',
                                'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                'value' => function ($model) {
                            return empty($model->cpoe_status) ? '-' : $model->cpoe_status;
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
                                        return Html::a('<span class="btn btn-info btn-xs"> Edit </span>', Url::to(['/cpoes/drugorder/index', 'id' => $key]), [
                                                    'title' => 'Edit',
                                        ]);
                                    },
                                            'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span>', '#', [
                                                    'title' => 'Delete',
                                        ]);
                                    },
                                        ]
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end(); ?>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>

