<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\helpers\ArrayHelper;
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
<div class="col-sm-12 col-md-12 col-lg-12">
        <div style="text-align: center">
            <h4><i class="glyphicon glyphicon-hand-down"></i></h4>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading bg-default"><div class="panel-title back"><?= Html::encode('รายละเอียดสินค้า') ?></div></div>
            <?=
                 kartik\grid\GridView::widget([
                     'dataProvider' => $dataProvider,
                     'bootstrap' => true,
                     'responsiveWrap' => FALSE,
                     'responsive' => true,
                     'showPageSummary' => true,
                     'hover' => true,
                     'pjax' => true,
                     'striped' => true,
                     'condensed' => true,
                     'toggleData' => false,
                     'pageSummaryRowOptions' => ['class' => 'default', 'id' => 'setting_summary_row'],
                     'layout' => "\n{items}\n{pager}",
                     'headerRowOptions' => ['class' => GridView::TYPE_DEFAULT],
                     //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                     'columns' => [
                         [
                                'class' => 'kartik\grid\SerialColumn',
                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                'width' => '36px',
                                'header' => 'ลำดับ',
                                'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'รหัสสินค้า',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->LN_Detail == null) {
                                        return '-';
                                    } else {
                                        return $model->LN_Detail;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'วันหมดอายุ',
                                'format' => ['date', 'php:d/m/Y'],
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->ItemExpDate == null) {
                                        echo '';
                                    } else {
                                        return $model->ItemExpDate;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'จำนวน',
                                'hAlign' => GridView::ALIGN_RIGHT,
                                'value' => function ($model) {
                                    if ($model->GRQty == null) {
                                        return '0.00';
                                    } else {
                                        return $model->GRQty;
                                    }
                                }
                         ],
                         [
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'header' => 'หน่วย',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'value' => function ($model) {
                                    if ($model->GRUnit == null) {
                                        return '-';
                                    } else {
                                        return $model->GRUnit;
                                    }
                                }
                         ],
                         [
                                'class' => 'kartik\grid\ActionColumn',
                                //'contentOptions' => ['style' => 'width:260px;'],
                                'options' => ['style' => 'width:90px;'],
                                'header' => 'Actions',
                                'hAlign' => GridView::ALIGN_CENTER,
                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                'template' => '{edit}',
                                'buttons' => [
                                    'edit' => function ($url, $model) {
                                        return Html::a('<span class="btn btn-info btn-xs">Edit</span>','#', [
                                                    'title' => Yii::t('app', 'Edit'),
                                                    'onclick' => "fn_edit($model->ItemInternalLotNum)",
                                       ]); 
                                    },
                                    
                                ],
                         ],
                    ],
                     
                ])
              ?>
         
        </div>
    </div>
    
    <script>
    function wait(){
        var current_effect = 'ios'; 
        run_waitMe(current_effect);
        function run_waitMe(effect){
            $('.page-content').waitMe({
            effect: 'ios',
            text: 'กำลังโหลดข้อมูล...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {}
            });
        }
    }  
    function fn_edit($key){
        var ItemInternalLotNum = $key;
        wait();
        $.post(
            'click-edit',
            {
                 ItemInternalLotNum: ItemInternalLotNum
            },
            function (data)
            {
                
                    $('#_modal_edit').trigger('reset');
                    $('.page-content').waitMe('hide');
                    $('#modal_edit').find('.modal-body').html(data);
                    $('#data_modal').html(data);
                    $('.modal-title').html('รายละเอียดสินค้า');
                    $('#modal_edit').modal('show');
                

            }
        );
    }
    </script>
<?php
$script = <<< JS
$(document).ready(function () {
    
});
JS;
$this->registerJs($script);
?>    