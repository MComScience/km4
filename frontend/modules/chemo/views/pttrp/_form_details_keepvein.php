<?php

use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\checkbox\CheckboxX;
use kartik\widgets\TimePicker;
use yii\jui\DatePicker;
#models
use app\modules\chemo\models\VwSigCode;
use app\modules\chemo\models\TbCpoePrnReason;
use app\modules\chemo\models\TbCpoePeriodUnit;
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'id' => 'form_drugsetdetail',
            'method' => 'post',
            //'enableAjaxValidation' => true,
            'action' => Url::to(['save-drugsetdetail']),
        ]);
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('ItemDetail :') ?></b>
        </h5>

        <ul class="list-group">
            <li class="list-group-item" style="border: 0px solid white;background-color: #fbfbfb;">
                <span class="text"><text class="itemdetail"></text></span>
            </li>
        </ul>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h5 class="success"><b><?= Html::encode('Drug Instruction :') ?></b></h5>
        <div class="well">

            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"><?= Html::decode('<b>จำนวน</b>') ?></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'cpoe_doseqty', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>  
                    </div>
                    <label class="col-sm-1 control-label no-padding-right text-left"><span class="disunitontable"></span></label>
                    <div class="col-xs-12 col-sm-6 col-md-0">

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_route_id', ['label' => '<b>Route</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8"><div id="drugroutename"></div></div>
                </div>
            </div>
            <p></p>
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_drugprandialadviceid', ['label' => '<b>Route Advice</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8"><div id="drugrouteadvicename"></div></div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_iv_driprate', ['label' => '<b>Drip Rate</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'cpoe_iv_driprate', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>  
                    </div>
                    <label class="col-sm-1 control-label no-padding-right text-left"><?= Html::encode('mL/Hr'); ?></label>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_sig_code', ['label' => '<b>SIG</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?=
                        $form->field($model, 'cpoe_sig_code', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(VwSigCode::find()->all(), 'cpoe_sig_code', 'sig_code_ip'),
                            'options' => ['placeholder' => 'Select Sigcode ...',],
                            'pluginOptions' => ['allowClear' => true],
                        ]);
                        ?>
                    </div>
                </div>  
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'Item_comment2', ['label' => '<b>คำเตือน</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'Item_comment2', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>
                    </div>
                </div>  
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'Item_comment3', ['label' => '<b>สรรพคุณ</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'Item_comment3', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>
                    </div>
                </div>  
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox"  id="inputPRN" <?= !empty($model->cpoe_prn_reason) ? 'checked=""' : ''; ?>/>
                                <span class="text"><b><?= Html::encode('PRN'); ?></b></span>
                            </label>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?=
                        $form->field($model, 'cpoe_prn_reason', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbCpoePrnReason::find()->all(), 'cpoe_prnreason_decs', 'cpoe_prnreason_decs'),
                            'options' => ['placeholder' => 'Select Reason ...', 'multiple' => false,],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'Item_comment4', ['label' => '<b>Special Instruction</b>', 'class' => 'col-sm-2 control-label no-padding-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'Item_comment4', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6">
        <h5 class="success"><b><?= Html::encode('Schedule :') ?></b></h5>

        <div class="well">
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <div class="btn-group btn-group-justified">
                            <a class="btn btn-default btn-sm <?= $model['cpoe_rxordertype'] == '1' ? 'active' : null; ?>" id="orderoneday1"><?= Html::encode('Oder One Day'); ?></a>
                            <a class="btn btn-default btn-sm <?= $model['cpoe_rxordertype'] == '2' ? 'active' : null; ?>" id="orderoneday2"><?= Html::encode('Order for continuation'); ?></a>
                        </div>
                    </div>
                </div>
            </div><!-- End Row -->
            <p></p>
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?php
                        echo $form->field($model, 'cpoe_stat', [
                            'template' => '{input}{label}{error}{hint}',
                            'labelOptions' => ['class' => 'cbx-label'],
                        ])->widget(CheckboxX::classname(), [
                            'autoLabel' => false,
                            'pluginOptions' => [
                                'size' => 'sm',
                                'threeState' => false,
                            ],
                            'options' => [
                                'data-toggle' => 'checkbox-x'
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- End Row -->
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <div class="btn-group btn-group-justified">
                            <?= Html::a('7d', 'javascript:void(0);', ['class' => 'btn btn-default btn-sm day', 'id' => '7d']) ?>
                            <?= Html::a('14d', 'javascript:void(0);', ['class' => 'btn btn-default btn-sm day', 'id' => '14d']) ?>
                            <?= Html::a('21d', 'javascript:void(0);', ['class' => 'btn btn-default btn-sm day', 'id' => '21d']) ?>
                            <?= Html::a('28d', 'javascript:void(0);', ['class' => 'btn btn-default btn-sm day', 'id' => '28d']) ?>
                            <?= Html::a('60d', 'javascript:void(0);', ['class' => 'btn btn-default btn-sm day', 'id' => '60d']) ?>
                            <?= Html::a('90d', 'javascript:void(0);', ['class' => 'btn btn-default btn-sm day', 'id' => '90d']) ?>
                        </div>
                    </div>
                </div>
            </div><!-- End Row -->
            <p></p>
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_period_value', ['label' => '<b>ระยะเวลา</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?= $form->field($model, 'cpoe_period_value', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'type' => 'number']) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?=
                        $form->field($model, 'cpoe_period_unit', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbCpoePeriodUnit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
                            'options' => ['placeholder' => 'Select State...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- End Row -->

            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <div class="radio">
                            <label>
                                <input type="radio" name="once" id="Onceradio" <?= !empty($model->cpoe_once) ? 'checked=""' : ''; ?> class="colored-success">
                                <span class="text"><?= Html::encode('Every day'); ?></span>
                            </label>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <label>
                                <input type="radio" name="once" id="Repeatradio" class="colored-success" <?= !empty($model->cpoe_repeat) ? 'checked=""' : ''; ?>>
                                <span class="text"><?= Html::encode('Repeat'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div><!-- End Row -->
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group frequencyday" style="display: <?= !empty($model->cpoe_frequency) || !empty($model->cpoe_dayrepeat) ? 'block' : 'none'; ?>;">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="radio">
                            <label>
                                <input type="radio" id="frequencyday" name="frequency"  <?= !empty($model->cpoe_frequency) ? 'checked=""' : ''; ?> class="colored-success">
                                <span class="text"><?= Html::encode('Frequency'); ?></span>
                            </label>
                        </div>
                    </div>

                    <p></p>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= $form->field($model, 'cpoe_frequency_value', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?=
                        $form->field($model, 'cpoe_frequency_unit', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbCpoePeriodUnit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
                            'options' => ['placeholder' => 'Select State...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- End Row -->
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group frequencyday" style="display: <?= !empty($model->cpoe_frequency) || !empty($model->cpoe_dayrepeat) ? 'block' : 'none'; ?>;">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-10">
                        <div class="radio">
                            <label><input type="radio" name="frequency" id="frequencydayrepeat" class="colored-success" <?= !empty($model->cpoe_dayrepeat) ? 'checked=""' : ''; ?> ><span class="text">Day</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_sun'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_sun" name="cpoe_dayrepeat_sun"><span class="text">Sun</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_mon'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_mon" name="cpoe_dayrepeat_mon"><span class="text">Mon</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_tue'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_tue" name="cpoe_dayrepeat_tue"><span class="text">Tue</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_wed'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_wed" name="cpoe_dayrepeat_wed"><span class="text">Wen</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_thu'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_thu" name="cpoe_dayrepeat_thu"><span class="text">Thu</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_fri'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_fri" name="cpoe_dayrepeat_fri"><span class="text">Fri</span></label>
                            <label><input class="colored-success dayweek" type="checkbox" <?= $model['cpoe_dayrepeat_sat'] == 1 ? 'checked=""' : ''; ?> id="cpoe_dayrepeat_sat" name="cpoe_dayrepeat_sat"><span class="text">Sat</span></label>
                        </div>
                    </div>
                </div>
            </div><!-- End Row -->

            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"><?= Html::encode('วงรอบการให้ยา'); ?></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <input id="showsig_code_ip" class="form-control bg-white" type="text" readonly=""/>
                    </div>
                </div>
            </div>

            <p></p>

            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_begindate', ['label' => '<b>วันเริ่ม</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?=
                        $form->field($model, 'cpoe_begindate', ['showLabels' => false])->widget(DatePicker::classname(), [
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
                    <?= Html::activeLabel($model, 'cpeo_begintime', ['label' => '<b>เวลา</b>', 'class' => 'col-sm-1 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?php
                        echo $form->field($model, 'cpeo_begintime', ['showLabels' => false])->widget(TimePicker::classname(), [
                            'pluginOptions' => [
                                'showSeconds' => true,
                                'showMeridian' => false,
                                'defaultTime' => '00:00',
                                'minuteStep' => 1,
                                'secondStep' => 5,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- End Row -->
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_enddate', ['label' => '<b>สิ้นสุด</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?=
                        $form->field($model, 'cpoe_enddate', ['showLabels' => false])->widget(DatePicker::classname(), [
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
                    <?= Html::activeLabel($model, 'cpoe_endtime', ['label' => '<b>เวลา</b>', 'class' => 'col-sm-1 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?php
                        echo $form->field($model, 'cpoe_endtime', ['showLabels' => false])->widget(TimePicker::classname(), [
                            'pluginOptions' => [
                                'showSeconds' => true,
                                'showMeridian' => false,
                                'defaultTime' => '00:00',
                                'minuteStep' => 1,
                                'secondStep' => 5,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- End Row -->
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_seq_mindelay', ['label' => '<b>Sequential Delay(min)</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'cpoe_seq_mindelay', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'type' => 'number', 'value' => !empty($model['cpoe_seq_mindelay']) ? $model['cpoe_seq_mindelay'] : '0']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        <div class="col-xs-12 col-sm-6 col-md-8">
            <input type="hidden" id="inputroute" value="<?= !empty($route->TMTID_GPU) ? $route->TMTID_GPU : ''; ?>">
            <input type="hidden" id="inputrouteadvice" value="<?= !empty($route->DrugPrandialAdviceID) ? $route->DrugPrandialAdviceID : ''; ?>">
            <?=
            $form->field($model, 'drugset_ids', ['showLabels' => false])->hiddenInput([
                'value' => empty($model->drugset_ids) ? time() : $model->drugset_ids
            ])
            ?>
            <?= $form->field($model, 'drugset_id', ['showLabels' => false])->hiddenInput(['value' => !empty($model['drugset_id']) ? $model['drugset_id'] : $drugsetid]) ?>
            <?= $form->field($model, 'chemo_regimen_ids', ['showLabels' => false])->hiddenInput(['value' => $regimen_ids]) ?>
            <?= $form->field($model, 'ItemPrice', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_route_id', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_drugprandialadviceid', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_Itemtype', ['showLabels' => false])->hiddenInput(['value' => '21']) ?>
            <?= $form->field($model, 'cpoe_narcotics_confirmed', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ised', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_once', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_repeat', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_frequency', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_dayrepeat', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'ised_reason', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_rxordertype', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'cpoe_ItemStatus', ['showLabels' => false])->hiddenInput() ?>
            <?= $form->field($model, 'Item_comment1', ['showLabels' => false])->hiddenInput(['style' => 'background-color: white']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Dispense Qty : ') ?></b>
            <text style="color: red">*</text><text style="color: black"><?= Html::encode('สามารถกำหนดปริมาณได้'); ?></text>
            <div id="msgqty" class="alert-error"></div><!-- Alert Message -->
        </h5>
        <!-- Begin Well -->
        <div class="well">
            <!-- Begin Row -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <table style="width: 100%" border="0">
                            <tbody>
                                <tr>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><b><?= Html::encode('เป็นเงิน'); ?></b></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><b><?= Html::encode('เบิกได้'); ?></b></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><b><?= Html::encode('เบิกไม่ได้'); ?></b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;"><span id="showItem_Total_Amt" class="showItem_Total_Amt"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Cr_Amt" class="showItem_Cr_Amt"></span></td>
                                    <td style="font-size: 12pt;width: 33.33%;text-align: center;border-left: 1px solid black;"><span id="showItem_Pay_Amt" class="showItem_Pay_Amt"></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <div class="form-group">
                        <?=
                        $form->field($model, 'ItemQty', ['showLabels' => false])->textInput([
                            'style' => [
                                'height' => '40px',
                                'font-size' => '25pt',
                                'text-align' => 'right',
                                'background-color' => 'white',
                                'width' => '100%'
                            ],
                            'class' => 'form-control',
                            'required' => true,
                            'value' => empty($model['ItemQty']) ? null : number_format($model['ItemQty'], 2)
                        ])
                        ?>
                        <span class="pull-right disunitontable"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-1">
                    <p></p>
                    <?= Html::a('Calculate', 'javascript:void(0);', ['onclick' => 'CalculateQty(this);', 'class' => 'btn btn-sm btn-primary']); ?>
                </div>
            </div><!-- End Row -->
        </div><!-- End Well -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <div class="form-group" style="text-align: right;">
            <?= Html::button('<i class="glyphicon glyphicon-chevron-left"></i> ' . 'Prev', ['class' => 'btn btn-default', 'id' => 'backsteb2']) ?>
            <?= Html::button('Close', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-default']); ?>
            <?= Html::button('Save', ['type' => 'button', 'class' => 'btn btn-success', 'id' => 'Savedrugsetdetail']); ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<script>
    $("a[id=7d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=7d]').addClass('active');
        $('#tbdrugsetdetail-cpoe_period_value').val('7');
        $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=14d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=14d]').addClass('active');
        $('#tbdrugsetdetail-cpoe_period_value').val('14');
        $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=21d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=21d]').addClass('active');
        $('#tbdrugsetdetail-cpoe_period_value').val('21');
        $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=28d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=28d]').addClass('active');
        $('#tbdrugsetdetail-cpoe_period_value').val('28');
        $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=60d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=60d]').addClass('active');
        $('#tbdrugsetdetail-cpoe_period_value').val('60');
        $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=90d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=90d]').addClass('active');
        $('#tbdrugsetdetail-cpoe_period_value').val('90');
        $("#tbdrugsetdetail-cpoe_period_unit").val('1').trigger("change");
    });

    //Event เมื่อคลิกที่ปุ่ม Order One Day
    $("a[id=orderoneday1]").click(function () {
        if ($('a[id=orderoneday1]').hasClass('active')) {
            $('a[id=orderoneday1]').removeClass('active');
            $('#tbdrugsetdetail-cpoe_rxordertype').val(null);
        } else {
            $('a[id=orderoneday2]').removeClass('active');
            $('a[id=orderoneday1]').addClass('active');
            $('#tbdrugsetdetail-cpoe_rxordertype').val('1');
        }
    });

    //Event เมื่อคลิกที่ปุ่ม Order for continuation
    $("a[id=orderoneday2]").click(function () {
        if ($('a[id=orderoneday2]').hasClass('active')) {
            $('a[id=orderoneday2]').removeClass('active');
            $('#ttbdrugsetdetail-cpoe_rxordertype').val(null);
        } else {
            $('a[id=orderoneday1]').removeClass('active');
            $('a[id=orderoneday2]').addClass('active');
            $('#tbdrugsetdetail-cpoe_rxordertype').val('2');
        }
    });

    /* FN ในกรณีที่เลือก Repeat ใน tab วิธีการใช้ยา */
    $("input[id=Repeatradio]").click(function () {
        $('div.frequencyday').css('display', 'block');
        if ($(this).is(":checked"))
        {
            $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val('1');//SetValue
            $('input[id=tbdrugsetdetail-cpoe_once]').val(null);//SetValue
        } else {
            $('input[id=tbdrugsetdetail-cpoe_once]').val(null);//SetValue
        }
    });
    /* FN Checkbox PRN */
    $("input[id=inputPRN]").click(function () {
        if ($(this).is(":checked"))
        {
            document.getElementById("tbdrugsetdetail-ised_reason").disabled = false;//กรณีเลือก PRN
        } else {
            document.getElementById("tbdrugsetdetail-ised_reason").disabled = true;//กรณีไม่เลือก PRN
        }
    });
    /* FN ในกรณีที่เลือก Frequency ใน tab วิธีการใช้ยา */
    $("input[id=frequencyday]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=tbdrugsetdetail-cpoe_frequency]').val('1');//SetValue
            $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val(null);//SetValue
            DisableFrequency();
            RemoveDisabledFrequency();
        } else {
            $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val(null);//SetValue
        }
    });
    /* FN Disabled Checkbox Between Sun - Sat */
    function DisableFrequency() {
        $('input.dayweek').attr('disabled', true);
    }
    function RemoveDisabledFrequency() {
        document.getElementById("tbdrugsetdetail-cpoe_frequency_unit").disabled = false;
        $('#tbdrugsetdetail-cpoe_frequency_value').attr('readonly', false);
    }

    /* FN ในกรณีที่เลือก Day ใน tab วิธีการใช้ยา */
    $("input[id=frequencydayrepeat]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val('1');//SetValue
            $('input[id=tbdrugsetdetail-cpoe_frequency]').val(null);//SetValue
            DisabledDayweek();
            RemoveDisabledDayweek();
        } else {
            $('input[id=tbdrugsetdetail-cpoe_frequency]').val(null);//SetValue
        }
    });
    /* FN Disabled */
    function DisabledDayweek() {
        document.getElementById("tbdrugsetdetail-cpoe_frequency_unit").disabled = true;
        $('#tbdrugsetdetail-cpoe_frequency_value').attr('readonly', true);
    }
    function RemoveDisabledDayweek() {
        $('input.dayweek').attr('disabled', false);
    }

    /* วันอาทิตย์ */
    $("input[id=cpoe_dayrepeat_sun]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_sun]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_sun]').val(null);//SetValue
        }
    });
    /* วันจันทร์ */
    $("input[id=cpoe_dayrepeat_mon]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_mon]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_mon]').val(null);//SetValue
        }
    });
    /* วันอังคาร */
    $("input[id=cpoe_dayrepeat_tue]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_tue]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_tue]').val(null);//SetValue
        }
    });
    /* วันพุธ */
    $("input[id=cpoe_dayrepeat_wed]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_wed]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_wed]').val(null);//SetValue
        }
    });
    /* วันพฤหัส */
    $("input[id=cpoe_dayrepeat_thu]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_thu]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_thu]').val(null);//SetValue
        }
    });
    /* วันศุกร์ */
    $("input[id=cpoe_dayrepeat_fri]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_fri]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_fri]').val(null);//SetValue
        }
    });
    /* วันเสาร์ */
    $("input[id=cpoe_dayrepeat_sat]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=cpoe_dayrepeat_sat]').val('1');//SetValue
        } else {
            $('input[id=cpoe_dayrepeat_sat]').val(null);//SetValue
        }
    });

    /* FN คำนวณเม็ดยา  */
    function CalculateQty() {
        var frm = $('#form_drugsetdetail');
        var qty = $('#tbdrugsetdetail-itemqty').val();
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=chemo/pttrp/calculate-qty',
            data: frm.serialize(),
            dataType: "JSON",
            success: function (data) {
                $('input[id=tbdrugsetdetail-itemqty]').val(data);
                CalculateDrugprice();
                var msg = 'Calculated!';
                $('#msgqty').addClass('alert-success').removeClass('alert-error').html(msg).show();
                setTimeout(function () {
                    $('#msgqty').addClass('alert-error').removeClass('alert-success').html('').hide();
                }, 1000);
            }
        });
    }

    function CalculateDrugprice() {
        var ItemID = $('input[id=tbdrugsetdetail-itemid]').val();
        var ItemQty = $('input[id=tbdrugsetdetail-itemqty]').val();
        var pt_visit_number = $('input[id=vwpttrporderset-pt_visit_number]').val();
        $.ajax({
            url: "index.php?r=chemo/pttrp/calculate-drugprice",
            type: "post",
            data: {ItemID: ItemID, ItemQty: ItemQty, pt_visit_number: pt_visit_number},
            dataType: "JSON",
            success: function (data) {
                $('.showItem_Total_Amt').html(data.Item_Total_Amt);//เป็นเงิน
                $('.showItem_Cr_Amt').html(data.Item_Cr_Amt);//เบิกได้
                $('.showItem_Pay_Amt').html(data.Item_Pay_Amt);//เบิกไม่ได้
            }
        });
    }

    //กรณีที่เลือก Route
    $("div[id=drugroutename]").click(function () {
        $('select[id=cat-id]').on('change', function () {
            var TMTID_GPU = $("input[id=inputroute]").val();
            var routeid = $(this).find("option:selected").val();
            if (routeid != '') {
                $.ajax({
                    url: "index.php?r=chemo/pttrp/getroute-select",
                    type: "get",
                    data: {gpu: TMTID_GPU, routeid: routeid},
                    dataType: "JSON",
                    success: function (data) {
                        $('div[id=drugrouteadvicename]').html(data.result1);//routeadvice
                        $("#subcat-id").val('').trigger("change");
                        $('input[id=tbdrugsetdetail-cpoe_route_id]').val(routeid);
                    }
                });
            }
        });
    });

    $("div[id=drugrouteadvicename]").click(function () {
        $('select[id=subcat-id]').on('change', function () {
            var routeadviceid = $(this).find("option:selected").val();
            if (routeadviceid != '') {
                $('input[id=tbdrugsetdetail-cpoe_drugprandialadviceid]').val(routeadviceid);
            }
        });
    });

    /* Click State*/
    $("input[id=tbdrugsetdetail-cpoe_stat]").click(function () {
        if ($(this).val() == '0') {
            dateset();
            $('input[id=tbdrugsetdetail-cpeo_begintime]').val('00:00:00');
        } else {
            $('input[id=tbdrugsetdetail-cpoe_begindate]').val(null);
            $('input[id=tbdrugsetdetail-cpeo_begintime]').val(null);
        }
    });
    //Event เมื่อเลือก SigCode
    $('select[id=tbdrugsetdetail-cpoe_sig_code]').on('change', function () {
        var sigcodeid = $(this).find("option:selected").val();
        var sig_code_ip = $(this).find("option:selected").text();
        if (sigcodeid != '') {
            $('#showsig_code_ip').val(sig_code_ip);//แสดงข้อความวงรอบการให้ยา
            $.ajax({
                url: "index.php?r=chemo/pttrp/changestate-sigcode",
                type: "post",
                data: {id: sigcodeid},
                dataType: "JSON",
                success: function (data) {
                    /* ถ้า state == 1 */
                    if (data.cpoe_stat == '1') {
                        $('div.cbx>span').html('<i class="glyphicon glyphicon-ok"></i>');//Set icon Checked ใน input State
                        $('#tbdrugsetdetail-cpoe_stat').val('1');//Set Value on Input State
                    } else if (data.cpoe_stat == null) {
                        $('#tbdrugsetdetail-cpoe_stat').checkboxX('reset');//Reset Input Checked State
                        $('div.cbx>span').html('');//Set icon Checked ใน input State
                        $('#tbdrugsetdetail-cpoe_stat').val('0');//Set Value on Input State
                    }
                    /* Set ระยะเวลา */
                    $('input[id=tbdrugsetdetail-cpoe_period_value]').val(data.period_value);//Set value ระยะเวลา
                    $("#tbdrugsetdetail-cpoe_period_unit").val(data.period_unit).trigger("change");
                    if (data.cpoe_frequency == '1') {
                        //Repeat
                        document.getElementById("Repeatradio").checked = true;//Set Repeat Checked
                        $('div.frequencyday').css('display', 'block');
                        $('input[id=tbdrugsetdetail-cpoe_repeat]').val('1');//SetValue
                        $('input[id=tbdrugsetdetail-cpoe_once]').val(null);//SetValue

                        document.getElementById("frequencyday").checked = true;//Set Frequency Checked
                        $('input[id=tbdrugsetdetail-cpoe_frequency]').val('1');//SetValue
                        $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val(null);//SetValue
                        $('input[id=tbdrugsetdetail-cpoe_frequency_value]').val(data.frequency_value);//SetValue
                        $("#tbdrugsetdetail-cpoe_frequency_unit").val(data.frequency_unit).trigger("change");
                        DisableFrequency();
                        RemoveDisabledFrequency();
                    } else if (data.cpoe_frequency == null || data.cpoe_frequency == '') {
                        document.getElementById("Repeatradio").checked = false;//Set Repeat Checked

                        document.getElementById("Onceradio").checked = true;//Set Frequency Checked

                        $('div.frequencyday').css('display', 'none');
                        //Frequency
                        $("#tbdrugsetdetail-cpoe_frequency_unit").select2("val", "");//Reset Select2
                        $('input[id=tbdrugsetdetail-cpoe_frequency_value]').val(null);//SetValueNull
                        $('input[id=tbdrugsetdetail-cpoe_frequency]').val(null);//SetValue
                        document.getElementById("frequencyday").checked = false;//UnChecked Frequency
                        //Day
                        $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val(null);//SetValue
                        $('input.dayweek').val(null);//SetValueNull
                        document.getElementById("frequencydayrepeat").checked = false;//UnChecked Day
                        document.getElementById("cpoe_dayrepeat_sun").checked = false;//UnChecked Sun
                        document.getElementById("cpoe_dayrepeat_mon").checked = false;//UnChecked Mon
                        document.getElementById("cpoe_dayrepeat_tue").checked = false;//UnChecked Tue
                        document.getElementById("cpoe_dayrepeat_wed").checked = false;//UnChecked Wed
                        document.getElementById("cpoe_dayrepeat_thu").checked = false;//UnChecked Thu
                        document.getElementById("cpoe_dayrepeat_fri").checked = false;//UnChecked Fri
                        document.getElementById("cpoe_dayrepeat_sat").checked = false;//UnChecked Sat    

                        $('input[id=tbdrugsetdetail-cpoe_once]').val('1');//SetValue
                        $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val(null);//SetValue
                    }
                }
            });
        }
    });
    /* FN ในกรณีที่เลือก Once ใน Tab วิธีการใช้ยา */
    $("input[id=Onceradio]").click(function () {

        if ($(this).is(":checked"))
        {
            swal({
                title: "Are you sure?",
                text: "ค่าต่างๆที่อยู่ในส่วนของ Repeat จะถูกรีเซ็ต!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm!",
                cancelButtonText: "Cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('div.frequencyday').css('display', 'none');
                            //Frequency
                            $("#tbdrugsetdetail-cpoe_frequency_unit").select2("val", "");//Reset Select2
                            $('input[id=tbdrugsetdetail-cpoe_frequency_value]').val(null);//SetValueNull
                            $('input[id=tbdrugsetdetail-cpoe_frequency]').val(null);//SetValue
                            document.getElementById("frequencyday").checked = false;//UnChecked Frequency
                            //Day
                            $('input[id=tbdrugsetdetail-cpoe_dayrepeat]').val(null);//SetValue
                            $('input.dayweek').val(null);//SetValueNull
                            document.getElementById("frequencydayrepeat").checked = false;//UnChecked Day
                            document.getElementById("cpoe_dayrepeat_sun").checked = false;//UnChecked Sun
                            document.getElementById("cpoe_dayrepeat_mon").checked = false;//UnChecked Mon
                            document.getElementById("cpoe_dayrepeat_tue").checked = false;//UnChecked Tue
                            document.getElementById("cpoe_dayrepeat_wed").checked = false;//UnChecked Wed
                            document.getElementById("cpoe_dayrepeat_thu").checked = false;//UnChecked Thu
                            document.getElementById("cpoe_dayrepeat_fri").checked = false;//UnChecked Fri
                            document.getElementById("cpoe_dayrepeat_sat").checked = false;//UnChecked Sat    

                            $('input[id=tbdrugsetdetail-cpoe_once]').val('1');//SetValue
                            $('input[id=tbdrugsetdetail-cpoe_repeat]').val(null);//SetValue
                        } else {
                            document.getElementById("Onceradio").checked = false;
                            document.getElementById("Repeatradio").checked = true;
                        }
                    });
        } else {
            $('input[id=tbdrugsetdetail-cpoe_repeat]').val(null);//SetValue
        }
    });

    //ปุ่มกลับ
    $("button[id=backsteb2]").click(function () {
        if ($('div.isedreason1').css('display') == 'block' || $('div.isedreason2').css('display') == 'block') {
            //Back to Steb 2
            $('#simplewizardstep3').removeClass('active');//AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
            $('div[id=numbersteb3]').html(''); //Setnumber Steb
            $('#content3').removeClass('active');
            $('#content2').addClass('active');
        } else {
            //Back to Steb 1
            $('#simplewizardstep3').removeClass('active');//AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
            $('div[id=numbersteb3]').html(''); //Setnumber Steb
            $('#content3').removeClass('active');
            $('#content1').addClass('active');
        }
    });

    //Submit From
    $('#Savedrugsetdetail').click(function (e) {
        var frm = $('#form_drugsetdetail');
        var qty = $('#tbdrugsetdetail-itemqty').val();
        if (qty == '' || qty == null) {
            swal("กรุณาคำนวณ Dispense!", "", "warning");
        } else {
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
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

                                }
                            });
                    $('#ajaxCrudModal').modal('hide');
                    $.pjax({container: '#drugdetdetail-pjax'});

                }
            });
        }
    });

    /* FN Checkbox PRN */
    $("input[id=inputPRN]").click(function () {
        if ($(this).is(":checked"))
        {
            document.getElementById("tbdrugsetdetail-cpoe_prn_reason").disabled = false;//กรณีเลือก PRN
        } else {
            document.getElementById("tbdrugsetdetail-cpoe_prn_reason").disabled = true;//กรณีไม่เลือก PRN
        }
    });
</script>
