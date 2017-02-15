
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
                <strong><?= Html::label('ปี :') ?></strong>
                <?php echo ($year + 543); ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;"><?= Html::label('หน้า {PAGENO} / {nbpg}') ?> </span>
<?php endif; ?>


<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="10%">รหัสสินค้า</th>
                <th width="30%">รายละเอียดสินค้า</th>
                <th width="5%" >หน่วย</th>
                <th width="5%">ม.ค</th>
                <th width="5%">ก.พ</th>
                <th width="5%">มี.ค</th>
                <th width="5%">เม.ย</th>
                <th width="5%">พ.ค</th>
                <th width="5%">มิ.ย</th>
                <th width="5%">ก.ค</th>
                <th width="5%">ส.ค</th>
                <th width="5%">ก.ย</th>
                <th width="5%">ต.ค</th>
                <th width="5%">พ.ย</th>
                <th width="5%">ธ.ค</th>
                <th width="5%">รวม</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['ItemID'] ?></td>
                    <td style="font-size:14pt;"><?php echo $r['ItemName'] ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['DispUnit']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M01']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M02']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M03']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M04']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M05']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M06']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M07']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M08']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M09']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M10']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M11']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['M12']; ?></td>
                    <td style="text-align:center;font-size:14pt;"><?php echo $r['MCum']; ?></td>
                </tr>
                <?php $sum[] = $r['MCum']; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>

            <td  style="font-size:16pt; text-align: right;padding-right:30px">รวมทั้งสิ้น <?php echo number_format(array_sum($sum),2) ?> บาท</td>
        </tr>
    </table>
<?php endif; ?>