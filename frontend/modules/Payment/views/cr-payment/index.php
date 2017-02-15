<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "นำส่งใบแจ้งค่าใช้จ่าย";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<!-- <span style="font-size:20px;color:#d73d32;text-align:center;"># <i class="glyphicon glyphicon-wrench" style="color:#d73d32;font-size:25px;"></i>ขออภัย หน้าเว็บไซต์นี้อยู่ระหว่างทดสอบระบบ #<br></span> -->
<div class="tabbable">
<div class="tabbable" id="wait">
<?php echo $this->render('_tab_menu'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-list-index">
                <?php Pjax::begin(['id' => 'cr_pjax', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_cr', ['model' => $searchModel]); ?>
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
                            'header' => 'ใบแจ้งค่าใช้จ่าย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->inv_id == null) {
                            return '-';
                        } else {
                            return $model->inv_id;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'วันที่',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->invdate == null) {
                            return '-';
                        } else {
                            return $model->invdate;
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
                        if ($model->VN_AN == null) {
                            return '-';
                        } else {
                            return $model->VN_AN;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อ-นามสกุลผู้ป่วย',
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
                            'header' => 'สิทธิการรักษา',
                            //'format' => '[decimal,2]',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                        if ($model->medical_right_desc == null) {
                            return '-';
                        } else {
                            return $model->medical_right_desc;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เป็นเงิน',
                            'format' => ['decimal',2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                        if ($model->inv_Amt_total == null) {
                            return '0.00';
                        } else {
                            return $model->inv_Amt_total;
                        }
                    }
                        ],
                    ]
                ]);
                ?>
                <?php Pjax::end() ?>
                <div class="form-group" style="margin-top: 2em;">
                   <label class="col-lg-1 col-md-2 col-sm-12 col-xs-12 control-label no-padding-left" style="color:#53a93f;">หมายเหตุ:</label>
                   <textarea rows="4" cols="50" style="border-radius: 5px;background-color: #FFFF99;"  name="cr_summary_remark" id="cr_summary_remark" value="<?php //echo $model['rep_summary_date']; ?>"></textarea>
                </div>
                <div class="form-group" style="text-align: right;margin-right: 10px">
                    <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                    <?= Html::button('Clear', ['class' => 'btn btn-danger', 'id' => 'Clear']) ?>
                    <a class="btn btn-success" id="CrSummary">สรุปนำส่งใบแจ้งค่าใช้จ่าย</a>
                    <?= Html::button('พิมพ์ใบนำส่งเรียกเก็บ', ['class' => 'btn btn-info', 'id' => 'Print']) ?>
                </div> 
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
     $(document).ready(function(){
//            document.getElementById("CrSummary").disabled = true;
//            $("#CrSummary").attr('disabled', 'disabled');
        });    
        
  $('#CrSummary').click(function (e) {
      console.log('CrSummary');
      var cr_summary_id = $('#cr_summary_id').val();
      var cr_summary_pt_visit_type = $('#vwfiinvcrlistsearch-pt_visit_type').val();
      //var cr_summary_date = $('#vwfiinvcrlistsearch-cr_summary_date').val();
      var cr_summary_remark = $('#cr_summary_remark').val();
      var pt_visit_status =  $('#pt_visit_status').val();
      if(pt_visit_status == ''){
            swal("","Checkbox Dischage","warning");
      }else{
        wait();
          $.get(
                    'index.php?r=Payment/cr-payment/cr-summary',
                    {
                       cr_summary_id,cr_summary_pt_visit_type,cr_summary_remark,pt_visit_status
                    },
                    function (data)
                    {   
                        if(data == 'false'){
                                $('#wait').waitMe('hide');
                                swal("","ไม่มีข้อมูลที่จะนำส่ง","warning");
                            }else{
                                $('#wait').waitMe('hide');
                                $.pjax.reload({container:'#cr_pjax'});
                            }

                    }
            );
      }
      
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
