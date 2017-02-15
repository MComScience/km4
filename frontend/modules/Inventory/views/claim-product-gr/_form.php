<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
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
/* @var $this yii\web\View */
/* @var $model app\modules\Inventory\models\TbGr2Temp */
/* @var $form yii\widgets\ActiveForm */
//echo $modelST['STID'];
if (empty($view)){
  $actions = 'index';
}else{
  $actions = 'history'; 
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
           <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('บันทึกใบรับสินค้าเคลม') ?>
                    </a>
                </li>
            </ul> 
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
<!-----------------------------------------START Header Claim_GR----------------------------------------> 
						<?php if (empty($view)) { ?>                        
                        <div class="tb-gr2-temp-form">
                           <?php
                            $form = ActiveForm::begin([
                                        'id' => 'tbgr2temp_form',
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                        'formConfig' => [
                                            'labelSpan' => 4,
                                            'columns' => 6,
                                            'deviceSize' => ActiveForm::SIZE_SMALL,
                                        ],
                                        'options' => ['enctype' => 'multipart/form-data']
                            ]);
                            ?>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                        $form->field($modelGR, 'GRNum')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white'
                                        ])->label('หมายเลขรับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                        $form->field($modelGR, 'GRDate')->widget(yii\jui\DatePicker::classname(), [
                                            'language' => 'th',
                                            'dateFormat' => 'dd/MM/yyyy',
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'style' => 'background-color: #FFFF99',
                                            ],
                                        ])->label('วันที่รับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                       $form->field($modelGR, 'GRTypeID')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white',
                                            'value' => $modelGR->grtype->GRType,
                                        ])->label('ประเภทการรับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                        $form->field($modelGR, 'StkID')->widget(\kartik\widgets\Select2::classname(), [
                                            'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\TbStk::find()->all(), 'StkID', 'StkName'),
                                            'options' => ['placeholder' => 'เลือกคลังสินค้า...'],
                                            'pluginOptions' => [
                                                'allowClear' => true,
                                            ],
                                        ])->label('รับเข้าคลัง'.'<font color="red">*</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>    
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                        $form->field($modelST, 'STNum')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white'
                                        ])->label('หมายเลขใบโอน', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                        $form->field($modelST, 'STDate')->widget(yii\jui\DatePicker::classname(), [
                                            'language' => 'th',
                                            'dateFormat' => 'dd/MM/yyyy',
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'style' => 'background-color: white',
                                            ],
                                        ])->label('วันที่โอนสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                     <?=
                                        $form->field($modelST, 'STDueDate')->widget(yii\jui\DatePicker::classname(), [
                                            'language' => 'th',
                                            'dateFormat' => 'dd/MM/yyyy',
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'style' => 'background-color: white',
                                            ],
                                        ])->label('วันที่ส่งมอบ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelGR, 'VenderID')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'placeholder' => 'คลิกเพื่อเลือก...',
                                    ])->label('รหัสผู้ขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                    $form->field($modelGR, 'datavender')->textInput([
                                        'maxlength' => true,
                                        'style' => 'background-color:white',
                                        'value'=> $vendername,
                                        'readonly'=>true,
                                        ])->label('ชื่อผู้ขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                     <?=
                                    $form->field($modelGR, 'VenderInvoiceNum')->textInput([
                                        'maxlength' => true,
                                        //'readonly' => true,
                                        'style' => 'background-color:#FFFF99'
                                    ])->label('หมายเลขใบส่ง'.'<font color="red">*</font>', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>
                            </div>
                            <?= $form->field($modelGR, 'GRID', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelST, 'STID', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelGR, 'GRNum', ['showLabels' => false])->hiddenInput() ?>
                            <br>
<!------------------------------------------END Header Lend_GR---------------------------------------->
<!------------------------------------------START Detail Lend_GR-------------------------------------->
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดสินค้า</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ($view == 'view') { ?>                       
                        <div class="tb-gr2-temp-form">
                           <?php
                            $form = ActiveForm::begin([
                                        'id' => 'tbgr2temp_form',
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                        'formConfig' => [
                                            'labelSpan' => 4,
                                            'columns' => 6,
                                            'deviceSize' => ActiveForm::SIZE_SMALL,
                                        ],
                                        'options' => ['enctype' => 'multipart/form-data']
                            ]);
                            ?>
                            <div class="row">
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                        $form->field($modelGR, 'GRNum')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white'
                                        ])->label('หมายเลขรับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                        $form->field($modelGR, 'GRDate')->widget(yii\jui\DatePicker::classname(), [
                                            'language' => 'th',
                                            'dateFormat' => 'dd/MM/yyyy',
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'style' => 'background-color: white',
                                            ],
                                        ])->label('วันที่รับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                       $form->field($modelGR, 'GRTypeID')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white',
                                            'value' => $modelGR->grtype->GRType,
                                        ])->label('ประเภทการรับสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                        $form->field($modelGR, 'StkID')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white',
                                            'value' => $modelGR->stk->StkName,
                                        ])->label('รับเข้าคลัง', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>     
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                        $form->field($modelST, 'STNum')->textInput([
                                            'maxlength' => true,
                                            'readonly' => true,
                                            'style' => 'background-color:white'
                                        ])->label('หมายเลขใบโอน', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                        $form->field($modelST, 'STDate')->widget(yii\jui\DatePicker::classname(), [
                                            'language' => 'th',
                                            'dateFormat' => 'dd/MM/yyyy',
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'style' => 'background-color: white',
                                            ],
                                        ])->label('วันที่โอนสินค้า', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                     <?=
                                        $form->field($modelST, 'STDueDate')->widget(yii\jui\DatePicker::classname(), [
                                            'language' => 'th',
                                            'dateFormat' => 'dd/MM/yyyy',
                                            'clientOptions' => [
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ],
                                            'options' => [
                                                'class' => 'form-control',
                                                'style' => 'background-color: white',
                                            ],
                                        ])->label('วันที่ส่งมอบ', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>
                                <div class="col-xs-6 col-sm-4">
                                    <?=
                                    $form->field($modelGR, 'VenderID')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'placeholder' => 'คลิกเพื่อเลือก...',
                                    ])->label('รหัสผู้ขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                    <?=
                                    $form->field($modelGR, 'datavender')->textInput([
                                        'maxlength' => true,
                                        'style' => 'background-color:white',
                                        'value'=> $vendername,
                                        'readonly'=>true,
                                        ])->label('ชื่อผู้ขาย', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                     <?=
                                    $form->field($modelGR, 'VenderInvoiceNum')->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])->label('หมายเลขใบส่ง', ['class' => 'col-sm-4 control-label no-padding-right'])
                                    ?>
                                </div>
                            </div>
                            <?= $form->field($modelGR, 'GRID', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelST, 'STID', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelGR, 'GRNum', ['showLabels' => false])->hiddenInput() ?>
                            <br>
<!------------------------------------------END Header Lend_GR---------------------------------------->
<!------------------------------------------START Detail Lend_GR-------------------------------------->
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดสินค้า</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                </div>
                            </div>
                            <?php } ?>
