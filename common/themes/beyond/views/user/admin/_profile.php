<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use dektrium\user\models\Province;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\widgets\MaskedInput;
use dektrium\user\assets\AvatarUploaderAsset;
use dektrium\user\assets\AvatarAsset;
use frontend\assets\SweetAlertAsset;

AvatarUploaderAsset::register($this);
AvatarAsset::register($this);
SweetAlertAsset::register($this);
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


<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php $avatar = ($userAvatar = Yii::$app->user->identity->getAvatar('large', $profile->user_id)) ? $userAvatar : AvatarAsset::getDefaultAvatar('admin') ?>

<?php if ($profile->UserCatID == 2) { ?>
    <?php
    $form = ActiveForm::begin([
                //'layout' => 'horizontal',
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'options' => ['enctype' => 'multipart/form-data'],
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);
    ?>
    <?= $form->field($profile, 'ref')->hiddenInput()->label(false); ?>
    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-5">
        <div class="kv-avatar text-center" style="width:200px">
            <?=
            $form->field($profile, 'profileimg[]')->widget(\kartik\widgets\FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'initialPreview' => $profile->initialPreview($profile->profileimg, 'profileimg', 'file'), //<-----
                    'showCaption' => false,
                        'showRemove' => false,
                        'showClose' => FALSE,
                        'showUpload' => false,
                        'overwriteInitial' => TRUE,
                        'maxFileCount' => 1,
                        'autoReplace' => true,
                        'showBrowse' => FALSE,
                        'defaultPreviewContent' => '<img src="/km4/frontend/web/profiles/default/admin.png" alt="Your Avatar" style="width:160px" >'
                ]
            ])->label(false);
            ?>
        </div>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderTaxID', ['label' => 'เลขประจำตัวผู้เสียภาษี', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderTaxID', ['showLabels' => false]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderName', ['label' => 'ชื่อผู้ขาย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderName', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderRating', ['label' => 'ระดับผู้ขาย', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-3">
           <?=
            $form->field($profile, 'VenderRating',['showLabels' => false])->widget(\kartik\widgets\StarRating::classname(), [
                'pluginOptions' => [
                    'step' => 0.5,
                    'size' => 'xs',
                    'showClear' => FALSE,
                    'showCaption' => FALSE
                    ]
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderAddress', ['label' => 'ที่อยู่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-6">
            <?=
            $form->field($profile, 'VenderAddress', ['showLabels' => false])->textarea([
                'rows' => 4,
                'cols' => 10,
            ])
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($profile, 'VendorProvince', ['label' => 'จังหวัด', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'VendorProvince', ['showLabels' => false])->dropdownList(
                    ArrayHelper::map(Province::find()->all(), 'PROVINCE_ID', 'PROVINCE_NAME'), [
                'id' => 'ddl-province',
                'prompt' => 'เลือกจังหวัด'
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderDistct', ['label' => 'อำเภอ/เขต', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'VenderDistct', ['showLabels' => false])->widget(DepDrop::classname(), [
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
        <?= Html::activeLabel($profile, 'VenderSubDistct', ['label' => 'ตำบล/แขวง', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'VenderSubDistct', ['showLabels' => false])->widget(DepDrop::classname(), [
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
        <?= Html::activeLabel($profile, 'VenderPostalCode', ['label' => 'รหัสไปรษณีย์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'VenderPostalCode', ['showLabels' => false])->widget(kartik\widgets\Typeahead::classname(), [
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
        <?= Html::activeLabel($profile, 'VenderPhone', ['label' => 'โทรศัพท์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderPhone', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderFax', ['label' => 'โทรสาร', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderFax', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderEmail', ['label' => 'E-mail บริษัท', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderEmail', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderContPersonNm', ['label' => 'ชื่อผู้ติดต่อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderContPersonNm', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderContJobPosition', ['label' => 'ตำแหน่ง', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderContJobPosition', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderContMobile', ['label' => 'โทรศัพท์มือถือ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderContMobile', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'VenderContEmail', ['label' => 'อีเมล์ผู้ติดต่อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'VenderContEmail', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10" style="text-align: right">
            <?= Html::a('Close', ['/user/registration/index'], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
<?php } else { ?>
	<div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-3">
            <div class="image-uploader">
                <?php
                ActiveForm::begin([
                    'method' => 'post',
                    'action' => Url::to(['/user/settings/upload-avatar', 'id' => $profile->user_id]),
                    'options' => ['enctype' => 'multipart/form-data', 'autocomplete' => 'off'],
                ])
                ?>
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
                          data-action="<?= Url::to(['/user/settings/remove-avatar', 'id' => $profile->user_id]) ?>"
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
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'options' => ['enctype' => 'multipart/form-data'],
                'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]
    ]);
    ?>
    <?= $form->field($profile, 'ref')->hiddenInput()->label(false); ?>
    <?php /*
    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-5">
        <div class="kv-avatar text-center" style="width:200px">
            <?=
            $form->field($profile, 'profileimg[]')->widget(\kartik\widgets\FileInput::classname(), [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false
                ],
                'pluginOptions' => [
                    'initialPreview' => $profile->initialPreview($profile->profileimg, 'profileimg', 'file'), //<-----
                    'initialPreviewConfig' => $profile->initialPreview($profile->profileimg, 'profileimg', 'config'), //<-----
                    'showCaption' => false,
                        //'showRemove' => false,
                        //'showUpload' => false,
                        'showClose' => FALSE,
                        'overwriteInitial' => TRUE,
                        'maxFileCount' => 1,
                        'layoutTemplates' => [
                            'main1' => '{preview} {remove} {upload} {browse}',
                            'main2' => '{preview} {remove} {upload} {browse}'
                        ],
                        'autoReplace' => true,
//                    'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-folder-open"></i>',
                        'removeIcon' => '<i class="glyphicon glyphicon-remove"></i>',
                        'browseLabel' => '',
                        'removeLabel' => '',
                        'uploadIcon' => '<i class="fa fa-save fa-lg"></i>',
                        'uploadTitle' => 'Save profile picture',
                        'uploadLabel' => '',
                        'removeTitle' => 'Cancel or reset changes',
                        'msgErrorClass' => 'alert alert-block alert-danger',
                        'defaultPreviewContent' => '<img src="/km4/frontend/web/profiles/default/admin.png" alt="Your Avatar" style="width:160px" >'
                ]
            ])->label(false);
            ?>
        </div>
        </div>
    </div>
    */ ?>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_title', ['label' => 'คำนำหน้า', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-3">
            <?=
            $form->field($profile, 'User_title', ['showLabels' => false])->widget(Select2::classname(), [
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
        <?= Html::activeLabel($profile, 'User_fname', ['label' => 'ชื่อ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">   
            <?= $form->field($profile, 'User_fname', ['showLabels' => false]) ?>
        </div>
        <?= Html::activeLabel($profile, 'User_lname', ['label' => 'นามสกุล', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-4">   
            <?= $form->field($profile, 'User_lname', ['showLabels' => false]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_sectionid', ['label' => 'แผนก', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_sectionid', ['showLabels' => false])->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\TbSection::find()->all(), 'SectionID', 'SectionDecs'),
                'options' => ['placeholder' => 'Select a state ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
        </div>
        <?= Html::activeLabel($profile, 'User_position', ['label' => 'ตำแหน่ง', 'class' => 'col-sm-1 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_position', ['showLabels' => false])->widget(Select2::classname(), [
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
        <?= Html::activeLabel($profile, 'User_citizentid', ['label' => 'รหัสบัตรประชาชน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_citizentid', ['showLabels' => false])->widget(MaskedInput::className(), [
                'mask' => '9-9999-99999-99-9'
            ])
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_jobid', ['label' => 'รหัสพนักงาน', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'User_jobid', ['showLabels' => false])->textInput(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_licenseid', ['label' => 'เลขทะเบียนวิชาชีพ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'User_licenseid', ['showLabels' => false])->textInput(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_address', ['label' => 'ที่อยู่', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?= $form->field($profile, 'User_address', ['showLabels' => false])->textarea(['rows' => 3]); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_province', ['label' => 'จังหวัด', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_province', ['showLabels' => false])->dropdownList(
                    ArrayHelper::map(Province::find()->all(), 'PROVINCE_ID', 'PROVINCE_NAME'), [
                'id' => 'ddl-province',
                'prompt' => 'เลือกจังหวัด'
            ]);
            ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_distct', ['label' => 'อำเภอ/เขต', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_distct', ['showLabels' => false])->widget(DepDrop::classname(), [
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
        <?= Html::activeLabel($profile, 'User_subdistct', ['label' => 'ตำบล/แขวง', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_subdistct', ['showLabels' => false])->widget(DepDrop::classname(), [
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
        <?= Html::activeLabel($profile, 'User_postalcode', ['label' => 'รหัสไปรษณีย์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_postalcode', ['showLabels' => false])->widget(kartik\widgets\Typeahead::classname(), [
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
        <?= Html::activeLabel($profile, 'User_phone', ['label' => 'หมายเลขโทรศัพท์', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_phone', ['showLabels' => false])->widget(MaskedInput::className(), [
                'mask' => ['9-9-999-9999']
            ])
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_mobilephone', ['label' => 'โทรศัพท์มือถือ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">
            <?=
            $form->field($profile, 'User_mobilephone', ['showLabels' => false])->widget(MaskedInput::className(), [
                'mask' => ['99-9999-9999']
            ])
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_email', ['label' => 'Email', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">   
            <?=
            $form->field($profile, 'User_email', ['showLabels' => false])->textInput([
                'type' => 'email'
            ])
            ?>
        </div>
    </div>



    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_rfidtageid', ['label' => 'เลขที่บัตร RFID', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">   
            <?= $form->field($profile, 'User_rfidtageid', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_comment', ['label' => 'หมายเหตุ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">   
            <?= $form->field($profile, 'User_comment', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::activeLabel($profile, 'User_status', ['label' => 'สถานะ', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
        <div class="col-sm-4">   
            <?= $form->field($profile, 'User_status', ['showLabels' => false])->textInput([]) ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10" style="text-align: right">
            <?= Html::a('Close', ['/user/admin/index'], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
<?php } ?>
<?php $this->endContent() ?>
<?php
$confRemovingAuthMessage = Yii::t('yii', 'Are you sure you want to unlink this authorization?');
$confRemovingAvatarMessage = Yii::t('yii', 'Are you sure you want to delete your profile picture?');
$js = <<<JS
confRemovingAuthMessage = "{$confRemovingAuthMessage}";
confRemovingAvatarMessage = "{$confRemovingAvatarMessage}";
JS;

$this->registerJs($js, yii\web\View::POS_READY);
?>