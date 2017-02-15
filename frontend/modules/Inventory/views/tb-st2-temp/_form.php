<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use app\modules\Inventory\models\TbStk;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStstatus;
use app\modules\Inventory\models\TbSttype;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;
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

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbSt2Temp */
/* @var $form yii\widgets\ActiveForm */
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
                    <?php $form->field($model, 'STTypeID')->textInput() ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">ประเภทการขอเบิก</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left"  value="<?php
                            if ($model->STTypeID == 1) {
                                echo 'Stock Transfer';
                            } else if ($model->STTypeID == 2) {
                                echo 'ส่งสินค้าเคลม';
                            } else if ($model->STTypeID == 3) {
                                echo 'ส่งคืนสินค้ายืม';
                            } else if ($model->STTypeID == 4) {
                                echo 'ส่งสินค้าให้ยืม';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->STTypeID; ?>" name="TbSt2Temp[STTypeID]" />
                    <?php
                    $form->field($model, 'STTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbSttype::find()->all(), 'STTypeID', 'STTypeDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php $form->field($model, 'STDate')->textInput() ?>
                    <?php
                    echo
                    $form->field($model, 'STDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'readonly' => TRUE,
                        ],
                    ])
                    ?>
                    <?php $form->field($model, 'STIssue_StkID')->textInput() ?>
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
                    $form->field($model, 'STStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStstatus::find()->all(), 'STStatusID', 'STStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <h5 class="row-title before-success">รายละเอียด</h5>
                <div style="margin: 20px">
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
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'class' => 'kartik\grid\ExpandRowColumn',
                                        'value' => function ($model, $key, $index, $column) {
                                            return GridView::ROW_COLLAPSED;
                                        },
                                        'headerOptions' => ['class' => 'kartik-sheet-style',],
                                        'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                        'expandOneOnly' => true,
                                        'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                        'detailUrl' => \yii\helpers\Url::to(['ext-pen']), //'/km4/Inventory/tb-st2-temp/ext-pen',
                                    ],
                                    [
                                        'headerOptions' => ['style' => 'text-align:center;'],
                                        'attribute' => 'ItemID',
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->ItemID == NULL) {
                                        return '-';
                                    } else {
                                        return $model->ItemID;
                                    }
                                }
                                    ],
                                    [
                                        'headerOptions' => ['style' => 'text-align:center;'],
                                        'attribute' => 'ItemName',
                                        'hAlign' => GridView::ALIGN_LEFT,
                                        'value' => function ($model) {
                                    if ($model->ItemName == NULL) {
                                        return '-';
                                    } else {
                                        return $model->ItemName;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '<a>ขอเบิก</a>',
                                        'width' => '100px',
                                        'headerOptions' => ['style' => 'text-align:center;background-color:#fcf8e3;', 'colspan'=>'2'],
                                        'attribute' => 'SRQty',
                                        'format' => ['decimal', 2],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->SRQty == NULL) {
                                        return '0.00';
                                    } else {
                                        return $model->SRQty;
                                    }
                                }
                                    ],
                                    [
                                        'header' => '<a>ยอดโอน</a>',
                                        'width' => '100px',
                                        'attribute' => 'SRUnit',
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
                                        'header' => '<a>Actions</a>',
                                        'width' => '100px',
                                        'attribute' => 'STQty',
                                        'format' => ['decimal', 2],
                                        'headerOptions' => ['style' => 'text-align:center;background-color:#dff0d8;'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->STQty == NULL) {
                                        return '0.00';
                                    } else {
                                        return $model->STQty;
                                    }
                                }
                                    ],
                                    [
                                        'attribute' => 'SRUnit',
                                        'width' => '100px',
                                        'headerOptions' => ['hidden'=>true],
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
                                        'class' => 'kartik\grid\ActionColumn',
                                        'noWrap' => true,
                                        'options' => ['style' => 'width:100px;'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                        'headerOptions' => ['hidden'=>true],
                                        'template' => ' {view}',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'buttons' => [
                                            'view' => function ($url, $model, $key) {



                                                $model = 'selectlot';
                                                return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
                                                            'class' => 'activity-view-link',
                                                            'title' => 'Select',
                                                            'data-toggle' => 'modal',
                                                            //  'data-target' => '#lotselect_',
                                                            'data-id' => $key,
                                                            'data-pjax' => '0',
                                                ]);
                                            },
                                                    'update' => function ($url, $model, $key) {
                                                if ($model->ids_st != null) {
                                                    return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                'class' => 'activity-update-link',
                                                                'title' => 'แก้ไขข้อมูล',
                                                                'data-toggle' => 'modal',
                                                                'data-target' => '#gpu-modal',
                                                                'data-id' => $key,
                                                                'data-pjax' => '0',
                                                    ]);
                                                }
                                            }
                                                    ,
                                                    'deletegpu' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                            //  'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                            'title' => 'Delete',
                                                            'data-toggle' => 'modal',
                                                            //'data-method' => "post",
                                                            //'role' => 'modal-remote',
                                                            'data-id' => $key,
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
                                                    if($model->STQty=='0'||$model->STQty==''){
                                                        $name_btn = 'Auto Lot';
                                                        $class_btn = 'btn btn-xs btn-success';
                                                        $title_btn = 'Auto';
                                                    }else{
                                                        $name_btn = 'Auto Lot';
                                                        $class_btn = 'btn btn-xs btn-success';
                                                        $title_btn = 'Auto';
                                                    }
                                                    return [
                                                        'mergeColumns' => [
                                                            [1, 3],
                                                            [8, 9]
                                                        ], // columns to merge in summary
                                                        'content' => [// content to show in each summary cell
                                                            1 => '',
                                                            4 => '<font color="black">จำนวน</font>',
                                                            5 => '<font color="black">หน่วย</font>',
                                                            6 => '<font color="black">จำนวน</font>',
                                                            7 => '<font color="black">หน่วย</font>',
                                                            8 =>  Yii::$app->controller->action->id =='create' ? Html::a($name_btn, 'javascript:void(0)', [
                                                                'class' => $class_btn,
                                                                'title' => $title_btn,
                                                                'onclick' => 'autolot(this)',
                                                                ]) : '',
                                                        ],
                                                        'contentOptions' => [// content html attributes for each summary cell
                                                            0 => ['style' => 'background-color: #dff0d8'],
                                                            1 => ['style' => 'background-color: #dff0d8'],
                                                            4 => ['style' => 'color:green;text-align:center;background-color: #fcf8e3'],
                                                            5 => ['style' => 'color:green;text-align:center;background-color: #fcf8e3'],
                                                            6 => ['style' => 'color:green;text-align:center;background-color: rgb(217, 237, 247)'],
                                                            7 => ['style' => 'color:green;text-align:center;background-color: rgb(217, 237, 247)'],
                                                            8 => ['style' => 'text-align:center;background-color: #dff0d8']
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
                                    <?= $form->field($model, 'STNote')->textarea(['maxlength' => true, 'rows' => '4', 'style' => 'backgroup']) ?>
                                </div>
                                <div class="form-group" style="text-align: right;">
                                    <div class="col-sm-12">
                                        <?= Yii::$app->controller->action->id =='create' ? Html::a('Close', ['spicking'], ['class' => 'btn btn-default']) : Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                                        <!-- <a class="btn btn-danger" id="_clear" href="javascript:void(0)">Clear</a> -->
                                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?>
                                        <div class="btn-group">
                                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Print
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <?= Html::a('<i class="text-danger fa fa-file-pdf-o"></i> A4', ['/Report/report-inventory/stocktranfer', 'STID' => $model['STID']], ['data-pjax' => 0, 'target' => '_blank']); ?>
                                                </li>
                                                <li>
                                                    <?= Html::a('<i class="text-muted fa fa-file-text-o"></i> Slip', ['/Report/report-inventory/slip-stocktranfer', 'STID' => $model['STID']], ['data-pjax' => 0, 'target' => '_blank']); ?>
                                                </li>
                                            </ul>
                                        </div>
                                        <!--                                    <a class="btn btn-info disabled" id="print_tran" href="javascript:void(0)">ใบโอนสินค้าระหว่างคลัง</a>-->
                                        <a class="btn btn-info ladda-button disabled" data-style="expand-left" id="_stock_issu" href="javascript:void(0)">Stock Issu</a>
                                    </div>
                                </div>

                                <div style="text-align: right;margin-right: 10px">


                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                $s = <<< JS
                        
 $('#tbst2temp-strecieve_stkid').on('change', function() {  
     var tbsr2tempsrreceivestkid =   $('#tbst2temp-strecieve_stkid').val();
     var tbsr2tempsrissuestkid =  $('#tbst2temp-stissue_stkid').val();
    if(tbsr2tempsrreceivestkid == tbsr2tempsrissuestkid){
         $("#tbst2temp-strecieve_stkid").val('').trigger("change");                  
     }                           
}); 
    
$('#tbst2temp-stissue_stkid').on('change', function() {   
     var tbsr2tempsrreceivestkid =   $('#tbst2temp-strecieve_stkid').val();
     var tbsr2tempsrissuestkid =  $('#tbst2temp-stissue_stkid').val();
    if(tbsr2tempsrreceivestkid == tbsr2tempsrissuestkid){
         $("#tbst2temp-stissue_stkid").val('').trigger("change");                  
     }                    
});  
                                        
$('#_clear').click(function (e) {
           swal({
            title: "ยืนยันคำสั่ง ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
          run_waitMe(2);
          $.ajax({
            url: '/km4/Inventory/tb-st2-temp/_clear',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) {
               window.location.replace("/km4/Inventory/tb-st2-temp");
            }
         });
       }
      });
 }); 
