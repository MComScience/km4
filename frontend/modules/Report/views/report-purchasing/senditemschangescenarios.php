<table border="0" cellpadding="0" cellspacing="0"  width="100%">
    <thead>
            <tr>
                <td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>เลขที่ใบส่งสินค้า</strong>
                </td>
                <td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>วันที่</strong>
                </td><td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>ผู้ขาย</strong>
                </td><td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>ประเภทการส่งสินค้า</strong>
                </td>
                <td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>กำหนดส่งมอบ</strong>
                </td>
            </tr>
    </thead>
    <tbody>
    <?php
    $rs = \app\modules\Inventory\models\VwSt2ListForGr2::find()->all();
    foreach ($rs as $r) {
        ?>
        <tr>
            <td style="text-align:center;font-size:16pt"><?php echo $r['STNum'] ?></td><td  style="text-align:center;font-size:16pt"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate($r['STDate']) ?></td><td  style="text-align:center;font-size:16pt"><?php echo $r['VenderName'] ?></td><td  style="text-align:center;font-size:16pt"><?php echo $r['STTypeDesc'] ?></td><td  style="text-align:center;font-size:16pt"><?php echo $r['STDueDate'] ?></td>
        </tr>
        <tr>
            <td  colspan="5">
                <table border="0"  width="100%">
                    <tr>
                        <td width="2%"></td><td width="5%">ลำดับ</td><td width="15%">รหัสสินค้า</td><td width="10%">ประเภทสินค้า</td><td width="20%">รายการสินค้า</td><td width="10%"></td><td width="10%">สั่งชื้อ</td><td width="10%"></td><td>รับแล้ว</td><td>ค้างส่ง</td>
                    </tr>
                    <tr>
                        <td width="2%"></td><td width="5%">#</td><td width="10%">ItemID</td><td width="15%">POItemType</td><td width="20%">Itemdetail</td><td width="10%">จำนวน</td><td width="10%">ราคา/หน่วย</td><td width="10%">หน่วย</td><td width="10%">จำนวน</td><td width="10%">จำนวน</td>
                    </tr>
                    <?php
                    $i = 1;

                    $result = app\modules\Inventory\models\VwGr2DetailNew2Cum::findAll(['POID' => $r['STID']]);
                    foreach ($result as $value) {
                        ?>
                        <tr>
                            <td width="2%"></td><td width="5%"><?php echo $i ?></td><td width="10%"><?php echo $value['ItemID'] ?></td><td width="15%"><?php echo $value['POItemType'] ?></td><td width="20%"><?php echo $value['ItemName'] ?></td><td width="10%"><?php echo $value['POQty'] ?></td><td width="10%"><?php echo $value['POUnitCost'] ?></td><td width="10%"><?php echo $value['POUnit'] ?></td><td width="10%"><?php echo $value['GRReceivedQty_cum'] ?></td><td width="10%"><?php echo $value['GRLeftItemQty_cum'] ?></td>
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