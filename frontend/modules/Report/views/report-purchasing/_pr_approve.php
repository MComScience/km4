<?php

use yii\helpers\Html;

$i = 1;
$j = 1;
$k = 1;
?>
<?php if ($type == 'c' && $model['PRTypeID'] == '1' || $model['PRTypeID'] == '2' || $model['PRTypeID'] == '4' || $model['PRTypeID'] == '6' || $model['PRTypeID'] == '7') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td width="33.3%">
                <?php echo Yii::$app->report->logo('ครุฑ', 90, 90); ?>
            </td>
            <td width="33.3%" style="text-align: center;font-size: 25pt;">
                <?php echo 'บันทึกข้อความ'; ?> 
            </td>
            <td width="33.3%">

            </td>
        </tr>
    </table>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2" style="font-size: 16pt;line-height: 1;">
                <?php echo 'ส่วนราชการ ' . '<u>' . 'กลุ่มงานเภสัชกรรรม โรงพยาบาลมะเร็งอุดรธานี'; ?>
                <?php echo Yii::$app->report->Genndsp(71); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 16pt;line-height: 1;">
                <?php echo 'ที่ ' . '<u>สธ๐๓๑๒.๕.๒.๑๒/ ' . Yii::$app->numberthai->arabicToThaiNumber($model['PRNum']); ?>
                <?php echo Yii::$app->report->Genndsp(25); ?>
                <?php echo '</u>'; ?>
            </td>
            <td width="50%" style="font-size: 16pt;line-height: 1;">
                <?php echo 'วันที่ ' . '<u>' . Yii::$app->numberthai->arabicToThaiNumber(Yii::$app->dateconvert->FullMonth($model['PRDate'])); ?>
                <?php echo Yii::$app->report->Genndsp(36); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 16pt;line-height: 1;">
                <?php echo 'เรื่อง ' . '<u>' . 'ขออนุมัติแผนเพิ่ม'; ?>
                <?php echo Yii::$app->report->Genndsp(118); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>
    </table>
    <p style="font-size: 16pt;"><?php echo 'เรียน ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี'; ?></p>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="font-size: 16pt;line-height: 1;" width="100%">
                <?php echo Yii::$app->report->Genndsp(5); ?>
                <?php echo 'ตามที่กลุ่มงานเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี ได้รับอนุมัติแผนการจัดชื้อยาและเวชภัณฑ์มิใช่ยา ประจำปีงบประมาณ&nbsp;๒๕๕๘&nbsp;แล้วนั้น&nbsp;บัดนี้กลุ่มงานเภสัชกรรมได้จัดซื้อครบแผนแล้ว&nbsp;กลุ่มงานเภสัชกรรมจึงขออนุมัติแผนเพิ่ม ดังนี้'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;">
                <?php echo '<p>' . Yii::$app->report->Genndsp(5) . '๑. เหตุผลและความจำเป็น</p>'; ?>

                <?php foreach ($reson as $v) : ?>
                    <?php echo '<p>' ?>
                    <?php echo Yii::$app->report->Genndsp(9); ?>
                    <?php echo Yii::$app->numberthai->arabicToThaiNumber($i) . '.&nbsp;' . $v->PRReason . '</p>'; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1; padding-left: 5px; " >
                <p><?php echo '๒. รายละเอียดยา'; ?></p>
                <table border="0" width="100%">
                    <tr>
                        <td style="font-size: 16pt;line-height: 1;">
                            <?php foreach ($detail as $v) : ?>
                                <p style="line-height: 1;"> <?php echo Yii::$app->report->Genndsp(9) . Yii::$app->numberthai->arabicToThaiNumber($j) . '.&nbsp;' . $v->ItemName . ' จำนวน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($v->PRQty)) . ' ราคา ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($v->PRUnitCost, 2)) . ' บาท'; ?></p>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <p><?php echo '๓. ราคาที่เคยซื้อครั้งล่าสุด'; ?></p>

                <?php foreach ($detail as $v) : ?>
                    <p> <?php echo Yii::$app->report->Genndsp(9) . Yii::$app->numberthai->arabicToThaiNumber($k) . '.&nbsp;' . $v->ItemName . ' ราคา ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($v->PRLastUnitCost, 2)) . ' บาท' . ' ' . $v->PRUnit; ?></p>
                    <?php $k++; ?>
                <?php endforeach; ?>

            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <p><?php echo '๔. วงเงินที่จะชื้อยา ' . $model->PRbudget . ' จำนวน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($model->PRTotal)) . ' บาท'; ?></p>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <?php echo '<p>๕. กำหนดเวลาที่ต้องใช้ยา กำหนดการส่งมอบยาภายใน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($model->PRExpectDate)) . ' วัน นับจากวันลงนามในใบสั่งชื้อ</p>'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <?php echo '<p>๖. วิธีที่จะชื้อยา และเหตุผลที่ต้องชื้อยา ดำเนินการ ' . $model->POType . ' เนื่องจากชื้อครั้งนี้ไม่เกิน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($model->POPriceLimit)) . ' บาท อ้างอิงตามคำสั่งเลขที่ กค (กวพ) ๐๔๒๑.๓/ว๒๙๙ ลว.๒๘ สิงหาคม ๒๕๕๘</p>'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <?php echo '<p>๗. ข้อเสนออื่นๆ คณะกรรมการตรวจรับพัสดุเป็นไปตามคำสั่งเลขที่ ๒๙๙/๒๕๕๙ ลว.๒๒ ก.ย ๒๕๕๙</p>'; ?>
            </td>
        </tr>
    </table>
    <br>
    <p style="font-size: 16pt; line-height: 1;"><?php echo Yii::$app->report->Genndsp(5); ?><?php echo 'จึงเรียนมาเพื่อโปรดพิจารณาหากเห็นชอบขอได้โปรดอนุมัติแผนเพิ่มให้ดำเนินการจัดชื้อยาต่อไป'; ?></p>

