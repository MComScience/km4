<?php ?>

<form role="form" id="form_vendormail">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="form-group">
                <label for="Subject">ชื่อเรื่อง</label>
                <input type="text" class="form-control" id="Subject" placeholder="ชื่อเรื่อง" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">ข้อความที่ต้องการส่ง ถึง <span id="name_email"></span></label>
                <div class="summernote"></div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="CC">
                        <span class="text" >CC</span>
                    </label>
                </div>

            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" placeholder="E-Mail" id="CCMail">
                    </div>
                </div> 
            </div>
            <input class="form-control" id="VendorEmail" type="hidden" name="VendorEmail"/>
            <input class="form-control" id="VendorName" type="hidden" name="VendorName"/>

            <div class="form-group " style="text-align: right;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a class="btn btn-blue" onclick="SendmailtoVendor(this);">Send</a>
            </div>

        </div> 
    </div>
</form>
