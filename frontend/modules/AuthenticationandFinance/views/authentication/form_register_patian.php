
<!--<link href="imageselect/css/demo.css" rel="stylesheet">
    <link href="imageselect/css/buttons.css" rel="stylesheet">
    <link href="imageselect/css/imgSelect.css" rel="stylesheet">-->

    <!-- JavaScript -->
<!--     <script src="imageselect/js/jquery-1.11.0.min.js"></script>
<script src="imageselect/js/jquery.Jcrop.min.js"></script>
<script src="imageselect/js/imgSelect.js"></script>-->
<!--<script type="text/javascript" src="web/js/webcam.js"></script>
$model->PT_NATION_ID
-->
<div class="row">
    <div class="col-md-6">
        <div style="font-size: 16pt" class="header-fullname"><?php echo $model->title->pt_titlename . $model->PT_FNAME_TH . ' ' . $model->PT_LNAME_TH ?></div>
        <br>
         <br>
        <div class="header-information"><b>HN: </b> <?php echo $model->PT_HOSPITAL_NUMBER . '<b> สัญชาติ: </b>' . $nation->pt_nation_decs . ' <b> อายุ: </b>' . $model->PT_DOB . ' <b> ปี </b>' ?></div>
        <div class="header-information"><b>VN: </b> - <b>AN: </b> <?php echo !empty($an) ? $an:'-' ?></div>
        <div class="header-information"><b>วันที่: </b> <?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($model->PT_REGISTRY_DATE) . '<b> เวลา: </b>' . $model->PT_REGISTRY_TIME ?></div>
        <div class="header-information"><b>สิทธิการรักษา: </b> <?php echo !empty($modelmainscl->PT_MAININSCL_ID)? $modelmainscl->PT_MAININSCL_ID :'' ?></div>
        <div class="header-information"><b>ชื่อหน่วยงานต้นสิทธิ์: </b> <?php echo !empty($modelrefer->REFER_HSENDER_CODE) ? $modelrefer->REFER_HSENDER_CODE :'' ?></div>
        <br>
        <div class="header-information"><b>เลขที่ใบส่งตัว: </b> <?php echo !empty($modelrefer->REFER_HSENDER_DOC_ID)? $modelrefer->REFER_HSENDER_DOC_ID :'' ?></div>
        <div class="header-information"><b>วันเริ่มใบส่งตัว: </b> <?php echo !empty($modelrefer->REFER_HSENDER_DOC_START) ? Yii::$app->componentdate->convertMysqlToThaiDate2($modelrefer->REFER_HSENDER_DOC_START) : '' ?></div>
        <div class="header-information"><b>วันสิ้นสุดใบส่งตัว: </b> <?php echo !empty($modelrefer->REFER_HSENDER_DOC_EXPDATE)? Yii::$app->componentdate->convertMysqlToThaiDate2($modelrefer->REFER_HSENDER_DOC_EXPDATE) : '' ?></div>
        <input type="hidden" value="<?php echo  $checkvalueid ?>" id="checkvalueid"/>
        <input type="hidden" value="<?php echo  $exprefer ?>" id="exprefer"/>
    </div>
    <div class="col-md-6">
        <div class="col-md-12"><?php
            if ($checkvalueid == 'NG') {
                echo 'มีการลงทะเบียนแล้วในระบบ';
            }
            ?></div>
            <div class="col-md-12"><?php
                if ($exprefer == 'exp') {
                    echo 'ใบส่งส่งตัวหมดอายุ';
                }
                ?>
            </div>
        </div>
        <!--<div class="col-md-6">-->   
        <!-- imgSelect Container 2 -->
    <!--        <div id="imgselect_container2">
                 Upload & Webcam buttons 
                <img src="https://www.gravatar.com/avatar/0?d=mm&s=150" class="avatar avatar2">
                <button type="button" class="btn btn-success imgs-webcam">Webcam</button>  .imgs-webcam 
                 Webcam & Crop containers 
                <div class="imgs-webcam-container"></div>  .imgs-webcam-container 
                <div class="imgs-crop-container"></div>  .imgs-crop-container 
                 Action buttons 
                <button type="button" class="btn btn-primary imgs-save">Save Image</button>  .imgs-save 
                <button type="button" class="btn btn-primary imgs-newsnap">New Snapshot</button>  .imgs-newsnap 
                <button type="button" class="btn btn-primary imgs-capture">Capture</button>  .imgs-capture 
                <button type="button" class="btn btn-default imgs-cancel">Cancel</button>  .imgs-cancel 
                <div class="imgs-alert alert"></div>  .imgs-alert 
            </div>-->
    <!--            <div id="results"></div>
                <div id="my_camera"></div>
                <img src="assets/img/avatars/admin.png" alt="" class="header-avatar" width="200" height="150" />
                <br>-->
                <!--<button type="button" class="btn btn-success imgs-webcam">Webcam</button>-->
    <!--            <a onclick="camerashow()" class="btn btn-success" href="#">Web Cam</a>
    <a onclick="take_snapshot()" class="btn btn-success" href="#">ถ่ายภาพ</a>-->
