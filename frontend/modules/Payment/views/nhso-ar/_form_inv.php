<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
$header_style = ['style' => 'text-align:center;color:#000000;'];
echo $this->render('/config/Asset_Js.php');
$this->title = 'บันทึกหนังสือเรียกเก็บ';
$this->params['breadcrumbs'][] = ['label' => 'สร้างหนังสือเรียกเก็บ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="loading_inv" class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="tabbable">
           <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('บันทึกหนังสือเรียกเก็บ') ?>
                    </a>
                </li>
            </ul> 
            <div class="tab-content bg-white">
        <div class="well">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => '_form_inv']); ?>
            
                <div class="form-group">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">หนังสือเรียกเก็บเลขที่</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'nhso_inv_num', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            'readonly' => true,
                            'style' => 'white;',
                            'value' => !empty($model['nhso_inv_num']) ? $model['nhso_inv_num'] : '',
                        ])
                        ?>
                        <?php /*
                        $form->field($model, 'nhso_inv_id', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            'readonly' => true,
                            'style' => 'background-color:white;',
                            'value' => !empty($model['nhso_inv_id']) ? $model['nhso_inv_id'] : '',
                        ])
                        */?>
                    </div>
                    
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">หนังสือออกเลขที่</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'nhso_inv_hdoc', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            //'readonly' => true,
                            'style' => 'background-color:#FFFF99;',
                            'value' => !empty($model['nhso_inv_hdoc']) ? $model['nhso_inv_hdoc'] : '',
                        ])
                        ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">วันที่</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                            $form->field($model, 'nhso_inv_date', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                'language' => 'th',
                                'dateFormat' => 'dd/MM/yyyy',
                                'clientOptions' => [
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                ],
                                'options' => [
                                    'class' => 'form-control',
                                    'style' => 'background-color: #FFFF99',
                                ],
                            ])
                       ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">ประเภท</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?=
                        $form->field($model, 'doc_type', ['showLabels' => false])->textInput([
                            'maxlength' => true,
                            'readonly' => true,
                            'style' => 'background-color:white;',
                            'value' => !empty($model['doc_type']) ? $model['doc_type'] : '',
                        ])
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">รพ.ต้นสังกัด</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'hmain', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;',
                                'value' => !empty($model['hmain']) ? $model->ar_name->ar_name : '',
                            ])
                            ?>
                        </div>
                    <label class="col-lg-2 col-md-2 col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">เรียน</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'nhso_inv_attnname', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                //'readonly' => true,
                                'style' => 'background-color:#FFFF99;',
                                'value' => !empty($model['nhso_inv_attnname']) ? $model['nhso_inv_attnname'] : 'ผู้อำนวยการ '.$model->ar_name->ar_name,

                            ])
                            ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">กำหนดชำระ(วัน)</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'nhso_inv_crdays', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                //'readonly' => true,
                                'style' => 'background-color:#FFFF99;',
                                'value' => !empty($model['nhso_inv_crdays']) ? $model['nhso_inv_crdays'] : '30',
                            ])
                            ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">ยอดเรียกเก็บ</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?=
                            $form->field($model, 'nhso_inv_cramt', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white;',
                                'value' => !empty($model['nhso_inv_cramt']) ? number_format($model['nhso_inv_cramt'],2) : '0.00',
                            ])
                            ?>
                    </div>
                    <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-right">วิธีชำระเงิน</label>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-top: 5px">
                            <label><input name="cash" id="cash" type="checkbox" /><span class="text"></span>&nbsp;เช็คเงินสด</label><br>
                            <label><input name="tranfer" id="tranfer" type="checkbox" /><span class="text"></span>&nbsp;โอนเงิน</label>
                            <?=
                            $form->field($model, 'nhso_inv_bank_id', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                'data' => yii\helpers\ArrayHelper::map(app\modules\Payment\models\VwFiCreditcardname::find()->all(), 'bank_id', 'creditcard_issueby'),
                                'language' => 'en',
                                'options' => ['placeholder' => 'Select Option'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ])
                            ?>
                    </div>
                    </div>
                    <br><br>
                 <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h5 class="row-title before-success">รายละเอียดหนังสือเรียกเก็บ</h5>
                    <br>
                    <?=
                     kartik\grid\GridView::widget([
                     'dataProvider' => $dataProvider,
                     'bootstrap' => true,
                     'responsiveWrap' => FALSE,
                     'responsive' => true,
                     'showPageSummary' => true,
                     'hover' => true,
                     'pjax' => true,
                     'striped' => true,
                     'condensed' => true,
                     'toggleData' => false,
                     'pageSummaryRowOptions' => ['class' => 'default', 'id' => 'setting_summary_row'],
                     'layout' => "\n{items}\n{pager}",
                     'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                     //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                     'columns' => [
                         [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => 'ลำดับ',
                                'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'REP',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return (!empty($model->rep)? $model->rep:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'Type',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                   return (!empty($model->doc_type)? $model->doc_type:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'HN',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                     return (!empty($model->pt_hospital_number)? $model->pt_hospital_number:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'PID',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    return (!empty($model->pid)? $model->pid:'-');
                                }
                         ],
                         [
                                'headerOptions' => $header_style,
                                'header' => 'ชื่อ-สกุล',
                                'hAlign' => GridView::ALIGN_LEFT,
                                'value' => function ($model) {
                                    return (!empty($model->pt_name)? $model->pt_name:'-');
                                }
                         ],
                         [
                            'headerOptions' => $header_style,
                            'header' => 'วันเข้ารักษา',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_registry_datetime;
                            }
                         ],
                         [
                            'headerOptions' => $header_style,
                            'header' => 'วันจำหน่าย',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return $model->pt_discharge_datetime;
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชดเชยสุทธิสปสช.',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->fpnhso_piad)? $model->fpnhso_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชดเชยสุทธิจ้นสังกัด',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'format' => ['decimal',2],
                            'value' => function ($model) {
                                return (!empty($model->affiliation_piad)? $model->affiliation_piad:'0');
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'สถานะ',
                            'attribute' => 'itemstatus',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                return (!empty($model->itemstatus)? $model->itemstatus:'-');
                            }
                        ],
                    ],
                     
                ])
                ?>
                </div>  
                </div>
                <br>     
                 <div class="form-group" style="text-align: right;margin-right: 3px">
                    <?= Html::a('Close',['index'],['class'=>'btn btn-default']) ?>
                    <?= Html::a('Draft',false,['class'=>'btn btn-success','onclick'=>"chk_empty(chk_bank,fn_draft);"]) ?>
                    <?= Html::a('Save',false,['class'=>'btn btn-success','onclick'=>"chk_empty(chk_bank,fn_save);"]) ?>
                    <?= Html::a('พิมพ์หนังสือเรียกเก็บ',['/Report/report-inventory/excess','data'=>$model->nhso_inv_id],['class'=>'btn btn-info','id'=>'btn_print_inv','target'=>"_blank",'data-pjax'=>0]) ?>
                    <?= Html::a('พิมพ์เอกสารแนบ REP',['/Report/report-inventory/excess2','data'=>$model->nhso_inv_id],['class'=>'btn btn-info','id'=>'btn_print_inv_detail','target'=>"_blank",'data-pjax'=>0]) ?>
                </div>
                <input type="hidden" id="hidden_status" value="<?php echo $model->itemstatus; ?>">
                <?= $form->field($model, 'nhso_inv_id', ['showLabels' => false])->hiddenInput() ?>
            </div>
            </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
