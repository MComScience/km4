<?php

use yii\bootstrap\Modal;
use kartik\grid\GridView;
use yii\bootstrap\Html;
?>
<div class=" col-md-8">
    <?php
    if ($data != null) {
        $htl = '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th style="text-align:center">
					ลำดับ
				</th>
				<th style="text-align:center">
					ชื่อหมวดย่อย
				</th>
				<th style="text-align:center" width="11%">
					รายละเอียด
				</th>
			</tr>
                        </thead>
                        <tbody>';
        $no = 1;
        $cost = 0;
        $i = 1;
        foreach ($data as $result) {
            $htl .='<tr>';
              $htl .= '<td style="text-align:center">' . $i . '</td>';
            $htl .= '<td style="text-align:left">' . $result['DrugSubClass'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['DrugSubClassDesc'] . '</td>';
          
            $htl .='</tr>';
            $i++;
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
