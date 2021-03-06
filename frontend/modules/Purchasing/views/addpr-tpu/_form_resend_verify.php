<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use app\models\TbDepartment;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\TbPrtype;
use app\models\TbPotype;
use app\models\TbPrstatus;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);

$decode = base64_decode($view);
if ($view == 'wating-verify') {
    $this->title = 'ใบขอซื้อรอการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['addpr-gpu/list-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['addpr-gpu/list-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($modelPR2['PRNum'] == $decode) {
    $this->title = 'ใบขอซื้อไม่ผ่านการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['addpr-gpu/list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['addpr-gpu/list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อยาสามัญ', 'url' => ['addpr-gpu/list-reject-verify']];
    $this->params['breadcrumbs'][] = $this->title;
}

if ($view == 'reject-verify' or $view == 'wating-verify' || $view == '') {
    $actioncolumn = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'noWrap' => true,
        'pageSummary' => 'บาท',
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
        'template' => '',
        'buttonOptions' => ['class' => 'btn btn-default'],
    ];
} else {
    $actioncolumn = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
        'template' => ' {edit} {delete}',
        'buttonOptions' => ['class' => 'btn btn-default'],
        'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:left'],
        'pageSummary' => 'บาท',
        'buttons' => [
            'edit' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                            'class' => 'activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
                            //'data-target' => '#verify-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
                    'delete' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                            'title' => 'Delete',
                            'data-toggle' => 'modal',
                            'class' => 'activity-delete-link',
                ]);
            },
                ],
            ];
        }
        ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="tabbable">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="tab-success active">
                            <a data-toggle="tab" href="#home">
                                <?= Html::encode($this->title) ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content bg-white">
                        <div id="home" class="tab-pane in active">
                            <div class="well">

                                <div class="tb-pr2-form ">
                                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtempgpu']); ?>
                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR2, 'PRNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRNum', ['showLabels' => false])->textInput([
                                                'maxlength' => true,
                                                'readonly' => true,
                                                'style' => 'background-color:white'
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR2, 'DepartmentID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'DepartmentID', ['showLabels' => false])->dropdownList(
                                                    ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                                                'id' => 'ddl-department',
                                                'prompt' => 'Select Department...',
                                                'style' => 'background-color: White',
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelPR2, 'PRDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRDate', ['showLabels' => false])->widget(DatePicker::classname(), [
                                                'language' => 'th',
                                                'dateFormat' => 'dd/MM/yyyy',
                                                'clientOptions' => [
                                                    'changeMonth' => true,
                                                    'changeYear' => true,
                                                ],
                                                'options' => [
                                                    'class' => 'form-control',
                                                    'style' => 'background-color: #ffff99',
                                                ],
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR2, 'SectionID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'SectionID', ['showLabels' => false])->widget(DepDrop::classname(), [
                                                'options' => ['id' => 'ddl-section'],
                                                'data' => [$section],
                                                'pluginOptions' => [
                                                    'depends' => ['ddl-department'],
                                                    'url' => Url::to(['addpr-tpu/get-department']),
                                                    'style' => 'background-color: White',
                                                ]
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR2, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPrtype::find()->where(['PRTypeID' => $modelPR2['PRTypeID']])->all(), 'PRTypeID', 'PRType'),
                                                'pluginOptions' => [
                                                    'placeholder' => 'Select Option',
                                                    'allowClear' => true,
                                                ],
                                                    //'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR2, 'POTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'POTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPotype::find()->where(['POTypeID' => $modelPR2['POTypeID']])->all(), 'POTypeID', 'POType'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Option'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR2, 'PRStatusID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRStatusID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPrstatus::find()->where(['PRStatusID' => $modelPR2['PRStatusID']])->all(), 'PRStatusID', 'PRStatus'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Option'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR2, 'PRExpectDate', ['label' => 'กำหนดเวลาการส่งมอบ(วัน)', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRExpectDate', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: #ffff99',
                                                'type' => 'number'
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                    <?= $form->field($modelPR2, 'PRID', ['showLabels' => false])->hiddenInput([]) ?>
                                    <div class="form-group" >
                                        <a class="btn btn-success" id="getdatatpu"><i class="glyphicon glyphicon-plus">เลือกรายการยาการค้า</i></a>
                                        <p></p>
                                        <?php Pjax::begin(['id' => 'verify_pjax_id']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'showPageSummary' => true,
                                            'responsiveWrap' => FALSE,
                                            'hover' => true,
                                            'pjax' => true,
                                            'bordered' => false,
                                            'striped' => false,
                                            'condensed' => true,
                                            'toggleData' => false,
                                            'rowOptions' => function($model) {
                                                if ($model->PRItemOnPCPlan == 1) {
                                                    return ['class' => 'warning'];
                                                }
                                            },
                                                    'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                                    'columns' => [
                                                        [
                                                            'class' => 'kartik\grid\SerialColumn',
                                                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                            'width' => '36px',
                                                            'header' => '#',
                                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;']
                                                        ],
                                                        [
                                                            'class' => 'kartik\grid\ExpandRowColumn',
                                                            'value' => function ($model, $key, $index, $column) {
                                                                return GridView::ROW_COLLAPSED;
                                                            },
                                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;'],
                                                            'expandOneOnly' => true,
                                                            'detailAnimationDuration' => 'slow', //fast
                                                            'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                            'detailUrl' => Url::to(['view-detailtpu-reject']),
                                                        ],
                                                        [
                                                            'attribute' => 'ItemID',
                                                            'header' => 'รหัสสินค้า',
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'format' => 'raw',
                                                            'value' => function ($model) {
                                                        return '<kbd>' . $model->TMTID_TPU . '</kbd>';
                                                    },
                                                        ],
                                                        [
                                                            'attribute' => 'ItemName',
                                                            'header' => 'รายละเอียดยา',
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                            'value' => function($model) {
                                                        return $model->dataonview->ItemName;
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'PRQty',
                                                            'label' => FALSE,
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->PRQty) ? '-' : number_format($model->dataonview->PRQty, 2);
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'PRUnitCost2',
                                                            'label' => 'ขอซื้อ',
                                                            'width' => '100px',
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->PRUnitCost2) ? '-' : number_format($model->dataonview->PRUnitCost2, 2);
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'PRUnit',
                                                            'label' => false,
                                                            'noWrap' => true,
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            'pageSummary' => 'รวมเป็นเงิน',
                                                            'value' => function ($model) {
                                                        return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                                    }
                                                        ],
                                                        [
                                                            'attribute' => 'ExtenedCost',
                                                            'label' => 'ราคารวม',
                                                            'noWrap' => true,
                                                            'width' => '120px',
                                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                            'hAlign' => 'center',
                                                            'pageSummary' => true,
                                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                                            'format' => ['decimal', 2],
                                                            'value' => function ($model) {
                                                        return $model->PROrderQty * $model->PRUnitCost;
                                                    }
                                                        ],
                                                        $actioncolumn,
                                                        [
                                                            'class' => '\kartik\grid\DataColumn',
                                                            'hAlign' => GridView::ALIGN_CENTER,
                                                            'width' => '10px',
                                                            'hidden' => true,
//                                                'value' => function ($model, $key, $index, $widget) {
//                                                    return '-';
//                                                },
                                                            'group' => true, // enable grouping
                                                            'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                                return [
                                                                    'mergeColumns' => [
                                                                        [1, 3],
                                                                        [8, 9]
                                                                    ], // columns to merge in summary
                                                                    'content' => [// content to show in each summary cell
                                                                        1 => '',
                                                                        4 => 'จำนวน',
                                                                        5 => 'ราคา/หน่วย',
                                                                        6 => 'หน่วย',
                                                                    ],
                                                                    'contentOptions' => [// content html attributes for each summary cell
                                                                        0 => ['style' => 'background-color: #ddd'],
                                                                        1 => ['style' => 'font-variant:small-caps;background-color: #ddd;color:black;'],
                                                                        4 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                        5 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                        6 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                        7 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                        8 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                        9 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                    ],
                                                                    // html attributes for group summary row
                                                                    'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                                ];
                                                            }
                                                                ],
                                                            ],
                                                        ]);
                                                        ?>
                                                        <?php Pjax::end() ?>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label no-padding-right">เหตุผลการขอซื้อ</label>
                                                        <div class="col-sm-4">
                                                            <div id="TbPrReasonCheckbox">
                                                                <?php
                                                                echo $htl_checkbox;
                                                                echo $htl_checkbox1;
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label no-padding-right">อื่นๆ</label>
                                                        <div class="col-sm-3">
                                                            <?=
                                                            $form->field($modelPR2, 'PRReasonNote', ['showLabels' => false])->textarea([
                                                                'rows' => 3,
                                                                'style' => 'background-color:white',
                                                            ])
                                                            ?>
                                                        </div>
                                                        <?= Html::activeLabel($modelPR2, 'PRRejectReason', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                                        <div class="col-sm-3">
                                                            <?=
                                                            $form->field($modelPR2, 'PRRejectReason', ['showLabels' => false])->textarea([
                                                                'rows' => 3,
                                                                'style' => 'background-color:white',
                                                                'readonly' => true
                                                            ])
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?= $form->field($modelPR2, 'PRID', ['showLabels' => false])->hiddenInput([]) ?>
                                            <div class="form-group" style="text-align: right">
                                                <?php if ($modelPR2['PRNum'] == $decode) { ?>
                                                    <?= Html::a('Close', ['addpr-gpu/list-reject-verify'], ['class' => 'btn btn-default']) ?>
                                                    <a class="btn btn-danger">Clear</a>
                                                    <?= Html::submitButton($modelPR2->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $modelPR2->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'id' => 'SaveDraft', 'data-style' => 'expand-left']) ?> 
                                                    <a class="btn btn-info" id="SendtoVerify" >Save & Send To Verify</a>
                                                <?php } ?>
                                            </div>
                                            <?php ActiveForm::end(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="horizontal-space"></div>
                            </div>
                        </div>


                        <!-- Modal /-->

                        <?php
                        Modal::begin([
                            'id' => 'getdatatpumodal',
                            'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                            'size' => 'modal-lg modal-primary',
                            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                            'closeButton' => false,
                        ]);
                        ?>
                        <div id="datatpu"></div>
                        <?php Modal::end(); ?>


                        <?php
                        Modal::begin([
                            'id' => 'verify-modal',
                            'header' => '<h4 class="modal-title">ปรับปรุงรายการยาการค้า</h4>',
                            'size' => 'modal-lg',
                            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                            'closeButton' => false,
                        ]);
                        ?>
                        <div id="data"></div>
                        <?php Modal::end();
                        ?>



                        <!-- JS -->
                        <?php
                        $script = <<< JS
/* Savedraft */
$('#formtempgpu').on('beforeSubmit', function (e)
{
    // var selector = '.steps #wiredstep1';
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )

            .done(function (result) {
                if (result == "1")
                {
                    swal({
                        title: "",
                        text: "ไม่สามารถขอซื้อเกินมูลค่าของประเภทการสั่งซื้อ",
                        type: "warning",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                }
                            });
                } else
                {
                    $('#SendtoVerify').removeClass('disabled');
                    swal({
                        title: "",
                        text: "Save Complete!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    Savereason();
                                }
                            });
                }
            })
            .fail(function ()
            {
                console.log('server error');
            })
            .always(function () {
                // l.ladda('stop');
                // Notify('SaveDraft Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
            });
    return false;
});

