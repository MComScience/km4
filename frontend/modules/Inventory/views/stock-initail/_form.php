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
if (empty($view)){
  $actions = 'index';
}else{
  $actions = 'history-stockinitail'; 
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
           <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('บันทึกตั้งต้นสินค้าคงคลัง') ?>
                    </a>
                </li>
            </ul> 
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
<!---------------------------------------------START Header StkInitail---------------------------------------->   
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
                            <div class="form-group" >
                                <?= Html::activeLabel($modelGR, 'GRNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRNum', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                
                            </div>
                             <div class="form-group" >
                                <?= Html::activeLabel($modelGR, 'GRDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
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
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">คลังสินค้า<a id="checkSTK"></a></label>
                                <?php if(!empty($_SESSION['ss_sectionid'])){ ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'StkID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\TbStk::find()->where(['SectionID'=>$_SESSION['ss_sectionid']])->all(),'StkID', 'StkName'),
                                        'options' => ['placeholder' => 'เลือกคลังสินค้า...'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?php }else{ ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'StkID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\TbStk::find()->all(),'StkID', 'StkName'),
                                        'options' => ['placeholder' => 'เลือกคลังสินค้า...'],
                                        'pluginOptions' => [
                                            'allowClear' => true,
                                        ],
                                    ])
                                    ?>
                                </div>
                                <?php } ?>
                             </div>
                             <div class="form-group" >
                                <?= Html::activeLabel($modelGR, 'GRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRTypeID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelGR->grtype->GRType,
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelGR, 'GRStatusID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRStatusID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelGR->status->GRStatusDesc,
                                    ])
                                    ?>
                                </div>
                             </div>
                             <div class="form-group" >
                            </div>
                            <?= $form->field($modelGR, 'GRID', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelGR, 'GRNum', ['showLabels' => false])->hiddenInput() ?>
                            <br>
<!---------------------------------------------END Header StkInitail---------------------------------------->
<!-------------------------------------------START Detail StkInitail---------------------------------------->                            
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดสินค้า</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                </div>
                            </div>
<!--------------------------------START Detail StkInitail IF Create and Edit-------------------------------->

                            <div class="form-group">
                                <a class="btn btn-success" id="getvwitemlisttpu"><i class="glyphicon glyphicon-plus">รายการยา</i></a>
                                <a class="btn btn-success" id="getvwitemlistnd"><i class="glyphicon glyphicon-plus">รายการเวซภัณฑ์</i></a>
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
                            <div class="form-group" >
                                <?= Html::activeLabel($modelGR, 'GRNum', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRNum', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                
                            </div>
                             <div class="form-group" >
                                <?= Html::activeLabel($modelGR, 'GRDate', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
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
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">คลังสินค้า<a id="checkSTK"></a></label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'StkID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelGR->stk->StkName,
                                    ])
                                    ?>
                                </div>
                             </div>
                             <div class="form-group" >
                                <?= Html::activeLabel($modelGR, 'GRTypeID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRTypeID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelGR->grtype->GRType,
                                    ])
                                    ?>
                                </div>
                                <?= Html::activeLabel($modelGR, 'GRStatusID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelGR, 'GRStatusID', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white',
                                        'value' => $modelGR->status->GRStatusDesc,
                                    ])
                                    ?>
                                </div>
                             </div>
                             <div class="form-group" >
                            </div>
                            <?= $form->field($modelGR, 'GRID', ['showLabels' => false])->hiddenInput() ?>
                            <?= $form->field($modelGR, 'GRNum', ['showLabels' => false])->hiddenInput() ?>
                            <br>
<!---------------------------------------------END Header StkInitail---------------------------------------->
<!-------------------------------------------START Detail StkInitail---------------------------------------->                            
                            <div class="row">
                                <h5 class="row-title before-success">รายละเอียดสินค้า</h5>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                </div>
                            </div>
