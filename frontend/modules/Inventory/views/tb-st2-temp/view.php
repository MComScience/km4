<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use app\modules\Inventory\models\Tbstk;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStstatus;
use app\modules\Inventory\models\TbSttype;
use yii\jui\DatePicker;
use yii\bootstrap\Modal;

$this->title = 'บันทึกใบโอนสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'โอนสินค้า', 'url' => ['index']];
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
                    ])->label('รับเข้าคลังสินค้า');;
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
                    <?php echo $form->field($model, 'STDate')->textInput() ?>
                    <?php
                    
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
                    ])->label('ขอเบิกจากคลังสินค้า');
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
                <h5 class="row-title before-success">รายละเอียดใบโอนสินค้า</h5>
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
                                    'header' => '<font color="black">#</font>',
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd']
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:black;text-align:center;background-color: #ddd'],
                                    'detailAnimationDuration' => 'slow', //fast'expandOneOnly' => true,
                                    'expandOneOnly' => true,
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['ext-pen2']), //'index.php?r=Inventory/tb-st2-temp/ext-pen',
                                ],
                                [
                                    'header' => '<font color="black">รหัสสินค้า</font>',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
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
                                    'header' => '<font color="black">รายละเอียดสินค้า</font>',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
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
                                    'header' => '<font color="black">ขอเบิก</font>',
                                    'width' => '150px',
                                    'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
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
                                    'header' => '',
                                    'attribute' => 'SRUnit',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
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
                                    'header' => '<font color="black">ยอดโอน</font>',
                                    'width' => '150px',
                                    'attribute' => 'STQty',
                                    'format' => ['decimal', 2],
                                    'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
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
                                    'header' => '',
                                    'attribute' => 'SRUnit',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
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
                                    'header' => '<font color="black">Actions</font>',
                                    'noWrap' => true,
                                    'options' => ['style' => 'width:100px;'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'template' => '',
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
                                                    ],
                                                    'contentOptions' => [// content html attributes for each summary cell
                                                        0 => ['style' => 'background-color: #ddd'],
                                                        1 => ['style' => 'background-color: #ddd'],
                                                        4 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        5 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        6 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        7 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        8 => ['style' => 'background-color: #ddd']
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
                                        <?= $form->field($model, 'STNote')->textarea(['maxlength' => true, 'rows' => '4']) ?>
                                </div>
                                <div style="text-align: right;margin-right: 10px">
                                    <a class="btn btn-default"  href="index.php?r=Inventory/tb-st2-temp">Close</a>
                                    <!--<a class="btn btn-danger" id="_clear" href="javascript:void(0)">Clear</a>-->
                                    <?php Html::submitButton($model->isNewRecord ? 'Create' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                                    <!--<a class="btn btn-info" disabled id="_stock_issu" href="javascript:void(0)">Stock Issu</a>-->
                                </div>
                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='images/712.gif' width="64" height="64" /><br>Loading..</div>
                                <?php
                                $s = <<< JS
 $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
      });
     $(document).ajaxComplete(function(){
         $("#wait").css("display", "none");
     });

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
            title: "Are you sure?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {                              
          $.ajax({
            url: 'index.php?r=Inventory/tb-st2-temp/_clear',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) {
               window.location.replace("index.php?r=Inventory/tb-st2-temp");
            }
         });
       }
      });
    }); 
                
   $('#_stock_issu').click(function (e) {
     swal({
            title: "Are you sure?",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
          $.ajax({
            url: 'index.php?r=Inventory/tb-st2-temp/cmd-st2-stk-issu',
            type: 'POST',
            data:$("#form_st_main").serialize(),
            success: function (data) {
             swal("", "stock_issu Successfully!", "success");
           //  Notify('stock_issu Successfully!', 'top-right', '2000', 'success', 'fa-check', false);   
             window.location.replace("index.php?r=Inventory/tb-st2-temp");
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
        $.get(
                'index.php?r=Inventory/tb-st2-temp/select-lot',
                {
                                        'ids_sr':ids_sr,
                    id: fID,
                stkid:stkid,
                    srid:srid
                },
        function (data)
        {
          $('#formdetail').html(data);
          $('#lotselect_').modal('show');
        }
        );
   
   });
            
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var stkid = $('#tbst2temp-stissue_stkid').val();
        var srid = $('#srid').val();
     if(stkid!==""){                         
        $.ajax({
                url: 'index.php?r=Inventory/tb-st2-temp/edit-detail',
            data:{id:fID,stkid:stkid,srid:srid},
            type: 'GET',
            success: function (data) {
                  //  $('#header_tpund').html('แก้ไขข้อมูล');
                    $('#resultedi_detail').html(data);
                    $('#resultedi').modal('show');
                }
             });
          }else{
             swal("", "กรุณาเลือกขอเบิกจากคลังสินค้า", "warning");     
             // alert('กรุณาเลือกขอเบิกจากคลังสินค้า');
       }
        });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
       bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                $.post(
                        'index.php?r=Inventory/tb-st2-temp/delete-detail',
                        {
                            id: fID
                        },
                function (data)
                {
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
         //On Save
    $('#form_st_main').on('beforeSubmit', function(e)
    {
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
                 // Notify('Saved Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
                 swal("", "บันทึกรายการแล้ว", "success");       
                $('#_stock_issu').removeAttr('disabled');
            } else
            {
            $("#message").html(result);
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
                    'size' => 'modal-dialog modal-lg'
                ]);
                ?>
                <div id="formdetail"></div>
                <?php
                Modal::end();

                Modal::begin([
                    'id' => 'determinethenumber',
                    'header' => '<h4 class="modal-title">กำหนดจำนวน</h4>',
                    'size' => 'modal-dialog modal-lg'
                ]);
                ?>

                <div id="determinethenumber_detail"></div>
                <?php
                Modal::end();
                Modal::begin([
                    'id' => 'resultedi',
                    'header' => '<h4 class="modal-title">กำหนดจำนวน</h4>',
                    'size' => 'modal-dialog modal-lg'
                ]);
                ?>
                <div id="resultedi_detail">
                </div>
                <?php Modal::end(); ?>



