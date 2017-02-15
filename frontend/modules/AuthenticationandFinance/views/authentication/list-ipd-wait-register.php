<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\base\View;

$layout = <<< HTML
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;
$this->title = 'ผู้ป่วยในรอลงทะเบียน';
$this->params['breadcrumbs'][] = ['label' => 'AuthenticationandFinance', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ลงทะเบียนผู้ป่วย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
           <?php echo $this->render('_tab'); ?>
            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <div class="tb-item-index">
                        <div class="col-lg-11" style="text-align: right;margin-left: 40px;font-size: 16px;"> 
                            <b>ลงทะเบียนอัตโนมัติ</b>
                        </div>
                        <label>
                          <input id="btn_auto_ipd" class="checkbox-slider slider-icon colored-palegreen" type="checkbox">
                          <span class="text"></span>
                        </label>
                        <?php Pjax::begin(['id' => 'tb_getipd_pjax']); ?>
                        <?php $count_rows = $dataProvider->getTotalCount(); if(!empty($count_rows)){ ?>
                        <?=
                        fedemotta\datatables\DataTables::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
                            'tableOptions' => [
                                'class' => 'default kv-grid-table table table-hover table-bordered  table-condensed'
                            ],
                            'clientOptions' => [
                                'bSortable' => false,
                                'bAutoWidth' => true,
                                'ordering' => false,
                                'pageLength' => 10,
                                //'bFilter' => false,
                                'language' => [
                                    'info' => 'แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ',
                                    'lengthMenu' => '_MENU_',
                                    'sSearchPlaceholder' => 'ค้นหาข้อมูล...',
                                    'search' => '_INPUT_ '
                                ],
                                "lengthMenu" => [[10, -1], [10, Yii::t('app', "All")]],
                                "responsive" => true,
                                "dom" => '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                "tableTools" => [
                                    "aButtons" => [
                                        [
                                            "sExtends" => "copy",
                                            "sButtonText" => Yii::t('app', "Copy to clipboard")
                                        ], [
                                            "sExtends" => "csv",
                                            "sButtonText" => Yii::t('app', "Save to CSV")
                                        ], [
                                            "sExtends" => "xls",
                                            "oSelectorOpts" => ["page" => 'current']
                                        ], [
                                            "sExtends" => "pdf",
                                            "sButtonText" => Yii::t('app', "Save to PDF")
                                        ], [
                                            "sExtends" => "print",
                                            "sButtonText" => Yii::t('app', "Print")
                                        ],
                                    ]
                                ]
                            ],
                            'columns' => [
                                [
                                    'header' => 'ลำดับ',
                                    'class' => 'yii\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
                                ],
                                [
                                    'header' => 'HN',
                                    'attribute' => 'PT_HOSPITAL_NUMBER',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
                                    'contentOptions' => ['class' => 'text-center'],
                                ],
                                [
                                    'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                                    'attribute' => 'PT_FNAME_TH',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function($model) {
        return $model->title['pt_titlename'] . $model['PT_FNAME_TH'] . '  ' . $model['PT_LNAME_TH'];
    }
        ],
                                //columns
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'headerOptions' => ['style' => 'text-align:center;color:black;background-color: #DFF0D8',],
                                    'header' => 'Actions',
                                    'contentOptions' => ['class' => 'text-center'],
                                    'template' => '{detail}',
                                    'buttons' => [
                                        /* Edit */
                                        'detail' => function ($url, $model) {
                                            return Html::a('<span class="btn btn-success btn-xs btn-group tooltip-lg"> ลงทะเบียน </span>', 'javascript:void(0)', [
                                                        'title' => Yii::t('app', 'Detail'),
                                                        'data-toggle' => 'tooltip',
                                                        'data-placement' => 'top',
                                                        'data-original-title' => 'ลงทะเบียน',
                                                        'onclick'=>'register('.$model->PT_HOSPITAL_NUMBER.')'
                                                        
                                            ]);
                                        },
                                            ],
                                        ],
                                    ],
                                        ]
                                );
                                ?>
                                <?php }else{ ?>
                                  <div class="alert alert-warning">ไม่พบข้อมูล ผู้ป่วยในรอลงทะเบียน</div>
                                <?php } ?>
                                <?php Pjax::end(); ?>
                            </div>
                            <br/>
                            
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>

            </div>
        </div>
