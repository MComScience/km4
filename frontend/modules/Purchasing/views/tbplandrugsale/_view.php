<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\TbPcplan;
use app\models\TbDepartment;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#drugsale").addClass("active");
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

$this->title = 'บันทึกสัญญาจะชื้อจะขายยา';
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
            <?php yii\widgets\Pjax::begin(['id' => 'branchesGrid']); ?>
            <?php
            $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'value' => $auto, 'readonly' => true]) ?>
                    <?= $form->field($model, 'PCPOContactID')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>
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
                        'options' => ['id' => 'ddl-section'],
                        'data' => [$section],
                        'disabled' => 'disabled',
                        'pluginOptions' => [
                            'depends' => ['ddl-department'],
                            //  'placeholder' => 'เลือกอำเภอ...',
                            'url' => Yii::$app->request->baseUrl . '/index.php?r=Purchasing/tbpcplan/getsection'
                        ]
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
                        'disabled' => 'disabled'
                    ]);
                    ?>
                </div>
                <div class="col-sm-6">
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
                    <?=
                    $form->field($model, 'PCVendorID')->textInput(['maxlength' => true, 'disabled' => 'disabled'])
                    ?>
                    <div class="form-group field-tbpcplan-pcvendorid">
                        <label  class="control-label col-sm-3" for="inputEmail3">ชื่อผู้ขาย</label>
                        <div class="col-sm-6">
                            <input type="text" name="vendername" id="vendername" readonly="true" class="form-control" value="<?php echo(!empty($vendername) ? $vendername : ''); ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <br>
            <hr>
            <div id="food">
                <?php
                if ($tbpcplangpu != "") {
                    $htl = '<h4 class="row-title before-success">รายละเอียดแผน</h4>  <br>                                                              ';
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
                     <th style="text-align:center">
                        
                    </th>
                   
                </tr>
            </thead>
            <tbody>';
                    $no = 1;
                    $cost = 0;
                    foreach ($tbpcplangpu as $result) {
                        $htl .='<tr>';
                        $htl .= '<td style="text-align:center">' . $no . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['TMTID_TPU'] . '</td>';
                        $htl .= '<td>' . $result['ItemName'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['TPUUnitCost'], 2) . '</td>';
                        $htl .= '<td align="right">' . number_format($result['TPUOrderQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['TPUUnitCost'] * $result['TPUOrderQty'], 2) . '</td>';
//                        $htl .= '<td style="text-align:center">' . $result['PRAPROVEDCUM'] . '</td>';
                        $htl .= '<td style="text-align:center"></td>';
                        //   $htl .='<td style="text-align:center"><a href="javascript:void(0)" onclick="editlistdrugpcplan(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="#" onclick="deletelistdrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete"> Delete</a></td>';
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
                               <td style="text-align:center" colspan="2">บาท</td> 
                            </tr>
                        </tfoot></table>';
                    echo $htl;
                }
                ?>
            </div>  <br>
            <div class="form-group">
                <div align="right" style="margin-right: 10px">
                    <a class="btn btn-default" href="index.php?r=Purchasing/tbplandrugsale/index">Close</a>
                </div>
            </div>
        </div>
    </div> 
</div>




<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$script = <<< JS
$('form#{$model->formName()}').on('beforeSubmit', function(e) 
{
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
        alert('บันทึกรายการแล้ว');
$('#actives').removeAttr("class");
    }else
    {        
        $("#message").html(result);
    }
}).fail(function() 
{
    console.log("server error");
});
return false;
});

JS;
$this->registerJs($script);
?>

<?php
$s = <<< JS
$(document).ready(function() {
   $("#tabledata").DataTable({
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
      });
        $("#tbpcplan2-pcvendorid").click(function(){
          $('#tb_venderrs').modal('show');
        });
      $('#vender_select').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "ajax": {
            "url": "index.php?r=Purchasing/tbplandrugsale/datavender",
            "processing": true,
            "serverSide": true,
            "type": "GET"
        },
    });
});
   $("#vender_select").delegate('tr', 'click', function() { 
       $('#tbpcplan2-pcvendorid').val($(this).children(":first").text());
       $('#vendername').val($(this).children(":first").next().text());  
        $('#tb_venderrs').modal('hide');
    });
        
JS;
$this->registerJs($s);
?>



