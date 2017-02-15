<?php

use kartik\widgets\Select2;
use app\modules\drugorder\models\VwSigCode;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\drugorder\models\Tbcpoeperiodunit;
use app\modules\drugorder\models\Tbcpoeprnreason;
use kartik\widgets\TimePicker;
use yii\jui\DatePicker;
use kartik\checkbox\CheckboxX;
use yii\helpers\Url;
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'id' => 'form_cpoedetail',
            'method' => 'post',
            //'enableAjaxValidation' => true,
            'action' => Url::to(['save-detailcpoe']),
        ]);
?>
<!-- Begin Row -->
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h5 class="success"><b><?= Html::encode('Drug Instruction :') ?></b></h5>
        <!-- Begin Well -->
        <div class="well">
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_sig_code', ['label' => '<b>SIG</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?=
                        $form->field($model, 'cpoe_sig_code', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(VwSigCode::find()->all(), 'cpoe_sig_code', 'sig_code'),
                            'options' => ['placeholder' => 'Select Sigcode ...'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>  
            </div>

            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"><?= Html::decode('<b>Route</b>') ?></label>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <span>&nbsp;</span><a href="#" id="routeid" data-type="select"  data-pk="1" data-url="index.php?r=/cpoe/drugorder/route" data-title="Select Route"><?= !empty($route->DrugRouteName) ? $route->DrugRouteName : ''; ?></a>
                    </div>
                    <label class="col-sm-3 control-label no-padding-right"><?= Html::decode('<b>Route Advice</b>') ?></label>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <a href="#" id="routeadviceid" data-type="select" data-pk="" data-url="index.php?r=/cpoe/drugorder/route-advice" data-title="Select Route Advice"><?= !empty($route->DrugPrandialAdviceDesc) ? $route->DrugPrandialAdviceDesc : ''; ?></a>
                    </div>
                </div>
            </div>
            <p></p>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"><?= Html::decode('<b>Dose</b>') ?></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'cpoe_doseqty', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>  
                    </div>
                    <label class="col-sm-1 control-label no-padding-right text-left"><span id="disunitontable"></span></label>
                    <div class="col-xs-12 col-sm-6 col-md-0">

                    </div>
                </div>
            </div>
            <p></p>
            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_iv_driprate', ['label' => '<b>Drip Rate</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'cpoe_iv_driprate', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>  
                    </div>
                    <label class="col-sm-1 control-label no-padding-right text-left">mL/Hr</label>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <div class="checkbox"><label><input type="checkbox"  id="inputPRN" <?= !empty($model->cpoe_prn_reason) ? 'checked=""' : ''; ?>/><span class="text"><b>PRN</b></span></label></div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <?=
                        $form->field($model, 'cpoe_prn_reason', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tbcpoeprnreason::find()->all(), 'cpoe_prnreason_decs', 'cpoe_prnreason_decs'),
                            'options' => ['placeholder' => 'Select Reason ...', 'multiple' => false],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'tags' => true,
                                'maximumInputLength' => 10
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
        </div><!-- End Well -->
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h5 class="success"><b><?= Html::encode('') ?></b></h5>
        <br/>
        <p></p>
        <div id="msg" class="alert-error"></div>
        <!-- Begin Well -->
        <div class="well">
            <div id="table_detailonselect">
                <table class="default kv-grid-table table table-hover table-condensed dataTable no-footer dtr-inline" id="tbdetailonselect">

                    <tbody>
                        <tr>
                            <td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">
                                <b><?= Html::encode('ItemDetail ') ?></b>
                            </td>
                            <td class="fixed-column" style="width:100%;vertical-align: middle;">
                                <div id="textdetails"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">
                                <b><?= Html::encode('วิธีใช้ยา ') ?></b>
                            </td>
                            <td class="fixed-column" style="width:100%;vertical-align: middle;">
                                <a href="#" data-type="textarea" class="myeditable" id="item_comment1" data-pk="<?= $model['cpoe_ids'] ?>"><?= $model['Item_comment1'] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">
                                <b><?= Html::encode('คำเตือน! ') ?></b>
                            </td>
                            <td class="fixed-column" style="width:100%;vertical-align: middle;">
                                <a href="#" data-type="textarea" class="myeditable" id="item_comment2" data-pk="<?= $model['cpoe_ids'] ?>"><?= $model['Item_comment2'] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="fixed-column text-right" style="padding: 0 10px;vertical-align: middle;">
                                <b><?= Html::encode('สรรพคุณ ') ?></b>
                            </td>
                            <td class="fixed-column" style="width:100%;vertical-align: middle;">
                                <a href="#" data-type="textarea" class="myeditable" id="item_comment3" data-pk="<?= $model['cpoe_ids'] ?>"><?= $model['Item_comment3'] ?></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Well -->
    </div>

</div><!-- End Row -->

<!-- Begin Row -->
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6">
        <h5 class="success"><b><?= Html::encode('Schedule :') ?></b></h5>
        <!-- Begin Well -->
        <div class="well">
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
                            <a href="javascript:void(0);" class="btn btn-default btn-sm day" id="7d">7d</a>
                            <a href="javascript:void(0);" class="btn btn-default btn-sm day" id="30d">30d</a>
                            <a href="javascript:void(0);" class="btn btn-default btn-sm day" id="60d">60d</a>
                            <a href="javascript:void(0);" class="btn btn-default btn-sm day" id="90d">90d</a>
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
                            'data' => ArrayHelper::map(Tbcpoeperiodunit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
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
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right text-right"></label>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <div class="radio">
                            <label><input type="radio" name="once" id="Onceradio" <?= !empty($model->cpoe_once) ? 'checked=""' : ''; ?> class="colored-success"><span class="text">Once</span></label>
                            <span>&nbsp;&nbsp;&nbsp;&nbsp;</span><label><input type="radio" name="once" id="Repeatradio" class="colored-success" <?= !empty($model->cpoe_repeat) ? 'checked=""' : ''; ?>><span class="text">Repeat</span></label>
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
                            <label><input type="radio" id="frequencyday" name="frequency"  <?= !empty($model->cpoe_frequency) ? 'checked=""' : ''; ?> class="colored-success"><span class="text">Frequency</span></label>
                        </div>
                    </div>
                    <p></p>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <?= $form->field($model, 'cpoe_frequency_value', ['showLabels' => false])->textInput(['style' => 'background-color: white']) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?=
                        $form->field($model, 'cpoe_frequency_unit', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Tbcpoeperiodunit::find()->all(), 'cpoe_period_unit_id', 'cpoe_period_unit_decs'),
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
        </div><!-- End Well -->
        <!-- Begin Row -->
        <div class="row">
            <div class="form-group">
                <div class="col-xs-12 col-sm-6 col-md-8">
                    <input type="hidden" id="inputroute" value="<?= !empty($route->TMTID_GPU) ? $route->TMTID_GPU : ''; ?>">
                    <input type="hidden" id="inputrouteadvice" value="<?= !empty($route->DrugPrandialAdviceID) ? $route->DrugPrandialAdviceID : ''; ?>">
                    <?=
                    $form->field($model, 'cpoe_ids', ['showLabels' => false])->hiddenInput([
                        'value' => empty($model->cpoe_ids) ? time() : $model->cpoe_ids
                    ])
                    ?>
                    <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput(['value' => $cpoeid]) ?>
                    <?= $form->field($model, 'Item_comment3', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'Item_comment1', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'Item_comment2', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'ItemPrice', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_route_id', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_drugprandialadviceid', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_Itemtype', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_narcotics_confirmed', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'ised', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_once', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_repeat', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_frequency', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'cpoe_dayrepeat', ['showLabels' => false])->hiddenInput() ?>
                    <?= $form->field($model, 'ised_reason', ['showLabels' => false])->hiddenInput() ?>
                </div>
            </div>
        </div><!-- End Row -->
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
        <h5 class="success"><b><?= Html::encode('Dispense Qty : ') ?></b><?= Html::a('<i class="fa fa-calculator"></i> คำนวณ','#',['onclick' => 'CalculateQty(this);','class' => 'btn btn-sm btn-primary']); ?> <div id="msgqty" class="alert-error"></div><!-- Alert Message --></h5>
        
        <!-- Begin Well -->
        <div class="well">
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <?=
                    $form->field($model, 'ItemQty', ['showLabels' => false])->textInput([
                        'style' => [
                            'height' => '50px',
                            'font-size' => '35pt',
                            'text-align' => 'right',
                            'background-color' => 'white',
                            'width' => '100%'
                        ],
                        'class' => 'form-control',
                        'value' => number_format($model['ItemQty'], 2)
                    ])
                    ?>
                </div>
            </div><!-- End Row -->
            <!-- Begin Row -->
            <div class="row">
                <div class="form-group">
                    <table style="width: 100%">
                        <tbody>
                            <tr>
                                <td style="font-size: 14pt;width: 40%;text-align: right;"><b>เบิกได้ :</b></td>
                                <td style="font-size: 14pt;width: 60%;text-align: right;">100,000.00 <b>บาท</b></td>
                            </tr>
                            <tr>
                                <td style="font-size: 14pt;width: 40%;text-align: right;"><b>เบิกไม่ได้ :</b></td>
                                <td style="font-size: 14pt;width: 60%;text-align: right;">100,000.00 <b>บาท</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- End Row -->
        </div><!-- End Well -->
    </div>
</div><!-- End Row -->
<!-- Begin Row -->
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-12">
        <div class="form-group" style="text-align: right;">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-success" id="btnSaveDetailcpoe">Save</button>
        </div>
    </div>
</div>
<!-- End Row -->

<?php if (!Yii::$app->request->isAjax) { ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php } ?>

<?php ActiveForm::end(); ?>

<script>

    $("a[id=7d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=7d]').addClass('active');
        $('#tbcpoedetail-cpoe_period_value').val('7');
        $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=30d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=30d]').addClass('active');
        $('#tbcpoedetail-cpoe_period_value').val('30');
        $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=60d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=60d]').addClass('active');
        $('#tbcpoedetail-cpoe_period_value').val('60');
        $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");
    });
    $("a[id=90d]").click(function () {
        $('a.day').removeClass('active');
        $('a[id=90d]').addClass('active');
        $('#tbcpoedetail-cpoe_period_value').val('90');
        $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");
    });
    //Submit From
    $('#btnSaveDetailcpoe').click(function (e) {
        var frm = $('#form_cpoedetail');
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
                $.pjax({container: '#pjax-tbcpoedetails'});
                //swal("Save Complete!", "", "success");

            }
        });
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
                            $("#tbcpoedetail-cpoe_frequency_unit").select2("val", "");//Reset Select2
                            $('input[id=tbcpoedetail-cpoe_frequency_value]').val(null);//SetValueNull
                            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
                            document.getElementById("frequencyday").checked = false;//UnChecked Frequency
                            //Day
                            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
                            $('input.dayweek').val(null);//SetValueNull
                            document.getElementById("frequencydayrepeat").checked = false;//UnChecked Day
                            document.getElementById("cpoe_dayrepeat_sun").checked = false;//UnChecked Sun
                            document.getElementById("cpoe_dayrepeat_mon").checked = false;//UnChecked Mon
                            document.getElementById("cpoe_dayrepeat_tue").checked = false;//UnChecked Tue
                            document.getElementById("cpoe_dayrepeat_wed").checked = false;//UnChecked Wed
                            document.getElementById("cpoe_dayrepeat_thu").checked = false;//UnChecked Thu
                            document.getElementById("cpoe_dayrepeat_fri").checked = false;//UnChecked Fri
                            document.getElementById("cpoe_dayrepeat_sat").checked = false;//UnChecked Sat    

                            $('input[id=tbcpoedetail-cpoe_once]').val('1');//SetValue
                            $('input[id=tbcpoedetail-cpoe_repeat]').val(null);//SetValue
                        } else {
                            document.getElementById("Onceradio").checked = false;
                            document.getElementById("Repeatradio").checked = true;
                        }
                    });
        } else {
            $('input[id=tbcpoedetail-cpoe_repeat]').val(null);//SetValue
        }
    });
    /* FN ในกรณีที่เลือก Repeat ใน tab วิธีการใช้ยา */
    $("input[id=Repeatradio]").click(function () {
        $('div.frequencyday').css('display', 'block');
        if ($(this).is(":checked"))
        {
            $('input[id=tbcpoedetail-cpoe_repeat]').val('1');//SetValue
            $('input[id=tbcpoedetail-cpoe_once]').val(null);//SetValue
        } else {
            $('input[id=tbcpoedetail-cpoe_once]').val(null);//SetValue
        }
    });
    /* FN Checkbox PRN */
    $("input[id=inputPRN]").click(function () {
        if ($(this).is(":checked"))
        {
            document.getElementById("tbcpoedetail-cpoe_prn_reason").disabled = false;//กรณีเลือก PRN
        } else {
            document.getElementById("tbcpoedetail-cpoe_prn_reason").disabled = true;//กรณีไม่เลือก PRN
        }
    });
    /* FN ในกรณีที่เลือก Frequency ใน tab วิธีการใช้ยา */
    $("input[id=frequencyday]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=tbcpoedetail-cpoe_frequency]').val('1');//SetValue
            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
            DisableFrequency();
            RemoveDisabledFrequency();
        } else {
            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
        }
    });

    /* FN ในกรณีที่เลือก Day ใน tab วิธีการใช้ยา */
    $("input[id=frequencydayrepeat]").click(function () {
        if ($(this).is(":checked"))
        {
            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val('1');//SetValue
            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
            DisabledDayweek();
            RemoveDisabledDayweek();
        } else {
            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
        }
    });
    /* FN Disabled Checkbox Between Sun - Sat */
    function DisableFrequency(){
        $('input.dayweek').attr('disabled', true);
    }
    /* FN Disabled */
    function DisabledDayweek(){
        document.getElementById("tbcpoedetail-cpoe_frequency_unit").disabled = true;
        $('#tbcpoedetail-cpoe_frequency_value').attr('readonly', true);
    }
    
    function RemoveDisabledFrequency(){
        document.getElementById("tbcpoedetail-cpoe_frequency_unit").disabled = false;
        $('#tbcpoedetail-cpoe_frequency_value').attr('readonly', false);
    }
    
    function RemoveDisabledDayweek(){
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
    function CalculateQty(){
        var frm = $('#form_cpoedetail');
        $.ajax({
            type: frm.attr('method'),
            url: 'index.php?r=cpoe/drugorder/calculate-qty',
            data: frm.serialize(),
            dataType: "JSON",
            success: function (data) {
                $('input[id=tbcpoedetail-itemqty]').val(data);
                var msg = 'Calculated!';
                $('#msgqty').addClass('alert-success').removeClass('alert-error').html(msg).show();
                setTimeout(function () {
                    $('#msgqty').addClass('alert-error').removeClass('alert-success').html('').hide();
                }, 1000);
            }
        });
    }
</script>