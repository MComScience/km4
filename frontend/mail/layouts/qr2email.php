<?php
$no = 1;
?>
<table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
    <tr>
        <td width='50%' style="border-bottom: 1px solid black;">
            <?= yii\helpers\Html::img('http://www.udcancer.org/km4/frontend/web/images/logocrop.png', ['width' => '250', 'height' => '100']) ?> 
        </td>
        <td width='50%' style="text-align: right;font-size: 18pt; vertical-align: bottom;border-bottom: 1px solid black;">
            โรงพยาบาลมะเร็งอุดรธานี
        </td>
    </tr>
</table>
<table table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
    <tr> 
        <td> เรียน  <?= $vendername; ?></td>
    </tr>
    <tr>
        <td>เรื่อง <b>ขอสืบราคาสินค้า</b></td>
    </tr>
    <tr>
        <td>เลขที่ใบสืบราคา <?= $queryqr['QRNum']; ?></td>
    </tr>
    <br>
    <tr>
        <td>
            &nbsp;&nbsp;&nbsp;&nbsp;เนื่องด้วยฝ่ายเภสัชกรรม  โรงพยาบาลมะเร็งอุดรธานี มีความประสงค์ขออนุมัติดำเนินการจัดซื้อสินค้า/วัสดุการแพทย์ จำนวน <?= $queryqr['qritemqty']; ?>  รายการ
            เพื่อใช้ในกิจการของโรงพยาบาลมะเร็งอุดรธานี ดังต่อไปนี้
        </td>
    </tr>
</table>
<br>

<table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table tab-bordered table-striped" 
       style="text-align: center;border-bottom: 1px solid black; border-top: 1px solid black;">
    <thead>
        <tr>
            <th width="5%" style="text-align: center;vertical-align: top;background-color: #ddd;"> ลำดับ</th>
            <th width="65%" style="text-align: left;vertical-align: top;background-color: #ddd;">รายละเอียด</th>
            <th width="10%" style="text-align: center;vertical-align: top;background-color: #ddd;">ประเภทสินค้า</th>
            <th width="10%" style="text-align: center;vertical-align: top;background-color: #ddd;">จำนวน</th>
            <th width="10%" style="text-align: center;vertical-align: top;background-color: #ddd;">หน่วย</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($querydetail as $data) : ?>
            <tr>
                <td width="5%" style="text-align: center;border-bottom: 1px solid black;"><?= $no; ?></td>
                <td width="65%" style="text-align: left;border-bottom: 1px solid black;"><?= $data['ItemDetail']; ?></td>
                <td width="10%" style="text-align: center;border-bottom: 1px solid black;"><?= $data['ItemType']; ?></td>
                <td width="10%" style="text-align: center;border-bottom: 1px solid black;"><?= number_format($data['QRQty'],2); ?></td>
                <td width="10%" style="text-align: center;border-bottom: 1px solid black;"><?= $data['QRUnit']; ?></td>
            </tr>
            <?php $no++;
        endforeach; ?>
    </tbody>
</table>
<br>
<table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
    <tr>
        <td><?= $queryqr['QRmassage']; ?></td>
    </tr>
</table>
<br>
<table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
    <tr>
        <td>
            <b> ข้อกำหนดการสืบราคา </b>
        </td>
    </tr>
    <tr>
        <td>ส่งมอบสินค้า(วัน)<?= ' ' . $queryqr['QRDeliveryDay']; ?></td>
    </tr>
    <tr>
        <td>ยืนราคา(วัน)<?= ' ' . $queryqr['QRValidDay']; ?></td>
    </tr>
    <tr>
        <td>
            วันที่ต้องการตอบกลับ<?= ' ' . $queryqr['QRExpectDate']; ?>
        </td>
    </tr>
    <tr>
        <td>
            ประเภทการสั่งซื้อ<?= ' ' . $queryqr['POType']; ?>
        </td>
    </tr>
</table>
<br>
<table table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
    <tr>
        <td>
            <b>ขั้นตอนการเสนอราคา </b>
        </td>
    </tr>
    <tr>
        <td>1.</b></td>
    </tr>
    <tr>
        <td>2.</td>
    </tr>
    <tr>
        <td>
            3.
        </td>
    </tr>
</table>

<a href="http://www.udcancer.org/procurement" class="btn btn-info"><img src="http://www.udcancer.org/km4/frontend/web/images/button.png"></a>
<br>
<table table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
    <tr>
        <td>
            <p>
                <b>ติดต่อสอบถาม </b>
            </p>
            <p>ฝ่ายเภสัชกรรม โรงพยาบาลมะเร็งอุดรธานี</p>
            <p>เจ้าหน้าที่ผู้ส่งใบสืบราคา : <?= Yii::$app->user->identity->profile->User_title . ' ' . Yii::$app->user->identity->profile->User_fname . ' ' . Yii::$app->user->identity->profile->User_lname; ?></p>
            <p>โทรศัพท์ : </p>
            <p>โทรสาร : </p>
            <p>E-mail : </p>
        </td>
    </tr>

</table>