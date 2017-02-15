<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
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
                            $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput([
                                'maxlength' => true,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $Item['ItemID'],
                            ])
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right">คลังสินค้า</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($modelstk, 'STIssue_StkID', ['showLabels' => false])->textInput([
                                'style' => 'background-color: white;',
                                'value' => $stkid,
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
                            $form->field($modeledit, 'ItemDetail', ['showLabels' => false])->textarea([
                                'rows' => 3,
                                'readonly' => true,
                                'style' => 'background-color:white',
                                'value' => $ItemDetail,
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
                                        'layout' => Yii::$app->componentdate->layoutgridview(),
                                        //'layout' => "\n{items}\n{pager}",
                                        'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                //'attribute' => 'ItemInternalLotNum',
                                                'header' => 'ItemInternalLotNum',
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
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                //'attribute' => 'ItemExternalLotNum',
                                                'header' => 'หมายเลขการผลิต',
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
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                //'attribute' => 'ItemExpdate',
                                                //'format' => ['date', 'php:d/m/Y'],
                                                'header' => 'วันหมดอายุ',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                    if ($model->ItemExpdate == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->ItemExpdate;

                                                    }   
                                                }
                                            ],
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center'],
                                            //     //'attribute' => 'PackQTY',
                                            //     'header' => '<a>จำนวนแพค</a>',
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            //     'value' => function ($model) {
                                            //         if ($model->PackQTY == NULL) {
                                            //             return '-';
                                            //         } else {

                                            //             return $model->PackQTY;

                                            //         }   
                                            //     }
                                                
                                            // ],
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center'],
                                            //     //'attribute' => 'PackItemUnitCost',
                                            //     'header' => '<a>ราคา/แพค</a>',
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            //     'value' => function ($model) {
                                            //         if ($model->PackItemUnitCost == NULL) {
                                            //             return '-';
                                            //         } else {

                                            //             return $model->PackItemUnitCost;

                                            //         }   
                                            //     }
                                            // ],
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center'],
                                            //     //'attribute' => 'PackUnit',
                                            //     'header' => '<a>หน่วยแพค</a>',
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                            //     'value' => function ($model) {
                                            //         if ($model->PackUnit == NULL) {
                                            //             return '-';
                                            //         } else {

                                            //             return $model->PackUnit;

                                            //         }   
                                            //     }
                                            // ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                //'attribute' => 'ItemQty',
                                                'header' => 'จำนวน',
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
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                //'attribute' => 'DispUnit',
                                                'header' => 'หน่วย',
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
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                //'attribute' => 'ItemUnitCost',
                                                'header' => 'ราคา/หน่วย',
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
                                                'header' => 'Actions',
                                                'noWrap' => true,
                                                //'pageSummary' => 'บาท',
                                                'options' => ['style' => 'width:100px;'],
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'template' => ' {update}',
                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                'buttons' => [
                                                            'update' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
                                                                        'class' => 'activity-update-link',
                                                                        'title' => 'Select',
                                                                        'data-toggle' => 'modal',
                                                                        //'data-target' => '#getdatavendor',
                                                                        'data-id' => $model->ItemInternalLotNum,
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
</div>
<script>
            function run_waitMe() {
                        $('#modaledit > div').waitMe({
                            effect: 'ios',
                            text: 'กำลังโหลดข้อมูล...',
                            bg: 'rgba(255,255,255,0.7)',
                            color: '#000',
                            onClose: function () {
                            }
                        });
            }
</script>
    <?php
    $script = <<< JS
$('.activity-update-link').click(function (e) {
                        var ItemID = $("#vwst2detailgroup-itemid").val();
                        //alert (ItemID);
                        var stkid = $("#tbst2temp-stissue_stkid").val();
                        //alert (stkid);
                        var Internal = $(this).attr("data-id");
                        //alert (Internal);
                        var STID = $("#tbst2temp-stid").val();
                        //alert (STID);
                        var STNum = $("#tbst2temp-stnum").val();
                        //alert (STNum);
                        run_waitMe();
                        $.get(
                                'index.php?r=Inventory/daily-issue/select-lotnumber',
                                {
                                    ItemID: ItemID, stkid: stkid, Internal: Internal, STID:STID, STNum:STNum
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                 swal("รายการนี้ถูกบันทึกแล้ว","", "warning");
                            } else {
                                //$('#form_detail').trigger('reset');
                                $('#form_update_adjust').trigger('reset');
                                $('#modaledit > div').waitMe('hide');
                                $('#modaledit').find('.modal-body').html(data);
                                $('#datamodaledit').html(data);
                                $('.modal-title').html('กำหนดจำนวน');
                                $('#modaledit').modal('show');
                            }

                        }
                        );
        });
JS;
        $this->registerJs($script);
       ?>