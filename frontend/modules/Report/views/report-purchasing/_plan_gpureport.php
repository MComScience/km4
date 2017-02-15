<?php

use yii\helpers\Html;

$i = 1;
$j = 1;
$k = 1;
$PCPlanTypeID = $model['PCPlanTypeID'];
switch ($PCPlanTypeID) {
    case "1":
    case "2":
        $title = 'รหัสยาสามัญ';
        $titledetail = 'รายละเอียดยาสามัญ';
        break;
    case "3":
    case "4":
    case "6":
        $title = 'รหัสสินค้า';
        $titledetail = 'รายละเอียดสินค้า';
        break;
    case "5":
    case "7":
    case "8":
        $title = 'รหัสยาการค้า';
        $titledetail = 'รายละเอียดยาการค้า';
        break;
    default :
        $title = '';
}
?>
<?php if ($type == 'c') : ?>
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
            <td colspan="3" style="font-size: 16pt;line-height: 1;">
                <?php echo 'ส่วนราชการ ' . '<u>' . 'กลุ่มงานเภสัชกรรรม โรงพยาบาลมะเร็งอุดรธานี'; ?>
                <?php echo Yii::$app->report->Genndsp(71); ?>
                <?php echo '</u>'; ?>
            </td>
        </tr>


        <tr>
            <td colspan="3" style="font-size: 16pt;line-height: 1;">
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
                <?php echo 'ตามที่กลุ่มงานเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี ได้รับอนุมัติแผนการจัดชื้อยาและเวชภัณฑ์มิใช่ยา ประจำปีงบประมาณ&nbsp;๒๕๖๐&nbsp;แล้วนั้น&nbsp;บัดนี้กลุ่มงานเภสัชกรรมได้จัดซื้อครบแผนแล้ว&nbsp;กลุ่มงานเภสัชกรรมจึงขออนุมัติแผนเพิ่ม '; ?>
                <?php echo 'เลขที่ ' . Yii::$app->numberthai->arabicToThaiNumber($model['PCPlanNum']); ?>
                <?php echo 'วันที่เริ่ม ' . Yii::$app->numberthai->arabicToThaiNumber(Yii::$app->dateconvert->FullMonth2($model['PCPlanBeginDate'])); ?>
                <?php echo 'วันที่สิ้นสุด ' . Yii::$app->numberthai->arabicToThaiNumber(Yii::$app->dateconvert->FullMonth2($model['PCPlanEndDate'])); ?>
                ประเภทแผน  <?php echo $model['PCPlanType']; ?>
                ดังนี้
            </td>
        </tr>
    </table>
    <br>
    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;font-size: 16pt; border-bottom: 1px solid black;border-top:1px solid black;">ลำดับ</th>
                <th  style="text-align: center;font-size: 16pt;border-bottom: 1px solid black;border-top:1px solid black;padding-left: 5px;"><?php echo $title; ?></th>
                <th  style="text-align: center;font-size: 16pt;border-bottom: 1px solid black;border-top:1px solid black;"><?php echo $titledetail ?></th>
                <th  style="text-align: center;font-size: 16pt;border-bottom: 1px solid black;border-top:1px solid black;padding-left: 5px">ราคา/หน่วย</th>
                <th  style="text-align: center;font-size: 16pt;border-bottom: 1px solid black;border-top:1px solid black;padding-left: 5px">จำนวน</th>
                <th  style="text-align: center;font-size: 16pt;border-bottom: 1px solid black;border-top:1px solid black;padding-left: 5px">รวมเป็นเงิน</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($model['PCPlanTypeID'] == 1 || $model['PCPlanTypeID'] == 2): ?>

                <?php foreach ($detail as $v): ?>
                    <tr>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo $i; ?>
                        </td>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo $v['TMTID_GPU']; ?>
                        </td>
                        <td style="text-align: left;font-size: 16pt;line-height: 0.9;vertical-align: top;">
                            <?php echo $v['FSN_GPU']; ?>
                        </td>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['GPUUnitCost'], 2); ?>
                        </td>
                        <td style="text-align: right;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['GPUOrderQty'], 2); ?>
                        </td>
                        <td style="text-align: right;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['GPUExtendedCost'], 2); ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php $sum[] = $v['GPUExtendedCost']; ?>
                <?php endforeach; ?>

            <?php endif; ?>

            <?php if ($model['PCPlanTypeID'] == 3 || $model['PCPlanTypeID'] == 4 || $model['PCPlanTypeID'] == 6): ?>

                <?php foreach ($detail as $v): ?>
                    <tr>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo $i; ?>
                        </td>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo $v['ItemID']; ?>
                        </td>
                        <td style="text-align: left;font-size: 16pt;line-height: 0.9;vertical-align: top;">
                            <?php echo $v['ItemName']; ?>
                        </td>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['PCPlanNDUnitCost'], 2); ?>
                        </td>
                        <td style="text-align: right;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['PCPlanNDQty'], 2); ?>
                        </td>
                        <td style="text-align: right;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['PCPlanNDExtendedCost'], 2); ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php $sum[] = $v['PCPlanNDExtendedCost']; ?>
                <?php endforeach; ?>

            <?php endif; ?>

            <?php if ($model['PCPlanTypeID'] == 5 || $model['PCPlanTypeID'] == 7 || $model['PCPlanTypeID'] == 8): ?>

                <?php foreach ($detail as $v): ?>
                    <tr>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo $i; ?>
                        </td>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo $v['TMTID_TPU']; ?>
                        </td>
                        <td style="text-align: left;font-size: 16pt;line-height: 0.9;vertical-align: top;">
                            <?php echo $v['ItemName']; ?>
                        </td>
                        <td style="text-align: center;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['TPUUnitCost'], 2); ?>
                        </td>
                        <td style="text-align: right;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['TPUOrderQty'], 2); ?>
                        </td>
                        <td style="text-align: right;font-size: 16pt; line-height: 0.9;vertical-align: top;">
                            <?php echo number_format($v['TPUExtendedCost'], 2); ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                    <?php $sum[] = $v['TPUExtendedCost']; ?>
                <?php endforeach; ?>

            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td  style="text-align: left;font-size: 16pt; border-bottom: 1px solid black;border-top:1px solid black;" colspan="3">
                    รวมทั้งสิ้น <?php echo $i - 1; ?> รายการ 
                </td>
                <td style="text-align: right;font-size: 16pt; line-height: 0.9;border-bottom: 1px solid black;border-top:1px solid black;" colspan="4">
                    ราคารวม  <?php echo number_format(array_sum($sum), 2); ?>  บาท
                </td>
            </tr>
        </tfoot>
    </table>


    <br>
    <p style="font-size: 16pt; line-height: 1;"><?php echo Yii::$app->report->Genndsp(5); ?><?php echo 'จึงเรียนมาเพื่อโปรดพิจารณาหากเห็นชอบขอได้โปรดอนุมัติแผนเพิ่มให้ดำเนินการจัดชื้อยาต่อไป'; ?></p>
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
<?php endif; ?>



<?php if ($type == 'f') : ?>
    <?php echo Yii::$app->report->footer(12); ?>
<?php endif; ?>
