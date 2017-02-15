<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>เลขที่ผู้ขาย</strong>
            </th>
            <th  style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>ชื่อผู้ขาย</strong>
            </th>
            <th  style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;" colspan="6">  
            </th>

        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($rs as $r) {
            ?>
            <tr>
                <td style="font-size:16pt"><?php echo $r['VendorID'] ?></td><td width="20%" style="font-size:16pt"><?php echo $r['VenderName'] ?></td><td style="font-size:16pt" colspan="6"></td>
            </tr>
            <?php
            $result = \app\modules\Purchasing\models\VwQuPricelist::findAll(['VendorID' => $r['VendorID'], 'ItemCatID' => $itemcat]);
            if ($result != null) {
                ?>   
                <tr>
                    <td  style="font-size:14pt;text-align: center">รหัสสินค้า</td><td  style="font-size:14pt;text-align: center" width="40%">รายละเอียดสินค้า</td><td  style="font-size:14pt;text-align: center">จำนวน</td><td  style="font-size:14pt;text-align: center">หน่วย</td><td   style="font-size:14pt;text-align: center">ราคา/หน่วย</td><td  style="font-size:14pt;text-align: center">เป็นเงิน</td><td  style="font-size:14pt;text-align: center">MOQ</td><td  style="font-size:14pt;text-align: center">ส่งสินค้าวัน</td>
                </tr>
                <?php foreach ($result as $value) {
                    ?>
                    <tr>
                        <td  style="font-size:14pt;text-align: center"><?php echo $value['TMTID_TPU'] ?></td><td style="font-size:14pt"><?php echo $value['ItemName'] ?></td><td  style="font-size:14pt;text-align: right"><?php echo number_format($value['QUQty'], 2) ?></td><td  style="font-size:14pt;text-align: center"><?php echo $value['QUUnit'] ?></td><td style="font-size:14pt;text-align: right"><?php echo number_format($value['QUUnitCost2'], 2) ?></td><td  style="font-size:14pt;text-align: right"><?php echo number_format($value['QUQty'] * $value['QUUnitCost2'], 2) ?></td><td  style="font-size:14pt;text-align: right"><?php echo $value['QUMQO'] ?></td><td style="font-size:14pt;text-align: center"><?php echo $value['QULeadtime'] ?></td>
                    </tr>
                    <?php
                }
            }
            ?>



        <?php } ?>
    </tbody>
</table>
