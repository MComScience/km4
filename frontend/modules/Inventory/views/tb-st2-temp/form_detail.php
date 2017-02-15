<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use frontend\assets\WaitMeAsset;
use frontend\assets\AutoNumericAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\SweetAlertAsset;
use frontend\assets\DataTableAsset;

WaitMeAsset::register($this);
AutoNumericAsset::register($this);
LaddaAsset::register($this);
SweetAlertAsset::register($this);
DataTableAsset::register($this);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="well">
            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_detail']); ?>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">รหัสสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($model, 'ItemID', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                    // 'value' => $Item['ItemID'],
                            ])
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <input type="hidden" id="ids_sr" name="ids_sr" class="form-control" value="<?php echo $ids_sr; ?>"/>
                        <input type="hidden" name="stkid" class="form-control" value="<?php echo $stkall->StkID; ?>"/>
                        <label class="col-sm-4 control-label no-padding-right">คลังสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($stkall, 'StkName', ['showLabels' => false])->textInput([
                                'style' => 'background-color: white;',
                                // 'value' => $stkid,
                                'readonly' => true,
                            ])
                            ?>
                        </div>
                    </div>


                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right">รายการสินค้า</label>
                        <div class="col-sm-10">
                            <?=
                            $form->field($model, 'ItemName', ['showLabels' => false])->textarea([
                                'rows' => 3,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                    // 'value' => $ItemDetail,
                            ])
                            ?>
                        </div> 
                    </div>
                    <br>
                    <div class="form-group">
                        <?=
                        kartik\grid\GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $searchModel,
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
                            'layout' => "\n{items}\n{pager}",
                            'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                            //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                            'columns' => [
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemInternalLotNum',
                                    'header' => '<font color="black">ItemInternalLotNum</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemInternalLotNum == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemInternalLotNum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemExternalLotNum',
                                    'header' => '<font color="black">หมายเลขการผลิต</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemExternalLotNum == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemExternalLotNum;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemExpdate',
                                    //'format' => ['date', 'php:d/m/Y'],
                                    'header' => '<font color="black">วันหมดอายุ</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemExpdate == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemExpdate;
                                }
                            }
                                ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    //'attribute' => 'PackQTY',
//                                    'header' => '<a>จำนวนแพค</a>',
//                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                    'value' => function ($model) {
//                                if ($model->PackQTY == NULL) {
//                                    return '-';
//                                } else {
//
//                                    return $model->PackQTY;
//                                }
//                            }
//                                ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    //'attribute' => 'PackItemUnitCost',
//                                    'header' => '<a>ราคา/แพค</a>',
//                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                    'value' => function ($model) {
//                                if ($model->PackItemUnitCost == NULL) {
//                                    return '-';
//                                } else {
//
//                                    return $model->PackItemUnitCost;
//                                }
//                            }
//                                ],
//                                [
//                                    'headerOptions' => ['style' => 'text-align:center'],
//                                    //'attribute' => 'PackUnit',
//                                    'header' => '<a>หน่วยแพค</a>',
//                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
//                                    'value' => function ($model) {
//                                if ($model->PackUnit == NULL) {
//                                    return '-';
//                                } else {
//
//                                    return $model->PackUnit;
//                                }
//                            }
//                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemQty',
                                    'header' => '<font color="black">จำนวน</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemQty == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemQty;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'DispUnit',
                                    'header' => '<font color="black">หน่วย</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->DispUnit == NULL) {
                                    return '-';
                                } else {

                                    return $model->DispUnit;
                                }
                            }
                                ],
                                [
                                    'headerOptions' => ['style' => 'text-align:center'],
                                    //'attribute' => 'ItemUnitCost',
                                    'header' => '<font color="black">ราคา/หน่วย</font>',
                                    'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    'value' => function ($model) {
                                if ($model->ItemUnitCost == NULL) {
                                    return '-';
                                } else {

                                    return $model->ItemUnitCost;
                                }
                            }
                                ],
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'header' => '<font color="black">Actions</font>',
                                    'noWrap' => true,
                                    //'pageSummary' => 'บาท',
                                    'options' => ['style' => 'width:100px;'],
                                    'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                    'headerOptions' => ['style' => 'text-align:center;'],
                                    'template' => ' {update}',
                                    'buttonOptions' => ['class' => 'btn btn-default'],
                                    'buttons' => [
                                        'update' => function ($url, $model, $key) {
                                            return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
                                                        'class' => 'activity-view-link1',
                                                        'title' => 'Select',
                                                        'data-toggle' => 'modal',
                                                        'data-target' => '#determinethenumber',
                                                        'data-id' => $key,
                                                        'data-pjax' => '0',
                                            ]);
                                        },
                                            ],
                                        ],
                                    ],
                                ])
                                ?>
                            </div>              
                        </div>
                        <div class="col-md-12">
                            <br>
                            <div class="form-group" style="text-align: right">
                                <button href="#" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
    <?php // echo $ItemQty; ?>
        </div>
        <script>
            function run_waitMe() {
                $('#modaledit > div').waitMe({
                    effect: 'ios',
                    text: 'Loading...',
                    bg: 'rgba(255,255,255,0.7)',
                    color: '#000',
                    onClose: function () {
                    }
                });
            }
        </script>
        <?php
        $s = <<< JS

 $('.activity-view-link1').click(function (e) {
       var  ids_sr = $('#ids_sr').val();    
       var fID = $(this).closest('tr').children('td:eq(0)').text();
       var stkid = $('#tbst2temp-stissue_stkid').val();
       var  srid = $('#srid').val();
       var itemid = $('#vwst2detailgroup-itemid').val();
       var stid = $('#stid').val();
       $.get(
                'select-num-ber',
                {
              ids_sr:ids_sr,
                    id: fID,
                stkid:stkid,
                    srid:srid,
              itemid:itemid,
                stid:stid
                },
        function (data)
        {
                if(data == 1){
                $("#determinethenumber").modal("hide");
                swal("", "lotนี้ถูกเลือกแล้ว", "warning");     
                    }
         // $.pjax.reload({container:'#lot_select'});
          $('#determinethenumber_detail').html(data);
        }
        );
    });


JS;
        $this->registerJs($s);
        ?>
