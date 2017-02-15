<?php

use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStk;
use app\modules\Inventory\models\Tbsrtype;
use yii\jui\DatePicker;
use kartik\grid\GridView;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);

$this->title = 'ใบโอนสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'เบิก โอน จ่าย', 'url' => ['stock-wait']];
$this->params['breadcrumbs'][] = $this->title;
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
        <div class="well">
            <?php $form = ActiveForm::begin(['id' => 'form_recive', 'layout' => 'horizontal']); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'STNum')->textInput(['maxlength' => true, 'readonly' => true]) ?>

                    <?php
                    echo $form->field($model, 'STRecieve_StkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'STTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrtype::find()->all(), 'SRTypeID', 'SRType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo $form->field($model, 'STDate')->textInput(['maxlength' => true, 'readonly' => true]);
                    ?>
                    <?php
                    echo $form->field($model, 'STIssue_StkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะใบโอนสินค้า</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left"  value="<?php
                            if ($model->STStatus == 1) {
                                echo 'Issue Draft ';
                            } else if ($model->STStatus == 3) {
                                echo 'Receive Draft';
                            } else if ($model->STStatus == 4) {
                                echo 'Received Not Complete';
                            } else if ($model->STStatus == 5) {
                                echo 'Received Complete';
                            } else if ($model->STStatus == 6) {
                                echo 'Accepted Received Not Complete ';
                            } else if ($model->STStatus == 10) {
                                echo 'Delete';
                            } else if ($model->STStatus == 20) {
                                echo 'Issued Complete';
                            } else if ($model->STStatus == 21) {
                                echo 'Issued Not Complete';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->STStatus; ?>" name="TbSt2Temp[STStatus]" />
                    <?php
                    echo
                    $form->field($model, 'STRecievedDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'value' => date('d-m-Y'),
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่รับสินค้า <font color=red>*</font>');
                    ?>
                </div>
                <h5 class="row-title before-success">รายละเอียด</h5>
                <div class="col-md-12">
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
                                    'header' => '<a>#</a>',
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'headerOptions' => ['class' => 'kartik-sheet-style',]
                                    ],

                                    [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                        },
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                    'expandOneOnly' => true,
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['ext-pen']), //'/km4/Inventory/tb-st2-temp/ext-pen',
                                    ],
                                    [
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'attribute' => 'ItemName',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    ],
                                    [
                                    'header' => '<a>ขอเบิก</a>',
                                    'width' => '90px',
                                    'options' => ['style' => 'background-color:#fcf8e3;'],
                                    'headerOptions' => ['style' => 'text-align:center;background-color:#fcf8e3;', 'colspan'=>'2'],
                                    'attribute' => 'SRQty',
                                    'format' => ['decimal', 2],
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                        if ($model->SRQty == NULL) {
                                            return '0.00';
                                        } else {
                                            return $model->SRQty;
                                            }
                                        }
                                    ],
                                    [
                                    'header' => '<a>อนุมัติ</a>',
                                    'width' => '90px',
                                    'attribute' => 'SRUnit',
                                    'options' => ['style' => 'background-color:#fcf8e3;'],
                                    'headerOptions' => ['style' => 'text-align:center;background-color:rgb(217, 237, 247);', 'colspan'=>'2'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->SRUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->SRUnit;
                                            }
                                        }
                                    ],
                                    [
                                    'width' => '90px',
                                    'headerOptions' => ['hidden'=>true],
                                    'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                    'attribute' => 'STQty',
                                    'format' => ['decimal', 2],
                                    'hAlign' => GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                        if ($model->STQty == NULL) {
                                            return '0.00';
                                        } else {
                                            return $model->STQty;
                                            }
                                        }
                                    ],
                                    [
                                    'width' => '90px',
                                    'headerOptions' => ['hidden'=>true],
                                    'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                    'attribute' => 'SRUnit',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->SRUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->SRUnit;
                                            }
                                        }
                                    ],
                                    [
                                    'class' => '\kartik\grid\DataColumn',
                                    'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                    'width' => '10px',
                                    'hidden' => true,
                                    'group' => true, // enable grouping
                                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                        return [
                                            'mergeColumns' => [
                                                [1, 3],
                                                [7, 8]
                                            ], // columns to merge in summary
                                            'content' => [// content to show in each summary cell
                                                1 => '',
                                                4 => '<font color="black">จำนวน</font>',
                                                5 => '<font color="black">หน่วย</font>',
                                                6 => '<font color="black">จำนวน</font>',
                                                7 => '<font color="black">หน่วย</font>',
                                            ],
                                            'contentOptions' => [// content html attributes for each summary cell
                                                0 => ['style' => 'background-color: #dff0d8'],
                                                1 => ['style' => 'background-color: #dff0d8'],
                                                3 => ['style' => 'color:green;text-align:center;background-color: #fcf8e3'],
                                                4 => ['style' => 'color:green;text-align:center;background-color: #fcf8e3'],
                                                5 => ['style' => 'color:green;text-align:center;background-color: #fcf8e3'],
                                                6 => ['style' => 'color:green;text-align:center;background-color: rgb(217, 237, 247)'],
                                                7 => ['style' => 'color:green;text-align:center;background-color: rgb(217, 237, 247)']
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
                            <?= $form->field($model, 'STNote')->textarea(['maxlength' => true, 'rows' => 4]) ?>
                        </div>  
                    </div>
                    <div style="text-align: right;margin-right: 10px">
                        <?php if ($status == '0') { ?>
                            <?php if ($_SESSION['chk_type']=='receive') { ?>
                            <a class="btn btn-default" href="/km4/Inventory/tbst2/stock-receive">Close</a>
                            <?php Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                            <a class="btn btn-primary ladda-button" id="_stock_receive" data-style="expand-left" href="javascript:void(0)">Stock Receive</a>
                        <?php } else { ?>
                             <a class="btn btn-default" href="/km4/Inventory/tbst2/stock-wait">Close</a>
                        <?php } ?> 
                        <?php } else { ?>
                            <a class="btn btn-default" href="/km4/Inventory/tbst2/stock-receive-history">Close</a>
                        <?php } ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        <?php
        $s = <<< JS

function datenows() {
   
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!

    var yyyy = today.getFullYear() + 543;
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    var today = dd + '/' + mm + '/' + yyyy;

    $("#tbst2-strecieveddate").val(today);
}
$(function () {
      datenows();
});

    $('#_stock_receive').click(function (e) {
            var tbst2strecieveddate = $('#tbst2-strecieveddate').val();
                if(tbst2strecieveddate !== ""){
                 swal({
            title: "ยืนยันคำสั่ง ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#53a93f",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
           var l = $('.ladda-button').ladda();
               l.ladda('start');
          $.ajax({
            url: '/km4/Inventory/tbst2/recive-data',
            type: 'POST',
            data:$("#form_recive").serialize(),
            success: function (data) {
              setTimeout("location.href = '/km4/Inventory/tbst2/stock-receive';",2000);   
            }
      });
                }
                });
                }else{
                 swal("", "กรุณากรอกวันที่รับเข้าสินค้า", "warning");    
                $('#tbst2-strecieveddate').val('');
   }
    });
JS;
        $this->registerJs($s);
        ?>