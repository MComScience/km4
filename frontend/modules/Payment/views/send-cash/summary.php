<?php

use yii\helpers\Html;
?>
<!--------------------------------------- Begin Header  ---------------------------------------------->
<?php if ($header == 'header') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="33%" class="text-left" style="vertical-align: top;">
                <img  height="100px" src="images/logocrop.jpg"/>
            </td>
            <td width="33%">

            </td>
            <td width="33%" style="vertical-align: bottom; font-size: 18pt;" class="text-center">
                <span><b>รายงานการนำส่งเงิน</b></span><p></p>
                <span><b>Receipt Summary Report</b></span>
            </td>
        </tr>

    </table>
    <p>

    </p>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td width="33%" style="font-size:16pt">
                <?php echo 'เลขที่ใบนำส่งเงิน : ' . $summary_header->rep_summary_id; ?>
            </td>
            <td width="33%" class="text-right" style="font-size:18pt">

            </td>
            <td width="33%" class="text-left" style="font-size:16pt">
                <?php echo 'แผนก : ' . $summary_header->SectionDecs; ?>
            </td>
        </tr>
        <tr>
            <td width="20%" class="text-left" style="font-size:16pt">
                <p>วันที่   <?php
                    $dataspit = explode(' ', $summary_header->rep_summary_date);
                    $dates = $dataspit[0];
                    ?>

                    <?php echo Yii::$app->componentdate->convertmonththai($dates); ?> </p>
            </td>
            <td>

            </td>
            <td>

            </td>
        </tr>
    </table>
<?php endif; ?>
<!--------------------------------------- End Header  ------------------------------------------------->


