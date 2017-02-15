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

use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\SweetAlertAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
SweetAlertAsset::register($this);
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#tbplandrug").addClass("active");
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

$this->title = 'บันทึกแผนการจัดชื้อยาการค้า';
$this->params['breadcrumbs'][] = ['label' => 'แผนการจัดซื้อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .ui-datepicker{ z-index:1151 !important;}
    th{
        white-space: nowrap;
    }
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
            <?php yii\widgets\Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php
            $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'value' => $auto, 'readonly' => true]) ?>
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
                        ],
                    ])
                    ?>
                    <?=
                    $form->field($model, 'PCPlanTypeID')->dropdownList(
                            ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [7, 8]])->all(), 'PCPlanTypeID', 'PCPlanType'), [

                        'disabled' => 'disabled'
                    ]);
                    ?>
                    <div style="margin-left:150px;" id="plancssid"  class="hidden"><font color="red">ประเภทแผนจัดชื้อ ต้องไม่ว่างเปล่า</font></div>
                    <br>
                       <div class="form-group field-inputEmail3 required ">
                        <label class="control-label col-sm-3" for="inputEmail3">สถานะ</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="" style="text-align:left" name="TbPcplan[PCPlanStatusID]" value="<?php
                            echo Yii::$app->finddata->statusplan($model->PCPlanStatusID)
                            ?>" readonly="" maxlength="50">
                            <div class="help-block help-block-error "></div>
                        </div>
                    </div>
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
        </div> 
        <hr>
        <br>
        <hr>
        <?php
        if ($tbpcplangpu != "") {

            $htl = '<div class="row">
         <div class="col-md-12">
        <p><h5 class="row-title before-success">รายละเอียดแผนการจัดชื้อ</h5><br></p>
        <div class="table-responsive">';
            $htl .= '<table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
            <thead>
                <tr role="row">
                    <th style="text-align:center" width="5%">
                        ลำดับ
                    </th>
                    <th style="text-align:center">
                       รหัสยาการค้า
                    </th>
                    <th style="text-align:center">
                         รายละเอียดยาการค้า
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
                    <th style="text-align:center" width="10%">
                        ราคารวม
                    </th>
                   
                     <th style="text-align:center" >
                        
                    </th>
                </tr>
            </thead>
            <tbody>';
            $no = 1;
            $cost = 0;
            foreach ($tbpcplangpu as $result) {
                $htl .='<tr>';
                $htl .= '<td align="center">' . $no . '</td>';
                $htl .= '<td align="center">' . $result['TMTID_TPU'] . '</td>';
                $htl .= '<td>' . $result['ItemName'] . '</td>';
                $htl .= '<td align="right">' . number_format($result['TPUUnitCost'], 2) . '</td>';
                $htl .= '<td align="right">' . number_format($result['TPUOrderQty'], 2) . '</td>';
                $htl .= '<td align="center">' . $result['DispUnit'] . '</td>';
                $htl .= '<td align="right">' . number_format($result['TPUUnitCost'] * $result['TPUOrderQty'], 2) . '</td>';
                $htl .= '<td align="center"></td>';
              //  $htl .= '<td align="center">' . $result['PRAVALIBLEQTY'] . '</td>';
// $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanItemEffectDate']) . '</td>';
                //  $htl .= '<td>' . $result['PCPlanGPUItemStatusID'] . '</td>';
                //$htl .='<td align="center"><a href="javascript:void(0)" onclick="editlistdrugpcplan(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="#" onclick="deletelistdrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete"> Delete</a></td>';
                $htl .='</tr>';
                $no++;
                $cost = $cost + ($result['TPUUnitCost'] * $result['TPUOrderQty']);
            }
            $htl .='</tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td colspan="1" align="center">บาท</td> 
                            </tr>
                        </tfoot></table></div>';
            echo $htl;
        }
        ?><br>
        <div style="text-align: right">
            <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
</div>  
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$s = <<< JS
$(document).ready(function() {
   $('.submenu').css('display','none');
   $("#tabledata").DataTable({
          "dom": '<"pull-left"f><"pull-right"l>tip',
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



