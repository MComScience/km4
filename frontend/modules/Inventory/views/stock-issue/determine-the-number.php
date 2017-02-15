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
    <?= Html::activeLabel($model, 'ItemID', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'ItemID', ['showLabels' => false])->textInput(['readonly' => true]); ?>
    </div>
    <input type="hidden" id="itempackid" value="<?php echo!empty($model->SRItemPackIDApprove) ? $model->SRItemPackIDApprove : '' ?>"/>
    <label class="col-sm-2 control-label">คลังสินค้า</label>
    <div class="col-sm-2">
        <input type="hidden" name="stkid" class="form-control" readonly  value="<?php $stkmodel->StkID ?>"/>
        <input type="text"  class="form-control" readonly  value="<?php echo $stkmodel->StkName ?>"/>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'ItemName')->textarea(['maxlength' => true, 'row' => 30, 'readonly' => true]) ?>
    </div>
    <?= Html::activeLabel($model, 'SRQty', ['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'SRQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>
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
                    'attribute' => 'ItemInternalLotNum',
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'headerOptions' => ['style' => 'text-align:center'],
                    'attribute' => 'ItemExternalLotNum',
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'headerOptions' => ['style' => 'text-align:center'],
                    'attribute' => 'ItemExpdate',
                    'hAlign' => GridView::ALIGN_RIGHT,
                    'format' => ['date', 'php:d/m/Y'],
                ],
                [
                    'attribute' => 'PackQTY',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'attribute' => 'PackItemUnitCost',
                    'format' => ['decimal', 2],
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_RIGHT
                ],
                [
                    'attribute' => 'PackUnit',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                if ($model->PackUnit == NULL) {
                    return '-';
                } else {
                    return $model->PackUnit;
                }
            }
                ],
                [
                    'attribute' => 'ItemQty',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'attribute' => 'DispUnit',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                    'value' => function ($model) {
                if ($model->DispUnit == NULL) {
                    return '-';
                } else {
                    return $model->DispUnit;
                }
            }
                ],
                [
                    'attribute' => 'ItemUnitCost',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
            ],
        ]);
        ?>

    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-inline">
                <?= Html::activeLabel($balence, 'SRQty', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($balence, 'SRQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
            </div>
            <div class="form-inline">
                <?= Html::activeLabel($balence, 'STSelectedQty', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($balence, 'STSelectedQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
            </div>
            <div class="form-inline">
                <?= Html::activeLabel($balence, 'STLeftQty', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($balence, 'STLeftQty', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
            </div>
            <div class="form-inline">
                <?= Html::activeLabel($balence, 'STUnit', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($balence, 'STUnit', ['showLabels' => false])->textInput(['readonly' => true]); ?>  
            </div>
        </div>
        <div class="col-sm-6">
            <div style="margin-left: 150px">
                เลือกแบบ  <input type="radio" id="pack1" value="2" name="pack"/> แพค <input value="1" type="radio" id="pack2" name="pack"/> ชิ้น
            </div>
            <br>
            <div class="form-inline">
                <?= Html::activeLabel($stdata, 'STPackQty', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($stdata, 'STPackQty', ['showLabels' => false])->textInput(['style' => 'text-align:right', 'value' => '0.00']); ?>  
            </div>
            <div class="form-inline">
                <?php echo Html::activeLabel($stdata, 'STItemPackID', ['class' => 'col-sm-5 control-label']) ?>
                <?php
                echo $form->field($model, 'STItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
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
            <div class="form-inline" >
                <label class="col-sm-5 control-label">ปริมาณ/แพค</label>
                <div class="form-group field-tbstitemdetail2temp-stpackunitcost">
                    <div class="col-md-12">
                        <input type="text" class="form-control" readonly="" id="ItemPackSKUQty" name="ItemPackSKUQty" style="background-color: white;text-align: right"  
                               value="<?php echo $packsize ?>"/>
                    </div>
                    <div class="col-md-12"></div>
                    <div class="col-md-12"><div class="help-block"></div></div>
                </div>

            </div>
            <div class="form-inline">
                <?= Html::activeLabel($innernallot, 'PackItemUnitCost', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($innernallot, 'PackItemUnitCost', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>  
            </div>
            <div class="form-inline">
                <?= Html::activeLabel($stdata, 'STItemQty', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($stdata, 'STItemQty', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>  
            </div>

            <div class="form-inline">
                <?= Html::activeLabel($model, 'DispUnit', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($model, 'DispUnit', ['showLabels' => false])->textInput(['style' => 'text-align:right', 'readonly' => true]); ?>  
            </div>
            <div class="form-inline">
                <?= Html::activeLabel($innernallot, 'ItemUnitCost', ['class' => 'col-sm-5 control-label']) ?>
                <?= $form->field($innernallot, 'ItemUnitCost', ['showLabels' => false])->textInput(['style' => 'text-align:right', 'readonly' => true]); ?>  
            </div>
            <div class="form-inline">
                <label class="col-sm-5 control-label">รวมเป็นเงิน</label>
                <input readonly="" id="vwgr2lotassigneddetail-extencost" class="form-control" value="0.00" style="background-color: white;text-align: right"/>
            </div>
            <br>
            <br>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="reset" class="btn btn-danger" >Clear</button>
        <button type="submit" class="btn btn-success">Save</button>
    </div>
    <?php ActiveForm::end(); ?>

<?php } ?>
<?php
$script = <<< JS
$(document).ready(function () {
    //begin<-------------   เช็คว่ามีแพคไหม  ----->
       var itempackid = $('#itempackid').val();
        if(itempackid != ""){
          $('#tbstitemdetail2temp-stpackqty').css('background-color', '#FFFF99');
          $('#pack2').removeAttr('checked', 'checked');
          $('#pack1').attr('checked', 'checked');
          $('#tbstitemdetail2temp-stitemqty,#tbstitemdetail2temp-stpackunitcost').attr('readonly', 'readonly');
       }
         //end<-------------   เช็คว่ามีแพคไหม  ----->
        // <-- คำนวนแพค -->
    $('#tbstitemdetail2temp-stpackqty').priceFormat({prefix: ''});
    $("#tbstitemdetail2temp-stpackqty").keyup(function () {
        var stpackqty = parseFloat($("#tbstitemdetail2temp-stpackqty").val().replace(/[,]/g, ""));
        var vwst2srbalancestleftqty = parseFloat($("#vwst2srbalance-stleftqty").val().replace(/[,]/g, ""));
        var ItemPackSKUQty = parseFloat($("#ItemPackSKUQty").val().replace(/[,]/g, ""));
        if(stpackqty > vwst2srbalancestleftqty){
             alert('คุณใส่เกินจำนวน');
        
        $("#tbstitemdetail2temp-stpackqty").val(addCommas(vwst2srbalancestleftqty.toFixed(2)));
        var packqty = parseFloat($("#tbstitemdetail2temp-stpackqty").val().replace(/[,]/g, ""));
        $("#tbstitemdetail2temp-stitemqty").val(packqty);
         var sumpackqtyitemsku = packqty * ItemPackSKUQty;
         $("#tbstitemdetail2temp-stitemqty").val(addCommas(sumpackqtyitemsku.toFixed(2)));
        
        var  tbstitemdetail2tempstitemunitcost =  parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
        var  sum = sumpackqtyitemsku.toFixed(2) * tbstitemdetail2tempstitemunitcost;
        $("#vwgr2lotassigneddetail-extencost").val(addCommas(sum.toFixed(2)));

    }
        else{
       
        var sumstpackqtyItemPackSKUQty = stpackqty * ItemPackSKUQty;
         $("#tbstitemdetail2temp-stitemqty").val(addCommas(sumstpackqtyItemPackSKUQty.toFixed(2)));
         var tbstitemdetail2tempstitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
         var sumprice = sumstpackqtyItemPackSKUQty * tbstitemdetail2tempstitemunitcost;
        $("#vwgr2lotassigneddetail-extencost").val(addCommas(sumprice.toFixed(2)));
        }
        
   });    
         // <-- คำนวนแพค -->
             
 $("#vwst2detailgroup-stitempackid").val($('#itempackid').val()).trigger("change");
        
    var packunit =   $('#vwst2detailgroup-stitempackid').val();
  if(packunit == ""){
   // $('#pack1').attr( 'disabled', true );
        document.getElementById("pack2").checked = true;
    $("#tbstitemdetail2temp-stpackqty,#tbstitemdetail2temp-stpackunitcost").attr('readonly', 'readonly');
    $('#tbstitemdetail2temp-stitemqty,#tbstitemdetail2temp-stitemunitcost').css('background-color', '#FFFF99');
    $('#tbstitemdetail2temp-stpackqty,#tbstitemdetail2temp-stpackunitcost,#vwgr2lotassigneddetail-extencost').val('0.00');
   }
        
        
    if($('#tbstitemdetail2temp-stitemqty').val() == ""){
        $('#tbstitemdetail2temp-stitemqty').val('0.00');
    }
      if($('#tbstitemdetail2temp-stitemunitcost').val() == ""){
        $('#tbstitemdetail2temp-stitemunitcost').val('0.00');
    }  
        
    $('input[id="tbstitemdetail2temp-stitemqty"]').priceFormat({prefix: ''});
    $('input[id="tbstitemdetail2temp-stitemunitcost"]').priceFormat({prefix: ''});
        
//คำนวณราคาต่อหน่วย
    $("#tbstitemdetail2temp-stitemqty").keyup(function () {
        var uni = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
        var stlftqty = parseFloat($("#vwst2srbalance-stleftqty").val().replace(/[,]/g, ""));
        if(uni>stlftqty){
            alert('คุณใส่เกินจำนวน');
        $("#tbstitemdetail2temp-stitemqty").val(addCommas(stlftqty.toFixed(2)));
        var uni = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
        var stitemunitcost = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
        
       var sum = uni* stitemunitcost;
         $("#vwgr2lotassigneddetail-extencost").val(addCommas(sum.toFixed(2)));
        
        
   }else{
        $('input[id="vwgr2lotassigneddetail-extencost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwst2lotnumberavalible-itemunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwgr2lotassigneddetail-extencost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2lotassigneddetail-extencost").val('0.00');
        }
      }
    });
        
    $("#tbstitemdetail2temp-stitemunitcost").keyup(function () {
        var tbstitemdetail2tempstitemunitcost = parseFloat($("#tbstitemdetail2temp-stitemunitcost").val().replace(/[,]/g, ""));
        var tbstitemdetail2tempstitemqty = parseFloat($("#tbstitemdetail2temp-stitemqty").val().replace(/[,]/g, ""));
        var sum  = tbstitemdetail2tempstitemqty * tbstitemdetail2tempstitemunitcost;
        $('#vwgr2lotassigneddetail-extencost').val(addCommas(sum.toFixed(2)));
    });
        
         $('#st2_item_save').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result)
            {
      
              $('#lotselect_').modal('hide');
              $('#determinethenumber').modal('hide');
             Notify('Saved Successfully!', 'top-right', '2000', 'success', 'fa-check', false);
             $.pjax.reload({container: '#sr2_detail_'});
          }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });      
});
JS;
$this->registerJs($script);
?>
