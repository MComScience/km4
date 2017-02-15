<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use app\models\TbDepartment;
use yii\jui\DatePicker;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use app\models\TbPrtype;
use app\models\TbPotype;
use app\models\TbPrstatus;
use app\modules\Purchasing\models\TbPrbudget;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);

$val1 = base64_encode($modelPR2['PRNum'] . $modelPR2['PRID']);
if ($view == 'wating-verify') {
    $this->title = 'ใบขอซื้อรอการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อยาสามัญ', 'url' => ['list-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == $val1) {
    $this->title = 'ทวนสอบใบขอซื้อยาสามัญ';
    $this->params['breadcrumbs'][] = ['label' => 'หัวหน้าเภสัชกรรม', 'url' => ['detail-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ทวนสอบใบขอซื้อ', 'url' => ['detail-verify']];
    $this->params['breadcrumbs'][] = $this->title;
} elseif ($view == 'reject-verify') {
    $this->title = 'ใบขอซื้อไม่ผ่านการทวนสอบ';
    $this->params['breadcrumbs'][] = ['label' => 'Purchasing', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อ', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = ['label' => 'ขอซื้อยาสามัญ', 'url' => ['list-reject-verify']];
    $this->params['breadcrumbs'][] = $this->title;
}

/*   ActionColumn     */
if ($view == 'wating-verify' || $view == 'reject-verify' || $view == '') {
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
} else if ($view == $val1) {
    $actioncolumn = [
        'class' => 'kartik\grid\ActionColumn',
        'header' => 'Actions',
        'noWrap' => true,
        'pageSummary' => 'บาท',
        'options' => ['style' => 'width:100px;'],
        'hAlign' => GridView::ALIGN_CENTER,
        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
        'template' => ' {ok} {update}',
        'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:left'],
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
                                <div class="tb-pr2-form">
                                    <?php
                                    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtempgpu']);
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
                                        <?= Html::activeLabel($modelPR2, 'PRbudgetID', ['label' => 'ประเภทงบประมาณ','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                        <div class="col-sm-3">
                                            <?=
                                            $form->field($modelPR2, 'PRbudgetID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => ArrayHelper::map(Tbprbudget::find()->all(), 'PRbudgetID', 'PRbudget'),
                                                'language' => 'en',
                                                'options' => ['placeholder' => 'Select Option'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
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
                                        <?php Pjax::begin(['id' => 'verify_pjax_id']) ?>
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $dataProvider,
                                            'showPageSummary' => true,
                                            'responsiveWrap' => FALSE,
                                            'hover' => true,
                                            //'pjax' => true,
                                            'striped' => false,
                                            'condensed' => true,
                                            'toggleData' => false,
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
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                ],
                                                [
                                                    'class' => 'kartik\grid\ExpandRowColumn',
                                                    'value' => function ($model, $key, $index, $column) {
                                                        return GridView::ROW_COLLAPSED;
                                                    },
                                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'detailAnimationDuration' => 'slow', //fast
                                                    'expandOneOnly' => true,
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
                                                return !empty($model['PRVerifyQty']) ? '<span class="label label-success">' . $model->TMTID_GPU . '</span>' : '<kbd>' . $model->TMTID_GPU . '</kbd>';
                                            }
                                                ],
                                                [
                                                    'attribute' => 'ItemName',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'header' => 'รายละเอียดยา',
                                                    'value' => function($model) {
                                                return $model->dataonview->ItemName;
                                            }
                                                ],
                                                [
                                                    'attribute' => 'PRQty',
                                                    'label' => FALSE,
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->PRQty) ? '-' : number_format($model->dataonview->PRQty, 4);
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
                                                    'label' => false,
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->PRUnitCost2) ? '-' : number_format($model->dataonview->PRUnitCost2, 2);
                                            }
                                                ],
                                                [
                                                    'label' => '',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;'],
                                                    'attribute' => 'VerifyQty',
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
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
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->VerifyUnit) ? '-' : $model->dataonview->VerifyUnit;
                                            }
                                                ],
                                                [
                                                    'header' => 'ทวนสอบ',
                                                    'width' => '100px',
                                                    'headerOptions' => ['style' => 'text-align:left;background-color: #ddd;color:black;'],
                                                    'attribute' => 'VerifyUnitCost',
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white', 'style' => 'text-align:right'],
                                                    'hAlign' => 'center',
                                                    'pageSummary' => 'รวมเป็นเงิน',
                                                    'value' => function ($model) {
                                                return empty($model->dataonview->VerifyUnitCost) ? '-' : number_format($model->dataonview->VerifyUnitCost, 4);
                                            }
                                                ],
                                                [
                                                    'label' => '',
                                                    'width' => '120px',
                                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:black;',],
                                                    'attribute' => 'ExtenedCost',
                                                    'options' => ['style' => 'background-color: #f9f9f9'],
                                                    'pageSummaryOptions' => ['class' => 'bg-white'],
                                                    'hAlign' => 'center',
                                                    'pageSummary' => true,
                                                    'format' => ['decimal', 4],
                                                    'value' => function ($model) {
                                                return $model->dataonview->PRExtendedCost;
                                            }
                                                ],
                                                $actioncolumn,
                                                [
                                                    'class' => '\kartik\grid\DataColumn',
                                                    'hAlign' => GridView::ALIGN_CENTER,
                                                    'width' => '10px',
                                                    'hidden' => true,
                                                    'group' => true,
                                                    'groupHeader' => function ($model, $key, $index, $widget) {
                                                        return [
                                                            'mergeColumns' => [
                                                                [1, 3],
                                                                [11, 12]
                                                            ],
                                                            'content' => [
                                                                1 => '',
                                                                4 => 'จำนวน',
                                                                5 => 'หน่วย',
                                                                6 => 'ราคา/หน่วย',
                                                                7 => 'จำนวน',
                                                                8 => 'หน่วย',
                                                                9 => 'ราคา/หน่วย',
                                                                10 => 'ราคารวม',
                                                            ],
                                                            'contentOptions' => [
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
                                                <label class="col-sm-2 control-label no-padding-right"><?= Html::encode('เหตุผลการขอซื้อ') ?></label>
                                                <div class="col-sm-4">
                                                    <div id="TbPrReasonCheckbox">
                                                        <?php
                                                        echo $htl_checkbox;
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right"><?= Html::encode('อื่นๆ') ?></label>
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
                                            <?php if($view == $val1) { ?>
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
                                            <?php }?>
                                            <input type="hidden" id="tbpr2-prid" name="TbPr2[PRID]" value="<?php echo $modelPR2['PRID']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group" style="text-align: right">
                                        <?php if ($view == $val1) { ?>
                                            <?= Html::a('Close', ['detail-verify'], ['class' => 'btn btn-default']) ?>
                                            <?= Html::a('Reject', 'javascript:void(0);', ['class' => 'btn btn-warning', 'id' => 'RejectVerify']); ?>
                                            <?= Html::button('Save Draft', ['class' => 'btn btn-success', 'id' => 'SaveDraftVerify',]); ?>
                                            <?php // Html::button('Verify & Send To Approve', ['class' => 'btn btn-info','id' => 'SendToApprove','disabled' => $modelPR2['PRStatusID'] == '5' ? false : true]); ?>
                                            <?= Html::button('Verify & Auto Approve', ['class' => 'btn btn-azure auto-approve']); ?>
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

                <?php if ($view == $val1) { ?>
                    <!-- Modal /-->
                    <?php
                    Modal::begin([
                        'id' => 'verify-modal',
                        'header' => '<h4 class="modal-title">บันทึกรายการยาสามัญ ใบขอซื้อ</h4>',
                        'size' => 'modal-lg',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => false,
                    ]);
                    ?>
                    <div id="data"></div>
                    <?php Modal::end();
                    ?>

                    <?php
                    Modal::begin([
                        'id' => 'Reject_Verify',
                        'size' => 'modal-dialog',
                        'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Verify</h4></font>',
                        //'headerOptions' => ['class' => 'bg-azure'],
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

                    <?php
                    Modal::end();
                    ?>

                    <!-- JS -->
                    <?php
                    $script = <<< JS
//Loading
function run_waitMe(effect) {
        $('.modal-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
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
$(document).ready(function () {
       // $('#SendToApprove').addClass("disabled", "disabled");
       // $('#SaveDraftVerify').addClass("disabled", "disabled");
    });
function init_click_handlers() {       
    //Edit Verify
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        LoadingClass();
        $.get(
                'update-verify',
                {
                    id: fID
                },
        function (data)
        { 
            //$('#formdetailgpu').trigger('reset');
            $('.modal-header').addClass("bordered-success");
            $('#verify-modal').find('.modal-body').html(data);
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาสามัญ ทวนสอบใบขอซื้อ');
            $('#checkover').val('');
            $('.page-content').waitMe('hide');
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
                                    'cancel-verify',
                                    {
                                        id: fID
                                    },
                                    function (result) {
                                        $.pjax.reload({container: '#verify_pjax_id'});
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
                                'verify-approve',
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
                                                                'auto-approve',
                                                                {
                                                                    PRID: PRID
                                                                },
                                                                function (result) {

                                                                    //$.pjax.reload({container: '#verify_pjax_id'});
                                                                }
                                                        ).fail(function (xhr, status, error) {
                                                            //swal("Oops...", error, "error");
                                                        });
                                                    }
                                                });
                                    } else {
                                        $.post(
                                                'auto-approve',
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
                        
//OK Verify
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
                    'ok-verify',
                    {
                        id: fID
                    },
                    function (data) {
                        $.pjax.reload({container: '#verify_pjax_id'});
                        swal("OK Complete!", "", "success");
                        $('#SaveDraftVerify').removeClass("disabled", "disabled");
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
        var PRVerifyNote = $("#tbpr2-prverifynote").val();
        var PRbudgetID = $('#tbpr2-prbudgetid').find("option:selected").val();
        $('#SendToApprove').removeClass('disabled');
        $.post(
                'savedraft-verify',
                {
                    PRID: PRID,PRVerifyNote:PRVerifyNote,PRbudgetID:PRbudgetID
                },
        function (data)
        {
            swal({
                title: "SaveDraft Completed!",
                text: "",
                type: "success",
                showCancelButton: false,
                confirmButtonText: "OK!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                location.reload();
              } else {
                
              }
            });
        }
        );
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
                            'send-to-approve',
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
          
//Save Reject Verify
$('#SaveRejectVerify').click(function (e) {
    var PRID = $("#tbpr2-prid").val();
    var PRRejectReason = $("#PRRejectReason").val();
    var PRNum = $("#tbpr2-prnum").val();
    var l = $( '.ladda-button' ).ladda();
    l.ladda( 'start' );
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
                'rejected-verify',
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
            $('.modal-title').html('ปรับปรุงรายการยาสามัญ ทวนสอบใบขอซื้อ');
            $('#verify-modal').modal('show');
        }
        );
    });
JS;
                    $this->registerJs($script);
                    ?>

                <?php } ?>
