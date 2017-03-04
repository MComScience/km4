<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use firdows\menu\models\Menu;
use firdows\menu\models\MenuCategory;
use kartik\widgets\Select2;
use common\iconmenu\SymbolPicker;
use firdows\menu\assets\AppAsset;

$asset = AppAsset::register($this);
?>


<div class="row">
    <div class="col-lg-12 col-sm-6 col-xs-12">
        <!--        <div class="widget">
                    <div class="widget-header bordered-bottom bordered-palegreen">
                        <div class="widget-caption">Create Menus</div>
                    </div>
                    <div class="widget-body">-->
        <?php $form = ActiveForm::begin(['id' => 'formmenu']); ?>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'icon')->widget(SymbolPicker::className()) ?>
            </div>
        </div>
        <div class="row">   
            <div class="">

                <?php // $form->field($model, 'icon')->textInput(['maxlength' => true])  ?>
            </div>   
            <div class="col-sm-12">   

                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">   
            <div class="col-sm-2">  
                <?= $form->field($model, 'target')->textInput(['maxlength' => true]) ?>
            </div>   
            <div class="col-sm-6">  
                <?= $form->field($model, 'router')->textInput(['maxlength' => true]) ?>
            </div>   
            <div class="col-sm-4">
                <?= $form->field($model, 'parameter')->textInput(['maxlength' => true]) ?>
            </div> 
        </div> 


        <div class="row">   
            <div class="col-sm-6">
                <?php
                echo $form->field($model, 'menu_category_id')->widget(Select2::classname(), [
                    'data' => MenuCategory::getList(),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>   
            <div class="col-sm-6">  
                <?php
                echo $form->field($model, 'parent_id')->widget(Select2::classname(), [
                    'data' => Menu::getList(),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div> 
        </div> 


        <div class="row">   
            <div class="col-sm-6">
                <?php
                echo $form->field($model, 'status')->widget(Select2::classname(), [
                    'data' => Menu::getItemStatus(),
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>   

            <div class="col-sm-6">  
                <?=
                $form->field($model, 'items')->widget(Select2::ClassName(), [
                    'data' => Menu::getAuth(),
                    'options' => [
                        'placeholder' => 'Select a color ...',
                        'multiple' => true
                    ],
                    'pluginOptions' => [
                        //'allowClear' => true,
                        'tags' => true,
                        //'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 10
                    ],
                ])
                ?>
            </div>   
        </div>   



        <div class="row">   
            <div class="col-sm-3">

                <?php /* = $form->field($model, 'sort')->dropDownList(Menu::getSortBy($model->menu_category_id, $model->parent_id), ['prompt' => Yii::t('app', 'เลือก')]) */ ?>
                <?= $form->field($model, 'sort')->textInput() ?>
            </div>   
            <div class="col-sm-3">  

                <?php /* = $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

                  <?= $form->field($model, 'assoc')->textInput(['maxlength' => true]) */ ?>

                <?= $form->field($model, 'params')->textInput() ?> 

            </div>   
            <div class="col-sm-3">  
                <?= $form->field($model, 'protocol')->textInput(['maxlength' => true]) ?>
            </div>  
            <div class="col-sm-3">  
                <?php
                echo $form->field($model, 'home')->widget(Select2::classname(), [
                    'data' => [ 1 => '1', 0 => '0',],
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>  
        <div class="form-group" style="text-align: right;">
            <div class="col-sm-12">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('menu', 'Create') : Yii::t('menu', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <!--            </div>
                </div>-->
    </div>
</div>
<?php
$script = <<< JS

$('#formmenu').on('beforeSubmit', function (e)
    {
        var form = $(this);
        $.post(
                form.attr("action"), // serialize Yii2 form
                form.serialize()
                )
                .done(function (result) {
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
                                    $(form).trigger("reset");
                                    $('#activity-modal').modal('hide');
                                    location.reload();
                                    //$.pjax.reload({container: '#menu_pjax_id'});
                                }
                            });
                }).fail(function ()
        {
            console.log("server error");
        });
        return false;
    });

JS;
$this->registerJs($script);
?>


