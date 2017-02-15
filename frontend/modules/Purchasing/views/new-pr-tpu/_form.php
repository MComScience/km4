<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\Purchasing\models\TbPr2Temp */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="tab-warning active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('บันทึกใบขอซื้อนอกแผน') ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-pr2-form">
                            <?php
                            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formtempnewtpu']);
                            ?>

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
                                <?= Html::activeLabel($modelPR, 'DepartmentID', ['label' => 'ฝ่าย' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
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
                                <?= Html::activeLabel($modelPR, 'PRDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
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
                                            'style' => 'background-color: white',
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR, 'SectionID', ['label' => 'แผนก' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR, 'SectionID', ['showLabels' => false])->widget(\kartik\widgets\DepDrop::classname(), [
                                        'options' => ['id' => 'ddl-section'],
                                        'data' => [$section],
                                        'pluginOptions' => [
                                            'depends' => ['ddl-department'],
                                            'url' => \yii\helpers\Url::to(['new-pr-gpu/get-department']),
                                            'style' => 'background-color: White'
                                        ]
                                    ])
                                    ?>
                                </div>
                            </div>

                            <div class="form-group" >
                                <?= Html::activeLabel($modelPR, 'PRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR, 'PRTypeID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value'=> $modelPR->prtype->PRType,
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR, 'POTypeID', ['label' => 'ประเภทการสั่งซื้อ' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR, 'POTypeID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\models\TbPotype::find()->all(), 'POTypeID', 'POType'),
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
                                <?= Html::activeLabel($modelPR, 'PRbudgetID', ['label' => 'ประเภทงบประมาณ' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR, 'PRbudgetID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(\app\modules\Purchasing\models\TbPrbudget::find()->all(), 'PRbudgetID', 'PRbudget'),
                                        'language' => 'en',
                                        'options' => ['placeholder' => 'Select Option'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelPR, 'PRExpectDate', ['label' => 'กำหนดส่งสินค้า' . '<font color="red"> *</font>','class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelPR, 'PRExpectDate', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        //'readonly' => true,
                                        'style' => 'background-color:#ffff99'
                                    ])
                                    ?>
                                </div>
                            </div>
                             
                            <?= $form->field($modelPR, 'ids_PR_selected', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelPR, 'PRID', ['showLabels' => false])->hiddenInput() ?>
                            <?php if ($view == '') { ?>
                                <div class="form-group">
                                    <a class="btn btn-success" id="getdatatpu"><i class="glyphicon glyphicon-plus">เลือกรายการยาการค้า</i></a>
                                </div>
                            <?php } ?>
                            <?php if ($view == '') { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'tpu_detail_id']) ?>
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
                                        'pageSummaryRowOptions' => ['class' => 'default'],
                                        'layout' => "{summary}\n{items}\n{pager}",
                                        'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_SUCCESS],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                 'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                            ],
                                            
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รหัสยาการค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'attribute' => 'TMTID_TPU',
                                            ],
                                            [
                                               'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                 'header' => 'รายละเอียดยา',
                                                'attribute' => 'ItemName',
                                            ],
                                            [
                                                'header' => '',
                                                'options' => ['style' => 'width:70px;'],
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                
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
                                                'options' => ['style' => 'width:85px;'],
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
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
                                                'header' => '',
                                                'options' => ['style' => 'width:80px;'],
                                                'pageSummary' => 'รวม',
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                
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
                                                'attribute' => 'PRExtendedCost',
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'hAlign' => 'right',
                                                'format' => ['decimal', 2],
                                                'pageSummary' => true,
                                            ],
                                            [
                                                'class' => 'kartik\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'pageSummary' => 'บาท',
                                                'noWrap' => true,
                                                'options' => ['style' => 'width:100px;'],
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'template' => ' {update} {deletegpu}',
                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                'buttons' => [
                                                    'update' => function ($url, $model, $key) {
                                                        return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                    'class' => 'activity-update-link',
                                                                    'title' => 'แก้ไขข้อมูล',
                                                                    'data-toggle' => 'modal',
                                                                    'data-target' => '#gpu-modal',
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
                                                                    [1, 2],
                                                                    [7, 8]
                                                                ], // columns to merge in summary
                                                                'content' => [// content to show in each summary cell
                                                                    1 => '',
                                                                    3 => 'จำนวน',
                                                                    4 => 'ราคา/หน่วย',
                                                                    5 => 'หน่วย',
                                                                ],
                                                                'contentOptions' => [// content html attributes for each summary cell
                                                                    0 => ['style' => 'background-color: #ddd'],
                                                                    1 => ['style' => 'font-variant:small-caps;background-color: #ddd'],
                                                                    3 => ['style' => 'font-variant:small-caps;background-color: #ddd;color:#000000;'],
                                                                    4 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    5 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    6 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    7 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    8 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    9 => ['style' => 'text-align:center;background-color: #ddd'],
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
                                    <?php } ?>

                                    <?php if ($view == 'view') { ?>
                                        <div class="form-group">
                                            <?php \yii\widgets\Pjax::begin([ 'id' => 'tpu_detail_id']) ?>
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
                                        'pageSummaryRowOptions' => ['class' => 'default'],
                                        'layout' => "{summary}\n{items}\n{pager}",
                                        'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_SUCCESS],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                 'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                            ],
                                            
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รหัสยาการค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'attribute' => 'TMTID_TPU',
                                            ],
                                            [
                                               'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                 'header' => 'รายละเอียดยา',
                                                'attribute' => 'ItemName',
                                            ],
                                            [
                                                'header' => '',
                                                'options' => ['style' => 'width:70px;'],
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                
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
                                                'options' => ['style' => 'width:85px;'],
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
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
                                                'header' => '',
                                                'options' => ['style' => 'width:80px;'],
                                                'pageSummary' => 'รวม',
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                
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
                                                'attribute' => 'PRExtendedCost',
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'hAlign' => 'right',
                                                'format' => ['decimal', 2],
                                                'pageSummary' => true,
                                            ],
                                            
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
                                                                    [1, 2],
                                                                    [6, 7]
                                                                ], // columns to merge in summary
                                                                'content' => [// content to show in each summary cell
                                                                    1 => '',
                                                                    3 => 'จำนวน',
                                                                    4 => 'ราคา/หน่วย',
                                                                    5 => 'หน่วย',
                                                                ],
                                                                'contentOptions' => [// content html attributes for each summary cell
                                                                    0 => ['style' => 'background-color: #ddd'],
                                                                    1 => ['style' => 'font-variant:small-caps;background-color: #ddd'],
                                                                    3 => ['style' => 'font-variant:small-caps;background-color: #ddd;color:#000000;'],
                                                                    4 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    5 => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                                    6 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    7 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    8 => ['style' => 'text-align:center;background-color: #ddd'],
                                                                    9 => ['style' => 'text-align:center;background-color: #ddd'],
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
                                    <?php } ?>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right">เหตุผลการขอซื้อ</label>
                                        <div class="col-sm-4">
                                            <div id="TbPrReasonCheckbox">
                                                <?php
                                                echo $htl_checkbox;
                                                ?>
                                                <?php /*
                                                  <?php foreach ($checkboxreason as $rm) { ?>
                                                  <div class="checkbox">
                                                  <label>
                                                  <input type="checkbox" class="colored-success" name="PRReason<?= $rm['PRReason'] ?>" id="PRReason<?= $rm['PRReason'] ?>" value="<?= $rm['ids'] ?>"/>
                                                  <span class="text"><?= $rm['PRReason'] ?></span>
                                                  </label>
                                                  </div>
                                                  <?php } ?>
                                                 * 
                                                 */ ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right">อื่นๆ</label>
                                        <div class="col-sm-4">
                                            <?=
                                            $form->field($modelPR, 'PRReasonNote', ['showLabels' => false])->textarea([
                                                'rows' => 3,
                                                'style' => 'background-color:#FFFF99',
                                            ])
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="text-align: right">
                                <?= Html::a('Close', ['new-pr-gpu/index'], ['class' => 'btn btn-default']) ?>
                                <?php if ($view == '') { ?>
                                    <a class="btn btn-danger" id="Clear">Clear</a>
                                    <?= Html::submitButton($modelPR->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $modelPR->isNewRecord ? 'btn btn-success draft' : 'btn btn-success draft', 'id' => 'SaveDraft']) ?> 
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

        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'getdatatpumodal',
            'header' => '<h4 class="modal-title">เลือกยาการค้า</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="datatpu"></div>
        <?php \yii\bootstrap\Modal::end(); ?>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'tpu-modal',
            'header' => '<h4 class="modal-title">บันทึกรายการยาการค้า ใบขอซื้อ</h4>',
            'size' => 'modal-lg modal-primary',
        ]);
        ?>
        <div id="data"></div>
        <?php \yii\bootstrap\Modal::end();
        ?>
        <!--JS-->
        <?php if ($view == '') { ?>
            <?php
$script = <<< JS
$(document).ready(function () {
        $('#SendtoVerify').addClass("disabled", "disabled");
        //$('thead').addClass('bordered-success');
});
  $('#getdatatpu').click(function (e) {
                wait();
                var data = $("#datatpu").val();
                if (data != "") {
                $('#getdatatpumodal').modal('show');
                $('#home').waitMe('hide');
                } else{
                $.ajax({
                url: 'index.php?r=Purchasing/new-pr-tpu/getdatatpu',
                        type: 'POST',
                        dataType: 'json',
                        success: function (data) {
                        $('#home').waitMe('hide');
                        $('#getdatatpumodal').find('.modal-body').html(data);
                        $('#datatpu').html(data);
                        $('.modal-title').html('เลือกยาการค้า');
                        $('#getdatatpumodal').modal('show');
                        $('.modal-header').addClass("bordered-success");
                        $('#getdatatputable').DataTable({
                         "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                        });
                        }
                });
                }

 });

//ClickEdit
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        $.get(
                'index.php?r=Purchasing/new-pr-tpu/update-detailtpu',
                {
                    id: fID
                },
        function (data)
        { 
            $('#formdetailtpu').trigger('reset');
            $('#tpu-modal').find('.modal-body').html(data);
            $('.modal-header').addClass("bordered-success");
            $('#data').html(data);
            $('.modal-title').html('ปรับปรุงรายการยาการค้า ใบขอซื้อ');
            $('#tpu-modal').modal('show');
            $('#cmd').val('2');
        }
        );
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
            wait();
            swal({   
                title: "Are you sure?",   
                //text: "You will not be able to recover this imaginary file!",   
                type: "error",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "OK",   
                closeOnConfirm: false
            },function(){    
                $.post(
                        'index.php?r=Purchasing/new-pr-tpu/delete-detailtpu',
                        {
                            id: fID
                        },
                function (data)
                {   
                    $('#home').waitMe('hide');
                    swal("Success","", "success");
                    $.pjax.reload({container: '#tpu_detail_id'});
                }
                );
        });
        $('#home').waitMe('hide');
    });
}
init_click_handlers(); //first run
$('#tpu_detail_id').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
//On Save
    $('#formtempnewtpu').on('beforeSubmit', function(e)
    {
    wait();
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result != null)
            {
            //$(\$form).trigger('reset');
                    $('#tbpr2temp-prnum').val(result);
                    $('#SendtoVerify').removeClass('disabled');
                    $('#home').waitMe('hide');
                    swal("SaveDraft","", "success");
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
$(document).ready(function () {
                    $('#tbpr2temp-prtypeid').on('change', function () {
                        var PRType = $(this).find('option:selected').val();
                        $.ajax({
                            url: 'index.php?r=Purchasing/new-pr-tpu/get-reasontpu',
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
                });

    $('#SaveDraft').click(function (e) {
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
                    'index.php?r=Purchasing/new-pr-tpu/save-reason',
                    {
                        PRID: PRID, reasonid: reasonid
                    },
            function (data)
            {

            }
            );
       // }
    });
    $('#Clear').click(function (e) {
        var PRID = $("#tbpr2temp-prid").val();
            wait();
            swal({   
                title: "Are you sure?",   
                //text: "You will not be able to recover this imaginary file!",   
                type: "error",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "OK",   
                closeOnConfirm: false
            },function(){
                $.post(
                        'index.php?r=Purchasing/new-pr-tpu/clear-tpu',
                        {
                            PRID: PRID
                        },
                function (data)
                {
                    $('#home').waitMe('hide');
                }
                );
        });
         $('#home').waitMe('hide');
    });
    function wait(){
         var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#home').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                    onClose: function () {}
                    });
                }
    }            
JS;
            $this->registerJs($script);
            ?>
            
            <script>
            function wait(){
                    var current_effect = 'ios'; 
                    run_waitMe(current_effect);
                    function run_waitMe(effect){
                    $('#home').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                        onClose: function () {}
                        });
                    }
                }
            function SelectTPU(id) {
                var PRID = $("#tbpr2temp-prid").val();
                var ids_PR_selected = $("#tbpr2temp-ids_pr_selected").val();
                wait();
                $.ajax({
                url: 'index.php?r=Purchasing/new-pr-tpu/new-detailtpu',
                        type: 'POST',
                        data: {id: id, PRID: PRID},
                        success: function (data) {
                        if (data == 'false') {
                            $('#home').waitMe('hide');
                            swal("รายการนี้ถูกบันทึกแล้ว","", "warning");
                        }else if (data == 'itemalready') {
                            $('#home').waitMe('hide');
                            swal("เป็นรายการที่มีอยู่ในบัญชีโรงพยาบาลแล้ว","", "warning");
                        } else {
                        $('#home').waitMe('hide');    
                        $('#formdetailtpu').trigger("reset");
                        $('#tpu-modal').find('.modal-body').html(data);
                        $('#data').html(data);
                        $('.modal-title').html('บันทึกรายการยาการค้า ใบขอซื้อ');
                        //$('#notpack').html('<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>');
                        $('#tpu-modal').modal('show');
                        $('#vwpritemdetail2temp-tmtid_tpu').val(id);
                        $('#vwpritemdetail2temp-ids_pr_selected').val(ids_PR_selected);
                        $('#vwpritemdetail2temp-prid').val(PRID);
                        $('#cmd').val('1');
                        }
                        }
                });
                }

                //getdata on chang pcplannum

                //                $.post(
                //                        'new-detailgpu',
                //                        {
                //                            id: id,PRID:PRID
                //                        },
                //                function (data)
                //                {
                //                    $('#formdetailtpu').trigger("reset");
                //                    $('#tpu-modal').find('.modal-body').html(data);
                //                    $('#data').html(data);
                //                    $('.modal-title').html('บันทึกรายการยาการค้า ใบขอซื้อ');
                //                    $('#tpu-modal').modal('show');
                //                    $('#vwpritemdetail2temp-tmtid_gpu').val(id);
                //                    $('#vwpritemdetail2temp-ids_pr_selected').val(ids_PR_selected);
                //                    $('#vwpritemdetail2temp-prid').val(PRID);
                //                    $('#cmd').val('1');
                //                }
                //                );
                function SendtoVerify() {
                var PRID = $("#tbpr2temp-prid").val();
                var PRNum = $("#tbpr2temp-prnum").val();
                wait();
                swal({   
                    title: "Verify?",   
                    //text: "You will not be able to recover this imaginary file!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#53a93f",   
                    confirmButtonText: "OK",   
                    closeOnConfirm: false
                },function(){
                $.post(
                        'index.php?r=Purchasing/new-pr-tpu/sendtoverify',
                {
                PRNum: PRNum, PRID: PRID
                },
                        function (data)
                        {
                             $('#home').waitMe('hide');  
                        }
                );
                });
                 $('#home').waitMe('hide');  
                }
                //                function myConfirmation() {
                //                    return 'Are you sure you want to quit?';
                //                }
                //                window.onbeforeunload = myConfirmation;
                //var myEvent = window.attachEvent || window.addEventListener;
                //var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compitable
                //
                //            myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
                //                var confirmationMessage = 'Are you sure to leave the page?';  // a space
                //                (e || window.event).returnValue = confirmationMessage;
                //                return confirmationMessage;
                //            });

                //        $.post({
                //            url: "new-detailgpu", // your controller action
                //            dataType: 'json',
                //            data: {id: id},
                //            success: function (data) {
                //                $('#tpu-modal').find('.modal-body').html(data);
                //                $('#data').html(data);
                //                $('.modal-title').html('บันทึกรายการยาการค้า ใบขอซื้อ');
                //                $('#tpu-modal').modal('show');
                //            },
                //        });

                //$(window).on('beforeunload', function () {
                //        return bootbox.confirm("Are you sure?", function (result) {
                //            if (result) {
                //            }
                //        });
                //    });
                //
                //    $(window).unload(function () {
                //        if ((sessionId != null) && (sessionId != "null") && (sessionId != "")) {
                //            logout();
                //        }
                //    });
              

            </script>
        <?php } ?>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => kartik\widgets\Growl::TYPE_SUCCESS,
                'title' => 'Well done!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => 'Save successfully.',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
            ?>
        <?php endforeach; ?>
