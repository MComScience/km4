<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\models\TbDepartment;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\TbPotype;
use app\models\TbPcplan;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\LaddaAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
SweetAlertAsset::register($this);
LaddaAsset::register($this);

$decode = base64_decode($view);
if ($view == 'view') {
    $script1 = <<< JS
$(document).ready(function () {
        document.getElementById("SaveDraft").disabled = true;
});      
JS;
    $this->registerJs($script1);
}

if ($view == 'view') {
    $actioncolumn = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
        'template' => '',
        'buttonOptions' => ['class' => 'btn btn-default'],
        'pageSummary' => 'บาท',
    ];
} else {
    $actioncolumn = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'noWrap' => true,
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
        'template' => ' {update} {deletegpu}',
        'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:left'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'pageSummary' => 'บาท',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                            'class' => 'activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
                            //'data-target' => '#tpu-cont-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
                    'deletegpu' => function ($url, $model) {
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
                    <ul class="nav nav-tabs">
                        <li class="tab-success active">
                            <a data-toggle="tab" href="#home">
                                <?= Html::encode('บันทึกใบขอซื้อยาการค้า สัญญาจะซื้อจะขาย') ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content bg-white">
                        <div id="home" class="tab-pane in active">
                            <div class="well">
                                <div class="tb-pr2-temp-form">

                                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtemptpu_cont']); ?>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'PRNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'PRNum', ['showLabels' => false])->textInput([
                                                'maxlength' => true,
                                                //'readonly' => true,
                                                'style' => 'background-color:#ffff99'
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR, 'DepartmentID', ['label' => 'ฝ่าย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'DepartmentID', ['showLabels' => false])->dropdownList(
                                                    ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                                                'id' => 'ddl-department',
                                                'prompt' => 'Select Department...',
                                                'style' => 'background-color: White'
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelPR, 'PRDate', ['label' => 'วันที่' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'PRDate', ['showLabels' => false])->widget(DatePicker::classname(), [
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
                                        <?= Html::activeLabel($modelPR, 'SectionID', ['label' => 'แผนก' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'SectionID', ['showLabels' => false])->widget(DepDrop::classname(), [
                                                'options' => ['id' => 'ddl-section'],
                                                'data' => [$section],
                                                'pluginOptions' => [
                                                    'depends' => ['ddl-department'],
                                                    'url' => Url::to(['addpr-gpu/get-department']),
                                                    'style' => 'background-color: White'
                                                ]
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <input class="form-control" value="<?php echo $modelPR->prtype->PRType; ?>" readonly="" style="background-color: white"/>
                                        </div>
                                        <?= Html::activeLabel($modelPR, 'POTypeID', ['label' => 'ประเภทการสั่งซื้อ' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'POTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPotype::find()->where(['POTypeID' => 3])->all(), 'POTypeID', 'POType'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Option'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'PRStatusID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <input class="form-control" value="<?php echo $modelPR->prstatus->PRStatus; ?>" readonly="" style="background-color: white"/>
                                        </div>
                                        <?= Html::activeLabel($modelPR, 'PRExpectDate', ['label' => 'กำหนดเวลาการส่งมอบ(วัน)' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'PRExpectDate', ['showLabels' => false])->textInput([
                                                'style' => 'background-color:#ffff99',
                                                'type' => 'number',
                                                'required' => true
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'POContactNum', ['label' => 'เลขที่สัญญาจะซื้อจะขาย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'POContactNum', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPcplan::find()->where(['PCPlanTypeID' => 5])->all(), 'PCPOContactID', 'PCPOContactID'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Option'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])
                                            ?>
                                        </div>

                                        <label class="col-sm-2 control-label no-padding-right">ชื่อผู้ขาย</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="Vendorname" readonly="" style="background-color: white"/>
                                        </div>
                                    </div>
                                    <input class="form-control" type="hidden" id="VendorID" name="VendorID" readonly="" style="background-color: white"/>
                                    <?= $form->field($modelPR, 'ids_PR_selected', ['showLabels' => false])->hiddenInput() ?>
                                    <?= $form->field($modelPR, 'PRID', ['showLabels' => false])->hiddenInput() ?>

                                    <?php if ($modelPR['PRID'] == $decode) { ?>
                                        <div class="form-group">
                                            <a class="btn btn-success" id="getdatatpucont"><i class="glyphicon glyphicon-plus">เลือกรายการยาการค้า</i></a>
                                        </div>
                                    <?php } ?>

                                    <div class="form-group">
                                        <?php Pjax::begin([ 'id' => 'tpu_cont_pjax_id']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'responsiveWrap' => FALSE,
                                            'showPageSummary' => true,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => false,
                                            'condensed' => true,
                                            'toggleData' => false,
                                            'bordered' => FALSE,
                                            'layout' => "{summary}\n{items}\n{pager}",
                                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                            'rowOptions' => function($model) {
                                        if ($model->PRItemOnPCPlan == 1) {
                                            return ['class' => 'warning'];
                                        }
                                    },
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
                                                    'detailUrl' => Url::to(['details']),
                                                ],
                                                [
                                                    'attribute' => 'TMTID_TPU',
                                                    'header' => 'รหัสยาการค้า',
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
                                                return $model->detail->ItemName;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRQty',
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => 'center',
                                                    //'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'value' => function ($model) {
                                                return empty($model->detail->PRQty) ? '-' : number_format($model->detail->PRQty, 2);
                                            }
                                                ],
                                                [
                                                    'header' => 'ขอซื้อ',
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'PRUnitCost2',
                                                    //'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => 'center',
                                                    'value' => function ($model) {
                                                return empty($model->detail->PRUnitCost2) ? '-' : number_format($model->detail->PRUnitCost2, 2);
                                            }
                                                ],
                                                [
                                                    'label' => FALSE,
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'PRUnit',
                                                    //'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => 'center',
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                return empty($model->detail->PRUnit) ? '-' : $model->detail->PRUnit;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRExtendedCost',
                                                    'header' => 'ราคารวม',
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => 'center',
                                                    'format' => ['decimal', 2],
                                                    //'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'pageSummary' => true,
                                                    'value' => function ($model) {
                                                return empty($model->PRExtendedCost) ? '': $model->PRExtendedCost;
                                            }
                                                ],
                                                $actioncolumn,
                                                [
                                                    'class' => '\kartik\grid\DataColumn',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'width' => '10px',
                                                    'hidden' => true,
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
                                                                0 => ['style' => 'background-color: #ddd;color:black;'],
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
                                                <div class="col-sm-4">
                                                    <?=
                                                    $form->field($modelPR, 'PRReasonNote', ['showLabels' => false])->textarea([
                                                        'rows' => 3,
                                                        'style' => 'background-color:#ffff99',
                                                    ])
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: right">
                                        <?= Html::a('Close', ['addpr-gpu/index'], ['class' => 'btn btn-default']) ?>
                                        <?php if ($modelPR['PRID'] == $decode) { ?>
                                            <a class="btn btn-danger" id="Clear">Clear</a>
                                            <?= Html::submitButton($modelPR->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $modelPR->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'id' => 'SaveDraft', 'data-style' => 'expand-left']) ?>
                                            <a class="btn btn-info" id="SendtoVerify" onclick="SendtoVerify();">Save & Send To Verify</a>
                                        <?php } ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="horizontal-space"></div>
                    </div>
                </div>

                <?php if ($modelPR['PRID'] == $decode) { ?>
                    <?php
                    Modal::begin([
                        'id' => 'getdatatpucontmodal',
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
                        'id' => 'tpu-cont-modal',
                        'header' => '<h4 class="modal-title">บันทึกรายการยาสามัญ ใบขอซื้อ</h4>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => false,
                    ]);
                    ?>
                    <div id="data"></div>
                    <?php Modal::end(); ?>



                    <!--JS-->
                    <?php
                    $script = <<< JS
$('#getdatatpucont').click(function (e) {
    var e = document.getElementById("tbpr2temp-pocontactnum");
    var plannum = e.options[e.selectedIndex].text;
    var PRID = $("#tbpr2temp-prid").val();

    if (plannum == '' || plannum == 'Select Option') {
        swal({
            title: "",
            text: "กรุณาเลือกเลขที่สัญญาจะซื้อจะขาย!",
            type: "warning"
        });
    } else {
        LoadingClass();
        $.ajax({
            url: 'getdatatpu',
            type: 'GET',
            data: {id: plannum},
            dataType: 'json',
            success: function (data) {
                $.post(
                        'updatecontactnum',
                        {
                            POContactNum: plannum,PRID:PRID
                        },
                function (data)
                {
                    
                }
                );
                $('#getdatatpucontmodal').find('.modal-body').html(data);
                $('#datatpu').html(data);
                $('.modal-title').html('เลือกรายการยาการค้า');
                $('.page-content').waitMe('hide');
                $('#getdatatpucontmodal').modal('show');
                $('#getdatatpuconttable').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    "language": {
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
    }
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
                            
/* ClickEdit */
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-detailtpu',
                {
                    id: fID
                },
        function (data)
        { 
            $('#formdetailtpu_cont').trigger('reset');
            $('#tpu-cont-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาการค้า ใบขอซื้อ');
            $('.page-content').waitMe('hide');
            $('#tpu-cont-modal').modal('show');
            $('#cmd').val('2');
            $('#checkover').val('');
        }
        );
    });
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
                            'delete-detailtpu',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#tpu_cont_pjax_id'});
                    }
                    );
                }
            });
});
}
init_click_handlers(); //first run
$('#tpu_cont_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                                
                                
/* On SaveDraft */
    $('#formtemptpu_cont').on('beforeSubmit', function(e)
    {
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result != null)
            {
            //$(\$form).trigger('reset');
                    $('#tbpr2temp-prnum').val(result);
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
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
                
//On Change PRType
$(document).ready(function () {
    $('#tbpr2temp-prtypeid').on('change', function () {
        var PRType = $(this).find('option:selected').val();
        $.post({
            url: 'get-reasontpu', // your controller action
            dataType: 'json',
            data: {PRType: PRType},
            success: function (data) {
            if(data.htl == null){
                $('#TbPrReasonCheckbox').html('');
            }else{
                $('#TbPrReasonCheckbox').html(data.htl);
            }
                
            },
        });
    });
});
                                
/* Save Reason */
function Savereason() {
        var PRID = $("#tbpr2temp-prid").val();
        var reasonid = new Array();
        $('input[type=checkbox]').each(function () {
            if ($(this).is(':checked'))
            {
                reasonid.push($(this).val());
            }
        });
        //if (reasonid != "") {
            $.post(
                    'save-reason',
                    {
                        PRID: PRID, reasonid: reasonid
                    },
            function (data)
            {

            }
            );
   // }
}
                                
/* Clear */                                
$('#Clear').click(function (e) {
    var PRID = $("#tbpr2temp-prid").val();
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
                            'clear-tpu',
                            {
                                PRID: PRID
                            },
                    function (data)
                    {

                    }
                    );
                }
            });
});

$(document).ready(function () {
        $('#SendtoVerify').addClass("disabled", "disabled");
        GetVendorname();
});

/* get vendorname */
$('#tbpr2temp-pocontactnum').on('change', function () {
    var id = $(this).find("option:selected").val();
    if (id != "") {
        $.ajax({
            url: "getvdname-byplannum",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#Vendorname').val(data.VendorName);
                $('#VendorID').val(data.VendorID);
            }
        });
    }else{
                $('#Vendorname').val('');                
    }
});
                                
function GetVendorname() {
        var e = document.getElementById("tbpr2temp-pocontactnum");
        var id = e.options[e.selectedIndex].value;
        if (id != "") {
            $.ajax({
                url: "getvdname-byplannum",
                type: "post",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    $('#Vendorname').val(data.VendorName);
                    $('#VendorID').val(data.VendorID);
                }
            });
        }
    } 
JS;
                    $this->registerJs($script, \yii\web\View::POS_END, 'create');
                    ?>
                    <script>
                        function SelectTPU(d) {
                            var PRID = $("#tbpr2temp-prid").val();
                            var plan = (d.getAttribute("data-id"));
                            var id = (d.getAttribute("id"));
                            var ids_PR_selected = $("#tbpr2temp-ids_pr_selected").val();
                            LoadingClass();
                            $.ajax({
                                url: 'new-detailtpu',
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
                                        $('#formdetailtpu_cont').trigger("reset");
                                        $('#tpu-cont-modal').find('.modal-body').html(data);
                                        $('#data').html(data);
                                        $('.modal-title').html('บันทึกรายการยาการค้า ใบขอซื้อ');
                                        $('.page-content').waitMe('hide');
                                        $('#tpu-cont-modal').modal('show');
                                        $('#vwpritemdetail2temp-tmtid_tpu').val(id);
                                        $('#vwpritemdetail2temp-ids_pr_selected').val(ids_PR_selected);
                                        $('#vwpritemdetail2temp-prid').val(PRID);
                                        if (plan != "") {
                                            $("#vwpritemdetail2temp-pcplannum").val(plan).trigger("change");
                                        }
                                        $('#cmd').val('1');
                                    }
                                }
                            });
                        }
                        function SendtoVerify() {
                            var PRID = $("#tbpr2temp-prid").val();
                            var PRNum = $("#tbpr2temp-prnum").val();
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
                                                    'sendtoverify',
                                                    {
                                                        PRNum: PRNum, PRID: PRID
                                                    },
                                            function (data)
                                            {

                                            }
                                            );
                                        }
                                    });
                        }

                    </script> 
                <?php } ?>