function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'ios',//roundBounce
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}   
/* Save เหตุผลการขอซื้อเมื่อกด SaveDraft */
function Savereason() {
    var PRID = $("#tbpr2-prid").val();
    var reasonid = new Array();
    $('input[type=checkbox]').each(function () {
        if ($(this).is(':checked'))
        {
            reasonid.push($(this).val());
        }
    });
    $.post(
            'save-reason',
            {
                PRID: PRID, reasonid: reasonid
            },
    function (data)
    {

    }
    );
}
                                    
$('#getdatatpu').click(function (e) {
    LoadingClass();
    $.ajax({
        url: 'getdatatpu',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#getdatatpumodal').find('.modal-body').html(data);
            $('#datatpu').html(data);
            //$('.modal-title').html('เลือกรายการยาการค้า');
            //$('.modal-header').addClass("bordered-success");
            $('.page-content').waitMe('hide');
            $('#getdatatpumodal').modal('show');
            $('#getdatatputable').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "pageLength": 5,
                responsive: true,
                "language": {
                    "lengthMenu": " _MENU_ ",
                    "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 10, 15, 20, 100, -1],
                    [5, 10, 15, 20, 100, "All"]
                ],
            });
        }
    });
});                                   
                                    
$(document).ready(function () {
        $('#SendtoVerify').addClass("disabled", "disabled");
});
                                    
