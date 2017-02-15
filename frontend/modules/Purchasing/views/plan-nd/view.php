<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TbPcplan */

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
            [
                'attribute' => 'DepartmentID',
                'value' => $model->department->DepartmentDesc],
            [
                'attribute' => 'SectionID',
                'value' => $model->section->SectionDecs],
            [
                'attribute' => 'PCPlanTypeID',
                'value' => $model->pcplantype->PCPlanType],
            'PCPlanBeginDate',
            'PCPlanEndDate',
        ],
    ])
    ?>
    <?php
    if ($tbpcplangpu != null) {
        $htl = '
 <div class="row">
<div class="col-md">
<div style="margin:10px;">
<p><h4><i class="glyphicon glyphicon-hand-down"></i> รายละเอียดแผนการจัดชื้อ</h4></p>
    <div class="table-responsive">  
';
        $htl .='<table class="table table-striped table-bordered table-hover dt-responsive nowrap" id="tablenondrug1" width="100%">
		<thead >
                        <tr>
                            <th style="text-align:center" width="5%">
                            ลำดับ
                            </th>
                         
                            <th style="text-align:center">
                                รหัสสินค้า
                            </th>
                            <th style="text-align:center">
                                รายละเอียดสินค้า
                            </th>
                            <th style="text-align:center">
                                ราคาต่อหน่วย
                            </th>
                           
                            <th style="text-align:center">
                                จำนวน
                            </th>
                             <th style="text-align:center">
                                หน่วย
                            </th>
                            <th style="text-align:center">
                                รวมเป็นเงิน
                            </th>                     
                        </tr>
                    </thead>
		<tbody>';
        $no = 1;
        $cost = 0;
        foreach ($tbpcplangpu as $result) {
            $htl .='<tr>';
            $htl .= '<td style="text-align:center">' . $no . '</td>';
            //$htl .= '<td>' . $result['PCPlanNum'] . '</td>';
            $htl .= '<td style="text-align:center">' . $result['ItemID'] . '</td>';
            $htl .= '<td>' . $result['ItemName'] . '</td>';
            $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'], 2) . '</td>';
            
            $htl .= '<td align="right">' . number_format($result['PCPlanNDQty'], 2) . '</td>';
            $htl .= '<td style="text-align:center">'.$result['DispUnit'].'</td>';
            $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty'], 2) . '</td>';
//            $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanNonDrugItemEffectDate']) . '</td>';
            $htl .='</tr>';
            $no++;
            $cost = $cost + ($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty']);
        }
        $htl .='</tr></tbody>'
                . '<tfoot>
                            <tr>
                                <td colspan="4" style="background-color: #ddd;"></td>
                                <td colspan="2" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                              
                            </tr>
                        </tfoot>
                        </table>
                        </div>
                        </div>
                        </div>
                        </div>';
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
   $("#tablenondrug1").DataTable({bFilter: false, bInfo: false,
                    "dom": '<"pull-right"f><"pull-right"l>tip'}
       );
        });
JS;
$this->registerJs($script);
?>