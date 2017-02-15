
<?php

use yii\helpers\Html;
?>
<?php if ($setheader == true) : ?>
    <!--------------------------------------- Begin Header  ---------------------------------------------->
    <table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="45%" style="vertical-align: top">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td>
                            <p style="font-size: 18pt"><b>โรงพยาบาลมะเร็งอุดรธานี</b></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 14pt">เลขที่ 36 หมู่ 1 ต.หนองไผ่ อ.เมือง จ.อุดรธานี 41330</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 14pt">โทรศัพท์ 042-207375-20</p>
                        </td>
                    </tr>
                    <tr>
                        xxx
                    </tr>
                    <tr>
                        xxxx
                    </tr>
                    <tr>
                        xxx
                    </tr>
                </table>
            </td>
            <td width="10%" class="text-center" style="vertical-align: bottom">
                <?= Html::img(Yii::getAlias('@frontend') . '/web/images/logo_iop_doc.jpg') ?>
            </td>
            <td  style="text-align: right;width: 40%;border-bottom: 0px;border-top: 0px;vertical-align: top;">
                <p style=" text-align: right; font-size: 16pt;"> หน้าที่ :{PAGENO}/{nbpg}</p>
                <p style=" text-align: right; font-size:14pt;"> Page No </p>
            </td>
        </tr>

        <?php ?>
    </table>
    <!--------------------------------------- End Header  ------------------------------------------------->