<!-------------------------------START Detail GR Donate IF Create and Edit---------------------------------->
                             <?php if (empty($view)) { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'gr_claim_detail']) ?>
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
                                        //'layout' => "{summary}\n{items}\n{pager}",
                                         'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รหัสสินค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
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
                                                'header' => 'รายการสินค้า',
                                                'value' => function ($model) {
                                                    if ($model->ItemID== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->ItemName;

                                                    }   
                                                }
                                            ],
//-------------------------------------------START ส่งเคลม----------------------------------------------------------                                                    
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                 'value' => function ($model) {
                                                    if ($model->dataview->POQty == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->POQty;

                                                    }   
                                                }
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ส่งเคลม',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                                    if ($model->dataview->POUnitCost == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->POUnitCost;

                                                    }   
                                                }
                                                
                                            ],
                                            [
                                               'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'รวมเป็นเงิน',
                                                'value' => function ($model) {
                                                    if ($model->dataview->POUnit == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->POUnit;

                                                    }   
                                                }
                                            ],
                                            
//------------------------------------------------END ส่งเคลม----------------------------------------------------
//------------------------------------------------START รับแล้ว-------------------------------------------------
                                             [   
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รับแล้ว',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                 'value' => function ($model) {
                                                    if ($model->dataview->GRReceivedQty == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRReceivedQty;

                                                    }   
                                                }
                                                
                                            ],
