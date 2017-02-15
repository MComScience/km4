<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
    <tr>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>เลขที่ใบขอชื้อ</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>วันที่</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>ผู้ขอชื้อ</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>เหตุผลการขอชื้อ</strong>
        </td>
        <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
            <strong>เหตุผลการไม่อนุมัติ</strong>
        </td>
    </tr>

    <?php
    foreach ($rs as $r) {
        ?>
        <tr>
            <td  style="font-size:16pt"><?php echo $r['PRNum'] ?></td><td  style="font-size:16pt"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($r['PRDate']) ?></td><td  style="font-size:16pt"><?php echo $r['PRCreatedBy'] ?></td><td  style="font-size:16pt"><?php echo $r['PRReasonNote'] ?></td><td  style="font-size:16pt"><?php echo$r['PRRejectReason'] ?></td>
        </tr>
        <tr>
            <td  colspan="5">
                <table border="0"  width="100%">
                    <tr>
                        <td width="2%"></td><td width="15%" style="font-size:14pt">รหัสสินค้า</td><td width="30%" style="font-size:14pt">รายละเอียดสินค้า</td><td width="10%" style="font-size:14pt">จำนวน</td><td width="10%" style="font-size:14pt">ราคา/หน่วย</td><td width="10%"  style="font-size:14pt">หน่วย</td><td width="10%" style="font-size:14pt">ราคารวม</td>
                    </tr>
                    <?php
                    $result = app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $r['PRNum']]);
                    foreach ($result as $value) {
                        ?>
                        <tr>
                            <td width="2%"></td><td width="15%" style="font-size:14pt"><?php echo $value['TMTID_GPU'] ?></td><td width="20%" style="font-size:14pt"><?php echo $value['ItemName'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['VerifyQty'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['VerifyUnitCost'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['VerifyUnit'] ?></td><td width="10%" style="font-size:14pt"><?php echo number_format($value['ExtenedCost'], 2) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </td>
        </tr>
    <?php } ?>
</table>
