<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\jui\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\modules\pharmacy\models\VwUserprofile;
?>
<style type="text/css">
    /*    .profile-container .profile-header {
            height: 50px;
            min-height: 100px;
        }
        .profile-info {
            height: 50px;
        }*/
</style>
<div class="profile-header row bg-white">
    <!-- Profile Detail -->
    <div class="col-lg-7 col-md-12 col-sm-12">
        <div class="row">
            <div class="invoice-container">
                <ul>
                    <li>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 25px" class="success"><?= $profile->pt_name; ?></span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="font-size: 14pt;"><?= Html::encode('อายุ'); ?>&nbsp;&nbsp;&nbsp; <?= !$profile->pt_age_registry_date ? '-' : $profile->pt_age_registry_date; ?> &nbsp;&nbsp;&nbsp;<?= Html::encode('ปี'); ?></b>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b style="font-size: 14pt;"><?= Html::encode('HN'); ?>&nbsp;&nbsp;&nbsp; <?= !$profile->pt_hospital_number ? '-' : $profile->pt_hospital_number; ?> &nbsp;&nbsp;&nbsp;
                            <?= Html::encode('VN'); ?>&nbsp;&nbsp;&nbsp; <?= !$profile->pt_visit_number ? '-' : $profile->pt_visit_number; ?> &nbsp;&nbsp;&nbsp;</b>
                    </li>
                    <hr/>
                    <li class="pull-left success">&nbsp;<b><?= Html::encode('สิทธิการรักษา'); ?></b></li>
                    <li class="pull-right">
                        <?=
                        Html::a('<i class="glyphicon glyphicon-list-alt"></i>' . 'Detail', ['ardetail', 'vn' => $profile['pt_visit_number']], ['role' => 'modal-remote', 'class' => 'btn btn-info  btn-xs'])
                        ?>
                        &nbsp;
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td class="text-left"><?= 1; ?>. <?= $ptar['ar_name1']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="invoice-container">
                <ul>
                    <li class="pull-left">&nbsp;<b class="success"><?= Html::encode('Drug Allergic'); ?></b> Drug1 Drug2 Drug3 Drug4</li>
                    <li class="pull-right">
                        <?=
                        Html::a('<i class="glyphicon glyphicon-list-alt"></i>' . 'Detail', ['ardetail', 'vn' => $profile['pt_visit_number']], ['role' => 'modal-remote', 'class' => 'btn btn-info  btn-xs']) . ' '
                        . Html::a('<i class="glyphicon glyphicon-plus"></i>' . 'Add', ['ardetail', 'vn' => $profile['pt_visit_number']], ['role' => 'modal-remote', 'class' => 'btn btn-success  btn-xs'])
                        ?>
                        &nbsp;
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="invoice-container">
                <ul>
                    <li class="pull-left">&nbsp;<b class="success"><?= Html::encode('Last Diagnosis :'); ?></b>  Dx1 Dx2 Dx3 Dx4</li>
                    <li class="pull-right">
                        Last Dx Date : 10/04/2559
                        <?=
                        Html::a('<i class="glyphicon glyphicon-list-alt"></i>' . 'Detail', ['ardetail', 'vn' => $profile['pt_visit_number']], ['role' => 'modal-remote', 'class' => 'btn btn-info  btn-xs']) . ' '
                        . Html::a('<i class="glyphicon glyphicon-plus"></i>' . 'Add', ['ardetail', 'vn' => $profile['pt_visit_number']], ['role' => 'modal-remote', 'class' => 'btn btn-success  btn-xs'])
                        ?>
                        &nbsp;
                    </li>
                </ul>
            </div>
        </div>
        <p></p>
    </div>
    <!-- /Profile Detail -->
    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <!-- /สิทธิการรักษา -->

            <!-- Drug Allergic -->
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 stats-col" style="border-left: 1px solid #ddd">
                <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL,'id' => 'form-header-cpoe']); ?>

                <div class="form-group">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'cpoe_num')->textInput(['class' => 'input-sm'])->label('ใบสั่งยาเลขที่') ?>
                    </div>
                    <div class="col-sm-6">
                        <?=
                        $form->field($model, 'cpoe_date')->widget(DatePicker::classname(), [
                            'language' => 'th',
                            'dateFormat' => 'dd/MM/yyyy',
                            'clientOptions' => [
                                'changeMonth' => true,
                                'changeYear' => true,
                            ],
                            'options' => [
                                'class' => 'form-control input-sm',
                            //'disabled' => true,
                            ],
                        ])->label('วันที่')
                        ?>  
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <?=
                        $form->field($model, 'cpoe_order_by')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(VwUserprofile::find()->select(['user_id', 'User_name'])->where(['User_position' => '6'])->all(), 'user_id', 'User_name'),
                            'pluginOptions' => ['allowClear' => true],
                            'options' => ['placeholder' => 'เลือกแพทย์...',],
                            'size' => Select2::SMALL,
                        ])->label('แพทย์');
                        ?>
                    </div>
                </div>
                <?php if ($model['cpoe_type'] == '1012') : ?>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <?=
                            $form->field($model, 'pt_trp_regimen_paycode', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Select', ['select-protocol'], ['class' => 'btn btn-default btn-sm protocal', 'role' => 'modal-remote']),
                                        'asButton' => true
                                    ]
                                ],
                            ])->textInput(['class' => 'input-sm'])->label('รหัสเบิกจ่าย');
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($model, 'pt_trp_regimen_name')->textInput(['class' => 'input-sm'])->label('Regimen'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <?= $form->field($model, 'chemo_cycle_seq')->textInput(['class' => 'input-sm'])->label('Cycle'); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'chemo_cycle_day')->textInput(['class' => 'input-sm'])->label('Day'); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'pt_cpr_number')->textInput(['class' => 'input-sm'])->label('CPR'); ?>
                        </div>
                        <div class="col-sm-3">
                            <?= $form->field($model, 'pt_ocpa_number')->textInput(['class' => 'input-sm'])->label('OCPA'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="form-group">
                    <div class="col-sm-1">
                        <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput() ?>
                        <?= $form->field($model, 'cpoe_comment', ['showLabels' => false])->hiddenInput() ?>

                    </div>
                    <?= $form->field($model, 'pt_vn_number', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_type', ['showLabels' => false])->hiddenInput() ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
            <!-- /Drug Allergic -->
        </div>
    </div>
</div>

