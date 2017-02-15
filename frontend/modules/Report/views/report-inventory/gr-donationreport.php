<?php if ($type == 'header') : ?>
    <table width="100%" border="0" >
        <tr>
            <td width="33%" style="text-align:center;font-size:20pt">
                <strong>ใบรับสินค้า<br>Goods Receive Report</strong>
            </td>
            <td width="33%" style="text-align:center;">
                <img  height="100px" src="images/logo.jpg"/>
            </td>
            <td width="33%" style="text-align:center;font-size:20pt">
                <strong>เลขที่</strong> <?php echo $rs->GRNum ?> 
            </td>
        </tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong> วันที่</strong> 
                <?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($rs->GRDate) ?> 
            </td>
            <td width="20%">

            </td>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>เอกสารอ้างอิง</strong> 
                <?php echo $rs->PONum . ' ' . Yii::$app->componentdate->convertMysqlToThaiDate2($rs->PODueDate) ?> 
            </td>
        </tr>
        <tr>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>ประเภทการรับสินค้า</strong>&nbsp;&nbsp;<?php echo $rs->GRType ?>

            </td>
            <td></td>
            <td style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>ประเภทการสั่งชื้อ</strong> <?php echo $rs->POType ?>  

            </td>
        </tr>
        <tr>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>ผู้จำหน่าย</strong> <?php echo $rs->VenderName ?> 

            </td>
            <td width="20%">

            </td>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>สัญญาจะชื้อจะขายเลขที่ </strong> 
                &nbsp;&nbsp;<?php echo empty($rs->POContactNum) ? '-' : $rs->POContactNum ?> 

            </td>
        </tr>
        <tr>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>ผู้ผลิต</strong> xxxxxxxx 

            </td>
            <td width="20%" style="text-align:left;font-size:16pt;line-height: 0.9;">

            </td>
            <td width="40%"  style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>เอกสารส่งสินค้า</strong>&nbsp;&nbsp; <?php echo $rs->VenderInvoiceNum ?>
            </td>
        </tr>
        <tr>
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">

            </td>
             <td width="20%" style="text-align:left;font-size:16pt;line-height: 0.9;">

            </td>
            
            <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
                <strong>กำหนดการส่งมอบ</strong>
                &nbsp;&nbsp; <?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($rs->PODueDate) ?>
            </td>
        </tr>
    </table> <p style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</p>


<?php endif; ?>

<?php if ($type == 'content') : ?>

    <table border="0"  width="100%" cellpadding="0" cellspacing="0">
        <thead>  
            <tr>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black;vertical-align: middle; border-bottom:1px solid black;" width="12%">
                    <strong>รหัสสินค้า</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black; border-bottom:1px solid black;" width="40%">
                    <strong>รายละเอียดสินค้า</strong>
                </th>

                <th style="text-align:center;font-size:16pt;border-top: 1px solid black; border-bottom:1px solid black;" width="10%">
                    <strong>รับครั้งนี้</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black; border-bottom:1px solid black;" width="12%">
                    <strong>หน่วย</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black; border-bottom:1px solid black;" width="15%">
                    <strong>ราคารวม</strong>
                </th>
                <th style="text-align:center;font-size:16pt;border-top: 1px solid black; border-bottom:1px solid black;" width="13%">
                    <strong>ค้างส่ง</strong>
                </th>
            </tr>

        </thead>
        <tbody>

            <?php
            $rs = \app\modules\Report\models\VwGr2DetailNew2::findAll(['GRNum' => $GRNum]);
            foreach ($rs as $r) {
                ?>
                <tr>
                    <td style="text-align:center;font-size:16pt;vertical-align: top;" width="12%"><strong><?php echo $r['ItemID'] ?>
                        </strong>
                    </td>
                    <td style="text-align:left;font-size:16pt;vertical-align: top;" width="45%">
                        <strong><?php echo $r['ItemName'] ?></strong>
                    </td>

                    <td style="text-align:center;font-size:16pt;vertical-align: top;" width="10%">
                        <strong><?php echo number_format($r['GRQty'], 2) ?></strong>
                    </td>

                    <td style="text-align:center;font-size:16pt;vertical-align: top;" width="10%">
                        <strong><?php echo $r['POUnit'] ?></strong>
                    </td>
                    <td style="text-align:center;font-size:16pt;vertical-align: top;"  width="10%">
                        <strong><?php echo number_format($r['GRExtenedCost'], 2); ?></strong>
                    </td>
                    <td style="text-align:center;font-size:16pt;vertical-align: top;" width="10%"><strong>
                            <?php echo $r['GRLeftQty'] ?></strong></td>
                </tr>
                <?php
                $result = app\modules\Report\models\VwGr2LotAssignedDetail2::findAll(['ids_gr' => $r->ids_gr]);
                foreach ($result as $value) {
                    ?>
                    <tr>
                        <td style="text-align:left;font-size:14pt;padding-left: 100px" width="45%" colspan="2">
                            <strong><?php echo $value['LN_Detail'] ?></strong>
                        </td>
                        <td style="text-align:center;font-size:14pt" width="15%">
                            <strong><?php echo $value['GRQty'] ?></strong>
                        </td>
                        <td style="text-align:center;font-size:14pt" width="10%">
                            <strong><?php echo $value['GRUnit'] ?></strong> 
                        </td>
                        <td style="text-align:center;font-size:14pt" width="10%" colspan="2">
                            <strong><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($value['ItemExpDate']) ?></strong>
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

            <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong></td><td></td><td  style="padding-left:30px;font-size: 16pt"><strong>ราคารวม <?php echo number_format($sum, 2); ?> บาท</strong></td>
        </tr>
    </table>

<?php endif; ?>


<?php if ($type == 'footer') : ?>
    <?php
    $queryuser = app\modules\pharmacy\models\VwUserprofile::findOne(['user_id' => $rs['GRCreatedBy']]);
    ?>

    <table border="0"  width="100%" >
        <tr>
            <td style="text-align:left; font-size: 16pt;"  width="20%">
                หมายเหตุ <?php echo $rs->GRNote ?></td>
            <td style="font-size:16pt"  width="20%"></td>
            <td style="font-size:16pt"  width="20%"></td>
            <td style="text-align:center;font-size:16pt"  width="20%">
                <?php echo $queryuser['User_name'] ?>
                <br>ผู้รับสินค้า
            </td>
        </tr>
    </table>
    <table border="0" width="100%" style="border-top: 1px solid black;">
        <tr>
            <td style="text-align:left; font-size: 12pt;"  width="50%">KM4 medical software</td>
            <td style="text-align:right; font-size: 12pt;"  width="50%"> 
                Print:<?php echo Yii::$app->componentdate->datenow() . ' ' . Date('H:i') ?>
                <?php echo ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname ?>
            </td>
        </tr>
    </table>
<?php endif; ?>

