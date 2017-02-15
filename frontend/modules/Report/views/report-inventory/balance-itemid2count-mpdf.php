<table border="0"  cellpadding="0" cellspacing="0"  width="100%">
    <thead>
        <tr>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                <strong>คลังสินค้า</strong>
            </td>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="13%">
                <strong>รหัสสินค้า</strong>
            </td>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="40%">
                <strong>รายละเอียดสินค้า</strong>
            </td>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                <strong>หน่วย</strong>
            </td>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                <strong>ยอดคงเหลือ</strong>
            </td>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="15%">
                <strong>ยอดตรวจนับ</strong>
            </td>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" width="10%">
                <strong>ผลต่าง</strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        $rs = app\modules\Inventory\models\VwStkBalanceItemid::findAll(['StkID' => $StkID, 'ItemCatID' => $ItemCatID]);

        foreach ($rs as $r) {
            ?>
            <tr>
                <td  style="font-size:16pt;text-align: center"><?php echo $r['StkName'] ?></td><td  style="font-size:16pt;text-align: center"><?php echo $r['ItemID'] ?></td><td  style="font-size:16pt;" ><?php echo $r['ItemName'] ?></td><td style="font-size:16pt;text-align: center" ><?php echo $r['DispUnit'] ?></td><td  style="font-size:16pt;text-align: center"><?php echo number_format($r['ItemQtyBalance'], 2) ?></td><td style="font-size:16pt;text-align: center">.................</td><td  style="font-size:16pt;text-align: center">.............</td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
$count = app\modules\Inventory\models\VwStkBalanceItemid::find()->where(['StkID' => $StkID, 'ItemCatID' => $ItemCatID])->count();
?>
<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>

        <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong></td><td></td><td  style="padding-left:30px"></td>
    </tr>
</table>