//-----------------------------------------------END รับแล้ว----------------------------------------------------- 
//-----------------------------------------------START รับครั้งนี้------------------------------------------------ 
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                 'value' => function ($model) {
                                                    if ($model->dataview->GRQty == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRQty;

                                                    }   
                                                }
                                                
                                            ],        
                                            [
                                               'headerOptions' => ['style' => 'text-align:right;background-color: #ddd;color:#000000;'],
                                                'header' => 'รับครั้งนี้',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRUnitCost == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRUnitCost;

                                                    }   
                                                }
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:right;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'รวมเป็นเงิน',
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRUnit == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRUnit;

                                                    }   
                                                }
                                            ],        
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => TRUE,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRExtenedCost == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRExtenedCost;

                                                    }   
                                                }
                                            ],
//-------------------------------------------END รับครั้งนี้-----------------------------------------------------
//-------------------------------------------START ค้างส่ง------------------------------------------------------
                                            // [
                                            //     'headerOptions' => ['style' => 'text-align:center;background-color: #ddd'],
                                            //     'header' => 'ค้างส่ง',
                                            //     'format' => ['decimal', 2],
                                            //     'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                            //     'pageSummary' => 'บาท',
                                            //     'value' => function ($model) {
                                            //         if ($model->dataview->GRLeftQty == NULL) {
                                            //             return '0';
                                            //         } else {

                                            //             return $model->dataview->GRLeftQty;

                                            //         }   
                                            //     }
                                            // ],
                                             [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ค้างส่ง',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'บาท',
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRReceivedQty == NULL || $model->dataview->GRReceivedQty == 0 ) {
                                                        if($model->dataview->GRQty == NULL || $model->dataview->GRQty == 0){
                                                            return $model->dataview->POQty;
                                                        }else{
                                                            $num_poqty = $model->dataview->POQty;
                                                            $num_grqty   = $model->dataview->GRQty;
                                                            $left_qty = $num_poqty-$num_grqty;
                                                            return $left_qty;
                                                        }
                                                        return $model->dataview->POQty;
                                                    } else {
                                                            $num_grqty = $model->dataview->GRQty;
                                                            $num_poqty = $model->dataview->POQty;
                                                            $num_receive = $model->dataview->GRReceivedQty;
                                                            $sum_receive = $num_receive+$num_grqty;
                                                            $left_qty = $num_poqty-$sum_receive;
                                                        return $left_qty;

                                                    }   
                                                }
                                            ],    
