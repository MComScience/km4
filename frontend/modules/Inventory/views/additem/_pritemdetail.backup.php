
<?php

use kartik\widgets\ActiveForm;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\widgets\Select2;

//$modelcheck = \app\modules\Inventory\models\Tbmedicalrightgroup::find()->where(['medical_right_group_id' => $ids])->all();
//$htl_checkbox = '';
//foreach ($modelcheck as $rm) {
//    $htl_checkbox .= '<div class="col-sm-4"><div class="checkbox"><label><input class="colored-success" type="checkbox" checked="checked" name="PRReason' . $rm['medical_right_group'] . '" id="PRReason' . $rm['medical_right_group'] . '" value="' . $rm['medical_right_group_id'] . '" />';
//    $htl_checkbox .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['medical_right_group'] . '</span></label></div>';
//    $htl_checkbox .= '</div>';
//    $no++;
//}
//$htl_checkbox .= '';
//
//$htl_checkbox1 = '';
//foreach ($modelcheck1 as $rm) {
//    $htl_checkbox1 .= '<div class="col-sm-4"><div class="checkbox"><label><input class="colored-success" type="checkbox" name="PRReason' . $rm['medical_right_group'] . '" id="PRReason' . $rm['medical_right_group'] . '" value="' . $rm['medical_right_group_id'] . '"  data-toggle="checkbox-x"/>';
//    $htl_checkbox1 .= '' . $no . '.' . ' ' . '<span class="text">' . $rm['medical_right_group'] . '</span></label></div>';
//    $htl_checkbox1 .= '</div>';
//    $no++;
//}
//$htl_checkbox1 .= '';

$layout = <<< HTML
{items}
HTML;

$script = <<< JS

