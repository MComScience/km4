<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
//$_SESSION['section_view'] = $SectionID;
/* @var $this yii\web-\View */
/* @var $searchModel ----app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "รายละเอียดเงินสด";
$this->params['breadcrumbs'][] = ['label' => 'ประวัติรายการนำส่งการชำระเงิน', 'url' => ['history']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("#tab_A").addClass("active");');
?>
<div class="tabbable" id="wait">
<?php echo $this->render('_tab_menu_detail'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-list-index">
                <?php Pjax::begin(['id' => 'pjax_PSC', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_detail', ['modelSummary' => $modelSummary,'SectionName'=>$SectionName]); ?>
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
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
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                            'pageSummary' => 'รวม',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                        if ($model->pt_name == null) {
                            return '-';
                        } else {
                            return $model->pt_name;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เงินสด',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->sum_cash == null) {
                            return '0.00';
                        } else {
                            return $model->sum_cash;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'บัตรเครดิต',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->sum_creditcard == null) {
                            return '0.00';
                        } else {
                            return $model->sum_creditcard;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'โอนเงิน',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->sum_banktransfer == null) {
                            return '0.00';
                        } else {
                            return $model->sum_banktransfer;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เช็คเงินสด',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->sum_cheque == null) {
                            return '0.00';
                        } else {
                            return $model->sum_cheque;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'รวมเป็นเงิน',
                            'format' => ['decimal',2],
                            'pageSummary' => true,
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->rep_Amt_net == null) {
                            return '0.00';
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
                <input type="hidden" class="form-control" style="background-color: white;text-align:left" readonly="" name="rep_summary_id" id="rep_summary_id" value="<?php echo $modelSummary['rep_summary_id'];?>">
                </div>
                <div class="form-group" style="margin-top: 2em;">
                   <label class="col-lg-1 col-md-2 col-sm-12 col-xs-12 control-label no-padding-left" style="color:#53a93f;">หมายเหตุ:</label>
                   <textarea rows="4" cols="50" readonly="" style="border-radius: 5px;background-color: white;"  name="rep_summary_remark" id="rep_summary_remark" value="<?php echo $modelSummary['rep_summary_remark']; ?>"></textarea>
                </div>
                 <div class="form-group" style="margin-top: 2em;">
                   <label class="col-lg-2 col-md-2 col-sm-12 col-xs-12 control-label no-padding-left" style="color:#53a93f;">รายละเอียดเงินสด</label>
               </div>
               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php echo $this->render('_detail_cash',['modelSummary'=>$modelSummary]); ?>
               </div>
                <br><br>
                <div class="form-group" style="text-align: right;margin-right: 10px">
                    <?= Html::a('Close', ['history'], ['class' => 'btn btn-default']) ?>
                    <?= Html::button('พิมพ์ใบนำส่งการชำระเงิน', ['class' => 'btn btn-info', 'id' => 'Print']) ?>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php //kepalung/ace/teo/naja/rudy/----------libo/ace/teo/naja/rudy/--------------------karin/ace/teo/jave/rudy
\yii\bootstrap\Modal::begin([
    'id' => 'form_send',
    'header' => '<h4 class="modal-title">รายละเอียดเงินสด</h4>',
    'size' => 'modal-lg modal-primary',
]);
?>
<div id="data_send">
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
    <h1><p> </p></h1><br>
</div>
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
                title: "",   
                text: "ยืนยันคำสั่ง?",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Confirm",   
                closeOnConfirm: true
         },function(){  
          wait();
          $.get(
                    'index.php?r=Payment/send-cash/send',
                    {
                       rep_summary_id,rep_summary_date,rep_summary_section,rep_summary_remark
                    },
                    function (data)
                    {   
                        if(data == 'false'){
                            $('#wait').waitMe('hide');
                            swal("","ไม่มีข้อมูลที่จะนำส่ง","warning");
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
    	//alert('รอลิงค์รายงาน');     
        window.open("http://www.udcancer.org/km4d/frontend/web/index.php?r=Payment/send-cash/summary&id="+$('#rep_summary_id').val(),'_blank');      
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
