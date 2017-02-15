
<?php
use yii\helpers\Html;
$i = 0;
?>
<?php if ($content == 'H') : ?>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align:center;font-size:16pt">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo','height' => '100px']) ?>
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
                <strong><?= Html::label('พิมพ์ยอดคงเหลือ ณ วันที่ :') ?></strong>
                <?php echo Yii::$app->thaiYearformat->asDate('sort'); ?>
            </td>
        </tr>
    </table>
   <span style="font-size:14pt;font-style: normal;"><?= Html::label('หน้า {PAGENO} / {nbpg}') ?> </span>
<?php endif; ?>
   
<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0"  width="100%"> 
        <thead>
            <tr>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                    <strong>คลังสินค้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                    <strong>รหัสสินค้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="30%">
                    <strong>รายละเอียดสินค้า</strong>
                </th>
                <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                    <strong>หน่วย</strong>
                    </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                    <strong>ยอดคงเหลือ</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                    <strong>ต่ำกว่าจุดสั่งชื้อ</strong>
                </th>
            </tr>
        </thead>
        <?php foreach ($rows as $r) : ?>
            <tr>
                <td  style="font-size:16pt;text-align:center;vertical-align: top;"><?php echo $r['StkName'] ?></td>
                <td  style="font-size:16pt;text-align:center;vertical-align: top;"><?php echo $r['ItemID'] ?></td>
                <td  style="font-size:16pt;vertical-align: top;" ><?php echo $r['ItemName'] ?></td>
                <td style="font-size:16pt;text-align: center;vertical-align: top;"><?php echo $r['DispUnit'] ?></td>
                <td  style="font-size:16pt;text-align: right;vertical-align: top;"><?php echo number_format($r['ItemQtyBalance'], 2) ?></td>
                <td  style="font-size:16pt;text-align: right;vertical-align: top;"><?php echo number_format($r['Reorderpoint'], 2) ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
    <table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $i; ?> รายการ</strong></td>
            <td></td><td  style="padding-left:30px"></td>
        </tr>
    </table>
<?php endif; ?>

