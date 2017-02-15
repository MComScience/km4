
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\Select2;

$layout = <<< HTML
{items}
HTML;

$script = <<< JS

/* Save */
$('#formcreditprice').on('beforeSubmit', function (e)
{
    var form = $(this);
    var l = $('.ladda-button').ladda();
    l.ladda('start');
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                if (result == 'success')
                {
                    swal({
                        title: "",
                        text: "Save Complete!",
                        type: "success",
                        showCancelButton: false,
                        closeOnConfirm: true,
                        closeOnCancel: true,
                    },
                            function (isConfirm) {
                                if (isConfirm) {
                                    l.ladda('stop');
                                    $.pjax.reload({container: '#tb_item_pjax_pricelisttpu'});
                                }
                            });
                    //$.pjax.reload({container: '#credit_pjax_id'});
                }
            })
            .fail(function ()
            {
                console.log('server error');
            });
    return false;
});

$('input[type="price"]').keyup(function () {
    $('input[type="price"]').priceFormat({prefix: ''});
});

$(document).ready(function () {
    $('input[type="textprice"]').keyup(function () {
        $('input[type="textprice"]').priceFormat({prefix: ''});
    });
});
JS;
$this->registerJs($script);
?>

<?php
$form1 = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formcreditprice', 'options' => ['data-pjax' => true]]);
$attribs = $model->formAttribs;
?>
<div class="form-group">
    <?= Html::activeLabel($model1, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-2 control-label no-padding-right ']) ?>
    <div class="col-sm-2">
        <?= $form1->field($model1, 'ItemID', ['showLabels' => false])->textInput(['style' => 'background-color:#f9f9f9', 'readonly' => true]); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($model1, 'ItemName', ['label' => 'รายละเอียด', 'class' => 'col-sm-2 control-label no-padding-right ']) ?>
    <div class="col-sm-8">
        <?= $form1->field($model1, 'ItemName', ['showLabels' => false])->textarea(['rows' => 3, 'style' => 'background-color:#f9f9f9', 'readonly' => true]); ?>
    </div>
</div>

<div class="form-group">
    <?= Html::activeLabel($model1, 'ItemPrice', ['label' => 'ราคาขาย(บาท)', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?=
        $form1->field($model1, 'ItemPrice', ['showLabels' => false])->textInput([
            'style' => 'text-align:right;background-color:#ffff99',
            'type' => 'textprice',
            'value' => number_format($model1->ItemPrice, 2)
        ]);
        ?>
    </div>
    <div class="col-sm-2">
        <a class="btn btn-success" onclick="GetAllPrice(this);">เบิกได้ทุกสิทธิ์</a>
    </div>
</div>
<?php \yii\widgets\Pjax::begin([ 'id' => 'credit_pjax_id']); ?>
<div class="form-group">
    <div class="col-md-8 col-md-offset-2">
        <?php // echo $htl_checkbox;  ?>
        <?php // echo $htl_checkbox1; ?>
    </div>  
</div>

<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-8"> 
        <?=
        kartik\builder\TabularForm::widget([
            'dataProvider' => $dataProvider,
            'form' => $form1,
//            'checkboxColumn' => [
//                'class' => '\kartik\grid\CheckboxColumn',
//                'contentOptions' => ['class' => 'kv-row-select'],
//                'headerOptions' => ['class' => 'kv-all-select'],
//            ],
            'attributes' => $attribs,
            'rowSelectedClass' => GridView::TYPE_SUCCESS,
            'checkboxColumn' => false,
            'gridSettings' => [
                'bootstrap' => true,
                'responsive' => false,
                'condensed' => true,
                'layout' => $layout,
                'responsiveWrap' => true,
                'hover' => true,
                //'striped' => true,
                'rowOptions' => ['style' => 'background-color: #f9f9f9'],
                'headerRowOptions' => ['style' => 'background-color: #ddd;color:black;'],
            // 'floatHeader' => true,
//                'panel' => [
//                    'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Manage Books</h3>',
//                    'type' => GridView::TYPE_SUCCESS,
//                    'footer' => false,
//                    'after' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add New', '#', ['class' => 'btn btn-success']) . ' ' .
//                    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class' => 'btn btn-danger']) . ' ' .
//                    Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
//                ]
            ],
            'actionColumn' => false,
            //'serialColumn' => false
            'serialColumn' => [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '20px',
                'header' => '',
                'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:black;']
            ],
        ]);
        ?>  
    </div>
</div>
<?php \yii\widgets\Pjax::end() ?>
<p></p>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-8" style="text-align: right">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
        <?=
        /* Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class' => 'btn btn-danger']) . ' ' . */
        Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary ladda-button','data-style' => 'expand-left'])
        ?>
    </div>
</div>

<?php
ActiveForm::end();
?>
<script>
function GetAllPrice(){
    var itemprice = $("#vwitempricelistscl-itemprice").val();
    $('input[type="textprice"]').val(itemprice);
}
</script>