$('#print_tran').click(function (e) {      
     window.open("/km4/Report/report-inventory/stocktranfer?STID="+$('#stid').val(),'_blank');     
 });                 
   $('#_stock_issu').click(function (e) {
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
            run_waitMe(2);          
          $.ajax({
            url: '/km4/Inventory/tb-st2-temp/cmd-st2-stk-issu',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) { 
             setTimeout("location.href = '/km4/Inventory/tb-st2-temp';", 10);
            }
                
      });
    }
                });
    }); 
function init_click_handlers() {
      $('.activity-view-link').click(function (e) {
        var ids_sr = $(this).closest('tr').data('key');   
        var fID = $(this).closest('tr').children('td:eq(2)').text();
        var stkid = $('#tbst2temp-stissue_stkid').val();
        var  srid = $('#srid').val();
        run_waitMe(2);
        $.get(
                '/km4/Inventory/tb-st2-temp/select-lot',
                {
                                        'ids_sr':ids_sr,
                    id: fID,
                stkid:stkid,
                    srid:srid
                },
        function (data)
        {
          $('#formdetail').html(data);
           waitMe_hide(2); 
          $('#lotselect_').modal('show');
        }
        );
   
   });
            
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var stkid = $('#tbst2temp-stissue_stkid').val();
        var srid = $('#srid').val();
     if(stkid!==""){
         run_waitMe(2);
        $.ajax({
                url: '/km4/Inventory/tb-st2-temp/edit-detail',
            data:{id:fID,stkid:stkid,srid:srid},
            type: 'GET',
            success: function (data) {
                    $('#resultedi_detail').html(data);
                     waitMe_hide(2); 
                    $('#resultedi').modal('show');
                }
             });
          }else{
              waitMe_hide(2); 
             swal("", "กรุณาเลือกขอเบิกจากคลังสินค้า", "warning");     
       }
        });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
       swal({
            title: message_confirmdelete,
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
                run_waitMe(2);
                $.post(
                        '/km4/Inventory/tb-st2-temp/delete-detail',
                        {
                            id: fID
                        },
                function (data)
                {
                    waitMe_hide(2); 
                    $.pjax.reload({container: '#sr2_detail_'});
                }
                );
            }
        });
    });
}
init_click_handlers(); //first run
$('#sr2_detail_').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
                        