$script = <<< JS
$(document).ready(function(){
        var chk_inv_status = $('#hidden_status').val();
        $("#btn_print_inv,#btn_print_inv_detail").addClass("disabled", "disabled");
        if(chk_inv_status=="2"){
            $('#btn_print_inv,#btn_print_inv_detail').removeClass('disabled');
        }else{
            $("#btn_print_inv,#btn_print_inv_detail").addClass("disabled", "disabled");
        }
        document.getElementById("cash").checked = true;
        document.getElementById("tranfer").checked = true;
        localStorage.checkbox_cash = 'checkbox_cash';
        localStorage.checkbox_tranfer = 'checkbox_tranfer';
        //$("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
    });
    $("input[id=cash]").click(function () {
        if ($(this).is(":checked"))
        {   
            // document.getElementById("tranfer").checked = false;
            // $("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
            localStorage.checkbox_cash = 'checkbox_cash';
            console.log('checkbox_cash');
        }else{
            // document.getElementById("tranfer").checked = true;
            // $("#tbfinhsoinv-nhso_inv_bank_id").removeAttr('disabled');
            localStorage.checkbox_cash = 'not_checkbox_cash';
            console.log('not_checkbox_cash');
        }
    });
    $("input[id=tranfer]").click(function () {
        if ($(this).is(":checked"))
        {   
            // document.getElementById("cash").checked = false;
            $("#tbfinhsoinv-nhso_inv_bank_id").removeAttr('disabled');
            localStorage.checkbox_tranfer = 'checkbox_tranfer';
            console.log('checkbox_tranfer');
        }else{
            //document.getElementById("cash").checked = true;
            $("#tbfinhsoinv-nhso_inv_bank_id").attr('disabled', 'disabled');
            localStorage.checkbox_tranfer = 'not_checkbox_tranfer';
            console.log('not_checkbox_tranfer');
        }
    });
    // var dataArray = $("#_form_inv").serialize(),
    //         dataObj = {};
    // $(dataArray).each(function (i, field) {
    //     dataObj[field.name] = field.value;
    // });
    // console.log(dataObj['TbFiNhsoInv[nhso_inv_crdays]']);
