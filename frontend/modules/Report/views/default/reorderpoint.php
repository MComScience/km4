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
                <strong><p>รายงานสินค้าต่ำกว่าจุดสั่งซื้อ</p><p>Re-OrderPoint</p></strong>
            </td>
        <tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt">
                <strong><?= Html::label('พิมพ์ยอดคงเหลือ ณ วันที่ :') ?></strong>
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
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                    <strong>รหัสสินค้า</strong>
                </td>
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="40%">
                    <strong>รายละเอียดสินค้า</strong>
                </td>
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                    <strong>หน่วย</strong>
                </td>
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                    <strong>ยอดคงเหลือ</strong>
                </td>
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                    <strong>จุดสั่งชื้อ</strong>
                </td>
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                    <strong>ต่ำกว่าจุดสั่งชื้อ</strong>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td style="font-size:16pt;text-align: center">
                        <?php echo $r['ItemID'] ?>
                    </td>
                    <td style="font-size:16pt">
                        <?php echo $r['ItemName'] ?>
                    </td>
                    <td style="font-size:16pt;text-align: center" >
                        <?php echo $r['DispUnit'] ?>
                    </td>
                    <td style="font-size:16pt;text-align: right">
                        <?php echo number_format($r['ItemQtyBalance'], 2) ?>
                    </td>
                    <td style="font-size:16pt;text-align: right">
                        <?php echo number_format($r['Reorderpoint'], 2) ?>
                    </td>
                    <td style="font-size:16pt;text-align: right">
                        <?php echo number_format($r['ItemROPDiff'], 2) ?>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>

            <td width="57%" style="font-size:16pt;">
                <strong>รวมทั้งสิ้น <?php echo $i; ?> รายการ</strong>
            </td>
            <td></td>
            <td  style="padding-left:30px"></td>
        </tr>
    </table>
<?php endif; ?>

