<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use app\models\TbDepartment;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use app\models\TbPrtype;
use kartik\widgets\Select2;
use app\models\TbPotype;
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
    $this->title = 'ทวนสอบใบขอซื้อเวชภัณฑ์ สัญญาจะซื้อจะขาย';
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
        'options' => ['style' => 'width:100px;'],
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
        'template' => '{ok} {update}',
        'buttonOptions' => ['class' => 'btn btn-default'],
        'pageSummary' => 'บาท',
        'buttons' => [
            'ok' => function ($url, $model) {
                if ($model->PRVerifyQty > 0.00) {
                    return Html::a('OK', "#", [
                                'title' => 'OK',
                                'class' => 'btn btn-success btn-xs',
                                'disabled' => true,
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
                            //'data-target' => '#verify-modal',
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
                                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formverify_nd_cont']); ?>
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
                                                'data' => ArrayHelper::map(app\models\TbPrstatus::find()->where(['PRStatusID' => $modelPR2['PRStatusID']])->all(), 'PRStatusID', 'PRStatus'),
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

                                    <div class="form-group" >
                                        <h5 class="row-title before-success">รายละเอียดใบขอซื้อ</h5>
                                        <?php Pjax::begin(['id' => 'verify_nd_cont_pjax_id']) ?>

                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'showPageSummary' => true,
                                            'responsiveWrap' => FALSE,
                                            'hover' => true,
                                            'bordered' => false,
                                            'pjax' => true,
                                            'striped' => false,
                                            'condensed' => true,
                                            'layout' => "{summary}\n{items}\n{pager}",
                                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                            'rowOptions' => function($model) {
                                        if ($model->PRItemOnPCPlan == 1) {
                                            return ['class' => 'warning'];
                                        }
                                    },
                                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
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
                                                    'detailUrl' => Url::to(['view-detail-verify', 'view' => $view]),
                                                ],
                                                [
                                                    'attribute' => 'ItemID',
                                                    'header' => 'รหัสสินค้า',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                return '<kbd>' . $model->ItemID . '</kbd>';
                                            }
                                                ],
                                                [
                                                    'attribute' => 'ItemName',
                                                    'header' => 'รายละเอียดสินค้า',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
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
                                                    'attribute' => 'PRUnitCost2',
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
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
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->VerifyQty) ? '-' : number_format($model->dataonview->VerifyQty, 2);
                                            }
                                                ],
                                                [
                                                    'attribute' => 'VerifyUnit',
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->VerifyUnit) ? '-' : $model->dataonview->VerifyUnit;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'VerifyUnitCost',
                                                    'header' => 'ทวนสอบ',
                                                    'headerOptions' => ['style' => 'text-align:left;background-color: #ddd;color:black;'],
                                                    'hAlign' => 'center',
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->VerifyUnitCost) ? '-' : number_format($model->dataonview->VerifyUnitCost, 2);
                                            }
                                                ],
                                                [
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'ExtenedCost',
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => 'center',
                                                    'pageSummary' => true,
                                                    'format' => ['decimal', 2],
                                                    'value' => function ($model) {
                                                return $model->PRVerifyQty * $model->PRVerifyUnitCost;
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
                                                                0 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                1 => ['style' => 'font-variant:small-caps', 'style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                                2 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                3 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                4 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                5 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                6 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                7 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                8 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                9 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                10 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                                11 => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
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
                                                        'readonly' => true
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
                                            <a class="btn btn-danger">Clear</a>
                                            <a class="btn btn-warning" id="RejectVerify">Reject</a>
                                            <a class="btn btn-success" id="SaveDraftVerify">Save Draft</a>
                                            <a class="btn btn-info" id="SendToApprove">Verify & Send To Approve</a>
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
                    'id' => 'verify-modal',
                    'header' => '<h4 class="modal-title">ปรับปรุงรายการเวชภัณฑ์ สัญญาจะซื้อจะขาย</h4>',
                    'size' => 'modal-lg',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => false,
                ]);
                ?>
                <div id="data"></div>
                <?php Modal::end(); ?>

                <?php
                Modal::begin([
                    'id' => 'Reject_Verify',
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
        var e = document.getElementById("tbpr2-pocontactnum");
        var id = e.options[e.selectedIndex].value;
        if (id != "") {
            $.ajax({
                url: "index.php?r=Purchasing/addpr-nd-cont/getvdname-byplannum",
                type: "post",
                data: {id: id},
                dataType: 'json',
                success: function (data) {
                    $('#Vendorname').val(data.VendorName);
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
                'index.php?r=Purchasing/addpr-nd-cont/rejected-verify',
                {
                    PRID: PRID, PRRejectReason: PRRejectReason, PRNum: PRNum
                },
        function (data)
        {

        }
        );
    }
});
                                
/* Reject Verify */
    $('#RejectVerify').click(function (e) {
        $('#Reject_Verify').modal('show');
        $('.modal-title').html('เหตุผลการ Reject Verify');
    });
                                
/* SaveDraft Verify */
    $('#SaveDraftVerify').click(function (e) {
        var PRID = $("#tbpr2-prid").val();
        var PRVerifyNote = $("#tbpr2-prverifynote").val();
        $('#SendToApprove').removeClass('disabled');
        $.post(
                'index.php?r=Purchasing/addpr-nd-cont/savedraft-verify',
                {
                    PRID: PRID,PRVerifyNote:PRVerifyNote
                },
        function (data)
        {
            swal("Save Complete!", "", "success");
        }
        );
    });
                                
/* SendToApprove */
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
                            'index.php?r=Purchasing/addpr-nd-cont/send-to-approve',
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
function init_click_handlers() {
/* Edit Verify */
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'index.php?r=Purchasing/addpr-nd-cont/update-verify',
                {
                    id: fID
                },
        function (data)
        { 
            $('#form_update_verify').trigger('reset');
            $('#verify-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการเวชภัณฑ์ สัญญาจะซื้อจะขาย');
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
        closeOnConfirm: false,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'index.php?r=Purchasing/addpr-nd-cont/delete-detail-verify',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#verify_nd_cont_pjax_id'});
                        swal("OK Complete!", "", "success");
                    }
                    );
                }
            });
});
                                
/* ok Verify */
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
                            'index.php?r=Purchasing/addpr-nd-cont/ok-verify',
                            {
                                id: fID
                            },
                    function (data)
                    {
                        $.pjax.reload({container: '#verify_nd_cont_pjax_id'});
                         swal("OK Complete!", "", "success");
                    }
                    );
                }
            });
});
}
init_click_handlers(); //first run
$('#verify_nd_cont_pjax_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
JS;
                $this->registerJs($script);
                ?>