//----------------------------------------------END ค้างส่ง--------------------------------------------------------
                                             [
                                                'class' => 'kartik\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'noWrap' => true,
                                                //'pageSummary' => 'บาท',
                                                'options' => ['style' => 'width:100px;'],
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'template' => ' {select} {edit}',
                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                'buttons' => [
                                                        'select' => function ($url, $model, $key) {
                                                        	if($model->dataview->POQty == $model->dataview->GRReceivedQty){
                                                        		return Html::a('Select', "#", [
                                                                    'title' => Yii::t('app', 'Select'),
                                                                    'class' => 'btn btn-success btn-xs',
                                                                    'disabled' => true,
                                                                    'data-toggle' => 'modal',
                                                                ]);

															}else{
																if ($model->dataview->GRQty == NULL) {
	                                                                return Html::a('<span class="btn btn-success btn-xs">Select</span>', '#', [
	                                                                    'class' => 'activity-select-link',
	                                                                    'title' => 'Select',
	                                                                    'data-toggle' => 'modal',
	                                                                    'data-id' => $key,
	                                                                ]);
	                                                            }else {
	                                                                return Html::a('Select', "#", [
	                                                                    'title' => Yii::t('app', 'Select'),
	                                                                    'class' => 'btn btn-success btn-xs',
	                                                                    'disabled' => true,
	                                                                    'data-toggle' => 'modal',
	                                                                ]);
	                                                            }
															}
                                                            
                                                        },
                                                        'edit' => function ($url, $model ,$key) {
                                                       	if($model->dataview->POQty == $model->dataview->GRReceivedQty){
                                                       		return Html::a('Edit', "#", [
                                                                    'title' => Yii::t('app', 'Edit'),
                                                                    'class' => 'btn btn-info btn-xs',
                                                                    'disabled' => true,
                                                                    'data-toggle' => 'modal',
                                                                ]);
                                                       	}else{
                                                       		if ($model->dataview->GRQty != NULL) {
                                                                return Html::a('<span class="btn btn-info btn-xs"> Edit </span> ', '#', [
                                                                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                    'title' => Yii::t('app', 'Edit'),
                                                                    'data-toggle' => 'modal',
                                                                    'class' => 'activity-edit-link',
                                                                ]);
                                                            }else {
                                                                return Html::a('Edit', "#", [
                                                                    'title' => Yii::t('app', 'Edit'),
                                                                    'class' => 'btn btn-info btn-xs',
                                                                    'disabled' => true,
                                                                    'data-toggle' => 'modal',
                                                                ]);
                                                            }
                                                       	}
                                                            
                                                    },
                                                ],

                                            ],
                                            [
                                                'class' => '\kartik\grid\DataColumn',
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'width' => '10px',
                                                'hidden' => true,
//                                                'value' => function ($model, $key, $index, $widget) {
//                                                    return '-';
//                                                },
                                                'group' => true, // enable grouping
                                                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                    return [
                                                        'mergeColumns' => [
                                                            [1, 2],
                                                            [12, 13],
                                                            
                                                        ], // columns to merge in summary
                                                        'content' => [// content to show in each summary cell
                                                            1 => '',
                                                            3 => 'จำนวน',
                                                            4 => 'ราคา/หน่วย',
                                                            5 => 'หน่วย',
                                                            6 => 'จำนวน',
                                                            7 => 'จำนวน',
                                                            8 => 'ราคา/หน่วย',
                                                            9 => 'หน่วย',
                                                            10 => 'ราคารวม',
                                                            11 => 'จำนวน',
                                                        ],
                                                        'contentOptions' => [// content html attributes for each summary cell
                                                            0 => ['style' => 'background-color: #ddd'],
                                                            1 => ['style' => 'background-color: #ddd'],
                                                            3 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            4 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            5 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            6 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            7 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            8 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            9 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            10 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            11 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            12 => ['style' => 'background-color: #ddd'],
                                                        ],
                                                        // html attributes for group summary row
                                                        'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                                                    ];
                                                }
                                                    ],
                                        ],
                                    ])
                                    ?>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                            <?php } ?>
