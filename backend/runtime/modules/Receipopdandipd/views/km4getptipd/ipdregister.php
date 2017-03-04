<div class="col-lg-12">
    <div class="hpanel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li ><a  href="index.php?r=Opdandipd/km4getptipd" aria-expanded="true">รายชื่อผู้ป่วยรอลงทะเบียน</a></li>
                <li class="active"><a  href="index.php?r=Opdandipd/km4getptipd/ipdregister" aria-expanded="false">รายชื่อผุ้ป่วยในลงทะเบียนแล้ว</a></li>
                <li class=""><a  href="index.php?r=Opdandipd/km4getptipd/waitregisterdoctor" aria-expanded="false">รายชื่อผู้ป่วยส่งพบแพทย์</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">รายชื่อผู้ป่วยรอคำสั่งแพทย์</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">รายชื่อผู้ป่วยจำหน่ายแล้ว</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">

                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 3%">ลำดับ</th>
                                        <th style="text-align: center;width: 15%">HN</th>
                                        <th style="text-align: center">VN</th>
                                        <th style="text-align: center">AN</th>
                                        <th style="text-align: center">ชื่อ-สกุล</th>
                                        <th style="text-align: center">สิทธิการรักษา</th>
                                        <th style="text-align: center">แผนก</th>
                                        <th style="text-align: center;width: 23%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($register)) {
                                        $a = 1;
                                        foreach ($register as $r) {
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?php echo $a; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_hospital_number; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_visit_number //echo $r->PT_TITLENAME_ID                                            ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_admission_number; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_fullname; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_maininscl_decs; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_visitstatus; ?></td>
                                                <!--<td><a  class="btn btn-success" href="index.php?r=Opdandipd/km4getptopd/save_service_arrive&hn=//<?php // echo $r->PT_HOSPITAL_NUMBER                                      ?>&&date=<?php // echo $r->PT_REGISTRY_DATE                                      ?>">ลงทะเบียน</a></td>-->
                                                <td style="text-align: center"><a  class="btn btn-success"   href="javascript:loadpage(<?php echo $r->pt_hospital_number; ?>);">บันทึก V/S</a> <a  class="btn btn-success"  href="javascript:loadpage2(<?php echo $r->pt_hospital_number; ?>,<?php echo $r->pt_visit_number; ?>)">ส่งพบแพทย์</a></td>
                                            </tr>
                                            <?php
                                            $a++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile('newcss/vendor/jquery/dist/jquery.min.js');
$this->registerJsFile('km4_2/backend/web/newcss/vendor/peity/jquery.peity.min.js');
?>

<script>
    function loadpage(hn) {
        $("#myModal7").modal("show");
        $("#pt_hn").val(hn);
    }
    function loadpage2(hn, vn) {
        $("#doctormodal").modal("show");
        $("#pt_hn2").val(hn);
        $('#pt_vn2').val(vn);
    }


</script>
<?php
$s = <<< JS
        $('#pt_vs_weight,#pt_vs_height,#pt_vs_bodytemp').priceFormat({
    prefix: '',
    thousandsSeparator: ''
});
        
       $("#example2 tbody tr").click(function (event) {
        $("#hn_show").html($(this).children(":first").next().text());
        $("#name_title").html($(this).children(":first").next().next().next().next().text());
        $("#name_title2").html($(this).children(":first").next().next().next().next().text());
        });
   $("#example2").dataTable({
       "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
           });
JS;
$this->registerJs($s);
?>
<div class="modal fade" id="myModal7" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--<div class="color-line"></div>-->
            <div class="modal-header">
                <h4 class="modal-title">HN <span id="hn_show"></span></h4>
                <h4>ชื่อผู้ป่วย (<span id="name_title"></span>)</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active" ><a  data-toggle="tab" href="#tab-3" aria-expanded="true">บันทึก Vital Sign</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4" aria-expanded="false" onclick="history()">ประวิติ Vital Sign</a></li>
                </ul>
                <div class="tab-content">
                    <br>
                    <div id="tab-3" class="tab-pane active">

                        <div class="panel-body">
                            <!--<div id="modell"/>-->
                            <form id="formtmtgpu" method="POST" >
                                <div class="row">
                                    <input type="hidden" name="pt_hn" id="pt_hn"/>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">ความดันโลหิตค่าบน (mm/Hg)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99"  name="pt_vs_bp_sys" id="pt_vs_bp_sys">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">ความดันโลหิตค่าล่าง (mm/Hg)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99"  name="pt_vs_bp_dia">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">ชีพจร (beats/min)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99" name="pt_vs_pr">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">อัตราออกชิเจนในเลือด (%)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99"  name="pt_vs_spo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">อัตราการเต้นของหัวใจ (min)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99" name="pt_vs_rr">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">อุณหภูมิร่างกาย (C)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99"  name="pt_vs_bodytemp" id="pt_vs_bodytemp">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">ส่วนสูง (cm.)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99"  name="pt_vs_height" id="pt_vs_height">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-sm-7 control-label" style="text-align: right">น้ำหนัก (kg.)</label>
                                            <div class="col-sm-5">
                                                <input type="text" style="background-color: #FFFF99;text-align:right" class="form-control" style="background-color:#ffff99"  name="pt_vs_weight" id="pt_vs_weight">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body no-padding">
                            <div id="vitalsign"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="reset" onclick="resetform();" class="btn btn-danger">Clear</button>
                <a class="btn btn-success" href="javascript:conf()">Save</a>
            </div>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="doctormodal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!--<div class="color-line"></div>-->
            <div class="modal-header">
                <h4 class="modal-title">เลือกแพทย์</h4>
                <h4>ชื่อผู้ป่วย (<span id="name_title2"></span>)</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <!--<div id="modell"/>-->
                    <form id="formdoctor" method="POST" >
                        <div class="row">
                            <input type="hidden" name="pt_hn" id="pt_hn2"/>
                            <input type="hidden" name="pt_vn" id="pt_vn2"/>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipient-name" style="text-align: right" class="col-sm-7 control-label">รายชื่อแพทย์</label>
                                    <div class="col-sm-5">
                                        <select id="doctor_id" class="form-control" name="doctor_id">
                                            <option value="1">แพทย์ A</option>
                                            <option value="2">แพทย์ B</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" style="text-align: right" class="col-sm-7 control-label">ประเภทการมารักษา</label>
                                    <div class="col-sm-5">
                                        <select id="pt_service_id" class="form-control" name="pt_service_id">
                                            <option value="1">จ่ายเงินเอง</option>
                                            <option value="2">บัตรทอง</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <button type="reset" onclick="resetform();" class="btn btn-danger">Clear</button>
                    <a class="btn btn-success" href="javascript:sendtodoctor()">Save</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function sendtodoctor() {
        swal({
            title: "ยืนยันคำสั่งหรือไม่ ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false},
        function (isConfirm) {
            if (isConfirm) {
                //$("#step1Content").load("index.php?r=Opdandipd/km4getptopd/loadpage");
                $.post('index.php?r=Opdandipd/km4getptopd/cmd_opd_md_assign', $("#formdoctor").serialize(), function (response) {
//                    window.location.reload();
//                });
                    $("#doctormodal").modal("hide");
                    swal(response, "", "success");
                    //alert(response);
                });
//
            } else {
                swal("Cancelled", "", "error");
            }
        }
        );
    }
    function resetform() {
        document.getElementById("formtmtgpu").reset();
        document.getElementById("formdoctor").reset();
    }
    function history() {
        var hn = $('#pt_hn').val();
        $("#vitalsign").load("index.php?r=Opdandipd/km4getptopd/vitalhistory&hn=" + hn);
    }
    function conf() {
        swal({
            title: "ยืนยันคำสั่งหรือไม่ ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false},
        function (isConfirm) {
            if (isConfirm) {
                //$("#step1Content").load("index.php?r=Opdandipd/km4getptopd/loadpage");
                $.post('index.php?r=Opdandipd/km4getptopd/cmd_pt_vs_save', $("#formtmtgpu").serialize(), function (response) {
//                    window.location.reload();
//                });
                    $("#myModal7").modal("hide");
                    swal(response, "", "success");
                    //alert(response);
                });
//
            } else {
                swal("Cancelled", "", "error");
            }
        }
        );
    }
</script>

