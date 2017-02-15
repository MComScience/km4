<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\Purchasing\models\VwPcplantypeDrug;
use app\models\TbDepartment;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\widgets\Select2;
use yii\helpers\Url;
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

$style = 'border-top: 1px solid #ddd;white-space: nowrap;background-color: white;text-align:center;';
?>
<?php $this->registerJs('
    $("#Purchasing").addClass("active open");
    $("#Purchasing1").addClass("active open");
    $("#pcplanbydrug").addClass("active");
    
    ');
?>
<style>
    .ui-datepicker{ z-index:1151 !important;}
    /*table#tabledata th{
        white-space: nowrap;
        background-color: white;
    }*/
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
            $form = ActiveForm::begin(['layout' => 'horizontal', 'id' => 'form_main']);
            ?> 
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'PCPlanNum')->textInput(['maxlength' => true, 'id' => 'inputEmail3', 'readonly' => true]) ?>
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
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่ <font color=red>*</font>');
                    ?>
                    <?php
                    echo $form->field($model, 'PCPlanTypeID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [1, 2]])->all(), 'PCPlanTypeID', 'PCPlanType'),
                        'options' => ['placeholder' => 'Select a state ...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    $form->field($model, 'PCPlanTypeID')->dropdownList(
                            ArrayHelper::map(VwPcplantypeDrug::find()->where(['PCPlanTypeID' => [1, 2]])->all(), 'PCPlanTypeID', 'PCPlanType'), [
                        'prompt' => 'SELECT OPTION',
                    ])->label('ประเภทแผนจัดชื้อ <font color=red>*</font>');
                    ?> 

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
                <div class="col-sm-6">
                    <?php
                    echo $form->field($model, 'DepartmentID')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TbDepartment::find()->all(), 'DepartmentID', 'DepartmentDesc'),
                        'language' => 'en',
                        'options' => ['placeholder' => '----- เลือกฝ่าย -----'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label('ฝ่าย <font color=red>*</font>');
                    ?>
                    <?php
                    echo $form->field($model, 'SectionID')->widget(DepDrop::classname(), [
                        'data' => [$section],
                        'options' => ['placeholder' => 'เลือกแผนก ...'],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['tbpcplan-departmentid'],
                            'url' => Url::to(['child-department']),
                            'loadingText' => 'Loading...',
                        ]
                    ])->label('แผนก <font color=red>*</font>');
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
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่เริ่มแผน <font color=red>*</font>')
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
                            'style' => 'background-color: #FFFF99'
                        ],
                    ])->label('วันที่สิ้นสุดแผน <font color=red>*</font>')
                    ?>
                </div>
            </div>
        </div> 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5 class="panel-title">รายละเอียดแผนการจัดชื้อ</h5>
            </div>
            <div class="panel-body">
                <div id="food">
                    <table id="tabledata" class="table table-striped table-bordered dt-responsive norap responsive" width="100%">
                        <thead>
                            <tr>
                                <?= Html::tag('th', Html::encode('#'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('รหัสยาสามัญ'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ขื่อยาสามัญในแผน'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ขื่อยาสามัญมาตรฐาน'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('ราคาต่อหน่วย'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('จำนวน'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('หน่วย'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('รวมเป็นเงิน'), ['style' => $style]) ?>

                                <?= Html::tag('th', Html::encode('Action'), ['style' => $style]) ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $cost = 0; ?>
                            <?php foreach ($tbpcplangpu as $v) : ?>
                                <tr>
                                    <?= Html::tag('td', '', ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['TMTID_GPU']) ? '-' : $v['TMTID_GPU'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['ItemName_plan']) ? '-' : $v['ItemName_plan'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', empty($v['FSN_GPU']) ? '-' : $v['FSN_GPU'], []) ?>

                                    <?= Html::tag('td', empty($v['GPUUnitCost']) ? '-' : number_format($v['GPUUnitCost'], 2), ['style' => 'text-align: right;']) ?>

                                    <?= Html::tag('td', empty($v['GPUOrderQty']) ? '-' : number_format($v['GPUOrderQty'], 2), ['style' => 'text-align: right;']) ?>

                                    <?= Html::tag('td', empty($v['DispUnit']) ? '-' : $v['DispUnit'], ['style' => 'text-align: center;']) ?>

                                    <?= Html::tag('td', number_format($v['GPUUnitCost'] * $v['GPUOrderQty'], 2), ['style' => 'text-align: right;']) ?>

                                    <?= Html::tag('td', Html::a('Edit', false, ['class' => 'btn btn-xs btn-primary', 'onclick' => 'editlistdrugpcplan(' . $v['ids'] . ')']) . ' ' . Html::a('Delete', false, ['class' => 'btn btn-xs btn-danger', 'onclick' => 'deletelistdrug(' . $v['ids'] . ')']), ['style' => 'text-align: center;white-space: nowrap;']) ?>
                                </tr>
                                <?php $cost = $cost + ($v['GPUUnitCost'] * $v['GPUOrderQty']); ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <?= Html::tag('td', 'รวมเป็นเงิน', ['colspan' => '7', 'style' => 'background-color: #f5f5f5;font-size:12pt;text-align:right']) ?>
                                <?= Html::tag('td', number_format($cost, 2), ['style' => 'background-color: #f5f5f5;font-size:12pt;text-align:right']) ?>
                                <?= Html::tag('td', 'บาท', ['style' => 'background-color: #f5f5f5;font-size:12pt;text-align:center']) ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <?php
        Modal::begin([
            "id" => "tb_pcplan",
            'header' => '<h4 class="modal-title">เลือกยาสามัญ</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE,
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
        ]);
        ?>
        <div id="dataread">
        </div>
        <?php Modal::end(); ?>

    </div>
    <div class="form-group">  
        <div align="right">
            <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
            <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Save Draft' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button', ' data-style' => 'expand-left']) ?>
            <a id="actives" class="btn btn-info disabled ladda-button" data-style="expand-left" href="javascript:sendtoapprove()">Send To Apprrove</a>
        </div> 
    </div>  
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<script>
    function showselectdata() {
        if ($('#inputEmail3').val() == "") {
            swal('', "กรุณาใส่ข้อมูลเลขรันก่อน", "warning");
        } else if ($('#tbpcplan-pcplandate').val() == "") {
            swal('', "กรุณาใส่ข้อมูลวันที่ก่อน", "warning");
        } else if ($('#tbpcplan-pcplantypeid').val() == "") {
            swal('', "กรุณาเลือกประเภทแผนจัดชื้อก่อน", "warning");
        } else if ($('#ddl-department').val() == "") {
            swal('', "กรุณาเลือกฝ่ายก่อน", "warning");
        } else if ($('#ddl-section').val() == "") {
            swal('', "กรุณาเลือกแผนกก่อน", "warning");
        } else if ($('#tbpcplan-pcplanbegindate').val() == "") {
            swal('', "กรุณาเลือกวันที่เริ่มแผนก่อน", "warning");
        } else if ($('#tbpcplan-pcplanenddate').val() == "") {
            swal('', "กรุณาเลือกวันที่สิ้นสุดแผนก่อน", "warning");
        } else {
            run_waitMe(2);
            $.ajax({
                url: "form_main",
                type: "post",
                data: $('#form_main').serialize(),
                success: function (result) {
                }
            });

            $.ajax({
                url: "datapcplanbydrug",
                type: "post",
                success: function (d) {
                    $('#dataread').html(d);
                    $('#tb_pcplan').modal('show');
                    $("#pcplanbydrugtable").DataTable({
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
                    $('#tb_pcplan').modal('show');
                    waitMe_hide(2);
                }
            });
        }
    }
    function saveprdetail() {
        if ($("#gpuunitCost").val() == "" || $("#gpuunitCost").val() < 0.01) {
            swal('', "กรุณากรอกข้อมูลลงช่องราคาต่อหน่วย", "warning");
        } else if ($("#gpuorderqty").val() == "" || $("#gpuorderqty").val() < 1) {
            swal('', "กรุณากรอกข้อมูลลงช่องจำนวน", "warning");
        } else {
            run_waitMe(1);

            $.ajax({
                url: "savedata",
                type: "post",
                data: $('#formtmtgpu').serialize(),
                dataType: 'json',
                success: function (d) {
                    $("#ids").val("");
                    $("input[name=tmtgpu]").val("");
                    //$('#food').html(d.htn);
                    $('#tb_pcplan').modal('hide');
                    $('#mmm').modal('hide');
                    $('#formtmtgpu').trigger("reset");
                    GettableDetails();
                    /*$("#tabledata").DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        "pageLength": 5,
                        responsive: true,
                        "language": {
                            "search": "Search : _INPUT_ ",
                            "lengthMenu": " _MENU_ ",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ"
                        },
                        "aLengthMenu": [
                            [5, 10, 15, 20, 100, -1],
                            [5, 10, 15, 20, 100, "All"]
                        ]
                    });*/
                    swal("", d.ff, "success");
                    waitMe_hide(1);
                }
            });
        }
    }
    function myFunpcplanbydrug(id) {
        var prnums = $("#inputEmail3").val();
        run_waitMe(1);
        $.ajax({
            url: "getdata",
            type: "post",
            data: {id: id, prnums: prnums},
            dataType: 'json',
            success: function (result) {
                if (result.TMTID_GPU != null) {
                    $('#detail_model_body').html(result.data);
                    $("input[name=tmtgpu]").val(result.TMTID_GPU);
                    $("#fsngpu").val(result.FSN_GPU);
                    $("#noii").val(result.itemDispUnit);
                    $("#prnum").val($('#inputEmail3').val());
                    $('#mmm').modal('show');
                    $('#effectivedate').val($('#tbpcplan-pcplanbegindate').val());

                    waitMe_hide(1);
                } else {
                    swal("", result.ale, "warning");
                    waitMe_hide(1);
                }
            }
        });
    }
    function sendtoapprove() {
        swal({
            title: "ยืนยันการส่งอนุมัติ ?",
            text: "",
            type: "warning",
            confirmButtonColor: "#53a93f",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var id = $("#inputEmail3").val();
                        var l = $('.ladda-button').ladda();
                        run_waitMe(2);
                        $.ajax({
                            url: "send-to-approve",
                            type: "post",
                            data: {id: id},
                            dataType: 'json',
                            success: function (result) {
                                if (result.status == '2') {
                                    $('#status_').val('WaitAprrove');

                                }
                                setTimeout("location.href = '/km4/Purchasing/plan-gpu/index';", 50);
                            }
                        });
                    }
                }
        );
    }

    function deletelistdrug(ids) {
        swal({
            title: "ยืนยันการลบ",
            text: "",
            type: "warning",
            confirmButtonColor: "#dd6b55",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        var prnums = $("#inputEmail3").val();
                        $.ajax({
                            url: "deletelistdrug",
                            type: "post",
                            data: {ids: ids, prnums: prnums},
                            dataType: 'json',
                            success: function (result) {
                                $('#formtmtgpu').trigger("reset");
                                $("#ids").val("");
                                $("input[name=tmtgpu]").val("");
                                $('#food').html(result.htn);
                                GettableDetails();
                            }
                        });
                    }
                });
    }
    function crear() {
        $("#gpuunitCost").val("0");
        $("#gpuorderqty").val("0");
        $("#gpuextended").val("0");
    }
    function cleartable() {
        $('#formtmtgpu').trigger("reset");
    }
    function editlistdrugpcplan(id) {
        run_waitMe(2);
        $.ajax({
            url: "editlistdrug",
            type: "post",
            data: {id: id},
            dataType: 'json',
            success: function (r) {
                $('#detail_model_body').html(r.data);
                $("#ids").val(r.ids);
                $("input[name=tmtgpu]").val(r.TMTID_GPU);
                $("#fsngpu").val(r.fsngpu);
                $("#gpuunitCost").val(r.GPUUnitCost);
                $("#gpuorderqty").val(r.GPUOrderQty);
                $("#gpuextended").val(r.GPUExtendedCost);
                $("#effectivedate").val(r.PCPlanGPUItemEffectDate);
                $("#pclanitemstatus").val(r.PCPlanGPUItemStatusID);
                $("#noii").val(r.noii);
                $("#prnum").val($('#inputEmail3').val());
                $('#mmm').modal('show');
                waitMe_hide(2);

            }
        });
    }
    function run_waitMe(type) {
        if (type == '1') {
            var idnaclass = '.modal-content';
        } else if (type == '2') {
            var idnaclass = '.main-container';
        }
        $(idnaclass).waitMe({
            effect: 'ios',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    }
    function waitMe_hide(type) {
        if (type == '1') {
            $('.modal-content').removeClass('waitMe_container');
            $('.waitMe').html('');
        } else if (type == '2') {
            $('.main-container').removeClass('waitMe_container');
        }
    }

</script>
<?php
Modal::begin([
    "id" => "mmm",
    'size' => 'modal-lg modal-primary',
    'header' => '<h4 class="modal-title">บันทึกแผนจัดชื้อ</h4>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => FALSE,
]);
?>
<div id="detail_model_body">

</div>

<?php Modal::end(); ?>
<?php
$script = <<< JS
      
$('#form_main').on('beforeSubmit', function(e) 
{
     run_waitMe(2);
 var \$form = $(this);
 $.post(
    \$form.attr("action"), // serialize Yii2 form
    \$form.serialize()
    )
.done(function(result) {
    if(result == 1)
    {
        swal("Save Complete!", "", "success");
        $('#actives').removeClass("disabled");
        waitMe_hide(2);
    }else
    {        
        $("#message").html(result);
        waitMe_hide(2);
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
    $(document).ready(function () {
        SetDatatableDetails();
    });
JS;
$this->registerJs($s);
?>
<script>
    function GettableDetails() {
        var PCPlanNum = $('#inputEmail3').val();
        $('.page-content').waitMe({
            effect: 'ios',
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
        $.ajax({
            url: 'gettable-details',
            type: 'POST',
            data: {PCPlanNum: PCPlanNum},
            dataType: 'json',
            success: function (data) {
                $('#food').html(data);
                SetDatatableDetails();
                $('.page-content').waitMe('hide');
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
                $('.page-content').waitMe('hide');
            },
        });
    }

    function SetDatatableDetails() {
        var t = $("#tabledata").DataTable({
            "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
            "pageLength": 5,
            responsive: true,
            "language": {
                "lengthMenu": " _MENU_ ",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                "search": "ค้นหา : _INPUT_ " + '<a href="javascript:showselectdata()" class="btn btn-success ladda-button"  data-style= "expand-left"><i class="glyphicon glyphicon-plus"></i> เพิ่มรายการยาสามัญ</a>'
            },
            "aLengthMenu": [
                [5, 10, 15, 20, 100, -1],
                [5, 10, 15, 20, 100, "All"]
            ],
            "columns": [
                {"bSortable": false},
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {"bSortable": false}
            ]
        });
    }
</script>