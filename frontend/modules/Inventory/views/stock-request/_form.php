<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use app\modules\Inventory\models\Tbsrstatus;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\Tbsrtype;
use app\modules\Inventory\models\TbStk;
use yii\jui\DatePicker;
use app\models\TbDepartment;
use kartik\widgets\DepDrop;
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


$i = 1;
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

        <!--<div class="vwsr2listdraf-form">-->

        <div class="well">
            <?php $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_main']); ?>
            <div class="row">
                <input type="hidden" name="SRID" id="SRID" value="<?php echo(!empty($SRID) ? $SRID : ''); ?>"/>      
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNum')->textInput(['readonly' => true]) ?>
                    <?php
                    echo $form->field($model, 'SRIssue_stkID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label('เบิกจากคลัง <font color=red>*</font>');
                    ?>
                    <?php
                    echo $form->field($model, 'SRTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Tbsrtype::find()->all(), 'SRTypeID', 'SRType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
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
                    <input type="hidden" value="<?php echo $model->SRStatus; ?>" name="Tbsr2temp[SRStatus]" />


                </div>
                <div class="col-sm-6">
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
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่ <font color=red>*</font>');
                    ?>
                    <?php
                    if (!empty($_SESSION['ss_sectionid'])) {
                        echo $form->field($model, 'SRReceive_stkID')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbStk::find()->where(['SectionID' => $_SESSION['ss_sectionid']])->all(), 'StkID', 'StkName'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('รับเข้าคลัง <font color=red>*</font>');
                    } else {
                        echo $form->field($model, 'SRReceive_stkID')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label('รับเข้าคลัง <font color=red>*</font>');
                    }
                    ?>
                    <?php
                    echo
                    $form->field($model, 'SRReqDate')->widget(DatePicker::classname(), [
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
                    ])->label('วันที่ต้องการ <font color=red>*</font>');
                    ?>
                </div>
            </div>
            <h5 class="row-title before-success">รายละเอียด</h5>
            <br>
            <?php
            echo '
            	<a class="btn btn-success ladda-button"  data-style= "expand-left" id="addtpu" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> ยา</i></a>
            	<a class="btn btn-success ladda-button"  data-style= "expand-left" id="addnd" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> เวชภัณฑ์และวัสดุการแพทย์</i></a>
            	<a class="btn btn-success ladda-button"  data-style= "expand-left" id="addcssd" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> งานจ่ายกลาง</i></a>
            	<a class="btn btn-success ladda-button"  data-style= "expand-left" id="addscience" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> วัสดุวิทยาศาสตร์</i></a>
            	<a class="btn btn-success ladda-button"  data-style= "expand-left" id="addparcel" href="javascript:void(0)"><i class="glyphicon glyphicon-plus"> พัสดุ</i></a>';
            ?>
            <div style="margin: 20px">
                <!-- new   -->
                <?php if (!empty($searchModel)) { ?>
                    <div class="form-group">

                        <?php \yii\widgets\Pjax::begin(['id' => 'sr2_detail_']) ?>
                        <?php
                        //echo $this->render('_searchdetailgpu', ['model' => $searchModel,]);
                        ?>
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
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'attribute' => 'ItemID',
                                    'hAlign' => GridView::ALIGN_CENTER,
                                ],
                                    [
                                    'headerOptions' => ['style' => 'text-align:center;'],
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
                                    'header' => '<a>ขอเบิก</a>',
                                    'width' => '45px',
                                    'attribute' => 'SRPackQty',
                                    'headerOptions' => ['style' => 'text-align:center;background-color:rgb(217, 237, 247);', 'colspan' => '2'],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                    'value' => function ($model) {
                                        if ($model->sr2detail->SRQty == NULL) {
                                            return '-';
                                        } else {
                                            return $model->sr2detail->SRQty;
                                        }
                                    },
                                ],
                                    [
                                    'header' => '<a>Actions</a>',
                                    'width' => '45px',
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'options' => ['style' => 'background-color:rgb(217, 237, 247);'],
                                    'attribute' => 'SRItemPackID',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                        if ($model->sr2detail->SRUnit == NULL) {
                                            return '-';
                                        } else {
                                            return $model->sr2detail->SRUnit;
                                        }
                                    }
                                ],
                                    [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'noWrap' => true,
                                    'hAlign' => GridView::ALIGN_CENTER,
                                    'headerOptions' => ['hidden' => true],
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
                                    'hidden' => true,
                                    'noWrap' => true,
                                    'group' => true, // enable grouping
                                    'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                        return [
                                            'mergeColumns' => [
                                                    [1, 2],
                                                    [5, 6]
                                            ], // columns to merge in summary
                                            'content' => [// content to show in each summary cell
                                                1 => '',
                                                3 => '<font color="black">จำนวน</font>',
                                                4 => '<font color="black">หน่วย</font>',
                                            //5 => '<font color="black">จำนวน</font>',
                                            //6 => '<font color="black">หน่วย</font>',
                                            ],
                                            'contentOptions' => [// content html attributes for each summary cell
                                                0 => ['style' => 'background-color: #dff0d8'],
                                                1 => ['style' => 'background-color: #dff0d8'],
                                                3 => ['style' => 'color:green;text-align:center;background-color:rgb(217, 237, 247)'],
                                                4 => ['style' => 'color:green;text-align:center;background-color:rgb(217, 237, 247)'],
                                                //5 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                //6 => ['style' => 'color:green;text-align:center;background-color: #ddd'],
                                                5 => ['style' => 'background-color: #dff0d8']
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
                <!-- new   -->
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'SRNote')->textArea(['maxlength' => true, 'rows' => '4', 'style' => 'background-color: #FFFF99']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12"  style="text-align: right;">
                    <?= Html::a('Close',['index'],['class' => 'btn btn-default']) ?>
                    <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save Draft', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?> 
                    <a class="btn btn-info disabled ladda-button"  data-style = 'expand-left'  id="saveandapprove"  href="javascript:void(0)">Save And Send To Approve</a>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
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
    'id' => 'save_detail',
    'header' => '<h4 class="modal-title">บันทึกรายการใบขอเบิก</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
]);
?>
<div id="detailitem_save">

</div>
<?php Modal::end(); ?>
<?php
$s = <<< JS

        $('#tbsr2temp-srreceive_stkid').on('change', function() {  
           var tbsr2tempsrreceivestkid =   $('#tbsr2temp-srreceive_stkid').val();
           var tbsr2tempsrissuestkid =  $('#tbsr2temp-srissue_stkid').val();
           if(tbsr2tempsrreceivestkid == tbsr2tempsrissuestkid){
               $("#tbsr2temp-srreceive_stkid").val('').trigger("change");                  
           }                           
       }); 

       $('#tbsr2temp-srissue_stkid').on('change', function() {   
           var tbsr2tempsrreceivestkid =   $('#tbsr2temp-srreceive_stkid').val();
           var tbsr2tempsrissuestkid =  $('#tbsr2temp-srissue_stkid').val();
           if(tbsr2tempsrreceivestkid == tbsr2tempsrissuestkid){
             $("#tbsr2temp-srissue_stkid").val('').trigger("change");                      
         }                   
     });                    

     /*$('#_clear').click(function (e) {
      $.ajax({
        url: 'savesendtoapprove',
        data:$("#form_main").serialize(),
        type: 'POST',
        success: function (data) {
         swal("", "บันทึกรายการแล้ว", "success");  
         Notify('Save & Send to Approve Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
         window.location.replace("/km4/Inventory/stock-request");             
     }
 });
});*/
       //approve
$('#saveandapprove').click(function (e) {

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
       run_waitMe(2);            
        $.ajax({
            url: 'savesendtoapprove',
            data:$("#form_main").serialize(),
            type: 'POST',
            success: function (data) {      
              setTimeout("location.href = '/km4/Inventory/stock-request';",10);   
          }
      });
  }
});        
});

