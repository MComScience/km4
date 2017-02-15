<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\checkbox\CheckboxX;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
?>
<?php Pjax::begin(['id' => 'branchesGrid']); ?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_main']); ?> 
<input type="hidden" value="<?php echo $model->ar_id ?>" name="TbArNew['ar_id']">
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($model, 'ar_maincode', ['label' => 'รหัสหน่วย', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($model, 'ar_maincode', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_name', ['label' => 'ชื่อหน่วยงานต้นสิทธิ์', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_name', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($model, 'medical_right_id', ['label' => 'กลุ่มสิทธิ์', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?php
        echo $form->field($model, 'medical_right_id', ['showLabels' => false])->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\modules\AuthenticationandFinance\models\TbMedicalRigth::find()->all(), 'medical_right_id', 'medical_right_desc'),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>
        <?php $form->field($model, 'medical_right_id', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_address', ['label' => 'ที่อยู่', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-10">
        <?= $form->field($modelardetail, 'ar_address', ['labelOptions' => ['class' => 'col-sm-2 col-md-2']])->label(false)->textarea(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_province', ['label' => 'จังหวัด', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?=
        $form->field($modelardetail, 'ar_province', ['showLabels' => false])->dropdownList(
            ArrayHelper::map(\app\models\Province:: find()->all(),
            'PROVINCE_ID',
            'PROVINCE_NAME'),
            [
                'id'=>'ddl-province',
                'prompt'=>'เลือกจังหวัด'
]);
        ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_amphur', ['label' => 'อำเภอ', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_amphur', ['showLabels' => false])->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-amphur'],
            'data'=> $amphur, 
            'pluginOptions'=>[
                'depends'=>['ddl-province'],
                'placeholder'=>'เลือกอำเภอ...',
                'url'=>Url::to(['/AuthenticationandFinance/ar/get-amphur'])
            ]
        ]); ?>
        <?php $form->field($modelardetail, 'ar_amphur', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_tumbol', ['label' => 'ตำบล', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_tumbol', ['showLabels' => false])->widget(DepDrop::classname(), [
           'data' =>$district,
           'pluginOptions'=>[
               'depends'=>['ddl-province', 'ddl-amphur'],
               'placeholder'=>'เลือกตำบล...',
               'url'=>Url::to(['/AuthenticationandFinance/ar/get-district'])
           ]
]); ?>
        <?php $form->field($modelardetail, 'ar_tumbol', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_postcode', ['label' => 'รหัสไปษณี', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_postcode', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_tel', ['label' => 'โทรศัพท์', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_tel', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_fax', ['label' => 'โทรสาร', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_fax', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_service_level', ['label' => 'ระดับบริการ', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_service_level', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-2"><div style="text-align:right"><?= Html::activeLabel($modelardetail, 'ar_service_type', ['label' => 'ประเภทบริการ', 'class' => 'control-label']) ?></div></div>
    <div class="col-sm-3">
        <?= $form->field($modelardetail, 'ar_service_type', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
    </div>
</div>
<hr>
<label style="font-size:150%;" class="control-label">เงื่อนไขการใช้สิทธิ์</label><br><br><br>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_opd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการรักษาผู้ป่วยนอก',
                'position' => CheckboxX::LABEL_RIGHT
        ]]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_opd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_opd_budgetlimit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
            </div>
            <div class="col-sm-5">
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_ipd_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินรักษาผู้ป่วยใน',
                'position' => CheckboxX::LABEL_RIGHT
        ]]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_ipd_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_ipd_budgetlimit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
            </div>
            <div class="col-sm-5">
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_year_budgetlimit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการรักษารายปี',
                'position' => CheckboxX::LABEL_RIGHT
        ]]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_year_budgetlimit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_year_budgetlimit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?>
            </div>
            <div class="col-sm-5">
                <label class="control-label" for="tbarpaymentcondition-ar_opd_budgetlimit_amt">บาท</label>
            </div>
        </div>
    </div>
</div>
<?php
echo $form->field($modelpaymentcondition, 'ar_drug_ned_allowed', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
        'label' => 'จำกัดการใช้ยา NED',
        'position' => CheckboxX::LABEL_RIGHT
]]);
?>
<div class="form-group">
    <div class="col-sm-4"> <?php
        echo $form->field($modelpaymentcondition, 'ar_drug_ned_limit', ['showLabels' => false])->widget(CheckboxX::classname(), [ 'pluginOptions' => ['threeState' => false], 'labelSettings' => [
                'label' => 'จำกัดวงเงินการใช้ยา NED',
                'position' => CheckboxX::LABEL_RIGHT
        ]]);
        ?></div>
    <div class="col-sm-7">
        <div class="form-group">
            <div class="col-sm-3"><div style="text-align:right"><?= Html::activeLabel($modelpaymentcondition, 'ar_drug_ned_limit_amt', ['label' => 'วงเงิน :', 'class' => 'control-label']) ?></div></div>
            <div class="col-sm-4">
                <?= $form->field($modelpaymentcondition, 'ar_drug_ned_limit_amt', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99']); ?> 
            </div>
            <div class="col-sm-5">
                <?php
                echo $form->field($modelpaymentcondition, 'ar_drug_ned_period')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\modules\AuthenticationandFinance\models\TbTimePeriod::find()->all(), 'ids', 'time_period'),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label('บาท');
                ?>
            </div>

        </div>
    </div>
</div>
<hr>
<div style="text-align: right;margin-right: 10px">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
</div>
<?= $form->field($model, 'ar_id')->hiddenInput()->label(false) ?>
<?= $form->field($modelpaymentcondition, 'ar_paymentcondition_id')->hiddenInput()->label(false) ?>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$script = <<< JS
        
$('#form_main').on('beforeSubmit', function(e) 
{
   var l = $('.ladda-button').ladda();
   l.ladda('start');
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
        l.ladda('stop');
        swal("Save Complete!", "", "success");
        $('#modal_register_ar').modal('hide');
        $.pjax.reload({container:"#grid_pjax", async:false});
    }else
    {        
        l.ladda('stop');
        $("#message").html(result);
    }
}).fail(function() 
{
    console.log("server error");
});
return false;
});

JS;
$this->registerJs($script);
?>