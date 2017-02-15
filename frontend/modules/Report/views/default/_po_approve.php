<?php

use yii\helpers\Html;
$count = [0];
$sum = [0];
?>

<?php if ($content == 'h') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td width="33.33%">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo','height' => '80px']) ?>
            </td>
            <td width="33.33%" style="font-size: 24pt; text-align: center;">
               <strong><?php echo $type == 1 ? 'ใบสั่งซื้อ' : 'ใบสั่งซื้อรายการสินค้าบริจาค' ?></strong>
            </td>
            <td width="33.33%" style="text-align: right;vertical-align: top;font-size: 16pt;">
                หน้า {PAGENO} / {nbpg}
            </td>
        </tr>
    </table>

    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td style="width: 25%;font-size: 18pt; padding-left: 50;">
                <strong><?= Html::label('ใบสั่งซื้อเลขที่', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo $header['PONum']; ?>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <strong><?= Html::label('เลขที่สัญญาจะซื้อจะขาย', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo $header['POContID']; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;font-size: 18pt; padding-left: 50;">
                <strong><?= Html::label('ประเภทใบขอซื้อ', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo $header['PRType']; ?>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <strong><?= Html::label('กำหนดการส่งมอบ', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($header['PODueDate']); ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;font-size: 18pt; padding-left: 50;">
                <strong><?= Html::label('ประเภทการสั่งซื้อ', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo $header['POType']; ?>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <strong><?= Html::label('กำหนดเวลาการส่งมอบ', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo 'ภายใน ' . $header['PRExpectDate'] . ' วัน'; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;font-size: 18pt; padding-left: 50;">
                <strong><?= Html::label('สถานะ', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo $header['POStatusDes']; ?>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <strong><?= Html::label('เลขที่ผู้จำหน่าย', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;">
                <?php echo $header['VendorID']; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;font-size: 18pt;vertical-align: top; padding-left: 50;">
                <strong><?= Html::label('วันที่', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;vertical-align: top;">
                <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($header['PODate']); ?>
            </td>
            <td style="width: 25%;font-size: 18pt;vertical-align: top;">
                <strong><?= Html::label('ชื่อผู้จำหน่าย', false, []) ?></strong>
            </td>
            <td style="width: 25%;font-size: 18pt;vertical-align: top;line-height: 0.9">
                <?php echo $header['VenderName']; ?>
            </td>
        </tr>
    </table>
<?php endif; ?>

<?php if ($content == 'c') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead>
            <tr>
                <th width="10%" style="font-size: 18pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <?= Html::label('รหัสสินค้า', false, []) ?>
                </th>
                <th width="50%" style="font-size: 18pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: left;">
                    <?= Html::label('รายละเอียดสินค้า', false, []) ?>
                </th>
                <th style="font-size: 18pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <?= Html::label('จำนวน', false, []) ?>
                </th>
                <th style="font-size: 18pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <?= Html::label('ราคา/หน่วย', false, []) ?>
                </th>
                <th style="font-size: 18pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <?= Html::label('หน่วย', false, []) ?>
                </th>
                <th style="font-size: 18pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <?= Html::label('ราคารวม', false, []) ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($query as $v) : ?>
                <tr>
                    <td style="font-size: 16pt;vertical-align: top;text-align: center;">
                        <?php echo $v['ItemID']; ?>
                    </td>
                    <td style="font-size: 16pt;vertical-align: top;">
                        <?php echo $v['ItemDetail']; ?>
                    </td>
                    <td style="font-size: 16pt;vertical-align: top;text-align: right;">
                        <?php echo $v['POQty']; ?>
                    </td>
                    <td style="font-size: 16pt;vertical-align: top;text-align: right;">
                        <?php echo number_format($v['POUnitCost'],4); ?>
                    </td>
                    <td style="font-size: 16pt;vertical-align: top;text-align: center;">
                        <?php echo $v['POUnit']; ?>
                    </td>
                    <td style="font-size: 16pt;vertical-align: top;text-align: right;">
                        <?php echo number_format($v['POExtenedCost'],4); ?>
                    </td>
                </tr>
                <?php 
                $sum[] = $v['POExtenedCost'];
                $count[] = $v['ids']; 
                ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="font-size: 18pt;border-bottom: 1px solid black;border-top: 1px solid black;text-align: left;">
                    <strong><?php echo 'รวมทั้งสิ้น ' . count($count) . ' รายการ'; ?></strong>
                </td>
                <td colspan="3" style="font-size: 18pt;border-bottom: 1px solid black;border-top: 1px solid black;text-align: right;">
                    <strong><?php echo 'ราคารวม ' . number_format(array_sum($sum),4) . ' บาท'; ?></strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="font-size: 18pt;text-align: right;">
                    <strong><?php echo 'ผู้ทวนสอบ'; ?></strong>
                </td>
                <td colspan="3" style="vertical-align: bottom;text-align: center;">
                    <strong>________________________________________</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="font-size: 18pt;text-align: right;">
                    <strong><?php echo 'ผู้อนุมัติ'; ?></strong>
                </td>
                <td colspan="3" style="vertical-align: bottom;text-align: center;">
                    <strong>________________________________________</strong>
                </td>
            </tr>
        </tfoot>
    </table>
<?php endif; ?>

<?php if ($content == 'f') : ?>
    <?php echo Yii::$app->report->footer(14); ?>
<?php endif; ?>
