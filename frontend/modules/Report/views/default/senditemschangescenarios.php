<?php

use yii\helpers\Html;
use app\modules\Inventory\models\VwGr2DetailNew2Cum;

$i = 1;
?>
<?php if ($content == 'H') : ?>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align:center;font-size:16pt">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo', 'height' => '100px']) ?>
            </td>
            <td width="33%" style="text-align:center;font-size:16pt">

            </td>
            <td width="33%" style="text-align:center;font-size:16pt">
                <strong><?= $title ?></strong>
            </td>
        <tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt">
                <strong><?= Html::label('พิมพ์ยอดคงเหลือ ณ วันที่ :') ?></strong>
                <?php echo Yii::$app->thaiYearformat->asDate('sort'); ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;"><?= Html::label('หน้า {PAGENO} / {nbpg}') ?> </span>
<?php endif; ?>
<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>เลขที่ใบส่งสินค้า</strong>
                </td>
                <td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>วันที่</strong>
                </td><td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>ผู้ขาย</strong>
                </td><td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>ประเภทการส่งสินค้า</strong>
                </td>
                <td width="20%" style="text-align:center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                    <strong>กำหนดส่งมอบ</strong>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($header as $r) : ?>
                <tr>
                    <td style="text-align:center;font-size:16pt;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $r['STNum'] ?>
                    </td>
                    <td style="text-align:center;font-size:16pt;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($r['STDate']) ?>
                    </td>
                    <td  style="text-align:center;font-size:16pt;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $r['VenderName'] ?>
                    </td>
                    <td  style="text-align:center;font-size:16pt;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $r['STTypeDesc'] ?>
                    </td>
                    <td  style="text-align:center;font-size:16pt;vertical-align: top;border-top: 1px solid #ddd;">
                        <?php echo $r['STDueDate'] ?>
                    </td>
                </tr>
                <?php if (($result = VwGr2DetailNew2Cum::findAll(['POID' => $r['STID']])) != null) : ?>
                    <tr>
                        <td colspan="5">
                            <table border="0" cellpadding="0" cellspacing="0"  width="100%">
                                <tr>
                                    <td width="5%" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        ลำดับ
                                    </td>
                                    <td width="15%" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        รหัสสินค้า
                                    </td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        ประเภทสินค้า
                                    </td>
                                    <td width="20%" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        รายการสินค้า
                                    </td>
                                    <td width="30%" colspan="3" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        สั่งชื้อ
                                    </td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        รับแล้ว
                                    </td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;background-color: #ddd;">
                                        ค้างส่ง
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="4"></td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;">จำนวน</td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;">ราคา/หน่วย</td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;">หน่วย</td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;">จำนวน</td>
                                    <td width="10%" style="text-align: center;font-size: 14pt;">จำนวน</td>
                                </tr>
                                <?php foreach ($result as $value) : ?>
                                    <tr>
                                        <td width="5%" style="text-align: center;font-size: 14pt;vertical-align: top;">
                                            <?php echo $i ?>
                                        </td>
                                        <td width="10%" style="text-align: center;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['ItemID'] ?>
                                        </td>
                                        <td width="15%" style="text-align: center;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['POItemType'] ?>
                                        </td>
                                        <td width="20%" style="text-align: left;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['ItemName'] ?>
                                        </td>
                                        <td width="10%" style="text-align: center;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['POQty'] ?>
                                        </td>
                                        <td width="10%" style="text-align: right;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['POUnitCost'] ?>
                                        </td>
                                        <td width="10%" style="text-align: center;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['POUnit'] ?>
                                        </td>
                                        <td width="10%" style="text-align: right;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['GRReceivedQty_cum'] ?>
                                        </td>
                                        <td width="10%" style="text-align: right;font-size: 14pt;vertical-align: top;">
                                            <?php echo $value['GRLeftItemQty_cum'] ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