/* Save */
$('#formcreditprice').on('beforeSubmit', function (e)
{
    var form = $(this);
    $.post(
            form.attr('action'), // serialize Yii2 form
            form.serialize()
            )
            .done(function (result) {
                if (result == 'success')
                {
                    swal("Save Complete!", "", "success");
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

$(function () {
    /* var allVals = []; */

   // $("#datepicker").datepicker();/*  set Datepicker   */

    $('.colored-success').bind('click', function () {

        if ($(this).is(':checked')) {
            var id = $(this).val();
            InsertNewCredit(id);
            /* allVals.push($(this).val()); */
        } else {
            var id = $(this).val();
            var itemid = $("#vwitempricelistscl-itemid").val();
            swal({
                title: "สิทธิ์นี้จะถูกยกเลิก?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'index.php?r=Inventory/additem/un-credit',
                                    {
                                        id: id, itemid: itemid
                                    },
                            function (data)
                            {
                                $.pjax.reload({container: '#credit_pjax_id'});
                            }
                            );
                        }else{
                            $.pjax.reload({container: '#credit_pjax_id'});
                        }
                    });
        }
    });
});
        
function InsertNewCredit(id) {
    var itemid = $("#vwitempricelistscl-itemid").val();
    swal({
        title: "ยืนยัน?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'index.php?r=Inventory/additem/addcredit-price',
                            {
                                id: id, itemid: itemid
                            },
                    function (data)
                    {
                        if (data == 'duplicate') {
                            swal("สิทธิ์นี้มีข้อมูลเดิมอยู่แล้ว!", "", "warning");
                            $.pjax.reload({container: '#credit_pjax_id'});
                        } else {
                            $.pjax.reload({container: '#credit_pjax_id'});
                        }
                    }
                    );
                }else{
                    $.pjax.reload({container: '#credit_pjax_id'});
                }
                
            });
}
/*        
$("#DeleteOnSelect").click(function (e) {
    var selected = [];
    selected.push($('#w0').yiiGridView('getSelectedRows'));
    if (selected != null) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=Inventory/additem/deletecredit-onselect',
                                {
                                    id: selected
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#credit_pjax_id'});
                        }
                        );
                    }else{
                        $.pjax.reload({container: '#credit_pjax_id'});
                    }
                });

    } else {
        swal("ยังไม่ได้เลือกรายการใด!", "", "warning");
    }
});
        */
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
    <?= Html::activeLabel($model1, 'ItemPrice', ['label' => 'ราคาขาย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
    <div class="col-sm-2">
        <?=
        $form1->field($model1, 'ItemPrice', ['showLabels' => false])->textInput([
            'style' => 'text-align:right;background-color:#ffff99',
            'type' => 'textprice',
            'value' => number_format($model1->ItemPrice, 2)
        ]);
        ?>
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
    <div class="col-sm-3">
<!--        <a class="btn btn-danger" id="DeleteOnSelect"><i class="glyphicon glyphicon-remove"></i> Delete</a>-->
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
        <?=
        /* Html::a('<i class="glyphicon glyphicon-remove"></i> Delete', '#', ['class' => 'btn btn-danger']) . ' ' . */
        Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class' => 'btn btn-primary'])
        ?>
    </div>
</div>

<?php
ActiveForm::end();
?>


<?php /*
  <?php
  $form2 = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]);
  ?>
  <div class="form-group">
  <?= Html::activeLabel($model, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-2 control-label']) ?>
  <div class="col-sm-2">
  <?= $form2->field($model, 'ItemID', ['showLabels' => false])->textInput(); ?>
  </div>
  </div>
  <div class="form-group">
  <label class="col-sm-2 control-label">รายละเอียด</label>
  <div class="col-sm-6">
  <textarea class="form-control" rows="3"></textarea>
  </div>
  </div>
  <div class="form-group">
  <?= Html::activeLabel($model1, 'ItemPrice', ['label' => 'ราคาขาย', 'class' => 'col-sm-2 control-label']) ?>
  <div class="col-sm-2">
  <?= $form2->field($model1, 'ItemPrice', ['showLabels' => false])->textInput(['style' => 'text-align:right']); ?>
  </div>
  <a class="btn btn-success">เบิกได้ทุกสิทธิ์</a>
  </div>
  <?=
  $form2->field($model, 'cr_effectiveDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
  'language' => 'th',
  'dateFormat' => 'dd/MM/yyyy',
  'clientOptions' => [
  'changeMonth' => true,
  'changeYear' => true,
  ],
  'options' => [
  'class' => 'form-control',
  'style' => 'background-color: #ffff99',
  'type' => 'hidden'
  ],
  ])
  ?>
  <div class="form-group">
  <label class="col-sm-2 control-label"></label>
  <div class="col-sm-6">
  <table class="kv-grid-table table table-hover kv-table-wrap kv-table-float" cellspacing="0" width="100%" >
  <thead>
  <tr>
  <th style="text-align: center;color:black;background-color: #ddd" widht="36px">#ID</th>
  <th style="text-align: center;color:black;background-color: #ddd" widht="36px">ประเภทสิทธิ</th>
  <th  style="text-align: center;color:black;background-color: #ddd">เบิกได้ตามสิทธิการรักษา</th>
  <th  style="text-align: center;color:black;background-color: #ddd">วันที่เริ่มใช้</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($medical as $data): ?>
  <tr>
  <td style="text-align: center;color:black;"><?php echo $id; ?></td>
  <td style="text-align: left;color:black;">
  <?php
  if ($data['medical_right_group_id'] == 0) {
  echo 'หลักประกันสุขภาพถ้วนหน้า';
  } elseif ($data['medical_right_group_id'] == 1) {
  echo 'ข้าราชการ';
  } elseif ($data['medical_right_group_id'] == 2) {
  echo 'ข้าราชการส่วนท้องถิ่น';
  } elseif ($data['medical_right_group_id'] == 3) {
  echo 'รัฐวิสาหกิจ';
  } elseif ($data['medical_right_group_id'] == 4) {
  echo 'สำนักงานประกันสังคม';
  } elseif ($data['medical_right_group_id'] == 5) {
  echo 'ประกันสุขภาพภาคเอกชน';
  } elseif ($data['medical_right_group_id'] == 6) {
  echo 'กองทุนผู้ประสบภัยจากรถ';
  } elseif ($data['medical_right_group_id'] == 7) {
  echo 'หน่วยงานองค์การอิสระตามรัฐธรรมนูญ';
  } elseif ($data['medical_right_group_id'] == 8) {
  echo 'สิทธิการรักษาพยาบาลเฉพาะกลุ่ม';
  } elseif ($data['medical_right_group_id'] == 9) {
  echo 'ชำระเงินเอง';
  }
  ?>
  </td>
  <td style="text-align: center;color:black;"><input style="text-align: right" type="price" class="form-control " name="<?php echo 'medicalprice' . $id; ?>" value="<?php echo number_format($data['cr_price'],2) ?>"/></td>
  <td style="text-align: center;color:black;"><input style="text-align: center" type="text1" class="form-control " name="<?php echo 'date' . $id; ?>" value="<?php echo Yii::$app->componentdate->convertMysqlToThaiDate($data['cr_effectiveDate']) ?>" data-mask="99/99/9999"/></td>
  </tr>
  <?php $id++; ?>
  <?php endforeach; ?>
  </table>
  </div>
  </div>
  <div class="form-group">
  <label class="col-sm-2 control-label"></label>
  <div class="col-sm-3">
  <?= Html::submitButton($model->isNewRecord ? 'SaveDraft' : 'SaveDraft', ['class' => $model->isNewRecord ? 'btn btn-success draft ladda-button' : 'btn btn-success draft ladda-button', 'id' => 'SaveDraft', 'data-style' => 'expand-left']) ?>
  </div>
  </div>
  <?php ActiveForm::end(); ?>
 * 
 */ ?>

<?php
$script1 = <<< JS

            
$(function () {
    /* var allVals = []; */

    //$("#datepicker").datepicker();/*  set Datepicker   */

    $('.colored-success').bind('click', function () {

        if ($(this).is(':checked')) {
            var id = $(this).val();
            InsertNewCredit(id);
            /* allVals.push($(this).val()); */
        } else {
            var id = $(this).val();
            var itemid = $("#vwitempricelistscl-itemid").val();
            swal({
                title: "สิทธิ์นี้จะถูกยกเลิก?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'index.php?r=Inventory/additem/un-credit',
                                    {
                                        id: id, itemid: itemid
                                    },
                            function (data)
                            {
                                $.pjax.reload({container: '#credit_pjax_id'});
                            }
                            );
                        }
                    });
        }
    });
});
        
function InsertNewCredit(id) {
    var itemid = $("#vwitempricelistscl-itemid").val();
    swal({
        title: "ยืนยัน?",
        text: "",
        type: "warning",
        showCancelButton: true,
        closeOnConfirm: true,
        closeOnCancel: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post(
                            'index.php?r=Inventory/additem/addcredit-price',
                            {
                                id: id, itemid: itemid
                            },
                    function (data)
                    {
                        if (data == 'duplicate') {
                            swal("สิทธิ์นี้มีข้อมูลเดิมอยู่แล้ว!", "", "warning");
                            $.pjax.reload({container: '#credit_pjax_id'});
                        } else {
                            $.pjax.reload({container: '#credit_pjax_id'});
                        }
                    }
                    );
                }
            });
}
        
$("#DeleteOnSelect").click(function (e) {
    var selected = [];
    selected.push($('#w0').yiiGridView('getSelectedRows'));
                alert(selected);
    if (selected != '') {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'index.php?r=Inventory/additem/deletecredit-onselect',
                                {
                                    id: selected
                                },
                        function (data)
                        {
                            $.pjax.reload({container: '#credit_pjax_id'});
                        }
                        );
                    }
                });

    } else {
        swal("ยังไม่ได้เลือกรายการใด!", "", "warning");
    }
});
JS;
$this->registerJs($script1);
?>