<!--------------------------------START Detail StkInitail IF Create and Edit-------------------------------->
                           <?php } ?>
                            <?php if (empty($view)) { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'stk_detail']) ?>
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
                                                    if ($model->ItemName== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->ItemName;

                                                    }   
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                //'header' => 'จำนวน',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRQty== NULL) {
                                                        return '-';
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
                                                    if ($model->dataview->GRUnitCost== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRUnitCost;

                                                    }   
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                //'header' => 'หน่วย',
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'รวมเป็นเงิน',
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRUnit== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRUnit;

                                                    }   
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                //'header' => 'ราคารวม',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => TRUE,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRExtenedCost== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRExtenedCost;

                                                    }   
                                                }
                                            ],
//                                            [
//                                                'attribute' => 'GRUnit',
//                                                'hAlign' => 'right',
//                                                'headerOptions' => ['style' => 'text-align:center'],
//                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
//                                                'pageSummary' => 'รวมเป็นเงิน',
//                                            ],
//                                            [
//                                                'attribute' => 'GRExtenedCost',
//                                                'headerOptions' => ['style' => 'text-align:center'],
//                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
//                                                'hAlign' => 'right',
//                                                'pageSummary' => true
//                                                
//                                            ],
                                             [
                                                'class' => 'kartik\grid\ActionColumn',
                                                'header' => 'Actions',
                                                'noWrap' => true,
                                                'pageSummary' => 'บาท',
                                                'options' => ['style' => 'width:100px;'],
                                                'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                'template' => ' {update} {delete}',
                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                'buttons' => [
                                                            'update' => function ($url, $model, $key) {
                                                                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                            'class' => 'activity-edit-link',
                                                                            'title' => 'Edit',
                                                                            'data-toggle' => 'modal',
                                                                            'data-id' => $key,
                                                                ]);
                                                            },
                                                            'delete' => function ($url, $model ,$key) {
                                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                            'title' => Yii::t('app', 'Delete'),
                                                                            'data-toggle' => 'modal',
                                                                            'class' => 'activity-delete-link',
                                                                ]);
                                                            },
                                                ],
