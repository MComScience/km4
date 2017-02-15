<?php

use yii\helpers\Html;

$i = 0;
?>
<?php if ($content == 'H') : ?>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align:center;font-size:16pt">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo', 'height' => '100px']) ?>
            </td>
            <td width="33%" style="text-align:center;font-size:16pt">

            </td>
            <td width="33%" style="text-align:center;font-size:16pt">
                <strong><?= $title ?></strong>
            </td>
        <tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt">
                <strong><?= Html::label('พิมพ์ ณ วันที่ :') ?></strong>
                <?php echo Yii::$app->thaiYearformat->asDate('sort'); ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;"><?= Html::label('หน้า {PAGENO} / {nbpg}') ?> </span>
<?php endif; ?>

<?php if ($content == 'C') : ?>
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <thead>
        <tr>
            <td width="20%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;">
                <strong>หมายเลขที่จำหน่าย</strong>
            </td>
            <td width="30%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;">
                <strong>ชื่อผู้จำหน่าย</strong>
            </td>
            <td width="20%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;">
                <strong>ระดับการประเมิน</strong>
            </td>
            <td width="20%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;">
                <strong>สถานะ</strong>
            </td>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <td style="font-size:16pt;text-align: center;">
                    <?php echo $r['VendorID'] ?>
                </td>
                <td style="font-size:16pt;text-align: left;">
                    <?php echo $r['VenderName'] ?>
                </td>
                <td style="font-size:16pt;text-align: center;">
                    <?php echo$r['VenderRating'] ?>
                </td>
                <td style="font-size:16pt;text-align: center;">
                    <?php echo $r['VendorStatus'] ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
