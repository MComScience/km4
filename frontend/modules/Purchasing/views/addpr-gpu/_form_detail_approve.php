<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;

$val = base64_decode($view);
if ($view == 'wating-approve') {
    $this->title = 'ใบขอซื้อรอการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-wating-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-wating-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อยาสามัญ', 'url' => ['list-wating-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($modelPR2['PRNum'] == $val) {
    $this->title = 'อนุมัติใบขอซื้อยาสามัญ';
    $this->params['breadcrumbs'][] = ['label' => 'ผู้อำนวยการ', 'url' => ['detail-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'อนุมัติใบขอซื้อ', 'url' => ['detail-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'reject-approve') {
    $this->title = 'ใบขอซื้อไม่ผ่านการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-reject-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-reject-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อยาสามัญ', 'url' => ['list-reject-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'approve') {
    $this->title = 'ใบขอซื้อผ่านการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อยาสามัญ', 'url' => ['list-approve']];
    $this->params['breadcrumbs'][] = $this->title;
}

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
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
                        <div class="tb-pr2-form">
                            <?php
                            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-detail-approve']);
                            ?>

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
                                            yii\helpers\ArrayHelper::map(app\models\TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                                        'id' => 'ddl-department',
                                        'prompt' => 'Select Department...',
                                        'style' => 'background-color: White',
                                        'disabled' => true,
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?= Html::activeLabel($modelPR2, 'PRDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR2, 'PRDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                        'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white',
                                            'disabled' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR2, 'SectionID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR2, 'SectionID', ['showLabels' => false])->widget(\kartik\widgets\DepDrop::classname(), [
                                        'options' => ['id' => 'ddl-section'],
                                        'data' => [$section],
                                        'disabled' => true,
                                        'pluginOptions' => [
                                            'depends' => ['ddl-department'],
                                            'url' => \yii\helpers\Url::to(['addpr-gpu/get-department']),
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
                                    $form->field($modelPR2, 'PRTypeID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\models\TbPrtype::find()->where(['PRTypeID' => $modelPR2['PRTypeID']])->all(), 'PRTypeID', 'PRType'),
                                        'pluginOptions' => [
                                            'placeholder' => 'Select Option',
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR2, 'POTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR2, 'POTypeID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\models\TbPotype::find()->where(['POTypeID' => $modelPR2['POTypeID']])->all(), 'POTypeID', 'POType'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="form-group" >
                                <?= Html::activeLabel($modelPR2, 'PRStatusID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR2, 'PRStatusID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\models\TbPrstatus::find()->where(['PRStatusID' => $modelPR2['PRStatusID']])->all(), 'PRStatusID', 'PRStatus'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                            'disabled' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR2, 'PRExpectDate', ['label' => 'กำหนดเวลาการส่งมอบ(วัน)', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR2, 'PRExpectDate', ['showLabels' => false])->textInput([
                                        'style' => 'background-color:white',
                                        'readonly' => true
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <h5 class="row-title before-success">รายละเอียดใบขอซื้อ</h5>
                                <?php //\yii\widgets\Pjax::begin([ 'id' => 'verify_pjax_id'])  ?>
                                <?php
                                //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                                ?>
                                <?=
                                GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'showPageSummary' => true,
                                    'responsiveWrap' => FALSE,
                                    'hover' => true,
                                    'pjax' => true,
                                    'striped' => false,
                                    'condensed' => true,
                                    'bordered' => false,
                                    'tableOptions' => ['class' => GridView::TYPE_DEFAULT],
                                    'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
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
                                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;;color:black;'],
                                            'expandOneOnly' => true,
                                            'detailAnimationDuration' => 'slow', //fast
                                            'detailRowCssClass' => GridView::TYPE_SUCCESS,
                                            'detailUrl' => Url::to(['details-verify-approve']),
                                        ],
                                        [
                                            'attribute' => 'TMTID_GPU',
                                            'header' => 'รหัสสินค้า',
                                            'format' => 'raw',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        return empty($model['TMTID_GPU']) ? '-' : '<kbd>' . $model->TMTID_GPU . '</kbd>';
                                    }
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
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => GridView::ALIGN_RIGHT,
                                            'value' => function ($model) {
                                        return empty($model->dataonview->PRQty) ? NULL : number_format($model->dataonview->PRQty, 4);
                                    }
                                        ],
                                        [
                                            'header' => 'ขอซื้อ',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'PRUnit',
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->dataonview->PRUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->dataonview->PRUnit;
                                        }
                                    }
                                        ],
                                        [
                                            'label' => '',
                                            'width' => '100px',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                            'attribute' => 'PRUnitCost2',
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->dataonview->PRUnitCost2 == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->dataonview->PRUnitCost2, 4);
                                        }
                                    }
                                        ],
                                        [
                                            'label' => '',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'VerifyQty',
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->dataonview->VerifyQty == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->dataonview->VerifyQty, 4);
                                        }
                                    }
                                        ],
                                        [
                                            'label' => '',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'VerifyUnit',
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->dataonview->VerifyUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->dataonview->VerifyUnit;
                                        }
                                    }
                                        ],
                                        [
                                            'header' => 'ทวนสอบ',
                                            'width' => '100px',
                                            'headerOptions' => ['style' => 'text-align:left;background-color: #ddd;color:black;'],
                                            'attribute' => 'VerifyUnitCost',
                                            'hAlign' => 'center',
                                            'pageSummary' => 'รวมเป็นเงิน',
                                            'value' => function ($model) {
                                        if ($model->dataonview->VerifyUnitCost == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->dataonview->VerifyUnitCost, 4);
                                        }
                                    }
                                        ],
                                        [
                                            'label' => '',
                                            'width' => '120px',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'ExtenedCost',
                                            'hAlign' => 'center',
                                            'pageSummary' => true,
                                            'format' => ['decimal', 4],
                                            'value' => function ($model) {
                                        return $model->PRVerifyQty * $model->PRVerifyUnitCost;
                                    }
                                        ],
                                        [
                                            'class' => 'kartik\grid\ActionColumn',
                                            'header' => 'Actions',
                                            'noWrap' => true,
                                            'pageSummary' => 'บาท',
                                            'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:left'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'template' => '',
                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                        ],
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
                                                        [11, 12]
                                                    ], // columns to merge in summary
                                                    'content' => [// content to show in each summary cell
                                                        1 => '',
                                                        4 => 'จำนวน',
                                                        5 => 'หน่วย',
                                                        6 => 'ราคา/หน่วย',
                                                        7 => 'จำนวน',
                                                        8 => 'หน่วย',
                                                        9 => 'ราคา/หน่วย',
                                                        10 => 'ราคารวม',
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
                                                        10 => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                        11 => ['style' => 'background-color: #ddd;color:black;'],
                                                    ],
                                                    // html attributes for group summary row
                                                    'options' => ['class' => 'success', 'style' => 'font-weight:bold;']
                                                ];
                                            }
                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <?php // \yii\widgets\Pjax::end()  ?>
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
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRReasonNote', ['showLabels' => false])->textarea([
                                                'rows' => 3,
                                                'style' => 'background-color:white',
                                                'readonly' => true,
                                            ])
                                            ?>
                                        </div>
                                        <?= Html::activeLabel($modelPR2, 'PRVerifyNote', ['label' => 'เหตุผลการ Verify', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRVerifyNote', ['showLabels' => false])->textarea([
                                                'rows' => 3,
                                                'style' => 'background-color:white',
                                                'readonly' => true,
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                    <?php if ($view == 'reject-approve') { ?>
                                        <div class="form-group">
                                            <?= Html::activeLabel($modelPR2, 'PRRejectReason', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                            <div class="col-sm-4">
                                                <?=
                                                $form->field($modelPR2, 'PRRejectReason', ['showLabels' => false])->textarea([
                                                    'rows' => 3,
                                                    'style' => 'background-color:white',
                                                    'readonly' => true,
                                                ])
                                                ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?=
                                    $form->field($modelPR2, 'PRTotal', ['showLabels' => false])->hiddenInput([
                                        'value' => $cost
                                    ])
                                    ?>
                                    <input type="hidden" id="tbpr2-prid" name="TbPr2[PRID]" value="<?php echo $modelPR2['PRID']; ?>"/>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: right">
                                <?php if ($view == 'wating-approve') { ?>
                                    <?= Html::a('Close', ['list-wating-approve'], ['class' => 'btn btn-default']) ?>
                                <?php } elseif ($view == 'reject-approve') { ?>
                                    <?= Html::a('Close', ['list-reject-approve'], ['class' => 'btn btn-default']) ?>
                                <?php } elseif ($view == 'approve') { ?>
                                    <?= Html::a('Close', ['list-approve'], ['class' => 'btn btn-default']) ?>
                                <?php } elseif ($modelPR2['PRNum'] == $val) { ?>
                                    <?= Html::a('Close', ['detail-approve'], ['class' => 'btn btn-default']) ?>
                                    <a class="btn btn-warning" id="RejectApprove">Reject</a>
                                    <a class="btn btn-primary" id="ApprovePR">Approve PR</a>
                                <?php } ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>
            </div>
        </div>

        <?php if ($modelPR2['PRNum'] == $val) { ?>
            <!-- Modal /-->

            <?php
            \yii\bootstrap\Modal::begin([
                'id' => 'Reject_Approve',
                'size' => 'modal-dialog modal-primary',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                'closeButton' => false,
                'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Approve</h4></font>',
                //'headerOptions' => ['class' => 'bg-azure'],
                'footer' => '<div class="col-xs-9 col-xs-offset-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="SaveRejectApprove" class="btn btn-warning ladda-button" data-style="expand-left">Rejected Approve</button>
                </div>',
            ]);
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <textarea type="text" class="form-control" id="PRRejectReason" name="PRRejectReason" cols="100" rows="5" cols="10" style="background-color: #ffff99;"></textarea>
                </div>
            </div>

            <?php
            \yii\bootstrap\Modal::end();
            ?>
            <!-- JS -->
            <?php
            $script = <<< JS
function init_click_handlers() {
//Approve
$('#ApprovePR').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRNum = $("#tbpr2-prnum").val();
    var PRTotal = $("#tbpr2-prtotal").val();
    swal({
        title: "ยืนยันการอนุมัติใบขอซื้อ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'index.php?r=Purchasing/addpr-gpu/approve-pr',
                            {
                                PRID: PRID, PRNum: PRNum, PRTotal: PRTotal
                            },
                    function (data)
                    {

                    }
                    );
                }
            });
});    
                
//Save Reject Approve
$('#SaveRejectApprove').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRRejectReason = $("#PRRejectReason").val();
    var PRNum = $("#tbpr2-prnum").val();
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    if (PRRejectReason == "") {
        swal({
            title: "",
            text: "กรุณากรอกเหตุผล!",
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
    } else {
        $.post(
                'index.php?r=Purchasing/addpr-gpu/rejected-approve',
                {
                    PRID: PRID, PRRejectReason: PRRejectReason, PRNum: PRNum
                },
        function (data)
        {

        }
        );
    }
});    
                
//Reject Approve
$('#RejectApprove').click(function (e) {
    $('#Reject_Approve').modal('show');
});   
}
init_click_handlers(); //first run
$('#verify_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
            $this->registerJs($script);
            ?>
        <?php } ?>