<table border="0"  width="100%">
    <?php
    $rs = \app\modules\Inventory\models\Vwsr2detail2::find()->where(['SRID' => $SRID])->orderBy('ItemID')->all();
    foreach ($rs as $r) {
        ?>
        <tr>
            <td style="text-align:left;font-size:18pt;vertical-align: top;" width="12%">
                <strong>
                    <?php echo $r['ItemID'] ?>
                </strong>
            </td>
            <td style="text-align:left;font-size:18pt;vertical-align: top;" width="38%">
                <strong>
                    <?php echo $r['ItemDetail'] ?>
                </strong>
            </td>
            <td style="text-align:center;font-size:18pt;vertical-align: top;" width="10%">
                <strong>
                    <?php echo $r['SRApproveQty'] ?>
                </strong>
            </td>
            <td style="text-align:center;font-size:18pt;vertical-align: top;" width="10%">
                <strong>
                    <?php echo $r['SRUnit'] ?>
                </strong>
            </td>
            <td style="text-align:center;font-size:14pt" width="20%">
                
            </td>
            <td style="text-align:center;font-size:14pt" width="20%"></td>
            <td style="text-align:center;font-size:14pt" width="20%"></td>
        </tr>
        <?php
        $result = app\modules\Inventory\models\VwStkPickinglist::findAll(['RefID' => $r['SRID'],'ItemID'=>$r['ItemID']]);
        foreach ($result as $value) {
            ?>
            <tr>
                <td style="text-align:left;font-size:18pt" width="12%">
                    
                </td>
                <td style="text-align:left;font-size:16pt" width="38%">
                    
                </td>
                <td style="text-align:center;font-size:14pt" width="10%"></td><td style="text-align:center;font-size:14pt" width="10%"></td><td style="text-align:center;font-size:18pt" width="20%"><strong><?php echo $value['ItemInternalLotNum'] ?></strong></td><td style="text-align:center;font-size:18pt" width="20%"><strong><?php  echo !empty($value['ItemExpDate']) ? Yii::$app->componentdate->convertMysqlToThaiDate2($value['ItemExpDate']):'' ?></strong></td><td style="text-align:center;font-size:18pt" width="20%"><strong><?php  echo $value['SPItemQty'] ?></strong></td>
            </tr>
            <?php
        }
        ?>
    <?php } ?>
</table>
<?php
$count = \app\modules\Inventory\models\VwSt2DetailGroup::find()->where(['SRID' => $SRID])->count();
?>
<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>

        <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong></td><td></td><td  style="padding-left:30px"></td>
    </tr>
</table>
