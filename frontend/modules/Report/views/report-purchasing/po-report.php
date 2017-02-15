<table border="0"  width="100%">
    <?php
    $rs = \app\modules\Purchasing\models\VwPo2Detail2New::findAll(['POID' => $model->POID]);
    foreach ($rs as $r) {
        ?>
        <tr>
            <td style="text-align:center;font-size:14pt;" width="12%"><strong><?php echo $r->ItemID; ?></strong></td><td style="text-align:center;font-size:14pt" width="12%"><strong><?php echo $r->POItemType; ?></strong></td><td style="text-align:left;font-size:14pt" width="40%" colspan="3"><strong><?php echo $r->ItemDetail; ?></strong></td><td style="text-align:center;font-size:14pt" width="10%"><strong><?php echo $r->POQty; ?></strong></td></td><td style="text-align:center;font-size:14pt" width="10%"><strong><?php echo $r->POUnitCost; ?></strong></td><td style="text-align:center;font-size:14pt" width="10%"><strong><?php echo $r->POUnit; ?></strong></td><td style="text-align:center;font-size:14pt" width="10%"><strong><?php echo number_format($r->POExtenedCost,2); ?></strong></td>
        </tr>
    <?php } ?>
</table>
<?php
$count = \app\modules\Purchasing\models\VwPo2Detail2New::find()->where(['POID' => $model->POID])->count();
$sum = \app\modules\Purchasing\models\VwPo2Detail2New::find()->where(['POID' => $model->POID])->sum('POExtenedCost');
?>
<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>

        <td width="57%" style="font-size:16pt;"><strong>รวมทั้งสิ้น <?php echo $count; ?> รายการ</strong></td><td></td><td  style="padding-left:30px;font-size:16pt;text-align: right"><strong>ราคารวม <?php echo number_format($sum,2); ?> บาท</strong></td>
    </tr>
</table>
<br>

<table width="100%" border="0" >
     <tr>
         <td width="57%" style="font-size:16pt;"></td><td></td><td  style="padding-left:30px;font-size:16pt;text-align: right">ผู้ทวนสอบ ...........................<br><br>ผู้อนุมัติ ...........................</td>
    </tr>
</table>