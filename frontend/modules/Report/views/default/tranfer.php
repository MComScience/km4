<?php

use yii\helpers\Html;
use app\modules\Inventory\models\TbStk;

$issue = TbStk::findOne($st_issue);
$recieve = TbStk::findOne($st_recieve);
$i = 0;
?>
<?php if ($content == 'H') : ?>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align:center;font-size:16pt">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo', 'height' => '100px']) ?>
            </td>
            <td width="33%" style="text-align:center;font-size:16pt"></td>
            <td width="33%" style="text-align:center;font-size:18pt">
                <strong><?= $title; ?></strong>
            </td>
        <tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt" width="25%">
                <strong>จาก : </strong><?php echo $issue['StkName'] ?>
            </td>
            <td style="text-align:center;font-size:16pt" width="25%">
                <strong>ไป: </strong><?php echo $recieve['StkName'] ?>
            </td>
            <td style="text-align:center;font-size:16pt" width="25%">
                <strong>วันที่เริ่ม : </strong><?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($startdate); ?>
            </td>
            <td style="text-align:center;font-size:16pt" width="25%">
                <strong>วันสุดท้าย : </strong><?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($enddate); ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>
<?php endif; ?>
<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="15%" style="border-bottom: 1px solid black;border-top: 1px solid black;font-size: 16pt;text-align: center;">รหัสสินค้า</th>
                <th width="60%" style="border-bottom: 1px solid black;border-top: 1px solid black;font-size: 16pt;text-align: center;">รายละเอียดสินค้า</th>
                <th width="15%" style="border-bottom: 1px solid black;border-top: 1px solid black;font-size: 16pt;text-align: center;">ยอดที่โอน</th>
                <th width="10%" style="border-bottom: 1px solid black;border-top: 1px solid black;font-size: 16pt;text-align: center;">หน่วย</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td style="text-align:center;font-size:16pt;"><?php echo $r['ItemID'] ?></td>
                    <td style="font-size:16pt;"><?php echo $r['ItemName'] ?></td>
                    <td style="text-align:right;font-size:16pt;"><?php echo $r['STItemQty']; ?></td>
                    <td style="text-align:center;font-size:16pt;"><?php echo $r['DispUnit']; ?></td>
                </tr>
                <?php $i++ ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <?php if ($i == '0' || $i == '') : ?>
                <td  style="font-size:16pt; text-align: right;padding-right:30px">ไม่พบข้อมูลการโอนสินค้า</td>
            <?php else : ?>
                <td  style="font-size:16pt; text-align: right;padding-right:30px">รวมทั้งสิ้น <?php echo $i; ?>  รายการ</td>
            <?php endif; ?>
        </tr>
    </table>
<?php endif; ?>

