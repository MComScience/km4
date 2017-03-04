<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
echo $this->render('/config/Asset_Js.php');
$header_style = ['style' => 'text-align:center;color:#000000;'];
/* @var $this yii\web-\View */
/* @var $searchModel ----app\modules\Payment\models\VwFiRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = "ประวัติชำระเงิน";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tabbable" id="wait_history">
<?php echo $this->render('_tab_menu_payment'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-fi-rep-list-index">
                <?php Pjax::begin(['id' => 'history_pjax', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_history', ['model' => $searchModel]); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => true,
                    'condensed' => true,
                    'bordered' => true,
                    'layout' => Yii::$app->componentdate->layoutgridview(),
                    //'layout' => "{items}",
                    'responsive' => false,
                    'showOnEmpty' => true,
                    'export' => false,
                    'headerRowOptions' => ['class' => \kartik\grid\GridView::TYPE_SUCCESS],
                    'tableOptions' => ['class' => GridView::TYPE_DEFAULT,'style' => 'width:100%','id'=>'grid_index'],
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
                                    return $model->repdate;
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
                            //'pageSummary' => 'รวม',
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
                            'header' => 'จำนวนเงิน',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->Item_Amt == null) {
                                    return '0';
                                } else {
                                    return $model->Item_Amt;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'เบิกได้',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->Item_Cr_Amt_Sum == null) {
                                    return '0';
                                } else {
                                    return $model->Item_Cr_Amt_Sum;
                                }
                            }
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'เบิกไม่ได้',
                            'format' => ['decimal', 2],
                            'hAlign' => GridView::ALIGN_RIGHT,
                            'value' => function ($model) {
                                if ($model->Item_PayAmt == null) {
                                    return '0';
                                } else {
                                    return $model->Item_PayAmt;
                                }
                            }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'noWrap' => true,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => $header_style,
                            'template' => '{select}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>',false, [
                                            'title' => Yii::t('app', 'Select'),
                                            'onclick' => "history_rep($model->rep_id)",
                                        ]);
                                },
                                ],
                        ],
                    ]
                ]);
                ?>
                
                <?php Pjax::end() ?>
                <?php echo $this->render('/config/btn_close.php'); ?>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
// $(document).ready(function () {
//     $('table.default').DataTable({
//         "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
//         "pageLength": 10,
//         "responsive": true,
//         "columns": [
//             null,
//             null,
//             null,
//             null,
//             null,
//             null,
//             null,
//             null,
//             null,
//             {"bSortable": false}
//         ],
//         "language": {
//             // "search": "ค้นหา : _INPUT_ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><span class='text'></span><input type='checkbox' class='colored-success' id='chk_box'  data-toggle='checkbox-x'><span class='text'> แสดงเฉพาะรายการที่ยังไม่บันทึกลูกหนี้</span></label>",
//             "search": "ค้นหา : _INPUT_ ",
//             /*"searchPlaceholder": "ค้นหาข้อมูล...",*/
//             "lengthMenu": "_MENU_",
//             "infoEmpty": "No records available",
//             "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
//             //"infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
//         },
//         "aLengthMenu": [
//             [5, 10, 15, 20, 100, -1],
//             [5, 10, 15, 20, 100, "All"]
//         ],
//         /*"paging":   false,
//          "ordering": false,
//          "info":     false*/
//     });

// });                      
JS;
$this->registerJs($script);
?>
<script>
function history_rep(rep_id){
        $.get(
                'history-detail',
            {
                rep_id
            },
            function (data)
            {
                        
            }
        );
}
</script>