<table border="0" cellpadding="0" cellspacing="0" width="100%">   
    <thead>
    <tr>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>PO</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>วันที่</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>ผู้ขาย</strong>
        </td>
        <td width="30%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>ประเภทการสั่งชื้อ</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>กำหนดส่งมอบ</strong>
        </td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($rs as $r) {
        ?>
        <tr>
            <td  style="font-size:16pt"><?php echo $r['PONum'] ?></td><td  style="font-size:16pt"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($r['PODate']) ?></td><td  style="font-size:16pt"><?php echo $r['VenderName'] ?></td><td  style="font-size:16pt"><?php echo $r['POType'] ?></td><td  style="font-size:16pt"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate($r['PODueDate']) ?></td>
        </tr>
        <tr>
            <td  colspan="5">
                <table border="0"  width="100%">
                    <tr>
                        <td width="2%"></td><td width="5%" style="font-size:14pt">ลำดับ</td><td width="15%" style="font-size:14pt">รหัสสินค้า</td><td width="10%" style="font-size:14pt">ประเภทสินค้า</td><td width="20%" style="font-size:14pt">รายการสินค้า</td><td width="10%"></td><td width="10%" style="font-size:14pt">สั่งชื้อ</td><td width="10%"></td><td style="font-size:14pt">รับแล้ว</td><td style="font-size:14pt">ค้างส่ง</td>
                    </tr>
                    <tr>
                        <td width="2%"></td><td width="5%">#</td><td width="10%" style="font-size:14pt">ItemID</td><td width="15%" style="font-size:14pt">POItemType</td><td width="20%" style="font-size:14pt">Itemdetail</td><td width="10%" style="font-size:14pt">จำนวน</td><td width="10%" style="font-size:14pt">ราคา/หน่วย</td><td width="10%" style="font-size:14pt">หน่วย</td><td width="10%" style="font-size:14pt">จำนวน</td><td width="10%" style="font-size:14pt">จำนวน</td>
                    </tr>
                    <?php
                    $i = 1;
                    $result = app\modules\Inventory\models\VwGr2DetailNew2Cum::findAll(['POID' => $r['POID']]);
                    foreach ($result as $value) {
                        ?>
                        <tr>
                            <td width="2%"></td><td width="5%" style="font-size:14pt"><?php echo $i ?></td><td width="10%" style="font-size:14pt"><?php echo $value['ItemID'] ?></td><td width="15%" style="font-size:14pt"><?php echo $value['POItemType'] ?></td><td width="20%" style="font-size:14pt"><?php echo $value['ItemName'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['POQty'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['POUnitCost'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['POUnit'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['GRReceivedQty_cum'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['GRLeftItemQty_cum'] ?></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </table>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
