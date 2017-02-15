<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
?>

<div class="col-xs-12 col-md-6">
    <div style="text-align: center"><i class="glyphicon glyphicon-hand-down"></i></div> 
        <?php
        if ($data != null) {
            $htl = '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th style="text-align:center">
					รหัสสินค้า
				</th>
				<th style="text-align:center">
					คลังสินค้า
				</th>
				<th style="text-align:center" width="11%">
					ยอดคงคลัง
				</th>
                                
				<th style="text-align:center">
					หน่วย
				</th>
                                <th style="text-align:center">
					Re-Order Point
				</th>
                                 <th style="text-align:center">
					Stock Card
				</th>
			</tr>
                        </thead>
                        <tbody>';
            $no = 1;
            $cost = 0;
            foreach ($data as $result) {
                $htl .='<tr>';
                $htl .= '<td style="text-align:center">' . $result['ItemID'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['StkName'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['ItemQtyBalance'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['Reorderpoint'] . '</td>';
                $htl .= '<td style="text-align:center"><a class="btn btn-success btn-xs" href="javascript:selectdetail(' . $result['ItemID'] . ',' . $result['StkID'] . ')">Detail</a></td>';
                $htl .='</tr>';
            }
            echo $htl;
        } else {
            echo '
            <div class="panel panel-danger">
                                    <div class="panel-body">
                                     <div align="center">ไม่มีรายการ</div>
                                    </div>
                                  </div>';
        }
        ?>
</div>
<script>
    function  selectdetail(itemid, stkid) {
		 window.location.replace("index.php?r=Purchasing/dashboard/view-stock-card2&itemid="+itemid+"&stkid="+stkid);
      /*  $.ajax({
            url: 'index.php?r=Inventory/dashboard/view-stockcard',
            type: 'POST',
            data: {itemid: itemid, stkid: stkid},
            dataType: 'json',
            success: function (data) {
                $('#_result').html(data.html);
                $('#itemid').html(data.itemid);
                $('#itemname').html(data.itemname);
                $('#tpu_sr2_detail_list').modal('show');
                $('#data_tpu').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 10,
                    responsive: true,
                    "language": {
                        "lengthMenu": " _MENU_ ",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": "ค้นหา "
                    },
                    "aLengthMenu": [
                        [5, 10, 15, 20, 100, -1],
                        [5, 10, 15, 20, 100, "All"]
                    ]
                });
            }
        });*/
    }
</script>
<?php
Modal::begin([
    'id' => 'tpu_sr2_detail_list',
    'header' => '<h4 class="modal-title">Stock Card</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="control-label col-sm-8">รหัสสินค้า:  <span id="itemid"></span></label>
        </div>
        <br>
        <div class="form-group">
            <label class="control-label col-sm-8" >ชื่อสินค้า:  <span id="itemname"></span></label> 
        </div>
    </div>
</div>
<br>
<div id="_result"></div>
<?php Modal::end(); ?>


