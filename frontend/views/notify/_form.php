<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use kartik\widgets\Select2;

$data = [
    "1" => "Waiting",
    "2" => "Completed",
];
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="well bordered-left bordered-themeprimary">
            <div class="tb-problem-form">
                <h1><?= Html::encode($this->title) ?></h1>

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <?= $form->field($model, 'ref')->hiddenInput(['maxlength' => 50])->label(false); ?>

                <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>

                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6">
                            <?= $form->field($model, 'create_date')->textInput(['value' => empty($model['create_date']) ? date('Y-m-d') : $model['create_date'], 'readonly' => true]) ?>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="control-label"><?= Html::encode('แจ้งโดย'); ?></label>
                            <input class="form-control" value="<?= Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname; ?>" readonly=""/>
                        </div>
                    </div>
                </div>

                <div class="form-group field-upload_files">
                    <label class="control-label" for="upload_files[]"> <?= Html::encode('รูปภาพเพิ่มเติม') ?> </label>
                    <div>
                        <?=
                        FileInput::widget([
                            'name' => 'upload_ajax[]',
                            'options' => ['multiple' => true, 'accept' => 'image/*'], //'accept' => 'image/*' หากต้องเฉพาะ image
                            'pluginOptions' => [
                                'overwriteInitial' => false,
                                'initialPreviewShowDelete' => true,
                                'initialPreview' => $initialPreview,
                                'initialPreviewConfig' => $initialPreviewConfig,
                                'uploadUrl' => Url::to(['/notify/upload-ajax']),
                                'uploadExtraData' => [
                                    'ref' => $model->ref,
                                ],
                                'maxFileCount' => 100
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <?php if (Yii::$app->controller->action->id == 'update') : ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-4 col-md-4">
                                <?php
                                echo $form->field($model, 'status')->widget(Select2::classname(), [
                                    'data' => $data,
                                    'options' => ['placeholder' => 'Select Status',],
                                ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-4 col-md-4">
                                <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <p></p>
                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Submit' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>

