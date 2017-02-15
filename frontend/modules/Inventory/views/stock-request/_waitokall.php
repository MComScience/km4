<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\Tbstk;
use app\modules\Inventory\models\Tbsrtype;
use app\models\TbDepartment;
use kartik\depdrop\DepDrop;
use yii\jui\DatePicker;
use app\modules\Inventory\models\Tbsrstatus;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\Tbsr2 */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'อนุมัติใบขอเบิกสินค้า';
$this->params['breadcrumbs'][] = ['label' => 'ใบขอเบิกสินค้า', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title
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
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_main']); ?>
            <input type="hidden" value="<?php echo $model->SRID ?>" name="srid" id="srid_"/>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNum')->textInput(['disabled' => 'disabled']) ?>
                    <?php
                    echo $form->field($model, 'SRReceive_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('รับเข้าคลัง <font color=red>*</font>');
                    ?>
                    <?php
                    echo $form->field($model, 'SRTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrtype::find()->all(), 'SRTypeID', 'SRType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <?php
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-department',
                        'prompt' => 'เลือกฝ่าย',
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'ddl-section'],
                        'data' => [$section],
                        'disabled' => 'disabled',
                        'pluginOptions' => [
                            'depends' => ['ddl-department'],
                            //  'placeholder' => 'เลือกอำเภอ...',
                            'url' => Yii::$app->request->baseUrl . '/index.php?r=Purchasing/tbpcplan/getsection'
                        ]
                    ]);
                    ?>
                    <?php
                    echo $form->field($model, 'SRDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'readonly' => true
                        ],
                    ])->label('วันที่ <font color=red>*</font>')
                    ?>
                    <?php
                    echo $form->field($model, 'SRIssue_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('เบิกจากคลัง <font color=red>*</font>');
                    ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะใบขอเบิก</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left"  value="<?php
                            if ($model->SRStatus == 1) {
                                echo 'Draft';
                            } else {
                                echo 'Active';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->SRStatus; ?>" name="Tbsr2[SRStatus]" />
                    <?php
                    $form->field($model, 'SRStatus')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrstatus::find()->all(), 'SRStatusID', 'SRStatusDesc'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <h5 class="row-title before-success">รายละเอียดใบขอเบิก</h5>
            <div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src='images/712.gif' width="64" height="64" /><br>Loading..</div>
            <div>
                <a class="btn btn-success ladda-button" data-style ='expand-left' id="addtpu" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> รายการยา</i></a> <a class="btn btn-success ladda-button" data-style ='expand-left' id="addnd" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> รายการเวชภัณฑ์</i></a>
                <br>
                <br>
                <?php if (!empty($searchModel)) { ?>
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
                                    'header' => '<font color="black">รหัสสินค้า</font>',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">รายละเอียดยา</font>',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'attribute' => 'ItemName',
                                    'hAlign' => GridView::ALIGN_LEFT,
                                    'value' => function ($model) {
                                if ($model->sr2detail['ItemDetail'] == NULL) {
                                    return '-';
                                } else {
                                    return $model->sr2detail->ItemDetail;
                                }
                            }
                                ],
                                [
                                    'header' => '<font color="black">ขอเบิก</font>',
                                    'width' => '150px',
                                    'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                    'attribute' => 'SRPackQty',
                                    'format' => ['decimal', 2],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->sr2detail['SRQty'] == NULL) {
                                    return '0.00';
                                } else {
                                    return $model->sr2detail->SRQty;
                                }
                            }
                                ],
                                [
                                    'header' => '',
                                    'attribute' => 'SRItemOrderQty',
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->sr2detail['SRUnit'] == NULL) {
                                    return '-';
                                } else {
                                    return $model->sr2detail->SRUnit;
                                }
                            }
                                ],
                                [
                                    'header' => '<font color="black">อนุมัติ</font>',
                                    'width' => '150px',
                                    'attribute' => 'SRPackQtyApprove',
                                    'format' => ['decimal', 2],
                                    'headerOptions' => ['style' => 'text-align:right;background-color: #ddd'],
                                    'hAlign' => GridView::ALIGN_CENTER,
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
                                    'attribute' => 'SRItemOrderQty',
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
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => '<font color="black">Actions</font>',
                                    'noWrap' => true,
                                    'options' => ['style' => 'width:100px;'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'background-color: #ddd'],
                                    'template' => ' {view} {update} {deletegpu}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        'view' => function ($url, $model, $key) {
                                            if ($model->SRPackQtyApprove == '') {
                                                $status = '';
                                            } else {
                                                $status = 'disabled';
                                            }
                                            return Html::a('<span class="btn btn-success  ' . $status . ' btn-xs">OK</span>', 'javascript:void(0)', [
                                                        'class' => 'activity-view-link' . $status,
                                                        'title' => 'OK',
                                                        // 'data-toggle' => 'modal',
                                                        //  'data-target' => '#gpu-modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                                        $status => $status,
                                            ]);
                                        },
                                                'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                        'class' => 'activity-update-link',
                                                        'title' => 'แก้ไขข้อมูล',
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#gpu-modal',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
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
                                                        [1, 2],
                                                        [7, 8]
                                                    ], // columns to merge in summary
                                                    'content' => [// content to show in each summary cell
                                                        1 => '',
                                                        3 => '<font color="black">จำนวน</font>',
                                                        4 => '<font color="black">หน่วย</font>',
                                                        5 => '<font color="black">จำนวน</font>',
                                                        6 => '<font color="black">หน่วย</font>',
                                                        7 => Html::a('OK All', 'javascript:void(0)', [
                                                                'class' => 'btn btn-xs btn-success',
                                                                'title' => 'OK',
                                                                'onclick' => 'okall(this)',
                            
                                                            ]),
                                                    ],
                                                    'contentOptions' => [// content html attributes for each summary cell
                                                        0 => ['style' => 'background-color: #ddd'],
                                                        1 => ['style' => 'background-color: #ddd'],
                                                        3 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        4 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        5 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        6 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                        7 => ['style' => 'text-align:center;background-color: #ddd']
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
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'SRNote')->textArea(['maxlength' => true, 'rows' => '4','style'=>"text-align: right; background-color: rgb(255, 255, 153);"]) ?>
                                </div>
                            </div>
                            <div style="text-align: right;margin-right: 10px">
                                <a href="index.php?r=Inventory/stock-request/wait-approve-pharmacys" class="btn btn-default">Close</a>
                                <button type="reset" class="btn btn-danger">Clear</button>
                                <a id="reject" class="btn btn-warning">Reject</a>
                                <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?> <a class="btn btn-info disabled ladda-button"  data-style = 'expand-left' id="approve"  href="javascript:void(0)">Approve</a>
                            </div>
                            <?php ActiveForm::end(); ?>

                        </div>
                    </div>
                    <?php
                    Modal::begin([
                        'id' => 'tpu_sr2_detail_list',
                        'header' => '<h4 class="modal-title"><div id="header_tpund"/></h4>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => FALSE,
                        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                    ]);
                    ?>
                    <div id="datatpu"></div>
                    <?php Modal::end(); ?>
                    <?php
                    Modal::begin([
                        'id' => 'tpu_sr2_detail_list2',
                        'header' => '<h4 class="modal-title"><div id="header_tpund2"/></h4>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => FALSE,
//                        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
                    ]);
                    ?>
                    <div id="datatpu2"></div>
                    <?php Modal::end(); ?>
                    <?php
                    $s = <<< JS
   
      //On Save
    $('#form_main').on('beforeSubmit', function(e)
    {
       run_waitMe(2);
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
                 
      if (result == 1)
          {
               swal("", "Save Complete!", "success");
               waitMe_hide(2);  
               $('#approve').removeClass('disabled');  
          } else
           {
            waitMe_hide(2);
            $("#message").html(result);
          }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });               
                                   
    $('#addtpu').click(function (e) {
         var tbsr2srissuestkid = $('#tbsr2-srissue_stkid').val();
         var tbsr2srreceivestkid = $('#tbsr2-srreceive_stkid').val();
         var SRID = $('#srid_').val();
       run_waitMe(2);
          $.ajax({
            url: 'index.php?r=Inventory/stock-request/gettpu2',
            type: 'POST',
            data:{stkid:tbsr2srissuestkid,receivestkid:tbsr2srreceivestkid,SRID:SRID},
            dataType: 'json',
            success: function (data) {
                $('#header_tpund').html('เลือกรายการยาการค้า');
                $('#datatpu').html(data);
                $('#tpu_sr2_detail_list').modal('show');
                $('#data_tpu').DataTable({
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
	        waitMe_hide(2);
            }
      });
                });
    $('#addnd').click(function (e) {
            var tbsr2srissuestkid = $('#tbsr2-srissue_stkid').val();
         var tbsr2srreceivestkid = $('#tbsr2-srreceive_stkid').val();
         var SRID = $('#srid_').val();
                 run_waitMe(2);
          $.ajax({
            url: 'index.php?r=Inventory/stock-request/getnd2',
            type: 'POST',
            data:{stkid:tbsr2srissuestkid,receivestkid:tbsr2srreceivestkid,SRID:SRID},
            dataType: 'json',
            success: function (data) {
                $('#header_tpund').html('เลือกรายการเวชภัณฑ์');
                $('#datatpu').html(data);
                $('#tpu_sr2_detail_list').modal('show');
                $('#data_tpu').DataTable({
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
                               
	        waitMe_hide(2);
            }
      });
});  
    /*$('#_clear').click(function (e) {
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
        run_waitMe(2);
        $.ajax({
            url: 'index.php?r=Inventory/stock-request/savesendtoapprove',
            data:$("#form_main").serialize(),
            type: 'POST',
           // dataType: 'json',
            success: function (data) {
             // window.location.replace("index.php?r=Inventory/vwsr2listdraf");
               Notify('Save & Send to Approve Successfully!', 'top-right', '10', 'success', 'fa-check', false);
               
            }
      });
         }
            });             
   });*/

    $('#reject').click(function (e) { 
        $('#reject_').modal('show');            
    });
                    
    $('#save_reject').click(function (e){
       var srid = $('#srid_').val();
       var SRRejectNote = $('#reject_detail').val();
        run_waitMe(2);
        $.ajax({
            url: 'index.php?r=Inventory/stock-request/rejecct',
            data:{id:srid,SRRejectNote:SRRejectNote},
            type: 'GET',
            success: function (data) {
                if(data =='1'){
                 swal("", "Reject Successfully!", "success");
                 setTimeout("location.href = 'index.php?r=Inventory/stock-request/wait-approve-pharmacys';",10);  
   }
        }
      });  
                    
   });
                    
    $('#approve').click(function (e){
         swal({
            title: "ยืนยันการอนุมัติ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#53a93f",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {
        var srid = $('#srid_').val();
         run_waitMe(2);
        $.ajax({
            url: 'index.php?r=Inventory/stock-request/sr2_approve',
            data:{id:srid},
            type: 'GET',
            success: function (data) {
                 setTimeout("location.href = 'index.php?r=Inventory/stock-request/wait-approve-pharmacys';",10);   
        }
     }); 
      }
  });              
});                
function init_click_handlers() {
    $('.activity-view-link').click(function (e) {
     var fID = $(this).closest('tr').data('key');
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
        $.get(
                'index.php?r=Inventory/stock-request/cmd_sr2_approve_ok',
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
    }
);
                 
    });
            
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
         run_waitMe(2);
               $.ajax({
                    url: 'index.php?r=Inventory/stock-request/detailedit',
            data:{id:fID},
            type: 'GET',
            success: function (data) {
            $('#header_tpund2').html('แก้ไขข้อมูล');
            $('#datatpu2').html(data);
            $('#tpu_sr2_detail_list2').modal('show');
             waitMe_hide(2);                
        }
      });                   
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
                        'index.php?r=Inventory/stock-request/delete-detail',
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
                    Modal::begin([
                        'id' => 'reject_',
                        'header' => '<h4 class="modal-title">เหตุผลการ Reject</h4>',
                        'size' => 'modal-fade modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => FALSE,
                    ]);

                    ActiveForm::begin([ 'id' => 'formdetail']);
                    ?>

                    <div class="row">
                        <div class="form-group">

                            <div class="col-sm-12">
                                <textarea rows="3" class="form-control" id="reject_detail" name="reject"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="modal-footer" >
                                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                                <a class="btn btn-warning" id="save_reject" href="javascript:void(0)">Reject</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    ActiveForm::end();
                    Modal::end();
                    ?>
                    <?php
                    Modal::begin([
                        'id' => 'save_detail',
                        'header' => '<h4 class="modal-title">บันทึกรายการใบขอเบิก</h4>',
                        'size' => 'modal-lg modal-primary',
                        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                        'closeButton' => FALSE,
                    ]);
                    ?>
                    <div id="detailitem_save"/>
                    <?php Modal::end(); ?>
    <script>
        function okall(){
            var SRID = $("#srid_").val();
            swal({
            title: 'ยืนยัน',
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) {           
                $.post(
                        'index.php?r=Inventory/stock-request/okall',
                        {
                            SRID: SRID
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
        function SelectGPU(id, type, balance) {
            run_waitMe(1);
            var SRID = $("#srid_").val();
            $.ajax({
                url: 'index.php?r=Inventory/stock-request/detailselect2',
                type: 'POST',
                data: {id: id, SRID: SRID, type: type, balance: balance},
                success: function (data) {
                    if (data == 'false') {
                        swal("", "รายการนี้ถูกบันทึกแล้ว", "warning");
                        waitMe_hide(1);
                    } else {
                        $('#formdetail').trigger("reset");
                        $('#save_detail').find('.modal-body').html(data);
                        $('#detailitem_save').html(data);
                        $('#save_detail').modal('show');
                        waitMe_hide(1);
                    }
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
