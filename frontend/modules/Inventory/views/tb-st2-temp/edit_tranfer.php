<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use app\modules\Inventory\models\VwItempack;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['id' => 'st2_item_save', 'type' => ActiveForm::TYPE_HORIZONTAL]); ?>
<div class="form-group">
    <?= $form->field($stdata, 'STID', ['showLabels' => false])->hiddenInput(); ?>
    <?= $form->field($stdata, 'ids', ['showLabels' => false])->hiddenInput(); ?>
    <?= $form->field($stdata, 'ItemInternalLotNum', ['showLabels' => false])->hiddenInput(); ?>
    <?= Html::activeLabel($model, 'ItemID', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'ItemID', ['showLabels' => false])->textInput(['readonly' => TRUE]); ?>
    </div>
    <input type="hidden" id="itempackid" value="<?php echo!empty($model->SRItemPackIDApprove) ? $model->SRItemPackIDApprove : '' ?>"/>
    <label class="col-sm-2 control-label">คลังสินค้า</label>
    <div class="col-sm-2">
        <input type="hidden" name="stkid" class="form-control" value="<?php echo $stkmodel->StkID ?>"/>
        <input type="text" name="stkname" class="form-control" readonly="" value="<?php echo $stkmodel->StkName ?>"/>
    </div>
    <div class="col-sm-12">
        <?php echo $form->field($item, 'ItemName')->textarea(['maxlength' => true, 'rows' => 3, 'readonly' => true])->label('รายละเอียดสินค้า') ?>
    </div>

</div>
<?php if (!empty($searchModel) && $searchModel != "") { ?>
    <div class="form-group" style="margin: 10px">
        <?=
        kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'bootstrap' => true,
            'responsiveWrap' => FALSE,
            'responsive' => true,
            'hover' => true,
            'pjax' => true,
            'striped' => true,
            'condensed' => true,
            'toggleData' => false,
            'pageSummaryRowOptions' => ['class' => 'default'],
            'layout' => "{summary}\n{items}\n{pager}",
            'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
            'columns' => [
                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemInternalLotNum',
                                    'header' => '<font color="black">ItemInternalLotNum</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemInternalLotNum == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemInternalLotNum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemExternalLotNum',
                                    'header' => '<font color="black">หมายเลขการผลิต</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemExternalLotNum == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemExternalLotNum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemExpdate',
                                    //'format' => ['date', 'php:d/m/Y'],
                                    'header' => '<font color="black">วันหมดอายุ</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemExpdate == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemExpdate;
                                }
                            }
                                ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    //'attribute' => 'PackQTY',
