<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <thead>
        <tr>
            <td width="20%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>หมายเลขที่จำหน่าย</strong>
            </td>
            <td width="30%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>ชื่อผู้จำหน่าย</strong>
            </td>
            <td width="20%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>ระดับการประเมิน</strong>
            </td>
            <td width="20%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>สถานะ</strong>
            </td>

        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rs as $r) {
            ?>
            <tr>
                <td  style="font-size:16pt;text-align: center;"><?php echo $r['VendorID'] ?></td><td  style="font-size:16pt;text-align: center;"><?php echo $r['VenderName'] ?></td><td  style="font-size:16pt;text-align: center;"><?php echo $r['VendorStatus'] ?></td><td  style="font-size:16pt;text-align: center;"><?php echo$r['VenderRating'] ?></td>
            </tr>

        <?php } ?>
    </tbody>
</table>
