<?php

use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\bootstrap\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;
use yii\jui\DatePicker;
?>
<br>
<label style="font-size: 16pt" >รายละเอียดสิทธิ์</label><br>
<label><b>กลุ่มของสิทธิ์: </b> <?php echo $arlist->medical_right_group; ?> </label> <label> </label> <label><b>ประเภทของสิทธิ์: </b><?php echo $arlist->medical_right_group; ?> </label> <label></label><br>

<label><b>ชื่อหน่วยงานต้นสิทธิ์: </b> <?php echo $arlist->ar_name; ?> </label> <label> </label>
<br>
<label style="font-size: 16pt" >รายละเอียดใบส่งตัว</label>
<br>
<?php Pjax::begin(['id' => 'pjax_add_right_patian']); ?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_edit_right_patian']); ?> 
<input type="hidden" id="vwptar-ar_id" class="form-control" name="VwPtAr[ar_id]" value="<?php echo $vwptar->ar_id ?>">
<input type="hidden" id="vwptar-pt_ar_id" class="form-control" name="VwPtAr[pt_ar_id]" value="<?php echo $vwptar->pt_ar_id ?>">
<input type="hidden" id="vwptar-pt_ar_usage" class="form-control" name="VwPtAr[pt_ar_usage]" value="<?php echo $vwptar->pt_ar_usage ?>">
<input type="hidden" id="pt_visit_number" class="form-control" name="VwPtAr[pt_visit_number]" value="<?php echo $vwptar->pt_visit_number ?>">
<input type="hidden" id="vwptar-medical_right_id" class="form-control" name="VwPtAr[medical_right_id]" value="<?php echo $vwptar->medical_right_id ?>">
<input type="hidden" id="vwptar-credit_group_id" class="form-control" name="VwPtAr[credit_group_id]" value="<?php echo $vwptar->credit_group_id ?>">
<input type="hidden" id="vwptar-refer_hrecieve_doc_id" class="form-control" name="VwPtAr[refer_hrecieve_doc_id]" value="<?php echo $vwptar->refer_hrecieve_doc_id ?>">
<input type="hidden" id="vwptar-pt_hospital_number" class="form-control" name="VwPtAr[pt_hospital_number]" value="<?php echo $vwptar->pt_hospital_number ?>">

<div class="form-group">
    <?= Html::activeLabel($vwptar, 'refer_hsender_doc_id', [ 'label' => 'เลขที่ใบส่งตัว', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($vwptar, 'refer_hsender_doc_id', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
    <?= Html::activeLabel($vwptar, 'refer_hsender_sent_typeid', [ 'class' => 'col-sm-3 control-label']) ?>

    <div class="col-sm-3">

        <div class="radio">
            <?php
            $list = [0 => 'ระยะเวลา', 1 => 'จำนวนครั้ง'];
            echo $form->field($vwptar, 'refer_hsender_sent_typeid', ['showLabels' => false])->radioList($list, ['inline' => true, 'class' => 'radio','item' => function($index, $label, $name, $checked, $value) {
 $check = $checked ? ' checked="checked"' : '';
                                    $return = '<label class="modal-radio">';
                                    $return .= '<input type="radio" '.$check.' name="' . $name . '" value="' . $value . '"  tabindex="3">';
                                    $return .= '<i></i>';
                                    $return .= '<span class="text">' . ucwords($label) . '</span>';
                                    $return .= '</label>';

                                    return $return;
                                }],
                                ['class' => 'i-checks']);
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($vwptar, 'refer_hrecieve_doc_date', [ 'label' => 'วันที่ใบส่งตัว', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?=
        $form->field($vwptar, 'refer_hrecieve_doc_date', ['showLabels' => false])->widget(DatePicker::classname(), [
            'language' => 'th',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options' => [
                'class' => 'form-control',
                'style' => 'background-color: #FFFF99'
            ],
        ]);
        ?>
    </div>
    <?= Html::activeLabel($vwptar, 'refer_hsender_doc_qtylimited', [ 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($vwptar, 'refer_hsender_doc_qtylimited', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($vwptar, 'ar_card_id', [ 'label' => 'เลขที่บัตรสิทธิการรักษา', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($vwptar, 'ar_card_id', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
    <?= Html::activeLabel($vwptar, 'refer_hsender_doc_start', [ 'label' => 'วันที่เริ่มสิทธิ', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-3">
        <?=
        $form->field($vwptar, 'refer_hsender_doc_start', ['showLabels' => false])->widget(DatePicker::classname(), [
            'language' => 'th',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'Select issue date ...',
                'style' => 'background-color: #FFFF99'
            ],
        ]);
        ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($vwptar, 'pt_refer_note', [ 'label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($vwptar, 'pt_refer_note', ['showLabels' => false])->textarea(['style' => 'background-color: #FFFF99']); ?>
    </div>
    <?= Html::activeLabel($vwptar, 'refer_hsender_doc_expdate', [ 'label' => 'วันที่สิ้นสุดสิทธิ', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-3">
        <?=
        $form->field($vwptar, 'refer_hsender_doc_expdate', ['showLabels' => false])->widget(DatePicker::classname(), [
            'language' => 'th',
            'dateFormat' => 'dd/MM/yyyy',
            'clientOptions' => [
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options' => [
                'class' => 'form-control',
                'placeholder' => 'Select issue date ...',
                'style' => 'background-color: #FFFF99'
            ],
        ]);
        ?>
    </div>
</div>
<hr>

<div style="text-align: right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
    <?= Html::submitButton($vwptar->isNewRecord ? 'Save' : 'Save', ['class' => $vwptar->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>


<?php
$s = <<< JS
        
 $('#form_edit_right_patian').on('beforeSubmit', function(e) 
{
 waitMe_Running_show(1);
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
      swal("Save Complete!", "", "success");
      waitMe_Running_hide(1);
        $('#modal_edit_right_patian').modal('hide'); 
         var vn = $('#pt_visit_number').val();
        $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/getptardetail-save',
                   type: 'get',
                   data:{vn:vn},
                    success: function (data) {
                        $('#table_right').html(data);
                        waitMe_Running_hide(1);
                        $('#example').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 5,
                        responsive: true,
                        "language": {
                            "lengthMenu": " _MENU_ ",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                            "search": "ค้นหา "
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
             ]
           }); 
                    }
                });
       
    }else
    {        
        $("#message").html(result);
    }
}).fail(function() 
{
    console.log("server error");
});
return false;
});
JS;
$this->registerJs($s);
?>
