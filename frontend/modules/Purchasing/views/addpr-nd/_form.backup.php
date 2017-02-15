<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$decode = base64_decode($view);
if ($view == 'view') {
    $actioncolumn = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'noWrap' => true,
        'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
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
        'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
        'template' => ' {update} {deletegpu}',
        'buttonOptions' => ['class' => 'btn btn-default'],
        'pageSummary' => 'บาท',
        'buttons' => [
            'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                            'class' => 'activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
                            'data-target' => '#tpu-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
                ]);
            },
                    'deletegpu' => function ($url, $model) {
                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //'title' => Yii::t('app', 'Delete'),
                            'data-toggle' => 'modal',
                            //'data-method' => "post",
                            //'role' => 'modal-remote',
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
                                <?= Html::encode('บันทึกใบขอซื้อเวชภัณฑ์') ?>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content bg-white">
                        <div id="home" class="tab-pane in active">
                            <div class="well">
                                <div class="tb-pr2-temp-form">

                                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtempnd']); ?>

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
                                                    yii\helpers\ArrayHelper::map(app\models\TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
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
                                            $form->field($modelPR, 'PRDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
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
                                            $form->field($modelPR, 'SectionID', ['showLabels' => false])->widget(\kartik\widgets\DepDrop::classname(), [
                                                'options' => ['id' => 'ddl-section'],
                                                'data' => [$section],
                                                'pluginOptions' => [
                                                    'depends' => ['ddl-department'],
                                                    'url' => \yii\helpers\Url::to(['addpr-gpu/get-department']),
                                                    'style' => 'background-color: White'
                                                ]
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3"> 
                                            <?php
                                            $queryprtype = app\models\TbPrtype::findOne(['PRTypeID' => $modelPR['PRTypeID']]);
                                            ?>
                                            <input class="form-control" value="<?php echo $queryprtype['PRType']; ?>" readonly="" style="background-color: white"/>
                                        </div>
                                        <?= Html::activeLabel($modelPR, 'POTypeID', ['label' => 'ประเภทการสั่งซื้อ' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'POTypeID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                                'data' => yii\helpers\ArrayHelper::map(app\models\TbPotype::find()->where(['POTypeID' => [1, 2]])->all(), 'POTypeID', 'POType'),
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
                                            <?php
                                            $queryprstatus = app\models\TbPrstatus::findOne(['PRStatusID' => $modelPR['PRStatusID']]);
                                            ?>
                                            <input class="form-control" value="<?php echo $queryprstatus['PRStatus']; ?>" readonly="" style="background-color: white"/>
                                        </div>
                                        <?= Html::activeLabel($modelPR, 'PRExpectDate', ['label' => 'กำหนดเวลาการส่งมอบ(วัน)' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR, 'PRExpectDate', ['showLabels' => false])->textInput([
                                                'style' => 'background-color:#ffff99',
                                                'type' => 'number'
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                    <?= $form->field($modelPR, 'ids_PR_selected', ['showLabels' => false])->hiddenInput() ?>
                                    <?= $form->field($modelPR, 'PRID', ['showLabels' => false])->hiddenInput() ?>

                                    <?php if ($modelPR['PRNum'] == $decode) { ?>
                                        <div class="form-group">
                                            <a class="btn btn-success" id="getdatand"><i class="glyphicon glyphicon-plus">เลือกรายการเวชภัณฑ์</i></a>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <?php \yii\widgets\Pjax::begin([ 'id' => 'nd_pjax_id']) ?>
                                        <?=
                                        kartik\grid\GridView::widget([
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
                                            'toggleData' => false,
                                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                            'layout' => "{summary}\n{items}\n{pager}",
                                            'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_SUCCESS],
                                            'rowOptions' => function($model) {
                                        if ($model->PROrderQty > $model->PRItemAvalible && $model->PRItemOnPCPlan == 1) {
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
                                                        return kartik\grid\GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;'],
                                                    'expandOneOnly' => true,
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                                    'detailUrl' => \yii\helpers\Url::to(['view-detailnd']),
                                                ],
                                                [
                                                    'header' => 'รหัสสิน้คา',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'ItemID',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                ],
                                                [
                                                    'header' => 'รายละเอียดสินค้า',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'ItemName',
                                                    'value' => function($model) {
                                                return $model->detail->ItemName;
                                            }
                                                ],
                                                [
                                                    'label' => '',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'PRQty',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                if ($model->detail->PRQty == 0) {
                                                    return '-';
                                                } else {
                                                    return number_format($model->detail->PRQty, 2);
                                                }
                                            }
                                                ],
                                                [
                                                    'header' => 'ขอซื้อ',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'PRUnitCost',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                if ($model->PRUnitCost == 0) {
                                                    return '-';
                                                } else {
                                                    return number_format($model->PRUnitCost, 2);
                                                }
                                            }
                                                ],
                                                [
                                                    'label' => '',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'PRUnit',
                                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                    'value' => function ($model) {
                                                if ($model->detail->PRUnit == NULL) {
                                                    return '-';
                                                } else {
                                                    return $model->detail->PRUnit;
                                                }
                                            }
                                                ],
                                                [
                                                    'header' => 'ราคารวม',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'PRExtendedCost',
                                                    'hAlign' => 'right',
                                                    'format' => ['decimal', 2],
                                                    'pageSummary' => true,
                                                    'value' => function ($model) {
                                                return $model->PROrderQty * $model->PRUnitCost;
                                            }
                                                ],
                                                $actioncolumn,
                                                [
                                                    'class' => '\kartik\grid\DataColumn',
                                                    'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
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
                                                <?php \yii\widgets\Pjax::end() ?>
                                            </div>


                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right">เหตุผลการขอซื้อ</label>
                                                <div class="col-sm-4">
                                                    <div id="TbPrReasonCheckbox">
                                                        <?php
                                                        echo $htl_checkbox;
                                                        ?>
                                                    </div>
                                                    <br> 
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right">อื่นๆ</label>
                                                <div class="col-sm-4">
                                                    <?=
                                                    $form->field($modelPR, 'PRReasonNote', ['showLabels' => false])->textarea([
                                                        'rows' => 3,
                                                        'style' => 'background-color:white',
                                                    ])
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: right">
                                        <?= Html::a('Close', ['addpr-gpu/index'], ['class' => 'btn btn-default']) ?>
                                        <?php if ($modelPR['PRNum'] == $decode) { ?>
                                            <a class="btn btn-danger" id="Clear">Clear</a>
                                            <?= Html::submitButton($modelPR->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $modelPR->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'id' => 'SaveDraft', 'data-style' => 'expand-left']) ?>
                                            <a class="btn btn-info" onclick="SendtoVerify();" id="SendtoVerify">Save & Send To Verify</a>
                                        <?php } ?>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="horizontal-space"></div>
                    </div>
                </div>

                <?php if ($modelPR['PRNum'] == $decode) { ?>
                    <?php
                    \yii\bootstrap\Modal::begin([
                        'id' => 'getdatandmodal',
                        'header' => '<h4 class="modal-title">เลือกรายการเวชภัณฑ์</h4>',
                        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => false,
                    ]);
                    ?>
                    <div id="datand"></div>
                    <?php \yii\bootstrap\Modal::end(); ?>

                    <?php
                    \yii\bootstrap\Modal::begin([
                        'id' => 'nd-modal',
                        'header' => '<h4 class="modal-title">บันทึกรายการเวชภัณฑ์ ใบขอซื้อ</h4>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => false,
                    ]);
                    ?>
                    <div id="data"></div>
                    <?php \yii\bootstrap\Modal::end(); ?>


                    <?php
                    $script = <<< JS

$('#getdatand').click(function (e) {
    $.ajax({
        url: 'index.php?r=Purchasing/addpr-nd/getdatand',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#getdatandmodal').find('.modal-body').html(data);
            $('#datand').html(data);
            $('.modal-title').html('เลือกรายการเวชภัณฑ์');
            $('#getdatandmodal').modal('show');
            $('#getdatandtable').DataTable({
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
});
                                
/* ClickEdit */
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $.get(
                'index.php?r=Purchasing/addpr-nd/update-detailnd',
                {
                    id: fID
                },
        function (data)
        { 
            $('#formdetailnd').trigger('reset');
            $('#nd-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการเวชภัณฑ์ ใบขอซื้อ');
            $('#nd-modal').modal('show');
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
        confirmButtonColor: "#DD6B55",
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'index.php?r=Purchasing/addpr-nd/delete-detailnd',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#nd_pjax_id'});
                    }
                    );
                }
            });
});
}
init_click_handlers(); //first run
$('#nd_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                                
/*  Clear */
$('#Clear').click(function (e) {
    var PRID = $("#tbpr2temp-prid").val();
    swal({
        title: "Are you sure?",
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
                            'index.php?r=Purchasing/addpr-nd/clear-nd',
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

/* On Save */
$('#formtempnd').on('beforeSubmit', function (e)
{
    var l = $('.ladda-button').ladda();
    l.ladda('start');
            var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == '1')
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
        });
        return false;
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
            'index.php?r=Purchasing/addpr-nd/save-reason',
            {
                PRID: PRID, reasonid: reasonid
            },
    function (data)
    {

    }
    );
}
                                
/* On Change PRType */
$(document).ready(function () {
    $('#SendtoVerify').addClass("disabled", "disabled");
    $('#tbpr2temp-prtypeid').on('change', function () {
        var PRType = $(this).find('option:selected').val();
        $.post({
            url: 'index.php?r=Purchasing/addpr-nd/get-reasonnd', // your controller action
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
JS;
                    $this->registerJs($script);
                    ?>
                    <script>
                        function SelectND(d) {
                            var PRID = $("#tbpr2temp-prid").val();
                            var plan = (d.getAttribute("data-id"));
                            var id = (d.getAttribute("id"));
                            var ids_PR_selected = $("#tbpr2temp-ids_pr_selected").val();
                            $.ajax({
                                url: 'index.php?r=Purchasing/addpr-nd/new-detailnd',
                                type: 'POST',
                                data: {id: id, PRID: PRID},
                                success: function (data) {
                                    if (data == 'false') {
                                        swal({
                                            title: "",
                                            text: "รหัสสินค้านี้ถูกบันทึกแล้ว!",
                                            type: "warning"
                                        });
                                    } else {
                                        $('#formdetailnd').trigger("reset");
                                        $('#nd-modal').find('.modal-body').html(data);
                                        $('#data').html(data);
                                        $('.modal-title').html('บันทึกรายการเวชภัณฑ์ ใบขอซื้อ');
                                        //$('#notpack').html('<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>');
                                        $('#nd-modal').modal('show');
                                        $('#vwpritemdetail2temp-itemid').val(id);
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
                                                    'index.php?r=Purchasing/addpr-nd/sendtoverify',
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