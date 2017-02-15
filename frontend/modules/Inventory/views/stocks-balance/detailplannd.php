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

$this->title = 'รายการเวชภัณฑ์ รอสร้างใบขอซื้อสัญญาจะซื้อจะขาย';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['detailnd']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$(document).ready(function () {
        $('#tab_G').addClass("active");
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
                    <?php Pjax::begin(['id' => 'detailplannd']) ?>
                    <?php
                    echo $this->render('_searchnd', ['model' => $searchModel,]);
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
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'layout' => "{summary}\n{items}\n{pager}",
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
                                'headerOptions' => ['style' => 'text-align:center'],
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'header' => '<a>รหัสสินค้า</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'ItemID',
                                'hAlign' => GridView::ALIGN_CENTER,
                            ],
                            [
                                'header' => '<a>รายละเอียดสินค้า</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'ItemName',
                                'value' => 'dataplannd.ItemName',
                            ],
                            [
                                'header' => '<a>ราคาต่อหน่วย</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PCPlanNDUnitCost',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                //'value' => 'dataplannd.PCPlanNDUnitCost',
                                'value' => function ($model) {
                            if ($model->dataplannd->PCPlanNDUnitCost != null) {
                                return $model->dataplannd->PCPlanNDUnitCost;
                            } else {
                                return '0.00';
                            }
                        }
                            ],
                            [
                                'header' => '<a>จำนวน</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PCPlanNDQty',
                                'format' => ['decimal', 2],
                                'hAlign' => 'right',
                                //'value' => 'dataplannd.PCPlanNDQty',
                                'value' => function ($model) {
                            if ($model->dataplannd->PCPlanNDQty != null) {
                                return $model->dataplannd->PCPlanNDQty;
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
                                //'value' => 'dataplannd.DispUnit',
                                'value' => function ($model) {
                            if ($model->dataplannd->DispUnit != null) {
                                return $model->dataplannd->DispUnit;
                            } else {
                                return '-';
                            }
                        }
                            ],
                            [
                                'header' => '<a>ขอซื้อแล้ว</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRApprovedQtySUM',
                                'hAlign' => 'right',
                                //'value' => 'dataplannd.PRApprovedQtySUM',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->dataplannd->PRApprovedQtySUM != null) {
                                return $model->dataplannd->PRApprovedQtySUM;
                            } else {
                                return '0.00';
                            }
                        }
                            //'width' => '120px',
                            ],
                            [
                                'header' => '<a>ขอซื้อได้</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRNDAvalible',
                                'hAlign' => 'right',
                                //'value' => 'dataplannd.PRNDAvalible',
                                'format' => ['decimal', 2],
                                'value' => function ($model) {
                            if ($model->dataplannd->PRNDAvalible != null) {
                                return $model->dataplannd->PRNDAvalible;
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
                                'header' => '<a>หน่วยแพค</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'ItemPackID',
                                'hAlign' => 'center',
                                //'value' => 'packunit.PackUnit',
                                'value' => function ($model) {
                            if ($model->ItemPackID != null) {
                                return $model->dataplannd->PackUnit;
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
                                'header' => '<a>รวมเป็นเงิน</a>',
                                'headerOptions' => ['style' => 'text-align:center'],
                                'attribute' => 'PRExtenedCost',
                                'hAlign' => 'right',
                                'format' => ['decimal', 2],
                                'pageSummary' => true,
                                'value' => function ($model) {
                            return $model->PRQty * $model->PRUnitCost;
                        }
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
                                                    //'data-method' => "post",
                                                    //'role' => 'modal-remote',
                                                    'class' => 'activity-delete-link',
                                                    'data-toggle' => 'modal',
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

        <div class="col-xs-12 col-sm-6 col-md-7"></div>
        <div class="form-group" >
            <?= Html::activeLabel($modelPR, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
            <div class="col-sm-3">
                <?=
                $form->field($modelPR, 'PRTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(\app\models\TbPrtype::find()->where(['PRTypeID' => [12]])->all(), 'PRTypeID', 'PRType'),
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
                    'data' => ArrayHelper::map(app\models\TbPotype::find()->where(['POTypeID' => [3]])->all(), 'POTypeID', 'POType'),
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
            'header' => '<h4 class="modal-title">บันทึกรายการเวชภัณฑ์ ใบขอซื้อสัญญาจะซื้อจะขาย</h4>',
            'size' => 'modal-lg modal-primary',
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
                    $.pjax.reload({container: '#detailplannd'});
                }
                );
            }
        });
    });
$(".activity-update-link").click(function(e) {
                    var fID = $(this).closest("tr").data("key");
                    $.get(
                        "index.php?r=Inventory/stocks-balance/updateplannd",
                        {
                            id: fID
                        },
                        function (data)
                        {
                            $('#formplannd').trigger('reset');
                            $("#activity-modal").find(".modal-body").html(data);
                            $(".modal-body").html(data);
                           // $(".modal-title").html("ปรับปรุงรายการเวชภัณฑ์ สัญญาจะซื้อจะขาย");
                            $("#activity-modal").modal("show");
                        }
                    );
                });
            
        }
        init_click_handlers(); //first run
        $("#detailplannd").on("pjax:success", function() {
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
        var Plan = 'ND_Cont';
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