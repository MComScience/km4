<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepListSearch */
/* @var $form yii\widgets\ActiveForm */
//echo $_SESSION['section_view'];
?>

<div class="vw-fi-rep-list-search">

    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'action' => ['index'],
                'method' => 'get',
                'options' => ['data-pjax' => true]
    ]);
    ?>
    <div class="form-group" >
<!--        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right">เลขที่นำส่งเงิน</label>-->
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <input type="hidden" class="form-control" style="background-color: white;text-align:right" readonly="" name="cr_summary_id" id="cr_summary_id" value="<?php //echo $rep_summary_id;    ?>">
        </div>
        
    </div>
    <div class="form-group" >
     
    </div>
     <div class="form-group" >
        
    </div>
    <div class="form-group" >
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="input-group">
        <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
        <span class="input-group-btn">
            <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ค้นหา', ['class' => 'btn btn-default', 'id' => 'btn_Search']) ?>
        </span>
    </div>
    </div>
         <div class="col-lg-offset-3 col-md-offset-3 col-lg-2 col-md-2 col-sm-12 col-xs-12" style="margin-top: 8px">
        <label><span class="text"></span><input type="checkbox" class="colored-success" name="dischage" id="dischage"  data-toggle="checkbox-x"><span class="text"> เฉพาะผู้ป่วย Dischage</span></label>
          <input type="hidden" class="form-control" style="background-color: white;text-align:left" readonly="" name="VwFiInvCrListSearch[pt_visit_status]" id="pt_visit_status" value="">
        </div>
        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right">ประเภทผู้ป่วย</label>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?=
            $form->field($model, 'pt_visit_type', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                'data' => yii\helpers\ArrayHelper::map(\app\modules\Payment\models\TbPtVisitType::find()->all(), 'pt_visit_type_code', 'pt_visit_type_desc'),
                'options' => ['placeholder' => 'Select Option...'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>
        </div>
       
    </div>
  <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<< JS
     $(document).ready(function(){
        if(localStorage.checkbox == 'true'){
            $('#pt_visit_status').val('3');
            document.getElementById("dischage").checked = true;
            //$("#CrSummary,#Print").removeAttr('disabled', 'disabled');
        }else{
            $('#pt_visit_status').val('');
            document.getElementById("dischage").checked = false;
            //$("#CrSummary,#Print").attr('disabled', 'disabled');
        }
       //
        //document.getElementById("dischage").checked = false;
    });
    $("input[id=dischage]").click(function () {
        if ($(this).is(":checked"))
        {   
            console.log('check_box');
            localStorage.checkbox = 'true';
            $('#pt_visit_status').val('3');
            $('#btn_Search').click();
            
        }else{
            localStorage.checkbox = 'false';
            $('#pt_visit_status').val('');
            $('#btn_Search').click();
        
        }
    });    
     $('#vwfiinvcrlistsearch-pt_visit_type').on('change', function () {
        //var sc_change = $(this).find("option:selected").val();
        $('#btn_Search').click();
     });

JS;
$this->registerJs($script);
?> 
<script>

</script>