<!--------------------------------------- Begin Content  ---------------------------------------------->
<?php if ($content == 'content') : ?>
<br/>
<br/>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr width="25%">
            <td style="font-size: 16pt;text-align:left;border-top: 0.5px solid black;" width="30%">
                <span> รายละเอียดการรับบัตรเครดิต </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;">
                <span> รวม  </span>
                <?php echo $data_listcount['count_creditcard']; ?>              
                <span> รายการ </span>
            </td>

            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;text-align:right">
                <?php echo number_format($data_content['sum_creditcard1'],2); ?> 
            </td>
            <td width="10%" class="text-center" style="font-size: 16pt;border-top: 0.5px solid black;">
                <span>บาท</span>
            </td>

        </tr>
        <tr width="25%">
            <td style="font-size: 16pt;text-align:left;border-top: 0.5px solid black;" width="30%">
                <span> รายละเอียดการโอนเงินธนาคาร </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;">
                <span> รวม <?php echo $data_listcount['count_banktransfer']; ?> รายการ </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;text-align: right">
                <?php echo number_format($data_content ['sum_banktransfer1'],2); ?> 
            </td>
            <td width="10%" class="text-center" style="font-size: 16pt;border-top: 0.5px solid black;">
                <span>บาท</span>
            </td> 
        </tr>
        <tr width="25%">

            <td style="font-size: 16pt;text-align:left;border-top: 0.5px solid black;" width="30%">
                <span> รายละเอียดการรับเช็ค </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;">
                <span> รวม  <?php echo $data_listcount['count_cheque']; ?> รายการ </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;text-align: right">
                <?php echo number_format($data_content ['sum_cheque1'],2); ?> 
            </td>
            <td width="10%" class="text-center" style="font-size: 16pt;border-top: 0.5px solid black;">
                <span>บาท</span>
            </td> 
        </tr>
        <tr width="25%">
            <td style="font-size: 16pt;text-align:left;border-top: 0.5px solid black;border-bottom: 0.5px solid black;" width="30%">
                <span> รับชำระเงินสด </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                <span> รวม <?php echo $data_listcount['count_cash']; ?> รายการ </span>
            </td>
            <td width="30%" style="font-size: 16pt;border-top: 0.5px solid black;border-bottom: 0.5px solid black;text-align: right">
                <?php echo number_format( $data_content['sum_cash1'],2); ?> 
            </td>
            <td width="10%" class="text-center" style="font-size: 16pt;border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                <span>บาท</span>
            </td> 
        </tr>
    </table>
    <br/>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr>
            <td style="font-size: 16pt;text-align:right;width: 10%;" >
                <p>ธนบัตร</p>
            </td>
            <td style="width:40%"></td>

            <td style="width: 10%;text-align: right;font-size: 16pt;">
                <p>เหรียญ</p>
            </td>
            <td style="width:40%"></td>
        </tr>
        <tr>
            <td style="width:10%"></td>
            <td style="width:40%">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" id="style1">
                    <tr>
                        <td width="20%" style="font-size:16pt;">1000 บาท</td>
                        <td width="15%" style="font-size:16pt; text-align: center;"> <?php echo ($data_header->banknote1000 == 0 ? '-' : $data_header->banknote1000); ?> </td>
                        <td  width="15%" style="font-size:16pt;text-align: left;"> ใบ</td>
                        <td width="50%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->banknote1000 == 0 ? '-' : number_format($data_header->banknote1000 * 1000,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="20%" style="font-size:16pt;"> 500 บาท </td>
                        <td width="15%" style="font-size:16pt; text-align: center;"><?php echo ($data_header->banknote500 == 0 ? '-' : $data_header->banknote500); ?></td>
                         <td  width="15%" style="font-size:16pt;text-align: left;">ใบ</td>
                        <td width="50%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->banknote500 == 0 ? '-' : number_format($data_header->banknote500 * 500,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="20%" style="font-size:16pt;">100 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->banknote100 == 0 ? '-' : $data_header->banknote100); ?></td>
                         <td  width="15%" style="font-size:16pt;text-align: left;">ใบ</td>
                        <td width="50%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->banknote100 == 0 ? '-' :number_format($data_header->banknote100 * 100,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="20%" style="font-size:16pt;">50 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->banknote50 == 0 ? '-' : $data_header->banknote50); ?></td>
                         <td  width="15%" style="font-size:16pt;text-align: left;">ใบ</td>
                        <td width="50%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->banknote50 == 0 ? '-' : number_format($data_header->banknote50 * 50,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="20%" style="font-size:16pt;">20 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->banknote20 == 0 ? '-' : $data_header->banknote20); ?></td>
                         <td  width="15%" style="font-size:16pt;text-align: left;">ใบ</td>
                        <td width="50%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->banknote20 == 0 ? '-' : number_format($data_header->banknote20 * 20,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width=25% style="font-size:16pt;">10 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->banknote10 == 0 ? '-' : $data_header->banknote10); ?></td>
                         <td  width="15%" style="font-size:16pt;text-align: left;">ใบ</td>
                        <td width="50%" style="font-size:16pt;">เป็นเงิน <?php echo ($data_header->banknote10 == 0 ? '-' : $data_header->banknote10 * 10); ?> บาท</td>
                    </tr>
                </table>
            </td>
            <td style="width:10%"></td>
            <td style="width:40%">
                <table width="100%"  cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td width="25%" style="font-size:16pt;">10 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->coin10bt == 0 ? '-' : $data_header->coin10bt); ?></td>
                        <td  width="20%" style="font-size:16pt;">เหรียญ</td>
                        <td width="45%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->coin10bt == 0 ? '-' : number_format($data_header->coin10bt *10,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="25%" style="font-size:16pt;">5 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->coin5bt == 0 ? '-' : $data_header->coin5bt); ?></td>
                         <td  width="20%" style="font-size:16pt;">เหรียญ</td>
                        <td width="45%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->coin5bt == 0 ? '-' : number_format($data_header->coin5bt *5,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="25%" style="font-size:16pt;">2 บาท</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->coin2bt == 0 ? '-' : $data_header->coin2bt); ?></td>
                         <td  width="20%" style="font-size:16pt;">เหรียญ</td>
                        <td width="45%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->coin2bt == 0 ? '-' : number_format($data_header->coin2bt *2,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="25%" style="font-size:16pt;">1 บาท</td>
                        <td width="15%" style="font-size:16pt; text-align: center;"><?php echo ($data_header->coin1bt == 0 ? '-' : $data_header->coin1bt); ?></td>
                         <td  width="20%" style="font-size:16pt;">เหรียญ</td>
                        <td width="45%" style="font-size:16pt;">เป็นเงิน <?php echo $data_header->coin1bt == 0 ? '-' :number_format($data_header->coin1bt *1,2); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="25%" style="font-size:16pt;">50 สตางค์</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->coin50cn == 0 ? '-' : $data_header->coin50cn); ?></td>
                        <td  width="20%" style="font-size:16pt;">เหรียญ</td>
                        <td width="45%" style="font-size:16pt;">เป็นเงิน <?php echo ($data_header->coin50cn == 0 ? '-' : $data_header->coin50cn); ?> บาท</td>
                    </tr>
                    <tr>
                        <td width="25%" style="font-size:16pt;">25 สตางค์</td>
                        <td width="15%" style="font-size:16pt;text-align: center; "><?php echo ($data_header->coin25cn == 0 ? '-' : $data_header->coin25cn); ?></td>
                         <td  width="20%" style="font-size:16pt;">เหรียญ</td>
                        <td width="45%" style="font-size:16pt;">เป็นเงิน <?php echo ($data_header->coin25cn == 0 ? '-' : $data_header->coin25cn); ?> บาท</td>
                    </tr>
                </table>
            </td>
        </tr>


    </table>

