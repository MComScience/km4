<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vw-fi-rep-list-search">

    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                //'action' => ['history'],
               // 'method' => 'get',
                'options' => ['data-pjax' => true]
    ]);
    ?>
    <div class="form-group" >
        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right">เลขที่นำส่งเงิน</label>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <input type="text" class="form-control" style="background-color: white;text-align:right" readonly="" name="rep_summary_id" id="rep_summary_id" value="<?php echo $modelSummary['rep_summary_id'];    ?>">
        </div>
        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right">วันที่</label>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <?=
            $form->field($modelSummary, 'rep_summary_date', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                'language' => 'th',
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'changeMonth' => true,
                    'changeYear' => true,
                ],
                'options' => [
                    'class' => 'form-control',
                    'style' => 'background-color: white',
                ],
                
            ])
            ?>
        </div>
        <label class="col-lg-1 col-md-1 col-sm-12 col-xs-12 control-label no-padding-right">แผนก</label>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <input type="text" class="form-control" style="background-color: white;text-align:left" readonly="" name="SectionName" id="SectionName" value="<?php echo $SectionName;?>">
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
	// $(document).ready(function(){
 //    var now = new Date();
 //    var month = (now.getMonth() + 1);               
 //    var day = now.getDate();
 //    if(month < 10) {
 //         month = "0" + month;
 //    }
 //    if(day < 10){
 //       day = "0" + day; 
 //    } 
 //    var year = now.getFullYear();
 //    var year_fm = year+543;
 //    var today =  day + '/' + month + '/' + year_fm;
 //    $('#vwfireplistsearch-repdate').val(today);
 //    });
 //    // $('#vwfireplistsearch-rep_create_section').on('change', function () {
 //    //    //var sc_change = $(this).find("option:selected").val();
 //    //    $('#btn_Search').click();
 //    // });

JS;
$this->registerJs($script);
?> 