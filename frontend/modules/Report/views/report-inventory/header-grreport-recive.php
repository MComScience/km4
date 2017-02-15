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
        <td width="20%">

        </td>
        <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
              <strong>ผู้นำเข้า</strong> xxxxxxxxxxxx
        </td>
    </tr>
    <tr>
        <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
            <strong>เอกสารส่งสินค้า</strong>&nbsp;&nbsp; <?php echo $rs->VenderInvoiceNum ?>
        </td>
        <td width="20%">  
        </td>
        <td width="40%" style="text-align:left;font-size:16pt;line-height: 0.9;">
            <strong>กำหนดการส่งมอบ</strong>
            &nbsp;&nbsp; <?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($rs->PODueDate) ?>
        </td>
    </tr>
</table> <p style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</p>