<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use fedemotta\datatables\DataTables;

$this->title = 'รายชื่อผู้ป่วยนอก';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tabA').addClass("active");
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
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab'); ?>
            <div class="tab-content">
                <div id="tabA" class="tab-pane in active">
                    <div class="vwptservicelistop-index">
                        <p>
                            <?php Html::a('Create Vwptservicelistop', ['create'], ['class' => 'btn btn-success']) ?>
                        </p>
                        <?php Pjax::begin(); ?>    
                        <?php // $this->render('_search', ['model' => $searchModel]); ?>
                        <?=
                        DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'class' => 'table table-hover table-bordered table-striped table-condensed',
                                'width' => '100%',
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
                                /*
                                  [
                                  'class' => 'kartik\grid\ExpandRowColumn',
                                  'value' => function ($model, $key, $index, $column) {
                                  return GridView::ROW_COLLAPSED;
                                  },
                                  'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
                                  'expandOneOnly' => true,
                                  'detailAnimationDuration' => 'slow', //fast
                                  'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                  'detailUrl' => Url::to(['details']),
                                  ], */
                                [
                                    'attribute' => 'pt_hospital_number',
                                    'header' => 'HN',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'value' => function ($model) {
                                return empty($model->pt_hospital_number) ? '-' : $model->pt_hospital_number;
                            }
                                ],
                                [
                                    'attribute' => 'pt_visit_number',
                                    'header' => 'VN',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'value' => function ($model) {
                                return empty($model->pt_visit_number) ? '-' : $model->pt_visit_number;
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
                                    'attribute' => 'pt_right',
                                    'header' => 'สิทธิการรักษา',
                                    'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'value' => function ($model) {
                                return empty($model->pt_right) ? '-' : $model->pt_right;
                            }
                                ],
                                [
                                    'attribute' => 'pt_visit_status',
                                    'header' => 'สถานะผู้ป่วย',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                    'template' => '{newcpoe} ',
                                    'urlCreator' => function($action, $model, $key, $index) {
                                return Url::to(['/cpoe/drugorder/create-header', 'id' => $key]);
                            },
                                    'buttons' => [
                                        'newcpoe' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-success btn-xs"> สร้างใบสั่งยา </span>', $url, [
                                                        'title' => 'สร้างใบสั่งยา',
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
        </div>
        <div class="horizontal-space"></div>

    </div>

</div>

