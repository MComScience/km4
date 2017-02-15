<style>
    .txt-center {
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-6">
        <input type="hidden" value="<?php echo $modelregitedlist->pt_hospital_number; ?>"  id="hn"/> 
        <input type="hidden" value="<?php echo $modelregitedlist->pt_visit_number; ?>" id="vn" />
        <input type="hidden" id="_csrf" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
        <div style="font-size: 16pt" class="header-fullname"><?php echo $modelregitedlist->pt_name; ?></div>
        <div class="header-information"><b>HN:</b> <?php echo $modelregitedlist->pt_hospital_number; ?><b> สัญชาติ </b><?php echo $modelregitedlist->pt_nation_decs; ?></div>
        <div class="header-information"><b>VN:</b> <?php echo $modelregitedlist->pt_visit_number; ?> <b>AN:</b> <?php echo $modelregitedlist->pt_admission_number != null ? $modelregitedlist->pt_admission_number : '-'; ?></div>
        <div class="header-information"><b>วันที่:</b> <?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($modelregitedlist->pt_registry_date); ?><b> เวลา: </b><?php echo $modelregitedlist->pt_registry_time; ?> </div>
        <br><br><br><a class="btn btn-success" href="javascript:addright();">เพิ่มสิทธิ</a><span style="text-align: right"></span>
    </div>
    <div class="col-md-6">
        <div id="webcam"></div>
        <div class="col-md-6">

        </div>
        <div class="col-md-6" >
            <div class="col-lg-2 col-md-4 col-sm-12 text-center">
                <img src="assets/img/avatars/admin.png" style="width: 150px;height: 150px;" id="image"  class="header-avatar">
            </div>

            <div style="margin-top:155px;text-align: center">
                <a class="btn btn-small btn-success"  id="btnshowcamera" onclick="showwebcam()"> <i class="glyphicon glyphicon-camera"></i> ShowWebCam</a>
                <a class="btn btn-small btn-success hidden" id="btntakesnapimg" onclick="base64_toimage()"><i class="glyphicon glyphicon-camera"></i></a>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div id="table_right" style="margin:10px">
            <table id="example" border="1" width="100%" class="table table-striped table-bordered dt-responsive norap">
               <thead>
                <tr>
                    <th style="text-align: center">ลำดับสิทธิ์</th>
                    <th style="text-align: center">สิทธิ์การรักษา</th> 
                    <th style="text-align: center">ชื่อหน่วยงาน(ลูกหนี้)</th>
                    <th style="text-align: center">เลขที่ใบส่งตัว</th>
                    <th style="text-align: center">วันที่เริ่มใบส่งตัว</th>
                    <th style="text-align: center">วันสิ้นสุดใบส่งตัว</th>
                    <th style="text-align: center">ใช้สิทธิ์</th>
                    <th style="text-align: center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                foreach ($modelardetail as $value) {
                    ?>
                    <tr>
                        <td style="text-align: center"><?php echo $value['pt_ar_seq'] ?></td> 
                        <td style="text-align: center"><?php echo $value['medical_right_group']; ?></td>
                        <td ><?php echo $value['ar_name'] ?></td> 
                        <td style="text-align: center"><?php echo $value['refer_hsender_doc_id'] ?></td>
                        <td style="text-align: center"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($value['refer_hsender_doc_start']) ?></td>
                        <td style="text-align: center"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($value['refer_hsender_doc_expdate']) ?></td>
                        <td style="text-align: center"><?php echo $value['pt_ar_usage'] ?></td> 
                        <td style="text-align: center"><a href="javascript:editar(<?php  echo $value['pt_ar_id'] ?>)" class="btn btn-info btn-xs">Edit</a> <a href="javascript:deletear(<?php  echo $value['pt_ar_id'] ?>)" class="btn btn-danger btn-xs">Delete</a></td>
</tr>
<?php
}
?>
</tbody>
</table>
</div>
</div>
<div class="form-group" style="text-align: right;margin:10px">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
</div>
</div>
<?php
$s = <<< JS
$('#example').DataTable({
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

function addright(){
 waitMe_Running_show(1);
 var hn = $('#hn').val();
 var vn = $('#vn').val();
 $.ajax({
    url: 'index.php?r=AuthenticationandFinance/authentication/addartopatain',
    type: 'get',
    data:{hn:hn,vn:vn},
    success: function (data) {
        $('#detail_add_right').html(data);
        $('#modal_add_right_opd_and_ipd2').modal({show: 'true'}); 
        waitMe_Running_hide(1);
    }
});
}  

JS;
$this->registerJs($s);
?>
<script>
  
    function deletear(id){
        var vn = $('#vn').val();
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
        $.ajax({
            url: "index.php?r=AuthenticationandFinance/authentication/delete-ar",
            type: "get",
            data: {id: id,vn:vn},
            success: function (result) {
                $('#table_right').html(result);
                $('#example').DataTable({
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
            }
        });
        }
        });

    }
    function showwebcam() {

        var id = "#webcam";
        $('#btntakesnapimg').removeClass('hidden');
        $('#btnshowcamera').addClass('hidden');
        $(id).scriptcam({
            showMicrophoneErrors: false,
            onError: onError,
            cornerRadius: 20,
            cornerColor: 'e3e5e2',
            onWebcamReady: onWebcamReady,
            // uploadImage: 'upload.gif',
            onPictureAsBase64: base64_tofield_and_image
        });


    }
    function base64_tofield() {
        $('#formfield').val($.scriptcam.getFrameAsBase64());
    }
    ;
    function base64_toimage() {
        var ima = "data:image/png;base64," + $.scriptcam.getFrameAsBase64();
        $.ajax({
            url: "index.php?r=Report/report-purchasing/saveimage",
            type: "post",
            data: {im: ima},
            success: function (result) {
                $('#image').attr("src", result);
                $("#webcam").replaceWith("<div id='webcam'></div>");
                $('#btntakesnapimg').addClass('hidden');
                $('#tbitem-itempic').val(result);
                $('#btnshowcamera').removeClass('hidden');
                var hn = $('#hn').val();
                var vn = $('#vn').val();
                var _csrf = $('#_csrf').val();
                var res = result.split("/");
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/saveimage',
                    type: 'post',
                    data: {hn: hn, vn: vn, pt_picture: res['1'], pt_picture_path: result, _csrf: _csrf},
                    success: function (data) {

                    }
                });
            }
        });
    }
    ;
    function base64_tofield_and_image(b64) {
        $('#formfield').val(b64);
        $('#image').attr("src", "data:image/png;base64," + b64);
    }
    ;
    function changeCamera() {
        $.scriptcam.changeCamera($('#cameraNames').val());
    }
    function onError(errorId, errorMsg) {
        $("#btn1").attr("disabled", true);
        $("#btn2").attr("disabled", true);
        alert(errorMsg);
    }
    function onWebcamReady(cameraNames, camera, microphoneNames, microphone, volume) {
        $.each(cameraNames, function (index, text) {
            $('#cameraNames').append($('<option></option>').val(index).html(text))
        });
        $('#cameraNames').val(camera);
    }
    ;
</script>
