<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use app\modules\Inventory\models\TbStk;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStstatus;
use app\modules\Inventory\models\TbSttype;
use yii\jui\DatePicker;

$this->title = 'รายละเอียดใบโอนสินค้า';
?>

<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title); ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">

        <!--<div class="tb-st2-temp-form">-->
        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_st_main']); ?>
            <div class="row">
                <input type="hidden" value="<?php echo!empty($STID) ? $STID : '' ?>" name="stid" id="stid"/>
                <input type="hidden" value="<?php echo!empty($SRID) ? $SRID : '' ?>" name="srid" id="srid"/>
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNum')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>
                    <?php
                    echo $form->field($model, 'SRReceive_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                              'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                    <?php $form->field($model, 'SRTypeID')->textInput() ?>

                    <?php
                    echo $form->field($model, 'SRTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbSttype::find()->all(), 'STTypeID', 'STTypeDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                              'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php $form->field($model, 'SRDate')->textInput() ?>
                    <?php
                    echo
                    $form->field($model, 'SRDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                              'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                    <?php $form->field($model, 'SRIssue_stkID')->textInput() ?>
                    <?php
                    echo $form->field($model, 'SRIssue_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                              'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                    <?php $form->field($model, 'SRStatus')->textInput() ?>
                    <?php
                    echo $form->field($model, 'SRStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStstatus::find()->all(), 'STStatusID', 'STStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                              'disabled' => 'disabled'
                        ],
                    ]);
                    ?>
                </div>
                <div style="margin: 20px">
                    <br>
                    <?php
                    if (!empty($searchModel)) {
                        $ids = '';
                        ?>
                        <div class="form-group">
                            <?php \yii\widgets\Pjax::begin(['id' => 'sr2_detail_']) ?>
                            <?=
                            kartik\grid\GridView::widget([
                                'dataProvider' => $dataProvider,
                                'bootstrap' => true,
                                'showPageSummary' => true,
                                'responsiveWrap' => FALSE,
                                'responsive' => true,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => false,
                                'condensed' => true,
                                'toggleData' => false,
                                'layout' => Yii::$app->componentdate->layoutgridview2(),
                                'filterPosition' => \kartik\grid\GridView::FILTER_POS_BODY,
                                'tableOptions' => ['class' => \kartik\grid\GridView::TYPE_DEFAULT],
                                'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                                'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                                'columns' => [

                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '<font color="black">#</font>',
                                        'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd']
                                    ],
                                    [
                                        'header' => '<font color="black">รหัสสินค้า</font>',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->vwst2detailgroup['ItemID'] == NULL) {
                                        return '-';
                                    } else {
                                        return $model->vwst2detailgroup->ItemID;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '<font color="black">รายละเอียดยา</font>',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'attribute' => 'ItemName',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                        'value' => function ($model) {
                                    if ($model->vwst2detailgroup['ItemName'] == NULL) {
                                        return '-';
                                    } else {
                                        return $model->vwst2detailgroup->ItemName;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '<font color="black">ขอเบิก</font>',
                                        'width' => '150px',
                                        'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                        'attribute' => 'SRItemOrderQtyApprove',
                                        'format' => ['decimal', 2],
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'value' => function ($model) {
                                    if ($model->vwst2detailgroup['SRQty'] == NULL) {
                                        return '0.00';
                                    } else {
                                        return $model->vwst2detailgroup->SRQty;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '',
                                        'attribute' => 'vwst2detailgroup.SRUnit',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->vwst2detailgroup['SRUnit'] == NULL) {
                                        return '-';
                                    } else {
                                        return $model->vwst2detailgroup->SRUnit;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '<font color="black">อนุมัติ</font>',
                                        'attribute' => 'SRItemOrderQty',
                                        'width' => '150px',
                                        'format' => ['decimal', 2],
                                        'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                        'hAlign' => GridView::ALIGN_RIGHT,
                                        'value' => function ($model) {
                                    if ($model->sr2detail['SRApproveQty'] == NULL) {
                                        return '0.00';
                                    } else {
                                        return $model->sr2detail->SRApproveQty;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '',
                                        'attribute' => 'sr2detail.SRApproveUnit',
                                        'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->sr2detail['SRApproveUnit'] == NULL) {
                                        return '-';
                                    } else {
                                        return $model->sr2detail->SRApproveUnit;
                                    }
                                }
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
                                                    3 => '<font color="black">จำนวน</font>',
                                                    4 => '<font color="black">หน่วย</font>',
                                                    5 => '<font color="black">จำนวน</font>',
                                                    6 => '<font color="black">หน่วย</font>',
														 7 => '',
                                                ],
                                                'contentOptions' => [// content html attributes for each summary cell
                                                    0 => ['style' => 'background-color: #ddd'],
                                                    1 => ['style' => 'background-color: #ddd'],
                                                    3 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                    4 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                    5 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                    6 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                    7 => ['style' => 'background-color: #ddd']
                                                ],
                                                // html attributes for group summary row
                                                'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                                            ];
                                        }
                                            ],
                                ],
                            ]);
                            ?>
                            <?php \yii\widgets\Pjax::end() ?>
                        </div>
                    <?php } ?>
                </div> 
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNote')->textarea(['maxlength' => true, 'rows' => 4]) ?>
                </div>
               
            </div>
             <div style="text-align: right">
                      <?= Html::a('Close', ['spicking'], ['class' => 'btn btn-default']) ?>
                </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>



