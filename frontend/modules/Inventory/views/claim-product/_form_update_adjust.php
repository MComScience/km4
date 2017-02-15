<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
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
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="well">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_update_adjust']); ?>
                
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">รหัสสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $Item['ItemID'],
                            ])
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">คลังสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelstk, 'STIssue_StkID', ['showLabels' => false])->textInput([
                                'style' => 'background-color: white;',
                                'value' => $stkid,
                                'readonly' => true,
                            ])
                            ?>
                        </div>
                </div>
                    
                    
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">รายการสินค้า</label>
                        <div class="col-sm-10">
                           <?=
                            $form->field($modeledit, 'ItemDetail', ['showLabels' => false])->textarea([
                                'rows' => 3,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $ItemDetail,
                            ])
                            ?>
                        </div> 
                    </div>
                    <br>
                    <div class="form-group">
                                    <?=
                                    kartik\grid\GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        //'filterModel' => $searchModel,
                                        'bootstrap' => true,
                                        'responsiveWrap' => FALSE,
                                        'responsive' => true,
                                        'showPageSummary' => true,
                                        'hover' => true,
                                        'pjax' => true,
                                        'striped' => true,
                                        'condensed' => true,
                                        'toggleData' => false,
                                        'pageSummaryRowOptions' => ['class' => 'default'],
                                        'layout' => Yii::$app->componentdate->layoutgridview(),
                                        //'layout' => "\n{items}\n{pager}",
                                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'attribute' => 'ItemInternalLotNum',
                                                'header' => 'ItemInternalLotNum',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'attribute' => 'ItemExternalLotNum',
                                                'header' => 'หมายเลขการผลิต',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'attribute' => 'ItemExpdate',
                                                'format' => ['date', 'php:d/m/Y'],
                                                'header' => 'วันหมดอายุ',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            ],
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center'],
                                            //     'attribute' => 'PackQTY',
                                            //     'header' => '<a>จำนวนแพค</a>',
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            //     'value' => function ($model) {
                                            //         if ($model->PackQTY == NULL) {
                                            //             return '-';
                                            //         } else {

                                            //             return $model->PackQTY;

                                            //         }   
                                            //     }
                                                
                                            // ],
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center'],
                                            //     'attribute' => 'PackItemUnitCost',
                                            //     'header' => '<a>ราคา/แพค</a>',
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                
                                            // ],
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center'],
                                            //     'attribute' => 'PackUnit',
                                            //     'header' => '<a>หน่วยแพค</a>',
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            //     'value' => function ($model) {
                                            //         if ($model->PackUnit == NULL) {
                                            //             return '-';
                                            //         } else {

                                            //             return $model->PackUnit;

                                            //         }   
                                            //     }
                                            // ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'attribute' => 'ItemQty',
                                                'header' => 'จำนวน',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'attribute' => 'DispUnit',
                                                'header' => 'หน่วย',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'attribute' => 'ItemUnitCost',
                                                'header' => 'ราคา/หน่วย',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                
                                            ],
                                            ],
                                        ])
                                ?>
                </div>              
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <br>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right"></label>
                        <div class="col-sm-8">
                            <div class="radio">
                            <label><input type="radio" name="แพค" id="แพค" value="yes"/> <span class="text">แพค  </span></label>
                            <label><input type="radio" name="แพค" id="ชิ้น" value="no"/> <span class="text">ชิ้น  </span></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">จำนวนแพค<a id="checkจำนวนแพค"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'STPackQty', ['showLabels' => false])->textInput([
                                'value' => number_format($STPackQty, 2),
                                'style' => 'background-color: white;text-align:right',
                            
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">หน่วยแพค<a id="checkหน่วยแพค"></a></label>
                        <div class="col-sm-8">
                            <?=
                                $form->field($modelST, 'STPackUnit', ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                                        'language' => 'en',
                                        'pluginOptions' => [
                                            'placeholder' => 'Select Option',
                                            'allowClear' => true,
                                        //'disabled' => true
                                        ],
                                    ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">ปริมาณบรรจุต่อแพค</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'ItemPackSKUQty', ['showLabels' => false])->textInput([
                                'value' => number_format($ItemPackSKUQty, 2),
                                'style' => 'background-color: white;text-align:right',
                                'readonly' => true,
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">ราคาต่อแพค<a id="checkราคาต่อแพค"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'STPackUnitCost', ['showLabels' => false])->textInput([
                                'value' => number_format($STPackUnitCost, 2),
                                'style' => 'background-color: white;text-align:right',
                                'readonly' => true,
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">จำนวน<a id="checkจำนวน"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'STItemQty', ['showLabels' => false])->textInput([
                                 'value' => number_format($STItemQty, 2),
                                'style' => 'background-color: white;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">หน่วย</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'DispUnit', ['showLabels' => false])->textInput([
                                'value' => $DispUnit,
                                'readonly' => true,
                                'style' => 'background-color: white;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">ราคาต่อหน่วย<a id="checkราคาต่อหน่วย"></a></label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'STItemUnitCost', ['showLabels' => false])->textInput([
                                 'value' => number_format($STItemUnitCost, 2),
                                'style' => 'background-color: white;text-align:right',
                                'readonly' => true,
                            ])
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">รวมเป็นเงิน</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelST, 'STExtenedCost', ['showLabels' => false])->textInput([
                                'value' => number_format($STExtenedCost, 2),
                                'style' => 'background-color: white;text-align:right',
                            ])
                            ?>
                        </div>
                    </div>
                    
                </div>
                <div class="col-md-12">
                    <br>
                    <div class="form-group" style="text-align: right">
                        <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                         <a class="btn btn-danger" id="Clear">Clear</a>
                         <button class="btn btn-success" type="submit">Save</button>
                    </div>
                </div>
            </div>
            <input type="hidden" id="getpackunit" value="<?php echo $findpack['ItemPackUnit']; ?>"/>
            <input type="hidden" id="checklot" value="<?php echo $checklot; ?>"/>
            <input type="hidden" id="checkpacklot" value="<?php echo $checkpacklot; ?>"/>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS
