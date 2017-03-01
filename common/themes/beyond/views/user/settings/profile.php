<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\MaskedInput;
use dektrium\user\models\Province;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use dektrium\user\assets\AvatarUploaderAsset;
use dektrium\user\assets\AvatarAsset;
use frontend\assets\SweetAlertAsset;

AvatarUploaderAsset::register($this);
AvatarAsset::register($this);
SweetAlertAsset::register($this);

$this->title = Yii::t('user', 'Profile settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
</style>
<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->render('_menu') ?>
    </div>
    <div class="col-md-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-3">
                        <div class="image-uploader">
                            <?php
                            ActiveForm::begin([
                                'method' => 'post',
                                'action' => Url::to(['upload-avatar', 'id' => $model->user_id]),
                                'options' => ['enctype' => 'multipart/form-data', 'autocomplete' => 'off'],
                            ])
                            ?>

                            <?php $avatar = ($userAvatar = Yii::$app->user->identity->getAvatar('large', $model->user_id)) ? $userAvatar : AvatarAsset::getDefaultAvatar('admin') ?>
                            <div class="image-preview" data-default-avatar="<?= $avatar ?>">
                                <img src="<?= $avatar ?>"/>
                            </div>
                            <div class="image-actions">
                                <span class="btn btn-primary btn-file"
                                      title="<?= Yii::t('yii', 'Change profile picture') ?>" data-toggle="tooltip"
                                      data-placement="left">
                                    <i class="fa fa-folder-open fa-lg"></i>
                                    <?= Html::fileInput('image', null, ['class' => 'image-input']) ?>
                                </span>

                                <?=
                                Html::submitButton('<i class="fa fa-save fa-lg"></i>', [
                                    'class' => 'btn btn-primary image-submit',
                                    'title' => Yii::t('yii', 'Save profile picture'),
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                ])
                                ?>

                                <span class="btn btn-primary image-remove"
                                      data-action="<?= Url::to(['remove-avatar', 'id' => $model->user_id]) ?>"
                                      title="<?= Yii::t('yii', 'Remove profile picture') ?>" data-toggle="tooltip"
                                      data-placement="right">
                                    <i class="fa fa-remove fa-lg"></i>
                                </span>
                            </div>
                            <div class="upload-status"></div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
                <?php
                $form = ActiveForm::begin([
                            'id' => 'profile-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'options' => ['enctype' => 'multipart/form-data'],
                            'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL],
                            'enableAjaxValidation' => true,
                            'enableClientValidation' => false,
                            'validateOnBlur' => false,
                ]);
                ?>
                <?= $form->field($model, 'ref')->hiddenInput()->label(false); ?>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_title', ['label' => 'คำนำหน้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-3">
                        <?=
                        $form->field($model, 'User_title', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\Tbtitlename::find()->all(), 'pt_titlename_id', 'pt_titlename'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_fname', ['label' => 'ชื่อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'User_fname', ['showLabels' => false]) ?>
                    </div>
                    <?= Html::activeLabel($model, 'User_lname', ['label' => 'นามสกุล', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'User_lname', ['showLabels' => false]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_sectionid', ['label' => 'แผนก', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_sectionid', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\TbSection::find()->all(), 'SectionID', 'SectionDecs'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                    <?= Html::activeLabel($model, 'User_position', ['label' => 'ตำแหน่ง', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_position', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(\app\models\Tbposition::find()->all(), 'PositionID', 'PositionDesc'),
                            'options' => ['placeholder' => 'Select a state ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">

                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_citizentid', ['label' => 'รหัสบัตรประชาชน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_citizentid', ['showLabels' => false])->widget(MaskedInput::className(), [
                            'mask' => '9-9999-99999-99-9'
                        ])
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_jobid', ['label' => 'รหัสพนักงาน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'User_jobid', ['showLabels' => false])->textInput(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_licenseid', ['label' => 'เลขทะเบียนวิชาชีพ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'User_licenseid', ['showLabels' => false])->textInput(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_address', ['label' => 'ที่อยู่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'User_address', ['showLabels' => false])->textarea(['rows' => 3]); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_province', ['label' => 'จังหวัด', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_province', ['showLabels' => false])->dropdownList(
                                ArrayHelper::map(Province::find()->all(), 'PROVINCE_ID', 'PROVINCE_NAME'), [
                            'id' => 'ddl-province',
                            'prompt' => 'เลือกจังหวัด'
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_distct', ['label' => 'อำเภอ/เขต', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_distct', ['showLabels' => false])->widget(DepDrop::classname(), [
                            'options' => ['id' => 'ddl-amphur'],
                            'data' => [$amphur],
                            'pluginOptions' => [
                                'depends' => ['ddl-province'],
                                'placeholder' => 'เลือกอำเภอ...',
                                'url' => Url::to(['/user/admin/get-amphur'])
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_subdistct', ['label' => 'ตำบล/แขวง', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_subdistct', ['showLabels' => false])->widget(DepDrop::classname(), [
                            'options' => ['id' => 'ddl-distct'],
                            'data' => [$district],
                            'pluginOptions' => [
                                'depends' => ['ddl-province', 'ddl-amphur'],
                                'placeholder' => 'เลือกตำบล...',
                                'url' => Url::to(['/user/admin/get-district'])
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_postalcode', ['label' => 'รหัสไปรษณีย์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_postalcode', ['showLabels' => false])->widget(kartik\widgets\Typeahead::classname(), [
                            //'options' => ['placeholder' => 'เลือกรหัสไปรษณีย์...'],
                            'scrollable' => true,
                            //'rtl' => true,
                            'pluginOptions' => ['hint' => false, 'highlight' => true],
                            'dataset' => [
                                    [
                                    'prefetch' => Url::to(['admin/zipcode-list']),
                                    'limit' => 10
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_phone', ['label' => 'หมายเลขโทรศัพท์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_phone', ['showLabels' => false])->widget(MaskedInput::className(), [
                            'mask' => ['9-9-999-9999']
                        ])
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_mobilephone', ['label' => 'โทรศัพท์มือถือ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'User_mobilephone', ['showLabels' => false])->widget(MaskedInput::className(), [
                            'mask' => ['99-9999-9999']
                        ])
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_email', ['label' => 'Email', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">   
                        <?=
                        $form->field($model, 'User_email', ['showLabels' => false])->textInput([
                            'type' => 'email'
                        ])
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_rfidtageid', ['label' => 'เลขที่บัตร RFID', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'User_rfidtageid', ['showLabels' => false])->textInput([]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'User_comment', ['showLabels' => false])->textInput([]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($model, 'User_status', ['label' => 'สถานะ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'User_status', ['showLabels' => false])->textInput([]) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-9">

                        <?= \yii\helpers\Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn  btn-success']) ?><br>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$confRemovingAuthMessage = Yii::t('yii', 'Are you sure you want to unlink this authorization?');
$confRemovingAvatarMessage = Yii::t('yii', 'Are you sure you want to delete your profile picture?');
$js = <<<JS
confRemovingAuthMessage = "{$confRemovingAuthMessage}";
confRemovingAvatarMessage = "{$confRemovingAvatarMessage}";
JS;

$this->registerJs($js, yii\web\View::POS_READY);
?>