<div class="modal-body">
    <form id="formtmtgpu">
        <input type="hidden" value="<?php echo!empty($types) ? $types : '' ?>" id="types"/>
        <input type="hidden" id="ids" name="ids" value="">
        <input type="hidden" value="" name="prnum" id="prnum">
        <div class="row">
            <div class="col-md-4"> 
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-7 control-label">รหัสยาสามัญ:</label>
                    <input type="text" name="tmtgpu"  readonly="true" class="form-control" id="recipient-name">
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label for="message-text" class="col-sm-7 control-label">รายละเอียดยาสามัญ:</label>
                    <textarea class="form-control" readonly="true" rows="2" name="fsngpu" id="fsngpu"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">ราคาต่อหน่วย:</label>
                    <input type="text" style="background-color: #FFFF99;text-align:right"   class="form-control" style="background-color:#ffff99" id="gpuunitCost" name="gpuunitCost">
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">จำนวน:</label>
                    <input type="text" onchange ="JavaScript:chkNum(this)" style="background-color: #FFFF99;text-align:right" class="form-control"  id="gpuorderqty" style="background-color:#ffff99" name="gpuorderqty">
                </div>
            </div>
            <div class="col-xs-6 col-sm-2">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">หน่วย:</label>
                    <input id="noii" type="text" readonly class="form-control"  id="gpuorderqty" >
                </div>
            </div>
            <!-- Add the extra clearfix for only the required viewport -->
            <div class="clearfix visible-xs-block"></div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">รวมเป็นเงิน:</label>
                    <input type="text" style="text-align: right" class="form-control" id="gpuextended" readonly="" name="gpuextended">
                </div>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="form-group">
                    <label for="recipient-name" class="col-sm-12 control-label">วันที่เริ่มใช้:</label>
                    <input type="text" class="form-control calendar" id="effectivedate" name="effectivedate" style="background-color:#ffff99">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <a class="btn btn-danger ladda-button" href="javascript:crear();" data-style = 'expand-left'> Clear</a>
    <a class="btn btn-default ladda-button" href="javascript:cleartable();" data-style = 'expand-left' data-dismiss="modal">Close</a>
    <a href="javascript:saveprdetail()" class="btn btn-success ladda-button" data-style = 'expand-left'> save</a>
</div>

<?php
$scripts = <<< JS
  $("#effectivedate").datepicker({});
  $('#effectivedate').val($('#tbpcplan-pcplanenddate').val());
  $('#gpuunitCost').priceFormat({prefix: ''});
  $('#gpuorderqty').priceFormat({prefix: ''});
    $("#gpuunitCost").keyup(function () {
         var gpuunitCost = parseFloat($("#gpuunitCost").val().replace(/[,]/g, "")); 
          var gpuorderqty = parseFloat($("#gpuorderqty").val().replace(/[,]/g, "")); 
          var sum = gpuunitCost * gpuorderqty;
          $("#gpuextended").val(addCommas(sum.toFixed(2)));
    });
       $("#gpuorderqty").keyup(function () {
         var gpuunitCost = parseFloat($("#gpuunitCost").val().replace(/[,]/g, "")); 
          var gpuorderqty = parseFloat($("#gpuorderqty").val().replace(/[,]/g, "")); 
          var sum = gpuunitCost * gpuorderqty;
          $("#gpuextended").val(addCommas(sum.toFixed(2)));
    });  

JS;
$this->registerJs($scripts);
?>