function init_click_handlers() {           

/* Edit Verify */
$('.activity-update-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
    LoadingClass();
    $.get(
            'update-verify-reject',
            {
                id: fID
            },
    function (data)
    {
        //$('#formdetailgpu').trigger('reset');
        $('#verify-modal').find('.modal-body').html(data);
        $('#data').html(data);
        //$('.modal-title').html('ปรับปรุงรายการยาสามัญ ทวนสอบใบขอซื้อ');
        $('#checkover').val('');
        $('.page-content').waitMe('hide');
        $('#verify-modal').modal('show');
    }
    );
});

/* Delete Verify */
$('.activity-delete-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
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
                            'delete-detail-verify',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#verify_pjax_id'});
                    }
                    );
                }
            });
});
}
init_click_handlers(); //first run
$('#verify_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                                
/* SendtoVerify */
$('#SendtoVerify').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRNum = $("#tbpr2-prnum").val();
    swal({
        title: "ยืนยันการส่งทวนสอบ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'sendtoverify-reject',
                            {
                                PRNum: PRNum, PRID: PRID
                            },
                    function (data)
                    {

                    }
                    );
                }
            });
});
JS;
                        $this->registerJs($script, \yii\web\View::POS_END, 'update-resend-verify');
                        ?>


<script>
    function SelectTPU(d) {
        var PRID = $("#tbpr2-prid").val();
        var plan = (d.getAttribute("data-id"));
        var id = (d.getAttribute("id"));
        var ids_PR_selected = $("#tbpr2temp-ids_pr_selected").val();
        LoadingClass();
        $.ajax({
            url: 'new-detailtpu-reject',
            type: 'POST',
            data: {id: id, PRID: PRID},
            success: function (data) {
                if (data == 'false') {
                    swal({
                        title: "",
                        text: "รหัสยานี้ถูกบันทึกแล้ว!",
                        type: "warning"
                    });
                    $('.page-content').waitMe('hide');
                } else {
                    $('#formdetailtpu').trigger("reset");
                    $('#verify-modal').find('.modal-body').html(data);
                    $('#data').html(data);
                    $('.page-content').waitMe('hide');
                    $('#verify-modal').modal('show');
                    $('#vwpritemdetail2-tmtid_tpu').val(id);
                    $('#vwpritemdetail2-prid').val(PRID);
                    if (plan != "") {
                        $("#vwpritemdetail2-pcplannum").val(plan).trigger("change");
                    }
                    $('#cmd').val('1');
                }
            }
        });
    }
</script>