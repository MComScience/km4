<table border="0"  width="100%" cellpadding="0" cellspacing="0">
    <thead>  
        <tr>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;vertical-align: middle;" width="12%">
                <strong>รหัสสินค้า</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;" width="40%">
                <strong>รายละเอียดสินค้า</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;" width="10%" colspan="3">
                <strong>สั่งชื้อ</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;" width="10%">
                <strong>รับแล้ว</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;" width="10%">
                <strong>รับครั้งนี้</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;" width="10%">
                <strong>ราคารวม</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-top: 1px solid black;" width="10%">
                <strong>ค้างส่ง</strong>
            </th>
        </tr>
        <tr>
            <th style="text-align:left;font-size:18pt;border-bottom: 1px solid black;" width="12%">
                <strong></strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-bottom: 1px solid black;" width="40%">
                <strong></strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-bottom: 1px solid black;" width="10%">
                <strong>จำนวน</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-bottom: 1px solid black;" width="10%">
                <strong>ราคา/หน่วย</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-bottom: 1px solid black;" width="10%">
                <strong>หน่วย</strong>
            </th>
            <th style="text-align:center;font-size:18pt;border-bottom: 1px solid black;" width="10%">
                <strong></strong></th>
            <th style="text-align:center;font-size:14pt;border-bottom: 1px solid black;" width="10%">
                
            </th>
            <th style="text-align:center;font-size:14pt;border-bottom: 1px solid black;" width="10%">
                
            </th>
            <th style="text-align:center;font-size:14p;border-bottom: 1px solid black;t" width="10%">
                
            </th>
        </tr>
    </thead>
    <tbody>
       
        <?php
        $rs = \app\modules\Report\models\VwGr2DetailNew2::findAll(['GRNum' => $GRNum]);
        foreach ($rs as $r) {
            ?>
            <tr>
                <td style="text-align:center;font-size:18pt;vertical-align: top;" width="12%"><strong><?php echo $r['ItemID']    ?>
                    </strong>
                </td>
                <td style="text-align:left;font-size:18pt;vertical-align: top;" width="45%">
                    <strong><?php echo $r['ItemName']?></strong>
                </td>
                <td style="text-align:center;font-size:18pt;vertical-align: top;" width="10%">
                    <strong><?php echo number_format($r['POQty']) ?></strong>
                </td>
                <td style="text-align:center;font-size:18pt;vertical-align: top;" width="15%">
                    <strong><?php echo number_format($r['POUnitCost'],2) ?></strong>
                </td>
                <td style="text-align:center;font-size:18pt;vertical-align: top;" width="10%">
                    <strong><?php echo $r['POUnit']?></strong>
                </td>
                <td style="text-align:center;font-size:18pt;vertical-align: top;" width="10%">
                    <strong><?php echo number_format($r['GRReceivedQty'])?></strong>
                </td>
                <td style="text-align:center;font-size:18pt;vertical-align: top;" width="10%">
                    <strong><?php echo number_format($r['GRQty'])?></strong>
                </td>
                <td style="text-align:right;font-size:18pt;vertical-align: top;"  width="10%">
                    <strong><?php echo number_format($r['GRExtenedCost'],2);    ?></strong>
                </td>
                <td style="text-align:right;font-size:18pt;vertical-align: top;" width="10%"><strong>
                    <?php echo $r['GRLeftQty']    ?></strong></td>
            </tr>
           <?php
            $result = app\modules\Report\models\VwGr2LotAssignedDetail2::findAll(['ids_gr' => $r->ids_gr]);
            foreach ($result as $value) {
             ?>
                <tr>
                    <td style="text-align:left;font-size:18pt;" width="12%">
                        <strong></strong>
                    </td>
                    <td style="text-align:left;font-size:18pt;padding-left: 30px" width="45%">
                        <strong><?php echo $value['LN_Detail']    ?></strong>
                    </td>
                    <td style="text-align:center;font-size:18pt" width="10%">
                        <strong><?php echo number_format($value['GRQty']) ?></strong>
                    </td>
                    <td style="text-align:center;font-size:18pt" width="15%">
                        <strong></strong>
                    </td>
                    <td style="text-align:center;font-size:18pt" width="10%">
                        <strong><?php echo $value['GRUnit']    ?></strong>
                    </td>
                    <td style="text-align:center;font-size:18pt" width="10%" colspan="2">
                        <strong><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($value['ItemExpDate'])    ?></strong>
                    </td>
           <td style="text-align:center;font-size:18pt" width="10%">
               <strong></strong>
           </td>
           <td style="text-align:right;font-size:18pt;padding-right:20px"  width="10%">
               <strong></strong>
           </td>
                </tr>
               <?php
            }
        }
        ?>
    </tbody>

   
</table>
    <?php
$count = \app\modules\Report\models\VwGr2DetailNew2::find()->where(['GRNum' => $GRNum])->count();
$sum = \app\modules\Report\models\VwGr2DetailNew2::find()->where(['GRNum' => $GRNum])->sum('GRExtenedCost');
?>
<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>

        <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count;    ?> รายการ</strong></td><td></td><td  style="padding-left:30px;font-size: 16pt"><strong>ราคารวม <?php echo number_format($sum, 2);    ?> บาท</strong></td>
    </tr>
</table>