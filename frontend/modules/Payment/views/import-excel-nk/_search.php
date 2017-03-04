<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\modules\Payment\models\VwFiRepListSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="VwRepUcOpipListSearch">

    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'action' => ['index'],
                'method' => 'get',
                'options' => ['data-pjax' => true]
    ]);
    ?>
    <div class="form-group" >
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <div class="input-group">
        <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
        <span class="input-group-btn">
            <?= Html::submitButton('<i class="glyphicon glyphicon-search"></i> ค้นหา', ['class' => 'btn btn-default', 'id' => 'btn_Search']) ?>
        </span>
    </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="margin-top: 8px">
          <label><span class="text"></span><input type="checkbox" class="colored-success" name="VwRepUcSearch[itemstatus]" id="chk_ipop"  data-toggle="checkbox-x"><span class="text"> แสดงเฉพาะรายการที่ยังไม่บันทึกลูกหนี้</span></label>
          <input type="hidden" class="form-control" style="background-color: white;text-align:left" readonly="" name="" id="" value="">
      </div>
    </div>
  <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<< JS

    $(document).ready(function(){
        if(localStorage.checkbox_import_ipop == 'true'){
            document.getElementById("chk_ipop").checked = true;
        }else{
            document.getElementById("chk_ipop").checked = false;
        }
    });
    $("input[id=chk_ipop]").click(function () {
    if ($(this).is(":checked"))
    {   
        console.log('check_box');
        localStorage.checkbox_import_ipop = 'true';
        $('#chk_ipop').val('รอบันทึกลูกหนี้');
        $('#btn_Search').click();
            
    }else{
        localStorage.checkbox_import_ipop = 'false';
        $('#chk_ipop').val('');
        $('#btn_Search').click();
        
    }
    });    
    

JS;
$this->registerJs($script);
?> 
<script>

</script>