<table border="0"  width="100%">                   
    <?php
   $rs = \app\modules\Inventory\models\VwSt2DetailGroup::findAll(['SRNum' => $SRNum]);
    foreach ($rs as $r) {
        ?>
        <tr>
            <td width="20%" style="font-size:16pt"><?php echo $r['ItemID'] ?></td><td width="20%" style="font-size:16pt"><?php echo $r['ItemName'] ?></td><td width="20%" style="font-size:16pt;text-align: center" colspan="2"><?php echo $r['DispUnit'] ?></td><td width="20%" style="font-size:16pt"><?php echo $r['STQty'] ?></td>
        </tr>
        <?php
        $result = app\modules\Inventory\models\VwSt2DetailSub::findAll(['ids_sr' => $r['ids']]);
       foreach ($result as $value) {
                   
            ?>
            <tr>
                <td width="20%" style="font-size:16pt"></td><td width="20%" style="font-size:16pt"></td><td width="20%" style="font-size:16pt"><?php echo $value['ItemInternalLotNum'] ?></td><td width="20%" style="font-size:16pt"><?php echo $value['ItemExpDate'] ?></td><td width="20%" style="font-size:16pt"><?php echo $value['STItemQty'] ?></td>
            </tr>
            <?php
       }
        ?>
    <?php } ?>
</table>
