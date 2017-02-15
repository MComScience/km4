<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
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
<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetail_s']);
?>
<?php echo $form->field($model, 'ids', ['showLabels' => false])->hiddenInput(); ?>
<?php echo $form->field($modeledit, 'ItemInternalLotNum', ['showLabels' => false])->hiddenInput(); ?>
<input type="hidden" name="SAID" value="<?php echo!empty($SAID) ? $SAID : '' ?>"/>
<div class="well">

    <input id="sritempackid" type="hidden" value="<?php
    if (!empty($sritempackid)) {
        echo $sritempackid;
    }
    ?>" name="sritempackid"/>
    <div class="form-group">
        <?php echo Html::activeLabel($modeledit, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-4">
            <?php echo $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <label class="col-sm-2 control-label" for="tbsaitemdetail2temp-itemid">คลังสินค้า</label>
        <div class="col-sm-3">
            <div class="form-group field-tbsaitemdetail2temp-itemid">
                <input type="hidden" id="stkid" name="stkid" value="<?php echo!empty($stk->StkID) ? $stk->StkID : '' ?>"/>
                <div class="col-md-12"><input type="text"  class="form-control" readonly value="<?php echo!empty($stk->StkName) ? $stk->StkName : '' ?>" ></div>
                <div class="col-md-12"></div>
                <div class="col-md-12"><div class="help-block"></div></div>
            </div>       
        </div>
    </div>
    <?php
    echo $form->field($modeledit, 'ItemName')->textarea([
        'rows' => 3,
        'readonly' => true,
        'style' => 'background-color:white',
    ])->label('รายการสินค้า')
    ?>
    <?php if (!empty($searchModel)) { ?>
        <?php \yii\widgets\Pjax::begin(['id' => 'form_adjitemp']) ?>
        <?php
        echo kartik\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'bootstrap' => true,
            // 'responsiveWrap' => FALSE,
            // 'responsive' => true,
            'hover' => true,
            'pjax' => true,
            'striped' => true,
            'condensed' => true,
            'toggleData' => false,
            'pageSummaryRowOptions' => ['class' => 'default'],
            'layout' => Yii::$app->componentdate->layoutgridview(),
            'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
            'columns' => [
                [
                    'header'=>'<font color="black">Internal</font>',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'attribute' => 'ItemInternalLotNum',
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                     'header'=>'<font color="black">หมายเลขการผลิต</font>',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'attribute' => 'ItemExternalLotNum',
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                       'header'=>'<font color="black">วันหมดอายุ</font>',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'attribute' => 'ItemExpdate',
                    'hAlign' => GridView::ALIGN_CENTER,
//                        'format' => ['date', 'php:d/m/Y'],
                ],
                [
                    'header'=>'<font color="black">จำนวนแพค</font>',
                    'attribute' => 'PackQTY',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                     'header'=>'<font color="black">ราคา/แพค</font>',
                    'attribute' => 'PackItemUnitCost',
                    'format' => ['decimal', 2],
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_RIGHT
                ],
                [
                     'header'=>'<font color="black">หน่วยแพค</font>',
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
                    'header'=>'<font color="black">จำนวน</font>',
                    'attribute' => 'ItemQty',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
                [
                    'header'=>'<font color="black">หน่วย</font>',
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
                    'header'=>'ราคาต่อหน่วย',
                    'attribute' => 'ItemUnitCost',
                    'headerOptions' => ['style' => 'text-align:center'],
                    'hAlign' => GridView::ALIGN_CENTER,
                ],
            ],
        ]);
        ?>
        <?php \yii\widgets\Pjax::end() ?>

    <?php } ?>
    <br>
    <br>
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="form-group">
    <?= Html::activeLabel($onhandata, 'ItemQty', ['label'=>'ยอดในคลัง', 'class'=>'col-sm-4 control-label']) ?>
    <div class="col-sm-7">
        <?= $form->field($onhandata, 'ItemQty',['showLabels'=>false])->textInput(['style' => 'text-align:right;', 'readonly' => true]); ?>
    </div>
   <?= Html::activeLabel($model, 'ActualLotItemQty', ['label'=>'นับได้<font color=red>*</font>', 'class'=>'col-sm-4 control-label']) ?>
    <div class="col-sm-7">
        <?= $form->field($model, 'ActualLotItemQty',['showLabels'=>false])->textInput(['style' => 'text-align:right;background-color: #FFFF99']); ?>
    </div>
       <?= Html::activeLabel($modeledit, 'DispUnit', ['label'=>'หน่วย', 'class'=>'col-sm-4 control-label']) ?>
    <div class="col-sm-7">
        <?= $form->field($modeledit, 'DispUnit',['showLabels'=>false])->textInput(['style' => 'text-align:right;', 'readonly' => true]); ?>
    </div>     
         <?= Html::activeLabel($model, 'AdjLotItemQty', ['label'=>'ส่วนต่าง', 'class'=>'col-sm-4 control-label']) ?>
    <div class="col-sm-7">
        <?= $form->field($model, 'AdjLotItemQty',['showLabels'=>false])->textInput(['style' => 'text-align:right;', 'readonly' => true]); ?>
    </div> 
           <?= Html::activeLabel($model, 'BalanceAdjLotItemQty', ['label'=>'ยอดหลังจากการปรับปรุง', 'class'=>'col-sm-4 control-label']) ?>
    <div class="col-sm-7">
        <?= $form->field($model, 'BalanceAdjLotItemQty',['showLabels'=>false])->textInput(['style' => 'text-align:right;', 'readonly' => true]); ?>
    </div> 
            <?php echo $form->field($model, 'SAItemNumStatus', ['showLabels' => false])->hiddenInput(); ?>
        </div>
    </div>
    <div style="text-align: right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', 'data-style' => "expand-left"]) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
    <?php
    $script = <<< JS

        
$(document).ready(function () {
 //<------------------  Actual ----------------->
            
         //$("#tbsaitemdetail2-actuallotitemqty").priceFormat({prefix: ''});
         $("#tbsaitemdetail2-actuallotitemqty").keyup(function () {
          $('#tbsaitemdetail2-actuallotitemqty').autoNumeric('init');  
          var tbsaitemdetail2actuallotitemqty = $('#tbsaitemdetail2-actuallotitemqty').val().replace(/[,]/g, "");
          var vwsalotnumberavalibleitemqty = $('#vwsalotnumberavalible-itemqty').val().replace(/[,]/g, "");
          var decrement =  tbsaitemdetail2actuallotitemqty-vwsalotnumberavalibleitemqty;
          $("#tbsaitemdetail2-adjlotitemqty").val(addCommas(decrement.toFixed(2)));
          var actual = $('#tbsaitemdetail2-actuallotitemqty').val();
          $("#tbsaitemdetail2-balanceadjlotitemqty").val(actual);
           
    });
        
          
   //On Save
 $('#formdetail_s').on('beforeSubmit', function(e)
    {
    var l = $('.ladda-button').ladda();
     l.ladda('start');          
    var \$form = $(this);
            $.post(
                    \$form.attr("action"), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {

          if (result == 1)
            {
                  $(\$form).trigger("reset");
                  $('#_item_list').modal('hide');
                  $('#save_detail').modal('hide');
                  $('#form_adjitem').modal('hide');
                  swal("Save Complete!", "", "success");
                  $.pjax.reload({container: '#sa_detail_'});
            l.ladda('stop');
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
                       
});
JS;
    $this->registerJs($script);
    ?>







