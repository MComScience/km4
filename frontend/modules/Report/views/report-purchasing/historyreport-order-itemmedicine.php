<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>PO</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>วันที่</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>ผุ้ขาย</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>ประเภทการสั่งชื้อ</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>ประเภทการขอชื้อ</strong></td>
    </tr>   
    <?php
    foreach ($rs as $r) {
        ?>
        <tr>
            <td  style="font-size:16pt"><?php echo $r['PONum'] ?></td><td  style="font-size:16pt"><?php echo $r['PODate'] ?></td><td  style="font-size:16pt"><?php echo $r['VenderName'] ?></td><td  style="font-size:16pt"><?php echo $r['POType'] ?></td><td  style="font-size:16pt"><?php echo $r['PRType'] ?></td>
        </tr>
        <tr>
            <td  colspan="5">
                <table border="0"  width="100%">
                    <tr>
                        <td width="2%" style="font-size:14pt;text-align: center">ลำดับ</td><td width="3%" style="font-size:14pt;text-align: center">รหัสสินค้า</td><td width="5%" style="font-size:14pt;text-align: center">ประเภทสินค้า</td><td width="50%" style="font-size:14pt;text-align: center">รายละเอียดสินค้า</td><td  style="font-size:14pt;text-align: center" colspan="3">สั่งชื้อ</td>
                    </tr>
                    <tr>
                        <td width="2%" style="font-size:14pt"></td><td width="3%" style="font-size:14pt"></td><td width="5%" style="font-size:14pt"></td><td width="50%" style="font-size:14pt"></td><td width="5%" style="font-size:14pt" >จำนวน</td><td width="5%" style="font-size:14pt;text-align: center" >ราคา/หน่วย</td><td width="5%" style="font-size:14pt;text-align: center" >หน่วย</td>
                    </tr>
                    <?php
                    $i = 1;
                    $result = app\modules\Purchasing\models\VwPo2Detail2New::findAll(['POID' => $r['POID']]);
                    foreach ($result as $value) {
                        ?>
                        <tr>
                            <td width="2%" style="font-size:14pt"><?php echo $i; ?></td><td width="3%" style="font-size:14pt"><?php echo $value['ItemID'] ?></td><td width="5%" style="font-size:14pt"><?php echo $value['POItemType'] ?></td><td width="50%" style="font-size:14pt"><?php echo $value['ItemDetail'] ?></td><td width="5%" style="font-size:14pt"><?php echo $value['POQty'] ?></td><td width="5%" style="font-size:14pt;text-align: center"><?php echo $value['POUnitCost'] ?></td><td width="5%" style="font-size:14pt;text-align: center"><?php echo $value['POUnit'] ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </td>
        </tr>
    <?php } ?>
</table>
