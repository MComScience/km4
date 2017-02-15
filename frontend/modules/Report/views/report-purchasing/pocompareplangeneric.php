<table border="0" cellpadding="0" cellspacing="0" width="100%">  
    <thead>
        <tr>
            <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>เลขที่แผนจัดชื้อ</strong>
            </td>
            <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>วันที่</strong>
            </td>
            <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong>ประเภทแผนจัดชื้อ</strong>
            </td>
            <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong></strong>
            </td>
            <td width="20%" style="font-size:16pt;border-top: 1px solid black;border-bottom: 1px solid black;padding-top: 10px;">
                <strong></strong>
            </td>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($rs as $r) {
            ?>
            <tr>
                <td  style="font-size:16pt"><?php echo $r['PCPlanNum'] ?></td><td style="font-size:16pt"><?php echo $r['PCPlanDate'] ?></td><td  style="font-size:16pt"><?php echo $r['PCPlanType'] ?></td><td  style="font-size:16pt"></td>
            </tr>
            <tr>
                <td  colspan="4">
                    <table border="0"  width="100%">
                        <tr>
                            <td width="2%" style="font-size:14pt">ลำดับ</td><td width="15%" style="font-size:14pt">รหัส<?php echo $header ?></td><td width="30%" style="font-size:14pt">รายละเอียดสินค้า</td><td width="10%" style="font-size:14pt">จำนวน</td><td width="10%" style="font-size:14pt">หน่วย</td><td width="10%"  style="font-size:14pt">ขอชื้อแล้ว</td><td width="10%" style="font-size:14pt">ขอชื้อได้</td>
                        </tr>
                        <?php
                        if ($type = 1) {
                            $result = \app\modules\Purchasing\models\VwItemListGpuplanAvalible::findAll(['PCPlanNum' => $r['PCPlanNum']]);
                        } else if ($type = 2) {
                            $result = \app\modules\Inventory\models\VwItemListTpuplanAvalible::findAll(['PCPlanNum' => $r['PCPlanNum']]);
                        } else if ($type = 3) {
                            $result = \app\modules\Purchasing\models\VwItemListNdplanAvalible::findAll(['PCPlanNum' => $r['PCPlanNum']]);
                        }
                        $i = 1;
                        foreach ($result as $value) {
                            ?>
                            <tr>
                                <td width="2%" style="font-size:14pt"><?php echo $i; ?></td><td width="15%" style="font-size:14pt"><?php
                                    if ($type == 1) {
                                        echo $value['TMTID_GPU'];
                                    } else if ($type == 2) {
                                        echo $value['TMTID_TPU'];
                                    } else if ($type == 3) {
                                        echo $value['TMTID_GPU'];
                                    }
                                    ?></td><td width="30%" style="font-size:14pt"><?php echo $value['ItemName'] ?></td><td width="20%" style="font-size:14pt"><?php echo $value['GPUOrderQty'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['DispUnit'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['PRApprovedOrderQty'] ?></td><td width="10%" style="font-size:14pt"><?php echo $value['PRGPUAvalible'] ?></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
