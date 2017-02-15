<table border="0"  width="100%">
    <?php
    $rs = \app\modules\Inventory\models\Vwsr2detail2::find()->where(['SRID' => $SRID])->all();
    foreach ($rs as $r) {
        ?>
        <tr>
            <td style="text-align:left;font-size:16pt" width="12%"><?php echo $r['ItemID'] ?></td><td style="text-align:left;font-size:16pt" width="40%"><?php echo $r['ItemDetail'] ?></td><td style="text-align:center;font-size:16pt" width="10%"><?php echo $r['SRApproveQty'] ?></td><td style="text-align:center;font-size:16pt" width="10%"><?php echo $r['SRUnit'] ?></td></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td><td style="text-align:center;font-size:14pt" width="20%"></td>
        </tr>
        <?php
        $result = app\modules\Inventory\models\VwStkPickinglist::findAll(['RefID' => $r['SRID'],'ItemID'=>$r['ItemID']]);
        foreach ($result as $value) {
            ?>
            <tr>
                <td style="text-align:left;font-size:12pt" width="10%"></td><td style="text-align:left;font-size:14pt" width="40%"></td><td style="text-align:center;font-size:14pt" width="10%"></td><td style="text-align:center;font-size:14pt" width="10%"></td><td style="text-align:center;font-size:14pt" width="20%"><?php echo $value['ItemInternalLotNum'] ?></td><td style="text-align:center;font-size:14pt" width="20%"><?php echo $value['ItemExpDate'] ?></td><td style="text-align:center;font-size:14pt" width="20%"><?php echo $value['SPItemQty'] ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    <?php } ?>
</table>