<?php endif; ?>
<?php if ($setcontent == true) : ?>
    <!--------------------------------------- Begin Content  ---------------------------------------------->
    <?php
    $no = 1;
    ?>
    <table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="30%" style="vertical-align: top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
                    <tr>
                        <td  style="text-align: left;width: 1px">
                            <p style="font-size: 18pt;"><b>HN</b></p>
                        </td>
                        <td  style="text-align: left;width: 250px">
                            <p style="font-size: 16pt;"><?= $header['pt_hospital_number']; ?></p>
                        </td>
                    </tr>
                    <tr> 
                        <td  style="text-align: left;width: 1px;font-size: 16pt;">ชื่อ<p></p> 
                            <p style="font-size: 14pt;"> Name </p>
                        </td>
                        <td  style="text-align: left;width: 250px;vertical-align: top">
                            <p style="font-size: 16pt;"><?= $header['pt_name']; ?></p>
                        </td>
                    </tr>

                    <tr>
                        <td  style="text-align: left;width: 1px">
                            <p style="font-size: 16pt;">เลขที่บัตรประจำตัว</p>
                        </td>
                        <td  style="text-align: left;width: 250px">
                            <p style="font-size: 16pt;">  : <?= $header['pt_cid']; ?> อายุ <?= $header['pt_age_registry_date']; ?> ปี  </p>
                        </td>
                    </tr>    
                </table>
            </td>

            <td width="10%" class="text-center" style="vertical-align: top;">
                <p style="font-size: 18pt"><b>ใบเสร็จรับเงิน</b></p>
                <p style="font-size: 16pt"><b>Recceipt</b></p>
            </td>

            <td width="45%" style="vertical-align: top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
                    <tr>
                        <td  style="text-align: right;width:120px;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;"> เลขที่ :</p><p>Receipt

                        <td  style="text-align: left;width: 180px;vertical-align: top;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;">&nbsp;<?= $header['rep_num']; ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td  style="text-align: right;width: 60px;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;">วันที่ : </p><p>Date.</p>       
                        </td>
                        <td  style="text-align: left;width: 80px;vertical-align: top;border-bottom: 0px;border-top: 0px">
                            <?php
                            $dataspit = explode(' ', $header['repdate']);
                            $dates = $dataspit[0];
                            ?>
                            <p style="font-size: 16pt;">&nbsp;<?php echo Yii::$app->componentdate->convertmonththai($dates); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td  style="text-align: right;width: 60px;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;">VN :</p>
                        </td>
                        <td  style="text-align: left;width: 80px;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;">&nbsp;<?= $header['pt_visit_number']; ?></p>
                        </td>
                    </tr>
                </table>   
            </td>
        </tr>
    </table>

    <table width="100%"  cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="45%" style="vertical-align: top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
                    <tr>
                        <td  style="text-align: left;width: 1px;vertical-align: top">
                            <p style="font-size: 16pt;">สิทธิ :</p>
                        </td>
                        <td  style="text-align: left;width: 250px">
                            <?php
                            $noar = 1;
                            foreach ($ar_name as $ar_names) :
                                ?>
                                <p style="font-size: 16pt;"><?= $noar . '.' . ' '; ?><?= $ar_names->ar_name1; ?></p>
                                <?php $noar++ ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;"> 
                            <p style="font-size: 16pt;"><b>แพทย์ผู้สั่ง </b></p>
                            <p>M.D.</p>
                        </td>
                        <td style="vertical-align: top;font-size: 16pt">&nbsp;<?= $header['cpoe_order_by']; ?> </td>
                    </tr>
                </table>
            <td width="10%" class="text-center" style="vertical-align: top;">
                <p ></p>
                <p ></p>
            </td>
            <td width="40%" style="vertical-align: top;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
                    <tr>
                        <td  style="text-align: center;width: 60px;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;"> AN :</p>
                        </td>
                        <td  style="text-align: center;width: 80px;border-bottom: 0px;border-top: 0px">
                            <p style="font-size: 16pt;">&nbsp;<?= $header['pt_admission_number']; ?></p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>
    <!-- Content -->
    <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <thead>
            <tr style="font-size: 14pt;">
                <th style="text-align:center;width: 35px;border-bottom:0.5px  solid black;border-top:0.5px solid black">
                    ลำดับ<p>No.</p>
                </th>
                <th style="text-align: center;width: 300px;border-bottom:0.5px  solid black;border-top:0.5px solid black">
                    รายการ<p>Description</p>
                </th>
                <th style="text-align: center;border-bottom:0.5px solid black;border-top: 0.5px  solid black">
                    จำนวน<p>Quantity</p>
                </th>

                <th style="text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">
                    จำนวนเงิน<p>Amt.</p>
                </th>
                <th style=" text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">
                    เบิกได้<p>Credit Amt.</p>
                </th>
                <th style=" text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">
                    ส่วนลด<p>Discount</p>
                </th>
                <th style="text-align: center;border-bottom:0.5px solid black;border-top: 0.5px solid black">
                    เป็นเงิน<p>Total</p>
                </th>
            </tr>
        </thead>
    <!--   <tfoot>
            <tr>
                <td style="text-align: left;border-bottom:0.5px solid black;border-top:0.5px solid black"></td>
                <td style="text-align: left;border-bottom:0.5px solid black;border-top:0.5px solid black"></td>
                <td style="text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">รวม</td>
          
                <td style="text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">{colsum2}</td>
                <td style="text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">{colsum2}</td>
                <td style="text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">{colsum2}</td>
                <td style="text-align: center;border-bottom:0.5px solid black;border-top:0.5px solid black">{colsum2}</td>

            </tr>
        </tfoot>-->-->

        <tbody>
            <?php foreach ($content as $detail) : ?>
                <tr>

                    <td width="5%" style="text-align: center;vertical-align: top"><?php echo $no; ?></td>
                    <td width="50%" style=""><?php echo $detail['ItemDetail'] ?></td>
                    <td width="10%" style="text-align:right;"><?php echo $detail['ItemQty1'] ?></td>
                    <td width="10%" style="text-align: right;" ><?php echo number_format($detail['Item_Amt'],2); ?></td>
                    <td width="10%" style="text-align: right;"><?php echo number_format($detail['Item_Cr_Amt_Sum'], 2); ?></td>
                    <td width="10%" style="text-align: right;"><?php echo number_format($detail['Item_Discount'],2); ?></td>
                    <td width="10%" style="text-align: right;"><?php echo number_format($detail['Item_Amt_Net'],2); ?></td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!--------------------------------------- End Content  ------------------------------------------------>