<!----------------------------------END Detail GR Donate IF Create and Edit----------------------------------->
<!------------------------------------START Detail GR Donate IF ViewDetail------------------------------------>
                            <?php if ($view == 'view') { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'gr_claim_detail']) ?>
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
                                        //'layout' => "{summary}\n{items}\n{pager}",
                                        'layout' => Yii::$app->componentdate->layoutgridview(),
                                         'headerRowOptions' => ['class' => GridView::TYPE_SUCCESS],
                                        //'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_DEFAULT],
                                        'columns' => [
                                            [
                                                'class' => 'kartik\grid\SerialColumn',
                                                'contentOptions' => ['class' => 'kartik-sheet-style'],
                                                'width' => '36px',
                                                'header' => 'ลำดับ',
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
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
                                                'detailUrl' => \yii\helpers\Url::to(['view-lotnumber']),
                                                    
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รหัสสินค้า',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
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
                                                'header' => 'รายการสินค้า',
                                                'value' => function ($model) {
                                                    if ($model->ItemID== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->ItemName;

                                                    }   
                                                }
                                            ],
//-------------------------------------------START ส่งเคลม----------------------------------------------------------                                                    
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                 'value' => function ($model) {
                                                    if ($model->dataview->POQty == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->POQty;

                                                    }   
                                                }
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ส่งเคลม',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                                    if ($model->dataview->POUnitCost == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->POUnitCost;

                                                    }   
                                                }
                                                
                                            ],
                                            [
                                               'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'รวมเป็นเงิน',
                                                'value' => function ($model) {
                                                    if ($model->dataview->POUnit == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->POUnit;

                                                    }   
                                                }
                                            ],
                                            
//------------------------------------------------END ส่งเคลม----------------------------------------------------
//------------------------------------------------START รับแล้ว-------------------------------------------------
                                             [   
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'รับแล้ว',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                 'value' => function ($model) {
                                                    if ($model->dataview->GRReceivedQty == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRReceivedQty;

                                                    }   
                                                }
                                                
                                            ],
//-----------------------------------------------END รับแล้ว----------------------------------------------------- 
//-----------------------------------------------START รับครั้งนี้------------------------------------------------ 
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                 'value' => function ($model) {
                                                    if ($model->dataview->GRQty == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRQty;

                                                    }   
                                                }
                                                
                                            ],        
                                            [
                                               'headerOptions' => ['style' => 'text-align:right;background-color: #ddd;color:#000000;'],
                                                'header' => 'รับครั้งนี้',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRUnitCost == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRUnitCost;

                                                    }   
                                                }
                                                
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:right;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'รวมเป็นเงิน',
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRUnit == NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRUnit;

                                                    }   
                                                }
                                            ],        
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => '',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => TRUE,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRExtenedCost == NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRExtenedCost;

                                                    }   
                                                }
                                            ],
//-------------------------------------------END รับครั้งนี้-----------------------------------------------------
//-------------------------------------------START ค้างส่ง------------------------------------------------------
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'header' => 'ค้างส่ง',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'บาท',
                                                'value' => function ($model) {
                                                    $GR = $model->dataview->GRReceivedQty;
                                                    $PO = $model->dataview->POQty;
                                                    $sum = $PO-$GR;
                                                    return $sum;
                                                    // if ($model->dataview->GRReceivedQty == NULL || $model->dataview->GRReceivedQty == 0 ) {
                                                    //     if($model->dataview->GRQty == NULL || $model->dataview->GRQty == 0){
                                                    //         return $model->dataview->POQty;
                                                    //     }else{
                                                    //         $countsss = $model->dataview->POQty;
                                                    //         $qdqwtq   = $model->dataview->GRQty;
                                                    //         $summarrr = $countsss-$qdqwtq;
                                                    //         return $summarrr;
                                                    //     }
                                                    //     return $model->dataview->POQty;
                                                    // } else {
                                                    //         $sdher = $model->dataview->GRQty;
                                                    //         $claimQty = $model->dataview->POQty;
                                                    //         $grqryafter = $model->dataview->GRReceivedQty;
                                                    //         $yuiasd = $grqryafter+$sdher;
                                                    //         $sumclaimandgr = $claimQty-$yuiasd;
                                                    //     return $sumclaimandgr;

                                                    // }   
                                                }
                                            ],  
