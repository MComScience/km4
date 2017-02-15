<?php

use yii\helpers\Html;
use app\modules\pr\models\VwPritemdetail2New;

$i = 1;
?>
<?php if ($content == 'H') : ?>
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="50%" style="text-align:center;">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo', 'height' => '100px']) ?>
            </td>
            <td width="50%" style="text-align:center;font-size:20pt">
                <strong><?php echo $title; ?></strong>
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
        <tr>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>เลขที่ใบขอชื้อ</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>วันที่</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>ผู้ขอชื้อ</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>เหตุผลการขอชื้อ</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>เหตุผลการไม่อนุมัติ</strong>
            </th>
        </tr>

        <?php foreach ($rows as $r) : ?>
            <tr>
                <td style="font-size:16pt;text-align: center;vertical-align: top;background-color: #ddd;">
                    <?php echo $r['PRNum'] ?>
                </td>
                <td style="font-size:16pt;text-align: center;vertical-align: top;background-color: #ddd;">
                    <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($r['PRDate']) ?>
                </td>
                <td style="font-size:16pt;text-align: center;vertical-align: top;background-color: #ddd;">
                    <?php echo empty($r->createName->User_name) ? '-' : $r->createName->User_name; ?>
                </td>
                <td style="font-size:16pt;text-align: left;vertical-align: top;background-color: #ddd;">
                    <?php echo $r['PRReasonNote'] ?>
                </td>
                <td style="font-size:16pt;text-align: left;vertical-align: top;background-color: #ddd;">
                    <?php echo$r['PRRejectReason'] ?>
                </td>
            </tr>
            <tr>
                <td  colspan="5">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="5%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                
                            </td>
                            <td width="15%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <strong>รหัสสินค้า</strong>
                            </td>
                            <td width="40%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <strong>รายละเอียดสินค้า</strong>
                            </td>
                            <td width="10%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <strong>จำนวน</strong>
                            </td>
                            <td width="10%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <strong>ราคา/หน่วย</strong>
                            </td>
                            <td width="10%"  style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <strong>หน่วย</strong>
                            </td>
                            <td width="10%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <strong>ราคารวม</strong>
                            </td>
                        </tr>
                        <?php $result = VwPritemdetail2New::findAll(['PRNum' => $r['PRNum']]); ?>
                        <?php foreach ($result as $value) : ?>
                            <tr>
                                <td width="5%" style="font-size: 14pt;text-align: center;vertical-align: top;">
                                    <?php echo $i; ?>
                                </td>
                                <td width="15%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['TMTID_GPU'] ?>
                                </td>
                                <td width="40%" style="font-size:14pt;vertical-align: top;">
                                    <?php echo $value['ItemName'] ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['VerifyQty'] ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: right;vertical-align: top;">
                                    <?php echo $value['VerifyUnitCost'] ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['VerifyUnit'] ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: right;vertical-align: top;">
                                    <?php echo number_format($value['ExtenedCost'], 2) ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
            <?php $i = 1; ?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>


