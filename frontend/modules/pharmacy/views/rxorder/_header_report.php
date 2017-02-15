<?php
use app\modules\pharmacy\models\TbSection;
use app\modules\pharmacy\models\VwUserprofile;
use yii\helpers\Html;

$querySection = TbSection::findOne($model['cpoe_order_section']);
$queryUser = VwUserprofile::findOne(['user_id' => $model['cpoe_order_by']]);
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
            <b><?= Html::encode('ใบสั่งยาเลขที่ : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $model['cpoe_num']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Treatment Plan No : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $model['pt_trp_chemo_id']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Cycle : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $model['chemo_cycle_seq']; ?>
        </td>
    </tr>
    <tr>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('วันที่ : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo Yii::$app->componentdate->convertMysqlToThaiDate($model['cpoe_date']); ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Regimen Name : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $modelChemo['pt_trp_regimen_name']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('Day : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $model['chemo_cycle_day']; ?>
        </td>
    </tr>
    <tr>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('หมายเหตุ : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo $model['cpoe_comment']; ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('แผนก : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo empty($querySection) ? '-' : $querySection['SectionDecs'] ?>
        </td>
        <td width="16.6%" style="text-align: right;">
            <b><?= Html::encode('แพทย์ : '); ?></b>
        </td>
        <td width="16.6%">
            &nbsp;<?php echo empty($queryUser) ? '-' : $queryUser['User_name'] ?>
        </td>
    </tr>
</table>
