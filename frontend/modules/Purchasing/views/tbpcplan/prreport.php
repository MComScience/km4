<?php

use yii\bootstrap\Html;
?>
<html>
    <head></head>
    <body >
        <table border="0" width="100%">
            <tr>
                <td width="40%">
                    <?= Html::img('images/logo_iop_doc.jpg', ['width' => 100, 'height' => 100]) ?>
                </td>
                <td style="text-align: left;font-size: 20pt;">
                    <strong>บันทึกข้อความ</strong>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;font-size: 16pt;" colspan="2">
                    <br>
                    ส่วนราชการ  <u>กลุ่มงานเภสัชกรรรม โรงพยาบาลมะเร็งอุดรธานี</u>
        </td>
    </tr>
    <tr>
        <td style="text-align: left;font-size: 16pt;" colspan="2">
            ที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>สธ๐๓๑๒.๕.๒.๑๒/ <?php echo $model->PRNum ?></u> &nbsp;&nbsp;&nbsp;วันที่ <u><?php echo Yii::$app->componentdate->convertnumbermonthyearthai($model->PRDate) ?></u>
</td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        เรื่อง     <u>รายงานขอชื้อยา</u>
</td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        <br>
        เรียน     ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี
    </td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่กลุ่มงานเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี ได้รับอนุมัติแผนการจัดชื้อยาและเวชภัณฑ์มิใช่ยา ประจำปีงบประมาณ ๒๕๕๘ แล้วนั้น  บัดนี้จึงใคร่ขอจัดทำรายงานขอชื้อยาและเวชภัณฑ์มิใช่ยา โดยมีรายละเอียดดังนี้<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๑. เหตุผลและความจำเป็น เพื่อให้ทันต่อความต้องการการใช้ยาผูป่วย<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๒. รายละเอียดยา<br>
        <?php
        $i = 1;
        $rs = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($rs as $value) {
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::$app->componentdate->format_number($i) ?>. <?php echo $value->ItemName; ?> (<?php echo $value->ItemPackNote; ?>) จำนวน <?php echo $value->PRQty ?> <?php echo $value->PRUnit ?><br>
            <?php $i++;
        }
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๓. ราคาที่เคยชื้อยาครั้งหลังสุด<br>
        <?php
        $x = 1;
        $result = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($result as $value) {
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::$app->componentdate->format_number($x) ?>. <?php echo $value->ItemName; ?> (<?php echo $value->ItemPackNote; ?>) ราคา  xxx บาท <?php echo $value->PRUnit ?><br>
            <?php $x++;
        }
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๔. วงเงินที่จะชื้อยา เงินนอกงบประมาณจากรายได้ของหน่วยงาน จำนวน <?php echo Yii::$app->componentdate->format_number($model->PRTotal); ?> บาท<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๕. กำหนดเวลาที่ต้องใช้ยา กำหนดการส่งมอบยาภายใน <?php echo $model->PRExpectDate ?> วัน นับจากวันลงนามในใบสั่งชื้อ<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๖. วิธีที่จะชื้อยา และเหตุผลที่ต้องชื้อยา ดำเนินการ <?php echo $model->POType ?> เนื่องจากชื้อครั้งนี้ไม่เกิน <?php echo $model->POPriceLimit ?> บาท อ้างอิงตามคำสั่งเลขที่ กค (กวพ) ๐๔๒๑.๓/ว๒๙๙ ลว.๒๘ สิงหาคม ๒๕๕๘<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๗. ข้อเสนออื่นๆ คณะกรรมการตรวจรับพัสดุเป็นไปตามคำสั่งเลขที่ ๓๘๒/๒๕๕๘ ลว.๓๐ ก.ย ๒๕๕๘<br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดพิจารณาหากเห็นชอบขอได้โปรดอนุมัติให้ดำเนินการจัดชื้อยาโดยวิธีตกลงประกวดราคาตาม<br>รายละเอียดในรายงานขอชื้อยาดังกล่าวข้างต้น<br>
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
    <td style="text-align: center;font-size: 16pt;" width="50%"><br>
        (นายอิสระ เจียวิริยบุญญา)<br>
        ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี
    </td>
</tr>
</table>
</body>
</html>