JS;
                $this->registerJs($s);
                ?>

                <?php
                $script = <<< JS
$(document).ready(function () {
    $('#issue_savedraf').removeClass('disabled');
    $('#form_st_main').on('beforeSubmit', function(e)
    {
  run_waitMe(2);
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
            //$(\$form).trigger("reset");
                $('#tbst2temp-stnum').val(result);
                 swal("Save Complete!", "", "success");       
                $('#_stock_issu').removeClass('disabled');
                $('#print_tran').removeClass('disabled');
                waitMe_hide(2);            
            } else
            {
                $("#message").html(result);
                waitMe_hide(2);    
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });
    
});
JS;
                $this->registerJs($script);
                ?>

                <?php
                Modal::begin([
                    'id' => 'lotselect_',
                    'header' => '<h4 class="modal-title">เลือก Lot Number</h4>',
                    'size' => 'modal-dialog modal-lg',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                ]);
                ?>
                <div id="formdetail"></div>
                <?php
                Modal::end();

                Modal::begin([
                    'id' => 'determinethenumber',
                    'header' => '<h4 class="modal-title">กำหนดจำนวน</h4>',
                    'size' => 'modal-dialog modal-lg',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                ]);
                ?>

                <div id="determinethenumber_detail"></div>
                <?php
                Modal::end();
                Modal::begin([
                    'id' => 'resultedi',
                    'header' => '<h4 class="modal-title">กำหนดจำนวน</h4>',
                    'size' => 'modal-dialog modal-lg',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                ]);
                ?>
                <div id="resultedi_detail">
                </div>
                <?php Modal::end(); ?>
<script>
    function autolot(){
        var SRID = $("#srid").val();
        var STID = $("#stid").val();
        swal({
        title: 'Auto Lot',
        text: "ยืนยันคำสั่ง ?",
        type: "warning",
        confirmButtonColor: "#dd6b55",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true
    },
    function (isConfirm) {
        if (isConfirm) {           
            $.post(
                    '/km4/Inventory/tb-st2-temp/autolot',
                    {
                        SRID: SRID, STID:STID
                    },
            function (data)
            {    
                $.pjax.reload({container: '#sr2_detail_'});
            }
            ).fail(function(xhr, status, error){
                swal("Opps...", error, "error");
            });
        }
    });
    }

    function run_waitMe(type) {
        if (type == '1') {
            var idnaclass = '.modal-content';
        } else if (type == '2') {
            var idnaclass = '.main-container';
        }
        $(idnaclass).waitMe({
            effect: 'ios',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }
    function waitMe_hide(type) {
        if (type == '1') {
            $('.modal-content').removeClass('waitMe_container');
            $('.waitMe').html('');
        } else if (type == '2') {
            $('.main-container').removeClass('waitMe_container');
        }
    }
</script>



