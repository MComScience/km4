
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
<label style="font-size: 13pt" >รายละเอียดสิทธิ์</label>
<br>
<div style="margin-left:30px">
<label><b>กลุ่มของสิทธิ์: </b> <?php echo $arlist->medical_right_group; ?> </label>  <label><b>ประเภทของสิทธิ์: </b><?php echo $arlist->medical_right_group; ?> </label><br>

<label><b>ชื่อหน่วยงานต้นสิทธิ์: </b> <?php echo $arlist->ar_name; ?> </label> 
</div>
<label style="font-size: 13pt" >รายละเอียดใบส่งตัว</label>
<?php Pjax::begin(['id' => 'pjax_add_right_patian','timeout'=>5000]); ?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_add_right_patian']); ?> 
<input type="hidden"  class="form-control" name="VwPtAr[pt_hospital_number]" value="<?php echo $pt_hospital_number ?>">
<input type="hidden"  class="form-control" id="pt_visit_number" name="VwPtAr[pt_visit_number]" value="<?php echo $pt_visit_number ?>">
<input type="hidden"  class="form-control" name="VwPtAr[medical_right_id]" value="<?php echo $arlist->medical_right_id; ?>">
<input type="hidden"  class="form-control" name="VwPtAr[refer_hrecieve_doc_id]" value="<?php echo $arselect->refer_hrecieve_doc_id; ?>">

<input type="hidden"  class="form-control" name="VwPtAr[pt_ar_id]" value="">

<?= $form->field($arlist, 'ar_id', ['showLabels' => false])->hiddenInput(); ?>
<?php $form->field($arselect, 'pt_ar_id', ['showLabels' => false])->hiddenInput(['value'=>'']); ?>
<?= $form->field($arselect, 'pt_ar_usage', ['showLabels' => false])->hiddenInput(); ?>
<div class="form-group">
    <?= Html::activeLabel($modelrefer, 'REFER_HSENDER_DOC_ID', [ 'label' => 'เลขที่ใบส่งตัว', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($modelrefer, 'REFER_HSENDER_DOC_ID', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
    <?= Html::activeLabel($arselect, 'refer_hsender_sent_typeid', [ 'class' => 'col-sm-3 control-label']) ?>

    <div class="col-sm-3">
        <div class="radio">
            <?php
            $list = [0 => 'ระยะเวลา', 1 => 'จำนวนครั้ง'];
            echo $form->field($arselect, 'refer_hsender_sent_typeid', ['showLabels' => false])->radioList($list, ['inline' => true, 'class' => 'radio','item' => function($index, $label, $name, $checked, $value) {
$check = $checked ? ' checked="checked"' : '';
                                    $return = '<label class="modal-radio">';
                                    $return .= '<input type="radio"  '.$check.' name="' . $name . '" value="' . $value . '" tabindex="3">';
                                    $return .= '<i></i>';
                                    $return .= '<span class="text">' . ucwords($label) . '</span>';
                                    $return .= '</label>';

                                    return $return;
                                }]);
            ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($arselect, 'refer_hrecieve_doc_date', [ 'label' => 'วันที่ใบส่งตัว', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?=
        $form->field($arselect, 'refer_hrecieve_doc_date', ['showLabels' => false])->widget(DatePicker::classname(), [
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
    <?= Html::activeLabel($arselect, 'refer_hsender_doc_qtylimited', [ 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($arselect, 'refer_hsender_doc_qtylimited', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <?= Html::activeLabel($modelpatent, 'PT_INSCLCARD_ID', [ 'label' => 'เลขที่บัตรสิทธิการรักษา', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($modelpatent, 'PT_INSCLCARD_ID', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
    <?= Html::activeLabel($modelrefer, 'REFER_HSENDER_DOC_START', [ 'label' => 'วันที่เริ่มสิทธิ', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-3">
        <?=
        $form->field($modelrefer, 'REFER_HSENDER_DOC_START', ['showLabels' => false])->widget(DatePicker::classname(), [
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
    <?= Html::activeLabel($arselect, 'pt_refer_note', [ 'label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-3">
        <?= $form->field($arselect, 'pt_refer_note', ['showLabels' => false])->textarea(['style' => 'background-color: #FFFF99']); ?>
    </div>
    <?= Html::activeLabel($modelrefer, 'REFER_HSENDER_DOC_EXPDATE', [ 'label' => 'วันที่สิ้นสุดสิทธิ', 'class' => 'col-sm-3 control-label']) ?>
    <div class="col-sm-3">
        <?=
        $form->field($modelrefer, 'REFER_HSENDER_DOC_EXPDATE', ['showLabels' => false])->widget(DatePicker::classname(), [
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

<label style="font-size:13pt;" class="control-label">เงื่อนไขการใช้สิทธิ</label><div style="text-align: right"><a class="btn btn-success" href="javascript:editright(<?php echo $arlist->ar_id ?>)">Edit</a></div>
<div id="payment_div">
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_opd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการรักษาผู้ป่วยนอก',
                'position' => CheckboxX::LABEL_RIGHT,
            ],
            'disabled' => true
        ]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_opd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_opd_budgetlimit_amt; ?></label>
                <label class="control-label">บาท</label>
            </div>
            <div class="col-sm-5">

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_ipd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินรักษาผู้ป่วยใน',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'disabled' => true]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_ipd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_ipd_budgetlimit_amt; ?></label>
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
            <div class="col-sm-5">

            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_year_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการรักษารายปี',
                'position' => CheckboxX::LABEL_RIGHT,
            ],
            'disabled' => true]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_year_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_year_budgetlimit_amt; ?></label>
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
            <div class="col-sm-5">

            </div>
        </div>
    </div>
</div>
<?php
echo $form->field($modelpaymentcondition, 'ar_drug_ned_allowed', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
        'label' => 'จำกัดการใช้ยา NED',
        'position' => CheckboxX::LABEL_RIGHT
    ],
    'disabled' => true]);
?>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_drug_ned_limit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการใช้ยา NED',
                'position' => CheckboxX::LABEL_RIGHT
            ],
            'disabled' => true]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_drug_ned_limit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <label class="control-label"><?php echo $modelpaymentcondition->ar_drug_ned_limit_amt; ?></label>
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
            <div class="col-sm-5">
                <?php
                echo $form->field($modelpaymentcondition, 'ar_drug_ned_period')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\modules\AuthenticationandFinance\models\TbTimePeriod::find()->all(), 'ids', 'time_period'),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'disabled' => true
                    ],
                ])->label('');
                ?>
            </div>

        </div>
    </div>
</div>
</div>
<div style="text-align: right">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
    <?= Html::submitButton($arselect->isNewRecord ? 'Save' : 'Save', ['class' => $arselect->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
</div>
<?=
$form->field($modelrefer, 'REFER_HSENDER_DOC_ID', ['showLabels' => false])->hiddenInput();
?>
<?=
$form->field($modelrefer, 'REFER_HSENDER_CODE', ['showLabels' => false])->hiddenInput();
?>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$s = <<< JS
        
      function editright(id){   
          $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/editright',
                    type: 'get',
                    data:{id:id},
                    success: function (data) {
                        $('#detail_edit_right_payment').html(data);
                        $('#modal_edit_right_payment').modal({show: 'true'}); 
                        
                    }
                });
       
    } 
 $('#form_add_right_patian').on('beforeSubmit', function(e) 
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
        $('#modal_add_right_opd_and_ipd2').modal('hide'); 
       // $.pjax.reload({container:"#pjax_add_right_patian", async:false});

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
