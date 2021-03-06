<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\models\TbDepartment;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\TbPrstatus;
use app\models\TbPrtype;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

$val = base64_decode($view);
if ($view == 'wating-approve') {
    $this->title = 'ใบขอซื้อรอการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['addpr-gpu/list-wating-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['addpr-gpu/list-wating-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($modelPR2['PRNum'] == $val) {
    $this->title = 'อนุมัติใบขอซื้อเวชภัณฑ์';
    $this->params['breadcrumbs'][] = ['label' => 'ผู้อำนวยการ', 'url' => ['addpr-gpu/detail-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'อนุมัติใบขอซื้อ', 'url' => ['addpr-gpu/detail-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'reject-approve') {
    $this->title = 'ใบขอซื้อไม่ผ่านการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['addpr-gpu/list-reject-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['addpr-gpu/list-reject-approve']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'approve') {
    $this->title = 'ใบขอซื้อผ่านการอนุมัติ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['addpr-gpu/list-approve']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['addpr-gpu/list-approve']];
    $this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs">
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
                                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
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
                                    $form->field($modelPR2, 'PRDate', ['showLabels' => false])->widget(DatePicker::classname(), [
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
                                    $form->field($modelPR2, 'SectionID', ['showLabels' => false])->widget(DepDrop::classname(), [
                                        'options' => ['id' => 'ddl-section'],
                                        'data' => [$section],
                                        'disabled' => true,
                                        'pluginOptions' => [
                                            'depends' => ['ddl-department'],
                                            'url' => Url::to(['addpr-gpu/get-department']),
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
                                            'disabled' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR2, 'POTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR2, 'POTypeID', ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\TbPotype::find()->where(['POTypeID' => $modelPR2['POTypeID']])->all(), 'POTypeID', 'POType'),
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
                                    $form->field($modelPR2, 'PRStatusID', ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(TbPrstatus::find()->where(['PRStatusID' => $modelPR2['PRStatusID']])->all(), 'PRStatusID', 'PRStatus'),
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
                                    'toggleData' => false,
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
                                            'detailUrl' => Url::to(['details-verify-approve']),
                                        ],
                                        [
                                            'attribute' => 'ItemID',
                                            'header' => 'รหัสสินค้า',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'format' => 'raw',
                                            'value' => function ($model) {
                                        return '<kbd>' . $model->ItemID . '</kbd>';
                                    },
                                        ],
                                        [
                                            'attribute' => 'ItemName',
                                            'header' => 'รายละเอียดยา',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;;color:black;'],
                                            'value' => function($model) {
                                        return $model->dataonview->ItemName;
                                    }
                                        ],
                                        [
                                            'attribute' => 'PRQty',
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        return empty($model->dataonview->PRQty) ? '-' : number_format($model->dataonview->PRQty, 2);
                                    }
                                        ],
                                        [
                                            'attribute' => 'PRUnit',
                                            'header' => 'ขอซื้อ',
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                    }
                                        ],
                                        [
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                            'attribute' => 'PRUnitCost2',
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        return empty($model->dataonview->PRUnitCost2) ? '-' : number_format($model->dataonview->PRUnitCost2, 2);
                                    }
                                        ],
                                        [
                                            'attribute' => 'VerifyQty',
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        return empty($model->dataonview->VerifyQty) ? '-' : number_format($model->dataonview->VerifyQty, 2);
                                    }
                                        ],
                                        [
                                            'attribute' => 'VerifyUnit',
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'hAlign' => GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                            return empty($model->dataonview->VerifyUnit) ? '-' : $model->dataonview->VerifyUnit;
                                        }
                                        ],
                                        [
                                            'attribute' => 'VerifyUnitCost',
                                            'header' => 'ทวนสอบ',
                                            'headerOptions' => ['style' => 'text-align:left;background-color: #ddd;color:black;'],
                                            'hAlign' => 'center',
                                            'pageSummary' => 'รวมเป็นเงิน',
                                            'value' => function ($model) {
                                            return empty($model->dataonview->VerifyUnitCost) ? '-' : number_format($model->dataonview->VerifyUnitCost, 2);
                                        }
                                        ],
                                        [
                                            'label' => FALSE,
                                            'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                            'attribute' => 'ExtenedCost',
                                            'hAlign' => 'center',
                                            'pageSummary' => true,
                                            'format' => ['decimal', 2],
                                            'value' => function ($model) {
                                        return $model->PRVerifyQty * $model->PRVerifyUnitCost;
                                    }
                                        ],
                                        [
                                            'class' => 'kartik\grid\ActionColumn',
                                            'header' => 'Actions',
                                            'noWrap' => true,
                                            'pageSummary' => 'บาท',
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
                                        <?php // \yii\widgets\Pjax::end() ?>
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
                                                'readonly' => true
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
                                    <?= Html::a('Close', ['addpr-gpu/list-wating-approve'], ['class' => 'btn btn-default']) ?>
                                <?php } elseif ($view == 'reject-approve') { ?>
                                    <?= Html::a('Close', ['addpr-gpu/list-reject-approve'], ['class' => 'btn btn-default']) ?>
                                <?php } elseif ($view == 'approve') { ?>
                                    <?= Html::a('Close', ['addpr-gpu/list-approve'], ['class' => 'btn btn-default']) ?>
                                <?php } elseif ($modelPR2['PRNum'] == $val) { ?>
                                    <?= Html::a('Close', ['addpr-gpu/detail-approve'], ['class' => 'btn btn-default']) ?>
                                    <a class="btn btn-warning" id="RejectApprove">Reject</a>
                                    <a class="btn btn-info" id="ApprovePR">Approve PR</a>
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
            'id' => 'Reject_Approve',
            'size' => 'modal-dialog',
            'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Approve</h4></font>',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => false,
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

        <?php Modal::end(); ?>
        <!-- JS -->
        <?php
        $script = <<< JS
function init_click_handlers() {
    /* Approve */
    $('#ApprovePR').click(function (e) {
        var PRID = $("#tbpr2-prid").val();
        var PRNum = $("#tbpr2-prnum").val();
        var PRTotal = $("#tbpr2-prtotal").val();
        swal({
            title: "ยืนยันการอนุมัติ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=Purchasing/addpr-nd/approve-pr',
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

    /* Save Reject Approve */
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
                    'index.php?r=Purchasin/addpr-nd/rejected-approve',
                    {
                        PRID: PRID, PRRejectReason: PRRejectReason, PRNum: PRNum
                    },
            function (data)
            {

            }
            );
        }
    });

    /* Reject Approve */
    $('#RejectApprove').click(function (e) {
        $('#Reject_Approve').modal('show');
    });
}
init_click_handlers(); //first run
JS;
        $this->registerJs($script);
        ?>
        