//                                                            'urlCreator' => function ($action, $model, $key, $index) {
//                                                            //Update
//                                                                if ($action === 'update') {
//                                                                        return Url::to(['edit-detail', 'GRID' => $model->GRID,'ItemID' => $model->ItemID,'GRNum'=>$model->GRNum]);
//                                                                }
//                                                               if ($action === 'delete') {//Delete
//                                                                    return Url::to(['delete-detail', 'id' => $model->GRID]);
//                                                                }
//                                                            }
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
                                                            [7, 8]
                                                        ], // columns to merge in summary
                                                        'content' => [// content to show in each summary cell
                                                            1 => '',
                                                            3 => 'จำนวน',
                                                            4 => 'ราคา/หน่วย',
                                                            5 => 'หน่วย',
                                                            6 => 'ราคารวม',
                                                        ],
                                                        'contentOptions' => [// content html attributes for each summary cell
                                                            0 => ['style' => 'background-color: #ddd'],
                                                            1 => ['style' => 'background-color: #ddd'],
                                                            3 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            4 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            5 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            6 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            7 => ['style' => 'background-color: #ddd']
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
<!-------------------------------------------END Detail StkInitail IF Create and Edit---------------------->
<!------------------------------------------------START Detail StkInitail IF ViewDetail-------------------->
                            <?php if ($view == 'view') { ?>
                                <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'stk_detail']) ?>
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
                                                    if ($model->ItemName== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->ItemName;

                                                    }   
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                //'header' => '<a>จำนวน</a>',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRQty== NULL) {
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
                                                    if ($model->dataview->GRUnitCost== NULL) {
                                                        return '0';
                                                    } else {

                                                        return $model->dataview->GRUnitCost;

                                                    }   
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                //'header' => '<a>หน่วย</a>',
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => 'รวมเป็นเงิน',
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRUnit== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRUnit;

                                                    }   
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;background-color: #ddd;color:#000000;'],
                                                //'header' => '<a>ราคารวม</a>',
                                                'format' => ['decimal', 2],
                                                'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                                'pageSummary' => TRUE,
                                                'value' => function ($model) {
                                                    if ($model->dataview->GRExtenedCost== NULL) {
                                                        return '-';
                                                    } else {

                                                        return $model->dataview->GRExtenedCost;

                                                    }   
                                                }
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
                                                            [7, 8]
                                                        ], // columns to merge in summary
                                                        'content' => [// content to show in each summary cell
                                                            1 => '',
                                                            4 => 'จำนวน',
                                                            5 => 'ราคา/หน่วย',
                                                            6 => 'หน่วย',
                                                            7 => 'ราคารวม',
                                                        ],
                                                        'contentOptions' => [// content html attributes for each summary cell
                                                            0 => ['style' => 'background-color: #ddd'],
                                                            1 => ['style' => 'background-color: #ddd'],
                                                            3 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            4 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            5 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            6 => ['style' => 'color:green;text-align:center;background-color: #ddd;color:#000000;'],
                                                            7 => ['style' => 'background-color: #ddd']
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
<!----------------------------------------END Detail StkInitail IF ViewDetail--------------------------------> 
<!----------------------------------------------END Detail StkInitail----------------------------------------> 
                            <?php if (empty($view)) { ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">หมายเหตุ</label>
                                    <div class="col-sm-3">
                                                        <?=
                                                        $form->field($modelGR, 'GRNote', ['showLabels' => false])->textarea([
                                                            'rows' => 3,
                                                            'style' => 'background-color:#FFFF99',
                                                        ])
                                                        ?>
                                    </div>
                            </div>
                            <?php } ?>                           
                            <?php if ($view == 'view') { ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label no-padding-right">หมายเหตุ</label>
                                    <div class="col-sm-3">
                                                        <?=
                                                        $form->field($modelGR, 'GRNote', ['showLabels' => false])->textarea([
                                                            'rows' => 3,
                                                            'style' => 'background-color:white',
                                                            'readonly'=>true,
                                                        ])
                                                        ?>
                                    </div>
                            </div>
                            <?php } ?>
                            <div class="form-group" style="text-align: right">
                                <?= Html::a('Close', [$actions], ['class' => 'btn btn-default']) ?>
                                <?php if (empty($view)) { ?>
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
<!----------------------------------------------START MODAL ALL---------------------------------------->
<?php
                \yii\bootstrap\Modal::begin([
                    'id' => 'getdatavendor',
                    'header' => '<h4 class="modal-title">เลือกรายการยาการค้า</h4>',
                    'size' => 'modal-lg modal-primary',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
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
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
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
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
                    'closeButton' => FALSE,
                    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>'
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
<!---------------------------------------------------END MODAL ALL--------------------------------------->
<!----------------------------------------------------START Javascript-------------------------------------->
        <?php if (empty($view)) { ?>
            <?php
            $script = <<< JS
$(document).ready(function () {
	$('#checkSTK').html('<font color="red">*</font>');
    $('#ReceiveToStock').addClass("disabled", "disabled");
    //$('thead').addClass('bordered-success');
});
$('#tbgr2temp-venderid').click(function (e) {
        wait();
        $.ajax({
            url: 'getdata-vendor',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#home').waitMe('hide')
                $('#getdatavendor').modal('show');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกผู้จำหน่าย');
                $('#getdatavendortable').DataTable({
                   "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                });
            }
      });
 });
//----------------------------------------START GetData TPU and ND-------------------                    
$('#getvwitemlisttpu').click(function (e) {
                var GRID = $("#tbgr2temp-grid").val();
                var StkID = $("#tbgr2temp-stkid").val();
                var GRDate = $('#tbgr2temp-grdate').val();
                if(StkID == '' || StkID == '0'){
                    swal ("กรุณาเลือกคลังสินค้า", "", "warning");
                }else{
                wait();
                $.ajax({
                    url: 'getdata-tpu',
                    type: 'GET',
                    data: {GRID: GRID,StkID:StkID,GRDate:GRDate},
                    dataType: 'json',
                    success: function (data) {
                            $('#home').waitMe('hide')
                            $('#getdatavendor').find('.modal-body').html(data);
                            $('#datavendor').html(data);
                            $('.modal-title').html('เลือกรายการยาการค้า');
                            $('#getdatavendor').modal('show');
                            $('#detailgrdonatetpu').DataTable({
                             "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                            });
                    }
            });
        }
});
$('#getvwitemlistnd').click(function (e) {
        var GRID = $("#tbgr2temp-grid").val();
        var StkID = $("#tbgr2temp-stkid").val();
        var GRDate = $('#tbgr2temp-grdate').val();
        if(StkID == '' || StkID == '0'){
                   swal ("กรุณาเลือกคลังสินค้า", "", "warning");
        }else{
        wait();
        $.ajax({
            url: 'getdata-nd',
            type: 'GET',
            data: {GRID: GRID,StkID:StkID,GRDate:GRDate},
            dataType: 'json',
            success: function (data) {
                $('#home').waitMe('hide')
                $('#getdatavendor').modal('show');
                $('#getdatavendor').find('.modal-body').html(data);
                $('#datavendor').html(data);
                $('.modal-title').html('เลือกรายการเวชภัณฑ์');
                $('#detailgrdonatend').DataTable({
                 "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                        "pageLength": 5,
                                        responsive: true,
                                        "language": {
                                            "lengthMenu": " _MENU_ ",
                                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                            "search": "ค้นหา "
                                        },
                                        "aLengthMenu": [
                                            [5, 10, 15, 20, 100, -1],
                                            [5, 10, 15, 20, 100, "All"]
                             ]
                });
            }
        });
        }
    });
//------------------------------------------------END GetData TPU and ND--------------------------------
//----------------------------------------------------START SaveDarf-----------------------------------
$('#tbgr2temp_form').on('beforeSubmit', function(e)
    {
     wait();
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
//-----------------------------------------------END SaveDarf------------------------------------------
//-----------------------------------------------START ClearForm---------------------------------------
    $('#Clear').click(function (e) {
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
    });
//-------------------------------------------END ClearForm-----------------------------
//--------------------------------------START Edit and Delete form---------------------                  
function init_click_handlers() {
    $('.activity-edit-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
                   // alert (fID);
        $.post(
                        'edit-detail',
                        {
                            id: fID
                        },
                function (data)
                {
                  
                }
         );
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        wait();
        swal({   
            title: "Are you sure?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "error",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "OK",   
            closeOnConfirm: false
        },function(){
                //Delete
                $.post(
                        'delete-detail',
                        {
                            id: fID
                        },
                function (data)
                {
                   $('#home').waitMe('hide');
                   swal("Success","", "success");
                   $.pjax.reload({container: '#stk_detail'});
                }
                );
        });$('#home').waitMe('hide');
    });    
    }
    
    init_click_handlers(); //first run
    $('#stk_detail').on('pjax:success', function () {
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
//-----------------------------------------END Edit and Delete form---------------------------------  
JS;
        $this->registerJs($script);
       ?>
        <script> 
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
//---------------------------------------START SELECT TPU and ND-------------------------                       
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
                                swal("รายการนี้ถูกบันทึกแล้ว","", "warning");
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
                                swal("รายการนี้ถูกบันทึกแล้ว","", "warning");
                            } else {
                                $('#getdatavendor').modal('hide');
                                $('#getdatavendor').modal('reset');
                                alert ('Success');
                            }

                        }
                        );
                    }
                    function ReceiveToStock() {
                        
                        var grid = $("#tbgr2temp-grid").val();
                        var StkID = $("#tbgr2temp-stkid").val();
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
                                            id: grid, StkID:StkID
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
//------------------------------------END SELECT TPU and ND---------------------------------                     
        </script>
<!--------------------------------------END Javascript------------------------------------>          
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