//----------------------------------------------END ค้างส่ง--------------------------------------------------------
                                            
                                            [
                                                'class' => '\kartik\grid\DataColumn',
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'width' => '10px',
                                                'hidden' => true,
//                                                'value' => function ($model, $key, $index, $widget) {
//                                                    return '-';
//                                                },
                                                'group' => true, // enable grouping
                                                'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                                                    return [
                                                        'mergeColumns' => [
                                                            [1, 2],
                                                            [12, 13],
                                                            
                                                        ], // columns to merge in summary
                                                        'content' => [// content to show in each summary cell
                                                            1 => '',
                                                            4 => 'จำนวน',
                                                            5 => 'ราคา/หน่วย',
                                                            6 => 'หน่วย',
                                                            7 => 'จำนวน',
                                                            8 => 'จำนวน',
                                                            9 => 'ราคา/หน่วย',
                                                            10 => 'หน่วย',
                                                            11 => 'ราคารวม',
                                                            12 => 'จำนวน',
                                                        ],
                                                        'contentOptions' => [// content html attributes for each summary cell
                                                            0 => ['style' => 'background-color: #ddd'],
                                                            1 => ['style' => 'background-color: #ddd'],
                                                            3 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            4 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            5 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            6 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            7 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            8 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            9 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            10 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            11 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            12 => ['style' => 'background-color: #ddd'],
                                                        ],
                                                        // html attributes for group summary row
                                                        'options' => ['class' => 'default', 'style' => 'font-weight:bold;']
                                                    ];
                                                }
                                                    ],
                                        ],
                                    ])
                                    ?>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                            <?php } ?>
                            <br><br>
<!----------------------------------END Detail GR Donate IF ViewDetail----------------------------------------> 
<!----------------------------------END Detail GR Donate------------------------------------------------------>
                            <div class="form-group" style="text-align: right">
                                <?= Html::a('Close', [$actions], ['class' => 'btn btn-default']) ?>
                                <?php if (empty($view)) { ?>
                                    <a class="btn btn-danger" id="Clear" onclick="Clear();">Clear</a>
                                    <?= Html::submitButton($modelGR->isNewRecord ? Yii::t('app', 'Save Draft') : Yii::t('app', 'Save Draft'), ['class' => $modelGR->isNewRecord ? 'btn btn-success' : 'btn btn-success']) ?>
                                    <a class="btn btn-info" id="ReceiveToStock" onclick="ReceiveToStock();">Save & Receive To Stock</a>
                                <?php } ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="horizontal-space"></div>
    </div>
</div>
<!----------------------------------------------------START MODAL ALL------------------------------------>
<?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'getdatavendor',
                    'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                    'size' => 'modal-lg modal-primary',
                ]);
                ?>
                <div id="datavendor">
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                </div>
                <?php \yii\bootstrap\Modal::end(); ?>

                <?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'SelectTableTpu',
                    'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                    'size' => 'modal-lg modal-primary',
                ]);
                ?>
                <div id="data">
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                </div>
                <?php \yii\bootstrap\Modal::end(); ?>


                <?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'modaledit',
                    'header' => '<h4 class="modal-title"></h4>',
                    'size' => 'modal-lg modal-primary',
                ]);
                ?>
                <div id="datamodaledit">
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                    <h1><p> </p></h1><br>
                </div>
 <?php \yii\bootstrap\Modal::end(); ?>
