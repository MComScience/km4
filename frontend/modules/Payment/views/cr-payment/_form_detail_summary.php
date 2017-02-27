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
$this->title = "รายละเอียดใบแจ้งค่าใช้จ่าย";
$this->params['breadcrumbs'][] = ['label' => 'ประวัติการนำส่งใบแจ้งค่าใช้จ่าย', 'url' => ['history']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('$("#tab_A").addClass("active");');
?>
<div class="tabbable" id="wait">
<?php echo $this->render('_tab_menu_detail'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-list-index">
                <?php Pjax::begin(['id' => 'pjax_detail_cr', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_detail', ['modelSummary' => $modelSummary]); ?>
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
                            'headerOptions' => $header_style,
                            'header' => 'ใบแจ้งค่าใช้จ่าย',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                if ($model->inv_num == null) {
                                    return '-';
                                } else {
                                    return $model->inv_num;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'วันที่',
                            'format' => ['date', 'php:d/m/Y'],
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                                 return $model->invdate;
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
                                if ($model->VN_AN == null) {
                                    return '-';
                                } else {
                                    return $model->VN_AN;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
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
                            'headerOptions' => $header_style,
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
                            'headerOptions' => $header_style,
                            'header' => 'เป็นเงิน',
                            //'format' => '[decimal,2]',
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->inv_Amt_total == null) {
                                    return '0';
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
                   <textarea rows="4" cols="50" readonly="" style="border-radius: 5px;background-color: white;"  name="cr_summary_remark" id="cr_summary_remark" value="<?php echo $modelSummary['cr_summary_remark']; ?>"></textarea>
                </div>
                 <br><br>
                <div class="form-group" style="text-align: right;margin-right: 10px">
                    <?= Html::a('Close', ['history'], ['class' => 'btn btn-default']) ?>
                </div> 
            </div>
        </div>
    </div>
</div>
