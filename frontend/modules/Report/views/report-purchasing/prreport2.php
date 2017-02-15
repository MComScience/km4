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
                            <td width="33%"><?php echo Html::img('images/logo_iop_doc.jpg', ['width' => 100, 'height' => 100]) ?></td><td  width="33%"><span style="text-align: center;font-size: 23pt;" ><strong>บันทึกข้อความ</strong></span></td><td  width="33%"></td>
                        </tr>
                    </table>
                    
                    
                </td>
            </tr>
            <tr>
                <td style="text-align: left;font-size: 16pt;" colspan="2">
                    ส่วนราชการ  กลุ่มงานเภสัชกรรรม โรงพยาบาลมะเร็งอุดรธานี
        </td>
    </tr>
    <tr>
        <td style="text-align: left;font-size: 16pt;" colspan="2">
            ที่&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;สธ๐๓๑๒.๕.๒.๑๒/ <?php echo  Yii::$app->componentdate->arabic_to_thai($model->PRNum) ?> &nbsp;&nbsp;&nbsp;วันที่ <?php echo Yii::$app->componentdate->convertnumbermonthyearthai(Yii::$app->componentdate->convertToMysql($model->PRDate)) ?>
</td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        เรื่อง     รายงานขอชื้อยา
</td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        เรียน     ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี
    </td>
</tr>
<tr>
    <td style="text-align: left;font-size: 16pt;" colspan="2">
        <br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ตามที่กลุ่มงานเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี ได้รับอนุมัติแผนการจัดชื้อยาและเวชภัณฑ์มิใช่ยา ประจำปีงบประมาณ ๒๕๕๘ แล้วนั้น  บัดนี้จึงใคร่ขอจัดทำรายงานขอชื้อยาและเวชภัณฑ์มิใช่ยา โดยมีรายละเอียดดังนี้<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๑. เหตุผลและความจำเป็น <br>
      <?php
      $i = 1;
  $result = VwPr2Reasonselected::findAll(['PRID'=>$model->PRID]);
  foreach ($result as $r){ 
      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;๑.'.Yii::$app->componentdate->arabic_to_thai($i).'&nbsp;'.$r->PRReason.'<br>';
      $i++;
      } ?> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๒. รายละเอียดยา<br>
		<table border="0" width="100%">
		<tr>
		<td style="text-align:center;font-size:14pt">ลำดับ</td><td style="text-align:center;font-size:14pt">ชื่อยา</td><td style="text-align:center;font-size:14pt">จำนวน x หน่วยบรรจุ</td><td style="text-align:center;font-size:14pt">ราคาที่เคยชื้อหลังสุด</td><td style="text-align:center;font-size:14pt">ราคาที่จะชื้อ</td><td style="text-align:center;font-size:14pt">ยอดรวม</td>
		<td style="text-align:center;font-size:14pt">หมายเหตุ</td>
		</tr>
<?php
$x = 1;
        $rs = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($rs as $value) {
            ?>
			<tr>
			<td style="text-align:left;font-size:14pt"><?php echo Yii::$app->componentdate->arabic_to_thai($x); ?></td><td style="text-align:left;font-size:14pt"><?php echo $value->ItemName; ?></td><td style="text-align:center;font-size:14pt"><?php echo $value->PRQty; ?> * <?php echo $value->PRUnit ?></td><td style="text-align:center;font-size:14pt"><?php echo $value->PRLastUnitCost; ?></td><td style="text-align:center;font-size:14pt"><?php echo number_format($value->PRApprovedUnitCost,2); ?></td><td style="text-align:center;font-size:14pt"><?php echo number_format($value->ExtenedCost,2); ?></td><td></td>
            </tr>
			<?php 
       $x++; }
        ?>
		</table>
        <?php
        /*$i = 1;
        $rs = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($rs as $value) {
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::$app->componentdate->format_number($i) ?>. <?php echo $value->ItemName; ?>  จำนวน <?php echo Yii::$app->componentdate->format_number($value->PRQty) ?> <?php echo $value->PRUnit ?><br>
            <?php $i++;
        }*/
        ?>
        <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๓. ราคาที่เคยชื้อยาครั้งหลังสุด<br>-->
        <?php
       /* $x = 1;
        $result = \app\modules\Purchasing\models\VwPritemdetail2New::findAll(['PRNum' => $model->PRNum]);
        foreach ($result as $value) {
            ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo Yii::$app->componentdate->format_number($x) ?>. <?php echo $value->ItemName; ?>  ราคา  <?php echo Yii::$app->componentdate->format_number($value->PRLastUnitCost) ?> บาท <?php echo $value->PRUnit ?><br>
            <?php $x++;
        }*/
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๓. วงเงินที่จะชื้อยา เงินนอกงบประมาณจากรายได้ของหน่วยงาน จำนวน <?php echo Yii::$app->componentdate->format_number($model->PRTotal); ?> บาท<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๔. กำหนดเวลาที่ต้องใช้ยา กำหนดการส่งมอบยาภายใน <?php echo Yii::$app->componentdate->format_number($model->PRExpectDate) ?> วัน นับจากวันลงนามในใบสั่งชื้อ<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๕. วิธีที่จะชื้อยา และเหตุผลที่ต้องชื้อยา ดำเนินการ <?php echo $model->POType ?> เนื่องจากชื้อครั้งนี้ไม่เกิน <?php echo Yii::$app->componentdate->format_number($model->POPriceLimit) ?> บาท อ้างอิงตามคำสั่งเลขที่ กค (กวพ) ๐๔๒๑.๓/ว๒๙๙ ลว.๒๘ สิงหาคม ๒๕๕๘<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ๖. ข้อเสนออื่นๆ คณะกรรมการตรวจรับพัสดุเป็นไปตามคำสั่งเลขที่ ๓๘๒/๒๕๕๘ ลว.๓๐ ก.ย ๒๕๕๘<br><br>
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