<!-----------------------------------------------END MODAL ALL------------------------------------------------>
<!-----------------------------------------------START Javascript-------------------------------------------->
        <?php if (empty($view)) { ?>
            <?php
            $script = <<< JS
$(document).ready(function () {
    $("#ReceiveToStock").addClass("disabled", "disabled");
    //$("#Clear").addClass("disabled", "disabled");              
    //$('thead').addClass('bordered-success');
});
                    
// $('#tbgr2temp-venderid').click(function (e) {
//         $('#getdatavendor').modal('show');
//         run_waitMe();
//         $.ajax({
//             url: 'getdata-vendor',
//             type: 'GET',
//             dataType: 'json',
//             success: function (data) {
//                 $('.modal-body').waitMe('hide');
//                 $('#getdatavendor').find('.modal-body').html(data);
//                 $('#datavendor').html(data);
//                 $('.modal-title').html('เลือกผู้จำหน่าย');
//                 $('#getdatavendortable').DataTable({
//                         "pageLength": 7,
//                          responsive: true,
//                 });
//             }
//       });
//  });
//-------------------------------------------------------------------------START GetData TPU and ND-------------------------------------------------------
$('#getvwitemlisttpu').click(function (e) {
             wait();
             $.ajax({
                    url: 'getdata-tpu',
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                            $('#home').waitMe('hide')
                            $('#getdatavendor').find('.modal-body').html(data);
                            $('#datavendor').html(data);
                            $('.modal-title').html('เลือกรายการยาการค้า');
                            $('#getdatavendor').modal('show');
                            $('#detailgrdonatetpu').DataTable({
                                "pageLength": 7,
                                responsive: true,
                            });
                    }
            });
});
$('#getvwitemlistnd').click(function (e) {
        wait();
        $('#getdatavendor').modal('show');
        $.ajax({
            url: 'getdata-nd',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#home').waitMe('hide')
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกรายการเวชภัณฑ์');
                $('#detailgrdonatend').DataTable({
                    "pageLength": 7,
                    responsive: true,
                });
            }
        });
    });
