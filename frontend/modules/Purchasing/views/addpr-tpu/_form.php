<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\TbPotype;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
#models
use app\models\TbDepartment;
use app\modules\Purchasing\models\TbPrbudget;
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
if ($view == 'view' || $view == 'true') {
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
} else if ($modelPR['PRID'] == $decode) {
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
                return Html::a('<span class="btn btn-primary btn-xs">Edit</span>', '#', [
                            'class' => 'activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
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
<style type="text/css">
    table#getdatatputable thead tr th{
        white-space: nowrap;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('บันทึกใบขอซื้อยาการค้า') ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-pr2-temp-form">

                            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtemptpu']); ?>

                            <div class="form-group" >
                                <?= Html::activeLabel($modelPR, 'PRNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR, 'PRNum', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
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
                                        'data' => ArrayHelper::map(TbPotype::find()->where(['POTypeID' => [1, 2, 4, 5, 6, 7, 8, 9]])->all(), 'POTypeID', 'POType'),
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
                                    <?=
                                            $form->field($modelPR, 'PRExpectDate', ['showLabels' => false])->
                                            input('number', ['min' => 0, 'style' => 'background-color:#ffff99', 'required' => true]);
                                    ?>
                                </div>
                            </div>
                            <?= $form->field($modelPR, 'ids_PR_selected', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelPR, 'PRID', ['showLabels' => false])->hiddenInput() ?>

                            <?php if ($modelPR['PRID'] == $decode) { ?>
                                <div class="form-group">
                                    <a class="btn btn-success" id="getdatatpu"><i class="glyphicon glyphicon-plus">เลือกรายการยาการค้า</i></a>
                                </div>
                            <?php } ?>

                            <div class="form-group">
                                <?php Pjax::begin(['id' => 'tpu_pjax_id']) ?>
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
                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;;color:black;']
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
                                            'detailUrl' => Url::to(['view-detailtpu']),
                                        ],
                                            [
                                            'attribute' => 'TMTID_TPU',
                                            'header' => 'รหัสยาการค้า',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => 'center',
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                                return '<kbd>' . $model->TMTID_TPU . '</kbd>';
                                            },
                                        ],
                                            [
                                            'header' => 'รายละเอียดยา',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'ItemName',
                                            'value' => function($model) {
                                                return $model->detail->ItemName;
                                            }
                                        ],
                                            [
                                            'attribute' => 'PROrderQty',
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => 'center',
                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                            'value' => function ($model) {
                                                return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 2);
                                            }
                                        ],
                                            [
                                            'attribute' => 'PRUnitCost',
                                            'header' => 'ขอซื้อ',
                                            'width' => '100px',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => 'center',
                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                            'value' => function ($model) {
                                                return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 2);
                                            }
                                        ],
                                            [
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'PRUnit',
                                            'hAlign' => 'center',
                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                            'pageSummary' => 'รวมเป็นเงิน.',
                                            'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:right'],
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
                                            'options' => ['style' => 'background-color: #f9f9f9'],
                                            'pageSummaryOptions' => ['class' => 'bg-white'],
                                            'format' => ['decimal', 2],
                                            'pageSummary' => true,
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
    </div>
</div>
<?php if ($modelPR['PRID'] == $decode) { ?>
    <!--Modal TPU-->

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
        'id' => 'tpu-modal',
        'header' => '<h4 class="modal-title">บันทึกรายการยาการค้า ใบขอซื้อ</h4>',
        'size' => 'modal-lg',
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
$(document).ready(function () {
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
                "bDestroy": true,
                "bAutoWidth": true,  
                "bFilter": true,
                "bSort": false, 
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
//ClickEdit
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
            $('#formdetailgpu').trigger('reset');
            $('#tpu-modal').find('.modal-body').html(data);
            $('#data').html(data);
            //$('.modal-title').html('ปรับปรุงรายการยาการค้า ใบขอซื้อ');
            $('.page-content').waitMe('hide');
            $('#tpu-modal').modal('show');
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
                        $.pjax.reload({container: '#tpu_pjax_id'});
                    }
                    );
                }
            });
});
}
init_click_handlers(); //first run
$('#tpu_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                                
//On Save
$('#formtemptpu').on('beforeSubmit', function (e)
{
    var l = $('.ladda-button').ladda();
    l.ladda('start');
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
                $('#tbpr2temp-prnum').val(result);
                $('#SendtoVerify').removeClass('disabled');
                swal({
                    title: "Save Complete!",
                    text: "",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                SaveReason();
                            }
                        });
            }
        })
        .fail(function ()
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
                                
//Save Reason
function SaveReason() {
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
}
                                
/*  Clear */
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
                data: {id: id, PRID: PRID, plan: plan},
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
                        $('#tpu-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        //$('.modal-title').html('บันทึกรายการยาการค้า ใบขอซื้อ');
                        //$('#notpack').html('<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>');
                        $('.page-content').waitMe('hide');
                        $('#tpu-modal').modal('show');
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