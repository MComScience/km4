<table border="0" cellpadding="0" cellspacing="0"  width="100%"> 
    <thead>
        <tr>
            <th style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="15%">
                <strong>รหัสสินค้า</strong>
            </th>
            <th style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="50%">
                <strong>รายละเอียดสินค้า</strong>
            </th>
            <td style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="10%" colspan="2">
                <strong>คลังสินค้า</strong>
                </th>
            <th style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="15%">
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
            <td style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="10%">
                <strong>ยอดเข้า</strong>
                </th>
            <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="10%">
                <strong>ยอดออก</strong>
            </th>
            <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="15%">
                <strong>ยอดคงเหลือ</strong>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rs as $r) {
            ?>
            <tr>
                <td  style="font-size:16pt;text-align:center"><?php echo $r['ItemID'] ?></td><td  style="font-size:16pt;" ><?php echo $r['ItemName'] ?></td><td style="font-size:16pt;text-align: center" colspan="2"> <?php echo $r['StkName'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['DispUnit'] ?></td>
            </tr>
            <tr>
                <td  style="font-size:16pt;text-align:center"><?php echo $r['StkTransDateTime'] ?></td><td  style="font-size:16pt;" ><?php echo $r['StkDocNum'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['ItemQtyIn'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['ItemQtyOut'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['ItemQtyBalance'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>

        <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong></td><td></td><td  style="padding-left:30px"></td>
    </tr>
</table>