//----------------------------------------END GetData TPU and ND-----------------------------
//-------------------------------------------START SaveDarf----------------------------------                    
$('#tbgr2temp_form').on('beforeSubmit', function(e)
    {
    wait()
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result != null)
            {
            //$(\$form).trigger('reset');
                    $('#tbgr2temp-grnum').val(result);
                    $('#ReceiveToStock').removeClass('disabled');
                    $('#home').waitMe('hide');
                    swal("SaveDraft","", "success");
            } else
            {
            $('#message').html(result);
            }
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
//----------------------------------------END SaveDarf--------------------------------------------------
//--------------------------------------START Edit and Delete form--------------------------------------    
function init_click_handlers() {
    $('.activity-select-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var STID = $("#tbst2-stid").val();
        var venderinvoicenum = $("#tbgr2temp-venderinvoicenum").val();            
        $.post(
                        'select-detail',
                        {
                            id: fID, STID:STID, venderinvoicenum:venderinvoicenum
                        },
                function (data)
                {
                  
                }
         );
    });                
    $('.activity-edit-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var STID = $("#tbst2-stid").val();
        var venderinvoicenum = $("#tbgr2temp-venderinvoicenum").val(); 
        $.post(
                        'edit-detail',
                        {
                            id: fID, STID:STID,venderinvoicenum:venderinvoicenum
                        },
                function (data)
                {
                  
                }
         );
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                //Delete
                $.post(
                        'delete-detail',
                        {
                            id: fID
                        },
                function (data)
                {
                   $.pjax.reload({container: '#gr_claim_detail'});
                }
                );
            }
        });
    });    
    }
    
    init_click_handlers(); //first run
    $('#gr_claim_detail').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    }); 
    function wait(){
         var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#home').waitMe({
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
//-------------------------------------------END Edit and Delete form------------------------------------     
JS;
        $this->registerJs($script);
       ?>
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
                        function wait(){
                         var current_effect = 'ios'; 
                                run_waitMe(current_effect);
                                function run_waitMe(effect){
                                    $('#home').waitMe({
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
                        function GetnameVendor(id) {
                        $.ajax({
                            url: "getname-vendor",
                            type: "post",
                            data: {id: id},
                            dataType: "JSON",
                            success: function (d) {
                                $("#tbgr2temp-venderid").val(d.VendorID);
                                $("#tbgr2temp-datavender").val(d.VenderName);
                                $('#getdatavendor').modal('hide');
                            }
                        });
                        }
//------------------------------START SELECT TPU and ND---------------------------------                         
                        function AddNewItemdetailtpu(ItemID) {
                        var GRID = $("#tbgr2temp-grid").val();
                        var GRNum = $("#tbgr2temp-grnum").val();
                        var ItemType = 'TPU';
                        //alert (GRID);
                        $.get(
                                'add-new-itemdetail',
                                {
                                    ItemID: ItemID, GRID: GRID, ItemType: ItemType, GRNum:GRNum
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                            } else {
                                $('#getdatavendor').modal('hide');
                                $('#getdatavendor').modal('reset');
                                alert ('Success');
                            }

                        }
                        );
                    }
                    function AddNewItemdetailND(ItemID) {
                        //alert (ItemID);
                        var GRID = $("#tbgr2temp-grid").val();
                        var GRNum = $("#tbgr2temp-grnum").val();
                        var ItemType = 'ND';
                        $.get(
                                'add-new-itemdetail',
                                {
                                    ItemID: ItemID, GRID: GRID, ItemType: ItemType, GRNum:GRNum
                                },
                        function (data)
                        {
                            if (data == 'false') {
                                Notify('รายการนี้ถูกบันทึกแล้ว!', 'top-right', '2000', 'danger', 'fa-exclamation', true);
                            } else {
                                $('#getdatavendor').modal('hide');
                                $('#getdatavendor').modal('reset');
                                alert ('Success');
                            }

                        }
                        );
                    }
//-----------------------------------START ClearForm----------------------------------------                    
    function Clear() {
                    var grid = $("#tbgr2temp-grid").val();
                    bootbox.confirm("Are you sure?", function (result) {
                        if (result) {
                            $.post(
                                    'clear-grtemp',
                                    {
                                        id: grid
                                    },
                            function (data)
                            {

                            }
                            );
                        }
                    });
    };
//----------------------------------------END ClearForm------------------------------------------------
//----------------------------------------START ReceiveToStock------------------------------------------
 function ReceiveToStock() {
 		
        var grid = $("#tbgr2temp-grid").val();
        var StkID = $('#tbgr2temp-stkid').val();
        swal({   
            title: "ReceiveToStock?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "OK",   
            closeOnConfirm: true
        },function(){
                wait();
                $.post(
                        'receive-to-stock',
                        {
                            id: grid,StkID: StkID
                        },
                function (data)
                {
                    if (data == 'false') {
                       swal("AssignLotNumberไม่ครบ","", "warning");
                     }
                     $('#home').waitMe('hide');
                }
                );
        });
         
    };
//-------------------------------------END ReceiveToStock-----------------------------------
//---------------------------------END SELECT TPU and ND------------------------------------                     
        </script>
<!---------------------------------------END Javascript---------------------------------------------->          
<?php } ?>
<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?php
            echo \kartik\widgets\Growl::widget([
                'type' => kartik\widgets\Growl::TYPE_SUCCESS,
                'title' => 'Well done!',
                'icon' => 'glyphicon glyphicon-ok-sign',
                'body' => 'Save successfully.',
                'showSeparator' => true,
                'delay' => 0,
                'pluginOptions' => [
                    'showProgressbar' => true,
                    'placement' => [
                        'from' => 'top',
                        'align' => 'right',
                    ]
                ]
            ]);
            ?>
<?php endforeach; ?>

<?php \yii\bootstrap\Modal::begin([
        'id' => 'modal_edit',
        'header' => '<h4 class="modal-title"></h4>',
        'size' => 'modal-lg modal-primary',
        'closeButton' => FALSE,
    ]);?>
        <div id="data_modal">
        <h1><p> </p></h1><br>
        <h1><p> </p></h1><br>
        <h1><p> </p></h1><br>
        <h1><p> </p></h1><br>
        <h1><p> </p></h1><br>
        </div>
<?php \yii\bootstrap\Modal::end(); ?>

