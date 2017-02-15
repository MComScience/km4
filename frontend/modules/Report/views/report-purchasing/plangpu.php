<?php if ($content == 'H') : ?>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align:center;font-size:16pt">
                <img height="100px" src="images/logo.jpg" />
            </td>
            <td width="33%" style="text-align:center;font-size:16pt">

            </td>
            <td width="33%" style="text-align:center;font-size:24pt">
                <strong><?php echo $reportheader ?></strong>
            </td>
        <tr>
    </table>
    <table border="0" class="tabletopgpuplan"  width="100%">
        <tr>
            <td width="30%" style="vertical-align: top; line-height: 0.9;">
                <strong>เลขที่แผนจัดชื้อ :</strong> <?php echo $PCPlanNum ?></td>
            <td  style="vertical-align: top; line-height: 0.9;">
                <strong> วันที่ : </strong>
                <?php echo Yii::$app->componentdate->convertMysqlToThaiDate3($rs->PCPlanDate) ?>
            </td>
            <td  style="vertical-align: top; line-height: 0.9;">
                <strong>ประเภทแผน : </strong><?php echo $rs->PCPlanType ?>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; line-height: 0.9;">
                <strong>ฝ่าย : </strong> 
                <?php echo $rs->DepartmentDesc ?>
            </td>
            <td  style="vertical-align: top; line-height: 0.9;">
                <strong>แผนก : </strong> <?php echo $rs->SectionDecs ?>
            </td>
            <td style="vertical-align: top; line-height: 0.9;">
                <strong>สถานะ : </strong><?php echo $rs->PCPlanStatus ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>วันที่เริ่มแผน : </strong> 
                <?php echo Yii::$app->componentdate->convertMysqlToThaiDate3($rs->PCPlanBeginDate) ?>
            </td>
            <td>
                <strong>วันที่สิ้นสุดแผน :</strong> 
                <?php echo Yii::$app->componentdate->convertMysqlToThaiDate3($rs->PCPlanEndDate) ?>
            </td>
            <td>
                <?php echo $purchaseandsale ?>
            </td>
        </tr>
        <tr>
                 <?php echo $purchaseandsaledatail ?>
        </tr>
       
    </table>
    <span style="font-size:14pt;font-style: normal;">หน้า {PAGENO} / {nbpg}</span>
<?php endif; ?>


