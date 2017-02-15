<?php

use yii\helpers\Html;
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-1"></div>
    <div class="col-xs-12 col-sm-6 col-md-10">
        <?php
        if ($data != null) {
            $htl = '<table class="default kv-grid-table table table-hover table-bordered  table-condensed dataTable no-footer" width="100%" id="tabledata">
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
                $htl .= '<tr>';
                $htl .= '<td style="text-align:center">' . $result['ItemID'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['StkName'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['ItemQtyBalance'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                $htl .= '<td style="text-align:center">' . $result['Reorderpoint'] . '</td>';
                $htl .= '<td style="text-align:center">' . Html::a('Detail', ['view-stock-card2', 'itemid' => $result['ItemID'], 'stkid' => $result['StkID']], ['class' => 'btn btn-success btn-sm', 'target' => '_blank', 'data-pjax' => 0]) . '</td>';
                $htl .= '</tr>';
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
</div>


