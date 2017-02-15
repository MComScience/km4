<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
?>
    <div class="col-sm-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-green"><div class="panel-title white"><?= Html::encode('Lot Number Detail') ?></div></div>
            <div class="table-responsive">  
                <?php
                if ($lotnumber != null) {
                    $htl = '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				
				<th style="text-align:center">
					Internal Lot Number
				</th>
				<th style="text-align:center">
					หมายเลขการผลิต
				</th>
				<th style="text-align:center" width="11%">
					วันหมดอายุ
				</th>
                                
				<th style="text-align:center">
					จำนวนแพค
				</th>
                                <th style="text-align:center">
					หน่วยแพค
				</th>
				<th style="text-align:center" width="11%">
					ราคา/แพค
				</th>
                                <th style="text-align:center" width="11%">
				 	จำนวน
				</th>
                                <th style="text-align:center" width="11%">
					หน่วย
				</th>
                                <th style="text-align:center" width="11%">
					ราคา/หน่วย
				</th>
                                <th style="text-align:center" width="11%">
					เป็นเงิน
				</th>
                                
			</tr>
                        </thead>
                        <tbody>';
                    $no = 1;
                    $cost = 0;
                    foreach ($lotnumber as $result) {
                        $htl .='<tr>';
                        $htl .= '<td style="text-align:center">' . $result['ItemInternalLotNum'] . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['ItemExternalLotNum'] . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['ItemExpDate'] . '</td>';
                        $htl .= '<td style="text-align:right">' . number_format($result['STPackQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['STPackUnit'] . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['STPackUnitCost'] . '</td>';
                        $htl .= '<td style="text-align:right">' . number_format($result['STItemQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                        $htl .= '<td style="text-align:right">' . number_format($result['STItemUnitCost'], 2) . '</td>';
                        $htl .= '<td style="text-align:right">' . number_format($result['STExtenedCost'], 2) . '</td>';
                       // $htl .='<td style="text-align:center"><a class="btn btn-info btn-xs" href="javascript:selectedt(' . $result['ids'] . ',' . $result['ids_sr'] . ')">Edit</a> <a class="btn btn-danger btn-xs" href="javascript:selectdelete(' . $result['ids'] . ',' . $result['ids_sr'] . ')">Delete</a></td>';
                        $htl .='</tr>';
                    }
                    echo $htl;
                } else {
                    echo '
            <div class="panel">
                                    <div class="panel-body">
                                     <div align="center">ไม่มีรายการ</div>
                                    </div>
                                  </div>';
                }
                ?>
            </div>
        </div>

    </div>
    <script>
        function selectedt(ids, ids_sr) {
            $.ajax({
                url: 'index.php?r=Inventory/tb-st2-temp/edit-detail',
                type: 'GET',
                data: {id: ids, ids_sr: ids_sr},
                success: function (data) {
                    $('#formdetail2').html(data);
                    $('#editlotselect_').modal('show');
                }
            });
        }
          function selectdelete(ids, ids_sr) {
               swal({
          title: message_confirmdelete,
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function (isConfirm) {
            if (isConfirm) { 
            $.ajax({
                url: 'index.php?r=Inventory/tb-st2-temp/delete-detail',
                type: 'GET',
                data: {id: ids, ids_sr: ids_sr},
                success: function (data) {
                  location.reload();
                }
            });
        }
    });
        }
    </script>
    <?php
    $script = <<< JS
$(document).ready(function() {
   $("#tabledata").DataTable({bFilter: false, bInfo: false,
                    "dom": '<"pull-right"f><"pull-right"l>tip'}
       );
        });
JS;
    $this->registerJs($script);
    ?>
    <?php
    Modal::begin([
        'id' => 'editlotselect_',
        'header' => '<h4 class="modal-title">แก้ไขข้อมูล</h4>',
        'size' => 'modal-dialog modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'closeButton' => FALSE,
    ]);
    ?>
    <div id="formdetail2"></div>
    <?php
    Modal::end();
    ?>