$(document).ready(function () {
        var chechpackunit = $('#getpackunit').val();
        // var checkpacklot = $('#checkpacklot').val();
        $("#vwst2detailsub-stpackunit").val(chechpackunit).trigger("change");
        var CheckPack = $("#vwst2detailsub-stpackqty").val();
        if (CheckPack == "" || CheckPack == "0.00") {
            document.getElementById("ชิ้น").checked = true;
            if ($("input[id=ชิ้น]").is(":checked"))
            {
                $('#checkจำนวน').html('<font color="red">*</font>');
                $("#vwst2detailsub-stpackqty").attr('readonly', 'readonly');
                //$("#vwst2detailsub-stpackunit").attr('disabled', 'disabled');
                $("#vwst2detailsub-stitemqty").removeAttr('readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
                $('#vwst2detailsub-stitemqty').css('background-color', '#FFFF99');
                $('#vwst2detailsub-stpackqty,#vwst2detailsub-stpackunitcost').css('background-color', 'white');
            }
        } else {
            document.getElementById("แพค").checked = true;
            if ($("input[id=แพค]").is(":checked"))
            {
                $("#vwst2detailsub-stpackqty").removeAttr('readonly');
                //$("#vwst2detailsub-stpackunit").removeAttr('disabled');
                $("#vwst2detailsub-stitemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color="red">*</font>');
                $('#checkขอซื้อ').html('');
                $('#vwst2detailsub-stpackqty').css('background-color', '#FFFF99');
                $('#vwst2detailsub-stitemqty').css('background-color', 'white');
            }
        }
        // if (checkpacklot == 'no') {
        //     document.getElementById("ชิ้น").checked = true;
        //     if ($("input[id=ชิ้น]").is(":checked"))
        //     {
        //         $('#checkจำนวน').html('<font color="red">*</font>');
        //         $("#vwst2detailsub-stpackqty").attr('readonly', 'readonly');
        //         //$("#vwst2detailsub-stpackunit").attr('disabled', 'disabled');
        //         $("#vwst2detailsub-stitemqty").removeAttr('readonly');
        //         $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
        //         $('#vwst2detailsub-stitemqty').css('background-color', '#FFFF99');
        //         $('#vwst2detailsub-stpackqty,#vwst2detailsub-stpackunitcost').css('background-color', 'white');
        //     }
        // } else if(checkpacklot == 'yes'){
        //     document.getElementById("แพค").checked = true;
        //     if ($("input[id=แพค]").is(":checked"))
        //     {
        //         $("#vwst2detailsub-stpackqty").removeAttr('readonly');
        //         //$("#vwst2detailsub-stpackunit").removeAttr('disabled');
        //         $("#vwst2detailsub-stitemqty").attr('readonly', 'readonly');
        //         $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color="red">*</font>');
        //         $('#checkขอซื้อ').html('');
        //         $('#vwst2detailsub-stpackqty').css('background-color', '#FFFF99');
        //         $('#vwst2detailsub-stitemqty').css('background-color', 'white');
        //     }
        // }
    });
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
                $("#vwst2detailsub-stpackqty").removeAttr('readonly');
                //$("#vwst2detailsub-stpackunit").removeAttr('disabled');
                $("#vwst2detailsub-stitemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color="red">*</font>');
                $('#checkขอซื้อ').html('');
                $('#vwst2detailsub-stpackqty').css('background-color', '#FFFF99');
                $('#vwst2detailsub-stitemqty').css('background-color', 'white');
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
                $('#checkจำนวน').html('<font color="red">*</font>');
                $("#vwst2detailsub-stpackqty").attr('readonly', 'readonly');
                $("#vwst2detailsub-stpackunit").val('').trigger("change");
                $("#vwst2detailsub-stitemqty").removeAttr('readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
                $("#vwst2detailsub-stpackqty").val('0.00');
                $('#vwst2detailsub-stitemqty').css('background-color', '#FFFF99');
                $('#vwst2detailsub-stpackqty,#vwst2detailsub-stpackunitcost').css('background-color', 'white');
        }
    });
    //คำนวณจำนวนแพค
    $("#vwst2detailsub-stpackqty").keyup(function () {
        $('#vwst2detailsub-stpackqty').autoNumeric('init');
        //var packunitcost = parseFloat($("#vwgr2detail-grpackunitcost").val().replace(/[,]/g, ""));
        var uni = parseFloat($("#vwst2detailsub-stpackqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwst2detailsub-itempackskuqty").val().replace(/[,]/g, ""));
        var grunitcost = parseFloat($("#vwst2detailsub-stitemunitcost").val().replace(/[,]/g, ""));
        var checkpacklot = $("#checkpacklot").val();
        var checklot = parseFloat($("#checklot").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        var Total = jj * grunitcost;
        //var unitcost = packunitcost / orq;
        if (orq == "0" || orq == "0.00" ) {
            $("#vwst2detailsub-stitemqty").val(addCommas(uni.toFixed(2)));
            var unitlot = parseFloat($("#vwst2detailsub-stitemqty").val().replace(/[,]/g, ""));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
            //$("#vwgr2detail-gritemunitcost").val(addCommas(unitcost.toFixed(2)));
            $("#vwst2detailsub-stitemqty").val(addCommas(jj.toFixed(2)));
            $("#vwst2detailsub-stextenedcost").val(addCommas(Total.toFixed(2)));
            var unitlot = parseFloat($("#vwst2detailsub-stitemqty").val().replace(/[,]/g, ""));
        }
        if(checkpacklot == 'edit'){
            if (unitlot>checklot){
               swal("ใส่เกินจำนวนที่มีอยู่ในสต็อก","","warning");
                $('#vwst2detailsub-stpackqty').val('0.00');
                $('#vwst2detailsub-stitemqty').val('0.00');
                $('#vwst2detailsub-stextenedcost').val('0.00');
            }
        }
        if(checkpacklot == 'no'){
            if (unitlot>checklot){
               swal("ใส่เกินจำนวนที่มีอยู่ในสต็อก","","warning");
                $('#vwst2detailsub-stpackqty').val('0.00');
                $('#vwst2detailsub-stitemqty').val('0.00');
                $('#vwst2detailsub-stextenedcost').val('0.00');
            }
        }
    });
    //คำนวนหน่วยแพค
    $('#vwst2detailsub-stpackunit').on('change', function () {
            var ItemID = $("#vwst2detailgroup-itemid").val();
            var ItemPackUnit = $(this).find("option:selected").val();
            var qty = parseFloat($("#vwst2detailsub-stpackqty").val().replace(/[,]/g, ""));
             $.ajax({
                url: "get-qty",
                type: "post",
                data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
                dataType: 'json',
                success: function (data) {
                    $('#vwst2detailsub-itempackskuqty').val(data.ItemPackSKUQty);
                    var STUnitCost = parseFloat($("#vwst2detailsub-stitemunitcost").val().replace(/[,]/g, ""));
                    var packunitcost = parseFloat($("#vwst2detailsub-stpackunitcost").val().replace(/[,]/g, ""));
                    var SKUQty = parseFloat($("#vwst2detailsub-itempackskuqty").val().replace(/[,]/g, ""));
                    var jj = (SKUQty) * (qty);
                    //var Total = jj * STUnitCost;
                    var unitcost = packunitcost / SKUQty;
                    if (data.qty == 0) {
                        $('#vwst2detailsub-stitemqty').val('0.00');
                    } else {
                        $("#vwst2detailsub-stitemqty").val(addCommas(jj.toFixed(2)));
                        $("#vwst2detailsub-stitemunitcost").val(addCommas(unitcost.toFixed(2)));
                        var itemunitcost = parseFloat($("#vwst2detailsub-stitemunitcost").val().replace(/[,]/g, ""));
                        var Total = jj * itemunitcost;
                        $("#vwst2detailsub-stextenedcost").val(addCommas(Total.toFixed(2)));
                    }
                }
            });
        });
    //คำนวณราคาต่อแพค
    $("#vwst2detailsub-stpackunitcost").keyup(function () {
       $('#vwst2detailsub-stpackunitcost').autoNumeric('init');
        var qty = $("#vwst2detailsub-stitemqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwst2detailsub-stpackunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwst2detailsub-itempackskuqty").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwst2detailsub-stextenedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            //orq = orq.toFixed(2);
            $("#vwst2detailsub-stitemunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwst2detailsub-stitemunitcost").val('0.00');
        }
    });
    //คำนวณจำนวน
    $("#vwst2detailsub-stitemqty").keyup(function () {
        $('#vwst2detailsub-stitemqty').autoNumeric('init');
        var uni = parseFloat($("#vwst2detailsub-stitemqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwst2detailsub-stitemunitcost").val().replace(/[,]/g, ""));
        var checkpacklot = $("#checkpacklot").val();
        var checklot = parseFloat($("#checklot").val().replace(/[,]/g, ""));
         var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwst2detailsub-stextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwst2detailsub-stextenedcost").val('0.00');
        }
        if(checkpacklot == 'edit'){
            if (uni>checklot){
               swal("ใส่เกินจำนวนที่มีอยู่ในสต็อก","","warning");
                $('#vwst2detailsub-stitemqty').val('0.00');
                $('#vwst2detailsub-stextenedcost').val('0.00');
            }
        }
        if(checkpacklot == 'no'){
            if (uni>checklot){
               swal("ใส่เกินจำนวนที่มีอยู่ในสต็อก","","warning");
                $('#vwst2detailsub-stitemqty').val('0.00');
                $('#vwst2detailsub-stextenedcost').val('0.00');
            }
        }
    });
    //คำนวณราคาต่อหน่วย
    $("#vwst2detailsub-stitemunitcost").keyup(function () {
        $('#vwst2detailsub-stitemunitcost').autoNumeric('init');
        var uni = parseFloat($("#vwst2detailsub-stitemunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwst2detailsub-stitemqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwst2detailsub-stextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwst2detailsub-stextenedcost").val('0.00');
        }
    });
$('#form_update_adjust').on('beforeSubmit', function(e)
    {
    wait();
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 1)
            {
            $(\$form).trigger("reset");
                    $.pjax.reload({container:'#st_detail'});
                    $('#modaledit').modal('hide');
                    $('#getdatavendor').modal('hide');
                    $('#form_update_adjust').trigger("reset");
                   $('#form_update_adjust').waitMe('hide');
                   swal("Save","", "success");
            } else
            {
            $("#message").html(result);
            }
            })
            .fail(function()
            {
            console.log("server error");
            });
            return false;
    });
    function wait(){
                var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                $('#form_update_adjust').waitMe({
                effect: 'ios',
                text: 'กำลังโหลดข้อมูล...',
                bg: 'rgba(255,255,255,0.7)',
                color: '#000',
                sizeW: '',
                sizeH: '',
                source: '',
                onClose: function () {}
                });
                }
             }
JS;
$this->registerJs($script);
?>