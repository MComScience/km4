<?php
use app\modules\pharmacy\models\TbCpoePeriodUnit;
use yii\helpers\Html;
$Disunit = TbCpoePeriodUnit::findOne($modelDrugset['chemo_regimen_freq_unit']);
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td style="text-align: right; vertical-align: top;">พิมพ์วันที่ <?= Yii::$app->thaiYearformat->asDate('medium'); ?></td>
    </tr>
</table>
<br>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tr>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Regimen ID :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelDrugset['drugset_id']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Cycle :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelDrugset['chemo_cycle_seq']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Day :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelDrugset['chemo_cycle_day']; ?>
        </td>
    </tr>
    <tr>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Regimen Name :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelChemo['pt_trp_regimen_name']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Frequency :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelDrugset['chemo_regimen_freq_value']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('หน่วย :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo empty($Disunit) ? '-' : $Disunit['cpoe_period_unit_decs']; ?>
        </td>
    </tr>
    <tr>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('หมายเหตุ :'); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelChemo['pt_trp_comment']; ?>
        </td>
        <td width="16.6%"></td>
        <td width="16.6%"></td>
        <td width="16.6%"></td>
        <td width="16.6%"></td>
    </tr>
</table>