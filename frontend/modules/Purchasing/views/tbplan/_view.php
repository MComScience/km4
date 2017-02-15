<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use app\models\TbDepartment;
use app\modules\Purchasing\models\VwPcplantypeNd;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use app\models\TbPcplan;
?>
<style>
    .ui-datepicker{ z-index:1151 !important; }
</style>
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

$this->title = 'บันทึกแผนการสั่งซื้อสินค้าเวชภัณฑ์มิใช่ยา';
$this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#addnondrugms").addClass("active");
    $("#effectivedate").datepicker({});
    '); ?>
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
            <?php yii\widgets\Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail13', 'value' => $auto, 'readonly' => true]) ?>

                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-province',
                        'prompt' => 'เลือกฝ่าย',
                        'disabled' => 'disabled'
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
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
                        ]
                    ])
                    ?>

                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'data' => [$section],
                        'disabled' => 'disabled',
                        'pluginOptions' => [
                            'depends' => ['ddl-province'],
                            'placeholder' => 'เลือกแผนก...',
                            'url' => Url::to(['tbplan/get-amphur'])
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'PCPlanTypeID')->dropdownList(
                            ArrayHelper::map(VwPcplantypeNd::find()->where(['PCPlanTypeID' => [3, 4]])->all(), 'PCPlanTypeID', 'PCPlanType'), [
                        'prompt' => 'SELECT OPTION',
                        'disabled' => 'disabled'
                    ]);
                    ?>
                </div>
                <div class="col-md-6">
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
                            'content' => '<i class="glyphicon glyphicon-phone"></i>',
                            'disabled' => 'disabled'
                        ],
                    ])
                    ?>
                </div>
                <div class="col-md-6">
              <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="status_" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                           echo Yii::$app->finddata->statusplan($model->PCPlanStatusID)
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $model->PCPlanStatusID; ?>" name="TbPcplan[PCPlanStatusID]" />
                </div>
                <div class="col-md-6">
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
                        ]
                    ])
                    ?>
                </div>
            </div>
            <hr>
            <br>
            <hr>
            <?php
            if ($tbpcplangpu != "") {
                $htl = '<div class="row">
         <div class="col-md-12">
        <p><h5 class="row-title before-success">รายละเอียดแผนการจัดชื้อ</h5><br></p><div class="table-responsive">';
                // $htl .=Yii::$app->headertable->headertableplandetail();
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
                    //  $htl .= '<td>' . $result['PCPlanNum'] . '</td>';
                    $htl .= '<td align="center">' . $result['ItemID'] . '</td>';
                    $htl .= '<td>' . $result['ItemName'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'], 2) . '</td>';
                    $htl .= '<td align="right">' . number_format($result['PCPlanNDQty'], 2) . '</td>';
                    $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
                    $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty'], 2) . '</td>';
                    $htl .= '<td align="center"></td>';
//                    $htl .= '<td align="center">' . $result['PRAVALIBLEQTY'] . '</td>';
// $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanNonDrugItemEffectDate']) . '</td>';
                    //   $htl .='<td align="center"><a href="#" onclick="editlistnondrug(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="#" onclick="deletedetailnondrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete"> Delete</a></td>';
                    $htl .='</tr>';
                    $no++;
                    $cost = $cost + ($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty']);
                }
                $htl .='</tr></tbody><tfoot>
                            <tr>
                                <td colspan="5" style="background-color: #ddd;"></td>
                                <td colspan="1" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td align="center" colspan="2">บาท</td>
                            </tr>
                        </tfoot>
                        </table>
                  </div>';
                echo $htl;
            }
            ?>
            <br>
            <div style="text-align: right"> <a href="index.php?r=Purchasing/tbplan" class="btn">Close</a></div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$s = <<< JS
$(document).ready(function() {
   $("#tablenondrug1").DataTable({
       "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 5,
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
