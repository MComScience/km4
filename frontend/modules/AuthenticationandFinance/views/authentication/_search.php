<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TbprSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-4">
        <div class="tb-pr-search">

            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => [$action],
                        'method' => 'get',
                        'options' => ['data-pjax' => true]
            ]);
            ?>
            <?php if ($action == 'index') { ?>
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                    <span class="input-group-btn">
                        <a class="btn btn-primary shiny" href="javascript:void(0);">ลงทะเบียนผู้ป่วย</a>
                        <a class="btn btn-primary dropdown-toggle shiny" data-toggle="dropdown" href="javascript:void(0);"><i class="fa fa-angle-down"></i></a>
                        <ul class="dropdown-menu dropdown-primary" >
                            <li>
                                <a href="javascript:void(0)" id="opd">
                                    <div class="panel-title"><i class="fa fa-edit"></i>
                                        ผู้ป่วยนอก
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0)" id="ipd">
                                    <div class="panel-title"><i class="fa fa-edit"></i> 
                                        ผู้ป่วยใน
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </span>
                <?php } ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
Modal::begin([
    'id' => 'modal_opd_and_ipd',
    'header' => '<h4 class="modal-title"><div id="title_opd_and_ipd"/></h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
        // 'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div class="form-group field-inputEmail3 required">
    <label class="control-label col-sm-3" for="inputEmail3"><div id="header_hnorand"></div></label>
    <div class="col-sm-6">
        <input type="text" name="pt" class="form-control" id="pt"/>
        <div class="help-block help-block-error "></div>
    </div>
    <button class="btn btn-success" id="searchipdopd" type="submit"><i class="glyphicon glyphicon-search"></i> Search</button>           
</div>
<input type="hidden" id="ipdopd"/>
<div id="patian_div_html">

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-danger disabled" disabled="" id="clear" data-dismiss="modal">Clear</button>
    <button type="button" class="btn btn-primary disabled" disabled="" id="save">Save</button>
</div>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => 'modal_register_opd_and_ipd',
    'header' => '<h4 class="modal-title">ลงทะเบียนผู้ป่วย</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
        //'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div id="detail_patain"></div>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => 'modal_add_right_opd_and_ipd',
    'header' => '<h4 class="modal-title">ลงทะเบียนผู้ป่วย</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
        // 'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div id="table_right_list"></div>
<div id="detail_right_and_refer">
</div>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => 'modal_add_right_opd_and_ipd2',
    'header' => '<h4 class="modal-title">เพิ่มสิทธิ์</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
        // 'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div id="detail_add_right">
</div>
<?php Modal::end(); ?>
<?php
Modal::begin([
    'id' => 'modal_edit_right_payment',
    'header' => '<h4 class="modal-title">ปรับปรุงเงื่อนไขการใช้งานสิทธิ์</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
        // 'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div id="detail_edit_right_payment">
</div>
<?php Modal::end(); ?>
<?php
$s = <<< JS

$('#opd').click(function (e) {
        $('#ipdopd').val('opd');
        $('#title_opd_and_ipd').html('ค้นหาผู้ป่วยนอก');
        $('#header_hnorand').html('HN'); 
        $('#patian_div_html').html('');
        $('#pt').val('');
        $("#save").addClass("disabled");
        $("#clear").addClass("disabled");
        $("#save").attr('disabled', 'disabled');
        $('#clear').attr('disabled', 'disabled');
        $('#modal_opd_and_ipd').modal({show: 'true'}); 
});
 $('#ipd').click(function (e) {
        $('#ipdopd').val('ipd');
        $('#title_opd_and_ipd').html('ค้นหาผู้ป่วยใน');
        $('#header_hnorand').html('HN หรือ AN');
        $('#patian_div_html').html('');
        $('#pt').val('');
         $("#save").addClass("disabled");
        $("#clear").addClass("disabled");
        $("#save").attr('disabled', 'disabled');
        $('#clear').attr('disabled', 'disabled');
        $('#modal_opd_and_ipd').modal({show: 'true'}); 
   });
   $(function () {
        $("#pt").keyup(function (event) {
            if (event.which == 13) {
               var id = $('#pt').val();
               var type = $('#ipdopd').val();
        if(type== 'ipd'){
        var message_warnig = 'กรุณาใส่ข้อมูล HN หรือ AN';
            }else{
               var message_warnig = 'กรุณาใส่ข้อมูล HN ';  
            }
                if(id != ""){
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/get-ipd-opd',
                    type: 'get',
                    data:{type:type,id:id},
                    dataType:'json',
                    success: function (data) { 
//                        if(data== 1){
//                         swal("", "ไม่พบข้อมูล", "warning");
//                        }
                    }
                });
                
            }else{
         swal("",message_warnig, "warning");
            }
            }
        });
    }); 
  $('#searchipdopd').click(function (e) {
       var id = $('#pt').val();
       var type = $('#ipdopd').val();
        if(type== 'ipd'){
        var message_warnig = 'กรุณาใส่ข้อมูล HN หรือ AN';
            }else{
               var message_warnig = 'กรุณาใส่ข้อมูล HN ';  
               
            }
          if(id != ""){
             run_waitMe(1);
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/get-ipd-opd',
                    type: 'get',
                    data:{type:type,id:id},
                    success: function (data) {
                   if(data == 'false'){
                       swal("", "ไม่พบข้อมูล", "warning");
                       $('.modal-content').removeClass('waitMe_container');
                       $('.waitMe').html('');
                      }else{
                           $('#patian_div_html').html(data); 
                           $("#save").removeClass("disabled");
                           $("#clear").removeClass("disabled");
                           $("#save").removeAttr('disabled', 'disabled');
                           $('#clear').removeAttr('disabled', 'disabled');
                           $('.modal-content').removeClass('waitMe_container');
                           $('.waitMe').html('');
                   }  
                    }
                });
          }else{
             swal("", message_warnig, "warning");
          $('.modal-content').removeClass('waitMe_container');
          $('.waitMe').html('');
            }
   });     
     $('#save').click(function (e) {
       var id = $('#pt').val();
       var type = $('#ipdopd').val();
        if(type== 'ipd'){
        var message_warnig = 'กรุณาใส่ข้อมูล HN หรือ AN';
            }else{
               var message_warnig = 'กรุณาใส่ข้อมูล HN ';  
            }
          if(id != ""){
            run_waitMe(1);
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/save-checkin',
                    type: 'get',
                    data:{type:type,id:id},
                   dataType:'json', 
                    success: function (data) {
                   if(data == 'false'){
                       swal("", "ไม่พบข้อมูล", "warning");
                      }else{
                        //  swal("", "บันทึกข้อมูลแล้ว", "success");
                         $('#modal_opd_and_ipd').modal('hide');
                         $('.modal-content').removeClass('waitMe_container');
                         $('.waitMe').html('');
                        //  $('.modal-backdrop').hide();
        
                    $.ajax({
                            url: 'index.php?r=AuthenticationandFinance/authentication/register',
                            type: 'get',
                            data:{hn:data.hn,registydate:data.registydate},
                            success: function (data) {
                            if(data == 'false'){
                                 swal("", "ไม่พบข้อมูล", "warning");
                         }else{
                          $('#modal_add_right_opd_and_ipd').modal('show');
                          $('#table_right_list').html(data); 
                             }  
                           }
                    });
                   }  
                    }
                });
          }else{
             swal("", message_warnig, "warning");
            }
   });
    $('#addar').click(function (e) {
        alert('aaa');
        /*  $.ajax({
                            url: 'index.php?r=AuthenticationandFinance/authentication/register',
                            type: 'get',
                            data:{hn:data.hn,registydate:data.registydate},
                            success: function (data) {
                            if(data == 'false'){
                                 swal("", "ไม่พบข้อมูล", "warning");
                         }else{
                           $('#modal_add_right_opd_and_ipd').modal('show');
                          $('#table_right_list').html(data); 
                             }  
                           }
                    });*/
   });
JS;
$this->registerJs($s);
?>
<script type="text/javascript">


function run_waitMe(type){
if(type == '1'){
var idnaclass = '.modal-content';
}else if(type == '2'){
var idnaclass = '';
}

    $(idnaclass).waitMe({
      effect: 'ios',
      text: 'Please wait...',
      bg: 'rgba(255,255,255,0.7)',
      color: '#000',
      maxSize: '',
      source: 'img.svg',
      onClose: function() {}
    });
  }
</script>