<?php endif; ?>

<?php if ($type == 'c' && $model['PRTypeID'] == '3' || $model['PRTypeID'] == '5' || $model['PRTypeID'] == '8') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td width="33.3%">
                <?php echo Yii::$app->report->logo('ครุฑ', 90, 90); ?>
            </td>
            <td width="33.3%" style="text-align: center;font-size: 25pt;">
                <?php echo 'บันทึกข้อความ'; ?> 
            </td>
            <td width="33.3%">

            </td>
        </tr>
    </table>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2" style="font-size: 16pt;line-height: 1;">
                <?php echo 'ส่วนราชการ ' . '<u>' . 'กลุ่มงานเภสัชกรรรม โรงพยาบาลมะเร็งอุดรธานี'; ?>
                <?php echo Yii::$app->report->Genndsp(71); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 16pt;line-height: 1;">
                <?php echo 'ที่ ' . '<u>สธ๐๓๑๒.๕.๒.๑๒/ ' . Yii::$app->numberthai->arabicToThaiNumber($model['PRNum']); ?>
                <?php echo Yii::$app->report->Genndsp(25); ?>
                <?php echo '</u>'; ?>
            </td>
            <td width="50%" style="font-size: 16pt;line-height: 1;">
                <?php echo 'วันที่ ' . '<u>' . Yii::$app->numberthai->arabicToThaiNumber(Yii::$app->dateconvert->FullMonth($model['PRDate'])); ?>
                <?php echo Yii::$app->report->Genndsp(36); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 16pt;line-height: 1;">
                <?php echo 'เรื่อง ' . '<u>' . 'รายงานขอซื้อเวชภัณฑ์มิใช่ยา'; ?>
                <?php echo Yii::$app->report->Genndsp(103); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>
    </table>
    <p style="font-size: 16pt;"><?php echo 'เรียน ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี'; ?></p>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="font-size: 16pt;line-height: 1;" width="100%">
                <?php echo Yii::$app->report->Genndsp(5); ?>
                <?php echo 'ตามที่กลุ่มงานเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี ได้รับอนุมัติแผนการจัดชื้อยาและเวชภัณฑ์มิใช่ยา ประจำปีงบประมาณ&nbsp;๒๕๕๘&nbsp;แล้วนั้น&nbsp;บัดนี้กลุ่มงานเภสัชกรรมได้จัดซื้อครบแผนแล้ว&nbsp;กลุ่มงานเภสัชกรรมจึงขออนุมัติแผนเพิ่ม ดังนี้'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;">
                <?php echo '<p>' . Yii::$app->report->Genndsp(5) . '๑. เหตุผลและความจำเป็น</p>'; ?>
                <?php foreach ($reson as $v) : ?>
                    <?php echo '<p>' ?>
                    <?php echo Yii::$app->report->Genndsp(9); ?>
                    <?php echo Yii::$app->numberthai->arabicToThaiNumber($i) . '.&nbsp;' . $v->PRReason . '</p>'; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1; padding-left: 5px; " >
                <p><?php echo '๒. รายละเอียดของเวชภัณฑ์มิใช่ยา'; ?></p>
                <table border="0" width="100%">
                    <tr>
                        <td style="font-size: 16pt;line-height: 1;">
                            <?php foreach ($detail as $v) : ?>
                                <p style="line-height: 1;"> <?php echo Yii::$app->report->Genndsp(9) . Yii::$app->numberthai->arabicToThaiNumber($j) . '.&nbsp;' . $v->ItemName . ' จำนวน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($v->PRQty)) . ' ราคา ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($v->PRUnitCost, 2)) . ' บาท'; ?></p>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <p><?php echo '๓. ราคาที่เคยซื้อเวชภัณฑ์มิใช่ยาครั้งล่าสุด'; ?></p>

                <?php foreach ($detail as $v) : ?>
                    <p> <?php echo Yii::$app->report->Genndsp(9) . Yii::$app->numberthai->arabicToThaiNumber($k) . '.&nbsp;' . $v->ItemName . ' ราคา ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($v->PRLastUnitCost, 2)) . ' บาท' . ' ' . $v->PRUnit; ?></p>
                    <?php $k++; ?>
                <?php endforeach; ?>

            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <p><?php echo '๔. วงเงินที่จะชื้อเวชภัณฑ์มิใช่ยา ' . $model->PRbudget . ' จำนวน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($model->PRTotal)) . ' บาท'; ?></p>
            </td> 
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <?php echo '<p>๕. กำหนดเวลาที่ต้องใช้เวชภัณฑ์มิใช่ยา กำหนดการส่งมอบยาภายใน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($model->PRExpectDate)) . ' วัน นับจากวันลงนามในใบสั่งชื้อ</p>'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1;padding-left: 5px;">
                <?php echo '<p>๖. วิธีที่จะชื้อเวชภัณฑ์มิใช่ยา และเหตุผลที่ต้องชื้อเวชภัณฑ์มิใช่ยา ดำเนินการ ' . $model->POType . ' เนื่องจากชื้อครั้งนี้ไม่เกิน ' . Yii::$app->numberthai->arabicToThaiNumber(number_format($model->POPriceLimit)) . ' บาท อ้างอิงตามคำสั่งเลขที่ กค (กวพ) ๐๔๒๑.๓/ว๒๙๙ ลว.๒๘ สิงหาคม ๒๕๕๘</p>'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16pt;line-height: 1; padding-left: 5px;">
                <?php echo '<p>๗. ข้อเสนออื่นๆ คณะกรรมการตรวจรับพัสดุเป็นไปตามคำสั่งเลขที่ ๒๙๙/๒๕๕๙ ลว.๒๒ ก.ย ๒๕๕๙</p>'; ?>
            </td>
        </tr>
    </table>
    <br>
    <p style="font-size: 16pt; line-height: 1;"><?php echo Yii::$app->report->Genndsp(5); ?><?php echo 'จึงเรียนมาเพื่อโปรดพิจารณาหากเห็นชอบขอได้โปรดอนุมัติแผนเพิ่มให้ดำเนินการจัดชื้อยาต่อไป'; ?></p>