<script>
function register(id){
     $('#pt').val(id);
       var type = "ipd";
      if(type == 'ipd'){
        var message_warnig = 'กรุณาใส่ข้อมูล HN หรือ AN';
            }else{
               var message_warnig = 'กรุณาใส่ข้อมูล HN ';
            }
          if(id != ""){
            waitMe_Running_show(2);
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/get-ipd-opd',
                    type: 'get',
                    data:{type:type,id:id},
                    success: function (data) {
                   if(data == 'false'){
                       swal("", "ไม่พบข้อมูล", "warning");
                       waitMe_Running_hide(2);
                      }else{
                            $('#ipdopd').val('ipd');
                           $('#patian_div_html').html(data); 
                           $("#save").removeClass("disabled");
                           $("#clear").removeClass("disabled");
                           $("#save").removeAttr('disabled', 'disabled');
                           $('#clear').removeAttr('disabled', 'disabled');
                           $('#modal_opd_and_ipd').modal({show: 'true'});
                            waitMe_Running_hide(2);
                   }  
                    }
                });
          }else{
             swal("", message_warnig, "warning");
          waitMe_Running_hide(2);
            }   
}
    </script>
<?php
$script = <<< JS
    $(document).ready(function () {
      var confirm = localStorage.Auto_confirm_ipd;
      if(confirm == "YES"){
        $('#btn_auto_ipd').prop('checked', true);
      }
    }); 
    setInterval(function(){
      $(document).ready(function () {
         var confirm = localStorage.Auto_confirm_ipd;
         if(confirm == "YES"){
            Auto_register_ipd();
          }
      });
    },360000);
    function Auto_register_ipd(){
        waitMe_Running_show(2);
            $.ajax({
              url: 'index.php?r=AuthenticationandFinance/authentication/auto-checkin-ipd',
              type: 'POST',
              data:{},
              success: function (data) {
                if(data){
                  console.log('Success!!');
                  waitMe_Running_hide(2);
                  $.pjax.reload({container:"#tb_getipd_pjax", async:false});
                  //location.reload();
                }else{
                  console.log('Empty!!');
                  waitMe_Running_hide(2);
                }
                

              },
              error: function(data){
                console.log('Error Function!!');
              }  
            }); 
          console.log('Auto_register_ipd');
    }
    $('#btn_auto_ipd').change(function() {
        var chk_status = $(this).prop('checked');
        if(chk_status){
          swal({
           title: "",
           text: "ยืนยันคำสั่ง?",
           type: "warning",
           confirmButtonColor: "#53a93f",  
           showCancelButton: true,
           confirmButtonText: "Confirm",
           closeOnConfirm: true,
           closeOnCancel: true
          },function(isConfirm){
            if(isConfirm){
              localStorage.Auto_confirm_ipd = "YES";
              Auto_register_ipd();
              console.log('if');
            }else{
              $('#btn_auto_ipd').prop('checked', false);
              localStorage.Auto_confirm_ipd = "NO";
              console.log('else');

            }
          });
        }else{
            localStorage.Auto_confirm_ipd = "NO";
            console.log('FALSE');
            //$(this).prop('checked', false);
        }
    })               
