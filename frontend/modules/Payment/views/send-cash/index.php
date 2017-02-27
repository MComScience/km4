<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
$header_style = ['style' => 'text-align:center;color:#000000;'];
echo $this->render('/config/Asset_Js.php');
//$_SESSION['section_view'] = $SectionID;
/* @var $this yii\web-\View */
/* @var $searchModel ----app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "รายการรอนำส่งการชำระเงิน";
$this->params['breadcrumbs'][] = $this->title;
?>
<span style="font-size:20px;color:#d73d32;text-align:center;"># <i class="glyphicon glyphicon-wrench" style="color:#d73d32;font-size:25px;"></i>ขออภัย หน้าเว็บไซต์นี้อยู่ระหว่างการปรับปรุง #<br></span>
<div class="tabbable" id="wait">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-list-index">
                <?php Pjax::begin(['id' => 'pjax_PSC', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_send_cash', ['model' => $searchModel,'SectionName'=>$SectionName]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'bootstrap' => true,
                    'responsiveWrap' => FALSE,
                    'responsive' => true,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => false,
                    'condensed' => true,
                    'toggleData' => true,
                    'layout' => Yii::$app->componentdate->layoutgridview(),
                    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                    'showPageSummary' => true,
                    'pageSummaryRowOptions' => ['class' => 'kv-page-summary default'],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'contentOptions' => ['class' => 'kartik-sheet-style'],
                            'width' => '36px',
                            'header' => 'ลำดับ',
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;']
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ใบเสร็จรับเงิน',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->rep_num == null) {
                                    return '-';
                                } else {
                                    return $model->rep_num;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'วันที่',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->repdate == null) {
                                    return '-';
                                } else {
                                    return $model->repdate;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'HN',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->pt_hospital_number == null) {
                                    return '-';
                                } else {
                                    return $model->pt_hospital_number;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'VN : AN',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->pt_admission_number == null) {
                                    return '-';
                                } else {
                                    return $model->pt_admission_number;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                            'pageSummary' => 'รวม',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                                if ($model->pt_name == null) {
                                    return '-';
                                }else{
                                    return $model->pt_name;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'เงินสด',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->sum_cash == null) {
                                    return '0';
                                } else {
                                    return $model->sum_cash;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'บัตรเครดิต',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->sum_creditcard == null) {
                                    return '0';
                                } else {
                                    return $model->sum_creditcard;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'โอนเงิน',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->sum_banktransfer == null) {
                                    return '0';
                                } else {
                                    return $model->sum_banktransfer;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'เช็คเงินสด',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->sum_cheque == null) {
                                    return '0';
                                } else {
                                    return $model->sum_cheque;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'รวมเป็นเงิน',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->rep_Amt_net == null) {
                                    return '0';
                                } else {
                                    return $model->rep_Amt_net;
                                }
                            }
                        ],
                    ]
                ]);
                ?>
                
                <?php Pjax::end() ?>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <input type="hidden" class="form-control" style="background-color: white;text-align:left" readonly="" name="SectionID" id="SectionID" value="<?php echo $_SESSION['section_view'];?>">
                </div>
                <div class="form-group" style="margin-top: 2em;">
                   <label class="col-lg-1 col-md-2 col-sm-12 col-xs-12 control-label no-padding-left" style="color:#53a93f;">หมายเหตุ:</label>
                   <textarea rows="4" cols="50" style="border-radius: 5px;background-color: #FFFF99;"  name="rep_summary_remark" id="rep_summary_remark" value="<?php //echo $model['rep_summary_date']; ?>"></textarea>
                </div>
                <div class="form-group" style="text-align: right;margin-right: 10px">
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                    <?= Html::a('นำส่งการชำระงิน',false, ['class' => 'btn btn-success','id'=>'Send']) ?>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'form_send',
    'header' => '<h4 class="modal-title">รายละเอียดเงินสด</h4>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div id="data_send"></div>
<?php \yii\bootstrap\Modal::end(); ?>
<?php
$script = <<< JS
   $('#Send').click(function (e) {
      console.log('Send');
      var rep_summary_id = $('#rep_summary_id').val();
      var rep_summary_date = $('#vwfireplistsearch-repdate').val();
      var rep_summary_section = $('#SectionID').val();
      var rep_summary_remark = $('#rep_summary_remark').val();
      if(rep_summary_date == ''){
         swal("","กรุณากรอกวันที่นำส่งเงินสด","warning");
      }else{
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
          $.get(
                    'send',
                    {
                       rep_summary_id,rep_summary_date,rep_summary_section,rep_summary_remark
                    },
                    function (data)
                    {   
                        if(data == 'false'){
                            $('#wait').waitMe('hide');
                            swal("ไม่มีข้อมูลที่จะนำส่ง!","","warning");
                        }else{
                            $('#wait').waitMe('hide');
                            $('#wait').waitMe('hide');
                            $('#form_send').find('.modal-body').html(data);
                            $('#data_send').html(data);
                            $('#form_send').modal('show');
                            $('.modal-lg').css('width', '85%');
                        }
                    }
            );
        });
         $('#wait').waitMe('hide');
      }
    });
    $('#Print').click(function (e) { 
    	alert('รอลิงค์รายงาน');     
    });
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#wait').waitMe({
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
JS;
$this->registerJs($script);
?>
