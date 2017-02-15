<?php
use app\modules\Inventory\models\TbItemndmedsupplycatidSub;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbItemndmedsupply */
/* @var $form yii\widgets\ActiveForm */
?>

<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?=
            Html::encode($this->title);            ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">

        <!--<div class="tb-itemndmedsupply-form">-->
        <div class="well">
         <?php Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php $form = ActiveForm::begin(['layout' => 'horizontal','id'=>'form_main']); ?>
            <div class="row">
                <div class="col-sm-7">
                 <?php
                 echo $form->field($model, 'ItemNDMedSupplyCatID_sub')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TbItemndmedsupplycatidSub::find()->all(), 'ItemNDMedSupplyCatID_sub_id', 'ItemNDMedSupplyCatID_sub_desc'),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                    'allowClear' => true
                    ],
                    ]);?>
                    <?= $form->field($model, 'ItemNDMedSupply')->textInput(['style' => 'background-color: #ffff99',]) ?>
                    <?= $form->field($model, 'ItemNDMedSupplyDesc')->textInput(['style' => 'background-color: #ffff99',]) ?>



                </div>
            </div>
            <div style="text-align: right;margin-right: 10px">
                <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::submitButton($model->isNewRecord ? 'บันทึกข้อมูล' : 'บันทึกข้อมูล', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                
            </div>
            <?php ActiveForm::end(); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div><?php
$script = <<< JS
      
$('#form_main').on('beforeSubmit', function(e) 
{
var tbitemndmedsupplyitemndmedsupplycatid_sub = $('#tbitemndmedsupply-itemndmedsupplycatid_sub').val();
 if(tbitemndmedsupplyitemndmedsupplycatid_sub != ""){
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
        swal("บัทึกรายการแล้ว!", "", "success");
    }else
    {        
        $("#message").html(result);
        waitMe_hide(2);
    }
}).fail(function() 
{
    console.log("server error");
});
}else{
   
    swal("", "กรุณาเลือกประเภทเวชภัณฑ์", "warning");
    
}
return false;
});

JS;
$this->registerJs($script);
?>
