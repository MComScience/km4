<?php

use yii\helpers\Html;
use fedemotta\datatables\DataTables;
use yii\widgets\Pjax;
use yii\helpers\Url;

$this->title = 'รายชื่อผู้ป่วยนอก';
$this->params['breadcrumbs'][] = ['label' => 'งานเภสัชกรรม', 'url' => ['/pharmacy/rx/index']];
$this->params['breadcrumbs'][] = ['label' => 'สั่งจ่ายยาผู้ป่วยนอก', 'url' => ['/pharmacy/rx/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <?php echo $this->render('_tab_index'); ?>
            <div class="tab-content bg-white">
                <div id="TabA" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="tb-cpoe-index">
                                <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
                                <?php Pjax::begin(); ?>    
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
                                            [
                                            'attribute' => 'HNVN',
                                            'header' => 'HNVN',
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
                                            'attribute' => 'pt_right',
                                            'header' => 'สิทธิการรักษา',
                                            'contentOptions' => ['class' => 'text-left', 'noWrap' => true,],
                                            'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                            'value' => function ($model) {
                                                return empty($model->pt_right) ? '-' : $model->pt_right;
                                            }
                                        ],
                                            [
                                            'class' => 'yii\grid\ActionColumn',
                                            'header' => 'Actions',
                                            'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                            'headerOptions' => ['style' => 'text-align:center;color:black;'],
                                            'template' => '{rxorder} {chemorxorder}',
                                            'buttons' => [
                                                'rxorder' => function ($url, $model) {
                                                    return Html::a('<span class="btn btn-success btn-xs"> Rx Order </span>', $url, [
                                                                'title' => 'Rx Order',
                                                                'data-pjax' => 0,
                                                    ]);
                                                },
                                                'chemorxorder' => function ($url, $model, $key) {
                                                    return Html::a('<span class="btn btn-purple btn-xs">Chemo Rx Order </span>', $url, [
                                                                'title' => 'Chemo Rx Order',
                                                                'data-pjax' => 0,
                                                    ]);
                                                },
                                            ],
                                            'urlCreator' => function ($action, $model, $key, $index) {
                                                if ($action === 'chemorxorder') {
                                                    return Url::to(['/pharmacy/rx/create-order-chemo', 'data' => $key,'type' => 'chemo']);
                                                }
                                                if ($action === 'rxorder') {
                                                    return Url::to(['/pharmacy/rx/create-order-chemo', 'data' => $key,'type' => 'homemed']);
                                                }
                                            }
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php Pjax::end(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: right;">
                            <?= Html::a('Close', ['/'], ['class' => 'btn btn-default']) ?>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>

    </div>
</div>


