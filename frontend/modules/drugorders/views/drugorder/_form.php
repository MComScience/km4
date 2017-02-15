<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
#models
use app\modules\drugorders\models\Tbcpoescheduletype;
use app\models\TbSection;
use app\modules\drugorders\models\Tbcpoestatus;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
?>
<style>
    table#datatables_w2 thead tr th{
        background-color: #ddd;
        text-align: center;
    }
    div#solution-modal .modal-content {
        /* new custom width */
        width: 1222px;
        /* must be half of the width, minus scrollbar on the left (30px) */
        margin-left: -140px;
    }
</style>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <?php
        $form = ActiveForm::begin([
                    'type' => ActiveForm::TYPE_VERTICAL,
                    'action' => Url::to(['save-cpoe']),
                    'id' => 'fromcpoe',
        ]);
        ?>
        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-2">
                <?= $form->field($model, 'cpoe_num')->textInput(['maxlength' => true, 'readonly' => true,])->label('เลขที่ใบสั่งยา') ?>


            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-2">
                <?=
                $form->field($model, 'cpoe_date')->widget(DatePicker::classname(), [
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
                ])->label('วันที่')
                ?>  
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-2">
                <?= $form->field($model, 'cpoe_order_by')->textInput(['maxlength' => true])->label('แพทย์') ?>


            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-2">
                <?=
                $form->field($model, 'cpoe_order_section')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TbSection::find()->all(), 'SectionID', 'SectionDecs'),
                    'language' => 'en',
                    'options' => ['placeholder' => 'Select Options'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])->label('แผนก')
                ?> 
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-0 col-sm-2">
                <?=
                $form->field($model, 'cpoe_status')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Tbcpoestatus::find()->all(), 'cpoe_status_id', 'cpoe_status_decs'),
                    'pluginOptions' => ['allowClear' => true],
                    'options' => ['placeholder' => 'Select state...', 'disabled' => true]
                ])->label('สถานะคำสั่ง');
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12 col-sm-6 col-md-12">
                <?=
                Html::a('Select Package', ['create-details', 'cpoeid' => $model->cpoe_id, 'vn_number' => $model->pt_vn_number], ['role' => 'modal-remote', 'title' => 'Select Package', 'class' => 'btn btn-warning',]) . ' ' .
                Html::a('<i class="glyphicon glyphicon-plus"></i> เปิดเส้น', ['create-keep-vein', 'cpoeid' => $model->cpoe_id, 'vn_number' => $model->pt_vn_number], ['role' => 'modal-remote', 'title' => 'เปิดเส้น', 'class' => 'btn btn-success',]) . ' ' .
                Html::a('<i class="glyphicon glyphicon-plus"></i> Premedication', ['create-premedication', 'cpoeid' => $model->cpoe_id, 'vn_number' => $model->pt_vn_number], ['role' => 'modal-remote', 'title' => 'Premediction', 'class' => 'btn btn-success',]) . ' ' .
                Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'IV Solution', 'javascript:void(0);', ['class' => 'btn btn-warning', 'onclick' => 'GetmodalSolution(this);']) . ' ' .
                Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'ยา', ['create-details', 'cpoeid' => $model->cpoe_id, 'vn_number' => $model->pt_vn_number], ['role' => 'modal-remote', 'title' => 'Create new Tbcpoes', 'class' => 'btn btn-success',]) . ' ' .
                Html::a('<i class="glyphicon glyphicon-plus"></i> ' . 'เวชภัณฑ์', '#', ['class' => 'btn btn-success', 'onclick' => 'return false']);
                ?>
                <p></p>
                <div class="well">
                    <?php Pjax::begin(['id' => 'pjax-tbcpoedetails']); ?>
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'showPageSummary' => true,
                        'responsive' => true,
                        'layout' => $layout,
                        'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                        'tableOptions' => [
                            'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed',
                        ],
                        'columns' => [
                            [
                                'class' => '\kartik\grid\SerialColumn',
                                'width' => '25px',
                            ],
                            [
                                'class' => 'kartik\grid\ExpandRowColumn',
                                'value' => function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;'],
                                'expandOneOnly' => true,
                                'detailAnimationDuration' => 'slow', //fast
                                'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                'detailUrl' => Url::to(['rxdetails']),
                            ],
                            [
                                'header' => 'cpoe_ids',
                                'attribute' => 'cpoe_ids',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($model, $key, $index) {
                            return empty($model->cpoe_ids) ? '-' : $model->cpoe_ids;
                        },
                            ],
                            [
                                'header' => 'ลำดับ',
                                'attribute' => 'cpoe_seq',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($model, $key, $index) {
                            return empty($model->cpoe_seq) ? '-' : $model->cpoe_seq;
                        },
                            ],
                            [
                                'header' => 'cpoe_parentid',
                                'attribute' => 'cpoe_parentid',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($model, $key, $index) {
                            return empty($model->cpoe_parentid) ? '-' : $model->cpoe_parentid;
                        },
                            ],
                            [
                                'header' => 'cpoe_itemtype_decs',
                                'attribute' => 'cpoe_itemtype_decs',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($model, $key, $index) {
                            return empty($model->cpoe_itemtype_decs) ? '-' : $model->cpoe_itemtype_decs;
                        },
                            ],
                            [
                                'header' => 'รหัสสินค้า',
                                'attribute' => 'ItemID',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($model, $key, $index) {
                            return empty($model->ItemID) ? '-' : $model->ItemID;
                        },
                            ],
                            [
                                'header' => 'รายการ',
                                'attribute' => 'ItemDetail',
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function($model, $key, $index) {
                            return empty($model->ItemDetail) ? '-' : $model->ItemDetail;
                        },
                            ],
                            [
                                'header' => 'จำนวน',
                                'attribute' => 'ItemQty1',
                                'contentOptions' => ['class' => 'text-center'],
                                'noWrap' => true,
                                'value' => function($model, $key, $index) {
                            return empty($model->ItemQty1) ? '-' : $model->ItemQty1;
                        },
                            ],
                            [
                                'header' => 'ราคา/หน่วย',
                                'attribute' => 'ItemPrice',
                                'contentOptions' => ['class' => 'text-right'],
                                'noWrap' => true,
                                'pageSummary' => 'รวม',
                                'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                'value' => function($model, $key, $index) {
                            return empty($model->ItemPrice) ? '-' : number_format($model->ItemPrice, 2);
                        },
                            ],
                            [
                                'header' => 'จำนวนเงิน',
                                'attribute' => 'Item_Amt',
                                'contentOptions' => ['class' => 'text-right'],
                                'noWrap' => true,
                                'format' => ['decimal', 2],
                                'pageSummary' => true,
                                'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                'value' => function($model, $key, $index) {
                            return empty($model->Item_Amt) ? '' : $model->Item_Amt;
                        },
                            ],
                            [
                                'header' => 'เบิกได้',
                                'attribute' => 'Item_Cr_Amt_Sum',
                                'contentOptions' => ['class' => 'text-right'],
                                'noWrap' => true,
                                'format' => ['decimal', 2],
                                'pageSummary' => true,
                                'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                'value' => function($model, $key, $index) {
                            return empty($model->Item_Cr_Amt_Sum) ? '' : $model->Item_Cr_Amt_Sum;
                        },
                            ],
                            [
                                'header' => 'เบิกไม่ได้',
                                'attribute' => 'Item_Pay_Amt_Sum',
                                'contentOptions' => ['class' => 'text-right'],
                                'noWrap' => true,
                                'format' => ['decimal', 2],
                                'pageSummary' => true,
                                'pageSummaryOptions' => ['style' => 'text-align:right;'],
                                'value' => function($model, $key, $index) {
                            return empty($model->Item_Pay_Amt_Sum) ? '' : $model->Item_Pay_Amt_Sum;
                        },
                            ],
                            [
                                'class' => '\kartik\grid\ActionColumn',
                                'contentOptions' => ['class' => 'text-center', 'noWrap' => true,],
                                'template' => '{update} {delete}',
                                'noWrap' => true,
                                'header' => 'Actions',
                                'buttons' => [
                                    'update' => function ($key, $model) {
                                        if ($model['cpoe_Itemtype'] == '50') {
                                            return Html::a('Edit', 'javascript:void(0);', [
                                                        'title' => 'Edit',
                                                        'onclick' => 'EditIVSolution(' . $model['cpoe_ids'] . ');',
                                                        'class' => 'btn btn-info btn-xs'
                                            ]);
                                        } else {
                                            $url = ['edit-details', 'id' => $model['cpoe_ids']];
                                            return Html::a('<span class="btn btn-info btn-xs btn-group tooltip-lg"> Edit </span>', $url, [
                                                        'title' => 'Edit',
                                                        //'data-toggle' => 'tooltip',
                                                        'data-placement' => 'top',
                                                        'data-original-title' => 'Edit',
                                                        'role' => 'modal-remote',
                                            ]);
                                        }
                                    },
                                            'delete' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                    'title' => 'Delete',
                                                    'data-toggle' => 'modal',
                                                    'class' => 'activity-delete-link',
                                        ]);
                                    },
                                        ],
                                    ],
                                ],
                            ]);
                            ?>
                            <?php Pjax::end(); ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-5">
                                <?= $form->field($model, 'cpoe_comment')->textarea(['rows' => 3, 'cols' => 5, 'style' => 'background-color: #ffff99'])->label('หมายเหตุ') ?>
                            </div>
                        </div>

                    </div>
                    <!--                    <div class="col-sm-offset-0 col-sm-3">
                                            <br/><br/>
                                            <div class="well">
                                                <div class="row">
                                                    <div class="databox databox-lg radius-bordered databox-shadowed databox-graded">
                                                        <div class="databox-left bg-palegreen">
                                                            <div class="databox-piechart">
                                                                <div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="50" data-animate="500" data-linewidth="3" data-size="60" data-trackcolor="#aadc95"><span class="white font-90">50%</span></div>
                                                            </div>
                                                        </div>
                                                        <div class="databox-right bg-white">
                                                            <span class="databox-number green">0 บาท</span>
                                                            <div class="databox-text darkgray" style="font-size: 14pt;">Normal Cost</div>
                                                            <div class="databox-stat bg-palegreen radius-bordered">
                                                                <div class="stat-text">50</div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>-->
                </div>

                <div class="row"></div>

                <div class="form-group">
                    <div class="col-sm-offset-0 col-sm-3">

                    </div>
                    <?= $form->field($model, 'cpoe_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($model, 'pt_vn_number')->hiddenInput()->label(false) ?>
                </div>

                <div class="form-group" style="text-align: right">
                    <div class="col-sm-12">
                        <?= Html::a('Close', Url::to(['/cpoes']), ['class' => 'btn btn-default']); ?>
                        <?= Html::a('Save Package', 'javascript:void(0);', ['class' => 'btn btn-success']); ?>
                        <?= Html::submitButton($model->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => 'expand-left']) ?>
                        <?= Html::button('Sign', [ 'class' => 'btn btn-info', 'id' => 'btnSign']); ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php
        $title = '<i class="glyphicon glyphicon-user"></i>' . $modelheader->pt_name . ' | ' . '<span class="success">อายุ</span> ' .
                $modelheader->pt_age_registry_date . ' <span class="success">ปี</span>' . ' | ' .
                ' <span class="success">HN</span> ' . $modelheader->pt_hospital_number . ' | ' .
                ' <span class="success">VN</span> ' . $modelheader->pt_vn_number . ' | ' .
                ' <span class="success">AN</span> ' . $modelheader->pt_admission_number . '&nbsp;&nbsp;';
        Modal::begin([
            'id' => 'solution-modal',
            'header' => '<h4 class="modal-title">' . 'IV Solution' . ' <span class="pull-right"> ' . $title . ' </span> ' . '</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                //'closeButton' => false,
        ]);
        ?>
        <div id="data"></div>
        <?php Modal::end(); ?>

        <?php
        $script = <<< JS
