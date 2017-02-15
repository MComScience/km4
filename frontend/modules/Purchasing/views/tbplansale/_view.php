<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\TbPcplanstatus;
use yii\jui\DatePicker;
use app\models\TbDepartment;
use yii\widgets\Pjax;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\bootstrap\Modal;
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

$this->title = 'บันทึกสัญญาจะชื้อจะขายสินค้าเวชภัณฑ์มิใช่ยา';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#tbplandrugsale").addClass("active open");
    $("#sale").addClass("active");
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
        <?php yii\widgets\Pjax::begin(['id' => 'branchesGrid']); ?>
        <?php $form = ActiveForm::begin(['id' => $model->formName(), 'layout' => 'horizontal']); ?>
        <div class="well well-small">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail13', 'value' => $auto, 'readonly' => true]) ?>
                    <?= $form->field($model, 'PCPOContactID')->textInput(['maxlength' => true, 'disabled' => 'disabled']) ?>

                    <?=
                    $form->field($model, 'DepartmentID')->dropdownList(
                            ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'), [
                        'id' => 'ddl-province',
                        'prompt' => 'เลือกฝ่าย',
                        'disabled' => 'disabled'
                    ]);
                    ?>
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
                            ]
                    );
                    ?>  
                </div>


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
                            'disabled' => 'disabled',
                            'content' => '<i class="glyphicon glyphicon-phone"></i>'
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
                        ]
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
            <div id="food1">
                <?php
                if ($tbpcplangpu != "") {
                    $htl = '<h4 class="row-title before-success"> รายละเอียดแผนการจัดชื้อ</h4><br><table class="table table-striped table-bordered table-hover dt-responsive nowrap" id="tablenondrug1" width="100%">
		<thead >
                        <tr>
                            <th width="5%" style="text-align:center">
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
                        $htl .= '<td style="text-align:center">' . $no . '</td>';
                        //  $htl .= '<td>' . $result['PCPlanNum'] . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['ItemID'] . '</td>';
                        $htl .= '<td>' . $result['ItemName'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'], 2) . '</td>';
                        $htl .= '<td align="right">' . number_format($result['PCPlanNDQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center">' . $result['DispUnit'] . '</td>';
                        $htl .= '<td align="right">' . number_format($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty'], 2) . '</td>';
                        $htl .= '<td style="text-align:center"></td>';
//                        $htl .= '<td style="text-align:center">' . $result['PRAVALIBLEQTY'] . '</td>';

// $htl .= '<td>' . Yii::$app->componentdate->convertMysqlToThaiDate($result['PCPlanNonDrugItemEffectDate']) . '</td>';
                        // $htl .='<td style="text-align:center"><a href="#" onclick="editlistnondrug(' . $result['ids'] . ')" class="btn btn-info btn-xs edit"> Edit</a> <a href="#" onclick="deletedetailnondrug(' . $result['ids'] . ')" class="btn btn-danger btn-xs delete"> Delete</a></td>';
                        $htl .='</tr>';
                        $no++;
                        $cost = $cost + ($result['PCPlanNDUnitCost'] * $result['PCPlanNDQty']);
                    }
                    $htl .='</tr></tbody><tfoot>
                            <tr>
                                <td colspan="3" style="background-color: #ddd;"></td>
                                <td colspan="3" style="background-color: #ddd;text-align: right;"><strong>รวมเป็นเงินทั้งสิ้น:</strong></td>
                                <td style="text-align: right;background-color: yellow;">
                                    ' . number_format($cost, 2) . '
                                </td>
                               <td colspan="2" style="text-align:center">บาท </td>
                            </tr>
                        </tfoot>
                        </table>
                                                              ';
                    echo $htl;
                }
                ?>
            </div>
            <br>
            <div align="right">
                <a class="btn btn-default" href="index.php?r=Purchasing/tbplansale/index">Close</a>
            </div>

        </div>

    </div>
</div><!--Widget Body-->


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

        alert("บันทึกรายการแล้ว!");
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
$.validate();
JS;
$this->registerJs($script);
//$(\$form).trigger("reset");$.pjax.reload({container:'#branchesGrid'});alert("Saved!");
?>
<?php $this->registerJs('
    function init_click_handlers(){
      $("#activity-create-link").click(function(e) {
        $.get(
            "?r=memp/create",
            function (data)
            {
                $("#modal").find(".modal-body").html(data);
                $(".modal-body").html(data);
                $(".modal-title").html("เพิ่มข้อมูลสมาชิก");
                $("#modal").modal("show");
            }
            );
});
$(".activity-view-link").click(function(e) {
    var fID = $(this).closest("tr").data("key");
    $.get(
        "?r=tbplan/view",
        {
            id: fID
        },
        function (data)
        {
            $("#modal").find(".modal-body").html(data);
            $(".modal-body").html(data);
            $(".modal-title").html("เปิดดูข้อมูลสมาชิก");
            $("#modal").modal("show");
        }
        );
});
$(".activity-update-link").click(function(e) {
    var fID = $(this).closest("tr").data("key");
    $.get(
        "?r=memp/update",
        {
            id: fID
        },
        function (data)
        {
            $("#modal").find(".modal-body").html(data);
            $(".modal-body").html(data);
            $(".modal-title").html("แก้ไขข้อมูลสมาชิก");
            $("#modal").modal("show");
        }
        );
});

}
init_click_handlers(); //first run
$("#branchesGrid").on("pjax:success", function() {
  init_click_handlers(); //reactivate links in grid after pjax update
});'); ?>
<?php
Modal::begin([
    'id' => 'modal1',
    'size' => 'modal-lg',
    'header' => ' <font color="#FFFFFF"><h4 class="modal-title">บันทึกแผนจัดชื้อ</h4></font>',
    'headerOptions' => ['class' => 'bg-azure'],
        //'footer' => '<div class="col-xs-9 col-xs-offset-3">
        //<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        //<a type="submit" onclick="Save();"  class="btn btn-primary" data-dismiss="modal" ><i class="glyphicon glyphicon-floppy-saved"></i>Save</a>
//</div>',
]);
?>


<?php
Modal::end();
?>
<?php
Modal::begin([
    "id" => "tb_venderrs",
    'size' => 'modal-lg',
    'header' => '<font color="#FFFFFF"><h4 class="modal-title">เลือกผู้ขาย</h4></font>',
    'headerOptions' => ['class' => 'bg-azure'],
]);
?>
                <!--<table id="pcplandrugtable" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">-->
<table id="vender_select" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
    <thead>
        <tr style="white-space: nowrap; overflow: hidden; text-overflow:ellipsis;">
            <th>รหัสผู้ขาย</th>
            <th>ชื่อผู้ขาย</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<?php Modal::end(); ?>
<?php
$s = <<< JS

   $('#tablenondrug1').DataTable({
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
                    ],
                });
 
JS;
$this->registerJs($s);
?>
