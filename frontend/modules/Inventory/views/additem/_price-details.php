<?php

use yii\helpers\Html;

$no = 1;
$no2 = 1;
?>


<input class="form-control" id="tbitem-itemid" value="<?php echo $dataitem->ItemID; ?>" type="hidden"/>
<input class="form-control" id="tbitem-itemname" value="<?php echo $dataitem->ItemName; ?>" type="hidden"/>
<input class="form-control" id="tbitem-itemdispunit" value="<?php echo $dataitem->DispUnit; ?>" type="hidden"/>

<p></p>
<div class="row">
    <div class="col-md-12 col-md-offset-0">

        <a class="btn btn-success" onclick="Additemprice(this);"><i class="glyphicon glyphicon-plus"></i>ราคาขาย</a>
        <p></p>
        <div id="query_itemprice">
            <?php if ($itemprice != null) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover dt-responsive " cellspacing="0" width="100%" >
                        <thead>
                            <tr>
                                <th style="text-align: center;color:black;background-color: #ddd" widht="36px">#</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">ราคาขาย</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">หน่วย</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">วันที่เริ่มใช้</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itemprice as $data): ?>
                                <tr>
                                    <td style="text-align: center;color:black;"><?php echo $no2 ?></td>
                                    <td style="text-align: center;color:black;"><?php echo number_format($data['ItemPrice'], 2); ?></td>
                                    <td style="text-align: center;color:black;"><?php echo $data['DispUnit']; ?></td>
                                    <td style="text-align: center;color:black;"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($data['ItemPriceEffectiveDate']); ?></td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-info btn-xs" onclick="UpdateItemprice(this);" data-id="<?php echo $data['ItemID']; ?>" id="<?php echo $data['ItemPriceEffectiveDate'] ?>"> Edit</a>
                                        <a class="btn btn-danger btn-xs" onclick="Deleteitemprice(this);" data-id="<?php echo $data['ItemID']; ?>" id="<?php echo $data['ItemPriceEffectiveDate'] ?>"> Delete</a>
                                    </td>
                                </tr>
                                <?php $no2++; ?>
                            <?php endforeach; ?>
                    </table>
                </div>
            <?php } else { ?>
                <div style="text-align: center">
                    <code style="font-size: 15px">No data found</code>
                </div>
            <?php } ?>
        </div>
        <p></p>
        <a class="btn btn-success" onclick="Addcredit(this);"><i class="glyphicon glyphicon-plus"></i>เบิกได้ตามสิทธิ์การรักษา</a>
        <p></p>
        <div id="query_credititem">
            <?php if ($creditprice != null) { ?>
                <div class="table-responsive">
                    <table class="table  table-bordered table-hover dt-responsive " cellspacing="0" width="100%" >
                        <thead>
                            <tr>
                                <th style="text-align: center;color:black;background-color: #ddd" widht="36px">#</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">ประเภทสิทธิ</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">เบิกได้ตามสิทธิการรักษา</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">วันที่เริ่มใช้</th>
                                <th  style="text-align: center;color:black;background-color: #ddd">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($creditprice as $record): ?>
                                <tr>
                                    <td style="text-align: center;color:black;"><?php echo $no ?></td>
                                    <td style="text-align: center;color:black;"><?php echo $record['medical_right_group']; ?></td>
                                    <td style="text-align: center;color:black;"><?php echo number_format($record['cr_price'], 2); ?></td>
                                    <td style="text-align: center;color:black;"><?php echo Yii::$app->componentdate->convertMysqlToThaiDate2($record['cr_effectiveDate']); ?></td>
                                    <td style="text-align: center;">
                                        <a class="btn btn-info btn-xs" onclick="UpdateCredititem(this);" data-id="<?php echo $record['ItemID']; ?>" id="<?php echo $record['medical_right_group_id'] ?>"> Edit</a>
                                        <a class="btn btn-danger btn-xs" onclick="DeleteCredititem(this);" data-id="<?php echo $record['ItemID']; ?>" id="<?php echo $record['medical_right_group_id'] ?>"> Delete</a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                    </table>
                </div>
            <?php } else { ?>
                <div style="text-align: center">
                    <code style="font-size: 15px">No data found</code>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