/* Function แก้ไข,ลบ ข้อมูลที่บันทึกลงตาราง */
function init_click_handlers() {
    /* Delete */
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=cpoes/drugorder/delete-details',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#pjax-tbcpoedetails'});
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#pjax-tbcpoedetails').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});

   //Sign
$("#btnSign").click(function () {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        swal({
            title: "Are you sure sign?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "index.php?r=cpoes/drugorder/rxsave",
                            type: "post",
                            data: {id: cpoeid},
                            dataType: "JSON",
                            success: function (data) {

                            }
                        });
                    }
                });
    });
                
/* Savedraft */
    $('#fromcpoe').on('beforeSubmit', function (e)
    {
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        var form = $(this);
        $.post(
                form.attr('action'), // serialize Yii2 form
                form.serialize()
                )

                .done(function (result) {
                    if (result != "")
                    {
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
                                        $('#tbcpoe-cpoe_num').val(result);
                                        l.ladda('stop');
                                        swal("Save Complete!", "", "success");
                                    }
                                });
                    }
                })
                .fail(function ()
                {
                    console.log('server error');
                })
        return false;
    });
InitiateEasyPieChart.init();
JS;
        $this->registerJs($script, \yii\web\View::POS_END, 'index');
        ?>
<script>
    function GetmodalSolution() {
        var cpoeid = $('#tbcpoe-cpoe_id').val();
        $.ajax({
            url: 'index.php?r=cpoes/drugorder/ivsolution',
            type: 'get',
            data: {cpoeid: cpoeid},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');

            }
        });
    }

    function EditIVSolution(id) {
        $.ajax({
            url: 'index.php?r=cpoes/drugorder/edit-ivsolution',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#solution-modal').find('.modal-body').html(data);
                $('#data').html(data);
                $('#solution-modal').modal('show');
            }
        });
    }
</script>

