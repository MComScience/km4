<table width="100%">
    <tr>
        <td width="33%" style="text-align:center;font-size:16pt"><img  height="100px" src="images/logo.jpg" />
        </td>
        <td width="33%" style="text-align:center;font-size:16pt"> 
        </td>
        <td width="33%" style="text-align:center;font-size:20pt"><strong>ใบส่งสินค้า</strong>
        </td>
    <tr>
</table>
<table border="0"  width="100%">
    <tr>
        <td width="40%"><span style="text-align:center;font-size:16pt"><strong>ใบส่งสินค้าเลขที่</strong> <?php echo  $rs->STNum ?> </span>
        </td>
        <td><span style="text-align:center;font-size:16pt"><strong> วันที่</strong><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($rs->STDate) ?></span>
        </td>
        <td><span style="text-align:center;font-size:16pt"><strong>ประเภทการขอเบิก</strong> <?php echo $rs->STTypeDesc ?> </span>
        </td>
    </tr>
    <tr>
        <td><span style="text-align:center;font-size:16pt"><strong>จากคลังสินค้า</strong>&nbsp;&nbsp;<?php echo $rs->StkID_Issue?></span>
        </td>
        <td> 
        </td>
        <td>
        </td>
    </tr>
</table>
<span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>