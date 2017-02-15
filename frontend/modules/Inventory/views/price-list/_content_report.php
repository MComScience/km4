<?php

use app\modules\Inventory\models\VwQuPricelist;
use app\modules\Inventory\models\VwQuPricelistSearch;
?>

<?php if ($type == 'header') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table-condensed">
        <tr> 
            <td width="45%" class="text-left" style="vertical-align: middle;">
                <img  height="80px" src="images/logocrop.jpg"/>
            </td>
            <td width="10%">

            </td> 
            <td width="45%" class="text-center" style="vertical-align: middle; font-size: 20pt;">
                <strong>ใบเสนอราคา</strong>
            </td>
        </tr>
        <tr>
            <td width="45%"> 

            </td>
            <td width="10%">

            </td> 
            <td width="45%" class="text-left" style="vertical-align: middle; font-size: 16pt;"> 
                เลขที่ &nbsp;<?php echo $model['ids_qu']; ?> 
                <p>วันที่ &nbsp;&nbsp;<?php echo Yii::$app->formatter->asDatetime($model['QUdate'], 'dd/MM/yyyy'); ?></p>
            </td>
        </tr>
    </table>
<?php endif; ?>

<?php if ($type == 'content') : ?>
    <hr>
    <table width="100%" border="0">
        <tr>
            <td width="50%" style="font-size: 16pt;">
                ผู้เสนอราคา 
            </td>
            <td width="50%" style="font-size: 16pt;">
                ผู้จัดจำหน่าย
            </td> 
        </tr>
    </table>

    <table width="100%" border="0">
        <tr>
            <td width="10%" style="font-size: 16pt;text-align: right;vertical-align: top;">
                บริษัท
            </td>
            <td width="40%" style="vertical-align: top;">
                <table width="100%"  class="kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
                    <tr>
                        <td style="width: 100%;height: 100px;vertical-align: top;font-size: 14pt;">
                            <p><b>ชื่อบริษัท</b>&nbsp;&nbsp; <?php echo $queryvendor1['VenderName']; ?></p>
                            <p><b>ที่อยู่ </b> &nbsp;&nbsp;<?php echo $queryvendor['VenderAddress']; ?> </p>
                            <p><b>รหัสประจำตัวผู้เสียภาษี</b> &nbsp;&nbsp; <?php echo $queryvendor['VenderTaxID']; ?> </p>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="10%" style="font-size: 16pt;text-align: right;vertical-align: top;">
                บริษัท
            </td>
            <td width="40%" style="font-size: 16pt;vertical-align: top;">
                <table width="100%"  class="kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
                    <tr>
                        <td style="width: 100%;height: 100px;vertical-align: top;font-size: 14pt;">
                            <p><b>ชื่อบริษัท</b> &nbsp;&nbsp;  <?php echo $queryvendor1['VenderName']; ?> </p>
                            <p><b>ที่อยู่</b>  &nbsp;&nbsp;<?php echo $queryvendor1['VenderAddress']; ?> </p>
                            <p><b>รหัสประจำตัวผู้เสียภาษี</b>  &nbsp;&nbsp;<?php echo $queryvendor1['VenderTaxID']; ?> </p>
                        </td>
                    </tr>
                </table>
            </td> 
        </tr>
    </table>
    <hr>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">

        <tr>
            <td width="10%" style="text-align: left;font-size: 16pt;vertical-align: top;" >
                รหัสยาการค้า 
            </td>
            <td width="85%">
                <table width="100%" class="kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
                    <tr>
                        <td width="100%" style="height: 30px;font-size: 14pt;">
                            <?php echo $model['TMTID_TPU']; ?>
                        </td>

                    </tr>
                </table>
            </td>
            <td width="5%"></td>
        </tr>

        <tr>
            <td style="height: 5px;"></td>
        </tr>

        <tr>
            <td width="10%" style="text-align: left;font-size: 16pt;vertical-align: top;">
                รายละเอียดยา
            </td>
            <td width="85%">
                <table width="100%" class="kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
                    <tr>
                        <td width="100%" style="height: 50px; vertical-align: top;font-size: 14pt;">
                            <?php echo $model['ItemName']; ?>

                        </td>

                    </tr>
                </table>
            </td>
            <td width="5%"></td>
        </tr>

        <tr>
            <td style="height: 5px;"></td>
        </tr>

        <tr>
            <td width="10%" style="text-align: left;font-size: 16pt;vertical-align: top;">
                <p>รายละเอียดเพิ่มเติม</p>
                <p>หรือข้อเสนอการค้า&nbsp;&nbsp;&nbsp;</p>
            </td>
            <td width="85%">
                <table width="100%" class="kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
                    <tr>
                        <td width="100%" style="height: 50px; vertical-align: top;font-size: 14pt; ">
                            <?php echo $model['QUComment']; ?> 
                        </td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
        </tr>

        <tr>
            <td style="height: 5px;"></td>
        </tr>

        <tr>
            <td width="10%" style="text-align: left;font-size: 16pt;vertical-align: top;">
                รายการเอกสารแนบ &nbsp;&nbsp;&nbsp;
            </td>

            <td width="85%">
                <table width="100%" class="kv-grid-table table table-hover table-bordered table-condensed kv-table-wrap">
                    <tr>
                        <td width="100%" style="height: 50px;font-size: 14pt;vertical-align: top;">
                            <?php
                                foreach ($modelfile as $data){
                                    echo '<p>'.$data->listFilesname($data['QUAttach1']).'</p>';
                                    echo '<p>'.$data->listFilesname($data['QUAttach2']).'</p>';
                                    echo '<p>'.$data->listFilesname($data['QUAttach3']).'</p>';
                                    echo '<p>'.$data->listFilesname($data['QUAttach4']).'</p>';
                                }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="5%"></td>
        </tr>
    </table>
    <br>
    <table width="100%" class="kv-grid-table table table-hover table-condensed kv-table-wrap">
        <tr>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                จำนวนที่เสนอ
            </td>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                ราคาต่อหน่วย
            </td>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                หน่วย
            </td>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;border-top: 1px solid #ddd;">
                รวมเป็นเงิน
            </td>
        </tr>
        <tr>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;">
                <?php echo number_format($model['QUOrderQty'],4); ?>
            </td>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;">
                <?php echo $model['QUUnitCost2']; ?>
            </td>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;">
                <?php echo $model['QUUnit']; ?>
            </td>
            <td width="25%" style="text-align: left; font-size: 16pt;border-bottom: 1px solid #ddd;">
                <?php echo number_format($model['QUUnitCost2'] * $model['QUOrderQty'], 4); ?> 
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellpadding="0" cellspacing="1">
        <tr>                                              
            <td style="text-align: left;font-size: 16pt;width: 100%">
                เงื่อนไขการเสนอราคา  
            </td>
        </tr>
    </table>
    <table width="100%" border="0" cellpadding="1" cellspacing="0" >
        <tr>
            <td style="text-align: left;font-size: 16pt;width: 5%">

            </td>
            <td style="text-align: left;font-size: 16pt;width: 95%">
                Minimum order&nbsp;&nbsp; <?php echo number_format($model['QUMQO'], 4); ?> 
                &nbsp;&nbsp; <?php echo $model['QUUnit']; ?> 
            </td>
        </tr>
        <tr>
            <td style="text-align: left;font-size: 16pt;width: 5%">

            </td>
            <td style="text-align: left;font-size: 16pt;width: 95%">
                ระยะเวลาในการจัดส่ง
                &nbsp;&nbsp;<?php echo $model['QULeadtime']; ?> &nbsp;&nbsp;วัน
            </td>
        </tr>
        <tr>
            <td style="text-align: left;font-size: 16pt;width: 5%">

            </td>
            <td style="text-align: left;font-size: 16pt;width: 95%">
                ยืนราคาถึงวันที่  &nbsp;&nbsp;<?php echo Yii::$app->formatter->asDatetime($model['QUValidDate'], 'dd/MM/yyyy'); ?>
            </td>
        </tr>
    </table>
    <hr>
<?php endif; ?>

<?php if ($type == 'footer') : ?>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
        <tr>
            <td width="50%" style="font-size: 14pt; text-align: left;">
                <b>KM4</b> medical software
            </td>
            <td width="50%" style="font-size: 14pt;text-align: right;">
                <?php
                $y = date('Y') + 543;
                $t = date('H:i:s');
                echo 'Print :' . date("d/m/") . $y . ' ' . $t;
                ?> By <?= Yii::$app->user->identity->username; ?>
            </td>
        </tr>
    </table>

<?php endif; ?>

