<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\Growl;

$this->title = 'รายการยาการค้า รอสร้างใบขอซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['detailgpu']];
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_D').addClass("active");
    });
JS;
$this->registerJs($script);
?>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="tabbable">
            <?php echo $this->render('_tab_menu'); ?>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <?php Pjax::begin([ 'timeout' => 5000, 'id' => 'detailtpu']) ?>
                    <?php
                    echo $this->render('_searchtpu', ['model' => $searchModel,]);
                    ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'export' => false,
                        'bootstrap' => true,
                        'responsiveWrap' => FALSE,
                        'responsive' => true,
                        'showPageSummary' => true,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => true,
                        'condensed' => true,
                        'toggleData' => false,
                        'layout' => "{summary}\n{items}\n{pager}",
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model->ids];
                },
                        //'rowOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'columns' => [
                            [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => '#',
                                'headerOptions' => ['class' => 'kartik-sheet-style']
                            ],
                            [
                                'class' => 'kartik\grid\CheckboxColumn',
                                'header' => '',
                                'headerOptions' => ['class' => 'kartik-sheet-style'],
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PCPlanNum',
                                'format' => 'html',
                                'value' => function($model) {
                            return '<kbd>' . $model->PCPlanNum . '</kbd>';
                        },
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'TMTID_TPU',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                            if ($model->TMTID_TPU != null) {
                                return $model->TMTID_TPU;
                            } else {
                                return '-';
                            }
                        }
                            ],
                            [
                                'header' => '<a>รายละเอียดยาการค้า</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'ItemName',
                                'value' => 'datatpu.ItemName'
                            ],
                            [
                                'header' => '<a>ราคากลาง</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GPUStdCost',
                                //'value' => 'datatpu.GPUStdCost',
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                'value' => function ($model) {
                            if ($model->datatpu->GPUStdCost != null) {
                                return $model->datatpu->GPUStdCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ราคาต่อหน่วย</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'TPUUnitCost',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                //'value' => 'datatpu.TPUUnitCost',
                                'value' => function ($model) {
                            if ($model->datatpu->TPUUnitCost != null) {
                                return $model->datatpu->TPUUnitCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>จำนวน</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'TPUOrderQty',
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                //'value' => 'datatpu.TPUOrderQty',
                                'value' => function ($model) {
                            if ($model->datatpu->TPUOrderQty != null) {
                                return $model->datatpu->TPUOrderQty;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>หน่วย</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'DispUnit',
                                'hAlign' => 'right',
                                'value' => 'datatpu.DispUnit',
                                'value' => function ($model) {
                            if ($model->datatpu->DispUnit != null) {
                                return $model->datatpu->DispUnit;
                            } else {
                                return '-';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ขอซื้อแล้ว</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRApprovedOrderQty',
                                'hAlign' => 'right',
                                //'value' => 'datatpu.PRApprovedOrderQty',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->datatpu->PRApprovedOrderQty != null) {
                                return $model->datatpu->PRApprovedOrderQty;
                            } else {
                                return '0.00';
                            }
                        }
                            //'width' => '120px',
                            ],
                            [
                                'header' => '<a>ขอซื้อได้</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRTPUAvalible',
                                'hAlign' => 'right',
                                //'value' => 'datatpu.PRTPUAvalible',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->datatpu->PRTPUAvalible != null) {
                                return $model->datatpu->PRTPUAvalible;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>จำนวนแพค</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRPackQty',
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                'value' => function ($model) {
                            if ($model->PRPackQty != null) {
                                return $model->PRPackQty;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>หน่วยแพค</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'ItemPackID',
                                'hAlign' => 'center',
                                //'value' => 'packunit.packunit',
                                'value' => function ($model) {
                            if ($model->ItemPackID != null) {
                                return $model->packunit->PackUnit;
                            } else {
                                return '-';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ขอซื้อ</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRQty',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->PRQty != null) {
                                return $model->PRQty;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ราคาต่อหน่วย</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRUnitCost',
                                'pageSummary' => 'รวมเป็นเงิน',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->PRUnitCost != null) {
                                return $model->PRUnitCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'class' => '\kartik\grid\FormulaColumn',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'header' => '<a>รวมเป็นเงิน</a>',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                'value' => function ($model, $key, $index, $widget) {
                            $p = compact('model', 'key', 'index');
                            // Write your formula below
                            return $widget->col(13, $p) * $widget->col(14, $p);
                        },
                                'pageSummary' => true,
                            ],
                            [
                                'class' => 'kartik\grid\ActionColumn',
                                'pageSummary' => 'บาท',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:200px;'],
                                'header' => '<a>Actions</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'template' => ' {update} {deletegpu}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'buttons' => [
                                    //view button
//                                            'view' => function ($url, $model) {
//                                                if ($model->PRStatusID != 9) {
//                                                    return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
//                                                                //'title' => Yii::t('app', 'view'),
//                                                                'class' => 'activity-view-link',
//                                                                'role' => 'modal-remote',
//                                                                'title' => 'View',
//                                                                'data-toggle' => 'modal',
//                                                                'data-target' => '#activity-modal',
//                                                                //'data-id' => $key,
//                                                                'data-pjax' => '0',
//                                                    ]);
//                                                }
//                                            },
                                    'update' => function ($url, $model, $key) {
                                        return Html::a('<span class="btn btn-primary btn-xs">Edit</span>', '#', [
                                                    'class' => 'activity-update-link',
                                                    'title' => 'แก้ไขข้อมูล',
                                                    'data-toggle' => 'modal',
                                                    'data-target' => '#activity-modal',
                                                    'data-id' => $key,
                                                    'data-pjax' => '0',
                                        ]);
                                    },
                                            'deletegpu' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                    //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'title' => Yii::t('app', 'Delete'),
                                                    'data-toggle' => 'modal',
                                                    //'data-method' => "post",
                                                    //'role' => 'modal-remote',
                                                    'class' => 'activity-delete-link',
                                        ]);
                                    },
                                        ],
                                    ],
                                ],
                                'persistResize' => false,
                            ]);
                            ?>
                            <?php Pjax::end() ?>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>
            </div>
        </div>

        <?php
        $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
        ?>
        <div class="col-xs-12 col-sm-6 col-md-7 "></div>
        <div class="form-group" >
            <?= Html::activeLabel($modelPR, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelPR, 'PRTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\TbPrtype::find()->where(['PRTypeID' => [2, 6]])->all(), 'PRTypeID', 'PRType'),
                    'pluginOptions' => [
                        'placeholder' => 'Select Option',
                        'allowClear' => true,
                    //'disabled' => true
                    ],
                ])
                ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-7"></div>
        <div class="form-group">
            <?= Html::activeLabel($modelPR, 'POTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelPR, 'POTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\TbPotype::find()->all(), 'POTypeID', 'POType'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Option'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
                ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-7"></div>
        <div class="form-group">
            <?= Html::activeLabel($modelPR, 'PRExpectDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelPR, 'PRExpectDate', ['showLabels' => false])->widget(DatePicker::classname(), [
                    'language' => 'th',
                    'dateFormat' => 'dd/MM/yyyy',
                    'clientOptions' => [
                        'changeMonth' => true,
                        'changeYear' => true,
                    ],
                    'options' => [
                        'class' => 'form-control',
                        //'placeholder' => 'เลือกวันที่ต้องการสินค้า...',
                        'style' => 'background-color: white'
                    ],
                ])
                ?>
            </div>
        </div>

        <div class="modal-footer" style="text-align: right">
            <a class="btn btn-default" href="index"><i class="glyphicon glyphicon-backward"></i><?php echo yii\helpers\Html::encode('Back'); ?></a>
            <button class="btn btn-danger" type="reset"><i class="glyphicon glyphicon-repeat"></i>Clear</button>
            <a class="btn btn-primary" onclick="CreatePR();"><i class="glyphicon glyphicon-pencil"></i>สร้างใบขอซื้อ</a>
        </div>
        <?php ActiveForm::end(); ?>

        <?php
        Modal::begin([
            'id' => 'activity-modal',
            'header' => '<h4 class="modal-title">บันทึกรายการยาการค้า ใบขอซื้อ</h4>',
            'size' => 'modal-lg',
//            'footer' => '
//            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
//            <a href="#" class="btn btn-success" >Save</a>
//            ',
        ]);
        Modal::end();
        ?>

        <?php
        $script = <<< JS
        function init_click_handlers(){
           $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.post(
                        'index.php?r=Inventory/stocks-balance/deletegpu',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#detailtpu'});
                }
                );
            }
        });
    });
            $(".activity-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                        "index.php?r=Inventory/stocks-balance/updatetpu",
                        {
                            id: fID
                        },
                        function (data)
                        {
                            $('#formtpu').trigger("reset");
                            $("#activity-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                           // $(".modal-title").html("แก้ไขข้อมูลสมาชิก");
                            $("#activity-modal").modal("show");
                        }
                    );
                });
            
        }
        init_click_handlers(); //first run
        $("#detailtpu").on("pjax:success", function() {
          init_click_handlers(); //reactivate links in grid after pjax update
        });
