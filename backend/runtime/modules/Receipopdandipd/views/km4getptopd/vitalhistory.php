<table class="table table-striped table-bordered table-hover " id="vitaltable">
    <thead>
        <tr>
            <th style="text-align: center;">วัดวันที่</th>
            <th style="text-align: center;">เวลา</th>
            <th style="text-align: center;">ความดันโลหิตค่าบน</th>
            <th style="text-align: center;">ความดันโลหิตค่าล่าง</th>
            <th style="text-align: center;">ชีพจร</th>
            <th style="text-align: center;">อัตราออกชิเจนในเลือด</th>
            <th style="text-align: center;">อัตราการหายใจ</th>
            <th style="text-align: center;">อุณหภูมิร่างกาย</th>
            <th style="text-align: center;">ส่วนสูง</th>
            <th style="text-align: center;">น้ำหนัก</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($result)) {
            foreach ($result as $r) {
                echo '<tr>';
                ?>
            <td style="text-align: center;"><?php echo $r->Name_exp_2 ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_time ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_bp_sys ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_bp_dia ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_pr ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_spo ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_rr ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_bodytemp ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_weight ?></td>
            <td style="text-align: center;"><?php echo $r->pt_vs_height ?></td> 
    <?php 
    
    echo '</tr>';
            }
} else { ?>
        <tr>
            <td colspan="10" style="text-align: center;">ยังไม่มีข้อมุล</td>
        </tr>
<?php } ?>
</tbody>
</table>
<script>
$("#vitaltable").dataTable({});
</script>






