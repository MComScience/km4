<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
use frontend\assets\WaitMeAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
?>
<style type="text/css">
    table#table_tb_drugadminstration thead tr th {
        white-space: nowrap;
    }
    table#table_tb_drugprecaution thead tr th{
        white-space: nowrap;
    }
    table#table_tb_drugindication thead tr th{
        white-space: nowrap;
    }
</style>
<?php if ($edit == 'yes') { ?>
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            บันทึกรายการสินค้ายา
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane in active">
                        <div class="well">
                            <form class="form-horizontal kv-form-horizontal">
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label no-padding-right"></label>
                                    <div class="col-xs-6 col-sm-3">
                                        <a class="btn btn-success" id="getdatatpu">เลือกยาการค้า</a>
                                    </div>       
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label no-padding-right">รหัสยาการค้า</label>
                                    <div class="col-xs-6 col-sm-3">
                                        <input id="TMTID_TPU" readonly="" type="text" class="form-control"  placeholder="" style="background-color: white" value="<?php echo $querydatatpu['TMTID_TPU'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label no-padding-right">ชื่อยาการค้า</label>
                                    <div class="col-xs-6 col-sm-3">
                                        <input id="TradeName_TMT" readonly="" type="text" class="form-control"  placeholder="" style="background-color: white" value="<?php echo $querydatatpu['TradeName_TMT'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label no-padding-right">Active Ingredient</label>
                                    <div class="col-xs-6 col-sm-6">
                                        <textarea id="ActiveIngredient" readonly="" rows="3" type="text" class="form-control"  placeholder="" style="background-color: white"><?php echo $querydatatpu['ActiveIngredient_TMT'] ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label  class="col-sm-2 control-label no-padding-right">รายละเอียดยา</label>
                                    <div class="col-xs-6 col-sm-6">
                                        <textarea id="FSN_TMT" readonly="" rows="3" type="text" class="form-control"  placeholder="" style="background-color: white"><?php echo $querydatatpu['FSN_TMT'] ?></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        Generic Product
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-item-form">
                            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'fromupdategpu']); ?>
                            <?= $form->errorSummary($tbgp) ?>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'TMTID_GPU', ['label' => 'รหัสยาสามัญ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($tbgpu, 'TMTID_GPU', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true,]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'FSN_GPU', ['label' => 'รายละเอียดยาสามัญ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($tbgpu, 'FSN_GPU', ['showLabels' => false])->textarea(['style' => 'background-color: white', 'rows' => 3, 'readonly' => true,]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">ชื่อบนฉลากยา<font color="red"> *</font></label>
                                        <div class="col-sm-7">
                                            <input class="form-control" style="background-color: #FFFF99" id="fsndruglabel" name="FNS_GPU_label" value="<?php echo $tbgpu['FNS_GPU_label'] ?>"/>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgp, 'Class_GP', ['label' => 'กลุ่มยา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgp, 'Class_GP', ['showLabels' => false])->dropdownList(
                                                    yii\helpers\ArrayHelper::map(app\models\TbDrugclass::find()->all(), 'DrugClassID', 'DrugClass'), [
                                                'id' => 'ddl-province',
                                                'prompt' => 'Select Option'
                                            ])->label();
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgp, 'SubClass_GP', ['label' => 'กลุ่มยาย่อย', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgp, 'SubClass_GP', ['showLabels' => false])->widget(\kartik\widgets\DepDrop::classname(), [
                                                'options' => ['id' => 'ddl-amphur'],
                                                'data' => [$subclassgp],
                                                'pluginOptions' => [
                                                    'depends' => ['ddl-province'],
                                                    'placeholder' => 'Select Option',
                                                    'url' => Url::to(['/Inventory/additem/get-subclass'])
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgp, 'DrugGroup_GP', ['label' => 'บัญชียา' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgp, 'DrugGroup_GP', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => yii\helpers\ArrayHelper::map(app\models\TbDruggroup::find()->all(), 'druggroupID', 'druggroup'),
                                                'pluginOptions' => [
                                                    'placeholder' => 'Select Option',
                                                    'allowClear' => true
                                                ],
                                            ])->label();
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgp, 'ISED_CatID', ['label' => 'บัญชียาหลักแห่งชาติ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgp, 'ISED_CatID', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => yii\helpers\ArrayHelper::map(app\models\TbIsed::find()->all(), 'ISEDID', 'ISED'),
                                                'pluginOptions' => [
                                                    'placeholder' => 'Select Option',
                                                    'allowClear' => true
                                                ],
                                            ])->label();
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgp, 'PregCatID_GP', ['label' => 'ระดับผลการใช้ยาหญิงมีครรค์', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgp, 'PregCatID_GP', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => yii\helpers\ArrayHelper::map(app\models\TbPregcat::find()->all(), 'PregCatID', 'PregCat'),
                                                'pluginOptions' => [
                                                    'placeholder' => 'Select Option',
                                                    'allowClear' => true
                                                ],
                                            ])->label();
                                            ?>
                                        </div>
                                    </div>
                                    <?php /*
                                      <div class="form-group">
                                      <?= Html::activeLabel($tbgp, 'HighDrugAlertType', ['label' => 'High Drug Alert', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                      <div class="col-sm-7">
                                      <?=
                                      $form->field($tbgp, 'HighDrugAlertType', ['showLabels' => false])->radioList($tbgp->getHighDrugAlertType(), ['inline' => true])
                                      ->label()
                                      ?>
                                      </div>
                                      </div>

                                     * 
                                     */ ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">High Drug Alert<font color="red"> *</font></label>                                        
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <div class='col-md-12'>
                                                    <input type="hidden" name="HighDrugAlertType" value="">
                                                    <div id="tbgenericproductgp-highdrugalerttype">
                                                        <label class="radio-inline"><input type="radio" name="HighDrugAlertType" value="1" id="HighDrugAlertType1"> <span class="text">Yes</span></label>
                                                        <label class="radio-inline"><input type="radio" name="HighDrugAlertType" value="0" id="HighDrugAlertType0"> <span class="text">No</span></label>
                                                    </div>
                                                </div>
                                            </div>                                       
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'Dosageform_GPU', ['label' => 'รูปแบบยา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($tbgpu, 'Dosageform_GPU', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'StrNum_GPU', ['label' => 'ความแรงยา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($tbgpu, 'StrNum_GPU', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'ContVal_GPU', ['label' => 'ขนาดบรรจุ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($tbgpu, 'ContVal_GPU', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'CoutUnit_GPU', ['label' => 'หน่วยของขนาดบรรจุ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgpu, 'CoutUnit_GPU', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: white',
                                                'value' => $queryview['ContUnit'],
                                                'readonly' => true
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($tbgpu, 'DispUnit_GPU', ['label' => 'หน่วยการจ่าย', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($tbgpu, 'DispUnit_GPU', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: white',
                                                'value' => $queryview['DispUnit'],
                                                'readonly' => true
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <?= $form->field($tbgp, 'HighDrugAlertType', ['showLabels' => false])->hiddenInput(['style' => 'background-color: white', 'readonly' => true,]); ?>
                                </div>
                            </div><!--/End Row -->
                            <hr>
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-xs-6">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs" id="myTab">
                                            <li class="active">
                                                <a data-toggle="tab" href="#profile">
                                                    ข้อมูลการให้ยา
                                                </a>
                                            </li>

                                            <li class="tab-success">
                                                <a data-toggle="tab" href="#dropdown1">
                                                    คำเตือนการใช้ยา
                                                </a>
                                            </li>

                                            <li class="tab-success">
                                                <a data-toggle="tab" href="#home1">
                                                    สรรพคุณทางยา
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div id="profile" class="tab-pane in active">
                                                <a class="btn btn-success" id="บันทึกข้อมูลการให้ยา"><i class="glyphicon glyphicon-plus"></i>บันทึกข้อมูลการให้ยา</a>
                                                <div id="query_drugadminstration"></div>
                                            </div>

                                            <div id="dropdown1" class="tab-pane">
                                                <a class="btn btn-success" id="บันทึกข้อมูลคำเตือนการใช้ยา"><i class="glyphicon glyphicon-plus"></i>บันทึกข้อมูลคำเตือนการใช้ยา</a>
                                                <div id="query_drugprecaution"></div>
                                            </div>

                                            <div id="home1" class="tab-pane">
                                                <a class="btn btn-success" id="บันทึกสรรพคุณทางยา"><i class="glyphicon glyphicon-plus"></i>บันทึกสรรพคุณทางยา</a>
                                                <div id="query_drugindication"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="horizontal-space"></div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-xs-6">
                                    <div class="invoice-container">
                                        <div class="row">
                                            <div class="panel panel-success">
                                                <div class="panel-heading bg-success" style="text-align: center">
                                                    <h5 class="white"><?= Html::encode('โรงพยาบาลมะเร็งอุดรธานี') ?></h5>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <a class="btn btn-block btn-default disabled">HN</a>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <a class="btn btn-block btn-default disabled">ชื่อ-นามสกุล</a>
                                                        </div>
                                                    </div>
                                                    <p></p>
                                                    <div class="row">
                                                        <div class="col-xs-10">
                                                            <a class="btn btn-block  disabled" style="background-color: #ddd"><div id="druglabel" ></div></a>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <a class="btn btn-block btn-default disabled">จำนวน</a>
                                                        </div>
                                                    </div>
                                                    <p></p>

                                                    <ul>
                                                        <li>
                                                            <a class="btn btn-block disabled" style="text-align: left;background-color: #ddd"><div id="drugadminlabel"></div></a>
                                                        </li>
                                                        <p></p>
                                                        <li>
                                                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #ddd"><div id="druglabel1"></div></a>
                                                        </li>
                                                        <p></p>
                                                        <li>
                                                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #ddd"><div id="druglabel2"></div></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>                
                                        </div> <!-- / end client details section -->
                                    </div>
                                </div>
                            </div>
                        </div><!--/End Class tb item form -->
                    </div><!--/Well -->
                    <div class="form-group" style="text-align: right">
                        <?php if ($edit == 'yes') { ?>
                            <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                        <?php } ?>

                        <?php if ($edit == 'no' && $itemid == '') { ?>
                            <?= Html::a('Close', ['managegpu'], ['class' => 'btn btn-default']) ?>
                        <?php } ?>

                        <?= Html::submitButton($tbgpu->isNewRecord ? Yii::t('app', 'บันทึกข้อมูลยาสามัญ') : Yii::t('app', 'บันทึกข้อมูลยาสามัญ'), ['class' => $tbgpu->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-primary ladda-button','data-style' => 'expand-left']) ?>
                        <?php if ($edit == 'yes') { ?>
                            <a class="btn btn-info" id="createadditem">สร้างรหัสสินค้าใหม่</a>
                        <?php } ?>

                        <?php if ($itemid != null) { ?>
                            <?= Html::a('แก้ไขรายการสินค้า', ['createitem', 'itemid' => $itemid, 'true' => 'yes'], ['class' => 'btn btn-default']) ?>
                        <?php } ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-space"></div>

</div>
<!-- /Modal TPU -->
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'getdatagpumodal',
    'header' => '<h4 class="modal-title">เลือกยาการค้า</h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
]);
?>
<div id="datatpu"></div>
<div id="datagpu">           
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
<?php \yii\bootstrap\Modal::end(); ?>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modaladd_drugin',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
]);
?>
<div id="from_drugin"></div>
<?php \yii\bootstrap\Modal::end(); ?>

<?php
$script = <<< JS
/* Check HighDrugAlertType   */
$(document).ready(function () {
        $('#createadditem').addClass("disabled", "disabled");
        var highdrug = $("#tbgenericproductgp-highdrugalerttype").val();
//        var fsn_gpu = $("#tbgenericproductusegpu-fsn_gpu").val();
//        $("#fsndruglabel").val(fsn_gpu);
        if(highdrug == 0){
            document.getElementById("HighDrugAlertType0").checked = true;
        }else if(highdrug == 1){
            document.getElementById("HighDrugAlertType1").checked = true;
        }
        GettableDrugindication();/* เรียกใช้ function */
        GettableDrugadmins();/* เรียกใช้ function */
        GettableDrugpre();/* เรียกใช้ function */
        Getdruglabel();/* เรียกใช้ function */
});
/* query ข้อความฉลากยา */
function Getdruglabel() {
        var gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
        run_waitMelabel();
        $.ajax({
            url: "getdruglabel",
            type: "post",
            data: {gpu: gpu},
            dataType: "JSON",
            success: function (result) {
                $('#druglabel').html(result.label);
                $('#drugadminlabel').html(result.drugadmin);
                $('#druglabel1').html(result.druglabel1);
                $('#druglabel2').html(result.druglabel2);
                $('.panel-body').waitMe('hide');
            }
        });
    }
/*   Query สรรพคุณทางยา  */
function GettableDrugindication() {
    var gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
    $.ajax({
        url: "gettabledrugin",
        type: "post",
        data: {gpu: gpu},
        dataType: "JSON",
        success: function (result) {
            $("#query_drugindication").html(result.table);
            $('#table_tb_drugindication').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
}
/*   Query Table การให้ยา     */
function GettableDrugadmins() {
    var gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
    $.ajax({
        url: "gettabledrugadmins",
        type: "post",
        data: {gpu: gpu},
        dataType: "JSON",
        success: function (result) {
            $("#query_drugadminstration").html(result.table);
            $('#table_tb_drugadminstration').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
} 
/*   Query Table คำเตือนการใช้ยา     */
function GettableDrugpre() {
    var gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
    $.ajax({
        url: "gettabledrugpre",
        type: "post",
        data: {gpu: gpu},
        dataType: "JSON",
        success: function (result) {
            $("#query_drugprecaution").html(result.table);
            $('#table_tb_drugprecaution').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
}

/* Loading */
function run_waitMe(effect) {
        $('.modal-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
function run_waitMelabel(effect) {
        $('.panel-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'ios',//roundBounce
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}
/* Save GPU */
$('#fromupdategpu').on('beforeSubmit', function(e)
    {
    var l = $( '.ladda-button' ).ladda();
    l.ladda( 'start' );
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'success')
            {
                Getdruglabel();/* เรียกใช้ function */
                l.ladda( 'stop' );
                swal("Save Complete!", "", "success");
                $('#createadditem').removeClass("disabled", "disabled");
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
$(function() {
/* Load data TPU to Modal */
$('#getdatatpu').click(function (e) {
    var Check = $("#datatpu").val();
    if (Check != "1") {
        $('#getdatagpumodal').modal('show');
        run_waitMe();
        $.ajax({
            url: 'getdatagpu',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('.modal-body').waitMe('hide');
                $('#datagpu').html(data);
                $("#datatpu").val('1');
                $('.modal-title').html('เลือกยาการค้า');
                $('#getdatagputable').DataTable({
                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                    "pageLength": 5,
                    responsive: true,
                    "language": {
                        "lengthMenu": "_MENU_",
                        "infoEmpty": "No records available",
                        "search": "_INPUT_ ",
                        "sSearchPlaceholder": "ค้นหาข้อมูล",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    },
                    "aLengthMenu": [
                        [5, 15, 20, 100, -1],
                        [5, 15, 20, 100, "All"]
                    ],
                });
            }
        });
    } else {
        $('#getdatagpumodal').modal('show');
    }
});
/* บันทึกสรรพคุณทางยา */
$('#บันทึกสรรพคุณทางยา').click(function (e) {
        var tmtid_gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
        var fsn_gpu = $("#tbgenericproductusegpu-fsn_gpu").val();
        var id = '';
        LoadingClass();
        $.get(
                'add-drugin',
                {
                     tmtid_gpu:tmtid_gpu,fsn_gpu:fsn_gpu,id:id
                },
                function (data)
                {
                    $("#modaladd_drugin").find(".modal-body").html(data);
                    $('#from_drugin').html(data);
                    $(".modal-title").html("บันทึกสรรพคุณทางยา");
                    $('.page-content').waitMe('hide');
                    $('#modaladd_drugin').modal('show');
                    $('#form_drugindication').trigger('reset');
                }
        );
    });
/* บันทึกข้อมูลการให้ยา */
    $('#บันทึกข้อมูลการให้ยา').click(function (e) {
        var tmtid_gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
        var fsn_gpu = $("#tbgenericproductusegpu-fsn_gpu").val();
        var id = '';
        LoadingClass();
        $.get(
                'adddrugadmin',
                {
                    tmtid_gpu: tmtid_gpu, fsn_gpu: fsn_gpu, id: id
                },
        function (data)
        {
            $("#modaladd_drugin").find(".modal-body").html(data);
            $('#from_drugin').html(data);
            $(".modal-title").html("บันทึกข้อมูลการให้ยา");
            $('.page-content').waitMe('hide');
            $('#modaladd_drugin').modal('show');
            $('#form_drugindication').trigger('reset');
        }
        );
    });
/* บันทึกข้อมูลคำเตือนการใช้ยา */
    $('#บันทึกข้อมูลคำเตือนการใช้ยา').click(function (e) {
        var tmtid_gpu = $("#tbgenericproductusegpu-tmtid_gpu").val();
        var fsn_gpu = $("#tbgenericproductusegpu-fsn_gpu").val();
        var id = '';
        LoadingClass();
        $.get(
                'adddrugpre',
                {
                    tmtid_gpu: tmtid_gpu, fsn_gpu: fsn_gpu, id: id
                },
        function (data)
        {
            $("#modaladd_drugin").find(".modal-body").html(data);
            $('#from_drugin').html(data);
            $(".modal-title").html("บันทึกข้อมูลคำเตือนการใช้ยา");
            $('.page-content').waitMe('hide');
            $('#modaladd_drugin').modal('show');
            //$('#form_drugindication').trigger('reset');
        }
        );
    });
/*  สร้างรหัสสินค้า    */
$('#createadditem').click(function (e) {
    var tpu = $("#TMTID_TPU").val();
    if (tpu == "") {
        swal({
            title: "",
            text: "กรุณาเลือกยาการค้า",
            type: "warning"
        });
    } else {
        $.post(
                'create-itemnew',
                {
                    tpu: tpu
                },
        function (data)
        {

        }
        );
    }
});

});


JS;
$this->registerJs($script, \yii\web\View::POS_END,'create');
?>
<script>
    function GetDetailTPU(id) {
        $.ajax({
            url: "getdetailtpu",
            type: "post",
            data: {id: id},
            dataType: "JSON",
            success: function (result) {
                $("#TMTID_TPU").val(result.TMTID_TPU);
                $("#TradeName_TMT").val(result.TradeName_TMT);
                $("#ActiveIngredient").val(result.ActiveIngredient_TMT);
                $("#FSN_TMT").val(result.FSN_TMT);
                $("#tbgenericproductusegpu-tmtid_gpu").val(result.TMTID_GPU);
                $("#tbgenericproductusegpu-fsn_gpu").val(result.FSN_GPU);
                $("#fsndruglabel").val(result.FNS_GPU_label);
                $("#ddl-province").val(result.DrugClassID).trigger("change");
                $("#tbgenericproductgp-druggroup_gp").val(result.druggroupID).trigger("change");
                $("#tbgenericproductgp-ised_catid").val(result.ISEDID).trigger("change");
                $("#tbgenericproductgp-pregcatid_gp").val(result.PregCatID).trigger("change");
                if (result.HighDrugAlertType == 0) {
                    document.getElementById("HighDrugAlertType0").checked = true;
                } else {
                    document.getElementById("HighDrugAlertType1").checked = true;
                }
                $("#tbgenericproductusegpu-dosageform_gpu").val(result.Dosageform_TMT);
                $("#tbgenericproductusegpu-strnum_gpu").val(result.StrNum_TMT);
                $("#tbgenericproductusegpu-contval_gpu").val(result.Contval_TMT);
                $("#tbgenericproductusegpu-coutunit_gpu").val(result.Contunit_TMT);
                $("#tbgenericproductusegpu-dispunit_gpu").val(result.DispUnit_TMT);
                $('#getdatagpumodal').modal('hide');
                /* query สรรพคุณทางยา */
                GettableDrugindication();
                /* query การให้ยา */
                GettableDrugadmins();
                /* query คำเตือนการให้ยา */
                GettableDrugpre();
                Getdruglabel();/* เรียกใช้ function */
            }
        });
    }



    /* Edit สรรพคุณทางยา */
    function UpdateDrugin(id) {
    	LoadingClass();
        $.get(
                "add-drugin",
                {
                    id: id,
                },
                function (data)
                {
                    $("#modaladd_drugin").find(".modal-body").html(data);
                    $("#from_drugin").html(data);
                    $(".modal-title").html("แก้ไขข้อมูล");
                    $('.page-content').waitMe('hide');
                    $("#modaladd_drugin").modal("show");
                }
        );
    }
    /* Delete สรรพคุณทางยา */
    function Deletedrugin(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'delete-drugin',
                                {
                                    id: id
                                },
                        function (data)
                        {
                            GettableDrugindication();
                        }
                        );
                    }
                });
    }
    /* Edit การใช้ยา */
    function UpdateDrugadmins(id) {
    	LoadingClass();
        $.get(
                "adddrugadmin",
                {
                    id: id,
                },
                function (data)
                {
                    $("#modaladd_drugin").find(".modal-body").html(data);
                    $("#from_drugin").html(data);
                    $(".modal-title").html("แก้ไขข้อมูล");
                    $('.page-content').waitMe('hide');
                    $("#modaladd_drugin").modal("show");
                }
        );
    }
    /* Delete การใให้ยา */
    function DeleteDrugadmins(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'deletedrugadmin',
                                {
                                    id: id
                                },
                        function (data)
                        {
                            GettableDrugadmins();
                        }
                        );
                    }
                });
    }
    /* Edit คำเตือนการใช้ยา */
    function UpdateDrugpre(id) {
    	LoadingClass();
        $.get(
                "adddrugpre",
                {
                    id: id,
                },
                function (data)
                {
                    $("#modaladd_drugin").find(".modal-body").html(data);
                    $("#from_drugin").html(data);
                    $(".modal-title").html("แก้ไขข้อมูล");
                    $('.page-content').waitMe('hide');
                    $("#modaladd_drugin").modal("show");
                }
        );
    }
    /* Delete คำเตือนการใช้ยา */
    function DeleteDrugpre(id) {
        swal({
            title: "ยืนยันการลบ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: true,
            closeOnCancel: true,
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.post(
                                'deletedrugpre',
                                {
                                    id: id
                                },
                        function (data)
                        {
                            GettableDrugpre();
                        }
                        );
                    }
                });
    }

</script>