<?php endif; ?>


<?php if ($type == 'f') : ?>
    <table border="0" width="100%">
        <tr>
            <td width="50%" style="font-size: 16pt;text-align: center;height: 30px;;"></td>
            <td width="50%" style="text-align: center;vertical-align: middle;height: 40px;">

            </td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 16pt;text-align: center;line-height: 1;">
                <p><?php echo '(นางสาวอารยา ลักขณาวรรณกุล)'; ?></p>
                <p><?php echo 'หัวหน้าเจ้าหน้าที่พัสดุ'; ?></p>
            </td>
            <td width="50%" style="font-size: 16pt;text-align: center;line-height: 1;">
                <p><?php echo '(นางเมธาวี เฮียงราช)'; ?></p>
                <p><?php echo 'เจ้าหน้าที่พัสดุ'; ?></p>
            </td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 16pt;text-align: center;line-height: 1;"></td>
            <td width="50%" style="text-align: center;vertical-align: middle;height: 40px;">

            </td>
        </tr>
        <tr>
            <td width="50%" style="font-size: 16pt;text-align: center;line-height: 1;">
            </td>
            <td width="50%" style="font-size: 16pt;text-align: center;line-height: 1;">
                <p><?php echo '(นายอิสระ เจียวิริยบุญญา)'; ?></p>
                <p><?php echo 'ผู้อำนวยการโรงพยาบาลมะเร็งอุดรธานี'; ?></p>
            </td>
        </tr>
    </table>
    <?php echo Yii::$app->report->footer(12); ?>
<?php endif; ?>
