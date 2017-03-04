
<?php

use yii\bootstrap\Html;

foreach (Yii::$app->session->getAllFlashes() as $message):
    ?>
    <?php
    echo \kartik\widgets\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
    ?>
<?php endforeach; ?>
<?php

$this->registerJs('
    $("#opd").addClass("active");
    $("#opd_chemistryin").toggleClass("in");
    $("#opd_chemistry").addClass("active");
    '); 
?>

<div class="col-lg-12">
    <div class="hpanel">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active"><a  href="index.php?r=Opdandipd/km4getptopd" aria-expanded="true">รายชื่อผูป่วยรอลงทะเบียน</a></li>
                <li class=""><a  href="index.php?r=Opdandipd/km4getptopd/opdregister" aria-expanded="false">รายชื่อผุ้ป่วยนอกลงทะเบียนแล้ว</a></li>
                <li class=""><a  href="index.php?r=Opdandipd/km4getptopd/waitregisterdoctor" aria-expanded="false">รายชื่อผู้ป่วยส่งพบแพทย์</a></li>
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
                                        <th style="text-align: center;width: 15%">HN</th>
                                        <th style="text-align: center">ชื่อผู้รับริการ</th>
                                    
                                        <th style="text-align: center">แผนก</th>
                                        <th style="text-align: center;width: 5%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $a = 1;
                                    foreach ($km4opd as $r) {
                                        if ($r->d['pt_registry_date'] != date('Y-m-d') && $r->d['pt_registry_date'] == null) {
                                            ?>
                                            <tr>
                                                <td style="text-align: center"><?php echo $a; ?></td>
                                                <td style="text-align: center"><?php echo $r->PT_HOSPITAL_NUMBER; ?></td>
                                                <td style="text-align: left"><?php echo $r->title['pt_titlename'].$r->PT_FNAME_TH.' '.$r->PT_LNAME_TH; //echo $r->PT_TITLENAME_ID                      ?></td>
                                                <td style="text-align: center"><?php echo $r->PT_SERVICE_SECTION_ID; ?></td>
                                                <!--<td><a  class="btn btn-success" href="index.php?r=Opdandipd/km4getptopd/save_service_arrive&hn=//<?php // echo $r->PT_HOSPITAL_NUMBER                ?>&&date=<?php // echo $r->PT_REGISTRY_DATE                ?>">ลงทะเบียน</a></td>-->
                                                <td style="text-align: center"><a  class="btn btn-success"  href="javascript:conf(<?php echo $r->PT_HOSPITAL_NUMBER ?>,<?php echo str_replace('-', '', $r->PT_REGISTRY_DATE) ?>)">ลงทะเบียน</a></td>
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
//$this->registerJsFile('newcss/vendor/peity/jquery.peity.min.js');
?>


<!--<div class="hpanel">
    <div class="panel-heading">
       

    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table id="example2" class="table table-striped table-bordered table-hover ">
                <thead>
                    <tr> 
                        <th style="text-align: center;width: 5%">ลำดับ</th>
                        <th style="text-align: center;width: 15%">HN</th>
                        <th style="text-align: center">คำนำหน้า</th>
                        <th style="text-align: center">ชื่อ</th>
                        <th style="text-align: center">นามสกุล</th>
                        <th style="text-align: center">แผนก</th>
                        <th style="text-align: center;width: 5%">Action</th>
                    </tr>
                </thead>
                <tbody>
<?php
//                    $a = 1;
//                    foreach ($km4opd as $r) {
//                        if ($r->d['pt_registry_date'] != date('Y-m-d') && $r->d['pt_registry_date'] == null) {
//                            
?>
                            <tr>
                                <td>//<?php // echo $a;  ?></td>
                                <td>//<?php // echo $r->PT_HOSPITAL_NUMBER;  ?></td>
                                <td>//<?php // echo $r->title['pt_titlename']; //echo $r->PT_TITLENAME_ID                      ?></td>
                                <td>//<?php // echo $r->PT_FNAME_TH;  ?></td>
                                <td>//<?php // echo $r->PT_LNAME_TH;  ?></td>
                                <td>//<?php // echo $r->PT_SERVICE_SECTION_ID;  ?></td>
                                <td><a  class="btn btn-success" href="index.php?r=Opdandipd/km4getptopd/save_service_arrive&hn=//<?php // echo $r->PT_HOSPITAL_NUMBER                ?>&&date=<?php // echo $r->PT_REGISTRY_DATE                ?>">ลงทะเบียน</a></td>
                                <td><a  class="btn btn-success"  href="javascript:conf(//<?php // echo $r->PT_HOSPITAL_NUMBER ?>,<?php // echo str_replace('-', '', $r->PT_REGISTRY_DATE) ?>)">ลงทะเบียน</a></td>
                            </tr>
                            //<?php
//                            $a++;
//                        }
//                    }
?>
                </tbody>
            </table>
        </div>
    </div>
</div>-->
<script>
    function conf(hn, dat) {
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
               // swal("ยืนยันคำสั่งแล้ว", "", "success");
                $("#step1Content").load("index.php?r=Opdandipd/km4getptopd/loadpage");
                $.get('index.php?r=Opdandipd/km4getptopd/save_service', {hn: hn, dat: dat}, function (response) {
                    window.location.reload();
                });
            } else {
                swal("Cancelled", "", "error");
            }
        });
    }
</script>
<?php
$s = <<< JS
   $("#example2").dataTable({
       "sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>'
           }); 
JS;
$this->registerJs($s);
?>
