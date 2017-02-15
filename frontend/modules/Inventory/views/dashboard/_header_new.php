<?php 
$rs = \app\modules\Inventory\models\VwDashbaordInvpur::find()->one();
?>
<div class="col-xs-12 col-sm-12 col-md-12">
    <table width="100%" class="tb1">
        <tr>
            <td width="5%" style="text-align: left;"></td>
            <td width="50%" style="text-align: left;"><h4><b>INVENTORY STATUS</b></h4></td>
            <td width="15%">
                <p style="font-size: 18pt;color: pink;"><?php echo $rs->ItemBelowReorderpoint; ?></p>
                <p>Item Below Re-Order Point</p>
            </td>
            <td width="10%">
                <p style="font-size: 18pt;color: pink;"><?php echo $rs->StockRequest; ?></p>
                <p>Stock Request</p>
            </td>
            <td width="10%">
                <p style="font-size: 18pt;color: pink;"><?php echo $rs->Purchasing; ?></p>
                <p>Purchase Order</p>
            </td>
            <td width="10%">
                <p style="font-size: 18pt;color: pink;"><?php echo $rs->LendProductOverDueDate; ?></p>
                <p>Over Due Date</p>
            </td>
        </tr>
    </table>
</div>
