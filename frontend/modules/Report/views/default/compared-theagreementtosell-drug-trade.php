<?php

use yii\helpers\Html;
use app\modules\Purchasing\models\VwItemListTpuplanAvalible;

$i = 1;
?>
<?php if ($content == 'H') : ?>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="50%" style="text-align:center;">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo', 'height' => '100px']) ?>
            </td>
            <td width="50%" style="text-align:center;font-size:20pt">
                <strong><?php echo 'รายงานยอดสั่งชื้อเปรียบเทียบกับสัญญาจะชื้อจะขาย' . $title ?></strong>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt">
                <strong>จากวันที่ : </strong><?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($startdate); ?><strong>  ถึงวันที่ : </strong> <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($enddate); ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>
<?php endif; ?>
<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <thead>
            <tr>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong>เลขที่แผนจัดชื้อ</strong>
                </th>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong>เลขที่สัญญาจะชื้อจะขาย</strong>
                </th>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong>วันที่</strong>
                </th>
                <th width="40%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong>ชื่อผู้จำหน่าย</strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $r) : ?>
                <tr>
                    <td  style="font-size:16pt;text-align: center;background-color: #ddd;vertical-align: top;">
                        <?php echo $r['PCPlanNum'] ?>
                    </td>
                    <td  style="font-size:16pt;text-align: center;background-color: #ddd;vertical-align: top;">
                        <?php echo $r['PCPOContactID'] ?>
                    </td>
                    <td  style="font-size:16pt;text-align: center;background-color: #ddd;vertical-align: top;">
                        <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($r['PCPlanDate2']); ?>
                    </td>
                    <td  style="font-size:16pt;text-align: left;background-color: #ddd;vertical-align: top;">
                        <?php echo $r['VenderName'] ?>
                    </td>
                </tr>
                <tr>
                    <td  colspan="4">
                        <table border="0" cellpadding="0" cellspacing="0"  width="100%">
                            <tr>
                                <td width="5%" style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    ลำดับ
                                </td>
                                <td width="15%" style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    รหัส<?php echo $title ?>
                                </td>
                                <td width="40%" style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    รายละเอียดสินค้า
                                </td>
                                <td width="10%" style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    จำนวน
                                </td>
                                <td width="10%" style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    หน่วย
                                </td>
                                <td width="10%"  style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    ขอชื้อแล้ว
                                </td>
                                <td width="10%" style="font-size:16pt;text-align: center;border-bottom: 1px solid #ddd;">
                                    ขอชื้อได้
                                </td>
                            </tr>
                            <?php $result = VwItemListTpuplanAvalible::findAll(['PCPlanNum' => $r['PCPlanNum']]); ?>
                            <?php if ($result != null) : ?>
                                <?php foreach ($result as $value) : ?>
                                    <tr>
                                        <td width="5%" style="font-size:16pt;text-align: center;vertical-align: top;">
                                            <?php echo $i; ?>
                                        </td>
                                        <td width="15%" style="font-size:16pt;text-align: center;vertical-align: top;">
                                            <?php echo $value['TMTID_TPU']; ?>
                                        </td>
                                        <td width="40%" style="font-size:16pt;text-align: left;vertical-align: top;">
                                            <?php echo $value['FSN_TMT']; ?>
                                        </td>
                                        <td width="10%" style="font-size:16pt;text-align: center;vertical-align: top;">
                                            <?php echo $value['TPUOrderQty']; ?>
                                        </td>
                                        <td width="10%" style="font-size:16pt;text-align: center;vertical-align: top;">
                                            <?php echo $value['DispUnit'] ?>
                                        </td>
                                        <td width="10%" style="font-size:16pt;text-align: right;vertical-align: top;">
                                            <?php echo $value['PRApprovedOrderQty']; ?>
                                        </td>
                                        <td width="10%" style="font-size:16pt;text-align: right;vertical-align: top;">
                                            <?php echo $value['PRTPUAvalible']; ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td width="100%" style="font-size: 16pt;text-align: center" colspan="7">-</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

