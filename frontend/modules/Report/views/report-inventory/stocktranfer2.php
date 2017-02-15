<table border="0"  width="100%">                   
    <?php
    $rs = \app\modules\Inventory\models\VwSt2DetailGroup::findAll(['SRNum' => $SRNum]);
    foreach ($rs as $r) {
        ?>

        <tr>
            <td width="10%" style="font-size:16pt;text-align: center"><?php echo $r['ItemID'] ?></td><td width="40%" style="font-size:16pt"><?php echo $r['ItemName'] ?></td><td width="10%" style="font-size:16pt;text-align: center" ><?php echo $r['SRQty1'] ?></td><td style="font-size:16pt;text-align: center" width="10%"><?php echo $r['SRUnit1'] ?></td><td width="10%" style="font-size:16pt;text-align: center"><?php echo $r['STQty'] ?></td><td width="10%" style="font-size:16pt;text-align: right"><?php echo $r['DispUnit'] ?></td>
        </tr>
        <?php
        $result = app\modules\Inventory\models\VwSt2DetailSub::findAll(['ids_sr' => $r['ids']]);
        foreach ($result as $value) {   
            ?>
            <tr>
                <td width="10%" style="font-size:16pt"></td><td width="40%" style="font-size:16pt"></td><td width="15%" style="font-size:14pt;text-align: center"><?php echo $value['ItemInternalLotNum']   ?></td><td width="15%" style="font-size:14pt;text-align: center"><?php echo $value['ItemExpDate']   ?></td><td width="10%" style="font-size:14pt;text-align: center" colspan="2"><?php echo $value['STItemQty']   ?></td>
            </tr>
            <?php
        }
        ?>
    <?php } ?>
</table>
<?php
$count = \app\modules\Inventory\models\VwSt2DetailGroup::find()->where(['SRNum' => $SRNum])->count();
?>
<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>

        <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong></td><td></td><td  style="padding-left:30px"></td>
    </tr>
</table>