JS;
        $this->registerJs($script);
        ?>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => Growl::TYPE_SUCCESS,
                'title' => 'Well done!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => 'Save successfully.',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
        <script>
            function CreatePR() {
                var keys = $("#w1").yiiGridView("getSelectedRows");
                var PRTypeID = $("#tbpr-prtypeid").val();
                var POTypeID = $("#tbpr-potypeid").val();
                var PRExpectDate = $("#tbpr-prexpectdate").val();
                var Plan = 'TPU';
                if (keys == "") {
                    Notify('ไม่ได้เลือกรายการยา', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                } else {
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.post({
                                url: "index.php?r=Inventory/stocks-balance/create-dataprtemp", // your controller action
                                //dataType: 'json',
                                data: {keylist: keys, PRTypeID: PRTypeID, POTypeID: POTypeID, PRExpectDate: PRExpectDate, Plan: Plan},
                                success: function (data) {

                                },
                            });
                        }
                    });
                }
            }


        </script>
        <div class="row">
            <?php /*
              $columns = [
              ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT],
              [
              'class' => 'kartik\grid\CheckboxColumn',
              'header' => '',
              'headerOptions' => ['class' => 'kartik-sheet-style'],
              ],
              [
              'header' => 'เลขที่แผนจัดซื้อ',
              'attribute' => 'PCPlanNum',
              'hAlign' => GridView::ALIGN_CENTER,
              ],
              [
              'header' => 'รหัสยาการค้า',
              'attribute' => 'TMTID_TPU',
              'hAlign' => GridView::ALIGN_CENTER,
              ],
              [
              'header' => 'รายละเอียดยาการค้า',
              'attribute' => 'ItemName',
              'value' => 'datatpu.ItemName'
              ],
              [
              'header' => 'ราคากลาง',
              'attribute' => 'GPUStdCost',
              'value' => 'datatpu.GPUStdCost'
              ],
              [
              'header' => 'ราคาต่อหน่วย',
              'attribute' => 'TPUUnitCost',
              'hAlign' => 'right',
              'format' => ['decimal', 2],
              'value' => 'datatpu.TPUUnitCost'
              ],
              [
              'header' => 'จำนวน',
              'attribute' => 'TPUOrderQty',
              'format' => ['decimal', 2],
              'hAlign' => 'right',
              'value' => 'datatpu.TPUOrderQty'
              ],
              [
              'header' => 'หน่วย',
              'attribute' => 'DispUnit',
              'hAlign' => 'right',
              'value' => 'datatpu.DispUnit',
              ],
              [
              'header' => 'ขอซื้อแล้ว',
              'attribute' => 'PRApprovedOrderQty',
              'hAlign' => 'right',
              'value' => 'datatpu.PRApprovedOrderQty',
              //'width' => '120px',
              ],
              [
              'header' => 'ขอซื้อได้',
              'attribute' => 'PRTPUAvalible',
              'hAlign' => 'right',
              'value' => 'datatpu.PRTPUAvalible',
              ],
              [
              'header' => 'จำนวนแพค',
              'attribute' => 'PRPackQty',
              ],
              [
              'header' => 'หน่วยแพค',
              'attribute' => 'ItemPackID',
              'value' => 'packunit.PackUnit',
              ],
              [
              'header' => 'ขอซื้อ',
              'attribute' => 'PRQty',
              ],
              [
              'header' => 'ราคาต่อหน่วย',
              'attribute' => 'PRUnitCost',
              'pageSummary' => 'รวมเป็นเงิน',
              'hAlign' => 'right',
              ],
              [
              'header' => 'รวมเป็นเงิน',
              'attribute' => 'PRExtenedCost',
              'hAlign' => 'right',
              'format' => ['decimal', 2],
              'value' => 'datatpu.PRExtenedCost',
              'pageSummary' => true,
              ],
              [
              'class' => 'kartik\grid\ActionColumn',
              'pageSummary' => 'บาท',
              //'contentOptions' => ['style' => 'width:260px;'],
              'options' => ['style' => 'width:200px;'],
              'header' => 'Actions',
              'hAlign' => GridView::ALIGN_CENTER,
              'headerOptions' => ['style' => 'text-align:center;'],
              'template' => ' {update} {deletegpu}',
              'buttonOptions' => ['class' => 'btn btn-default'],
              'buttons' => [
              //view button
              //                                            'view' => function ($url, $model) {
              //                                                if ($model->PRStatusID != 9) {
              //                                                    return Html::a('<span class="btn btn-success btn-xs btn-group"> Detail </span>', $url, [
              //                                                                //'title' => Yii::t('app', 'view'),
              //                                                                'class' => 'activity-view-link',
              //                                                                'role' => 'modal-remote',
              //                                                                'title' => 'View',
              //                                                                'data-toggle' => 'modal',
              //                                                                'data-target' => '#activity-modal',
              //                                                                //'data-id' => $key,
              //                                                                'data-pjax' => '0',
              //                                                    ]);
              //                                                }
              //                                            },
              'update' => function ($url, $model, $key) {
              return Html::a('<span class="btn btn-primary btn-xs">Edit</span>', '#', [
              'class' => 'activity-update-link',
              'title' => 'แก้ไขข้อมูล',
              'data-toggle' => 'modal',
              'data-target' => '#activity-modal',
              'data-id' => $key,
              'data-pjax' => '0',
              ]);
              },
              'deletegpu' => function ($url, $model) {
              return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', $url, [
              'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
              'title' => Yii::t('app', 'Delete'),
              'data-method' => "post",
              'role' => 'modal-remote',
              ]);
              },
              ],
              ],
              ];
              $dynagrid = DynaGrid::begin([
              'columns' => $columns,
              //'theme' => 'panel-info',
              //'showPersonalize' => true,
              //'storage' => 'cookie',
              'gridOptions' => [
              'dataProvider' => $dataProvider,
              //'filterModel' => $searchModel,
              'bootstrap' => true,
              'responsiveWrap' => FALSE,
              'responsive' => true,
              'showPageSummary' => true,
              'hover' => true,
              'pjax' => true,
              'striped' => false,
              'condensed' => true,
              'footerRowOptions' => false,
              'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
              //                                'panel' => [
              //                                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i>  Library</h3>',
              //                                    'before' => '<div style="padding-top: 7px;"><em>* The table header sticks to the top in this demo as you scroll</em></div>',
              //                                    'after' => false
              //                                ],
              'toolbar' => [
              //                                    ['content' =>
              //                                        //Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => 'Add Book', 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' ' .
              //                                       // Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['dynagrid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])
              //                                    ],
              ['content' => '{dynagridFilter}{dynagridSort}{dynagrid}'],
              '{export}',
              '{toggleData}'
              ]
              ],
              'options' => ['id' => 'dynagrid-1'] // a unique identifier is important
              ]);
              if (substr($dynagrid->theme, 0, 6) == 'simple') {
              $dynagrid->gridOptions['panel'] = false;
              }
              DynaGrid::end();?>
             * 
             */
            ?>         
        </div>
        <?php /*
          use dosamigos\google\maps\LatLng;
          use dosamigos\google\maps\services\DirectionsWayPoint;
          use dosamigos\google\maps\services\TravelMode;
          use dosamigos\google\maps\overlays\PolylineOptions;
          use dosamigos\google\maps\services\DirectionsRenderer;
          use dosamigos\google\maps\services\DirectionsService;
          use dosamigos\google\maps\overlays\InfoWindow;
          use dosamigos\google\maps\overlays\Marker;
          use dosamigos\google\maps\Map;
          use dosamigos\google\maps\services\DirectionsRequest;
          use dosamigos\google\maps\overlays\Polygon;
          use dosamigos\google\maps\layers\BicyclingLayer;

          $coord = new LatLng(['lat' => 39.720089311812094, 'lng' => 2.91165944519042]);
          $map = new Map([
          'center' => $coord,
          'zoom' => 14,
          ]);

          // lets use the directions renderer
          $home = new LatLng(['lat' => 39.720991014764536, 'lng' => 2.911801719665541]);
          $school = new LatLng(['lat' => 39.719456079114956, 'lng' => 2.8979293346405166]);
          $santo_domingo = new LatLng(['lat' => 39.72118906848983, 'lng' => 2.907628202438368]);

          // setup just one waypoint (Google allows a max of 8)
          $waypoints = [
          new DirectionsWayPoint(['location' => $santo_domingo])
          ];

          $directionsRequest = new DirectionsRequest([
          'origin' => $home,
          'destination' => $school,
          'waypoints' => $waypoints,
          'travelMode' => TravelMode::DRIVING
          ]);

          // Lets configure the polyline that renders the direction
          $polylineOptions = new PolylineOptions([
          'strokeColor' => '#FFAA00',
          'draggable' => true
          ]);

          // Now the renderer
          $directionsRenderer = new DirectionsRenderer([
          'map' => $map->getName(),
          'polylineOptions' => $polylineOptions
          ]);

          // Finally the directions service
          $directionsService = new DirectionsService([
          'directionsRenderer' => $directionsRenderer,
          'directionsRequest' => $directionsRequest
          ]);

          // Thats it, append the resulting script to the map
          $map->appendScript($directionsService->getJs());

          // Lets add a marker now
          $marker = new Marker([
          'position' => $coord,
          'title' => 'My Home Town',
          ]);

          // Provide a shared InfoWindow to the marker
          $marker->attachInfoWindow(
          new InfoWindow([
          'content' => '<p>This is my super cool content</p>'
          ])
          );

          // Add marker to the map
          $map->addOverlay($marker);

          // Now lets write a polygon
          $coords = [
          new LatLng(['lat' => 25.774252, 'lng' => -80.190262]),
          new LatLng(['lat' => 18.466465, 'lng' => -66.118292]),
          new LatLng(['lat' => 32.321384, 'lng' => -64.75737]),
          new LatLng(['lat' => 25.774252, 'lng' => -80.190262])
          ];

          $polygon = new Polygon([
          'paths' => $coords
          ]);

          // Add a shared info window
          $polygon->attachInfoWindow(new InfoWindow([
          'content' => '<p>This is my super cool Polygon</p>'
          ]));

          // Add it now to the map
          $map->addOverlay($polygon);


          // Lets show the BicyclingLayer :)
          $bikeLayer = new BicyclingLayer(['map' => $map->getName()]);

          // Append its resulting script
          $map->appendScript($bikeLayer->getJs());

          // Display the map -finally :)
          echo $map->display();
         */ ?>