JS;
$this->registerJs($script);
?>
<script> 
    function fn_print_inv($key){
        alert($key);
    }
    function fn_print_inv_rep($key){
        alert($key);
    }
    function fn_save(){
        $.ajax({
          url: 'save-inv',
          type: 'POST',
          data: $('#_form_inv').serialize(),
          success: function (data) {
            $('#loading_inv').waitMe('hide');
            $('#form_inv').modal('hide');
            swal('Saved','','success');
            location.reload();
            // var url = "index";
            // window.location.replace(index);
          },
          error: function(data){
           $('#loading_inv').waitMe('hide');
          }  
        }); 
    }
    function fn_draft(){
        $.ajax({
          url: 'draft-inv',
          type: 'POST',
          data: $('#_form_inv').serialize(),
          success: function (data) {
            $('#loading_inv').waitMe('hide');
            $('#form_inv').modal('hide');
            $('#tbfinhsoinv-nhso_inv_num').val(data);
            swal('Draft','','success');
            location.reload();
            //location.reload();
            // var url = "index";
            // window.location.replace(url);
          },
          error: function(data){
           $('#loading_inv').waitMe('hide');
          }  
        }); 
        
    }
    function btn_submit(callback){
            swal({   
            title: "ยืนยันคำสั่ง?",   
            text: "",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: true
            },function(){
                wait();
                callback();
            });
    }
    function chk_bank(callback){
        var chk_tranfer = localStorage.checkbox_tranfer;
        if(chk_tranfer=="checkbox_tranfer"){
            var chk_back = $('#tbfinhsoinv-nhso_inv_bank_id').val();
            if(chk_back){
                btn_submit(callback);
            }else{
                swal('กรุณากรอกข้อมูลธนาคารที่ต้องการโอน','','warning');
            }
        }else{
            btn_submit(callback);
        }
    }
    function chk_empty(callback1,callback2){
        var chk_date = $('#tbfinhsoinv-nhso_inv_date').val();
        //var chk_inv_num = $('#tbfinhsoinv-nhso_inv_num').val();
        //var chk_inv_hdoc = $('#tbfinhsoinv-nhso_inv_hdoc').val();
        var chk_inv_crdays = $('#tbfinhsoinv-nhso_inv_crdays').val();
        var chk_inv_attnname = $('#tbfinhsoinv-nhso_inv_attnname').val();
        if(chk_date&&chk_inv_crdays&&chk_inv_attnname){
            callback1(callback2);
        }else{
            swal('กรุณากรอกข้อมูลให้ครบ','','warning');
        }
    }
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#loading_inv').waitMe({
                    effect: 'ios',
                    text: 'กำลังโหลดข้อมูล...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    sizeW: '',
                    sizeH: '',
                    source: '',
                    onClose: function () {}
                });
            }
    }    
   

</script>