<?php endif; ?>

<!--------------------------------------- End Content  ------------------------------------------------>



<!--------------------------------------- Begin Content  ---------------------------------------------->

<?php if ($footer == 'footer') : ?>

    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <thead></thead>
        <tbody></tbody>
        <tfoot>  
            <tr>
                <td style="font-size: 16pt;text-align:left;border-top: 0.5px solid black;width: 60%;border-bottom: 0.5px solid black;">
                    <p>รวมเป็นเงิน <?php echo !empty($total['sum_total']) ? Yii::$app->numberthai->Convert($total['sum_total']) : ''; ?></p>
                </td>
                <td style="width: 10%;text-align: center;font-size: 16pt;border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                    <p>ราคารวม  </p>
                </td>
                <td style="width: 20%;text-align: center;font-size: 16pt;border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                    <?php echo number_format($total['sum_total'],2); ?>
                </td>
                <td style="width: 10%;text-align: center;font-size: 16pt;border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                    <p>บาท</p>
                </td>

            </tr>

        </tfoot>

    </table>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tr>
            <td style="font-size: 16pt;">
                <P><?php echo 'หมายเหตุ  : ' . $remark->rep_summary_remark; ?></P>
            </td>
        </tr>
    </table>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>

    <table style="width:100%" cellspacing="0" cellpadding="0" border="0">

        <tbody>
            <tr>
                <td style="text-align:left;font-size:16pt;">
                    ลายมือชื่อ ________________________________
                </td>
                <td style="text-align: right;font-size: 16pt;">
                    ลายมือชื่อ ___________________________________ 
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    <p style="font-size: 16pt;"><?= Yii::$app->user->identity->username; ?></p>
                    <p style="text-align: center; font-size: 16pt;"><b>ผู้นำส่งเงิน</b></p>
                </td>
                <td style="text-align: center;">
                    <p></p>
                    <p style=" text-align: center; font-size: 16pt;"><b>ผู้รับเงิน</b></p>
                </td>
            </tr>
        </tbody>
    </table>
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
<?php endif; ?>  
<!--------------------------------------- End Footer  ------------------------------------------------->





