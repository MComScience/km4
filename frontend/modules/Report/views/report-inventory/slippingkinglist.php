<?php if ($type == 'header') : ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="33%" style="text-align:center;font-size:1.2em;">
                <strong>ใบจัดสินค้าตามใบขอเบิก</strong>
            </td>
            <td width="33%" style="text-align:center;">
                <img width="70px" height="70px" src="images/1094650_509.jpg" />
            </td>
            <td width="33%" style="text-align:center;font-size:1.4em;">
                <strong>เลขที่&nbsp;&nbsp;<?= $rs->SRNum ?></strong>
            </td>
        <tr>
    </table>
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
        <tr>

            <td width="50%" style="text-align:left;font-size:1.1em" >
                <strong>จาก&nbsp;&nbsp;<?php echo $rs->stk_issue; ?>
                </strong> 
            </td>
            <td width="50%" style="text-align:right;font-size:1.1em" >
                <strong>ไป&nbsp;&nbsp;<?php echo $rs->stk_receive; ?> </strong>
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #D8D8D8;border-bottom: 1px solid #D8D8D8;" >
        <tr>
            <td style="text-align:left;font-size:1.1em;" width="15%">
                <strong>รหัสสินค้า</strong>
            </td>
            <td style="text-align:center;font-size:1.1em;" width="55%">
                <strong>รายละเอียดสินค้า</strong>
            </td>
            <td style="text-align:center;font-size:1.1em;" width="15%">
                <strong>ขอเบิก</strong>
            </td>
            <td style="text-align:center;font-size:1.1em;" width="15%">
                <strong>หน่วย</strong>
            </td>

        </tr>

    </table>
<?php endif; ?>

<?php if ($type == 'content') : ?>
    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
        <?php foreach ($rs1 as $r) : ?>
            <tr>
                <td style="text-align:left;font-size:1.1em;line-height: 1;vertical-align: top;" width="15%">
                    <strong><?php echo $r['ItemID']; ?></strong>  
                </td>
                <td style="text-align:left;font-size:1em;line-height: 1;vertical-align: top;" width="55%">
                    <strong> <?php echo $r['ItemDetail']; ?></strong>
                </td>
                <td style="text-align:center;font-size:1.1em;line-height: 1;vertical-align: top;" width="15%">
                    <strong><?php echo number_format($r['SRApproveQty'], 2); ?></strong> 
                </td>
                <td style="text-align:center;font-size:1.1em;;white-space: nowrap;line-height: 1;vertical-align: top;" width="15%">
                    <strong><?php echo $r['SRUnit']; ?></strong>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php
    $count = \app\modules\Inventory\models\VwSt2DetailGroup::find()->where(['SRID' => $SRID])->count();
    ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td width="100%" style="font-size:12pt;border-bottom: 1px solid #D8D8D8;border-top:1px solid #D8D8D8">
                <strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong> 
            </td>
           
        </tr>
    </table>
<?php endif; ?>

<?php if ($type == 'footer') : ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid #D8D8D8;">
        <tr>
            <td style="text-align:left; font-size: 10pt;"  width="40%">KM4 medical software</td>
            <td style="text-align:center;font-size: 10pt;"  width="60%">
                <p> Print:<?php echo Yii::$app->componentdate->datenow() . ' ' . Date('H:i:s') ?><p/>
                <p><?php echo ' by ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname; ?></p>
            </td>
        </tr>
    </table>
<?php endif; ?>












