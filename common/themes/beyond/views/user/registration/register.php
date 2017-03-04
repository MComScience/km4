<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use dektrium\user\models\User;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;
use dektrium\user\models\Province;
use kartik\widgets\DepDrop;
use yii\helpers\Url;


$this->title = Yii::t('user', 'บันทึกข้อมูลผู้ขาย Vendor Registry');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$max = User::find() // AQ instance
        ->select('max(id)') // we need only one column
        ->scalar(); // cool, huh?
$max1 = $max + 1;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php
                $form = ActiveForm::begin([
                            'id' => 'registration-form',
                            'options' => ['class' => 'form-horizontal'],
                            'fieldConfig' => [
                                'template' => "{label}\n<div class=\"col-lg-7\">{input}</div>\n<div class=\"col-sm-offset-3 col-lg-9\">{error}\n{hint}</div>",
                                'labelOptions' => ['class' => 'col-lg-4 control-label'],
                            ],
                            'enableAjaxValidation' => true,
                            //'enableClientValidation' => false,
                            'validateOnBlur' => false,
                ]);
                ?>

                <div class="row" >
                    <div class="col-md-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode('ข้อมูลบริษัท') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($profile, 'VenderTaxID')->textInput()->label('เลขประจำตัวผู้เสียภาษี<font color="red" size="3">*</font>') ?>

                                <?= $form->field($profile, 'VenderName')->textInput()->label('ชื่อผู้ขาย <font color="red" size="3">*</font>') ?>

                                <?=
                                $form->field($profile, 'VenderAddress')->textarea([
                                    'rows' => 4,
                                    'cols' => 10,
                                ])->label('ที่อยู่ <font color="red" size="3">*</font>')
                                ?>

                                <?=
                                $form->field($profile, 'VendorProvince')->dropdownList(
                                        ArrayHelper::map(Province::find()->all(), 'PROVINCE_ID', 'PROVINCE_NAME'), [
                                    'id' => 'ddl-province',
                                    'prompt' => 'เลือกจังหวัด'
                                ]);
                                ?>

                                <?=
                                $form->field($profile, 'VenderDistct')->widget(DepDrop::classname(), [
                                    'options' => ['id' => 'ddl-amphur'],
                                    'data' => [],
                                    'pluginOptions' => [
                                        'depends' => ['ddl-province'],
                                        'placeholder' => 'เลือกอำเภอ...',
                                        'url' => Url::to(['/user/admin/get-amphur'])
                                    ]
                                ]);
                                ?>

                                <?=
                                $form->field($profile, 'VenderSubDistct')->widget(DepDrop::classname(), [
                                    'options' => ['id' => 'ddl-distct'],
                                    'data' => [],
                                    'pluginOptions' => [
                                        'depends' => ['ddl-province', 'ddl-amphur'],
                                        'placeholder' => 'เลือกตำบล...',
                                        'url' => Url::to(['/user/admin/get-district'])
                                    ]
                                ]);
                                ?>

                                <?=
                                $form->field($profile, 'VenderPostalCode')->widget(kartik\widgets\Typeahead::classname(), [
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

                                <?= $form->field($profile, 'VenderPhone')->label('โทรศัพท์ <font color="red" size="3">*</font>') ?>

                                <?= $form->field($profile, 'VenderFax')->label('โทรสาร <font color="red" size="3">*</font>') ?>

                                <?=
                                $form->field($model, 'email')->widget(\yii\widgets\MaskedInput::className(), [
                                    'clientOptions' => [
                                        'alias' => 'email'
                                    ],
                                ])->label('E-mail บริษัท <font color="red" size="3">*</font>')
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode('ข้อมูลผู้ติดต่อ') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($profile, 'VenderContPersonNm')->label('ชื่อผู้ติดต่อ <font color="red" size="3">*</font>') ?>

                                <?= $form->field($profile, 'VenderContJobPosition')->label('ตำแหน่ง <font color="red" size="3">*</font>') ?>

                                <?= $form->field($profile, 'VenderContMobile')->label('โทรศัพท์มือถือ <font color="red" size="3">*</font>') ?>

                                <?=
                                $form->field($profile, 'VenderContEmail')->widget(\yii\widgets\MaskedInput::className(), [
                                    'clientOptions' => [
                                        'alias' => 'email'
                                    ],
                                ])->label('อีเมล์ผู้ติดต่อ <font color="red" size="3">*</font>')
                                ?>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><?= Html::encode('ข้อมูลการเข้าระบบเสนอราคา') ?></h3>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($model, 'username')->label('Username <font color="red" size="3">*</font>') ?>

                                <?php if ($module->enableGeneratingPassword == FALSE): ?>
                                    <?= $form->field($model, 'password')->passwordInput()->label('Password <font color="red" size="3">*</font>') ?>
                                <?php endif ?>
                                
                                <?= $form->field($profile, 'user_id')->hiddenInput(['value' => $max1])->label('') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group" style="text-align: right;">
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success ']) ?>
                    <?= Html::a('Print', [''], ['class' => 'btn btn-primary','disabled' => 'disabled']) ?>
                    <span>&nbsp;&nbsp;&nbsp;</span>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#ตกลงราคา").addClass("active open");
    $("#สั่งซื้อ").addClass("active open");
    $("#ตกลงราคาขอซื้อยาสามัญ").addClass("active");
    '); ?>

<?php $this->registerJs('
       $(function () {
    $("#profile-vendertaxid").keyup(function () {
        var uni = $("#profile-vendertaxid").val();
        var res = uni.substring(13, 7);
        $("#register-form-username").val(uni);
        $("#register-form-password").val(res);
    });
});

        '); ?>


<?php
/*
use yii\helpers\Html;
use yii\widgets\ActiveForm;



$this->title = Yii::t('user', 'Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id'                     => 'registration-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                ]); ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'username') ?>

                <?php if ($module->enableGeneratingPassword == false): ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                <?php endif ?>

                <?= Html::submitButton(Yii::t('user', 'Sign up'), ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a(Yii::t('user', 'Already registered? Sign in!'), ['/user/security/login']) ?>
        </p>
    </div>
</div>
 * 
 */?>