$('#addtpu').click(function (e) {
 var SRID = $('#SRID').val();
 var tbsr2tempsrissuestkid  = $('#tbsr2temp-srissue_stkid').val();
 var tbsr2tempsrreceivestkid = $('#tbsr2temp-srreceive_stkid').val();
 if(tbsr2tempsrissuestkid !== "" && tbsr2tempsrreceivestkid !== ""){
    run_waitMe(2);
    fn_save();
    $.ajax({
    url: 'gettpu',
    data:{stkid:tbsr2tempsrissuestkid,receivestkid:tbsr2tempsrreceivestkid,SRID:SRID},
    type: 'POST',
    dataType: 'json',
    success: function (data) {
        $('#header_tpund').html('เลือกรายการยาการค้า');
        $('#datatpu').html(data);
        $('#tpu_sr2_detail_list').modal('show');
        $('#data_tpu').DataTable({
           "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
           "pageLength": 10,
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

}else{
  swal("", "กรุณาเลือกคลังสินค้า", "warning");
}
});
$('#addnd').click(function (e) {
    var SRID = $('#SRID').val();
    var tbsr2tempsrissuestkid  = $('#tbsr2temp-srissue_stkid').val();
    var tbsr2tempsrreceivestkid = $('#tbsr2temp-srreceive_stkid').val();
    if(tbsr2tempsrissuestkid !== ""&& tbsr2tempsrreceivestkid !== ""){
        run_waitMe(2);
        fn_save();
        $.ajax({
        url: 'getnd',
        data:{stkid:tbsr2tempsrissuestkid,SRID:SRID,receivestkid:tbsr2tempsrreceivestkid},
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('#header_tpund').html('เลือกรายการเวชภัณฑ์');
            $('#datatpu').html(data);
            $('#tpu_sr2_detail_list').modal('show');
            $('#data_tpu').DataTable({
               "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
               "pageLength": 10,
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
}else{
   swal("", "กรุณาเลือกคลังสินค้า", "warning");
                            
}         

    //$.pjax.reload({container:'#sr2_detail_'});
});
$('#addphama').click(function (e) {
    var SRID = $('#SRID').val();
    var tbsr2tempsrissuestkid  = $('#tbsr2temp-srissue_stkid').val();
    var tbsr2tempsrreceivestkid = $('#tbsr2temp-srreceive_stkid').val();
    if(tbsr2tempsrissuestkid !== ""&& tbsr2tempsrreceivestkid !== ""){
        run_waitMe(2);
        fn_save();
        $.ajax({
        url: 'getnd-phama',
        data:{stkid:tbsr2tempsrissuestkid,SRID:SRID,receivestkid:tbsr2tempsrreceivestkid},
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('#header_tpund').html('เลือกรายการวัสดุการแพทย์');
            $('#datatpu').html(data);
            $('#tpu_sr2_detail_list').modal('show');
            $('#data_tpu').DataTable({
               "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
               "pageLength": 10,
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
}else{
   swal("", "กรุณาเลือกคลังสินค้า", "warning");
                            
}         

    //$.pjax.reload({container:'#sr2_detail_'});
});
$('#addcssd').click(function (e) {
    var SRID = $('#SRID').val();
    var tbsr2tempsrissuestkid  = $('#tbsr2temp-srissue_stkid').val();
    var tbsr2tempsrreceivestkid = $('#tbsr2temp-srreceive_stkid').val();
    if(tbsr2tempsrissuestkid !== ""&& tbsr2tempsrreceivestkid !== ""){
        run_waitMe(2);
        fn_save();
        $.ajax({
        url: 'getnd-cssd',
        data:{stkid:tbsr2tempsrissuestkid,SRID:SRID,receivestkid:tbsr2tempsrreceivestkid},
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('#header_tpund').html('เลือกรายการงานจ่ายกลาง');
            $('#datatpu').html(data);
            $('#tpu_sr2_detail_list').modal('show');
            $('#data_tpu').DataTable({
               "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
               "pageLength": 10,
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
}else{
   swal("", "กรุณาเลือกคลังสินค้า", "warning");
                            
}         

    //$.pjax.reload({container:'#sr2_detail_'});
});
$('#addscience').click(function (e) {
    var SRID = $('#SRID').val();
    var tbsr2tempsrissuestkid  = $('#tbsr2temp-srissue_stkid').val();
    var tbsr2tempsrreceivestkid = $('#tbsr2temp-srreceive_stkid').val();
    if(tbsr2tempsrissuestkid !== ""&& tbsr2tempsrreceivestkid !== ""){
        run_waitMe(2);
        fn_save();
        $.ajax({
        url: 'getnd-science',
        data:{stkid:tbsr2tempsrissuestkid,SRID:SRID,receivestkid:tbsr2tempsrreceivestkid},
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('#header_tpund').html('เลือกรายการวัสดุวิทยาศาสตร์');
            $('#datatpu').html(data);
            $('#tpu_sr2_detail_list').modal('show');
            $('#data_tpu').DataTable({
               "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
               "pageLength": 10,
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
}else{
   swal("", "กรุณาเลือกคลังสินค้า", "warning");
                            
}         

    //$.pjax.reload({container:'#sr2_detail_'});
});
$('#addparcel').click(function (e) {
    var SRID = $('#SRID').val();
    var tbsr2tempsrissuestkid  = $('#tbsr2temp-srissue_stkid').val();
    var tbsr2tempsrreceivestkid = $('#tbsr2temp-srreceive_stkid').val();
    if(tbsr2tempsrissuestkid !== ""&& tbsr2tempsrreceivestkid !== ""){
        run_waitMe(2);
        fn_save();
        $.ajax({
        url: 'getnd-parcel',
        data:{stkid:tbsr2tempsrissuestkid,SRID:SRID,receivestkid:tbsr2tempsrreceivestkid},
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            $('#header_tpund').html('เลือกรายการพัสดุ');
            $('#datatpu').html(data);
            $('#tpu_sr2_detail_list').modal('show');
            $('#data_tpu').DataTable({
               "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
               "pageLength": 10,
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
}else{
   swal("", "กรุณาเลือกคลังสินค้า", "warning");
                            
}         

    //$.pjax.reload({container:'#sr2_detail_'});
});
//ClickEdit
function init_click_handlers() {
    $('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var stkid = $('#tbsr2temp-srissue_stkid').val();   
        run_waitMe(2);
        $.get(
        'update-detailgpu',
        {
            id: fID,stkid:stkid
        },
        function (data)
        {
         $('#formdetail').trigger("reset");
         $('#save_detail').find('.modal-body').html(data);
         $('#detailitem_save').html(data);
         $('#save_detail').modal('show');   
         waitMe_hide(2);
     }
     );
 });
 $('.activity-delete-link').click(function (e) {
    var fID = $(this).closest('tr').data('key');
    //run_waitMe(2);
    swal({
       title: "ยืนยันการลบ",
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
        'deletedetailgpu',
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


$(document).ready(function () {

    $("#tbsritemdetail2temp-srpackqty").keyup(function () {
        $("#tbsritemdetail2temp-srpackqty").priceFormat({prefix: ''});
    });
    $("#tbsritemdetail2temp-sritemorderqty").keyup(function () {
        $("#tbsritemdetail2temp-sritemorderqty").priceFormat({prefix: ''});
    });

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
        $('#tbsr2temp-srnum').val(result);
        swal("", "Save Complete!", "success");         
        $('#saveandapprove').removeClass('disabled');
        waitMe_hide(2);
    })
    .fail(function()
    {
        console.log("server error");
        waitMe_hide(2);
    });
    return false;
});
});                       
function fn_save(){
    var SRID = $('#SRID').val();
    var SRDate = $('#tbsr2temp-srdate').val();
    var SRIssue = $('#tbsr2temp-srissue_stkid').val();
    var SRReceive = $('#tbsr2temp-srreceive_stkid').val();
    var SRType = $('#tbsr2temp-srtypeid').val();
    var SRReqdate = $('#tbsr2temp-srreqdate').val();
    if(SRDate&&SRReqdate){
        $.ajax({
                url: 'before-select',
                type: 'POST',
                data: {SRID: SRID,SRDate:SRDate,SRIssue:SRIssue,SRReceive:SRReceive,SRType:SRType,SRReqdate:SRReqdate},
                dataType: 'json',
                success: function (data) {
                }
          });
    }else{
        $.ajax({
                url: 'before-select',
                type: 'POST',
                data: {SRID: SRID,SRIssue:SRIssue,SRReceive:SRReceive,SRType:SRType},
                dataType: 'json',
                success: function (data) {
                }
          });
    }
    
}
JS;
$this->registerJs($s);
?>

<script>
    function SelectGPU(id, type, balance) {
        run_waitMe(1);
        var SRID = $("#SRID").val();
        if (balance == '0') {
            swal({
                title: "",
                text: "ไม่มีสินค้าต้องการขอเบิกหรือไม่?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#53a93f",
                confirmButtonText: "Confirm",
                closeOnConfirm: true
            }, function () {
                $.ajax({
                    url: 'detailselect',
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
                            $('#effectivedate').val($('#tbpcplan-pcplanbegindate').val());
                            $('#save_detail').modal('show');
                            waitMe_hide(1);
                        }
                    }
                });
            });
            waitMe_hide(1);
        } else {
            $.ajax({
                url: 'detailselect',
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
                        $('#effectivedate').val($('#tbpcplan-pcplanbegindate').val());
                        $('#save_detail').modal('show');
                        waitMe_hide(1);
                    }
                }
            });
        }
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


