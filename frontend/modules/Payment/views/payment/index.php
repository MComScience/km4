<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\Payment\models\VwInvForRepListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "รายการใบแจ้งค่าใช้จ่าย";
$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$(document).ready(function () {
        $('#tab_A').addClass("active");
    });
JS;
$this->registerJs($script);
?>
<!-- <span style="font-size:20px;color:#d73d32;text-align:center;"># <i class="glyphicon glyphicon-wrench" style="color:#d73d32;font-size:25px;"></i>ขออภัย หน้าเว็บไซต์นี้อยู่ระหว่างการทดสอบระบบ #<br></span> -->
    <?php echo $this->render('_tab_menu_payment'); ?>
    <div class="tab-content">
        <div id="tab" class="tab-pane in active ">
            <div class="vw-inv-for-rep-list-index">
                <?php Pjax::begin(['id' => 'inv_pjax', 'timeout' => 5000]) ?>
                <?php echo $this->render('_search_payment', ['model' => $searchModel]); ?>
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
                            'detailUrl' => \yii\helpers\Url::to(['view-detail-inv']),
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'เลขที่ใบสั่งยา',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->cpoe_num == null) {
                            return '-';
                        } else {
                            return $model->cpoe_num;
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
                        if ($model->VNAN == null) {
                            return '-';
                        } else {
                            return $model->VNAN;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'ชื่อ-นามสกุลผู้ป่วย',
                            'hAlign' => GridView::ALIGN_LEFT,
                            'value' => function ($model) {
                        if ($model->pt_fullname == null) {
                            return '-';
                        } else {
                            return $model->pt_fullname;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'สถานะคำสั่ง',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->cpoe_status == null) {
                            return '-';
                        } else {
                            return $model->cpoe_status;
                        }
                    }
                        ],
                        [
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'header' => 'สถานะการชำระเงิน',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'value' => function ($model) {
                        if ($model->rep_status == null) {
                            return '-';
                        } else {
                            return $model->rep_status;
                        }
                    }
                        ],
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'options' => ['style' => 'width:160px;'],
                            'header' => 'Actions',
                            'hAlign' => GridView::ALIGN_CENTER,
                            'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                            'template' => '{select} {owed}',
                            'buttons' => [
                                'select' => function ($url, $model) {
                                    $findRep = \app\modules\Payment\models\TbFiRep::findOne(['inv_id' => $model->inv_id]);
                                    if (!empty($findRep)) {
                                        return '<span style="color:#53a93f;">กำลังดำเนินการ</span><span class="glyphicon glyphicon-hourglass" style="color:#53a93f;"></span>';
                                   } else {    
                                        return Html::a('<span class="btn btn-success btn-xs">Select</span>','#', [
                                            'title' => Yii::t('app', 'Select'),
                                            'onclick' => "select_inv($model->inv_id)",
                                            //'data-id' => $model->inv_id,
                                        ]);
                                    }
                                },
                                'owed' => function ($url, $model) {
                                $findRep = \app\modules\Payment\models\TbFiRep::findOne(['inv_id' => $model->inv_id]);
                                if (empty($findRep)) {    
                                    return Html::a('<span class="btn btn-warning btn-xs">บันทึกค้างชำระ</span>','#', [
                                        'title' => Yii::t('app', 'บันทึกค้างชำระ'),
                                        'onclick' => "owed($model->inv_id)",
                                     ]);
                                }    
                                },
                                    ],
                                ],
                            ],
                        ]);
                        ?>
                        <?php Pjax::end() ?>
                        <div class="form-group" style="margin-top:30px;text-align: right">
                                <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
$script = <<< JS
$(document).ready(function () {
	setInterval(function(){
		$.pjax.reload({container: '#inv_pjax'}); 
	}, 60000); 
});             
JS;
$this->registerJs($script);
?>
<script>
function select_inv(inv_id) {

        $.get(
                'index.php?r=Payment/payment/create-payment',
                {
                    inv_id
                },
                function (data)
                {
                    if (data) {
                        var data_key = data;
                        var url = "index.php?r=Payment/payment/create&rep_id=" + data_key + "";
                        window.location.replace(url);
                    }
                }
        );
 }   
 function owed(inv_id){
    swal("","รอออกแบบหน้าบันทึกค้างชำระ","warning");
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
                               