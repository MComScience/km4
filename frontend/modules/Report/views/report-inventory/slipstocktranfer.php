<?php if ($type == 'header') : ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="33%" style="text-align:center;font-size:1.3em;">
                <strong>ใบโอนสินค้าระหว่างคลัง</strong>
            </td>
            <td width="33%" style="text-align:center;">
                <img width="60px" height="60px" src="images/1094650_509.jpg" />
            </td>
            <td width="33%" style="text-align:center;font-size:1.3em;">
                <strong>เลขที่<?php echo $rs->STNum ?></strong>
            </td>
        <tr>
    </table>

    <table  width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%" style="text-align:left;font-size:1.1em;">
                <strong> วันที่</strong> <?php echo $rs->STDate ?>
            </td>
            <td  width="50%" style="text-align:center;font-size:1.1em;">
                <strong>ประเภท
                    <?php echo $rs->STTypeDesc ?></strong>
            </td>
        </tr>
    </table>

    <table  width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="50%" style="text-align:left;font-size:1.1em;"> 
                <strong>จาก&nbsp;&nbsp;<?php echo$rs->Stk_issue ?> </strong>
            </td>
            <td width="50%"  style="text-align:center;font-size:1.1em;">
                <strong>ไป <?php echo $rs->Stk_receive ?> </strong> 
            </td>
        </tr>
    </table>

    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;" >
        <tr>
            <td width="15%" style="font-size:1.1em;text-align:center; ">
                <strong>รหัสสินค้า</strong>
            </td>
            <td width="55%" style="font-size:1.1em;text-align:center">
                <strong>รายละเอียดสินค้า</strong>
            </td>
            <td width="15%" style="font-size:1.1em;text-align: center">
                <strong>จำนวน</strong>
            </td>
            <td width="20%" style="text-align:center;font-size:1.1em;" >
                <strong>หน่วย</strong>
            </td>
        </tr>
    </table>
<?php endif; ?>

<?php if ($type == 'content') : ?>
    <table border="0"  width="100%" cellpadding="0" cellspacing="0"  > 
        <?php
        foreach ($rs1 as $r) {
            ?>
            <tr>
                <td width="15%" style="font-size:1.1em;;text-align: center;vertical-align: top; line-height: 0.9;">
                    <?php echo $r['ItemID'] ?>
                </td>
                <td width="55%" style="font-size:1.1em;vertical-align: top; line-height: 0.9;">
                    <?php echo $r['ItemName'] ?>
                </td>
                <td width="15%" style="font-size:1.1em;text-align: right;vertical-align: top; line-height: 0.9;">
                    <?php echo number_format($r['STQty'], 2) ?>
                </td>
                <td width="20%" style="font-size:1.1em;text-align: center; vertical-align: top; line-height: 0.9;">
                    <?php echo $r['DispUnit'] ?>
                </td>
            </tr>

        <?php } ?>
    </table>
    <?php
    $count = \app\modules\Inventory\models\VwSt2DetailGroup::find()->where(['SRNum' => $SRNum])->count();
    ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="100%" style="font-size:1.1em; border-top: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;">
                <strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong>
            </td>
        </tr>
    </table>
   
<?php endif; ?>

<?php if ($type == 'footer') : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%"  >
        <tr>
            <td  width ="50%" style="text-align:left;font-size: 1em;height: 3px;line-height: 0.8;vertical-align: top;border-bottom: 1px solid #D8D8D8;">
                <b>หมายเหตุ <?php $rs->STNote ?></b> 
            </td>
            <td  width="50%" style="text-align:center;font-size:1em;height: 3px;border-bottom: 1px solid #D8D8D8;"> 
                <strong><?php echo $rs->User_fname . ' ' . $rs->User_lname ?></strong> 
                <br>ผู้โอน
            </td>
        </tr>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" >
        <tr>
            <td width = "50%" style = "text-align:left;height: 3px;line-height: 0.8; vertical-align: bottom;" >
                <p> KM4 medical software</p>
            </td>
    
            <td  width = "50%" style = "text-align:center;height: 3px;">
                <p>Print:<?php echo Yii::$app->componentdate->datenow() . ' ' . Date('H:i') ?></p> 
                <p><?php echo ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname; ?></p>
            </td>
        </tr>
    </table>

<?php endif; ?>



