<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
echo $this->render('/config/Asset_Js.php');
$header_style = ['style' => 'text-align:center;color:#000000;'];
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwInvForRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "ร่างบันทึกการชำระเงิน";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tabbable">
    <?php echo $this->render('_tab_menu_payment'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-inv-for-rep-list-index">
                <?php Pjax::begin(['id' => 'rep_pjax', 'timeout' => 5000]) ?>
                
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'hover' => true,
                    'pjax' => true,
                    'striped' => true,
                    'condensed' => true,
                    'bordered' => true,
                    'layout' => "{items}",
                    'responsive' => false,
                    'showOnEmpty' => false,
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
                            'class' => 'kartik\grid\ExpandRowColumn',
                            'value' => function ($model, $key, $index, $column) {
                                return kartik\grid\GridView::ROW_COLLAPSED;
                            },
                            'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'color:#000000;'],
                            'expandOneOnly' => true,
                            //'header' => '<a>Detail</a>',
                            //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                            //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                            'detailAnimationDuration' => 'slow', //fast
                            'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                            'detailUrl' => \yii\helpers\Url::to(['view-detail-rep']),
                        ],
                        [
                            'headerOptions' => $header_style,
                            'header' => 'ใบแจ้งค่าใช้จ่าย',
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
                                if ($model->pt_hospital_number == null) {
                                    return '-';
                                } else {
                                    return $model->pt_hospital_number;
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
                            'class' => 'kartik\grid\ActionColumn',
                            'header' => 'Actions',
                            'noWrap' => true,
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => $header_style,
                            'template' => '{select} {owed}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-success btn-xs">Select</span>',false, [
                                            'title' => Yii::t('app', 'Select'),
                                            'onclick' => "select_rep($model->rep_id)",
                                        ]);
                                },
                               'owed' => function ($url, $model) {
                                    return Html::a('<span class="btn btn-warning btn-xs">บันทึกค้างชำระ</span>',false, [
                                            'title' => Yii::t('app', 'บันทึกค้างชำระ'),
                                            'onclick' => "select_owed($model->rep_id)",
                                        ]);
                                },
                                ],
                                    'urlCreator' => function ($action, $model, $key, $index) {
                            }
                                ],
                            ],
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
$(document).ready(function () {
    $('table.default').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
        "pageLength": 10,
        "responsive": true,
        "columns": [
            null,
            {"bSortable": false},
            null,
            null,
            null,
            null,
            null,
            null,
            {"bSortable": false}
        ],
        "language": {
            // "search": "ค้นหา : _INPUT_ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><span class='text'></span><input type='checkbox' class='colored-success' id='chk_box'  data-toggle='checkbox-x'><span class='text'> แสดงเฉพาะรายการที่ยังไม่บันทึกลูกหนี้</span></label>",
            "search": "ค้นหา : _INPUT_ ",
            /*"searchPlaceholder": "ค้นหาข้อมูล...",*/
            "lengthMenu": "_MENU_",
            "infoEmpty": "No records available",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            //"infoFiltered": "(ค้นหาจากทั้งหมด _MAX_ รายการ)"
        },
        "aLengthMenu": [
            [5, 10, 15, 20, 100, -1],
            [5, 10, 15, 20, 100, "All"]
        ],
        /*"paging":   false,
         "ordering": false,
         "info":     false*/
    });

});                             
JS;
$this->registerJs($script);
?>
<script>
function select_rep(rep_id){
        $.get(
                'rep-to-create',
                {
                    rep_id
                },
                function (data)
                {

        }
    );
}
function select_owed(rep_id){
  swal("", "รอออกแบบหน้าบันทึกค้างชำระ", "warning");
}  
</script>
        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                 <?php
                 echo \kartik\widgets\Growl::widget([
                     'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                     'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                     'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                     'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                     'showSeparator' => true,
                     'delay' => 1, //This delay is how long before the message shows
                     'pluginOptions' => [
                         'delay' => (!empty($message['duration'])) ? $message['duration'] : 2000, //This delay is how long the message shows for
                         'placement' => [
                             'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                             'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                         ]
                     ]
                 ]);
                 ?>
        <?php endforeach; ?>
                               