</div>
<!--</div>-->
<!--<div class="col-md-4"style="display: none">
    <input type="text"  class="form-control" id="myInputTextField"/>
</div> <a class="btn btn-success" id="add_authenticaton">เพิ่มสิทธิ์</a> 

<div class="row">
    <div class="col-lg-12">
        <table id="tb_right_id" class="table table-bordered">
            <thead>
                <tr>
                    <th>ลำดับสิทธิ์</th><th>สิทธิ์การรักษา</th><th>ชื่อหน่วยงาน(ลูกหนี้)</th><th>เลขที่ใบส่งตัว</th><th>วันที่เริ่มใบส่งตัว</th><th>วันสิ้นสุดใบส่งตัว</th><th>ใช้สิทธิ์</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
<?php // foreach ($authenticationright as $r) { ?>
                    <tr>
                        <td><?php // echo $r->pt_ar_seq     ?></td> <td><?php // echo $r->medical_right_group     ?></td><td><?php // echo $r->ar_name     ?></td><td><?php // echo $r->refer_hrecieve_doc_date     ?></td><td><?php // echo $r->refer_hsender_doc_start     ?></td><td><?php // echo $r->refer_hsender_doc_expdate     ?></td><td><?php // echo $r->pt_ar_usage     ?></td><td><a class="btn btn-success">Detail</a><a class="btn btn-info">Edit</a><a class="btn btn-info">Delete</a></td>
                    </tr>
<?php // } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="form-group" style="text-align: right;">
    <hr>
    <div style="margin-right: 10px">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<?php // Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
<?php // Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>  
    </div>  
</div>-->
<?php
$s = <<< JS

/*$('#add_authenticaton').click(function (e) {
    $('#modal_add_right_opd_and_ipd').modal({show: 'true'}); 
    $.ajax({
        url: 'index.php?r=AuthenticationandFinance/authentication/ar-right-list',
        type: 'get',
        success: function (data) {
         $('#table_right_list').html(data);
     }
 }); 
 $.ajax({
    url: 'index.php?r=AuthenticationandFinance/authentication/get-pt-ardetail',
    type: 'POST',
    success: function (data) {
     $('#detail_right_and_refer').html(data);
 }
}); 
});       
oTable = $("#tb_right_id").DataTable({
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
}
);    
$('#myInputTextField').keyup(function(){
    oTable.search($(this).val()).draw() ;
});
$('#tb_right_id_filter,#tb_right_id_length').css('display','none');
        */
JS;
$this->registerJs($s);
?>

<script language="JavaScript">
    /* function camerashow() {
     Webcam.set({
     width: 320,
     height: 240,
     image_format: 'jpeg',
     jpeg_quality: 90
     });
     Webcam.attach('#my_camera');
     }
     function camara() {
     Webcam.reset();
     }
     function take_snapshot() {
     // take snapshot and get image data
     Webcam.snap(function (data_uri) {
     // display results in page
     $(".header-avatar").attr("src", data_uri);
     $("#my_camera").removeAttr("style");
     camara();
     //document.getElementById('results').innerHTML = '<img id="image" src="'+data_uri+'"/>';
     });
     
 }*/
</script>
<script>

//            new ImgSelect( $('#imgselect_container1'), {
//                crop: {
//                    aspectRatio: 1
//                },
//                uploadComplete: function(image) {
//                    // Calculate the default selection for the cropper
//                    var select = (image.width > image.height) ?
//                            [(image.width-image.height)/2, 0, image.height, image.height] :
//                            [0, (image.height-image.width)/2, image.width, image.width];
//
//                    this.crop.setSelect = select;
//                },
//                cropComplete: function(image) {
//                    $('.avatar1').attr('src', image.url);
//                    $('#nameimage').attr('value', image.name);
//                }
//            });
//
//            new ImgSelect( $('#imgselect_container2'), {
//                crop: {
//                    aspectRatio: 1
//                },
//                uploadComplete: function(image) {
//                    // Calculate the default selection for the cropper
//                    var select = (image.width > image.height) ?
//                            [(image.width-image.height)/2, 0, image.height, image.height] :
//                            [0, (image.height-image.width)/2, image.width, image.width];
//
//                    this.crop.setSelect = select;
//                },
//                cropComplete: function(image) {
//                    $('.avatar2').attr('src', image.url);
//                    $('#nameimage').attr('value', image.name);
//                }
//            });
</script>



