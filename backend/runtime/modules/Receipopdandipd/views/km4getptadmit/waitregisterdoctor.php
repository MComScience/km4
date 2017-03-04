<div class="col-lg-12">
    <div class="hpanel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li ><a  href="index.php?r=Opdandipd/km4getptadmit" aria-expanded="true">รายชื่อผู้ป่วยรอลงทะเบียน</a></li>
                <li ><a  href="index.php?r=Opdandipd/km4getptadmit/admitipdregister" aria-expanded="false">รายชื่อผุ้ป่วยในลงทะเบียนแล้ว</a></li>
                <li class="active"><a  href="index.php?r=Opdandipd/km4getptadmit/waitregisterdoctor" aria-expanded="false">รายชื่อผู้ป่วยส่งพบแพทย์</a></li>
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
                                        <th style="text-align: center;width: 5%">ลำดับ</th>
                                        <th style="text-align: center;width: 10%">HN</th>
                                        <th style="text-align: center;width: 10%">VN</th>
                                        <th style="text-align: center;width: 10%">AN</th>
                                        <th style="text-align: center">ชื่อ - สกุล</th>
                                        <th style="text-align: center">สิทธิการรักษา</th>
                                        <th style="text-align: center">สถานะผู้ป่วย</th>
                                        <th style="text-align: center">แผนก</th>
                                        <th style="text-align: center">ชื่อแพทย์</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($wgd)) {
                                        $a = 1;
                                        foreach ($wgd as $r) {
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?php echo $a; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_hospital_number; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_visit_number ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_admission_number; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_fullname; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_maininscl_id; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_servicetrans_statusid; ?></td>
                                                <td style="text-align: center"><?php echo $r->section_id; ?></td>
                                                <td style="text-align: center"><?php echo $r->pt_service_op_id; ?></td>
                                               <!--<td><a  class="btn btn-success" href="index.php?r=Opdandipd/km4getptopd/save_service_arrive&hn=//<?php // echo $r->PT_HOSPITAL_NUMBER                     ?>&&date=<?php // echo $r->PT_REGISTRY_DATE                     ?>">ลงทะเบียน</a></td>-->

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

<?php
$s = <<< JS
   $("#example2").dataTable({
       "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
           }); 
JS;
$this->registerJs($s);
?>
