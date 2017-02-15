<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\helpers\Url;
use kartik\grid\GridView;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;
WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);
// echo $checklot;
// echo $checkpacklot;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="well">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => '_modal_edit']); ?>
            <div class="row">
                <div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group" >
                        <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label no-padding-right"><b>รหัสสินค้า:</b></label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="margin-top: 8px;">
                            <?php echo $model['ItemID'] ?>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label no-padding-right"><b>รายละเอียดสินค้า:</b></label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="margin-top: 8px;">
                            <?php echo $ItemName ?>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label no-padding-right"><b>จำนวน:</b></label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style="margin-top: 8px;">
                            <?php echo $model['GRQty'] ?>  <?php echo $model['GRUnit'] ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label no-padding-right"><b>วันหมดอายุ:</b></label>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <?=
                                    $form->field($model, 'ItemExpDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                       'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: #FFFF99',
                                            'placeholder' => '',
                                        ],
                                    ])
                                    ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 10px;">
                        <label class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label no-padding-right"><b>หมายเลขการผลิต:</b></label>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        <?=
                            $form->field($model, 'ItemExternalLotNum', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            'style' => 'background-color:#FFFF99'
                            ])
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group" style="text-align: right;margin-right: 5px;">
                        <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                        <a class="btn btn-success" id="Save_modal" onclick="fn_save(<?php echo $model->ItemInternalLotNum ?>);">Save</a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    function fn_save($key){
        var ItemInternalLotNum = $key;
        var ExpDate = $('#vwgr2lotassigneddetail2-itemexpdate').val();
        var External = $('#vwgr2lotassigneddetail2-itemexternallotnum').val();
        if(ItemInternalLotNum&&ExpDate&&External){
            swal({   
            title: "ยืนยันคำสั่ง?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: true
            },function(){
                $.ajax({
                url: "update-lotnumber",
                type: "post",
                data: {ItemInternalLotNum: ItemInternalLotNum, ExpDate: ExpDate, External:External},
                dataType: 'json',
                    success: function (data) {
                        $('#modal_edit').modal('hide');
                        $.pjax.reload({container: '#gr_donate_detail'});
                        swal('','อัพเดตข้อมูลเรียบร้อยแล้ว','success');
                    },
                    error:function (data){
                        console.log('server error!!');
                    }
                });
            });
        }else{
            swal('','กรุณากรอกข้อมูลให้ครบ','warning');
        }
    }
</script>
<?php
$script = <<< JS
// $(document).ready(function () {
//     alert('Test');

// });
JS;
$this->registerJs($script);
?>