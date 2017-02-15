<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use app\models\TbDepartment;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\TbPrtype;
use app\models\TbPotype;
use app\models\TbPrstatus;
use app\models\TbPcplan;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

$val1 = base64_encode($modelPR2['PRNum'] . $modelPR2['PRID']);
if ($view == 'wating-verify') {
    $this->title = 'ใบขอซื้อรอการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == $val1) {
    $this->title = 'ทวนสอบใบขอซื้อยาการค้า สัญญาจะซื้อจะขาย';
    $this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['addpr-gpu/detail-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ทวนสอบใบขอซื้อ', 'url' => ['addpr-gpu/detail-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'reject-verify') {
    $this->title = 'ใบขอซื้อไม่ผ่านการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = $this->title;
}

if ($view == 'reject-verify' or $view == 'wating-verify') {
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
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;;'],
        'template' => '{ok} {update}',
        'buttonOptions' => ['class' => 'btn btn-default'],
        'pageSummary' => 'บาท',
        'buttons' => [
            'ok' => function ($url, $model) {
                if ($model->PRVerifyQty > 0.00) {
                    return Html::a('Cancel', "#", [
                                'title' => 'Cancel',
                                'class' => 'btn btn-warning btn-xs btn-cancel',
                                'data-toggle' => 'modal',
                    ]);
                } else {
                    return Html::a('<span class="btn btn-success btn-xs"> OK </span> ', '#', [
                                'title' => 'OK',
                                'data-toggle' => 'modal',
                                'class' => 'activity-ok-link',
                    ]);
                }
            },
                    'update' => function ($url, $model, $key) {
                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                            'class' => 'activity-update-link',
                            'title' => 'แก้ไขข้อมูล',
                            'data-toggle' => 'modal',
                            //'data-target' => '#verify-tpu-cont-modal',
                            'data-id' => $key,
                            'data-pjax' => '0',
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
                                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_verify_tpu_cont']); ?>
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
                                                    ArrayHelper::map(TbDepartment::find()->where(['DepartmentID' => $modelPR2['DepartmentID']])->all(), 'DepartmentID', 'DepartmentDesc'), [
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
                                                    'disabled' => true,
                                                ],
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
                                                'style' => 'background-color: white',
                                                'disabled' => true,
                                            ])
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <?= Html::activeLabel($modelPR2, 'POContactNum', ['label' => 'เลขที่สัญญาจะซื้อจะขาย' . '<font color="red"> *</font>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'POContactNum', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(TbPcplan::find()->where(['PCPOContactID' => $modelPR2['POContactNum']])->all(), 'PCPOContactID', 'PCPOContactID'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Option'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
                                                    'disabled' => true,
                                                ],
                                            ])
                                            ?>
                                        </div>

                                        <label class="col-sm-2 control-label no-padding-right">ชื่อผู้ขาย</label>
                                        <div class="col-sm-3">
                                            <input class="form-control" id="Vendorname" readonly="" style="background-color: white"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <h5 class="row-title before-success">รายละเอียดใบขอซื้อ</h5>
                                        <?php Pjax::begin(['id' => 'verify_tpu_cont_pjax_id']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'showPageSummary' => true,
                                            'responsiveWrap' => FALSE,
                                            'hover' => true,
                                            'pjax' => true,
                                            'striped' => false,
                                            'bordered' => FALSE,
                                            'condensed' => true,
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
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;;']
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;;'],
                                                    'expandOneOnly' => true,
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                                    'detailUrl' => Url::to(['details-verify-approve']),
                                                ],
                                                [
                                                    'attribute' => 'ItemID',
                                                    'header' => 'รหัสสินค้า',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                return '<kbd>' . $model->ItemID . '</kbd>';
                                            },
                                                ],
                                                [
                                                    'attribute' => 'ItemName',
                                                    'header' => 'รายละเอียดยา',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;;'],
                                                    'value' => function($model) {
                                                return $model->dataonview->ItemName;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PROrderQty',
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->PROrderQty) ? '-' : number_format($model->PROrderQty, 2);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRUnitCost',
                                                    'header' => 'ขอซื้อ',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->PRUnit) ? '-' : $model->dataonview->PRUnit;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRUnitCost',
                                                    'label' => FALSE,
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->PRUnitCost) ? '-' : number_format($model->PRUnitCost, 2);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'VerifyQty',
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->PRVerifyQty) ? '-' : number_format($model->PRVerifyQty, 2);
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
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:left;background-color: #ddd;color:black;'],
                                                    'hAlign' => 'center',
                                                    'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:left'],
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                return empty($model->PRVerifyUnitCost) ? '-' : number_format($model->PRVerifyUnitCost, 2);
                                            }
                                                ],
                                                [
                                                    'label' => FALSE,
                                                    'width' => '120px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'ExtenedCost',
                                                    'hAlign' => 'center',
                                                    'pageSummary' => true,
                                                    'format' => ['decimal', 2],
                                                    'value' => function ($model) {
                                                return $model->dataonview->ExtenedCost;
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
                                                    $form->field($modelPR2, 'PRReasonNote', ['showLabels' => false])->textarea([
                                                        'rows' => 3,
                                                        'style' => 'background-color:white',
                                                        'readonly' => true,
                                                    ])
                                                    ?>
                                                </div>
                                            </div>
                                            <?php if ($view == 'reject-verify') { ?>
                                                <div class="form-group">
                                                    <?= Html::activeLabel($modelPR2, 'PRRejectReason', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                                    <div class="col-sm-4">
                                                        <?=
                                                        $form->field($modelPR2, 'PRRejectReason', ['showLabels' => false])->textarea([
                                                            'rows' => 3,
                                                            'style' => 'background-color:white',
                                                        ])
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <?php if ($view == $val1) { ?>
                                            <div class="form-group">
                                                <?= Html::activeLabel($modelPR2, 'PRVerifyNote', ['label' => 'เหตุผลการ Verify', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                                                <div class="col-sm-4">
                                                    <?=
                                                    $form->field($modelPR2, 'PRVerifyNote', ['showLabels' => false])->textarea([
                                                        'rows' => 3,
                                                        'style' => 'background-color:#ffff99',
                                                    ])
                                                    ?>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <input type="hidden" id="tbpr2-prid" name="TbPr2[PRID]" value="<?php echo $modelPR2['PRID']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: right">
                                        <?php if ($view == $val1) { ?>
                                            <?= Html::a('Close', ['addpr-gpu/detail-verify'], ['class' => 'btn btn-default']) ?>
                                            <!-- <a class="btn btn-danger">Clear</a> -->
                                            <a class="btn btn-warning" id="RejectVerify">Reject</a>
                                            <a class="btn btn-success" id="SaveDraftVerify">Save Draft</a>
                                            <?= Html::button('Verify & Auto Approve', ['class' => 'btn btn-azure auto-approve']); ?>
                                        <?php } elseif ($view == 'wating-verify') { ?>
                                            <?= Html::a('Close', ['addpr-gpu/list-verify'], ['class' => 'btn btn-default']) ?>
                                        <?php } elseif ($view == 'reject-verify') { ?>
                                            <?= Html::a('Close', ['list-reject-verify'], ['class' => 'btn btn-default']) ?>
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
                    'id' => 'verify-tpu-cont-modal',
                    'header' => '<h4 class="modal-title">ปรับปรุงรายการยาการค้า ใบขอซื้อสัญญาจะซื้อจะขาย</h4>',
                    'size' => 'modal-lg modal-primary',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => false,
                ]);
                ?>
                <div id="data"></div>
                <?php Modal::end(); ?>

                <?php
                Modal::begin([
                    'id' => 'Reject_Verify_tpu_cont',
                    'size' => 'modal-dialog',
                    'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Verify</h4></font>',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => false,
                    'footer' => '<div class="col-xs-9 col-xs-offset-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="SaveRejectVerify" class="btn btn-warning ladda-button" data-style="expand-left">Rejected Verify</button>
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
$(document).ready(function () {
    $('#SendToApprove').addClass("disabled", "disabled");
    GetVendorname();
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
                        
function GetVendorname() {
    var e = document.getElementById("tbpr2-pocontactnum");
    var id = e.options[e.selectedIndex].value;
    if (id != "") {
        $.ajax({
            url: "index.php?r=Purchasing/addpr-tpu-cont/getvdname-byplannum",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (data) {
                $('#Vendorname').val(data.VendorName);
            }
        });
    }
}
function init_click_handlers() {
    //Edit Verify
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'index.php?r=Purchasing/addpr-tpu-cont/update-verify',
                {
                    id: fID
                },
        function (data)
        {
            $('#form_update_verify').trigger('reset');
            $('#verify-tpu-cont-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาการค้า ทวนสอบใบขอซื้อ');
            $('#checkover').val('');
            $('.page-content').waitMe('hide');
            $('#verify-tpu-cont-modal').modal('show');
        }
        );
    });

    //Cancel
        $('.btn-cancel').click(function (e) {
            var fID = $(this).closest('tr').data('key');
            swal({
                title: "Are you sure cancel?",
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
                                    'index.php?r=Purchasing/addpr-tpu-cont/cancel-verify',
                                    {
                                        id: fID
                                    },
                                    function (result) {
                                        $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                    }
                            ).fail(function (xhr, status, error) {
                                swal("Oops...", error, "error");
                            });
                        }
                    });
        });

    //AutoApprove
    $('.auto-approve').click(function (e) {
        var PRID = $("#tbpr2-prid").val();
        swal({
            title: "Verify & Auto Approve?",
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
                                'index.php?r=Purchasing/addpr-tpu-cont/verify-approve',
                                {
                                    PRID: PRID
                                },
                                function (result) {
                                    if (result != 'Pass') {
                                        swal({
                                            title: "ยืนยัน?",
                                            text: '<span style="color:#F8BB86">' + result + '</span>',
                                            type: "warning",
                                            showCancelButton: true,
                                            closeOnConfirm: true,
                                            closeOnCancel: true,
                                            confirmButtonText: "Confirm",
                                            html: true
                                        },
                                                function (isConfirm) {
                                                    if (isConfirm) {
                                                        $.post(
                                                                'index.php?r=Purchasing/addpr-tpu-cont/auto-approve',
                                                                {
                                                                    PRID: PRID
                                                                },
                                                                function (result) {

                                                                    //$.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                                                                }
                                                        ).fail(function (xhr, status, error) {
                                                            //swal("Oops...", error, "error");
                                                        });
                                                    }
                                                });
                                    } else {
                                        $.post(
                                                'index.php?r=Purchasing/addpr-tpu-cont/auto-approve',
                                                {
                                                    PRID: PRID
                                                },
                                                function (result) {
                                                    
                                                }
                                        ).fail(function (xhr, status, error) {
                                            //swal("Oops...", error, "error");
                                        });
                                    }
                                }
                        ).fail(function (xhr, status, error) {
                            swal("Oops...", error, "error");
                        });
                    }
                });
    });

    /* OK Verify */
    $('.activity-ok-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
            title: "Are you sure ok verify",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=Purchasing/addpr-tpu-cont/ok-verify',
                                {
                                    id: fID
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#verify_tpu_cont_pjax_id'});
                            swal("OK Complete!", "", "success");
                            $('#SaveDraftVerify').removeClass("disabled", "disabled");
                        }
                        );
                    }
                });
    });
}
init_click_handlers(); //first run
$('#verify_tpu_cont_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
//SendToApprove
$('#SendToApprove').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRNum = $("#tbpr2-prnum").val();
    swal({
        title: "ยืนยันการส่งอนุมัติ?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'index.php?r=Purchasing/addpr-tpu-cont/send-to-approve',
                            {
                                PRID: PRID, PRNum: PRNum
                            },
                    function (data)
                    {

                    }
                    );
                }
            });
});

//SaveDraft Verify
$('#SaveDraftVerify').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    $('#SendToApprove').removeClass('disabled');
    var PRVerifyNote = $("#tbpr2-prverifynote").val();
    $.post(
            'index.php?r=Purchasing/addpr-tpu-cont/savedraft-verify',
            {
                PRID: PRID,PRVerifyNote:PRVerifyNote
            },
    function (data)
    {
        swal("Save Complete!", "", "success");
    }
    );
});

/* Save Reject Verify */
$('#SaveRejectVerify').click(function (e) {
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
                'index.php?r=Purchasing/addpr-tpu-cont/rejected-verify',
                {
                    PRID: PRID, PRRejectReason: PRRejectReason, PRNum: PRNum
                },
        function (data)
        {

        }
        );
    }
});

//Reject Verify
$('#RejectVerify').click(function (e) {
    $('#Reject_Verify_tpu_cont').modal('show');
});
JS;
                $this->registerJs($script, \yii\web\View::POS_END, 'verify');
                ?>