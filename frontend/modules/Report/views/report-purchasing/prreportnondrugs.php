<?php

use yii\bootstrap\Html;
use app\modules\Report\models\VwPr2Reasonselected;
?>
<html>
    <body >
        <table border="0" width="100%">
            <tr>
                <td colspan="2">
                    <table border="0" width="100%">
                        <tr>
                            <td width="33%"><?php echo Html::img('images/logo_iop_doc.jpg', ['width' => 100, 'height' => 100]) ?></td><td  width="33%"><span style="text-align: center;font-size: 28pt;" ><strong>บันทึกข้อความ</strong></span></td><td  width="33%"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;font-size: 16pt;" colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;ส่วนราชการ <span  > <u>กลุ่มงานเภสัชกรรรม โรงพยาบาลมะเร็งอุดรธานี&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
        </td>
    </tr>
    <tr>
        <td style="text-align: left;font-size: 16pt;" colspan="2">
            &nbsp;&nbsp;&nbsp;&nbsp;ที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span  ><u>สธ๐๓๑๒.๕.๒.๑๒/ <?php echo Yii::$app->componentdate->arabic_to_thai($model->PRNum) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>&nbsp;&nbsp;&nbsp;&nbsp;วันที่ <span  ><u><?php echo Yii::$app->componentdate->convertnumbermonthyearthai(Yii::$app->componentdate->convertToMysql($model->PRDate)) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;</u></span>
</td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        &nbsp;&nbsp;&nbsp;&nbsp;เรื่อง   <span >  <u>รายงานขอชื้อเวชภัณฑ์มิใช่ยา &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
</td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        <span style="font-size: 6pt;color: white">xxx</span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;เรียน     ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี
    </td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;padding-left: 19px" colspan="2"> <span style="font-size: 6pt;color: white">xxx</span><br>
        <span style="text-align: left;">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่กลุ่มงานเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี ได้รับอนุมัติแผนการจัดชื้อยาและเวชภัณฑ์มิใช่ยา ประจำปีงบประมาณ ๒๕๕๘ แล้วนั้น  บัดนี้จึงใคร่ขอจัดทำรายงานขอชื้อยาและเวชภัณฑ์มิใช่ยา โดยมีรายละเอียดดังนี้<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๑. เหตุผลและความจำเป็น <br>
        <?php
        $j = 1;
        $re = VwPr2Reasonselected::findAll(['PRID' => $model->PRID]);
        foreach ($re as $r) {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . Yii::$app->componentdate->arabic_to_thai($j) . '.&nbsp;' . $r->PRReason . '<br>';
            $j++;
        }
        ?> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๒. รายละเอียดของเวชภัณฑ์มิใช่ยา<br>
        <?php
        $i = 1;
        $rs = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($rs as $value) {
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::$app->componentdate->format_number($i) ?>. <?php echo $value->ItemName; ?>  จำนวน <?php echo Yii::$app->componentdate->format_number($value->PRQty) ?> <?php echo $value->PRUnit ?> ราคา <?php echo Yii::$app->componentdate->format_number($value->PRUnitCost); ?> บาท<br>
            <?php
            $i++;
        }
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๓. ราคาที่เคยชื้อเวชภัณฑ์มิใช่ยาครั้งหลังสุด<br>
        <?php
        $x = 1;
        $result = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($result as $value) {
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::$app->componentdate->format_number($x) ?>. <?php echo $value->ItemName; ?>  ราคา  <?php echo Yii::$app->componentdate->format_number($value->PRLastUnitCost) ?> บาท <?php echo $value->PRUnit ?><br>
            <?php
            $x++;
        }
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๔. วงเงินที่จะชื้อเวชภัณฑ์มิใช่ยา <?php echo $model->PRbudget; ?> จำนวน <?php echo Yii::$app->componentdate->format_number($model->PRTotal); ?> บาท<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๕. กำหนดเวลาที่ต้องใช้ยา กำหนดการส่งมอบยาภายใน <?php echo Yii::$app->componentdate->format_number($model->PRExpectDate) ?> วัน นับจากวันลงนามในใบสั่งชื้อ<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๖. วิธีที่จะชื้อเวชภัณฑ์มิใช่ยา และเหตุผลที่ต้องชื้อเวชภัณฑ์มิใช่ยา ดำเนินการ <?php echo $model->POType ?> เนื่องจากชื้อครั้งนี้ไม่เกิน <?php echo Yii::$app->componentdate->format_number($model->POPriceLimit) ?> บาท อ้างอิงตามคำสั่งเลขที่ กค (กวพ) ๐๔๒๑.๓/ว๒๙๙ ลว.๒๘ สิงหาคม ๒๕๕๘<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๗. ข้อเสนออื่นๆ คณะกรรมการตรวจรับพัสดุเป็นไปตามคำสั่งเลขที่ ๓๘๒/๒๕๕๘ ลว.๓๐ ก.ย ๒๕๕๘<br><span style="font-size: 6pt;color: white">xxx</span><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาหากเห็นชอบขอได้โปรดอนุมัติให้ดำเนินการจัดชื้อเวชภัณฑ์มิใช่ยาโดยวิธีตกลงประกวดราคา ตามรายละเอียดในรายงานขอชื้อเวชภัณฑ์มิใช่ยาดังกล่าวข้างต้น<br>
        </span>
        </td>
</tr>
<tr>
    <td style="text-align: center;font-size: 16pt;" width="50%"><br><br>
        (นางสาวอารยา ลักขณาวรรณกุล)<br>
        หัวหน้าเจ้าหน้าที่พัสดุ
    </td>
    <td style="text-align: center;font-size: 16pt;" width="50%"><br>
        (นางวราภรณ์ บุญประคม)<br>
        เจ้าหน้าที่พัสดุ
    </td>
</tr>
<tr>
    <td style="text-align: center;font-size: 16pt;" width="50%"><br><br>

    </td>
    <td style="text-align: center;font-size: 16pt;" width="50%"><br><br>
        (นายอิสระ เจียวิริยบุญญา)<br>
        ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี
    </td>
</tr>
</table>
</body>
</html>
