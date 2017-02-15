<?php $count = '';?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th width="15%">รหัสสินค้า</th>
            <th width="60%">รายละเอียดสินค้า</th>
            <th width="15%">ยอดที่โอน</th>
            <th width="10%">หน่วย</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rs as $r) { ?>
            <tr>
                <td style="text-align:center;font-size:14pt;"><?php echo $r['ItemID'] ?></td>
                <td style="font-size:14pt;"><?php echo $r['ItemName'] ?></td>
                <td style="text-align:center;font-size:14pt;"><?php echo $r['STItemQty'];?></td>
                <td style="text-align:center;font-size:14pt;"><?php echo $r['DispUnit']; ?></td>
            </tr>
            <?php $count++ ?>
        <?php } ?>
    </tbody>
</table>
<table width="100%" border="0" style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
    <?php if($count=='0'||$count==''){?>
        <td  style="font-size:16pt; text-align: right;padding-right:30px">ไม่พบข้อมูลการโอนสินค้า</td>
        <?php }else{?>
        <td  style="font-size:16pt; text-align: right;padding-right:30px">รวมทั้งสิ้น <?php echo $count; ?>  รายการ</td>
        <?php  }?>
    </tr>
</table>