//                                    'header' => '<a>จำนวนแพค</a>',
//                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                    'value' => function ($model) {
//                                if ($model->PackQTY == NULL) {
//                                    return '-';
//                                } else {
//
//                                    return $model->PackQTY;
//                                }
//                            }
//                                ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    //'attribute' => 'PackItemUnitCost',
//                                    'header' => '<a>ราคา/แพค</a>',
//                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                    'value' => function ($model) {
//                                if ($model->PackItemUnitCost == NULL) {
//                                    return '-';
//                                } else {
//
//                                    return $model->PackItemUnitCost;
//                                }
//                            }
//                                ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    //'attribute' => 'PackUnit',
//                                    'header' => '<a>หน่วยแพค</a>',
//                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                    'value' => function ($model) {
//                                if ($model->PackUnit == NULL) {
//                                    return '-';
//                                } else {
//
//                                    return $model->PackUnit;
//                                }
//                            }
//                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemQty',
                                    'header' => '<font color="black">จำนวน</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemQty == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemQty;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'DispUnit',
                                    'header' => '<font color="black">หน่วย</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->DispUnit == NULL) {
                                    return '-';
                                } else {

                                    return $model->DispUnit;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemUnitCost',
                                    'header' => '<font color="black">ราคา/หน่วย</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemUnitCost == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemUnitCost;
                                }
                            }
                                ],
            ],
        ]);
        ?>

    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label no-padding-right">ราคากลาง</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($balence, 'SRQty', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($balence, 'SRQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label no-padding-right">จำนวนที่เลือกโอนแล้ว</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($balence, 'STSelectedQty', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($balence, 'STSelectedQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label no-padding-right">จำนวนคงเหลือที่ต้องโอน</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($balence, 'STLeftQty', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($balence, 'STLeftQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-5 control-label no-padding-right">หน่วย</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($balence, 'STUnit', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($balence, 'STUnit', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">เลือกแบบ</label>
                    <div class="col-sm-6">
                    <div class="radio">
                        <label>
                            <input name="pack" type="radio" value="2" id="pack1">
                            <span class="text">แพค </span>
                        </label>
                        <label>
                            <input name="pack" type="radio" value="1" id="pack2">
                            <span class="text">ชิ้น </span>
                        </label>
                    </div>
                    </div>
                    <?php /*
                      <input type="radio" id="pack1" value="2" name="pack"/> แพค <input value="1" type="radio" id="pack2" name="pack"/> ชิ้น
                */ ?>
                </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวนแพค<a id="checkจำนวนแพค"></a></label>
                <div class="col-sm-6">
                    <?= $form->field($stdata, 'STPackQty', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วยแพค<a id="checkหน่วยแพค"></a></label>
                <div class="col-sm-6">
                    <?=
                    $form->field($model, 'STItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(VwItempack::find()->where(['ItemID' => $model->ItemID])->all(), 'ItemPackID', 'PackUnit'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                    <br>
                    <?php '<font color="red">!! ยังไม่ได้บันทึกขนาดแพค</font> <a class="btn btn-primary btn-sm">บันทึกขนาดแพค</a>'; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ปริมาณ/แพค</label>
                <div class="col-sm-6">
                    <div class="form-group field-tbstitemdetail2temp-stpackunitcost">
                        <div class="col-md-12">
                            <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                                   value="<?php echo $packsize ?>"/>
                        </div>
                        <div class="col-md-12"></div>
                        <div class="col-md-12"><div class="help-block"></div></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคา/แพค</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($innernallot, 'PackItemUnitCost', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($innernallot, 'PackItemUnitCost', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">จำนวน</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($stdata, 'STItemQty', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($stdata, 'STItemQty', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>  
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">หน่วย</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($model, 'DispUnit', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($model, 'DispUnit', ['showLabels' => false])->textInput(['style' => 'text-align:right', 'readonly' => true]); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">ราคา/หน่วย</label>
                <div class="col-sm-6">
                    <?php Html::activeLabel($innernallot, 'ItemUnitCost', ['class' => 'col-sm-5 control-label']) ?>
                    <?= $form->field($innernallot, 'ItemUnitCost', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>  
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">รวมเป็นเงิน</label>
                <div class="col-sm-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input readonly="" id="vwgr2lotassigneddetail-extencost" class="form-control" value="" style="background-color: white;text-align: right"/>
                        </div>
                        <div class="col-md-12"></div>
                        <div class="col-md-12"><div class="help-block"></div></div>  
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="reset" class="btn btn-danger" >Clear</button>
                    <button type="submit" class="btn btn-success ladda-button" data-style = 'expand-left'>Save</button>
                </div>
                <?php ActiveForm::end(); ?>

            <?php } ?>
            <?php
            $script = <<< JS
$(document).ready(function () {
        var tbstitemdetail2tempstpackqty = parseFloat($('#tbstitemdetail2temp-stpackqty').val().replace(/[,]/g, ""));
                    if(tbstitemdetail2tempstpackqty> 0){
                        $('#vwst2srbalance-stleftqty').val(tbstitemdetail2tempstpackqty);
                       }else{
                     var tbstitemdetail2tempstitemqty = parseFloat($('#tbstitemdetail2temp-stitemqty').val().replace(/[,]/g, ""));
                       $('#vwst2srbalance-stleftqty').val(tbstitemdetail2tempstitemqty);
                    }
       //<-------------   เช็คว่ามีแพคไหม  ----->
       var itempackid = $('#itempackid').val();
        if(itempackid != ""){
          $('#tbstitemdetail2temp-stpackqty').css('background-color', '#FFFF99');
          $('#pack2').removeAttr('checked', 'checked');
          $('#pack1').attr('checked', 'checked');
          $('#tbstitemdetail2temp-stitemqty,#tbstitemdetail2temp-stpackunitcost,#vwst2lotnumberavalible-itemunitcost,#vwst2lotnumberavalible-packitemunitcost').attr('readonly', 'readonly');
           var tbstitemdetail2tempstitemqty = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
           var tbstitemdetail2tempstitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
           var sum = tbstitemdetail2tempstitemqty * tbstitemdetail2tempstitemunitcost;
           $("#vwgr2lotassigneddetail-extencost").val(addCommas(sum.toFixed(2)));
       }else{
        
          $('#pack').removeAttr('checked', 'checked');
          $('#pack2').attr('checked', 'checked');
          $('#tbstitemdetail2temp-stitemunitcost,#tbstitemdetail2temp-stitemqty').css('background-color', '#FFFF99');
          $('#tbstitemdetail2temp-stpackunitcost,#tbstitemdetail2temp-stpackqty,#vwst2lotnumberavalible-itemunitcost,#vwst2lotnumberavalible-packitemunitcost').attr('readonly', 'readonly');
           var tbstitemdetail2tempstitemqty = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
           var tbstitemdetail2tempstitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
           var sum = tbstitemdetail2tempstitemqty * tbstitemdetail2tempstitemunitcost;
           $("#vwgr2lotassigneddetail-extencost").val(addCommas(sum.toFixed(2)));
           $('#vwst2detailgroup-stitempackid').attr('disabled', 'disabled');
        
   }
         //<-------------   เช็คว่ามีแพคไหม  ----->
        
        //<--- จำนวนแพค * ปริมาณต่อแพค = จำนวน * ราคาต่อหน่วย ---->
        
        $('#tbstitemdetail2temp-stpackqty').priceFormat({prefix: ''});
        $("#tbstitemdetail2temp-stpackqty").keyup(function () {
        var tbstitemdetail2tempstpackqty = parseFloat($("#tbstitemdetail2temp-stpackqty").val().replace(/[,]/g, ""));
        var ItemPackSKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        
        var vwst2srbalancestleftqty = parseFloat($("#vwst2srbalance-stleftqty").val().replace(/[,]/g, ""));
        var vwst2srbalancestselectedqty = parseFloat($("#vwst2srbalance-stselectedqty").val().replace(/[,]/g, ""));
        
         var sumavali = vwst2srbalancestleftqty;
        if(tbstitemdetail2tempstpackqty > sumavali){
            swal("", "คุณใส่เกินจำนวน", "warning");
             $('#tbstitemdetail2temp-stpackqty').val(addCommas(sumavali.toFixed(2)));
             var sumall =  sumavali * ItemPackSKUQty;
            $('#tbstitemdetail2temp-stitemqty').val(addCommas(sumall.toFixed(2)));
            var vwst2lotnumberavalibleitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
            var sumcost = sumall * vwst2lotnumberavalibleitemunitcost;
            $('#vwgr2lotassigneddetail-extencost').val(addCommas(sumcost.toFixed(2)));
        }else{
             var sumall =  tbstitemdetail2tempstpackqty * ItemPackSKUQty;
             $('#tbstitemdetail2temp-stitemqty').val(addCommas(sumall.toFixed(2)));
             var vwst2lotnumberavalibleitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
             var sumcost = sumall * vwst2lotnumberavalibleitemunitcost;
             $('#vwgr2lotassigneddetail-extencost').val(addCommas(sumcost.toFixed(2)));
     }
       
        });
        
        
         //<--- จำนวนแพค * ปริมาณต่อแพค = จำนวน * ราคาต่อหน่วย ---->
    
     //<-------------   จำนวน * ราคาต่อหน่วย  ----->  
        
        $('#tbstitemdetail2temp-stitemqty').autoNumeric('init');//priceFormat({prefix: ''});
        $("#tbstitemdetail2temp-stitemqty").keyup(function () {
        
        var tbstitemdetail2tempstitemqty = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
        var vwst2lotnumberavalibleitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
        
        var vwst2srbalancestleftqty = parseFloat($("#vwst2srbalance-stleftqty").val().replace(/[,]/g, ""));
        var vwst2srbalancestselectedqty = parseFloat($("#vwst2srbalance-stselectedqty").val().replace(/[,]/g, ""));
 
        var sumavali = vwst2srbalancestleftqty;
        if(tbstitemdetail2tempstitemqty > sumavali){
             swal("", "คุณใส่เกินจำนวน", "warning");
             $('#tbstitemdetail2temp-stitemqty').val(addCommas(sumavali.toFixed(2)));
             var sumall =  sumavali * vwst2lotnumberavalibleitemunitcost;
        $('#vwgr2lotassigneddetail-extencost').val(addCommas(sumall.toFixed(2)));
        }else{
           
           var sum  = tbstitemdetail2tempstitemqty * vwst2lotnumberavalibleitemunitcost;
           $('#vwgr2lotassigneddetail-extencost').val(addCommas(sum.toFixed(2)));    
        }
        
       
    });
        
     //<-------------   จำนวน * ราคาต่อหน่วย  ----->  
        
    $('#pack2').on('change', function() {
                $('#tbstitemdetail2temp-stitemqty').css('background-color', '#FFFF99');
                $('#tbstitemdetail2temp-stpackqty').attr('readonly', 'readonly');
                $('#tbstitemdetail2temp-stitemqty').removeAttr('readonly', 'readonly');
                $('#tbstitemdetail2temp-stpackqty').css('background-color', '#FFFFFF');
                     $('#vwst2detailgroup-stitempackid').attr('disabled', 'disabled');
   });
        
     $('#pack1').on('change', function() {
              $('#tbstitemdetail2temp-stpackqty').css('background-color', '#FFFF99');
              $('#tbstitemdetail2temp-stitemqty').attr('readonly', 'readonly');
              $('#tbstitemdetail2temp-stitemqty').css('background-color', '#FFFFFF');
              $('#tbstitemdetail2temp-stpackqty').removeAttr('readonly', 'readonly');
              $('#vwst2detailgroup-stitempackid').removeAttr('disabled', 'disabled');
   });    
        
        //เลือกแพค
        $('#vwst2detailgroup-stitempackid').on('change', function() {
            $('#tbstitemdetail2temp-stpackqty').removeAttr('readonly', 'readonly');
            $('#pack2').removeAttr('checked', 'checked');
            $('#tbstitemdetail2temp-stitemqty').attr('readonly', 'readonly');
            $('#pack1').attr('checked', 'checked');
            $('#tbstitemdetail2temp-stitemqty').css('background-color', '#FFFFFF');
            $('#tbstitemdetail2temp-stpackqty').css('background-color', '#FFFF99');
        
        var item_ids =  $('#vwst2detailgroup-stitempackid').val();
        $.get(
                        'index.php?r=Inventory/tb-st2-temp/select-pack',
                        {
                        item_ids:item_ids   
                        },
                function (data)
                {
                    $('#ItemPackSKUQty').val(data);
        var tbstitemdetail2tempstpackqty = $('#tbstitemdetail2temp-stpackqty').val().replace(/[,]/g, "");
        var ItemPackSKUQty = $('#ItemPackSKUQty').val().replace(/[,]/g, "");
        var sumpack = tbstitemdetail2tempstpackqty*ItemPackSKUQty;
        $('#tbstitemdetail2temp-stitemqty').val(addCommas(sumpack.toFixed(2)));
        var vwst2lotnumberavalibleitemunitcost = $('#vwst2lotnumberavalible-itemunitcost').val().replace(/[,]/g, "");
       var sumqty =  sumpack * vwst2lotnumberavalibleitemunitcost;
        $('#vwgr2lotassigneddetail-extencost').val(addCommas(sumqty.toFixed(2)));
        
                }
                );
        });
        
         
    //<--- บันทึกข้อมูล --->  
$('#st2_item_save').on('beforeSubmit', function(e)
    {
       if($("#pack1").is(':checked')){
          if($('#tbstitemdetail2temp-stpackqty').val()< 1){
              swal("", "กรุณาใส่จำนวนแพค", "warning"); 
              return false;
             }else{
        
          var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
      
              $('#editlotselect_').modal('hide');
              swal("Save Complete!", "", "success");
             $.pjax.reload({container: '#sr2_detail_'});
   l.ladda('stop');
          }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
         }
      }else if($("#pack2").is(':checked')){
        if($('#tbstitemdetail2temp-stitemqty').val() < 1){
            swal("", "กรุณาใส่จำนวนขอเบิก", "warning"); 
              return false;
         }else{
                    var l = $('.ladda-button').ladda();
   l.ladda('start');
         var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
              $('#editlotselect_').modal('hide');
            swal("Save Complete!", "", "success");
             $.pjax.reload({container: '#sr2_detail_'});

   l.ladda('stop');
          }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
      }
     }                
                    
    });      
});
   //<--- บันทึกข้อมูล --->  
JS;
            $this->registerJs($script);
            ?>