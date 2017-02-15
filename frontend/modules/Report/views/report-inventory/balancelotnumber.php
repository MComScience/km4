<table border="0" cellpadding="0" cellspacing="0"  width="100%"> 
    <thead>
        <tr>
            <th style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="15%">
                <strong>รหัสสินค้า</strong>
            </th>
            <th style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="40%">
                <strong>รายละเอียดสินค้า</strong>
            </th>
           
            <th style="text-align:center;font-size:16pt;border-top: 1px solid black;padding-top: 10px;" width="15%" colspan="4">
                <strong>หน่วย</strong>
            </th>

        </tr>
        <tr>
            <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="15%">
               
            </th>
            <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="40%">
                <strong>เลขที่เอกสาร</strong>
            </th>
            <td style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="15%">
                <strong>วันที่รับสินค้า</strong>
                </th>
            <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="15%">
                <strong>LotNumber</strong>
            </th>
            <th style="text-align:center;font-size:16pt;border-bottom: 1px solid black;" width="15%">
                <strong>วันหมดอายุ</strong>
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
                <td  style="font-size:16pt;text-align:center"><?php echo $r['ItemID'] ?></td><td  style="font-size:16pt;" ><?php echo $r['ItemName'] ?></td><td style="font-size:16pt;text-align: center" colspan="4"><?php echo $r['DispUnit'] ?></td>
            </tr>
            <tr>
                <td  style="font-size:16pt;text-align:center"></td><td  style="font-size:16pt;" ><?php echo $r['GRNum'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['GRDate'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['ItemInternalLotNum'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['ItemExpDate'] ?></td><td style="font-size:16pt;text-align: center"><?php echo $r['LNQtyBalance'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
