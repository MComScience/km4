<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

if ($view == 'wating-verify') {
    $this->title = 'ใบขอซื้อรอการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการเวซภัณฑ์ฯ', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'false') {
    $this->title = 'ทวนสอบใบขอซื้อรายการเวซภัณฑ์ฯ';
    $this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['detail-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ทวนสอบใบขอซื้อ', 'url' => ['new-pr-gpu/detail-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'reject-verify') {
    $this->title = 'ใบขอซื้อไม่ผ่านการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อรายการเวซภัณฑ์ฯ', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = $this->title;
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
                    <div class="tb-pr2-form">
                        <?php
                        $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_detail_verify']);
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
                            <?= Html::activeLabel($modelPR2, 'PRExpectDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelPR2, 'PRExpectDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
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
                        </div>            
                        <?php if ($view == 'reject-verify' or $view == 'wating-verify') { ?>
                            <div class="form-group">
                                <?php \yii\widgets\Pjax::begin([]) ?>
                                <?php
                                //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                                ?>
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
                                    'striped' => true,
                                    'condensed' => true,
                                    'toggleData' => false,
                                    'layout' => "{summary}\n{items}\n{pager}",
                                    'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                    'columns' => [
                                        [
                                            'class' => 'kartik\grid\SerialColumn',
                                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                                            'width' => '36px',
                                            'header' => '<a>ลำดับ</a>',
                                            'headerOptions' => ['class' => 'kartik-sheet-style']
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemID',
                                            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemName',
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'PRPackQtyVerify',
                                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            'value' => function ($model) {
                                        if ($model->PRPackQtyVerify == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->PRPackQtyVerify, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'header' => '<a>หน่วยแพค</a>',
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemPackIDVerify',
                                            //'value' => 'packunitverify.PackUnit',
                                            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->ItemPackIDVerify == NULL) {
                                            return '-';
                                        } else {
                                            return $model->packunitverify->PackUnit;
                                        }
                                    }
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemPackCostVerify',
                                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            'value' => function ($model) {
                                        if ($model->ItemPackCostVerify == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->ItemPackCostVerify, 2);
                                        }
                                    }
                                        ],
                                        [

                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'PRVerifyQty',
                                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            'value' => function ($model) {
                                        if ($model->PRVerifyQty == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->PRVerifyQty, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'header' => '<a>หน่วย</a>',
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'DispUnit',
                                            //'value' => 'detail.DispUnit',
                                            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->detail->DispUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->detail->DispUnit;
                                        }
                                    }
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'PRVerifyUnitCost',
                                            'hAlign' => 'right',
                                            //'format' => ['decimal', 2],
                                            'pageSummary' => 'รวมเป็นเงิน',
                                            'value' => function ($model) {
                                        if ($model->PRVerifyUnitCost == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->PRVerifyUnitCost, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'class' => '\kartik\grid\FormulaColumn',
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'header' => '<a>ราคารวม</a>',
                                            'hAlign' => 'right',
                                            'format' => ['decimal', 2],
                                            'value' => function ($model, $key, $index, $widget) {
                                        $p = compact('model', 'key', 'index');
                                        // Write your formula below
                                        return $widget->col(6, $p) * $widget->col(8, $p);
                                    },
                                            'pageSummary' => true,
                                        ],
                                        [
                                            'class' => 'kartik\grid\ExpandRowColumn',
                                            'value' => function ($model, $key, $index, $column) {
                                                return kartik\grid\GridView::ROW_COLLAPSED;
                                            },
                                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                                            'header' => '<a>Actions</a>',
                                            'expandOneOnly' => true,
                                            'expandIcon' => '<span class="btn btn-success btn-xs">Select</span>',
                                            'collapseIcon' => '<span class="btn btn-success btn-xs">Select</span>',
                                            'detailAnimationDuration' => 'slow', //fast
                                            'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                            'detailUrl' => \yii\helpers\Url::to(['view-detail-verify', 'view' => $view]),
                                            'pageSummary' => 'บาท',
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php \yii\widgets\Pjax::end() ?>
                            </div>
                        <?php } elseif ($view == 'false') { ?>
                            <div class="form-group">
                                <?php \yii\widgets\Pjax::begin(['id' => 'verify_pjax_id']) ?>
                                <?php
                                //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                                ?>
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
                                    'striped' => true,
                                    'condensed' => true,
                                    'toggleData' => false,
                                    'layout' => "{summary}\n{items}\n{pager}",
                                    'pageSummaryRowOptions' => ['class' => 'default'],
                                    'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                    'columns' => [
                                        [
                                            'class' => 'kartik\grid\SerialColumn',
                                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                                            'width' => '36px',
                                            'header' => '<a>ลำดับ<a/>',
                                            'headerOptions' => ['class' => 'kartik-sheet-style']
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemID',
                                            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemName',
                                        ],
                                        [
                                            'attribute' => 'PRPackQtyVerify',
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            //'format' => ['decimal', 2],
                                            'value' => function ($model) {
                                        if ($model->PRPackQtyVerify == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->PRPackQtyVerify, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'header' => '<a>หน่วยแพค</a>',
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemPackIDVerify',
                                            //'value' => 'packunitverify.PackUnit',
                                            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->ItemPackIDVerify == NULL) {
                                            return '-';
                                        } else {
                                            return $model->packunitverify->PackUnit;
                                        }
                                    }
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'ItemPackCostVerify',
                                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            'value' => function ($model) {
                                        if ($model->ItemPackCostVerify == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->ItemPackCostVerify, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'PRVerifyQty',
                                            'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            //'format' => ['decimal', 2],
                                            'value' => function ($model) {
                                        if ($model->PRVerifyQty == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->PRVerifyQty, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'header' => '<a>หน่วย</a>',
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'DispUnit',
                                            'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            'value' => function ($model) {
                                        if ($model->detail->DispUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->detail->DispUnit;
                                        }
                                    }
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'PRVerifyUnitCost',
                                            'hAlign' => 'right',
                                            //'format' => ['decimal', 2],
                                            'pageSummary' => 'รวมเป็นเงิน',
                                            'value' => function ($model) {
                                        if ($model->PRVerifyUnitCost == NULL) {
                                            return '-';
                                        } else {
                                            return number_format($model->PRVerifyUnitCost, 2);
                                        }
                                    }
                                        ],
                                        [
                                            'headerOptions' => ['style' => 'text-align:center'],
                                            'attribute' => 'PRExtendedCost',
                                            'header' => '<a>ราคารวม</a>',
                                            'hAlign' => 'right',
                                            'format' => ['decimal', 2],
                                            'value' => function ($model, $key, $index, $widget) {
                                        return $model->PRVerifyQty * $model->PRVerifyUnitCost;
                                    },
                                            'pageSummary' => true,
                                        ],
                                        [
                                            'class' => 'kartik\grid\ExpandRowColumn',
                                            'value' => function ($model, $key, $index, $column) {
                                                return kartik\grid\GridView::ROW_COLLAPSED;
                                            },
                                            'headerOptions' => ['class' => 'kartik-sheet-style'],
                                            'pageSummary' => 'บาท',
                                            'header' => '<a>Detail</a>',
                                            'expandIcon' => '<span class="btn btn-success btn-xs">Select</span>',
                                            'collapseIcon' => '<span class="btn btn-success btn-xs">Select</span>',
                                            'detailAnimationDuration' => 'slow', //fast
                                            'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                            'detailUrl' => \yii\helpers\Url::to(['view-detail-verify', 'view' => $view]),
                                        ],
//                            [
//                                'header' => 'ราคารวม',
//                                'attribute' => 'PRExtendedCost',
//                                'hAlign' => 'right',
//                                'format' => ['decimal', 2],
//                                'pageSummary' => true,
//                            ],
                                        [
                                            'class' => 'kartik\grid\ActionColumn',
                                            'header' => '<a>Actions</a>',
                                            'noWrap' => true,
                                            'options' => ['style' => 'width:100px;'],
                                            'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                            'headerOptions' => ['style' => 'text-align:center;'],
                                            'template' => '{update} {deletegpu}',
                                            'buttonOptions' => ['class' => 'btn btn-default'],
                                            'buttons' => [
                                                'update' => function ($url, $model, $key) {
                                                    return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                'class' => 'activity-update-link',
                                                                'title' => 'แก้ไขข้อมูล',
                                                                'data-toggle' => 'modal',
                                                                'data-target' => '#verify-modal',
                                                                'data-id' => $key,
                                                                'data-pjax' => '0',
                                                    ]);
                                                },
                                                        'deletegpu' => function ($url, $model) {
                                                    return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                                //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                'title' => Yii::t('app', 'Delete'),
                                                                'data-toggle' => 'modal',
                                                                //'data-method' => "post",
                                                                //'role' => 'modal-remote',
                                                                'class' => 'activity-delete-link',
                                                    ]);
                                                },
                                                    ],
                                                ],
                                            ],
                                        ]);
                                        ?>
                                        <?php \yii\widgets\Pjax::end() ?>
                                    </div>
                                <?php } ?>
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
                                <input type="hidden" id="tbpr2-prid" name="TbPr2[PRID]" value="<?php echo $modelPR2['PRID']; ?>"/>
                            </div>
                        </div>
                        <div class="form-group" style="text-align: right">
                            <?php if ($view == 'false') { ?>
                                <?= Html::a('Close', ['new-pr-gpu/detail-verify'], ['class' => 'btn btn-default']) ?>
                                <!--<a class="btn btn-danger">Clear</a>-->
                                <a class="btn btn-warning" id="RejectVerify">Reject</a>
                                <a class="btn btn-success" id="SaveDraftVerify">Save Draft</a>
                                <a class="btn btn-info" id="SendToApprove">Verify & Send To Approve</a>
                            <?php } elseif ($view == 'wating-verify') { ?>
                                <?= Html::a('Close', ['list-verify'], ['class' => 'btn btn-default']) ?>
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
        \yii\bootstrap\Modal::begin([
            'id' => 'verify-modal',
            'header' => '<h4 class="modal-title">บันทึกรายการยาการค้า ใบขอซื้อ</h4>',
            'size' => 'modal-lg',
        ]);
        ?>
        <div id="data"></div>
        <?php \yii\bootstrap\Modal::end();
        ?>

        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'Reject_Verify',
            'size' => 'modal-dialog',
            'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Verify</h4></font>',
            //'headerOptions' => ['class' => 'bg-azure'],
            'footer' => '<div class="col-xs-9 col-xs-offset-3">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" id="SaveRejectVerify" class="btn btn-warning">Rejected Verify</button>
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
$(document).ready(function () {
        $('#SendToApprove').addClass("disabled", "disabled");
        $('#SaveDraftVerify').addClass("disabled", "disabled");
       
    });
function init_click_handlers() {       
    //Edit Verify
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $.get(
                'update-verify',
                {
                    id: fID
                },
        function (data)
        { 
            $('.modal-header').addClass("bordered-success");
            $('#verify-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาการค้า ทวนสอบใบขอซื้อ');
            $('#verify-modal').modal('show');
        }
        );
    });
                
    //Delete Verify
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        bootbox.confirm('Are you sure delete this item?', function (result) {
            if (result) {
                $.post(
                        'delete-detail-verify',
                        {
                            id: fID
                        },
                function (data)
                {
                    $.pjax.reload({container: '#verify_pjax_id'});
                    Notify('Delete Complete!', 'top-right', '2000', 'success', 'fa-check', true);
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
//SaveDraft Verify
    $('#SaveDraftVerify').click(function (e) {
        var PRID = $("#tbpr2-prid").val();
        $('#SendToApprove').removeClass('disabled');
        $.post(
                'savedraft-verify',
                {
                    PRID: PRID
                },
        function (data)
        {
            Notify('SaveDraft Successfully!', 'top-right', '5000', 'success', 'fa-check', true);
        }
        );
    });
//SendToApprove
    $('#SendToApprove').click(function (e) {
        var PRID = $("#tbpr2-prid").val();
        var PRNum = $("#tbpr2-prnum").val();
        bootbox.confirm('ยืนยันการส่งอนุมัติ?', function (result) {
            if (result) {
                $.post(
                        'send-to-approve',
                        {
                            PRID: PRID,PRNum:PRNum
                        },
                function (data)
                {
                    
                }
                );
            }
        });
    });
          
    //Save Reject Verify
    $('#SaveRejectVerify').click(function (e) {
        var PRID = $("#tbpr2-prid").val();
        var PRRejectReason = $("#PRRejectReason").val();
        var PRNum = $("#tbpr2-prnum").val();
        if (PRRejectReason == "") {
            Notify('กรุณากรอกเหตุผล!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
        } else {
            $.post(
                    'rejected-verify',
                    {
                        PRID: PRID, PRRejectReason: PRRejectReason,PRNum:PRNum
                    },
            function (data)
            {

            }
            );
        }
    });
                
    //Reject Verify
    $('#RejectVerify').click(function (e) {
        $('#Reject_Verify').modal('show');
        $('.modal-title').html('เหตุผลการ Reject Verify</h4>');
    });
                
    $('.btn-info.edit').click(function (e) {
        var fID = $(this).attr('data-id');
        $.get(
                'update-verify',
                {
                    id: fID
                },
        function (data)
        {
            $('#form_update_verify').trigger('reset');
            $('#verify-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาการค้า ทวนสอบใบขอซื้อ');
            $('#verify-modal').modal('show');
        }
        );
    });
JS;
        $this->registerJs($script);
        ?>
