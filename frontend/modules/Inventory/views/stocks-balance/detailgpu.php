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

$this->title = 'รายการยาสามัญ รอสร้างใบขอซื้อ';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['detailgpu']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_C').addClass("active");
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
                    <?php Pjax::begin(['id' => 'detailgpu']) ?>
                    <?php echo $this->render('_searchgpu', ['model' => $searchModel]); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'export' => false,
                        'bootstrap' => true,
                        'resizableColumns' => true,
                        'responsive' => true,
                        'showPageSummary' => true,
                        'hover' => true,
                        'pjax' => true,
                        'striped' => true,
                        'condensed' => true,
                        'toggleData' => false,
                        'responsiveWrap' => true,
                        'layout' => "{summary}\n{items}\n{pager}",
                        'pageSummaryRowOptions' => ['class' => 'default'],
                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                        'rowOptions' => function ($model, $key, $index, $grid) {
                    return ['data-id' => $model->ids];
                },
                        //'rowOptions' => ['class' => GridView::TYPE_DEFAULT],
                        'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
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

                                'attribute' => 'PCPlanNum',
                                'class' => '\kartik\grid\DataColumn',
                                'noWrap' => true,
                                //'headerOptions' => ['style' => 'text-align:center'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'vAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'attribute' => 'TMTID_GPU',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'header' => '<a>รายละเอียดยาสามัญ</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'FSN_GPU',
                                'value' => 'fsngpu.FSN_GPU'
                            ],
                            [
                                'header' => '<a>ราคากลาง</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GPUStdCost',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                //'value' => 'planview.GPUStdCost',
                                'value' => function ($model) {
                            if ($model->planview->GPUStdCost != null) {
                                return $model->planview->GPUStdCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ราคาต่อหน่วย</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GPUUnitCost',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                //'value' => 'planview.GPUUnitCost',
                                'value' => function ($model) {
                            if ($model->planview->GPUUnitCost != null) {
                                return $model->planview->GPUUnitCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>จำนวน</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'GPUOrderQty',
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                //'value' => 'planview.GPUOrderQty',
                                'value' => function ($model) {
                            if ($model->planview->GPUOrderQty != null) {
                                return $model->planview->GPUOrderQty;
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
                                //'value' => 'planview.DispUnit',
                                'value' => function ($model) {
                            if ($model->planview->DispUnit != null) {
                                return $model->planview->DispUnit;
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
                                //'value' => 'planview.PRApprovedOrderQty',
                                'width' => '120px',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->planview->PRApprovedOrderQty != null) {
                                return $model->planview->PRApprovedOrderQty;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ขอซื้อได้</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRGPUAvalible',
                                'hAlign' => 'right',
                                //'value' => 'planview.PRGPUAvalible',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->planview->PRGPUAvalible != null) {
                                return $model->planview->PRGPUAvalible;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'attribute' => 'PRPackQty',
                                'headerOptions' => ['style' => 'text-align:center'],
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
                                'attribute' => 'ItemPackID',
                                'headerOptions' => ['style' => 'text-align:center'],
                                //'value' => 'packunit.PackUnit',
                                'hAlign' => 'center',
                                'value' => function ($model) {
                            if ($model->ItemPackID != null) {
                                return $model->packunit->PackUnit;
                            } else {
                                return '-';
                            }
                        }
                            ],
                            [
                                'attribute' => 'PRQty',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                'value' => function ($model) {
                            if ($model->PRQty != null) {
                                return $model->PRQty;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'attribute' => 'PRUnitCost',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'pageSummary' => 'รวมเป็นเงิน',
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                'value' => function ($model) {
                            if ($model->PRUnitCost != null) {
                                return $model->PRUnitCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
//                        [
//                            'header' => '<a>รวมเป็นเงิน</a>',
//                            'headerOptions' => ['style' => 'text-align:center'],
//                            'attribute' => 'PRExtenedCost',
//                            'hAlign' => 'right',
//                            'format' => ['decimal', 2],
//                            'value' => 'planview.PRExtenedCost',
//                            'pageSummary' => true,
//                        ],
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
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:160px;'],
                                'header' => '<a>Actions</a>',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;'],
                                'template' => ' {update} {deletegpu}',
                                'buttonOptions' => ['class' => 'btn btn-default'],
                                'pageSummary' => 'บาท',
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
        <div class="form-group">
            <?= Html::activeLabel($modelPR, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelPR, 'PRTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\TbPrtype::find()->where(['PRTypeID' => [1, 5]])->all(), 'PRTypeID', 'PRType'),
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
            'header' => '<h4 class="modal-title">บันทึกรายการยาสามัญ ใบขอซื้อ</h4>',
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
                    $.pjax.reload({container: '#detailgpu'});
                }
                );
            }
        });
    });
            $(".activity-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                        "index.php?r=Inventory/stocks-balance/updategpu",
                        {
                            id: fID
                        },
                        function (data)
                        {
                            $("#formgpu").trigger("reset");
                            $("#activity-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                           // $(".modal-title").html("แก้ไขข้อมูลสมาชิก");
                            $("#activity-modal").modal("show");
                        }
                    );
                });
            
        }
        init_click_handlers(); //first run
        $("#detailgpu").on("pjax:success", function() {
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
        var Plan = 'GPU';
        if (keys == "") {
            Notify('ไม่ได้เลือกรายการยา', 'top-right', '2000', 'danger', 'fa-exclamation', true);
        } else {
            bootbox.confirm("Are you sure?", function (result) {
                if (result) {
                    $.post({
                        url: "index.php?r=Inventory/stocks-balance/create-dataprtemp", // your controller action
                        //dataType: 'json',
                        data: {keylist: keys, PRTypeID: PRTypeID, POTypeID: POTypeID, PRExpectDate: PRExpectDate, Plan: Plan},
//                success: function () {
//                    Notify('Success!', 'top-right', '5000', 'success', 'fa-check', true);
//                },
                    });
                }
            });
        }
    }


</script>
