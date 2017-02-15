<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TbPcplan;
use app\modules\Purchasing\models\VwPcplantypeDrug;
use app\models\TbDepartment;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#pcplanbydrug").addClass("active");
    $("#effectivedate").datepicker({});
    '); ?>
<?php
if ($model->PCPlanNum == "") {
    $result = TbPcplan::find()->count();
    $auto = $result + 1;
    $dat = substr(date('Y') + 543, 2, 4);
    $auto = sprintf("%04d", $auto);
    $auto = 'PC' . $dat . '-' . $auto;
} else {
    $auto = $model->PCPlanNum;
}
$this->title = 'บันทึกแผนการจัดชื้อยาสามัญ';
$this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .ui-datepicker{ z-index:1151 !important;}
</style>
<ul class="nav nav-tabs " id="myTab5">
    <li class="active">
        <a data-toggle="tab" href="#home5">
            <?= Html::encode($this->title) ?>
        </a>
    </li>  
</ul>

<div class="tab-content">
    <div id="home5" class="tab-pane in active">
        <div class="well">
            <?php Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php
            $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'value' => $auto, 'readonly' => true]) ?>

                    <?php
                    echo
                    $form->field($model, 'PCPlanDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                    <?=
                    $form->field($model, 'PCPlanTypeID')->dropdownList(
                            ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [1, 2]])->all(), 'PCPlanTypeID', 'PCPlanType'), [
                        'prompt' => 'SELECT OPTION',
                        'disabled' => 'disabled'
                    ]);
                    ?> 
                    <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                            echo Yii::$app->finddata->statusplan($model->PCPlanStatusID)
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <?php
                    $form->field($model, 'PCPlanStatusID')->dropdownList(
                            ArrayHelper::map(TbPcplanstatus::find()->all(), 'PCPlanStatusID', 'PCPlanStatus'), [
                        //   'placeholder' => 'Select Option',
                        //  'readonly' => 'readonly'
                        'disabled' => 'disabled'
                    ]);
                    ?>
                </div>

                <div class="col-sm-6">
                    <?=
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-department',
                        'prompt' => 'เลือกฝ่าย',
                        'disabled' => 'disabled'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'options' => ['id' => 'ddl-section', 'disabled' => 'disabled'],
                        'data' => [$section],
                        'pluginOptions' => [
                            'depends' => ['ddl-department'],
                            //  'placeholder' => 'เลือกอำเภอ...',
                            'url' => Yii::$app->request->baseUrl . '/index.php?r=Purchasing/tbpcplan/getsection'
                        ]
                    ]);
                    ?>
                    <?=
                    $form->field($model, 'PCPlanBeginDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                    <?=
                    $form->field($model, 'PCPlanEndDate')->widget(DatePicker::classname(), [
                        'language' => 'th',
                        'dateFormat' => 'dd/MM/yyyy',
                        'clientOptions' => [
                            'changeMonth' => true,
                            'changeYear' => true,
                        ],
                        'options' => [
                            'class' => 'form-control',
                            'placeholder' => 'Select issue date ...',
                            'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                </div>
            </div>
            <hr>
            <?php
            if ($tbpcplangpu != "") {
                $htl = '<div class="row">
         <div class="col-md-12">
        <p><hr><h5 class="row-title before-success">รายละเอียดแผนการจัดชื้อ</h5></p>
    <div class="table-responsive">
';
                $htl .= '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th style="text-align:center" width="5%">
					ลำดับ
				</th>
				<th style="text-align:center">
รหัสยาสามัญ
				</th>
				<th style="text-align:center">
					' . $attribute['FSN_GPU'] . '
				</th>
				<th style="text-align:center" width="11%">
					' . $attribute['GPUUnitCost'] . '
				</th>
                                
				<th style="text-align:center">
					' . $attribute['GPUOrderQty'] . '
				</th>
                                <th style="text-align:center">
					' . $attribute['DispUnit'] . '
				</th>
                                <th style="text-align:center" width="11%">
					' . $attribute['GPUExtendedCost'] . '
				</th>
                                 <th style="text-align:center">
					
				</th>
                             
			</tr>
                        </thead>
                        <tbody>';
                $no = 1;
                $cost = 0;
                foreach ($tbpcplangpu as $result) {
                    $htl .='<tr>';
                    $htl .= '<td align="center">' . $no . '</td>';
                    $htl .= '<td align="center">' . $result['TMTID_GPU'] . '</td>';
                    $htl .= '<td>' . $result['FSN_GPU'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['GPUUnitCost'], 2) . '</td>';
                    $htl .= '<td align="right">' . number_format($result['GPUOrderQty'], 2) . '</td>';
                    $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['GPUUnitCost'] * $result['GPUOrderQty'], 2) . '</td>';
                    $htl .= '<td align="right"></td>';
//                    $htl .= '<td align="right">' . $result['PRAVALIBLEQTY'] . '</td>';
//                    $htl .='<td style="text-align:center"><a href="javascript:editlistdrugpcplan(' . $result['ids'] . ')"  class="btn btn-info btn-xs edit"> Edit</a> <a href="javascript:deletelistdrug(' . $result['ids'] . ')"  class="btn btn-danger btn-xs delete"> Delete</a></td>';
                    $htl .='</tr>';
                    $no++;
                    $cost = $cost + ($result['GPUUnitCost'] * $result['GPUOrderQty']);
                }
                $htl .='</tr></tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td colspan="2" style="text-align:center">บาท</td> 
                            </tr>
                        </tfoot>
                        </table>
              </div>';
                echo $htl;
            }
            ?>
            <br>
            <div style="text-align: right"> <a href="index.php?r=Purchasing/tbpcplan" class="btn">Close</a></div>
        </div> 
    </div>

</div>

<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>


<?php
$s = <<< JS
$(document).ready(function() {
   $("#tabledata").DataTable({
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
           }
       ); 
  });
JS;
$this->registerJs($s);
?>