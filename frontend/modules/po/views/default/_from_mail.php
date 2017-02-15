<?php

use yii\bootstrap\Modal;
use frontend\assets\LaddaAsset;
use frontend\assets\WaitMeAsset;
WaitMeAsset::register($this);
LaddaAsset::register($this);
?>
<?php
Modal::begin([
    'id' => 'modalsendmail',
    'header' => '<h4 class="modal-title">ส่งใบสั่งซื้อผ่าน E-mail</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
    'options' => ['tabindex' => false, 'class' => 'modal-mail'],
]);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form id="formmail" class="form-horizontal" role="form" method="post" data-bv-message="This value is not valid"
              data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
              data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
              data-bv-feedbackicons-validating="glyphicon glyphicon-refresh">
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right">เลขที่ใบสั่งซื้อ</label>
                <div class="col-sm-3">
                    <input class="form-control" name="PONum" id="PONum" style="background-color: white" readonly=""/> 
                </div>
                <label class="col-sm-2 control-label no-padding-right">เลขที่ผู้จำหน่าย</label>
                <div class="col-sm-3">
                    <input class="form-control" name="VendorID" id="VendorID" style="background-color: white" readonly=""/> 
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right">วันที่</label>
                <div class="col-sm-3">
                    <input class="form-control" name="PODate" id="PODate" style="background-color: white" readonly=""/> 
                </div>
                <label class="col-sm-2 control-label no-padding-right">ชื่อผู้จำหน่าย</label>
                <div class="col-sm-3">
                    <input class="form-control" name="VendorName" id="VendorName" style="background-color: white" readonly=""/> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right"></label>
                <div class="col-sm-3">
                    <input class="form-control" type="hidden" id="POID"/>
                </div>
                <label class="col-sm-2 control-label no-padding-right">E-mail ผู้รับ</label>
                <div class="col-sm-3">
                    <input required="" data-bv-emailaddress-message="The input is not a valid email address" class="form-control" name="Email" id="Email" style="background-color: #ffff99" type="email"/> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right">ชื่อเรื่อง</label>
                <div class="col-sm-8">
                    <input class="form-control" name="Subject" id="Subject" style="background-color: #ffff99"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right">ข้อความ</label>
                <div class="col-sm-8">
                    <div id="summernote"></div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10" style="text-align: right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="clear3" class="btn btn-danger" onclick="Clearnote(this);" type="button">Clear</button>
                    <!--            <button id="edit" class="btn btn-info" onclick="edit()" type="button">Edit</button>-->
                    <a id="save" class="btn btn-primary ladda-button" onclick="send(this);" type="button" data-style="expand-left">Send</a>
                </div>
            </div>
        </form>   
    </div>
</div>
<?php Modal::end(); ?>
