<table border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;" width="100%">
    <thead>
        <tr>
            <td style="text-align:left;font-size:18pt;" width="12%"><strong>รหัสสินค้า</strong></td><td style="text-align:center;font-size:18pt" width="40%"><strong>รายละเอียดสินค้า</strong></td><td style="text-align:center;font-size:18pt" width="10%"><strong>ขอเบิก</strong></td><td style="text-align:center;font-size:18pt" width="10%"><strong>หน่วย</strong></td></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td>
        </tr>
        <tr>
            <td style="text-align:left;font-size:16pt" width="12%"></td><td style="text-align:left;font-size:16pt" width="40%"></td><td style="text-align:center;font-size:16pt" width="10%"></td><td style="text-align:center;font-size:16pt" width="10%"></td></td><td style="text-align:center;font-size:18pt" width="20%"><strong>Int.LotNum</strong></td><td style="text-align:center;font-size:18pt" width="20%"><strong>Exp Date</strong></td><td style="text-align:center;font-size:18pt" width="20%"><strong>จำนวน</strong></td>
        </tr>   
    </thead>
    <tbody>
        <?php
        $rs = \app\modules\Inventory\models\VwSt2DetailGroupClaim2::findAll(['STID' => $STID]);
        foreach ($rs as $r) {
            ?>
            <tr>
                <td width="12%" style="font-size:16pt"><?php echo $r['ItemID'] ?></td><td width="40%" style="font-size:16pt"><?php echo $r['ItemName'] ?></td><td width="10%" style="font-size:16pt;text-align: center" ><?php echo $r['STQty'] ?></td><td width="10%" style="font-size:16pt;text-align: center"><?php echo $r['STUnit'] ?></td><td width="10%" style="font-size:16pt"></td><td width="10%" style="font-size:16pt"></td><td width="10%" style="font-size:16pt;text-align: center"></td>
            </tr>
            <?php
            $result = app\modules\Inventory\models\VwSt2DetailSub2::findAll(['ids' => $r['ids_st']]);
            foreach ($result as $value) {
                ?>
                <tr>
                    <td width="12%" style="font-size:16pt"></td><td width="40%" style="font-size:16pt"></td><td width="10%" style="font-size:16pt"></td><td width="10%" style="font-size:16pt"></td><td width="20%" style="font-size:16pt;text-align: center"><?php echo $value['ItemInternalLotNum'] ?></td><td width="20%" style="font-size:16pt;text-align: center"><?php echo $value['ItemExpDate'] ?></td><td width="20%" style="font-size:16pt;text-align: center"><?php echo $value['STItemQty'] ?></td>
                </tr>
                <?php
            }
            ?>
        <?php } ?>
    </tbody>
</table>
<br>
<table border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;" width="100%" width="100%"> 
    <tr>
        <td style="font-size:16pt">รวมทั้งสิ้น <?php echo \app\modules\Inventory\models\VwSt2DetailGroupClaim2::find()->where(['STID' => $STID])->count(); ?> รายการ</td>
    </tr>
</table>