function init_click_handlers() {
    $(".activity-register").click(function (e) {
       var id = $(this).closest("tr").children("td:eq(1)").text();
      $('#pt').val(id);
       var type = "ipd";
      if(type == 'ipd'){
        var message_warnig = 'กรุณาใส่ข้อมูล HN หรือ AN';
            }else{
               var message_warnig = 'กรุณาใส่ข้อมูล HN ';
            }
          if(id != ""){
            waitMe_Running_show(2);
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/get-ipd-opd',
                    type: 'get',
                    data:{type:type,id:id},
                    success: function (data) {
                   if(data == 'false'){
                       swal("", "ไม่พบข้อมูล", "warning");
                       waitMe_Running_hide(2);
                      }else{
                            $('#ipdopd').val('ipd');
                           $('#patian_div_html').html(data); 
                           $("#save").removeClass("disabled");
                           $("#clear").removeClass("disabled");
                           $("#save").removeAttr('disabled', 'disabled');
                           $('#clear').removeAttr('disabled', 'disabled');
                           $('#modal_opd_and_ipd').modal({show: 'true'});
                            waitMe_Running_hide(2);
                   }  
                    }
                });
          }else{
             swal("", message_warnig, "warning");
          waitMe_Running_hide(2);
            }   
    });

}
init_click_handlers(); //first run
$("#tb_getipd_pjax").on("pjax:success", function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
 //$('#ipd_tab').addClass('active');     
 $('#save').click(function (e) {
       var id = $('#pt').val();
       var type = $('#ipdopd').val();
        if(type== 'ipd'){
        var message_warnig = 'กรุณาใส่ข้อมูล HN หรือ AN';
            }else{
               var message_warnig = 'กรุณาใส่ข้อมูล HN ';  
            }
          if(id != ""){
             waitMe_Running_show(1);
                $.ajax({
                    url: 'index.php?r=AuthenticationandFinance/authentication/save-checkin',
                    type: 'get',
                    data:{type:type,id:id},
                   dataType:'json', 
                    success: function (data) {
                   if(data == 'false'){
                       swal("", "ไม่พบข้อมูล", "warning");
                      }else{
                        //  swal("", "บันทึกข้อมูลแล้ว", "success");
                         $('#modal_opd_and_ipd').modal('hide');
                       waitMe_Running_hide(1);
                    $.ajax({
                            url: 'index.php?r=AuthenticationandFinance/authentication/register',
                            type: 'get',
                            data:{hn:data.hn,registydate:data.registydate},
                            success: function (data) {
                            if(data == 'false'){
                                 swal("", "ไม่พบข้อมูล", "warning");
                         }else{
                          $('#modal_add_right_opd_and_ipd').modal('show');
                          $('#table_right_list').html(data); 
                             }  
                           }
                    });
                   }  
                    }
                });
          }else{
             swal("", message_warnig, "warning");
            }
   });   
  
JS;
        $this->registerJs($script);
        ?>
        <?php
        Modal::begin([
            'id' => 'modal_opd_and_ipd',
            'header' => '<h4 class="modal-title">ลงทะเบียนผู้ป่วยใน</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE
        ]);
        ?>
        <div class="form-group field-inputEmail3 required">
            <label class="control-label col-sm-3" for="inputEmail3"><div id="header_hnorand"></div></label>
            <div class="col-sm-6">
                <input type="hidden" name="pt" class="form-control" id="pt"/>
                <div class="help-block help-block-error "></div>
            </div>
        </div>
        <input type="hidden" id="ipdopd"/>
        <div id="patian_div_html">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger disabled" disabled="" id="clear" data-dismiss="modal">Clear</button>
            <button type="button" class="btn btn-primary disabled" disabled="" id="save">Save</button>
        </div>
        <?php Modal::end(); ?>
        <?php
        Modal::begin([
            'id' => 'modal_add_right_opd_and_ipd',
            'header' => '<h4 class="modal-title">ลงทะเบียนผู้ป่วย</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE
        ]);
        ?>
        <div id="table_right_list"></div>
        <div id="detail_right_and_refer">
        </div>
        <?php Modal::end(); ?>
        <?php
        Modal::begin([
            'id' => 'modal_add_right_opd_and_ipd2',
            'header' => '<h4 class="modal-title">เพิ่มสิทธิ์</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE
        ]);
        ?>
        <div id="detail_add_right">
        </div>
        <?php Modal::end(); ?>
        <?php
        Modal::begin([
            'id' => 'modal_edit_right_payment',
            'header' => '<h4 class="modal-title">ปรับปรุงเงื่อนไขการใช้งานสิทธิ์</h4>',
            'size' => 'modal-lg modal-primary',
            'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
            'closeButton' => FALSE
        ]);
        ?>
