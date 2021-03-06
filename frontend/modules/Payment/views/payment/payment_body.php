<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
?>
<div class="tabbable">
    <div class="tab-content tabs-flat">
        <div id="body_payment" class="tab-pane active">
            <div class="row profile-overview">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php if ($view == 'create') { ?>
                    <div class="tb-st2-temp-index">
                        <?php \yii\widgets\Pjax::begin([ 'id' => 'pjax_body', 'timeout' => 5000]) ?>
                        <?=
                        kartik\grid\GridView::widget([
                            'dataProvider' => $dataProviderBD,
                            //'filterModel' => $searchModelBD,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'showPageSummary' => true,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => true,
                            'condensed' => true,
                            'toggleData' => false,
                            'pageSummaryRowOptions' => ['class' => 'default'],
                            'layout' => Yii::$app->componentdate->layoutgridview(),
                            //'layout' => "{summary}\n{items}\n{pager}",
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => 'ลำดับ',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return kartik\grid\GridView::ROW_COLLAPSED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                    'expandOneOnly' => true,
                                    //'header' => '<a>Detail</a>',
                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                    'detailAnimationDuration' => 'slow', //fast
                                    'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['view-detail-item']),
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'รหัสสินค้า',
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->ItemID == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemID;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'รายการ',
                                    'value' => function ($model) {
                                if ($model->ItemDetail == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemDetail;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'จำนวน',
                                    'options' => ['style' => 'width:120px;'],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->ItemQty1 == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemQty1;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'ราคาต่อหน่วย',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->ItemPrice == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemPrice;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'จำนวนเงิน',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Amt == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Amt;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'ขอเบิกได้',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Cr_Amt_Sum == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Cr_Amt_Sum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'เบิกไม่ได้',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_PayAmt == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_PayAmt;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'ส่วนลด',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Discount == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Discount;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'เป็นเงิน',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Amt_Net == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Amt_Net;
                                }
                            }
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'noWrap' => true,
                                    //'pageSummary' => 'บาท',
                                    'options' => ['style' => 'width:120px;'],
                                    'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'template' => ' {update} {delete}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-info btn-xs">Discount</span>', '#', [
                                                        'class' => 'activity-discount-link',
                                                        'title' => 'Discount',
                                                        //'data-toggle' => 'modal',
                                                        'data-id' => $key,
                                            ]);
                                        },
                                                'delete' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                        'title' => 'Delete',
                                                        //'data-toggle' => 'modal',
                                                        'class' => 'activity-delete-link',
                                                        'data-id' => $key,
                                            ]);
                                        },
                                            ],
                                        ],
                                    ],
                                ]);
                                ?>
                                <?php \yii\widgets\Pjax::end() ?>
                            </div>
                            <?php }?>
                            <?php if ($view == 'history') { ?>
                    <div class="tb-st2-temp-index">
                        <?php \yii\widgets\Pjax::begin([ 'id' => 'pjax_body', 'timeout' => 5000]) ?>
                        <?=
                        kartik\grid\GridView::widget([
                            'dataProvider' => $dataProviderBD,
                            //'filterModel' => $searchModelBD,
                            'bootstrap' => true,
                            'responsiveWrap' => FALSE,
                            'responsive' => true,
                            'showPageSummary' => true,
                            'hover' => true,
                            'pjax' => true,
                            'striped' => true,
                            'condensed' => true,
                            'toggleData' => false,
                            'pageSummaryRowOptions' => ['class' => 'default'],
                            'layout' => Yii::$app->componentdate->layoutgridview(),
                            //'layout' => "{summary}\n{items}\n{pager}",
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\SerialColumn',
                                    'contentOptions' => ['class' => 'kartik-sheet-style'],
                                    'width' => '36px',
                                    'header' => 'ลำดับ',
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                ],
                                [
                                    'class' => 'kartik\grid\ExpandRowColumn',
                                    'value' => function ($model, $key, $index, $column) {
                                        return kartik\grid\GridView::ROW_COLLAPSED;
                                    },
                                    'headerOptions' => ['class' => 'kartik-sheet-style', 'style' => 'background-color: #ddd;color:#000000;'],
                                    'expandOneOnly' => true,
                                    //'header' => '<a>Detail</a>',
                                    //'expandIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                    //'collapseIcon' => '<a class="btn btn-success btn-xs">Detail</a>',
                                    'detailAnimationDuration' => 'slow', //fast
                                    'detailRowCssClass' => kartik\grid\GridView::TYPE_DEFAULT,
                                    'detailUrl' => \yii\helpers\Url::to(['view-detail-item']),
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'รหัสสินค้า',
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->ItemID == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemID;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'รายการ',
                                    'value' => function ($model) {
                                if ($model->ItemDetail == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemDetail;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'จำนวน',
                                    'options' => ['style' => 'width:120px;'],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->ItemQty1 == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemQty1;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'ราคาต่อหน่วย',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->ItemPrice == NULL) {
                                    return '-';
                                } else {
                                    return $model->ItemPrice;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'จำนวนเงิน',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Amt == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Amt;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'ขอเบิกได้',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Cr_Amt_Sum == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Cr_Amt_Sum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'เบิกไม่ได้',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_PayAmt == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_PayAmt;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'ส่วนลด',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                if ($model->Item_Discount == NULL) {
                                    return '-';
                                } else {
                                    return $model->Item_Discount;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                    'header' => 'เป็นเงิน',
                                    'format' => ['decimal', 2],
                                    'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                    'value' => function ($model) {
                                        if ($model->Item_Amt_Net == NULL) {
                                            return '-';
                                        } else {
                                            return $model->Item_Amt_Net;
                                        }
                                    }
                                ],
                                ],
                                ]);
                                ?>
                                <?php \yii\widgets\Pjax::end() ?>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        \yii\bootstrap\Modal::begin([
            'id' => 'form_discount',
            'header' => '<h4 class="modal-title">บันทึกส่วนลด</h4>',
            'size' => 'modal-md modal-primary',
        ]);
        ?>
        <div id="data_discount">
            <h1><p> </p></h1><br>
            <h1><p> </p></h1><br>
            <h1><p> </p></h1><br>
            <h1><p> </p></h1><br>
            <h1><p> </p></h1><br>
        </div>
        <?php \yii\bootstrap\Modal::end(); ?>
<?php
$script = <<< JS
$(document).ready(function(){
	init_click_handlers(); //first run
    $('#pjax_body').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
   function init_click_handlers() {
      $('.activity-discount-link').click(function (e) {
      		LocationBody();
            var ids_rep = $(this).attr("data-id")
            wait();
            console.log(ids_rep);
            $.get(
                    'index.php?r=Payment/payment/discount',
                    {
                       ids_rep
                    },
                    function (data)
                    {   
                        $('#_form_payment').waitMe('hide');
                        $('#form_discount').find('.modal-body').html(data);
                        $('#data_discount').html(data);
                        $('#form_discount').modal('show');
                    }
            );
        });
        $('.activity-delete-link').click(function (e) {
        	LocationBody();
            var ids_rep = $(this).attr("data-id")
            wait();
            console.log(ids_rep);
            swal({   
                title: "",   
                text: "ยืนยันคำสั่ง?",   
                type: "error",   
                showCancelButton: true,   
                confirmButtonColor: "#53a93f",   
                confirmButtonText: "Confirm",   
                closeOnConfirm: false
        	},function(){
            $.get(
                    'index.php?r=Payment/payment/delete-discount',
                    {
                       ids_rep
                    },
                    function (data)
                    {   
	                    $('#_form_payment').waitMe('hide');
	                    swal("Success","", "success");
	                    $.pjax.reload({container:'#pjax_body'});
                    
                    }
            );
            });
            $('#_form_payment').waitMe('hide'); 
        }); 
    }    
});         
    
   	function LocationBody() {
    	$("html, body").animate({ scrollTop: $('#pjax_body').offset().top -50}, 10);
	}  
    function wait(){
            var current_effect = 'ios';
            run_waitMe(current_effect);
            function run_waitMe(effect) {
                $('#_form_payment').waitMe({
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