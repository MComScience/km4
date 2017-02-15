<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use app\modules\Inventory\models\TbStk;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbSatype;
use kartik\grid\GridView;
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
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_sa_main']); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SAID')->hiddenInput()->label(false); ?>
                    <?= $form->field($model, 'SANum')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">ประเภทเอกสาร</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="Tb" value="<?php
                            if ($model->SATypeID == 1) {
                                echo 'ปรับปรุงยอดสินค้าคงคลัง';
                            } else if ($model->SAStatus == 2) {
                                echo 'Active';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->SATypeID; ?>" name="TbPcplan[SATypeID]" />
                    <?php
                    $form->field($model, 'SATypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbSatype::find()->all(), 'SATypeID', 'SAType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                            if ($model->SAStatus == 1) {
                                echo 'Draft';
                            } else if ($model->SAStatus == 2) {
                                echo 'Active';
                            } else if ($model->SAStatus == 3) {
                                echo 'Reject From Approve';
                            } else if ($model->SAStatus == 4) {
                                echo 'Approve';
                            } else if ($model->SAStatus == 5) {
                                echo 'Hold SA';
                            } else if ($model->SAStatus == 6) {
                                echo 'Draft Approve';
                            }
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->SAStatus; ?>" name="TbPcplan[PCPlanStatusID]" />
                    <?php
//                    echo $form->field($model, 'SAStatus')->widget(Select2::classname(), [
//                        'data' => ArrayHelper::map(TbSastatus::find()->all(), 'SAStatusID', 'SAStatusDesc'),
//                        'options' => ['placeholder' => 'Select a state ...'],
//                        'pluginOptions' => [
//                            'allowClear' => true,
//                        ],
//                    ]
//                            );
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo
                    $form->field($model, 'SADate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่ <font color="red">*</font>');
                    ?>
                    <?php if(!empty($_SESSION['ss_sectionid'])){
                    echo $form->field($model, 'SA_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('คลังสินค้า <font color="red">*</font>');
                    }else{
                    echo $form->field($model, 'SA_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbstk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('คลังสินค้า <font color="red">*</font>');
                    } ?>

                </div>
            </div>
            <h5 class="row-title before-success">รายละเอียดปรับปรุงยอด</h5>
            <br>
            <?php
            echo '<a class="btn btn-success ladda-button" id="addtpu" data-style="expand-left" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> รายการยา</i></a> <a class="btn btn-success ladda-button" data-style="expand-left" id="addnd" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> รายการเวชภัณฑ์</i></a>';
            ?>
            <br>
            <div style="margin: 20px">
                <?php if (!empty($searchModel)) { ?>
                    <div class="form-group">
                        <?php \yii\widgets\Pjax::begin(['id' => 'sa_detail_']) ?>
                        <?=
                        kartik\grid\GridView::widget([
                            'dataProvider' => $dataProvider,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => false,
                            'condensed' => true,
                            'toggleData' => true,
                            'layout' => Yii::$app->componentdate->layoutgridview2(),
                            'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                            'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                            'columns' => [
                                [
                                    'header' => '<font color="black">#</font>',
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => '']
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return GridView::ROW_COLLAPSED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'text-align:center;background-color: #ddd'],
                                    'detailAnimationDuration' => 'slow',
                                    'expandOneOnly' => true,
                                    'detailRowCssClass' => GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['ext-pen']),
                                ],
                                [
                                    'header' => '<font color="black">รหัสสินค้า</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'ItemID',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemID != null) {
                                    return $model->ItemID;
                                } else {
                                    return '-';
                                }
                            }
                                ],
                                [
                                    'header' => '<font color="black">รายละเอียดยา</font>',
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'attribute' => 'ItemName',
                                    'value' => function ($model) {
                                if ($model->ItemName == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemName;
                                }
                            }
                                ],
                                [
                                    'header' => '<font color="black">หน่วย</font>',
                                    'attribute' => 'DispUnit',
                                    'headerOptions' => ['style' => ''],
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->DispUnit == NULL) {
                                    return '-';
                                } else {
                                    return $model->DispUnit;
                                }
                            },
                                ],
                                [
                                    'header' => '<font color="black">ยอดในคลัง</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'OnhandLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">นับได้</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'ActualLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">ส่วนต่าง</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'AdjLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'header' => '<font color="black">ยอดหลังจากการปรับปรุง</font>',
                                    'headerOptions' => ['style' => ''],
                                    'attribute' => 'BalanceAdjLotItemQty',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => '<font color="black">Actions</font>',
                                    'noWrap' => true,
                                    'options' => ['style' => 'width:100px;'],
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => ''],
                                    'template' => '{deletegpu}',
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
                                                'deletegpu' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => 'Delete',
                                                        'data-toggle' => 'modal',
                                                        'data-id' => $key,
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'SANote')->textarea(['maxlength' => true, 'rows' => 3]) ?>
                        </div> 
                    </div>
                    <div style="text-align: right;margin-right: 10px">
                        <?php if ($appvo == '1') { ?>
                            <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                            <input type="hidden" name="status" value="1" />
                            <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?>
                            <?= Html::a('Send To Approve', 'javascript:void(0)', ['class' => 'btn btn-info disabled ladda-button', 'id' => '_sendtoapprove', 'data-style' => "expand-left"]) ?>
                            <?php } else if ($appvo == '2') { ?>
                            <?= Html::a('Close', 'wait-approve-prarmacy', ['class' => 'btn btn-default']) ?>
                            <?= Html::a('Reject', 'javascript:void(0)', ['class' => 'btn btn-warning', 'id' => '_Reject']) ?>
                            <input type="hidden" name="status" value="6" />
                            <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?>
                            <?= Html::a('Approve', 'javascript:void(0)', ['class' => 'btn btn-info disabled ladda-button', 'id' => '_approve', 'data-style' => "expand-left"]) ?>
                            <?php } else if ($appvo == '3') { ?>
                                <?= Html::a('Close', ['history'], ['class' => 'btn btn-default']) ?>
                            <?php } ?>
                               
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>

        <?php
        Modal::begin([
            'id' => '_item_list',
            'header' => '<h4 class="modal-title"><div id="header_tpund"/></h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="_item_list_detail"></div>
        <br>
        <?php Modal::end(); ?>
        <?php
        Modal::begin([
            'id' => 'save_detail',
            'header' => '<h4 class="modal-title"><div id="header_item"/></h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="detailitem_save"></div>
        <?php Modal::end(); ?>
        <?php
        Modal::begin([
            'id' => 'form_adjitem',
            'header' => '<h4 class="modal-title">ปรับปรุงยอดสินค้า</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
                //  'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="form_adjitem_detail"></div>
        <?php Modal::end(); ?>
        <script>
            function SelectGPU(id, type) {
                var SAID = $("#tbsa2-said").val();
                var tbsa2sastkid = $('#tbsa2-sa_stkid').val();

                $.ajax({
                    url: 'detail-select',
                    type: 'get',
                    data: {id: id, SAID: SAID, tbsa2sastkid: tbsa2sastkid},
                    success: function (data) {
                        if (data === 'false') {
                            swal("", 'รายการนี้ถูกบันทึกแล้ว!', "warning");
                            // Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                        } else {
                            $('#detailitem_save').html(data);
                            $('#header_item').html('เลือก Lot Number');
                            $('#save_detail').modal('show');
                        }
                    }
                });

            }
        </script>
        <div id="Reject_Approve" class="fade modal" role="dialog" tabindex="-1" style="display: none;">
            <div class="modal-dialog modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <font color="#"><h4 class="modal-title">เหตุผลการระบุไม่อนุมัติ</h4></font>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <textarea type="text" class="form-control" id="SaReason" name="SaReason" cols="100" rows="5" style="background-color: #ffff99;"></textarea>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <div class="col-xs-9 col-xs-offset-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="SaveRejectApprove" class="btn btn-warning">Rejected Approve</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $script = <<<JS
      
     
$('#_Reject').click(function (e) {
    $('#Reject_Approve').modal("show");
});  
          
$('#SaveRejectApprove').click(function (e) {
    var tbsa2said = $('#tbsa2-said').val();
    var SaReason = $('#SaReason').val();
    if (SaReason == "") {
            swal("", "ไม่สามารถ Reject ได้", "warning")     
    } else {
        $.ajax({
            url: 'sa-reject',
            type: 'POST',
            data: {SaReason: SaReason, tbsa2said: tbsa2said},
            success: function (data) {
                if (data == '1') {
                swal("", "Reject Successfully!", "success");
                  setTimeout("location.href = 'wait-approve-prarmacy';",2000);
                } else {
                swal("", "ไม่สามารถ Reject ได้", "warning");
                }
            }
        });
    }
});                                   
$('#addtpu').click(function (e) {
    var tbsa2sastkid = $('#tbsa2-sa_stkid').val();
    var tbsa2said = $('#tbsa2-said').val();
               
        if(tbsa2sastkid !== ""){
                var l = $('.ladda-button').ladda();
    l.ladda('start'); 
            $.ajax({
            url: 'save-data-header',
            type: 'POST',
            data:{tbsa2sastkid:tbsa2sastkid,tbsa2said:tbsa2said},
            success: function (data) {
            }
      });
          $.ajax({
            url: 'gettpu',
            type: 'POST',
            success: function (data) {
                $('#header_tpund').html('เลือกรายการยาการค้า');
                $('#_item_list_detail').html(data);
                $('#_item_list').modal('show');
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
            l.ladda('stop');
            }
      });
       }else{
                 swal("", 'กรุณาเลือกคลังสินค้า', "warning");
        
   }
    });
        
     $('#addnd').click(function (e) {
       var tbsa2sastkid = $('#tbsa2-sa_stkid').val();
        var tbsa2said = $('#tbsa2-said').val();
             
        if(tbsa2sastkid !== ""){
                 var l = $('.ladda-button').ladda();
            l.ladda('start');  
          $.ajax({
            url: 'save-data-header',
            type: 'POST',
            data:{tbsa2sastkid:tbsa2sastkid,tbsa2said:tbsa2said},
            success: function (data) {
            }
      });
          $.ajax({
            url: 'getnd',
            type: 'POST',
            success: function (data) {
                $('#header_tpund').html('เลือกรายการเวชภัณฑ์');
                $('#_item_list_detail').html(data);
                $('#_item_list').modal('show');
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
                l.ladda('stop');
            }
      }); 
           }else{
        swal("", 'กรุณาเลือกคลังสินค้า', "warning");    
   }
    });                    
    $('#_Clear').click(function (e) {
        var fID = $('#tbsa2-said').val(); 
             $.get(
                    'sa2-clear',
                {
                     id: fID
                },
                function (data)
                {
                swal("", "Clear Successfully!", "success");
                setTimeout("location.href = 'index';",2000);
                }
    );
    });
                  
   $('#_sendtoapprove').click(function (e) {
        swal({
            title: "ยืนยันการส่งอนุมัติ ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#53a93f",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
        var fID = $('#tbsa2-said').val();
            var l = $('.ladda-button').ladda();
            l.ladda('start');
             $.get(
                    'sa2-send-to-approve',
                {
                     id: fID
                },
                function (data)
                {
                setTimeout("location.href = 'index';",2000);
                }
        );
                }
                }
                );
    });
$('#_approve').click(function (e) {
     swal({
            title: "ยืนยันการอนุมัติ ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#53a93f",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
            var fID = $('#tbsa2-said').val();
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            $.get(
                    'sa2-approve',
                    {
                        id: fID
                    },
            function (data)
            {
                setTimeout("location.href = 'wait-approve-prarmacy';",2000);
            }
            );
        }
    }
        );
});
                
          //On Save  
  $(document).ready(function () {
    $('#form_sa_main').on('beforeSubmit', function(e)
    {
     var l = $('.ladda-button').ladda();
     l.ladda('start');           
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
                $('#tbsa2-sanum').val(result);
                swal("Save Complete!", "", "success");
                $('#_sendtoapprove').removeClass( "disabled" );
                $('#_approve').removeClass( "disabled");
                l.ladda('stop');
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
   
         
function init_click_handlers() {
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        swal({
           title: 'ยืนยันการลบ',
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
                'delete-detail',
                 {
                    id: fID
                 },
                function (data)
                {
                     $.pjax.reload({container: '#sa_detail_'});
                }
                );
            }
       }
                
    );
    });
}
init_click_handlers(); //first run
$('#sa_detail_').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});   
                
JS;

        $this->registerJs($script);
        ?>
