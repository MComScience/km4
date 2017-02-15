<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\Po */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="po-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','layout' => 'horizontal']); ?>

    <?= $form->field($model, 'ItemNDMedSupplyCatID_sub_id')->hiddenInput(['maxlength' => 10])->label(false) ?>
  <div class="row">
                <div class="col-sm-6">
    <?= $form->field($model, 'ItemNDMedSupplyCatID_sub_desc')->textInput(['style' => 'background-color: #ffff99']) ?>
	</div>
    </div>
<?php /*	<div class="row">
		<div class="panel panel-default">
        <div class="panel-heading"><h4> หมวดย่อย</h4></div>
        <div class="panel-body">
             DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 10, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelsItemndmedsupply[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'ItemNDMedSupply',
                    'ItemNDMedSupplyDesc',
                ],
            ]); */?>

         <!--   <div class="container-items"> widgetContainer -->
            <?php 
            //foreach ($modelsItemndmedsupply as $i => $modelsItemndmedsupplys): ?>
             <?php /*   <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                
                        <?php
                            // necessary for update action.
                            if (! $modelsItemndmedsupplys->isNewRecord) {
                                echo Html::activeHiddenInput($modelsItemndmedsupplys, "[{$i}]ItemNDMedSupplyCatID");
                            }
                        ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelsItemndmedsupplys, "[{$i}]ItemNDMedSupply")->textInput(['maxlength' => 128,'style' => 'background-color: #ffff99']) ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelsItemndmedsupplys, "[{$i}]ItemNDMedSupplyDesc")->textInput(['maxlength' => 128,'style' => 'background-color: #ffff99']) ?>
                            </div>
                        </div><!-- .row -->
                    </div>
             
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); 
        </div>
		</div>
	</div>
*/?>
    <div style="text-align:right" class="form-group">
     <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
     <?php if($type == 'view'){ ?>
        <?= Html::submitButton($model->isNewRecord ? 'บันทึกข้อมูล' : 'บันทึกข้อมูล', [
        'disabled'=>'disabled','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
        <?php }else{ ?>
             <?= Html::submitButton($model->isNewRecord ? 'บันทึกข้อมูล' : 'บันทึกข้อมูล', [
        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
            <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
