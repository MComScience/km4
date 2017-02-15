<?php

use yii\helpers\Html;
use app\modules\pr\models\VwQuPricelist;

$i = 0;
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
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th width="25%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong>เลขที่ผู้ขาย</strong>
                </th>
                <th width="25%" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong>ชื่อผู้ขาย</strong>
                </th>
                <th width="50%" colspan="6" style="text-align: center;font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong></strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td width="25%" style="font-size:16pt;text-align: center;vertical-align: top;background-color: #ddd;">
                        <?php echo $r['VendorID'] ?>
                    </td>
                    <td width="25%" style="font-size:16pt;vertical-align: top;background-color: #ddd;">
                        <?php echo $r['VenderName'] ?>
                    </td>
                    <td width="50%" colspan="6" style="font-size:16pt;vertical-align: top;background-color: #ddd;">
                        
                    </td>
                </tr>
                <?php $result = VwQuPricelist::findAll(['VendorID' => $r['VendorID'], 'ItemCatID' => $catid]); ?>
                <?php if ($result != null) : ?>   
                    <tr>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            รหัสสินค้า
                        </td>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="30%">
                            รายละเอียดสินค้า
                        </td>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            จำนวน
                        </td>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            หน่วย
                        </td>
                        <td   style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            ราคา/หน่วย
                        </td>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            เป็นเงิน
                        </td>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            MOQ
                        </td>
                        <td  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" width="10%">
                            ส่งสินค้าวัน
                        </td>
                    </tr>
                    <?php foreach ($result as $value) : ?>
                        <tr>
                            <td  style="font-size:14pt;text-align: center;vertical-align: top;">
                                <?php echo $value['TMTID_TPU'] ?>
                            </td>
                            <td style="font-size:14pt;vertical-align: top;">
                                <?php echo $value['ItemName'] ?>
                            </td>
                            <td  style="font-size:14pt;text-align: center;vertical-align: top;">
                                <?php echo number_format($value['QUQty'], 2) ?>
                            </td>
                            <td  style="font-size:14pt;text-align: center;vertical-align: top;">
                                <?php echo $value['QUUnit'] ?>
                            </td>
                            <td style="font-size:14pt;text-align: right;vertical-align: top;">
                                <?php echo number_format($value['QUUnitCost2'], 2) ?>
                            </td>
                            <td  style="font-size:14pt;text-align: right;vertical-align: top;">
                                <?php echo number_format(($value['QUQty'] * $value['QUUnitCost2']), 2) ?>
                            </td>
                            <td  style="font-size:14pt;text-align: right;vertical-align: top;">
                                <?php echo $value['QUMQO'] ?>
                            </td>
                            <td style="font-size:14pt;text-align: center;vertical-align: top;">
                                <?php echo $value['QULeadtime'] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

