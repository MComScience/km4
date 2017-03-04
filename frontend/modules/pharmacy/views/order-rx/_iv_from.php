<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\pharmacy\models\VwCpoeDrugadmitDefault;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use app\modules\pharmacy\models\VwSigCode;
use app\modules\pharmacy\models\TbCpoePrnReason;
use app\modules\pharmacy\models\TbCpoePeriodUnit;
use yii\jui\DatePicker;
use kartik\widgets\TimePicker;
use app\modules\pharmacy\models\TbDrugroute;
?>
<?php
$form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_VERTICAL,
            'id' => 'form_cpoeiv',
            'method' => 'post',
            'action' => Url::to(['save-cpoedetail']),
        ]);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Base Solution</h3>
            </div>
            <div class="panel-body">
                <div id="detailsBaseSolution">
                    <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbBasesolution">
                        <thead>
                            <tr>
                                <th style="text-align: center;">
                                    รหัสสินค้า
                                </th>
                                <th style="text-align: center;">
                                    รายการ
                                </th>
                                <th style="text-align: center;">
                                    ปริมาณ
                                </th>
                                <?php /*
                                <th style="text-align: center;">
                                    ราคา/หน่วย
                                </th>
                                <th style="text-align: center;">
                                    เบิกได้
                                </th>
                                <th style="text-align: center;">
                                    เบิกไม่ได้
                                </th>*/?>
                                <th style="text-align: center;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($query1 as $v) : ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php echo $v['ItemID']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                        <?php echo $v['ItemDetail']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $v['ItemQty1']; ?>
                                    </td>
                                    <?php /*
                                    <td style="text-align: right;">
                                        <?php echo $v['ItemPrice']; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $v['Item_Cr_Amt_Sum']; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $v['Item_Pay_Amt_Sum']; ?>
                                    </td>*/?>
                                    <td style="text-align: center;white-space: nowrap;">
                                        <?= Html::a('Edit', false, ['class' => 'btn btn-primary btn-xs','onclick' => 'EditByType(this);','ids' => $v['cpoe_ids'],'item-type' => 41,'title-modal' => 'Base Solution']) ?>
                                        <?= Html::a('Delete', false, ['class' => 'btn btn-danger btn-xs', 'onclick' => 'DeleteSubparent(' . $v['cpoe_ids'] . ');']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Drug Additive</h3>
            </div>
            <div class="panel-body">
                <div id="detailsDrugAdditive">
                    <table class="table table-bordered table-striped table-condensed flip-content" width="100%" id="tbDrugAdditive">
                        <thead>
                            <tr>
                                <th style="text-align: center;">
                                    รหัสสินค้า
                                </th>
                                <th style="text-align: center;">
                                    รายการ
                                </th>
                                <th style="text-align: center;">
                                    ปริมาณ
                                </th>
                                <?php /*
                                <th style="text-align: center;">
                                    ราคา/หน่วย
                                </th>
                                <th style="text-align: center;">
                                    เบิกได้
                                </th>
                                <th style="text-align: center;">
                                    เบิกไม่ได้
                                </th>*/?>
                                <th style="text-align: center;">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($query2 as $v) : ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php echo $v['ItemID']; ?>
                                    </td>
                                    <td style="text-align: left;">
                                        <?php echo $v['ItemDetail']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $v['ItemQty1']; ?>
                                    </td>
                                    <?php /*
                                    <td style="text-align: right;">
                                        <?php echo $v['ItemPrice']; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $v['Item_Cr_Amt_Sum']; ?>
                                    </td>
                                    <td style="text-align: right;">
                                        <?php echo $v['Item_Pay_Amt_Sum']; ?>
                                    </td>*/?>
                                    <td style="text-align: center;white-space: nowrap;">
                                        <?= Html::a('Edit', false, ['class' => 'btn btn-primary btn-xs','onclick' => 'EditByType(this);','ids' => $v['cpoe_ids'],'item-type' => 42,'title-modal' => 'Additive']) ?>
                                        <?= Html::a('Delete', false, ['class' => 'btn btn-danger btn-xs', 'onclick' => 'DeleteSubparent(' . $v['cpoe_ids'] . ');']) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6">
        <h5 class="success"><b><?= Html::encode('Drug Instruction :') ?></b></h5>
        <div class="well">

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_doseqty', ['label' => 'จำนวน', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'cpoe_doseqty', ['showLabels' => false])->textInput([
                            'value' => empty($model['cpoe_doseqty']) ? '1' : $model['cpoe_doseqty'],
                            'style' => 'background-color: white',
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?= Html::label($Item['DispUnit'], 'DispUnit', ['class' => 'text']) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_route_id', ['label' => 'Route', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->field($model, 'cpoe_route_id', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbDrugroute::find()->all(), 'DrugRouteID', 'DrugRouteName'),
                            'language' => 'en',
                            'options' => ['placeholder' => '----- Select Route -----'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?php echo Html::hiddenInput('input-type-2', $Item['TMTID_GPU'], ['id' => 'input-tmtid-gpu']); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_drugprandialadviceid', ['label' => 'Route Advice', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?php
                        echo $form->field($model, 'cpoe_drugprandialadviceid', ['showLabels' => false])->widget(DepDrop::classname(), [
                            'data' => [$adviceid],
                            'options' => ['placeholder' => '----- Select Route Advice -----'],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['tbcpoedetail-cpoe_route_id'],
                                'url' => Url::to(['child-route-advice', 'id' => '2']),
                                'loadingText' => 'Loading...',
                                'params' => ['input-tmtid-gpu']
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_iv_driprate', ['label' => 'Drip Rate', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'cpoe_iv_driprate', ['showLabels' => false])->textInput([
                            'style' => 'background-color: white',
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                        <?= Html::label('mL/Hr', 'mL/Hr', ['class' => 'text']) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_sig_code', ['label' => 'SIG', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'cpoe_sig_code', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(VwSigCode::find()->all(), 'cpoe_sig_code', 'sig_code_ip'),
                            'options' => ['placeholder' => '----Select Sigcode----',],
                            'pluginOptions' => ['allowClear' => true],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'Item_comment2', ['label' => 'คำเตือน', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'Item_comment2', ['showLabels' => false])->textInput([
                            'value' => $Item['DrugPrecaution_lable'],
                            'style' => 'background-color: white',
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'Item_comment3', ['label' => 'สรรพคุณ', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'Item_comment3', ['showLabels' => false])->textInput([
                            'value' => $Item['DrugIndication_lable'],
                            'style' => 'background-color: white',
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="form-group">
                    <div class="col-sm-2 text-align-right">
                        <div class="checkbox">
                            <label>
                                <?= Html::input('checkbox', 'cpoe_prn_reason', '', ['class' => 'inverted', 'id' => 'PRN']) ?>
                                <?= Html::tag('span', Html::encode('PRN'), ['class' => 'text',]) ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'cpoe_prn_reason', ['showLabels' => false])->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(TbCpoePrnReason::find()->all(), 'cpoe_prnreason_decs', 'cpoe_prnreason_decs'),
                            'options' => ['placeholder' => '----Select Reason----', 'multiple' => false,],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'disabled' => empty($model['cpoe_prn_reason']) ? true : false,
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'Item_comment4', ['label' => 'คำสั่งเพิ่มเติม', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <?=
                        $form->field($model, 'Item_comment4', ['showLabels' => false])->textInput([
                            'style' => 'background-color: white',
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-6">
        <h5 class="success"><b><?= Html::encode('Schedule :') ?></b></h5>
        <div class="well Schedule">

            <div class="row">
                <div class="form-group">
                    <?= Html::label('', 'label', ['class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-8">
                        <div class="btn-group btn-group-justified">
                            <a class="btn btn-default btn-sm <?= $model['cpoe_rxordertype'] == '1' ? 'active' : null; ?>" id="orderoneday1"><i class=""></i><?= Html::encode('Order One Day'); ?></a>
                            <a class="btn btn-default btn-sm <?= $model['cpoe_rxordertype'] == '2' ? 'active' : null; ?>" id="orderoneday2"><i class=""></i><?= Html::encode('Order for continuation'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::label('', 'label', ['class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-sm-8">
                        <div class="checkbox">
                            <label>
                                <?= Html::input('checkbox', 'TbCpoeDetail[cpoe_stat]', empty($model['cpoe_stat']) ? 0 : $model['cpoe_stat'], ['class' => 'inverted', 'id' => 'cpoe_stat', 'checked' => $model['cpoe_stat'] == 1 ? true : false]) ?>
                                <?= Html::tag('span', 'Stat', ['class' => 'text']) ?>
                            </label>
                        </div>

                        <?php /*
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
                          ]); */
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::label('', 'label', ['class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-sm-10">
                        <div class="radio">
                            <label>
                                <?= Html::input('radio', 'input_day', '7', ['class' => 'inverted auto-day', 'id' => '7d']) ?>
                                <?= Html::tag('span', Html::encode('7d'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('radio', 'input_day', '14', ['class' => 'inverted auto-day', 'id' => '14d']) ?>
                                <?= Html::tag('span', Html::encode('14d'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('radio', 'input_day', '21', ['class' => 'inverted auto-day', 'id' => '21d']) ?>
                                <?= Html::tag('span', Html::encode('21d'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('radio', 'input_day', '28', ['class' => 'inverted auto-day', 'id' => '28d']) ?>
                                <?= Html::tag('span', Html::encode('28d'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('radio', 'input_day', '60', ['class' => 'inverted auto-day', 'id' => '60d']) ?>
                                <?= Html::tag('span', Html::encode('60d'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('radio', 'input_day', '90', ['class' => 'inverted auto-day', 'id' => '90d']) ?>
                                <?= Html::tag('span', Html::encode('90d'), ['class' => 'text']) ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_period_value', ['label' => 'ระยะเวลา', 'class' => 'col-sm-2 control-label no-padding-right text-align-right']) ?>
                    <div class="col-sm-4">
                        <?=
                        $form->field($model, 'cpoe_period_value', ['showLabels' => false])->textInput([
                            'style' => 'background-color: white',
                            'type' => 'number',
                            'value' => empty($model['cpoe_period_value']) ? '1' : $model['cpoe_period_value'],
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-4">
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
                    <div class="col-sm-2">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::label('', 'label', ['class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label>
                                <?= Html::input('radio', 'Every-day-Repeat', 'Every day', ['class' => 'inverted', 'id' => 'Every-day',]) ?>
                                <?= Html::tag('span', Html::encode('Every day'), ['class' => 'text']) ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="radio">
                            <label>
                                <?= Html::input('radio', 'Every-day-Repeat', 'Repeat', ['class' => 'inverted', 'id' => 'Repeat']) ?>
                                <?= Html::tag('span', Html::encode('Repeat'), ['class' => 'text']) ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group FrequencyDay" style="display: none;">
                    <?= Html::label('', 'label', ['class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-sm-3">
                        <div class="radio">
                            <label>
                                <?= Html::input('radio', 'FrequencyDay', 'FrequencyDay', ['class' => 'inverted', 'id' => 'Frequency', $model['cpoe_frequency'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Frequency'), ['class' => 'text']) ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <?=
                        $form->field($model, 'cpoe_frequency_value', ['showLabels' => false])->textInput([
                            'style' => 'background-color: white',
                        ]);
                        ?>
                    </div>
                    <div class="col-sm-4">
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
            </div>

            <div class="row">
                <div class="form-group FrequencyDay" style="display: none;">
                    <?= Html::label('', 'label', ['class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-sm-10">
                        <div class="radio">
                            <label>
                                <?= Html::input('radio', 'FrequencyDay', 'FrequencyDay', ['class' => 'inverted', 'id' => 'Day', $model['cpoe_dayrepeat'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Day'), ['class' => 'text']) ?>
                            </label>

                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_sun', $model['cpoe_dayrepeat_sun'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_sun', $model['cpoe_dayrepeat_sun'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Sun'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_mon', $model['cpoe_dayrepeat_sun'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_mon', $model['cpoe_dayrepeat_mon'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Mon'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_tue', $model['cpoe_dayrepeat_tue'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_tue', $model['cpoe_dayrepeat_tue'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Tue'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_wed', $model['cpoe_dayrepeat_wed'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_wed', $model['cpoe_dayrepeat_wed'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Wed'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_thu', $model['cpoe_dayrepeat_thu'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_thu', $model['cpoe_dayrepeat_thu'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Tue'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_fri', $model['cpoe_dayrepeat_fri'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_fri', $model['cpoe_dayrepeat_fri'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Fri'), ['class' => 'text']) ?>
                            </label>
                            <label>
                                <?= Html::input('checkbox', 'cpoe_dayrepeat_sat', $model['cpoe_dayrepeat_sat'] == 1 ? 1 : 0, ['class' => 'inverted input-day', 'id' => 'cpoe_dayrepeat_sat', $model['cpoe_dayrepeat_sat'] == 1 ? 'checked' : 'unckeck' => 'checked']) ?>
                                <?= Html::tag('span', Html::encode('Sat'), ['class' => 'text']) ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::label('วงรอบให้ยา', 'วงรอบให้ยา', ['class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-sm-8">
                        <?= Html::input('text', 'sig_code_des', '', ['class' => 'form-control bg-white', 'id' => 'sig_code_des', 'readonly' => true]) ?>
                    </div>
                </div>
            </div>
            <p></p>
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
            </div>

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
            </div>

            <div class="row">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'cpoe_seq_mindelay', ['label' => '<b>Delay(min)</b>', 'class' => 'col-sm-2 control-label no-padding-right text-right']) ?>
                    <div class="col-xs-12 col-sm-6 col-md-8">
                        <?= $form->field($model, 'cpoe_seq_mindelay', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'type' => 'number', 'value' => !empty($model['cpoe_seq_mindelay']) ? $model['cpoe_seq_mindelay'] : '0']) ?>
                    </div>
                </div>
            </div>

        </div> <!-- End Well-->

        <div class="row">
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <?= Html::a('คำนวณปริมาณ', 'javascript:void(0);', ['onclick' => 'CalculateQty(this);', 'class' => 'btn btn-block btn-primary ladda-button', 'data-style' => 'slide-left', 'id' => 'CalculateQty']); ?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <p></p>
                    <div id="msgqty" class="alert-error"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <h5 class="success">
            <b><?= Html::encode('Dispense Qty : ') ?></b>
            <text style="color: red">*</text><text style="color: black"><?= Html::encode('สามารถกำหนดปริมาณได้'); ?></text>
            <!-- Alert Message -->
        </h5>
        <!-- Begin Well -->
        <div class="well">
            <!-- Begin Row -->
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="form-group">
                        <?php /*
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
                        </table>*/?>
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
                            'class' => 'form-control itemqty',
                            'required' => true,
                            'value' => empty($model['ItemQty']) ? null : number_format($model['ItemQty'], 2)
                        ])
                        ?>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-1">
                    <p></p>
                    <span class="disunitontable" style="font-size: 13pt;"><?= $Item['DispUnit']; ?></span>
                </div>
            </div><!-- End Row -->
        </div><!-- End Well -->
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?= $form->field($model, 'cpoe_narcotics_confirmed', ['showLabels' => false])->hiddenInput() ?>
        <?= $form->field($model, 'ised_reason', ['showLabels' => false])->hiddenInput() ?>
        <?= Html::input('hidden', 'pt_visit_number', '', ['class' => 'form-control', 'id' => 'pt_visit_number']) ?>
        <?= $form->field($model, 'cpoe_frequency', ['showLabels' => false])->hiddenInput() ?>
        <?= $form->field($model, 'cpoe_ids', ['showLabels' => false])->hiddenInput() ?>
        <?= $form->field($model, 'cpoe_dayrepeat', ['showLabels' => false])->hiddenInput() ?>
        <?= $form->field($model, 'cpoe_repeat', ['showLabels' => false])->hiddenInput() ?>
        <?= $form->field($model, 'cpoe_rxordertype', ['showLabels' => false])->hiddenInput(['value' => empty($model['cpoe_rxordertype']) ? '1' : $model['cpoe_rxordertype']]) ?>
        <?= $form->field($model, 'cpoe_once', ['showLabels' => false])->hiddenInput(['value' => empty($model['cpoe_once']) ? '1' : $model['cpoe_once']]) ?>
        <?= $form->field($model, 'ItemPrice', ['showLabels' => false])->hiddenInput(['value' => empty($model['ItemPrice']) ? $ItemOP['ItemPrice'] : $model['ItemPrice']]) ?>
        <?= $form->field($model, 'ItemID', ['showLabels' => false])->hiddenInput(['value' => empty($model['ItemID']) ? $Item['ItemID'] : $model['ItemID']]) ?>
        <?= $form->field($model, 'cpoe_id', ['showLabels' => false])->hiddenInput(['id' => 'tbcpoedetail-cpoe_id2']) ?>
        <?= $form->field($model, 'cpoe_Itemtype', ['showLabels' => false])->hiddenInput(['value' => $Itemtype]) ?>
        <?= $form->field($model, 'Item_comment1', ['showLabels' => false])->hiddenInput(['value' => empty($model['Item_comment1']) ? $Item['DrugAdminstration'] : $model['Item_comment1']]) ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group" style="text-align: right;">
            <?= Html::button('<i class="glyphicon glyphicon-chevron-left"></i> ' . 'Prev', ['class' => 'btn btn-default', 'id' => 'btn-backsteb2']) ?>
            <?= Html::button('Close', ['type' => 'button', 'data-dismiss' => 'modal', 'class' => 'btn btn-default']); ?>
            <?= Html::button('Save', ['type' => 'button', 'class' => 'btn btn-success ladda-button', 'id' => 'btn-savecpoe-ivform', 'data-style' => 'expand-left',]); ?>
        </div>
    </div>
</div> 
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    //ปุ่มกลับ
    $("button[id=btn-backsteb2]").click(function () {
        if ($('div.isedreason1').css('display') === 'block' || $('div.isedreason2').css('display') === 'block') {
            //Back to Steb 2
            DisabledButtonSave();
            $('#simplewizardstep3').removeClass('active');//AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
            $('div[id=numbersteb3]').html(''); //Setnumber Steb
            $('#content3').removeClass('active');
            $('#content2').addClass('active');
        } else {
            //Back to Steb 1
            DisabledButtonSave();
            $('#simplewizardstep3').removeClass('active');//AddClass Steb
            $("li[id=simplewizardstep3]").css("display", "none");//Show Steb 2
            $('div[id=numbersteb3]').html(''); //Setnumber Steb
            $('#content3').removeClass('active');
            $('#content1').addClass('active');
        }
    });
    /* Event เมื่อคลิกที่ปุ่ม Order One Day */
    $("a[id=orderoneday1]").click(function (e) {
        if ($(this).hasClass('btn-success')) {
            $(this).removeClass('btn-success');
            $('#orderoneday1 i').removeClass('fa fa-check');
            $('#tbcpoedetail-cpoe_rxordertype').val(null);
        } else {
            $(this).addClass('btn-success');
            $('#orderoneday1 i').addClass('fa fa-check');
            //Order for continuation Event
            $('a[id=orderoneday2]').removeClass('btn-success');
            $('a[id=orderoneday2]').addClass('btn-default');
            $('#orderoneday2 i').removeClass('fa fa-check');
            $('#tbcpoedetail-cpoe_rxordertype').val('1');//Set Value
        }
    });
    /* Order for continuation */
    $("a[id=orderoneday2]").click(function (e) {
        if ($(this).hasClass('btn-success')) {
            $(this).removeClass('btn-success');
            $('#orderoneday2 i').removeClass('fa fa-check');
            $('#tbcpoedetail-cpoe_rxordertype').val(null);
        } else {
            $(this).addClass('btn-success');
            $('#orderoneday2 i').addClass('fa fa-check');
            //เมื่อคลิกที่ปุ่ม Order One Day Event
            $('a[id=orderoneday1]').removeClass('btn-success');
            $('a[id=orderoneday1]').addClass('btn-default');
            $('#orderoneday1 i').removeClass('fa fa-check');
            $('#tbcpoedetail-cpoe_rxordertype').val('2');//Set Value
        }
    });

    /* Auto Select ระยะเวลา */
    $(".auto-day").click(function (e) {
        if ($(this).is(":checked") && $('#tbcpoedetail-cpoe_period_value').val() !== '' && $('#tbcpoedetail-cpoe_period_value').val() === $(this).val())
        {
            $(this).prop('checked', false);
            $('#tbcpoedetail-cpoe_period_value').val(null);
            $("#tbcpoedetail-cpoe_period_unit").val(null).trigger("change");
        } else {
            $('#tbcpoedetail-cpoe_period_value').val($(this).val());
            $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");
        }
    });

    /* Event Keyup ระยะเวลา */
    $("#tbcpoedetail-cpoe_period_value").keyup(function () {
        var value = $(this).val();
        if ((value === '7') || (value === '14') || (value === '21') || (value === '28') || (value === '60') || (value === '90')) {
            $('#' + value + 'd').prop('checked', true);
        } else {
            $('.auto-day').prop('checked', false);
        }
    });

    /* FN ในกรณีที่เลือก Repeat ใน tab วิธีการใช้ยา */
    $("input[id=Repeat]").click(function () {
        $('div.FrequencyDay').css('display', 'block');
        DisableDay();
        if ($(this).is(":checked"))
        {
            $('input[id=tbcpoedetail-cpoe_repeat]').val('1');//SetValue
            $('input[id=tbcpoedetail-cpoe_once]').val(null);//SetValue
        } else {
            $('input[id=tbcpoedetail-cpoe_repeat]').val(null);
            $('input[id=tbcpoedetail-cpoe_once]').val('1');//SetValue
        }
    });

    /* FN Disabled Checkbox Between Sun - Sat */
    function DisableDay() {
        $('.input-day').prop('disabled', true);
        $('.input-day').prop('checked', false);
        $('.input-day').val('0');
    }
    function UnabledDay() {
        $('.input-day').prop('disabled', false);
    }
    function UnabledFrequency() {
        $('#tbcpoedetail-cpoe_frequency_value').css('background-color', '#ffffff');
        $('#tbcpoedetail-cpoe_frequency_unit').prop('disabled', false);
        $('#tbcpoedetail-cpoe_frequency_value').prop('readonly', false);
    }
    function DisabledFrequency() {
        $('#tbcpoedetail-cpoe_frequency_value').css('background-color', '#eeeeee');
        $('#tbcpoedetail-cpoe_frequency_unit').prop('disabled', true);
        $('#tbcpoedetail-cpoe_frequency_value').prop('readonly', true);
    }

    /* FN ในกรณีที่เลือก Frequency ใน tab วิธีการใช้ยา */
    $("input[id=Frequency]").click(function () {
        if ($(this).is(":checked"))
        {
            DisableDay();
            UnabledFrequency();
            $('input[id=tbcpoedetail-cpoe_frequency]').val('1');//SetValue
            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
        } else {
            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val('1');//SetValue
        }
    });

    /* FN ในกรณีที่เลือก Day ใน tab วิธีการใช้ยา */
    $("input[id=Day]").click(function () {
        if ($(this).is(":checked"))
        {
            UnabledDay();
            DisabledFrequency();
            $("#tbcpoedetail-cpoe_frequency_unit").select2("val", "");//Reset Select2
            $('input[id=tbcpoedetail-cpoe_frequency_value]').val(null);//SetValueNull
            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val('1');//SetValue
            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
        } else {
            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
        }
    });
    /* FN ในกรณีที่เลือก Once ใน Tab วิธีการใช้ยา */
    $("input[id=Every-day]").click(function () {
        var Repeat = $('input[id=tbcpoedetail-cpoe_dayrepeat]').val();
        //if (Repeat !== '') {
        if ($(this).is(":checked"))
        {
            swal({
                title: "Are you sure?",
                text: "ค่าต่างๆที่อยู่ในส่วนของ Repeat จะถูกรีเซ็ต!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm!",
                cancelButtonText: "Cancel",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $('div.FrequencyDay').css('display', 'none');
                            //Frequency
                            $("#tbcpoedetail-cpoe_frequency_unit").select2("val", "");//Reset Select2
                            $('input[id=tbcpoedetail-cpoe_frequency_value]').val(null);//SetValueNull
                            $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
                            $('input[id=Frequency]').prop('checked', false);//UnChecked Frequency
                            //Day
                            $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
                            $('input.input-day').val(null);//SetValueNull
                            $('input[id=Day]').prop('checked', false);
                            DisableDay();
                            DisabledFrequency();
                            $('input[id=tbcpoedetail-cpoe_once]').val('1');//SetValue
                            $('input[id=tbcpoedetail-cpoe_repeat]').val(null);//SetValue
                        } else {
                            $('input[id=Every-day]').prop('checked', false);
                            $('input[id=Repeat]').prop('checked', true);
                        }
                    });
        } else {
            $('input[id=tbcpoedetail-cpoe_repeat]').val(null);//SetValue
        }
        //}
    });
    /* FN ในกรณีที่เลือก Day ใน tab วิธีการใช้ยา */
    $("input.input-day").click(function () {
        if ($(this).is(":checked"))
        {
            $(this).val('1');
        } else {
            $(this).val('0');
        }
    });

    /* FN Checkbox PRN */
    $("input[id=PRN]").click(function () {
        if ($(this).is(":checked"))
        {
            $('#tbcpoedetail-cpoe_prn_reason').prop('disabled', false);
        } else {
            $("#tbcpoedetail-cpoe_prn_reason").select2("val", "");
            $('#tbcpoedetail-cpoe_prn_reason').prop('disabled', true);
        }
    });

    /* เลือก Stat*/
    $("input[id=cpoe_stat]").click(function () {
        if ($(this).val() === '0') {
            $(this).val('1');
            DateDefault();
            $('input[id=tbcpoedetail-cpeo_begintime]').val('00:00:00');
        } else {
            $(this).val('0');
            $('input[id=tbcpoedetail-cpoe_begindate]').val(null);
            $('input[id=tbcpoedetail-cpeo_begintime]').val(null);
        }
    });

    function DateDefault() {
        var myDate = new Date();
        var prettyDate = myDate.getDate() + '/' + (myDate.getMonth() + 1) + '/' +
                (myDate.getFullYear() + 543);
        $("#tbcpoedetail-cpoe_begindate").val(prettyDate);
    }

    function DefaultSIG() {
        var e = document.getElementById("tbcpoedetail-cpoe_sig_code");
        var sig_code_ip = e.options[e.selectedIndex].text;
        if (sig_code_ip !== '----Select Sigcode----') {
            $('input[id=sig_code_des]').val(sig_code_ip);
        } else {
            $("#tbcpoedetail-cpoe_sig_code").val('3').trigger("change");
        }
    }
    //Event เมื่อเลือก SigCode
    $('select[id=tbcpoedetail-cpoe_sig_code]').on('change', function () {
        var sigcodeid = $(this).find("option:selected").val();
        var sig_code_des = $(this).find("option:selected").text();
        //LoadingOnSIG();
        if (sigcodeid !== '') {
            DefaultSIG();//แสดงข้อความวงรอบการให้ยา
            $.ajax({
                url: "changestate-sigcode",
                type: "post",
                data: {id: sigcodeid},
                dataType: "JSON",
                success: function (data) {
                    /* ถ้า state == 1 */
                    if (parseFloat(data.cpoe_stat) === parseFloat('1')) {
                        $('input[id=cpoe_stat]').prop('checked', true);
                        $('input[id=cpoe_stat]').val('1');//Set Value on Input State
                        DateDefault();
                        $('input[id=tbcpoedetail-cpeo_begintime]').val('00:00:00');
                    } else {
                        $('input[id=cpoe_stat]').prop('checked', false);//Reset Input Checked State
                        $('input[id=cpoe_stat]').val('0');//Set Value on Input State
                        $('input[id=tbcpoedetail-cpoe_begindate]').val(null);
                        $('input[id=tbcpoedetail-cpeo_begintime]').val(null);
                    }
                    /* Set ระยะเวลา */
                    if (data.period_value !== null) {
                        $('input[id=tbcpoedetail-cpoe_period_value]').val(data.period_value);//Set value ระยะเวลา
                    } else {
                        //$('input[id=tbcpoedetail-cpoe_period_value]').val(null);
                        DefaultPeriodUnit();
                    }
                    if (data.period_unit !== null) {
                        $("#tbcpoedetail-cpoe_period_unit").val(data.period_unit).trigger("change");
                    } else {
                        DefaultPeriodUnit();
                        //$("#tbcpoedetail-cpoe_period_unit").val(null).trigger("change");
                    }

                    if (parseFloat(data.cpoe_frequency) === parseFloat('1')) {
                        //Repeat
                        $('input[id=Repeat]').prop('checked', true);//Set Repeat Checked
                        $('div.FrequencyDay').css('display', 'block');
                        $('input[id=tbcpoedetail-cpoe_repeat]').val('1');//SetValue
                        $('input[id=tbcpoedetail-cpoe_once]').val(null);//SetValue

                        UnabledFrequency();
                        $('input[id=Frequency]').prop('checked', true);//Set Frequency Checked
                        $('input[id=tbcpoedetail-cpoe_frequency]').val('1');//SetValue
                        $('input[id=tbcpoedetail-cpoe_dayrepeat]').val('1');//SetValue
                        $('input[id=tbcpoedetail-cpoe_frequency_value]').val(data.frequency_value);//SetValue
                        $('#' + data.frequency_value + 'd').prop('checked', true);
                        $("#tbcpoedetail-cpoe_frequency_unit").val(data.frequency_unit).trigger("change");
                        DisableDay();
                        $('#tbcpoedetail-cpoe_frequency_value').prop('readonly', false);
                        $('#tbcpoedetail-cpoe_frequency_unit').prop('disabled', false);
                    } else if (data.cpoe_frequency === null) {
                        $('input[id=Repeat]').prop('checked', false);//Set Repeat Checked

                        $('input[id=Every-day]').prop('checked', true);//Set Frequency Checked

                        $('div.FrequencyDay').css('display', 'none');
                        //Frequency
                        DisabledFrequency();
                        $("#tbcpoedetail-cpoe_frequency_unit").select2("val", "");//Reset Select2
                        $('input[id=tbcpoedetail-cpoe_frequency_value]').val(null);//SetValueNull
                        $('.auto-day').prop('checked', false);
                        $('input[id=tbcpoedetail-cpoe_frequency]').val(null);//SetValue
                        $('input[id=Frequency]').prop('checked', false);//UnChecked Frequency
                        //Day
                        $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
                        DisableDay();

                        $('input[id=tbcpoedetail-cpoe_once]').val('1');//SetValue
                        $('input[id=tbcpoedetail-cpoe_dayrepeat]').val(null);//SetValue
                    }
                    //$('.Schedule').waitMe('hide');
                }
            });
        } else {
            //$('.Schedule').waitMe('hide');
        }
    });

    function LoadingOnSIG() {
        $('.Schedule').waitMe({
            effect: 'roundBounce', //roundBounce,ios,progressBar,rotation
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#001940', //default #000
            maxSize: '60',
            //source: 'img.svg',
            fontSize: '18px',
            onClose: function () {
            }
        });
    }

    function DefaultOrderOneDay() {
        var value = $('#tbcpoedetail-cpoe_rxordertype').val();
        if (parseFloat(value) === parseFloat('1')) {
            $('a[id=orderoneday1]').addClass('btn-success');
            $('#orderoneday1 i').addClass('fa fa-check');
            //Order for continuation Event
            $('a[id=orderoneday2]').removeClass('btn-success');
            $('a[id=orderoneday2]').addClass('btn-default');
            $('#orderoneday2 i').removeClass('fa fa-check');
            $('#tbcpoedetail-cpoe_rxordertype').val('1');//Set Value
        } else {
            $('a[id=orderoneday2]').addClass('btn-success');
            $('#orderoneday2 i').addClass('fa fa-check');
            //เมื่อคลิกที่ปุ่ม Order One Day Event
            $('a[id=orderoneday1]').removeClass('btn-success');
            $('a[id=orderoneday1]').addClass('btn-default');
            $('#orderoneday1 i').removeClass('fa fa-check');
            $('#tbcpoedetail-cpoe_rxordertype').val('2');//Set Value
        }
    }

    function DefaultRoute() {
        var value = '<?= $Item['DrugRouteID']; ?>' || 0;
        if (parseFloat(value) === parseFloat('2')) {
            $('input[id=tbcpoedetail-cpoe_iv_driprate]').attr('readonly', true);
        } else {
            //$("#tbcpoedetail-cpoe_route_id").val().trigger("change");
        }
    }

    function DefaultPeriodUnit() {
        var e = document.getElementById("tbcpoedetail-cpoe_period_unit");
        var value = e.options[e.selectedIndex].text;
        if (value === 'Select State...') {
            $("#tbcpoedetail-cpoe_period_unit").val('1').trigger("change");
            $('#tbcpoedetail-cpoe_period_value').val('1');
        }
    }

    function DefautlOnceRepeat() {
        var value = $('#tbcpoedetail-cpoe_repeat').val();
        if (value === '1') {
            $('div.FrequencyDay').css('display', 'block');
            $('input[id=Repeat]').prop('checked', true);
        } else {
            $('input[id=Every-day]').prop('checked', true);
        }
    }

    $(document).ready(function () {
        GettbBasesolution();
        GettbDrugAdditive();
//        DefaultSIG();
//        DefaultOrderOneDay();
//        DefaultRoute();
//        DefaultPeriodUnit();
//        DefautlOnceRepeat();
//        CheckedSelectAutoDay();
//        CheckedPRN();
        $('#tbcpoedetail-cpoe_id').val($('#tbcpoe-cpoe_id').val());
        $('#pt_visit_number').val($('#tbcpoe-pt_vn_number').val());
        $('#tbcpoedetail-itemqty').autoNumeric('init');
    });

    /* FN คำนวณเม็ดยา  */
    function CalculateQty() {
        var frm = $('#form_cpoedetail');
        var qty = $('#tbcpoedetail-itemqty').val();
        var l = $('#CalculateQty').ladda();
        l.ladda('start');
        $.ajax({
            type: frm.attr('method'),
            url: 'calculate-qty',
            data: frm.serialize(),
            dataType: "JSON",
            success: function (data) {
                $('input[id=tbcpoedetail-itemqty]').val(data.Qty);
                $('.showItem_Total_Amt').html(data.Item_Total_Amt);//เป็นเงิน
                $('.showItem_Cr_Amt').html(data.Item_Cr_Amt);//เบิกได้
                $('.showItem_Pay_Amt').html(data.Item_Pay_Amt);//เบิกไม่ได้
                var msg = '<div class="alert alert-success fade in"><i class="fa-fw fa fa-check"></i><strong>Calculated!</strong></div>';
                $('#msgqty').addClass('alert-success').removeClass('alert-error').html(msg).show();
                setTimeout(function () {
                    $('#msgqty').addClass('alert-error').removeClass('alert-success').html('').hide();
                }, 1000);
                //Notify('Calculated', 'bottom-left', '2000', 'success', 'fa-check', true);
                l.ladda('stop');
                document.getElementById("btn-savecpoe-details").disabled = false;
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                l.ladda('stop');
            }
        });
    }

    //Submit From
    $('#btn-savecpoe-ivform').click(function (e) {
        var frm = $('#form_cpoeiv');
        var qty = $('#tbcpoedetail-itemqty').val();
        var l = $(this).ladda();
        if (qty === '' || qty === null) {
            swal("กรุณาคำนวณ Dispense!", "", "warning");
        } else {
            l.ladda('start');
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
                                    l.ladda('stop');
                                    $('#form_cpoeiv').trigger("reset");
                                    $('#from-input').html('');//Query From
                                    $('#solution-modal').modal('hide');
                                }
                            });
                },
                error: function (xhr, status, error) {
                    swal({
                        title: error,
                        text: "",
                        type: "error",
                        confirmButtonText: "OK"
                    });
                    l.ladda('stop');
                }
            });
        }
    });
    //Checkend ระยะเวลา
    function CheckedSelectAutoDay() {
        var NumX = parseInt($('#tbcpoedetail-cpoe_period_value').val()) || null;
        if (NumX !== null) {
            $("input[id=" + NumX + "d]").prop('checked', true);
        }
    }
    /* Checked PRN */
    function CheckedPRN() {
        var NumX = $('#tbcpoedetail-cpoe_prn_reason').val() || null;
        if (NumX !== null) {
            $("input[id=PRN]").prop('checked', true);
        }
    }

    function GettbBasesolution() {
        var parent = '<?= $model['cpoe_ids']; ?>';
        var cpoe_id = '<?= $model['cpoe_id']; ?>';
        var ItemType = '<?= $model['cpoe_Itemtype']; ?>' === "40" ? "41" : "51";
        $.ajax({
            url: "gettb-basesolution",
            type: "POST",
            data: {parent: parent,cpoe_id:cpoe_id,ItemType:ItemType},
            dataType: "JSON",
            success: function (result) {
                $('#detailsBaseSolution').html(result.table);
                $('#tbBasesolution').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
                    "pageLength": 10,
                    responsive: true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    //"bFilter": false,
                    //"bSort": false,
                    "aaSorting": [[0]],
                    "info": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": "ค้นหา : _INPUT_ " + '<a class="btn btn-success" title-modal="Base Solution" item-type="'+ItemType+'" onclick="CreateByType(this);"><i class="glyphicon glyphicon-plus"></i>Add</a>'
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }

    function GettbDrugAdditive() {
        var parent = '<?= $model['cpoe_ids']; ?>';
        var ItemType = '<?= $model['cpoe_Itemtype']; ?>' === "40" ? "42" : "52";
        $.ajax({
            url: "gettb-drugadditive",
            type: "POST",
            data: {parent: parent,ItemType:ItemType},
            dataType: "JSON",
            success: function (result) {
                $('#detailsDrugAdditive').html(result.table);
                $('#tbDrugAdditive').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>',
                    "pageLength": 10,
                    responsive: true,
                    "bDestroy": true,
                    "bAutoWidth": true,
                    //"bFilter": false,
                    //"bSort": false,
                    "aaSorting": [[0]],
                    //"info": false,
                    "language": {
                        "lengthMenu": "",
                        "infoEmpty": "",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": "ค้นหา : _INPUT_ " + '<a class="btn btn-success" title-modal="Additive" item-type="'+ItemType+'" onclick="CreateByType(this);"><i class="glyphicon glyphicon-plus"></i>Add</a>'
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    }

    function DeleteSubparent(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: true,
            confirmButtonText: "Confirm",
            showLoaderOnConfirm: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-details',
                                {
                                    id: id
                                },
                                function (data)
                                {
                                    GettbBasesolution();
                                    GettbDrugAdditive();
                                    swal("Deleted!", "", "success");
                                }
                        );
                    }
                });
    }

</script>