<?php endif; ?>
<?php if ($setfooter == true) : ?>
    <!--------------------------------------- Begin Footer  ------------------------------------------------>

    <!-- Footer -->

    <?php
    $rep_id = $header['rep_id'];
    $rs = \app\modules\Payment\models\VwFiRepDetail::find()->where(['rep_id' => $rep_id])->sum('ItemQty1');
    $command = Yii::$app->db->createCommand("SELECT sum(ItemQty1) as ItemQty1,sum(Item_Amt) as Item_Amt,sum(Item_Cr_Amt_Sum) as Item_Cr_Amt_Sum,sum(Item_Discount) as Item_Discount,sum(Item_Amt_Net) as Item_Amt_Net FROM vw_fi_rep_detail where rep_id = $rep_id");
    $sum = $command->queryAll();
    ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tfoot>
            <tr>    
                <td width="5%"  style="border-bottom:1px solid black;border-top: 0.5px solid black;"></td>
                <td width="50%" style="text-align: left;border-bottom:0.5px solid black;border-top: 0.5px solid black;"><?php echo Yii::$app->numberthai->Convert($sum[0]['Item_Amt_Net']); ?></td>
                <td width="10%" style="text-align:right;border-bottom:0.5px solid black;border-top: 0.5px solid black;text-align: right;">Grard total</td>
                <td width="10%" style="text-align:right;border-bottom:0.5px solid black;border-top: 0.5px solid black;"><?php echo number_format($sum[0]['Item_Amt']); ?></td>
                <td width="10%" style="text-align:right;Cellpadding:0.5pt;border-bottom:0.5px solid black;border-top: 0.5px solid black;"><?php echo number_format($sum[0]['Item_Cr_Amt_Sum'], 2); ?> </td>
                <td width="10%" style="text-align:right;border-bottom:0.5px solid black;border-top: 0.5px solid black;"><?php echo $sum[0]['Item_Discount'] ?></td>
                <td width="10%" style="text-align:right;border-bottom:0.5px solid black;border-top: 0.5px solid black;"><?php echo number_format($sum[0]['Item_Amt_Net'], 2); ?> </td>

            </tr>
        </tfoot>
    </table>

    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <thead>
            <tr>

            </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>

        </tfoot>

        <tr>
            <td  style="width: 16px;vertical-align: top;font-size: 14pt;">หมายเหตุ:</td>
            <td width="45%" style="vertical-align: top;font-size: 14pt;">
                <p> รวมค่ายาในบัญชีหลักแห่งชาติ จำนวนเงิน <?= $ed; ?>   บาท</p>
                รวมค่ายานอกบัญชีหลักแห่งชาติ จำนวนเงิน  <?= $ned; ?>  บาท
            </td>
            <td width="55%">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" >
                    <tr>
                        <td style="width: 14px;vertical-align: top;font-size: 14pt;">ชำระด้วย</td>
                    <td style="width: 230px;font-size: 14pt;">
                            <br/>
                             
                            เงินสด :&nbsp;<?= number_format($paid->rep_piad_cash, 2); ?>&nbsp;บาท<br/>
                            <?php foreach ($payment as $payment) : ?>
                                บัตรเครดิต&nbsp;<?= $payment->rep_creditcardetail; ?> :&nbsp; <?= number_format($payment->paid_creditcard, 2); ?> บาท<br/>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <br/>
    
    <table width="100%" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="text-center" style="font-size: 16pt;">
                ได้รับเงินไว้เป็นที่ถูกต้องแล้ว  
            </td>
        </tr>
    </table>
    <table style="width:100%">
        <thead>

                <!--        <th style="vertical-align: bottom; font-size: 16pt;">
                            ลงชื่อ
                        </th>-->
        <th style="vertical-align: bottom; font-size: 16pt;">
            ลงชื่อ
        </th>

    </thead>
    </table>
    <tbody>
        <tr>
    <!--            <td style="text-align: center">
                ___________________________________ 
                <br/>
                <br/>
                <p style="font-size: 16pt;"><?= $header['pt_name']; ?> </p>
                <p style="font-size: 16pt;">ผู้ป่วย</p>

            </td>-->
    <table width="100%" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td width="40%"></td>
            <td style="text-align: center ;font-size: 16pt;" width="60%">
                ลายมือชื่อ ____________________________________ผู้รับเงิน
            </td>
        </tr>
        <tr>
            <td width="40%">

            </td>
            <td style="text-align: center ;font-size: 16pt;" width="60%">
                <p style=" text-align: center; font-size: 16pt;"><?= $header['User_name']; ?> </p>
                <p style=" text-align: center;font-size: 16pt;">เจ้าหน้าที่การเงิน</p>
            </td>
        </tr>
    </table>
    </tr>  
    </tbody>
    </table>
    </tr>

    <br/>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tr>
            <td width="50%" class="text-left">
                <b>KM4</b> medical software
            </td>
            <td width="50%" class="text-right">
                <?php
                $y = date('Y') + 543;
                $t = date('H:i:s');
                echo 'Print :' . date("d/m/") . $y . ' ' . $t;
                ?> By <?= Yii::$app->user->identity->username; ?>
            </td>
        </tr>
    </table>

    <!--------------------------------------- End Footer  ------------------------------------------------->
<?php endif; ?>

