<?php

use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\ArrayHelper;
use app\modules\Inventory\models\TbStk;
use app\modules\Report\models\VwStkYearcut;
use kartik\widgets\DatePicker;
use kartik\daterange\DateRangePicker;

$addon = <<< HTML
<span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
</span>
HTML;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); ?>
        <?php if (($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้ายา') || ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้าเวชภัณฑ์') || ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้ายาเพื่อตรวจนับ') || ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้าเวชภัณฑ์เพื่อตรวจนับ')) : ?>
            <div class="form-group">
                <?= Html::label('เลือกคลัง', 'เลือกคลัง', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-6">
                    <?php
                    echo Select2::widget([
                        'name' => 'state_2',
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => [
                            'placeholder' => 'เลือกคลัง ...',
                            'id' => 'state_2',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php if ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้ายา') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportSeparate(1);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้าเวชภัณฑ์') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportSeparate(2);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้ายาเพื่อตรวจนับ') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportDrugofCount(1);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดคงเหลือแยกตามคลังสินค้าเวชภัณฑ์เพื่อตรวจนับ') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportDrugofCount(2);',
                        ])
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($title == 'รายงานปริมาณการขายสินค้ายา สรุปรายเดือน') || $title == 'รายงานปริมาณการขายสินค้าเวชภัณฑ์ สรุปรายเดือน') : ?>
            <div class="form-group">
                <?= Html::label('เลือกปี', 'เลือกปี', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-6">
                    <?php
                    echo Select2::widget([
                        'name' => 'state_3',
                        'data' => ArrayHelper::map(VwStkYearcut::find()->groupBy('YEAR')->all(), 'YEAR', 'YEAR'),
                        'options' => [
                            'placeholder' => 'เลือกปี ...',
                            'id' => 'state_3',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-sm-4">
                    <?=
                    Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                        'class' => 'btn btn-primary',
                        'onclick' => $title == 'รายงานปริมาณการขายสินค้ายา สรุปรายเดือน' ? 'PrintReportYearcut(1);' : 'PrintReportYearcut(2);',
                    ])
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($title == 'รายงานเคลื่อนไหวคลังสินค้า(ยา)') || ($title == 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว(ยา)') || ($title == 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว(เวชภัณฑ์)') || ($title == 'รายงานเคลื่อนไหวคลังสินค้า(เวชภัณฑ์)')) : ?>
            <div class="form-group">
                <?= Html::label('เลือกช่วงเวลา', 'เลือกช่วงเวลา', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?php
                    echo '<div class="drp-container">';
                    echo DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'startAttribute' => 'from_date',
                        'endAttribute' => 'to_date',
                        'startInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'endInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'D/M/Y',
                                'separator' => ' ถึง ',
                            ],
                        ]
                    ]);
                    echo '</div>';
                    ?>
                </div>
                <div class="col-sm-2">
                    <?php if ($title == 'รายงานเคลื่อนไหวคลังสินค้า(ยา)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportProductmovements(1);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานเคลื่อนไหวคลังสินค้า(เวชภัณฑ์)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportProductmovements(2);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว(ยา)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportProductNotmovements(1);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานสินค้าที่ไม่มีการเคลื่อนไหว(เวชภัณฑ์)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportProductNotmovements(2);',
                        ])
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($title == 'รายงานการโอนสินค้ารายเดือน(ยา)') || ($title == 'รายงานการโอนสินค้ารายเดือน(เวชภัณฑ์)')) : ?>
            <div class="form-group">
                <?= Html::label('จากคลัง', 'จากคลัง', ['class' => 'col-sm-1 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?php
                    echo Select2::widget([
                        'name' => 'state_1',
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => [
                            'placeholder' => 'เลือกคลัง ...',
                            'id' => 'state_1',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <?= Html::label('ไปคลัง', 'ไปคลัง', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?php
                    echo Select2::widget([
                        'name' => 'state_2',
                        'data' => ArrayHelper::map(TbStk::find()->all(), 'StkID', 'StkName'),
                        'options' => [
                            'placeholder' => 'เลือกคลัง ...',
                            'id' => 'state_2',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <?= Html::label('ช่วงเวลา', 'เลือกช่วงเวลา', ['class' => 'col-sm-1 control-label no-padding-right']) ?>
                <div class="col-sm-10">
                    <?php
                    echo '<div class="drp-container">';
                    echo DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'startAttribute' => 'from_date',
                        'endAttribute' => 'to_date',
                        'startInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'endInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'D/M/Y',
                                'separator' => ' ถึง ',
                            ],
                        ]
                    ]);
                    echo '</div>';
                    ?>
                </div>
            </div>
            <div class="form-group" style="text-align: right;">
                <div class="col-sm-11">
                    <?=
                    Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                        'class' => 'btn btn-primary',
                        'onclick' => $title == 'รายงานการโอนสินค้ารายเดือน(ยา)' ? 'PrintReportTranfer(1);' : 'PrintReportTranfer(2);',
                    ])
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($title == 'รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย(ยา)') || ($title == 'รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย(เวชภัณฑ์)') || ($title == 'รายงานสถานะการสั่งชื้อ')) : ?>
            <div class="form-group">
                <?= Html::label('เลือกวันที่', 'เลือกวันที่', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?php
                    echo '<div class="drp-container">';
                    echo DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'startAttribute' => 'from_date',
                        'endAttribute' => 'to_date',
                        'startInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'endInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'D/M/Y',
                                'separator' => ' ถึง ',
                            ],
                        ]
                    ]);
                    echo '</div>';
                    ?>
                </div>
                <div class="col-sm-2">
                    <?php if ($title == 'รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย(ยา)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOHistory(1);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานประวัติการสั่งชื้อตามรายการสินค้า ตามผู้จำหน่าย(เวชภัณฑ์)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOHistory(2);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานสถานะการสั่งชื้อ') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPocompareplan(this)',
                        ])
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if (($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(ยาสามัญ)') || ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(ยาการค้า)') || ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(เวชภัณฑ์ฯ)') || ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย(ยา)') || ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย(เวชภัณฑ์ฯ)')) : ?>
            <div class="form-group">
                <?= Html::label('เลือกวันที่', 'เลือกวันที่', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-8">
                    <?php
                    echo '<div class="drp-container">';
                    echo DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'startAttribute' => 'from_date',
                        'endAttribute' => 'to_date',
                        'startInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'endInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'D/M/Y',
                                'separator' => ' ถึง ',
                            ],
                        ]
                    ]);
                    echo '</div>';
                    ?>
                </div>
                <div class="col-sm-2">
                    <?php if ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(ยาสามัญ)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOCompareplangeneric(1);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(ยาการค้า)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOCompareplangeneric(2);',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับแผนการสั่งชื้อประจำปีงบประมาณ(เวชภัณฑ์ฯ)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOCompareplangeneric(3)',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย(ยา)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOCompareTheagreementtosell(5)',
                        ])
                        ?>
                    <?php endif; ?>
                    <?php if ($title == 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย(เวชภัณฑ์ฯ)') : ?>
                        <?=
                        Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                            'class' => 'btn btn-primary',
                            'onclick' => 'PrintReportPOCompareTheagreementtosell(6)',
                        ])
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($title == 'ประวัติการอนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)') || ($title == 'ประวัติการไม่อนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)')) : ?>
            <div class="form-group">
                <?= Html::label('เลือกวันที่', 'เลือกวันที่', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                <div class="col-sm-6">
                    <?php
                    echo '<div class="drp-container">';
                    echo DateRangePicker::widget([
                        'name' => 'date_range_2',
                        'presetDropdown' => true,
                        'hideInput' => true,
                        'startAttribute' => 'from_date',
                        'endAttribute' => 'to_date',
                        'startInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'endInputOptions' => ['value' => Yii::$app->formatter->asDate('now', 'php:d/m/'.date('Y'))],
                        'pluginOptions' => [
                            'locale' => [
                                'format' => 'D/M/Y',
                                'separator' => ' ถึง ',
                            ],
                        ],
                    ]);
                    echo '</div>';
                    ?>
                </div>
                <div class="col-sm-2">
                    <?=
                    Html::a(Icon::show('print', [], Icon::BSG) . 'Print', false, [
                        'class' => 'btn btn-primary',
                        'onclick' => $title == 'ประวัติการอนุมัติ ยาขอใช้นอกแผน(รายการยาใหม่)' ? 'PrintReportHistoryApprove(11)' : 'PrintReportHistoryApprove(6)',
                    ])
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>

