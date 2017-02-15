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
        <thead>
            <tr>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong><?= Html::label('เลขที่ใบสั่งซื้อ') ?></strong>
                </th>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong><?= Html::label('วันที่') ?></strong>
                </th>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong><?= Html::label('ผู้ขาย') ?></strong>
                </th>
                <th width="30%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong><?= Html::label('ประเภทการสั่งชื้อ') ?></strong>
                </th>
                <th width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;text-align: center;">
                    <strong><?= Html::label('กำหนดส่งมอบ') ?></strong>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($header as $r) : ?>
                <tr>
                    <td style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                        <?php echo $r['PONum'] ?>
                    </td>
                    <td style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                        <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($r['PODate']) ?>
                    </td>
                    <td  style="font-size:16pt;vertical-align: top;border-top: 1px solid black;">
                        <?php echo $r['VenderName'] ?>
                    </td>
                    <td style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                        <?php echo $r['POType'] ?>
                    </td>
                    <td  style="font-size:16pt;vertical-align: top;text-align: center;border-top: 1px solid black;">
                        <?php echo Yii::$app->dateconvert->convertThaiToMysqlDate4($r['PODueDate']) ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="5%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                    <?= Html::label('ลำดับ') ?>
                                </td>
                                <td width="15%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                    <?= Html::label('รหัสสินค้า') ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                    <?= Html::label('ประเภทสินค้า') ?>
                                </td>
                                <td width="20%" style="font-size:14pt;text-align: center;background-color: #ddd;">
                                    <?= Html::label('รายการสินค้า') ?>
                                </td>
                                <td width="30%" style="font-size:14pt;text-align: center;background-color: #ddd;" colspan="3">
                                    <?= Html::label('สั่งชื้อ') ?>
                                </td>
                                <td style="font-size:14pt;text-align: center;background-color: #ddd;">
                                    <?= Html::label('รับแล้ว') ?>
                                </td>
                                <td style="font-size:14pt;text-align: center;background-color: #ddd;">
                                    <?= Html::label('ค้างส่ง') ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%" style="font-size:14pt" colspan="4">

                                </td>
                                <td width="10%" style="font-size:14pt;text-align: center;">
                                    <?= Html::label('จำนวน') ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: center;">
                                    <?= Html::label('ราคา/หน่วย') ?>
                                </td>
                                <td width="10%" style="font-size:14pt;text-align: center;">
                                    <?= Html::label('หน่วย') ?>
                                </td>
                                <td width="20%" style="font-size:14pt;text-align: center;" colspan="2">

                                </td>
                            </tr>
                            <?php $rows = VwGr2DetailNew2Cum::find()->where(['POID' => $r['POID']])->all(); ?>
                            <?php if ($rows != null) : ?>
                                <?php foreach ($rows as $value) : ?>
                                    <tr>
                                        <td width="5%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo $i; ?>
                                        </td>
                                        <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo!empty($value['ItemID']) ? $value['ItemID'] : '-'; ?>
                                        </td>
                                        <td width="15%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo!empty($value['POItemType']) ? $value['POItemType'] : '-'; ?>
                                        </td>
                                        <td width="20%" style="font-size:14pt;vertical-align: top;">
                                            <?php echo!empty($value['ItemName']) ? $value['ItemName'] : '-'; ?>
                                        </td>
                                        <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo!empty($value['POQty']) ? $value['POQty'] : '-'; ?>
                                        </td>
                                        <td width="10%" style="font-size:14pt;text-align: right;vertical-align: top;">
                                            <?php echo number_format($value['POUnitCost'], 4) ?>
                                        </td>
                                        <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo!empty($value['POUnit']) ? $value['POUnit'] : '-'; ?>
                                        </td>
                                        <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo!empty($value['GRReceivedQty_cum']) ? $value['GRReceivedQty_cum'] : '-'; ?>
                                        </td>
                                        <td width="10%" style="font-size:14pt;text-align: center;vertical-align: top;">
                                            <?php echo!empty($value['GRLeftItemQty_cum']) ? $value['GRLeftItemQty_cum'] : '-'; ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                    <tr>
                                        <td colspan="9" style="font-size: 16pt;text-align: center;">-</td>
                                    </tr>
                            <?php endif; ?>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>
