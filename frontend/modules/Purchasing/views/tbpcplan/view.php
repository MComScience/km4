<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

$this->title = $model->PCPlanNum;
$this->params['breadcrumbs'][] = ['label' => 'Tb Pcplans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tb-pcplan-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?=
    DetailView::widget([
        'model' => $model,
        'enableEditMode' => false,
        'responsive' => true,
        'mode' => DetailView::MODE_VIEW,
        'panel' => [
            'heading' => 'Detail # ' . $model->PCPlanNum,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'PCPlanNum',
            'PCPlanDate',
            ['attribute' => 'DepartmentID',
                'value' => $model->department->DepartmentDesc],
            ['attribute' => 'SectionID',
                'value' => $model->section->SectionDecs],
            ['attribute' => 'PCPlanTypeID',
                'value' => $model->pcplantype->PCPlanType],
            'PCPlanBeginDate',
            'PCPlanEndDate',
        ],
    ])
    ?>
    <?php
    if ($tbpcplangpu != null) {
        $htl = '<div class="row">
         <div class="col-md-12">
        <p><h4><i class="glyphicon glyphicon-hand-down"></i> รายละเอียดแผนการจัดชื้อ</h4></p>
    <div class="table-responsive">  
';
        $htl .= '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th width="5%">
					ลำดับ
				</th>
				<th>
					รหัสยาสามัญ
				</th>
				<th>
					รายละเอียดยาสามัญ
				</th>
				<th width="11%">
					ราคาต่อหน่วย
				</th>
                                
				<th>
					จำนวน
				</th>
                                <th>
					หน่วย
				</th>
				<th width="11%">
					รวมเป็นเงิน
				</th>
			</tr>
                        </thead>
                        <tbody>';
        $no = 1;
        $cost = 0;
        // $htl = "";
        foreach ($tbpcplangpu as $result) {
            $htl .='<tr>';
            $htl .= '<td>' . $no . '</td>';
            $htl .= '<td>' . $result['TMTID_GPU'] . '</td>';
            $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['GPUUnitCost'], 2) . '</td>';
            
            $htl .= '<td align="right">' . number_format($result['GPUOrderQty'], 2) . '</td>';
            $htl .= '<td>' . $result['DispUnit'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['GPUExtendedCost'], 2) . '</td>';
            //$htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanGPUItemEffectDate']) . '</td>';
            $htl .='</tr>';
            $no++;
            $cost = $cost + ($result['GPUExtendedCost']);
        }
        $htl .='</tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                              
                            </tr>
                        </tfoot></table>';
        $htl .='</div></div></div>';
        echo $htl;
    } else {
        echo '<p><h4><i class="glyphicon glyphicon-hand-down"></i>รายละเอียดแผนการจัดชื้อ</h4></p>
            <div class="panel panel-danger">
                                    <div class="panel-body">
                                     <div align="center">ไม่มีรายการ</div>
                                    </div>
                                  </div>';
    }
    ?>
</div>
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