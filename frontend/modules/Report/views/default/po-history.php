<?php

use yii\helpers\Html;
use app\modules\po\models\VwPo2Detail2New;

$i = 1;
?>
<?php if ($content == 'H') : ?>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align:center;font-size:16pt">
                <?= Html::img('@web/images/logo.jpg', ['alt' => 'My logo', 'height' => '100px']) ?>
            </td>
            <td width="33%" style="text-align:center;font-size:16pt"></td>
            <td width="33%" style="text-align:center;font-size:16pt">
                <strong><?php echo $title; ?></strong>
            </td>
        <tr>
    </table>
    <table border="0"  width="100%">
        <tr>
            <td style="text-align:center;font-size:16pt">
                <strong>พิมพ์จากวันที่ : </strong><?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($startdate); ?>
                <strong>  ถึงวันที่ : </strong><?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($enddate); ?>
            </td>
        </tr>
    </table>
    <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>
<?php endif; ?>
<?php if ($content == 'C') : ?>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>เลขที่ใบสั่งซื้อ</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>วันที่</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>ผุ้ขาย</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>ประเภทการสั่งชื้อ</strong>
            </th>
            <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                <strong>ประเภทการขอชื้อ</strong>
            </th>
        </tr>   
        <?php foreach ($header as $r) : ?>
            <tr>
                <td  style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                    <?php echo $r['PONum'] ?>
                </td>
                <td  style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                    <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($r['PODate']) ?>
                </td>
                <td  style="font-size:16pt;vertical-align: top;border-top: 1px solid #ddd;border-top: 1px solid black;">
                    <?php echo $r['VenderName'] ?>
                </td>
                <td  style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                    <?php echo $r['POType'] ?>
                </td>
                <td  style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                    <?php echo $r['PRType'] ?>
                </td>
            </tr>
            <tr>
                <td  colspan="5">
                    <table border="0"  cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="2%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                <?= Html::label('ลำดับ') ?>
                            </td>
                            <td width="3%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                <?= Html::label('รหัสสินค้า') ?>
                            </td>
                            <td width="5%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                <?= Html::label('ประเภทสินค้า') ?>
                            </td>
                            <td width="50%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                <?= Html::label('รายละเอียดสินค้า') ?>
                            </td>
                            <td  style="font-size:14pt;text-align: center;border-top: 1px solid #ddd;background-color: #ddd;" colspan="3">
                                <?= Html::label('สั่งชื้อ') ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="70%" style="font-size:14pt;" colspan="4"></td>
                            <td width="10%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;" >
                                <?= Html::label('จำนวน') ?>
                            </td>
                            <td width="10%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <?= Html::label('ราคา/หน่วย') ?>
                            </td>
                            <td width="10%" style="font-size:14pt;text-align: center;border-bottom: 1px solid #ddd;">
                                <?= Html::label('หน่วย') ?>
                            </td>
                        </tr>
                        <?php $rows = VwPo2Detail2New::find()->where(['POID' => $r['POID']])->all(); ?>
                        <?php foreach ($rows as $value) : ?>
                            <tr>
                                <td width="2%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $i; ?>
                                </td>
                                <td width="3%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['ItemID'] ?>
                                </td>
                                <td width="5%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['POItemType'] ?>
                                </td>
                                <td width="50%" style="font-size:14pt;vertical-align: top;">
                                    <?php echo $value['ItemDetail'] ?>
                                </td>
                                <td width="5%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['POQty'] ?>
                                </td>
                                <td width="5%" style="font-size:14pt;text-align: right;vertical-align: top;">
                                    <?php echo $value['POUnitCost'] ?>
                                </td>
                                <td width="5%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                    <?php echo $value['POUnit'] ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

