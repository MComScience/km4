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
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use app\modules\Purchasing\models\TbPrbudget;

use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\SweetAlertAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
SweetAlertAsset::register($this);

$decode = base64_decode($view);
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
        'pageSummary' => 'บาท',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                            'class' => 'activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
                            //'data-target' => '#gpu-modal',
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
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="tab-success active">
                            <a data-toggle="tab" href="#home">
                                <?= Html::encode('บันทึกใบขอซื้อยาสามัญ') ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content bg-white">
                        <div id="home" class="tab-pane in active">
                            <div class="well">
                                <div class="tb-pr2-form">
                                    <?php
                                    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtempgpu']);
                                    ?>
                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'PRNum', ['label' => 'เลขที่ใบขอซื้อ' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'PRNum', ['showLabels' => false])->textInput([
                                                'maxlength' => true,
                                                'style' => 'background-color:#ffff99'
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR, 'DepartmentID', ['label' => 'ฝ่าย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'DepartmentID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => '----- Select Option -----'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
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
                                                'data' => [$section],
                                                'options' => ['placeholder' => 'Select ...'],
                                                'type' => DepDrop::TYPE_SELECT2,
                                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                'pluginOptions' => [
                                                    'depends' => ['tbpr2temp-departmentid'],
                                                    'url' => Url::to(['child-department']),
                                                    'loadingText' => 'Loading...',
                                                ]
                                            ]);
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
                                                'data' => ArrayHelper::map(TbPotype::find()->where(['POTypeID' => [1, 2,4,5,6,7,8,9]])->all(), 'POTypeID', 'POType'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => '----- Select Option -----'],
                                                'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'PRbudgetID', ['label' => 'ประเภทงบประมาณ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'PRbudgetID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPrbudget::find()->all(), 'PRbudgetID', 'PRbudget'),
                                                'language' => 'th',
                                                'options' => ['placeholder' => '----- Select Option -----'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                ],
                                            ])
                                            ?>
                                        </div>

                                        <?= Html::activeLabel($modelPR, 'PRExpectDate', ['label' => 'กำหนดเวลาการส่งมอบ(วัน)' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?= $form->field($modelPR, 'PRExpectDate', ['showLabels' => false])->input('number', ['min' => 0, 'style' => 'background-color:#ffff99','required' => true,]);
                                            ?>
                                        </div>
                                    </div>

                                    <?= $form->field($modelPR, 'ids_PR_selected', ['showLabels' => false])->hiddenInput() ?>
                                    <?= $form->field($modelPR, 'PRID', ['showLabels' => false])->hiddenInput() ?>



                                    <div class="form-group">
                                        <?php if ($modelPR['PRID'] == $decode) { ?>
                                            <a class="btn btn-success" id="getdatagpu"><i class="glyphicon glyphicon-plus">เลือกรายการยาสามัญ</i></a>
                                            <p></p>
                                        <?php } ?>

                                        <?php Pjax::begin([ 'id' => 'gpu_pjax_id']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'responsiveWrap' => FALSE,
                                            'showPageSummary' => true,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => false,
                                            'condensed' => true,
                                            'bordered' => false,
                                            'toggleData' => false,
                                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                            'layout' => "{summary}\n{items}\n{pager}",
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
                                                    'width' => '33px',
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
                                                    'detailRowCssClass' => GridView::TYPE_SUCCESS,
                                                    'detailUrl' => Url::to(['details']),
                                                ],
                                                [
                                                    'attribute' => 'TMTID_GPU',
                                                    'header' => 'รหัสยาสามัญ',
                                                    'width' => '100px',
                                                    'noWrap' => true,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'format' => 'raw',
                                                        'value' => function ($model) {
                                                    return '<kbd>' . $model->TMTID_GPU . '</kbd>';
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
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                    return empty($model->detail->PRQty) ? '-' : number_format($model->detail->PRQty, 4);
                                                }
                                                ],
                                                [
                                                    'attribute' => 'PRUnitCost',
                                                    'header' => 'ขอซื้อ',
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                    return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 4);
                                                }
                                                ],
                                                [
                                                    'attribute' => 'PRUnit',
                                                    'label' => FALSE,
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'pageSummary' => 'รวมเป็นเงิน.',
                                                    'value' => function ($model) {
                                                    return empty($model->detail->PRUnit) ? '-' : $model->detail->PRUnit;
                                                }
                                                ],
                                                [
                                                    'header' => 'ราคารวม',
                                                    'attribute' => 'PRExtendedCost',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'format' => ['decimal', 4],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'pageSummary' => true,
                                                    'value' => function ($model) {
                                                    return $model->PRExtendedCost;
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
                                                        echo $reason;
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
                                        <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                                        <?php if ($modelPR['PRID'] == $decode) { ?>
                                            <!-- <a class="btn btn-danger" id="Clear">Clear</a> -->
                                            <?= Html::submitButton($modelPR->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $modelPR->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'id' => 'SaveDraft', 'data-style' => 'expand-left']) ?> 
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
                        'id' => 'getdatagpumodal',
                        'header' => '<h4 class="modal-title">เลือกยาสามัญ</h4>',
                        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => false,
                    ]);
                    ?>
                    <div id="datagpu"></div>
                    <?php Modal::end(); ?>
                    <?php
                    Modal::begin([
                        'id' => 'gpu-modal',
                        'header' => '<h4 class="modal-title">บันทึกรายการยาสามัญ ใบขอซื้อ</h4>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => false,
                    ]);
                    ?>
                    <div id="data"></div>
                    <?php Modal::end();
                    ?>
                    <!--JS-->
                    <?php
                    $script = <<< JS

