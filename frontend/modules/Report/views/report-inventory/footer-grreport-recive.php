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
            <?php echo $queryuser['User_name']?>
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