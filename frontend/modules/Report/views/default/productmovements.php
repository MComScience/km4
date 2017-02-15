
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
            <td width="33%" style="text-align:center;font-size:16pt"></td>
            <td width="33%" style="text-align:center;font-size:16pt">
                <strong><?= $title ?></strong>
            </td>
        <tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt">
                <strong>จากวันที่ : </strong><?php echo $startdate; ?><strong>  ถึงวันที่ : </strong> <?php echo $enddate; ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>

<?php endif; ?>
<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0"  width="100%"> 
        <thead>
            <tr>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;" width="15%">
                    <strong>รหัสสินค้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;" width="50%">
                    <strong>รายละเอียดสินค้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;" width="10%" colspan="2">
                    <strong>คลังสินค้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;border-left: 1px solid black;" width="15%">
                    <strong>หน่วย</strong>
                </th>

            </tr>
            <tr>
                <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="15%">
                    <strong>วันที่</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="50%">
                    <strong>เลขที่เอกสาร</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;border-left: 1px solid black;" width="10%">
                    <strong>ยอดเข้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;border-left: 1px solid black;" width="10%">
                    <strong>ยอดออก</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;border-left: 1px solid black;" width="15%">
                    <strong>ยอดคงเหลือ</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td  style="font-size:16pt;text-align:center;vertical-align: top;">
                        <?php echo $r['ItemID'] ?>
                    </td>
                    <td  style="font-size:16pt;vertical-align: top;">
                        <?php echo $r['ItemName'] ?>
                    </td>
                    <td style="font-size:16pt;text-align: center;vertical-align: top;" colspan="2"> 
                        <?php echo $r['StkName'] ?>
                    </td>
                    <td style="font-size:16pt;text-align: center;vertical-align: top;">
                        <?php echo $r['DispUnit'] ?>
                    </td>
                </tr>
                <tr>
                    <td  style="font-size:16pt;text-align:center;border-bottom: 1px solid #ddd;">
                        <?php echo $r['StkTransDateTime2'] ?>
                    </td>
                    <td  style="font-size:16pt;border-bottom: 1px solid #ddd;">
                        <?php echo $r['StkDocNum'] ?>
                    </td>
                    <td style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                        <?php echo number_format($r['ItemQtyIn'],2) ?>
                    </td>
                    <td style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                        <?php echo number_format($r['ItemQtyOut'],2) ?>
                    </td>
                    <td style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                        <?php echo number_format($r['ItemQtyBalance'],2) ?>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>

            <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $i; ?> รายการ</strong></td>
            <td></td><td  style="padding-left:30px"></td>
        </tr>
    </table>
<?php endif; ?>