/* Disable ปุ่ม Send To Verify */
$(document).ready(function () {
    var PRNUM = $("#tbpr2temp-prnum").val();
   // document.getElementById("SaveDraft").disabled = true;
    $('#SendtoVerify').addClass("disabled", "disabled");

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
                            
/* เรียกใช้ Modal เลือกยาสามัญ */
$(function () {
    $('#getdatagpu').click(function (e) {
        var check = $("#datagpu").val();
        if (check != '') {
            $('#getdatagpumodal').modal('show');
        } else {
            LoadingClass();
            $.ajax({
                url: 'getdatagpu',
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#getdatagpumodal').find('.modal-body').html(data);
                    $('#datagpu').html(data);
                    $('.modal-title').html('เลือกยาสามัญ');
                    $('.page-content').waitMe('hide');
                    $('#getdatagpumodal').modal('show');
                    $('.modal-header').addClass("bordered-success");
                    $('#getdatagputable').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 5,
                        responsive: true,
                        "bDestroy": true,
                        "bAutoWidth": true,  
                        "bFilter": true,
                        "bSort": false, 
                        "aaSorting": [[0]],
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
});

/* Function แก้ไข,ลบ ข้อมูลที่บันทึกลงตาราง */
function init_click_handlers() {
    /* Edit */
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-detailgpu',
                {
                    id: fID
                },
        function (data)
        {
            $('#formdetailgpu').trigger('reset');
            $('#gpu-modal').find('.modal-body').html(data);
            $('.modal-header').addClass("bordered-success");
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาสามัญ ใบขอซื้อ');
            $('.page-content').waitMe('hide');
            $('#gpu-modal').modal('show');
            $('#cmd').val('2');
            $('#checkover').val('');
        }
        );
    });
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-detailgpu',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#gpu_pjax_id'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#gpu_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});

/* Savedraft */
$('#formtempgpu').on('beforeSubmit', function (e)
{
    // var selector = '.steps #wiredstep1';
    var l = $( '.ladda-button' ).ladda();
    l.ladda( 'start' );
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            
            .done(function(result) {
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
               // $('#tbpr2temp-prnum').val(result);
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
//                l.ladda('stop');
//                swal("Save Complete!", "", "success");
            }
        })
        .fail(function ()
        {
            console.log('server error');
        })
        .always(function() { 
           // l.ladda('stop');
           // Notify('SaveDraft Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
        });
        return false;
});
        
/* Query เหตุผลการขอซื้อตามประเภทใบขอซื้อที่เลือก */
$('#tbpr2temp-prtypeid').on('change', function () {
    var PRType = $(this).find('option:selected').val();
    $.ajax({
        url: 'get-reasongpu',
        type: 'POST',
        data: {PRType: PRType},
        dataType: 'json',
        success: function (data) {
            if (data.htl == null) {
                $('#TbPrReasonCheckbox').html('');
            } else {
                $('#TbPrReasonCheckbox').html(data.htl);
            }
        }
    });
});
                                    
$('#tbpr2temp-potypeid').on('change', function () {
    document.getElementById("SaveDraft").disabled = false;
});

/* Save เหตุผลการขอซื้อเมื่อกด SaveDraft */
function Savereason() {
    var PRID = $("#tbpr2temp-prid").val();
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

/* Clear ข้อมูลเมื่อกดปุ่ม Clear */
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
                            'clear-gpu',
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
 


JS;
                    $this->registerJs($script, \yii\web\View::POS_END, 'create');
                    ?>

                    <script>
                        /* Function เลือกยาสามัญ */
                        function SelectGPU(id) {
                            var PRID = $("#tbpr2temp-prid").val();
                            var plan = (id.getAttribute("data-id"));
                            var gpu = (id.getAttribute("id"));
                            var ids_PR_selected = $("#tbpr2temp-ids_pr_selected").val();
                            LoadingClass();
                            $.ajax({
                                url: 'new-detailgpu',
                                type: 'POST',
                                data: {id: gpu, PRID: PRID, plan: plan},
                                success: function (data) {
                                    if (data == 'false') {
                                        swal({
                                            title: "",
                                            text: "รหัสยาสามัญนี้ถูกบันทึกแล้ว!",
                                            type: "warning"
                                        });
                                        $('.page-content').waitMe('hide');
                                    } else {
                                        $('#formdetailgpu').trigger("reset");
                                        $('#gpu-modal').find('.modal-body').html(data);
                                        $('#data').html(data);
                                        //$('.modal-title').html('บันทึกรายการยาสามัญ ใบขอซื้อ');
                                        //$('#notpack').html('<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>');
                                        $('.page-content').waitMe('hide');
                                        $('#gpu-modal').modal('show');
                                        $('#vwpritemdetail2temp-tmtid_gpu').val(gpu);
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

                        /* เรียกใช้ Modal */
                        function ShowdataGPU() {
                            $('#modaldata-gpu').modal('show');
                        }

                        /* Function ส่งใบขอซื้อไป verify */
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
               