<?php if ($content == 'C') : ?>
    <table class="tableheadergpuplan" border="0" cellpadding="0" cellspacing="0"  width="100%">
        <thead>
            <tr>
                <th width="8%" style="border-top:1px solid black;border-bottom: 1px solid black; text-align: center;">ลำดับ</th>
                <th width="15%" style="border-top:1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $numbertmt ?></th>
                <th width="40%" style="border-top:1px solid black;border-bottom: 1px solid black;text-align: center;"><?php echo $detailtmt ?> </th>
                <th width="10%" style="border-top:1px solid black;border-bottom: 1px solid black;text-align: center;">ราคา/หน่วย</th>
                <th width="10%" style="border-top:1px solid black;border-bottom: 1px solid black;text-align: center;">จำนวน</th>
                <th width="10%" style="border-top:1px solid black;border-bottom: 1px solid black;text-align: center;">หน่วย</th>
                <th width="10%" style="border-top:1px solid black;border-bottom: 1px solid black;text-align: center;">รวมเป็นเงิน</th>
            </tr> 
        </thead> 
        <tbody>
            <?php
            if ($PCPlanTypeID == 1 || $PCPlanTypeID == 2) {
                $rs = app\modules\Purchasing\models\FmReportGpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                $count = app\modules\Purchasing\models\FmReportGpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->count();
                $sum = app\modules\Purchasing\models\FmReportGpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->sum('GPUExtendedCost');
                $i = 1;
                foreach ($rs as $r) {
                    ?>
                    <tr>
                        <td width="8%" style="text-align: center;vertical-align: top;"><?php echo $i; ?></td>
                        <td width="15%" style="text-align: center;vertical-align: top;"><?php echo $r->TMTID_GPU; ?></td>
                        <td width="40%" style="vertical-align: top;"><?php echo $r->FSN_GPU; ?></td>
                        <td width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->GPUUnitCost, 2); ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->GPUOrderQty, 2); ?></td>
                        <td  width="10%" style="text-align: center;vertical-align: top;"><?php echo $r->DispUnit; ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->GPUExtendedCost, 2); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else if ($PCPlanTypeID == 7 || $PCPlanTypeID == 8) {
                $rs = app\modules\Purchasing\models\FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                $count = app\modules\Purchasing\models\FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->count();
                $sum = app\modules\Purchasing\models\FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->sum('TPUExtendedCost');
                $i = 1;
                foreach ($rs as $r) {
                    ?>
                    <tr>
                        <td width="8%" style="text-align: center;vertical-align: top;"><?php echo $i; ?></td>
                        <td width="15%" style="text-align: center;vertical-align: top;"><?php echo $r->TMTID_TPU; ?></td>
                        <td width="40%" style="vertical-align: top;"><?php echo $r->ItemName; ?></td>
                        <td width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->TPUUnitCost, 2); ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->TPUOrderQty, 2); ?></td>
                        <td  width="10%" style="text-align: center;vertical-align: top;"><?php echo $r->DispUnit; ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->TPUExtendedCost, 2); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else if ($PCPlanTypeID == 3 || $PCPlanTypeID == 4) {
                $rs = app\modules\Purchasing\models\FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                $count = app\modules\Purchasing\models\FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->count();
                $sum = app\modules\Purchasing\models\FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->sum('PCPlanNDExtendedCost');
                $i = 1;
                foreach ($rs as $r) {
                    ?>
                    <tr>
                        <td width="8%" style="text-align: center;vertical-align: top;"><?php echo $i; ?></td>
                        <td width="15%" style="text-align: center;vertical-align: top;"><?php echo $r->ItemID; ?></td>
                        <td width="40%" style="vertical-align: top;"><?php echo $r->ItemName; ?></td>
                        <td width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->PCPlanNDUnitCost, 2); ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->PCPlanNDQty, 2); ?></td>
                        <td  width="10%" style="text-align: center;vertical-align: top;"><?php echo $r->DispUnit; ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->PCPlanNDExtendedCost, 2); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else if ($PCPlanTypeID == 5) {
                $rs = app\modules\Purchasing\models\FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                $count = app\modules\Purchasing\models\FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->count();
                $sum = app\modules\Purchasing\models\FmReportTpuplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->sum('TPUExtendedCost');
                $i = 1;
                foreach ($rs as $r) {
                    ?>
                    <tr>
                        <td width="8%" style="text-align: center;vertical-align: top;"><?php echo $i; ?></td>
                        <td width="15%" style="text-align: center;vertical-align: top;"><?php echo $r->TMTID_TPU; ?></td>
                        <td width="40%" style="vertical-align: top;"><?php echo $r->ItemName; ?></td>
                        <td width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->TPUUnitCost, 2); ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->TPUOrderQty, 2); ?></td>
                        <td  width="10%" style="text-align: center;vertical-align: top;"><?php echo $r->DispUnit; ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->TPUExtendedCost, 2); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            } else if ($PCPlanTypeID == 6) {
                $rs = app\modules\Purchasing\models\FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->all();
                $count = app\modules\Purchasing\models\FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->count();
                $sum = app\modules\Purchasing\models\FmReportNdplanDetail::find()->where(['PCPlanNum' => $PCPlanNum])->sum('PCPlanNDExtendedCost');
                $i = 1;
                foreach ($rs as $r) {
                    ?>
                    <tr>
                        <td width="8%" style="text-align: center;vertical-align: top;"><?php echo $i; ?></td>
                        <td width="15%" style="text-align: center;vertical-align: top;"><?php echo $r->ItemID; ?></td>
                        <td width="40%" style="vertical-align: top;"><?php echo $r->ItemName; ?></td>
                        <td width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->PCPlanNDUnitCost, 2); ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->PCPlanNDQty, 2); ?></td>
                        <td  width="10%" style="text-align: center;vertical-align: top;"><?php echo $r->DispUnit; ?></td>
                        <td  width="10%" style="text-align: right;vertical-align: top;"><?php echo number_format($r->PCPlanNDExtendedCost, 2); ?></td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
    <?php
    ?>
    <table class="tablefootergpuplan" width="100%" border="0" >
        <tr>
            <td width="50%">รวมทั้งสิ้น <?php echo $count; ?> รายการ</td>
            <td width="50%"  style="text-align: right;">ราคารวม <?php echo number_format($sum, 2); ?> บาท</td>
        </tr>
    </table>
<?php endif; ?>