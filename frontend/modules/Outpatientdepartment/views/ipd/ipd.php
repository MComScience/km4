<?php

use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\Outpatientdepartment\models\TbPtService;
use app\modules\Outpatientdepartment\models\TbPtServiceMd;
?>

<div class="row">
    <div class="col-md-12">
        <div class="profile-container">
            <div class="profile-header row">
                <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                    <img src="assets/img/avatars/admin.png" alt="" class="header-avatar" />
                </div>
                <div id="wait2" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;z-index: 99999999999999;"><img src='images/712.gif' width="64" height="64" /><br>Loading..</div>
                <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
                    <div class="row">
                        <div class="header-fullname"><b>หอผู้ป่วยสามัญชาย</b></div>
                        <div class="invoice-container">
                            <ul>
                                <li>ชื่อเจ้าหน้าที่ + รหัสพนักงาน</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink"><font color="#FFFFFF">xx</font></div>
                            <div class="stats-title"><font color="#FFFFFF">xx</font></div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink"><font color="#FFFFFF">xx</font></div>
                            <div class="stats-title"><font color="#FFFFFF">xx</font></div>
                        </div>
                        <!--                    </div>
                                            <div class="row">-->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink"><font color="#FFFFFF">xx</font></div>
                            <div class="stats-title"><font color="#FFFFFF">xx</font></div>
                        </div>
                        <!--                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 stats-col">
                                                    <div class="stats-value pink">12</div>
                                                    <div class="stats-title">Inpatients</div>
                                                </div>-->
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink"><font color="#FFFFFF">xx</font></div>
                            <div class="stats-title"><font color="#FFFFFF">xx</font></div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink"><font color="#FFFFFF">xx</font></div>
                            <div class="stats-title"><font color="#FFFFFF">xx</font></div>
                        </div>
                        <!--                    </div>
                                            <div class="row">-->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink"><font color="#FFFFFF">xx</font></div>
                            <div class="stats-title"><font color="#FFFFFF">xx</font></div>
                        </div>
                        <!--                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 stats-col">
                                                    <div class="stats-value pink">12</div>
                                                    <div class="stats-title">Inpatients</div>
                                                </div>-->
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink">3</div>
                            <div class="stats-title">Adjust Order Request</div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink">12</div>
                            <div class="stats-title">Inpatients</div>
                        </div>
                        <!--                    </div>
                                            <div class="row">-->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 stats-col">
                            <div class="stats-value pink">40</div>
                            <div class="stats-title">Outpatients</div>
                        </div>
                        <!--                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 stats-col">
                                                    <div class="stats-value pink">12</div>
                                                    <div class="stats-title">Inpatients</div>
                                                </div>-->
                    </div>
                </div>
            </div>
            <div class="profile-body">
                <div class="col-lg-12">
                    <div class="tabbable">
                        <ul class="nav nav-tabs tabs-flat  nav-justified" id="myTab11">
                            <li class="active">
                                <a data-toggle="tab" href="#overview">
                                    รายชื่อผู้ป่วย
                                </a>
                            </li>
                            <li class="tab-red">
                                <a data-toggle="tab" href="#timeline">
                                    รายการคำสั่งแพทย์
                                </a>
                            </li>
                            <li class="tab-palegreen">
                                <a data-toggle="tab" id="contacttab" href="#contacts">

                                </a>
                            </li>
                            <li class="tab-yellow">
                                <a data-toggle="tab" href="#settings">

                                </a>
                            </li>
                        </ul>
                        
                        <div class="tab-content tabs-flat">

                            <div id="overview" class="tab-pane active">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">

                                        <a class="btn btn-success" id="_registerpatienopd">ลงทะเบียนผู้ป่วยใน</a>
                                        <br><br><table class="table table-striped table-hover table-bordered" id="simpletable">
                                            <thead>
                                                <tr role="row">
                                                    <th width="36px" style="text-align: center">
                                                        #
                                                    </th>
                                                    <th style="text-align: center">
                                                        HN
                                                    </th>
                                                    <th style="text-align: center">
                                                        VN/AN
                                                    </th>
                                                    <th style="text-align: center">
                                                        ชื่อ-นามสกุลผู้ป่วย
                                                    </th>
                                                    <th style="text-align: center">
                                                        สิทธิการรักษา
                                                    </th>
                                                    <th style="text-align: center">
                                                        แผนก
                                                    </th>
                                                    <th style="text-align: center">
                                                        ชื่อแพทย์
                                                    </th>
                                                    <th style="text-align: center">
                                                        สถานะ
                                                    </th>
                                                    <th style="text-align: center">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                $i = 1;
                                                foreach ($data as $r) {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center"><?= $i ?></td>
                                                        <td><?= $r->pt_hospital_number ?></td>
                                                        <td><?= $r->pt_visit_number ?></td>
                                                        <td class="center "><?= $r->pt_fullname ?></td>
                                                        <td class="center "><?= $r->pt_maininscl_decs ?></td>
                                                        <td class="center "><?= $r->SectionDecs ?></td>
                                                        <td class="center ">นายแพทย์ xxx  xxx</td>
                                                        <td class="center "><?= $r->pt_servicetrans_statusid ?></td>
                                                        <td style="text-align: center">
                                                            <a href="#" class="btn btn-success btn-xs edit"> V/S</a>
                                                            <a href="#" class="btn btn-info btn-xs delete"> MD</a>
                                                            
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="timeline" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-xs-12 col-md-12">
                                        <table class="table table-striped table-hover table-bordered" id="simpletable1">
                                            <thead>
                                                <tr role="row">
                                                    <th width="36px" style="text-align: center">
                                                        #
                                                    </th>
                                                    <th style="text-align: center">
                                                        OrderID
                                                    </th>
                                                    <th style="text-align: center">
                                                        Order Type
                                                    </th>
                                                    <th style="text-align: center">
                                                        HN
                                                    </th>
                                                    <th style="text-align: center">
                                                        VN/AN
                                                    </th>
                                                    <th style="text-align: center">
                                                        ชื่อ-นามสกุลผู้ป่วย
                                                    </th>
                                                    <th style="text-align: center">
                                                        ชื่อแพทย์
                                                    </th>
                                                    <th style="text-align: center">
                                                        สถานะ
                                                    </th>
                                                    <th style="text-align: center">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td style="text-align: center">1</td>
                                                    <td>xxx</td>
                                                    <td>xxx</td>
                                                    <td class="center ">HN</td>
                                                    <td class="center ">VN/AN</td>
                                                    <td class="center ">นาย xxx xxx</td>
                                                    <td class="center ">นายแพทย์ xxx  xxx</td>
                                                    <td class="center ">Status</td>
                                                    <td style="text-align: center">
                                                        <a href="#" class="btn btn-success btn-xs edit"><i class="fa fa-print"></i> Print</a>
                                                        <a href="#" class="btn btn-danger btn-xs delete"> Discharge</a>
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="contacts" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">รายชื่อผู้ป่วยนอก</div>
                                </div>
                            </div>

                            <div id="settings" class="tab-pane">
                                <div class="row profile-overview">
                                    <div class="col-md-8">Simple Page</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
Modal::begin([
    'id' => 'searchpatien',
    'header' => '<h4 class="modal-title">ค้นหาผู้ป่วย</h4>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div  style="text-align: center">
    <div class="form-inline">
        <label>HN หรือ เลขที่บัตรประชาชน</label>
        <input type="text" class="form-control"  onkeypress="return isNumberKey(event)" id="hn" name="hn"/> <a id="searchipdopd" class="btn btn-success">Search</a>
    </div>
</div>


<div style="text-align: right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'registerpatien',
    'header' => '<h4 class="modal-title">ลงทะเบียนผู้ป่วย</h4>',
    'size' => 'modal-lg modal-primary',
]);
?>
<?php
$form = ActiveForm::begin(['id' => '_formdetail']);
?>
<input type="hidden" id="Hn_namber" name="Hn_namber" value=""/>
<input type="hidden" id="registydate" name="registydate" value=""/>
<div style="margin: 10px">
    <div class="profile-header row">
        <div class="col-lg-2 col-md-4 col-sm-12 text-center">
            <img src="assets/img/avatars/admin.png" width="100px" height="100px" alt="" class="header-avatar" />
        </div>
        <div class="col-lg-5 col-md-8 col-sm-12 profile-info">
            <div class="row">
                <div class="header-fullname"><b><span id="_fullname"></span></b></div>
                <div class="invoice-container">
                    <ul>
                        <li>HN : <font color="green"><span id="_hnnumber"></span></font> สัญชาติ : <span id="_nation"></span> อายุ : <span id="_age"></span> ปี</li>
                        <li>VN:<span id="_vnnumber"></span> AN:<span id="_annumber"></span> </li>
                        <li>สิทธิ : <span id="_right"></span></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 profile-stats">
            <?php
            echo $form->field($secton, 'section_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(app\models\TbSection::find()->all(), 'SectionID', 'SectionDecs'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?php
            echo $form->field($secton, 'pt_service_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TbPtService::find()->all(), 'pt_service_id', 'pt_service_name'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?php
            echo $form->field($secton, 'pt_service_md_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(TbPtServiceMd::find()->all(), 'pt_service_md_id', 'pt_service_md_name'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        </div>
    </div>

</div>
<br><br>
<div style="text-align: right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-danger" data-dismiss="modal">Clear</button>
    <a href="javascript:void(0)" id="registerbtn" class="btn btn-success">ลงทะเบียน</a>
</div>
<?php ActiveForm::end(); ?>
 <div id="modal-success" class="modal modal-message modal-success fade" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="glyphicon glyphicon-check"></i>
                </div>
                <div class="modal-title">Success</div>

                <div class="modal-body">You have done great!</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
                </div>
            </div> <!-- / .modal-content -->
        </div> <!-- / .modal-dialog -->
    </div>

<?php
Modal::end();
?>
<script>
    function run_waitMe() {
        $('#_registerpatienopd > div').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
</script>

<?php
$script = <<< JS
   $(document).ajaxStart(function(){
      $("#wait2").css("display", "block");
    });
    $(document).ajaxComplete(function(){
        $("#wait2").css("display", "none");
    });   
$('#registerbtn').click(function (e) {
    $.ajax({
        url: 'index.php?r=Outpatientdepartment/ipd/save-service-arrive',
        type: 'POST',
        data:$("#_formdetail").serialize(),
        dataType: 'json',
        success: function (data) {
        if(data == '1'){   
       Notify('บันทึกรายการเรียบร้อยแล้ว', 'top-right', '5000', 'success', 'fa-check', true);
       $('#searchpatien').modal('hide');
       $('#registerpatien').modal('hide');
       $('#hn').val('');
       $("#_formdetail").trigger('reset');
   }
      }
    });       
});        
        
$('#_registerpatienopd').click(function (e) {      
    $('#searchpatien').modal('show');
   
});       
    
$('#searchipdopd').click(function (e) {
       var  hn = $('#hn').val();
        if(hn !== ""){
          $.ajax({
            url: 'index.php?r=Outpatientdepartment/ipd/km4-get-tpu-ipd',
            type: 'POST',
            data:{hn:hn},
            dataType: 'json',
            success: function (data) {
        if(data.datafalse == 'nodata'){
        Notify('ไม่พบข้อมูล', 'top-right', '5000', 'warning', 'fa-warning', true);
            }else{
                $('#_hnnumber').html(data.hn);
                $('#Hn_namber').val(data.hn);
                $('#registydate').val(data.registydate);
                $('#_fullname').html(data.full_name);
                $('#_annumber').html(data.an);
                $('#_vnnumber').html(data.vn);
                $('#_nation').html(data.nation);
                $('#_age').html(data.age);
                $('#_right').html(data.right);
                $('#registerpatien').modal('show');
        }
            }
           });
          }else{
             Notify('กรุณาใส่ HN หรือ เลขที่บัตรประชาชน ก่อน', 'top-right', '5000', 'warning', 'fa-warning', true);
           }
}); 
                
$(document).ready(function () {
    $('#simpletable').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 10,
        "order": [[1, 'asc']]
    });
    $('#simpletable1').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "pageLength": 10,
        "order": [[1, 'asc']]
    });
});       
JS;
$this->registerJs($script);
?>