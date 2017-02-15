<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\grid\GridView;
use yii\widgets\Pjax;
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
$this->title = 'บันทึกใบรับสินค้าให้ยืม';
$this->params['breadcrumbs'][] = ['label' => 'Inventory', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'รับสินค้าให้ยืม', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
           <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('Goods Receiving') ?>
                    </a>
                </li>
            </ul> 
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-pr2-form">
                            <?php
                            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_goods_receiving']);
                            ?>
<!---------------------------------START FROM Goods Receiving---------------------------------------------->                          <div class="form-group">
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($Item, 'ItemID', ['showLabels' => false])->hiddenInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">                                  
                                    <?=
                                    $form->field($Item, 'ItemName', ['showLabels' => false])->hiddenInput([
                                        //'row' => 3,
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($modelGR, 'GRItemPackSKUQty', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRItemPackSKUQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div> 
                                <div class="col-sm-1" style="display:none;">
                                    <?=
                                    $form->field($modelST, 'POItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->where(['PackUnitID' => $packst])->all(), 'PackUnitID', 'PackUnit'),
                                        'language' => 'en',
                                        'pluginOptions' => [
                                            'placeholder' => 'Select Option',
                                            'allowClear' => true,
                                        //'disabled' => true
                                        ],
                                    ])
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label no-padding-right"><b>ชื่อสินค้า:</b></label>
                                <div class="col-sm-3" style="margin-top: 8px;">
                                    <?php echo $modelST['ItemID_Name'] ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label no-padding-right"><b>ให้ยืม:</b></label>
                                <div class="col-sm-8" style="margin-top: 8px;">
                                    จำนวน&nbsp;<?php echo $modelST['POQty'] ?>&nbsp;<?php echo $modelST['POUnit'] ?>&nbsp;&nbsp;&nbsp;รับแล้ว&nbsp;<?php echo $modelST['GRReceivedQty'] ?>&nbsp;<?php echo $modelST['POUnit'] ?>&nbsp;&nbsp;&nbsp;ค้างส่ง&nbsp;<?php echo number_format($GRLeftItemQty, 2) ?>&nbsp;<?php echo $modelST['POUnit'] ?>
                                </div>
                            </div>

                        <!-- <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right"><h5 class="row-title before-success">ส่งเคลม</h5></label>
                            <div class="col-sm-3"></div>
                            <label class="col-sm-2 control-label no-padding-right"><h5 class="row-title before-success">รับครั้งนี้</h5></label>
                            <div class="col-sm-3"></div>
                        </div> -->
                            <div class="form-group" style="margin-top:8px;">
                               <label class="col-sm-2 control-label no-padding-right"><b>รับครั้งนี้:</b></label>
                                <label class="col-sm-1 control-label no-padding-right">
                                <div class="radio">
                                    <label ><span class="text">แพค  </span><input type="radio" name="แพค" id="แพค" value="yes"/><span class="text"></span></label>
                                    <!-- <label><input type="radio" checked="checked" name="แพค" id="ชิ้น" value="no"/>&nbsp;จำนวน</label> -->
                                </div>
                                </label>
                                <div class="col-sm-2">
                                    <?=
                                    $form->field($modelGR, 'GRPackQty', ['showLabels' => false])->textInput([
                                        'value' => number_format($GRPackQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                    ])
                                    ?>
                                </div>
                                <!-- <label class="col-sm-1 control-label no-padding-right">หน่วยแพค<a id="checkหน่วยแพค"></a></label> -->
                                <div class="col-sm-2">
                                   <?=
                                    $form->field($modelGR, 'GRItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                                        'language' => 'en',
                                        'pluginOptions' => [
                                            'placeholder' => 'Select Option',
                                            'allowClear' => true,
                                        //'disabled' => true
                                        ],
                                    ])
                                    ?>
                                </div>
                                <label class="col-sm-1 control-label no-padding-right">ปริมาณแพค</label>
                                <div class="col-sm-2">
                                 <input type="text" class="form-control" style="background-color: white;text-align:right" readonly="" name="PackNote" id="PackNote" value="0.00"/>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top:8px;">
                                <label class="col-sm-2 control-label no-padding-right"></label>
                                <label class="col-sm-1 control-label no-padding-right">
                                <div class="radio">
                                    <!-- <label style="margin-top:8px;"><input type="radio" name="แพค" id="แพค" value="yes"/>&nbsp;แพค</label> -->
                                    <label><span class="text">จำนวน  </span><input type="radio" checked="checked" name="แพค" id="ชิ้น" value="no"/><span class="text"></span></label>
                                </div>
                                </label>
                                <div class="col-sm-2">
                                    <?=
                                    $form->field($modelGR, 'GRItemQty', ['showLabels' => false])->textInput([
                                       'value' => number_format($GRItemQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-2" style="margin-top:8px;">
                                    <?php echo $DispUnit ?>
                                </div>
                                <label class="col-sm-1 control-label no-padding-right">ค้างส่ง</label>
                                <div class="col-sm-2">
                                 <input type="text" class="form-control" style="background-color: white;text-align:right" readonly="" name="has" id="has" value="0.00"/>
                                </div>
                                <div class="col-sm-1" style="margin-top:8px;">
                                    <?php echo $modelST['POUnit']; ?>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: right">
                                <div class="col-sm-8">
                                </div>
                                <div class="col-sm-2">
                                <a class="btn btn-danger" id="Clear">Clear</a>
                                <?= Html::submitButton($modelGR->isNewRecord ? 'Receive' : 'Receive', ['class' => $modelGR->isNewRecord ? 'btn btn-success draft' : 'btn btn-success draft', 'id' => 'Receive']) ?> 
                                </div>
                            </div>           
                            <div class="form-group">
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelST, 'POPackQtyApprove', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($STPackQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly'=>true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelST, 'STItemSKUQty', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($STItemSKUQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelST, 'POPackUnitCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($STPackUnitCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelGR, 'GRPackUnitCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRPackUnitCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelST, 'POQty', ['showLabels' => false])->hiddenInput([
                                       'value' => number_format($STItemQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly'=>true,
                                    ])
                                    ?>
                            </div>
                             <div class="col-sm-1">
                                    <?=
                                    $form->field($modelST, 'POUnitCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($STItemUnitCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelGR, 'DispUnit', ['showLabels' => false])->hiddenInput([
                                        'value' => $DispUnit,
                                        'readonly' => true,
                                        'style' => 'background-color: white;text-align:right',
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                  <?=
                                    $form->field($modelST, 'GRExtenedCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($STExtenedCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">        
                                   <?=
                                    $form->field($modelGR, 'GRItemUnitCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRItemUnitCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                    <?=
                                    $form->field($modelST, 'GRReceivedQty', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRReceivedQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">        
                                    <?=
                                    $form->field($modelGR, 'GRExtenedCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRExtenedCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <div class="col-sm-1">
                                     <?=
                                    $form->field($modelGR, 'GRLeftQty', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRLeftItemQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                            </div>
                            <input type="hidden" class="form-control" name="idst" id="idst" value="<?php echo $idst; ?>"/>
                            <input type="hidden" class="form-control" name="GRID" id="GRID" value="<?php echo $GRID; ?>"/>
                            <input type="hidden" class="form-control" name="GRNum" id="GRNum" value="<?php echo $GRNum; ?>"/>
                            <input type="hidden" class="form-control" name="PackGR" id="PackGR" value="<?php echo $packgr; ?>"/>
                            <input type="hidden" class="form-control" name="PackST" id="PackST" value="<?php echo $packst; ?>"/>
                            <input id="ids_gr" type="hidden" value=""/>
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
<!----------------------------------END FROM Goods Receiving-------------------------------------------------->
<!----------------------------------START FROM LOT ASSIGN---------------------------------------------------->
<div class="row" id="AssignLots">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tabbable">
           <ul class="nav nav-tabs" id="myTab">
                <li class="tab-success active">
                    <a data-toggle="tab" href="#home">
                        <?= Html::encode('Assign Lot Number') ?>
                    </a>
                </li>
            </ul> 
            <div class="tab-content bg-white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-pr2-form">
                            <?php
                            $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_lot_assign']);
                            ?>
                             <div class="form-group" >
                             <label class="col-sm-2 control-label no-padding-right"></label><div class="col-sm-3"></div>
                             <label class="col-sm-2 control-label no-padding-right"></label>
                                <div class="col-sm-3" style="display: none;">
                                <div class="radio">
                                   <label><input type="radio" name="แพค" id="แพคlot" value="no"/><span class="text"></span></label>
                                   <label><input type="radio" name="แพค" id="ชิ้นlot" value="no"/><span class="text"></span></label>
                                   </div>
                                </div>
                            </div>
                             <div class="form-group" >
                                <label class="col-sm-2 control-label no-padding-right">จำนวนแพค<a id="checkจำนวนแพคlot"></a></label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelLN, 'GRPackQty', ['showLabels' => false])->textInput([
                                        'value' => number_format($GRPackQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label no-padding-right">จำนวน<a id="checkจำนวนlot"></a></label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($modelLN, 'GRItemQty', ['showLabels' => false])->textInput([
                                       'value' => number_format($GRItemQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1" style="margin-top:8px;">
                                 <?php echo $DispUnit ?>
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">บันทึก Lot numbe แล้ว</label>
                                <div class="col-sm-2">
                                    <?=
                                    $form->field($balance, 'LNAssignedQty', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1" style="margin-top:8px;">
                                 <?php echo $modelST['POUnit'] ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label no-padding-right">หมายเลขการผลิต<a id="checkหมายเลขการผลิตlot"></a></label>
                                <div class="col-sm-3">
                                    <?=
                                    $form->field($detail, 'ItemExternalLotNum', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        //'readonly' => true,
                                        'style' => 'background-color:white'
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                </div>
                                <label class="col-sm-2 control-label no-padding-right">คงเหลือบันทึก Lot Number</label>
                                <div class="col-sm-2">
                                    <?=
                                    $form->field($balance, 'LNAssignedLeftQty', ['showLabels' => false])->textInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color: white;text-align:right',
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1" style="margin-top:8px;">
                                 <?php echo $modelST['POUnit'] ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-2 control-label no-padding-right">วันหมดอายุ<a id="checkวันหมดอายุlot"></a></label>
                                <div class="col-sm-3">
                                     <?=
                                    $form->field($detail, 'ItemExpDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                       'language' => 'th',
                                        'dateFormat' => 'dd/MM/yyyy',
                                        'clientOptions' => [
                                            'changeMonth' => true,
                                            'changeYear' => true,
                                        ],
                                        'options' => [
                                            'class' => 'form-control',
                                            'style' => 'background-color: white',
                                            'placeholder' => '',
                                        ],
                                    ])
                                    ?>
                                    
                                </div>
                                <div class="col-sm-1">
                                </div>
                                <div class="col-sm-4" style="text-align: right">
                                <?= Html::submitButton('Assign Lot Number', ['class' => 'btn btn-primary', 'id' => 'btn_assignlot']) ?>
                                <?= Html::submitButton('Update Lot Number', ['class' => 'btn btn-primary', 'id' => 'btn_updatelot']) ?>
                                </div>
                            </div>
                            <div class="form-group">
                                    <?php \yii\widgets\Pjax::begin([ 'id' => 'lot_detail','timeout' => 5000 ]) ?>
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
                                                'headerOptions' => ['class' => 'kartik-sheet-style','style'=>'color:#000000;']
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'ItemInternalLotNum',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataonview->ItemInternalLotNum != null) {
                                                            return $model->dataonview->ItemInternalLotNum;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'หมายเลขการผลิต',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataonview->ItemExternalLotNum != null) {
                                                            return $model->dataonview->ItemExternalLotNum;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'วันหมดอายุ',
                                                'format' => ['date', 'php:d/m/Y'],
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataonview->ItemExpDate != null) {
                                                            return $model->dataonview->ItemExpDate;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'จำนวน',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataonview->GRQty != null) {
                                                            return $model->dataonview->GRQty;
                                                        } else {
                                                            return '-';
                                                        }
                                                }
                                            ],
                                            [
                                                'headerOptions' => ['style' => 'text-align:center;color:#000000;'],
                                                'header' => 'หน่วย',
                                                'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                                'value' => function ($model) {
                                                        if ($model->dataonview->GRUnit != null) {
                                                            return $model->dataonview->GRUnit;
                                                        } else {
                                                            return '-';
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
                                                'template' => ' {update} {delete}',
                                                'buttonOptions' => ['class' => 'btn btn-default'],
                                                'buttons' => [
                                                            'update' => function ($url, $model, $key) {
                                                            return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                                        'class' => 'activity-edit-link',
                                                                        'title' => 'Edit',
                                                                        'data-toggle' => 'modal',
                                                                        'data-id' => $model->ids_gr,
                                                            ]);
                                                            },
                                                            'delete' => function ($url, $model ,$key) {
                                                            return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                                        //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                                        'title' => Yii::t('app', 'Delete'),
                                                                        'data-toggle' => 'modal',
                                                                        //'data-method' => "post",
                                                                        //'role' => 'modal-remote',
                                                                        'class' => 'activity-delete-link',
                                                            ]);
                                                        }
                                                ],
                                            ],
                                            ],
                                        ]);
                                    ?>
                                  <?php \yii\widgets\Pjax::end() ?>
                            </div>
                            <div class="form-group" >
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($detail, 'GRUnit', ['showLabels' => false])->hiddenInput([
                                        'maxlength' => true,
                                        'readonly' => true,
                                        'style' => 'background-color: white;text-align:right',
                                        
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1" style="display:none;">
                                  <?=
                                    $form->field($modelLN, 'GRItemPackID', ['showLabels' => false])->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(app\models\TbPackunit::find()->where(['PackUnitID' => $pack])->all(), 'PackUnitID', 'PackUnit'),
                                        'language' => 'en',
                                        'pluginOptions' => [
                                            'placeholder' => 'Select Option',
                                            'allowClear' => true,
                                        //'disabled' => true
                                        ],
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($modelLN, 'DispUnit', ['showLabels' => false])->hiddenInput([
                                        'value' => '',
                                        'readonly' => true,
                                        'style' => 'background-color: white;text-align:right',
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($modelLN, 'GRItemUnitCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRItemUnitCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($modelLN, 'GRExtenedCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRExtenedCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">
                                    <?=
                                    $form->field($modelLN, 'GRItemPackSKUQty', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRItemPackSKUQty, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div>
                                <div class="col-sm-1">    
                                    <?=
                                    $form->field($modelLN, 'GRPackUnitCost', ['showLabels' => false])->hiddenInput([
                                        'value' => number_format($GRPackUnitCost, 2),
                                        'style' => 'background-color: white;text-align:right',
                                        'readonly' => true,
                                    ])
                                    ?>
                                </div>
                             </div>
                            <div class="form-group" style="text-align: right"><br>
                                <?= Html::a('Close', ['create','GRID' => $GRID,'STID'=>$STID,'view' => ''], ['class' => 'btn btn-default']) ?>
                                <?= Html::button('Save Lot Number', ['class' => 'btn btn-success', 'id' => 'SaveLotNumber']) ?>
                            </div>
                            <input name="GRNum_lot" type="hidden" id="GRNum_lot" class="form-control" readonly=""/>
                            <input name="ItemIDlot" type="hidden" id="ItemIDlot" class="form-control" readonly=""/>
                            <input name="ids_grlot" type="hidden" id="ids_grlot" class="form-control" readonly=""/>
                            <input name="checkedit" type="hidden" id="checkedit" class="form-control" readonly=""/>
                            <input name="itemqtytemp" type="hidden" id="itemqtytemp" class="form-control" readonly=""/>
                            <input name="packqtytemp" type="hidden" id="packqtytemp" class="form-control" readonly=""/>
                            <input name="Internal" type="hidden" id="Internal" class="form-control" readonly=""/>            
                             <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      <div class="horizontal-space"></div>
    </div>
</div>
<!-----------------------------------END FROM Assign Lot Number------------------------------------------------>
<?php
    $script = <<< JS
$(document).ready(function () {
     $('#tbgritemdetail2temp-gritemqty').val('0.00');
     $('#tbgritemdetail2temp-grpackqty').val('0.00');   
     var checkpackst = $("#PackST").val();
     var checkpackgr = $("#PackGR").val();
     if (checkpackst == "" || checkpackst == "0.00") {
            var stitemqty = parseFloat($("#vwgr2detailnew-poqty").val().replace(/[,]/g, ""));
            var stitemunitcost = parseFloat($("#vwgr2detailnew-pounitcost").val().replace(/[,]/g, ""));      
            var stextencost = stitemqty*stitemunitcost;
            var gritemqty = parseFloat($("#vwgr2detail-gritemqty").val().replace(/[,]/g, ""));
            var gritemunitcost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));      
            var grextencost = stitemqty*stitemunitcost;
            $("#vwgr2detail-grextenedcost").val(addCommas(grextencost.toFixed(2)));
            $("#vwgr2detailnew-grextenedcost").val(addCommas(stextencost.toFixed(2)));  
            $("#vwgr2detail-grpackunitcost").val('0.00');
            $("#vwgr2detailnew-popackunitcost").val('0.00');
    }else{
            $("#vwgr2detailnew-poitempackid").val(checkpackst).trigger("change");
            $("#vwgr2detail-gritempackid").val(checkpackgr).trigger("change");       
            var stitemqty = parseFloat($("#vwgr2detailnew-poqty").val().replace(/[,]/g, ""));
            var stitemunitcost = parseFloat($("#vwgr2detailnew-pounitcost").val().replace(/[,]/g, ""));      
            var stextencost = stitemqty*stitemunitcost;
            $("#vwgr2detailnew-grextenedcost").val(addCommas(stextencost.toFixed(2)));  
    }
     
     document.getElementById("btn_assignlot").disabled = true;
     document.getElementById("btn_updatelot").disabled = true;
            
//-------------------------------START Pack/Unit Assign Lot NUmber---------------------------------------------
        if ($("input[id=ชิ้นlot]").is(":checked")){
                $('#checkจำนวนlot').html('<font color="red">*</font>');
                $("#tbgritemdetail2temp-grpackqty").attr('readonly', 'readonly');
                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
                $("#tbgritemdetail2temp-gritemqty").removeAttr('readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot').html('');
                $('#tbgritemdetail2temp-gritemqty').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-grpackqty').css('background-color', 'white');  
        }else if ($("input[id=แพค]").is(":checked")){
                $("#tbgritemdetail2temp-grpackqty").removeAttr('readonly');
                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
                $("#tbgritemdetail2temp-gritemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot').html('<font color="red">*</font>');
                $('#checkจำนวนlot').html('');
                $('#tbgritemdetail2temp-grpackqty').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-gritemqty').css('background-color', 'white');
        }$("input[id=แพคlot]").click(function () {
        if ($(this).is(":checked"))
        {       
                calculate();
                $("#tbgritemdetail2temp-grpackqty").removeAttr('readonly');
                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
                $("#tbgritemdetail2temp-gritemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot').html('<font color="red">*</font>');
                $('#checkจำนวนlot').html('');
                $('#tbgritemdetail2temp-grpackqty').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-gritemqty').css('background-color', 'white');
        }
        });
        $("input[id=ชิ้นlot]").click(function () {
        if ($(this).is(":checked"))
        {
                $('#checkจำนวนlot').html('<font color="red">*</font>');
                $("#tbgritemdetail2temp-grpackqty").attr('readonly', 'readonly');
                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
                $("#tbgritemdetail2temp-gritemqty").removeAttr('readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot').html('');
                $('#tbgritemdetail2temp-gritemqty').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-grpackqty').css('background-color', 'white');  
        }
        });
//------------------------------END Pack/Unit Assign Lot NUmber---------------------------------------------
//------------------------------START Pack/Unit Goods Receiving---------------------------------------------
        var CheckPack = $("#PackST").val();
        if (CheckPack == "" || CheckPack == "0.00") {
            document.getElementById("ชิ้น").checked = true;
            if ($("input[id=ชิ้น]").is(":checked"))
            {
                $('#checkจำนวน').html('<font color="red">*</font>');
                $("#vwgr2detail-grpackqty").attr('readonly', 'readonly');
                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
                $("#vwgr2detail-gritemqty").removeAttr('readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
                $('#vwgr2detail-gritemqty').css('background-color', '#FFFF99');
                $('#vwgr2detail-grpackqty').css('background-color', 'white');
            }
        } else {
            document.getElementById("แพค").checked = true;
            if ($("input[id=แพค]").is(":checked"))
            {
                $("#vwgr2detail-grpackqty").removeAttr('readonly');
                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
                $("#vwgr2detail-gritemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color="red">*</font>');
                $('#checkจำนวน').html('');
                $('#vwgr2detail-grpackqty').css('background-color', '#FFFF99');
                $('#vwgr2detail-gritemqty').css('background-color', 'white');
            }
        }
    });
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
                $("#vwgr2detail-grpackqty").removeAttr('readonly');
                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
                $("#vwgr2detail-gritemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('<font color="red">*</font>');
                $('#checkจำนวน').html('');
                $('#vwgr2detail-grpackqty').css('background-color', '#FFFF99');
                $('#vwgr2detail-gritemqty').css('background-color', 'white');
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
                $('#checkจำนวน').html('<font color="red">*</font>');
                $("#vwgr2detail-grpackqty").attr('readonly', 'readonly');
                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
                $("#vwgr2detail-gritemqty").removeAttr('readonly');
                $('#checkจำนวนแพค,#checkหน่วยแพค').html('');
                $('#vwgr2detail-gritemqty').css('background-color', '#FFFF99');
                $('#vwgr2detail-grpackqty').css('background-color', 'white');
        }
    });
//------------------------------------END Pack/Unit Goods Receiving-----------------------------------------
//------------------------------------START CALCUlATE FROM Goods Receiving----------------------------------
    //คำนวณจำนวนแพค
    $("#vwgr2detail-grpackqty").keyup(function () {
        $('#vwgr2detail-grpackqty').autoNumeric('init');
        //var packunitcost = parseFloat($("#vwgr2detail-grpackunitcost").val().replace(/[,]/g, ""));
        var uni = parseFloat($("#vwgr2detail-grpackqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2detail-gritempackskuqty").val().replace(/[,]/g, ""));
        var grunitcost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
        var stpackqty = parseFloat($("#vwgr2detail-grleftqty").val().replace(/[,]/g, ""));
        var result =  (stpackqty)-(uni);
        var jj = uni * orq;
        var Total = jj * grunitcost;
        //var unitcost = packunitcost / orq;
        if (orq == "0" || orq == "0.00" ) {
            $("#vwgr2detail-gritemqty").val(addCommas(uni.toFixed(2)));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
            //$("#vwgr2detail-gritemunitcost").val(addCommas(unitcost.toFixed(2)));
            $("#vwgr2detail-gritemqty").val(addCommas(jj.toFixed(2)));
            $("#vwgr2detail-grextenedcost").val(addCommas(Total.toFixed(2)));
        }
        $("#has").val(addCommas(result.toFixed(2)));
        if(result < 0){
                swal("เกินจำนวนที่ค้างส่ง","","warning");
                //alert ('รับครั้งนี้เกินจำนวนค้างส่งของการให้ยืม?');
                $("#vwgr2detail-grpackqty").val(addCommas(stpackqty.toFixed(2)));
                var packqty = parseFloat($("#vwgr2detail-grpackqty").val().replace(/[,]/g, ""));
                //alert (packqty);
                var packskuqty = parseFloat($("#vwgr2detail-gritempackskuqty").val().replace(/[,]/g, ""));
                //alert (packskuqty);
                var itemqty = (packqty)*(packskuqty);
                //alert (itemqty);
                $("#vwgr2detail-gritemqty").val(addCommas(itemqty.toFixed(2)));
                var itemunitcost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
                var extend = itemqty*itemunitcost;
                $("#vwgr2detail-grextenedcost").val(addCommas(extend.toFixed(2)));
                $("#has").val('0.00');
        }
    });
    $('#vwgr2detail-gritempackid').on('change', function () {
        var ItemID = $("#vwitemlist-itemid").val();
        var ItemPackUnit = $(this).find("option:selected").val();
        var qty = parseFloat($("#vwgr2detail-grpackqty").val().replace(/[,]/g, ""));
        
        $.ajax({
            url: "get-qty",
            type: "post",
            data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
            dataType: 'json',
            success: function (data) {
                $('#vwgr2detail-gritempackskuqty').val(data.ItemPackSKUQty);
                $('#PackNote').val(data.PackNote);
                var GRUnitCost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
                var packunitcost = parseFloat($("#vwgr2detail-grpackunitcost").val().replace(/[,]/g, ""));
                var SKUQty = parseFloat($("#vwgr2detail-gritempackskuqty").val().replace(/[,]/g, ""));
                var jj = (SKUQty) * (qty);
                //var Total = jj * GRUnitCost;
                var unitcost = packunitcost / SKUQty;
                if (data.qty == 0) {
                    $('#vwgr2detail-gritemqty').val();
                } else {
                    
                    $("#vwgr2detail-gritemqty").val(addCommas(jj.toFixed(2)));
                    $("#vwgr2detail-gritemunitcost").val(addCommas(unitcost.toFixed(2)));
                    var itemunitcost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
                    var Total = jj * itemunitcost;
                    $("#vwgr2detail-grextenedcost").val(addCommas(Total.toFixed(2)));
                }
            }
        });
    });
    //คำนวณราคาต่อแพค
    $("#vwgr2detail-grpackunitcost").keyup(function () {
        $('#vwgr2detail-grpackunitcost').autoNumeric('init');
        var qty = $("#vwgr2detail-gritemqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwgr2detail-grpackunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2detail-gritempackskuqty").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwgr2detail-grextenedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwgr2detail-gritemunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2detail-gritemunitcost").val('0.00');
        }
    });
    //คำนวณจำนวน
    $("#vwgr2detail-gritemqty").keyup(function () {
        $('#vwgr2detail-gritemqty').autoNumeric('init');
        var uni = parseFloat($("#vwgr2detail-gritemqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
        var stitemqty = parseFloat($("#vwgr2detail-grleftqty").val().replace(/[,]/g, ""));
        var result =  (stitemqty)-(uni);
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwgr2detail-grextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2detail-grextenedcost").val('0.00');
        }
        $("#has").val(addCommas(result.toFixed(2)));
        if(result < 0){
                swal("เกินจำนวนที่ค้างส่ง","","warning");
                $("#vwgr2detail-gritemqty").val(addCommas(stitemqty.toFixed(2)));
                var itemqty = parseFloat($("#vwgr2detail-gritemqty").val().replace(/[,]/g, ""));
                var itemunitcost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
                var extend = itemqty*itemunitcost;
                $("#vwgr2detail-grextenedcost").val(addCommas(extend.toFixed(2)));
                $("#has").val('0.00');
        }
    });
    //คำนวณราคาต่อหน่วย
    $("#vwgr2detail-gritemunitcost").keyup(function () {
        $('#vwgr2detail-gritemunitcost').autoNumeric('init');
        var uni = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2detail-gritemqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwgr2detail-grextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2detail-grextenedcost").val('0.00');
        }
    });
//--------------------------END CALCUlATE FROM Goods Receiving---------------------------------------
//--------------------------START SUBMIT FROM GOODS RECEIVING----------------------------------------
   $('#form_goods_receiving').on('beforeSubmit', function(e)
    {
      waitGR();
      var GRNum = $("#GRNum").val();
      $("#GRNum_lot").val(GRNum);
      var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            var ids_gr = result;
            //alert (ids_gr);
            $("#ids_gr").val(ids_gr);
            document.getElementById("Receive").disabled = true;
            document.getElementById("btn_assignlot").disabled = false;
            Receive();
            LocationHash();
            swal("Receive","", "success"); 
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
    function LocationHash() {
        $("html, body").animate({ scrollTop: $('#AssignLots').offset().top -50}, 1000);
    }
    function LocationGR() {
        $("html, body").animate({ scrollTop: $('#form_goods_receiving').offset().top -200}, 1000);
    }
//------------------------------END SUBMIT FROM GOODS RECEIVING---------------------------------------------
 //------------------------------START SUBMIT FROM Assign LotNumber-----------------------------------------
$('#form_lot_assign').on('beforeSubmit', function(e)
    {   wait();
        var checkedit = $("#checkedit").val();
        //alert ('Submit');
        var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == "success"){
                document.getElementById("Receive").disabled = true;
                if(checkedit=="no"){
                    GetBalance();
                    swal("Assign Lot Number Successfully","", "success");
                }
                else if (checkedit=="yes"){
                    document.getElementById("btn_updatelot").disabled = true;
                    GetBalanceEdit();
                    swal("Update Lot Number Successfully","", "success");
                    if ($('#แพคlot').is(':checked')) {
                        $('#tbgritemdetail2temp-grpackqty,#tbgritemdetail2temp-grpackunitcost,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', 'white');
                        $('#tbgritemdetail2temp-grpackqty,#tbgritemdetail2temp-grpackunitcost,#tbgritemdetail2temp-gritempackskuqty').val('0.00');
                        $('#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost,#tbgritemdetail2temp-grextenedcost').val('0.00');
                        $('#checkจำนวนแพคlot,#checkหน่วยแพคlot,#checkราคาต่อแพคlot,#checkหมายเลขการผลิตlot,#checkวันหมดอายุlot').html('');
                        $('#vwgr2lotassigneddetail-itemexternallotnum').val('');
                        $('#vwgr2lotassigneddetail-itemexpdate').val('');
                        $("#tbgritemdetail2temp-gritempackid").val('');
                        $("#tbgritemdetail2temp-dispunit").val('');  
                        $("#tbgritemdetail2temp-gritempackid").val('0').trigger("change");
                        $("#tbgritemdetail2temp-grpackqty,#tbgritemdetail2temp-grpackunitcost").attr('readonly', 'readonly');
                        document.getElementById("แพคlot").checked = false;
                       
                    } else {
                        $('#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', 'white');
                        $('#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost,#tbgritemdetail2temp-grextenedcost').val('0.00');
                        $('#checkราคาต่อหน่วยlot,#checkจำนวนlot,#checkหมายเลขการผลิตlot,#checkวันหมดอายุlot').html('');
                        $('#vwgr2lotassigneddetail-itemexternallotnum').val('');
                        $('#vwgr2lotassigneddetail-itemexpdate').val('');
                        $("#tbgritemdetail2temp-dispunit").val('');
                        $("#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost").attr('readonly', 'readonly');
                        //$("#tbgritemdetail2temp-gritempackid").val('');
                        document.getElementById("ชิ้นlot").checked = false;

                    }
                   
                }
            }else{
               // alert ('else');    
            }
            
            })
            .fail(function()
            {
            console.log('server error');
            });
            return false;
    });
    
//-----------------------------END SUBMIT FROM Assign LotNumber-----------------------------------------------
//-----------------------------START Function GetBalance-------------------------------------------------------
 function GetBalance() {
        var ids_gr = $("#ids_grlot").val();
        $.ajax({
            url: "get-balance",
            type: "post",
            data: {id: ids_gr},
            dataType: "JSON",
            success: function (data) {
                $('#AssignLots').waitMe('hide');
                $.pjax.reload({container: '#lot_detail'});
                $("#vwgr2lotassignedbalance-lnassignedqty").val(data.LNAssignedQty);
                $("#vwgr2lotassignedbalance-lnassignedleftqty").val(data.LNAssignedLeftQty);
                $("#vwgr2lotassigneddetail-grunit").val(data.GRUnit);
                $('#vwgr2lotassigneddetail-itemexternallotnum').val('');
                $('#vwgr2lotassigneddetail-itemexpdate').val('');
                if (data.LNAssignedLeftQty == "0.00") {
                    //$('#form_assign_lot').trigger("reset");
                    document.getElementById("btn_assignlot").disabled = true;
                    if ($('#แพคlot').is(':checked')) {
                        $('#tbgritemdetail2temp-grpackqty,#tbgritemdetail2temp-grpackunitcost,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', 'white');
                        $('#tbgritemdetail2temp-grpackqty,#tbgritemdetail2temp-grpackunitcost,#tbgritemdetail2temp-gritempackskuqty').val('0.00');
                        $('#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost,#tbgritemdetail2temp-grextenedcost').val('0.00');
                        $('#checkจำนวนแพคlot,#checkหน่วยแพคlot,#checkราคาต่อแพคlot,#checkหมายเลขการผลิตlot,#checkวันหมดอายุlot').html('');
                        $('#vwgr2lotassigneddetail-itemexternallotnum').val('');
                        $('#vwgr2lotassigneddetail-itemexpdate').val('');
                        $("#tbgritemdetail2temp-gritempackid").val('');
                        $("#tbgritemdetail2temp-dispunit").val('');  
                        $("#tbgritemdetail2temp-gritempackid").val('0').trigger("change");
                        $("#tbgritemdetail2temp-grpackqty,#tbgritemdetail2temp-grpackunitcost").attr('readonly', 'readonly');
                        document.getElementById("แพคlot").checked = false;
                    } else {
                        $('#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', 'white');
                        $('#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost,#tbgritemdetail2temp-grextenedcost').val('0.00');
                        $('#checkราคาต่อหน่วยlot,#checkจำนวนlot,#checkหมายเลขการผลิตlot,#checkวันหมดอายุlot').html('');
                        $('#vwgr2lotassigneddetail-itemexternallotnum').val('');
                        $('#vwgr2lotassigneddetail-itemexpdate').val('');
                        $("#tbgritemdetail2temp-dispunit").val('');
                        $("#tbgritemdetail2temp-gritemqty,#tbgritemdetail2temp-gritemunitcost").attr('readonly', 'readonly');
                        //$("#tbgritemdetail2temp-gritempackid").val('');
                        document.getElementById("ชิ้นlot").checked = false;
                    }
                } else {
                    document.getElementById("btn_assignlot").disabled = false;
                    if ($('#แพคlot').is(':checked')) {
                        $("#tbgritemdetail2temp-grpackqty").val(data.LNAssignedLeftQty);
                        var packqty = parseFloat($("#tbgritemdetail2temp-grpackqty").val().replace(/[,]/g, ""));
                        //alert (packqty);
                        var packskuqty = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
                        //alert (packskuqty);
                        var itemqty = (packqty)*(packskuqty);
                        //alert (itemqty);
                        $("#tbgritemdetail2temp-gritemqty").val(addCommas(itemqty.toFixed(2)));
                        var itemunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                        var extend = itemqty*itemunitcost;
                         //alert (extend);
                        $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
                    }else{    
                        $("#tbgritemdetail2temp-gritemqty").val(data.LNAssignedLeftQty);
                        var itemqty = $("#tbgritemdetail2temp-gritemqty").val();
                        var itemunitcost = $("#tbgritemdetail2temp-gritemunitcost").val();
                        var extend = itemqty*itemunitcost;
                        $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
                    }
                }
            }
        });
    }
//-------------------------------------END Function GetBalance-----------------------------------------------
//-------------------------------START AFTER Click Receive FROM Goods Receive--------------------------------
function  Receive() {
        $('#form_goods_receiving').waitMe('hide');
        var GRID = $("#vwitemlist-itemid").val();
        var ItemID = $("#vwitemlist-itemid").val();
        var ids_gr = $("#ids_gr").val();
        var GRPackQty = $("#vwgr2detail-grpackqty").val();
        var ItemPackSKU = $("#vwgr2detail-gritempackskuqty").val();
        var GRPackUnitCost = $("#vwgr2detail-grpackunitcost").val();
        var GRItemQty = $("#vwgr2detail-gritemqty").val();
        var DispUnit = $("#vwgr2detail-dispunit").val();
        var GRItemUnitCost = $("#vwgr2detail-gritemunitcost").val();
        var GRExtenedCost = $("#vwgr2detail-grextenedcost").val();
        var e = document.getElementById("vwgr2detail-gritempackid");
        var PackUnit = e.options[e.selectedIndex].value;
        var PackUnitText = e.options[e.selectedIndex].text;
        localStorage.ids_gr = ids_gr;
        $('#ItemIDlot').val(ItemID);
        $('#ids_grlot').val(ids_gr);
        $('#tbgritemdetail2temp-grpackqty').val(GRPackQty);
        $('#tbgritemdetail2temp-gritempackskuqty').val(ItemPackSKU);
        $('#tbgritemdetail2temp-grpackunitcost').val(GRPackUnitCost);
        $('#tbgritemdetail2temp-gritemqty').val(GRItemQty);
        $('#tbgritemdetail2temp-dispunit').val(DispUnit);
        $('#tbgritemdetail2temp-gritemunitcost').val(GRItemUnitCost);
        $('#tbgritemdetail2temp-grextenedcost').val(GRExtenedCost);
        $("#tbgritemdetail2temp-gritempackid").val(PackUnit).trigger("change");
        $("#checkedit").val('no');
        if(GRPackQty == "0.00" || GRPackQty ==""){
            $("#vwgr2lotassignedbalance-lnassignedleftqty").val(GRItemQty);
            $("#vwgr2lotassigneddetail-grunit").val(DispUnit);
        }else{
            $("#vwgr2lotassignedbalance-lnassignedleftqty").val(GRPackQty);
            $("#vwgr2lotassigneddetail-grunit").val(PackUnitText);
        }
        $("#vwgr2lotassignedbalance-lnassignedqty").val("0.00");
        var checkpacklot = $('#tbgritemdetail2temp-grpackqty').val();
        if (checkpacklot == "" || checkpacklot == "0.00"){
                document.getElementById("ชิ้นlot").checked = true;
                $('#checkจำนวนlot,#checkวันหมดอายุlot').html('<font color="red">*</font>');
                $("#tbgritemdetail2temp-grpackqty").attr('readonly', 'readonly');
                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
                $("#tbgritemdetail2temp-gritemqty").removeAttr('readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot').html('');
                $('#tbgritemdetail2temp-gritemqty,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-grpackqty').css('background-color', 'white'); 
        }else{
                document.getElementById("แพคlot").checked = true;
                calculate();
                $("#tbgritemdetail2temp-grpackqty").removeAttr('readonly');
                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
                $("#tbgritemdetail2temp-gritemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot,#checkราคาต่อแพคlot,#checkวันหมดอายุlot').html('<font color="red">*</font>');
                $('#checkขอซื้อlot').html('');
                $('#tbgritemdetail2temp-grpackqty,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-gritemqty').css('background-color', 'white');
        }
        
}
//--------------------------END AFTER Click Receive FROM Goods Receive--------------------------------------
//-----------------------START CALCUlATE FROM Assign Lot Number-----------------------------------------------
    //คำนวณจำนวนแพค
    $("#tbgritemdetail2temp-grpackqty").keyup(function () {
       $('#tbgritemdetail2temp-grpackqty').autoNumeric('init');
        //var packunitcost = parseFloat($("#vwgr2detail-grpackunitcost").val().replace(/[,]/g, ""));
        var uni = parseFloat($("#tbgritemdetail2temp-grpackqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
        var grunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
        var checksum = parseFloat($("#vwgr2lotassignedbalance-lnassignedleftqty").val().replace(/[,]/g, ""));
        var left = parseFloat($("#packqtytemp").val().replace(/[,]/g, ""));
        var sum = left+checksum;    
        var jj = uni * orq;
        var Total = jj * grunitcost;
        var checkif = 0;
        var checkedit = $("#checkedit").val();
            //alert (checkedit);
        if(checkedit=="no"){
            if(uni>checksum){
                swal("เกินจำนวนที่รับ","","warning");
                $("#tbgritemdetail2temp-grpackqty").val(addCommas(checksum.toFixed(2)));
                checkif = 1;
                var packqty = parseFloat($("#tbgritemdetail2temp-grpackqty").val().replace(/[,]/g, ""));
                //alert (packqty);
                var packskuqty = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
                //alert (packskuqty);
                var itemqty = (packqty)*(packskuqty);
                //alert (itemqty);
                $("#tbgritemdetail2temp-gritemqty").val(addCommas(itemqty.toFixed(2)));
                var itemunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                var extend = itemqty*itemunitcost;
                $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
            }
         }else if(checkedit == 'yes'){
            if(uni>sum){
                swal("เกินจำนวนที่เหลือบันทึก","","warning");
                var packqtytemp = $("#packqtytemp").val();
                $("#tbgritemdetail2temp-grpackqty").val(packqtytemp);
                checkif = 1;
                var packqty = parseFloat($("#tbgritemdetail2temp-grpackqty").val().replace(/[,]/g, ""));
                //alert (packqty);
                var packskuqty = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
                //alert (packskuqty);
                var itemqty = (packqty)*(packskuqty);
                //alert (itemqty);
                $("#tbgritemdetail2temp-gritemqty").val(addCommas(itemqty.toFixed(2)));
                var itemunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                var extend = itemqty*itemunitcost;
                $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
            }
        }
        if(checkif == 0){
        if (orq == "0" || orq == "0.00" ) {
            $("#tbgritemdetail2temp-gritemqty").val(addCommas(uni.toFixed(2)));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
            //$("#vwgr2detail-gritemunitcost").val(addCommas(unitcost.toFixed(2)));
            $("#tbgritemdetail2temp-gritemqty").val(addCommas(jj.toFixed(2)));
            $("#tbgritemdetail2temp-grextenedcost").val(addCommas(Total.toFixed(2)));
        }
        }
    });
    //คำนวณราคาต่อแพค
    $("#tbgritemdetail2temp-grpackunitcost").keyup(function () {
        $('#tbgritemdetail2temp-grpackunitcost').autoNumeric('init');
        var qty = $("#tbgritemdetail2temp-gritemqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#tbgritemdetail2temp-grpackunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#tbgritemdetail2temp-grextenedcost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#tbgritemdetail2temp-gritemunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#tbgritemdetail2temp-gritemunitcost").val('0.00');
        }
    });
    //คำนวณจำนวน
    $("#tbgritemdetail2temp-gritemqty").keyup(function () {
        $('#tbgritemdetail2temp-gritemqty').autoNumeric('init');
        var uni = parseFloat($("#tbgritemdetail2temp-gritemqty").val().replace(/[,]/g, ""));
        var checksum = parseFloat($("#vwgr2lotassignedbalance-lnassignedleftqty").val().replace(/[,]/g, ""));
        var left = parseFloat($("#itemqtytemp").val().replace(/[,]/g, ""));
        var sum = left+checksum;
        var checkif = 0;
        var checkedit = $("#checkedit").val();
            //alert (checkedit);
        if(checkedit == 'no'){
            if(uni>checksum){
                swal("เกินจำนวนที่รับ","","warning");
                $("#tbgritemdetail2temp-gritemqty").val(addCommas(checksum.toFixed(2)));
                checkif = 1;
                var itemqty = $("#tbgritemdetail2temp-gritemqty").val();
                var itemunitcost = $("#tbgritemdetail2temp-gritemunitcost").val();
                var extend = itemqty*itemunitcost;
                $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
            }
        }else if(checkedit == 'yes'){
            if(uni>sum){
                swal("เกินจำนวนที่เหลือบันทึก","","warning");
                var itemqtytemp = $("#itemqtytemp").val();
                $("#tbgritemdetail2temp-gritemqty").val(itemqtytemp);
                checkif = 1;
                var itemqty = $("#tbgritemdetail2temp-gritemqty").val();
                //alert (itemqty);
                var itemunitcost = $("#tbgritemdetail2temp-gritemunitcost").val();
                //alert (itemunitcost);
                var extend = itemqty*itemunitcost;
                $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
            }
        }
        var orq = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if(checkif == 0){
            if (orq > 0) {
                uni = uni.toFixed(2);
                $("#tbgritemdetail2temp-grextenedcost").val(addCommas(jj.toFixed(2)));
            } else {
                $("#tbgritemdetail2temp-grextenedcost").val('0.00');
            }
        }
    });
    //คำนวณราคาต่อหน่วย
    $("#tbgritemdetail2temp-gritemunitcost").keyup(function () {
        $('#tbgritemdetail2temp-gritemunitcost').autoNumeric('init');
        var uni = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#tbgritemdetail2temp-gritemqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#tbgritemdetail2temp-grextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#tbgritemdetail2temp-grextenedcost").val('0.00');
        }
    });
//------------------------------START FUNCTION คำนวณเปลี่ยนหน่วยแพค--------------------------------------------
function  calculate() {
    //คำนวณเปลี่ยนหน่วยแพค
    $('#tbgritemdetail2temp-gritempackid').on('change', function () {
        var ItemID = $("#vwitemlist-itemid").val();
        var ItemPackUnit = $(this).find("option:selected").val();
        var qty = parseFloat($("#tbgritemdetail2temp-grpackqty").val().replace(/[,]/g, ""));
        $.ajax({
            url: "get-qty",
            type: "post",
            data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
            dataType: 'json',
            success: function (data) {
                $('#tbgritemdetail2temp-gritempackskuqty').val(data.ItemPackSKUQty);
                var GRUnitCost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                var packunitcost = parseFloat($("#tbgritemdetail2temp-grpackunitcost").val().replace(/[,]/g, ""));
                var SKUQty = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
                var jj = (SKUQty) * (qty);
                //var Total = jj * GRUnitCost;
                var unitcost = packunitcost / SKUQty;
                if (data.qty == 0) {
                    $('#tbgritemdetail2temp-gritemqty').val();
                } else {
                    
                    $("#tbgritemdetail2temp-gritemqty").val(addCommas(jj.toFixed(2)));
                    $("#tbgritemdetail2temp-gritemunitcost").val(addCommas(unitcost.toFixed(2)));
                    var itemunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                    var Total = jj * itemunitcost;
                    $("#tbgritemdetail2temp-grextenedcost").val(addCommas(Total.toFixed(2)));
                }
            }
        });
    });
}  
//------------------------------------END FUNCTION คำนวณเปลี่ยนหน่วยแพค---------------------------------------------
//-----------------------------------END CALCUlATE FROM Assign Lot Number-------------------------------------
function GetBalanceEdit() {
        var ids_gr = $("#ids_grlot").val();
        $.ajax({
            url: "get-balance",
            type: "post",
            data: {id: ids_gr},
            dataType: "JSON",
            success: function (data) {
                $('#AssignLots').waitMe('hide');
                $.pjax.reload({container: '#lot_detail'}); 
                $("#vwgr2lotassignedbalance-lnassignedqty").val(data.LNAssignedQty);
                $("#vwgr2lotassignedbalance-lnassignedleftqty").val(data.LNAssignedLeftQty);
                $("#vwgr2lotassigneddetail-grunit").val(data.GRUnit);
                document.getElementById("btn_assignlot").disabled = true;
            }
        });
    } 
    function GetBalanceDelete() {
        var ids_gr = $("#ids_grlot").val();
        $.ajax({
            url: "get-balance",
            type: "post",
            data: {id: ids_gr},
            dataType: "JSON",
            success: function (data) {
                $('#AssignLots').waitMe('hide');
                $.pjax.reload({container: '#lot_detail'}); 
                $("#vwgr2lotassignedbalance-lnassignedqty").val(data.LNAssignedQty);
                $("#vwgr2lotassignedbalance-lnassignedleftqty").val(data.LNAssignedLeftQty);
                $("#vwgr2lotassigneddetail-grunit").val(data.GRUnit);
                if(data.LNAssignedLeftQty == null){
                    document.getElementById("btn_assignlot").disabled = true;
                    LocationGR();
                    document.getElementById("Receive").disabled = false;
                }else{
                    document.getElementById("btn_assignlot").disabled = false;
                    var leftqry = $("#vwgr2lotassignedbalance-lnassignedleftqty").val();
                    returnlot(leftqry);
                }
            }
        });
    }
    function returnlot(leftqry) {
        var GRID = $("#vwitemlist-itemid").val();
        var ItemID = $("#vwitemlist-itemid").val();
        var ids_gr = $("#ids_gr").val();
        //var GRPackQty = $("#vwgr2detail-grpackqty").val();
        var ItemPackSKU = $("#vwgr2detail-gritempackskuqty").val();
        var GRPackUnitCost = $("#vwgr2detail-grpackunitcost").val();
        //var GRItemQty = $("#vwgr2detail-gritemqty").val();
        var DispUnit = $("#vwgr2detail-dispunit").val();
        var GRItemUnitCost = $("#vwgr2detail-gritemunitcost").val();
        //var GRExtenedCost = $("#vwgr2detail-grextenedcost").val();
        var e = document.getElementById("vwgr2detail-gritempackid");
        var PackUnit = e.options[e.selectedIndex].value;
        var PackUnitText = e.options[e.selectedIndex].text;
        localStorage.ids_gr = ids_gr;
        $('#ItemIDlot').val(ItemID);
        $('#ids_grlot').val(ids_gr);
        //$('#tbgritemdetail2temp-grpackqty').val(GRPackQty);
        $('#tbgritemdetail2temp-gritempackskuqty').val(ItemPackSKU);
        $('#tbgritemdetail2temp-grpackunitcost').val(GRPackUnitCost);
        //$('#tbgritemdetail2temp-gritemqty').val(GRItemQty);
        $('#tbgritemdetail2temp-dispunit').val(DispUnit);
        $('#tbgritemdetail2temp-gritemunitcost').val(GRItemUnitCost);
        //$('#tbgritemdetail2temp-grextenedcost').val(GRExtenedCost);
        $("#tbgritemdetail2temp-gritempackid").val(PackUnit).trigger("change");
        $("#checkedit").val('no');
        // if(GRPackQty == "0.00" || GRPackQty ==""){
        //     $("#vwgr2lotassignedbalance-lnassignedleftqty").val(GRItemQty);
        //     $("#vwgr2lotassigneddetail-grunit").val(DispUnit);
        // }else{
        //     $("#vwgr2lotassignedbalance-lnassignedleftqty").val(GRPackQty);
        //     $("#vwgr2lotassigneddetail-grunit").val(PackUnitText);
        // }
        //$("#vwgr2lotassignedbalance-lnassignedqty").val("0.00");
        var checkpackGr = $("#tbgritemdetail2temp-gritempackid").val();
        var checkpacklot = $('#tbgritemdetail2temp-grpackqty').val();
        if (checkpackGr == "" || checkpackGr == "0"){
                document.getElementById("ชิ้นlot").checked = true;
                $('#checkจำนวนlot,#checkวันหมดอายุlot').html('<font color="red">*</font>');
                $("#tbgritemdetail2temp-grpackqty").attr('readonly', 'readonly');
                //$("#vwgr2detail-gritempackid").attr('disabled', 'disabled');
                $("#tbgritemdetail2temp-gritemqty").removeAttr('readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot').html('');
                $('#tbgritemdetail2temp-gritemqty,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-grpackqty').css('background-color', 'white');
                $("#vwgr2lotassignedbalance-lnassignedleftqty").val(leftqry);
                $("#vwgr2lotassigneddetail-grunit").val(DispUnit);
                $('#tbgritemdetail2temp-gritemqty').val('0.00');

        }else{
                document.getElementById("แพคlot").checked = true;
                $("#tbgritemdetail2temp-grpackqty").removeAttr('readonly');
                //$("#vwgr2detail-gritempackid").removeAttr('disabled');
                $("#tbgritemdetail2temp-gritemqty").attr('readonly', 'readonly');
                $('#checkจำนวนแพคlot,#checkหน่วยแพคlot,#checkราคาต่อแพคlot,#checkวันหมดอายุlot').html('<font color="red">*</font>');
                $('#checkขอซื้อlot').html('');
                $('#tbgritemdetail2temp-grpackqty,#vwgr2lotassigneddetail-itemexternallotnum,#vwgr2lotassigneddetail-itemexpdate').css('background-color', '#FFFF99');
                $('#tbgritemdetail2temp-gritemqty').css('background-color', 'white');
                $("#vwgr2lotassignedbalance-lnassignedleftqty").val(leftqry);
                $("#vwgr2lotassigneddetail-grunit").val(PackUnitText);
                $('#tbgritemdetail2temp-grpackqty').val('0.00');
                calculate();
        }
    }                       
//------------------------------START EDIT AND DELETE LOT NUMBER ------------------------------------------
function init_click_handlers() {
   $('.activity-edit-link').click(function (e) {
        $("#checkedit").val('yes');
//      var ids_gr = $(this).attr("data-id")
//      alert (ids_gr);
        var fID = $(this).closest('tr').data('key');
        $.ajax({
            url: 'edititem-lotassign',
            type: 'POST',
            data: {id: fID},
            dataType: 'json',
            success: function (data) {
                document.getElementById("btn_updatelot").disabled = false;
                document.getElementById("btn_assignlot").disabled = true;
                if (data.LNItemPackID == null || data.LNItemPackID == '') {
                   document.getElementById("ชิ้นlot").checked = true;
                   $("#ItemIDlot").val(data.ItemID);
                   $("#Internal").val(data.ItemInternalLotNum);
                   $('#vwgr2lotassigneddetail-itemexternallotnum').val(data.ItemExternalLotNum);
                   $('#vwgr2lotassigneddetail-itemexpdate').val(data.ItemExpDate);
                   $("#tbgritemdetail2temp-gritemqty").val(data.LNItemQty);
                   $("#itemqtytemp").val(data.LNItemQty);
                   $("#tbgritemdetail2temp-gritemunitcost").val(data.LNItemUnitCost);
                   $("#tbgritemdetail2temp-dispunit").val(data.DispUnit);
                   $("#ids_grlot").val(data.ids_gr);
                   var itemqty =  parseFloat($("#tbgritemdetail2temp-gritemqty").val().replace(/[,]/g, ""));
                   var itemunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                   var extend = itemqty*itemunitcost;
                   $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
                   $("#tbgritemdetail2temp-gritemqty").removeAttr('readonly');
                   $("#tbgritemdetail2temp-gritemqty,#vwgr2lotassigneddetail-itemexpdate").css('background-color', '#FFFF99');
                   $('#checkจำนวนlot,#checkวันหมดอายุlot').html('<font color="red">*</font>');
                   GetBalanceEdit();
                } else {
                   document.getElementById("แพคlot").checked = true;
                   $("#ItemIDlot").val(data.ItemID);
                   $("#tbgritemdetail2temp-gritempackid").val(data.ItemPackUnit).trigger("change");
                   $("#Internal").val(data.ItemInternalLotNum);
                   $('#vwgr2lotassigneddetail-itemexternallotnum').val(data.ItemExternalLotNum);
                   $('#vwgr2lotassigneddetail-itemexpdate').val(data.ItemExpDate);
                   $("#tbgritemdetail2temp-grpackqty").val(data.LNPackQty);
                   $("#tbgritemdetail2temp-gritempackskuqty").val(data.ItemPackSKUQty);
                   $("#tbgritemdetail2temp-grpackunitcost").val(data.LNPackUnitCost);
                   $("#packqtytemp").val(data.LNPackQty);
                   $("#tbgritemdetail2temp-dispunit").val(data.DispUnit);
                   $("#tbgritemdetail2temp-gritemunitcost").val(data.LNItemUnitCost);
                   $("#ids_grlot").val(data.ids_gr);
                   var packqty = parseFloat($("#tbgritemdetail2temp-grpackqty").val().replace(/[,]/g, ""));
                   //alert (packqty);
                   var packskuqty = parseFloat($("#tbgritemdetail2temp-gritempackskuqty").val().replace(/[,]/g, ""));
                   //alert (packskuqty);
                   var itemqty = (packqty)*(packskuqty);
                   //alert (itemqty);
                   $("#tbgritemdetail2temp-gritemqty").val(addCommas(itemqty.toFixed(2)));
                   var itemunitcost = parseFloat($("#tbgritemdetail2temp-gritemunitcost").val().replace(/[,]/g, ""));
                   var extend = itemqty*itemunitcost;
                   $("#tbgritemdetail2temp-grextenedcost").val(addCommas(extend.toFixed(2)));
                   $("#tbgritemdetail2temp-grpackqty").removeAttr('readonly');
                   $("#tbgritemdetail2temp-grpackqty,#vwgr2lotassigneddetail-itemexpdate").css('background-color', '#FFFF99');
                   $('#checkจำนวนแพคlot,#checkวันหมดอายุlot').html('<font color="red">*</font>');
                   calculate();
                   GetBalanceEdit();
                   
                }
            }
        });
    });
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        wait();
        swal({   
            title: "ยืนยันคำสั่ง?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "error",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: false
        },function(){
                //Delete
                $.post(
                        'deletelot',
                        {
                            id: fID
                        },
                function (data)
                {
                    GetBalanceEdit();
                    swal("Success","", "success"); 
                }
                );
        });
        $('#AssignLots').waitMe('hide');
    });    
    }

    init_click_handlers(); //first run
    $('#lot_detail').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
//----------------------------------------END EDIT AND DELETE LOT NUMBER ---------------------------------------
//--------------------------------------START Save Lot Number -------------------------------------------------
    $('#SaveLotNumber').click(function (e) {
        wait();
        var ids_gr = localStorage.ids_gr;
        //alert (ids_gr);
        $.post(
                'save-lot-number',
                {
                    ids_gr: ids_gr
                },
        function (data)
        {
           $('#AssignLots').waitMe('hide');    
           swal("SaveLotNumber","", "success"); 
        }
        );
    });
    $('#Clear').click(function (e) {
        waitGR()
        var ids_gr = localStorage.ids_gr;
        swal({   
            title: "ยืนยันคำสั่ง?",   
            //text: "You will not be able to recover this imaginary file!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#53a93f",   
            confirmButtonText: "Confirm",   
            closeOnConfirm: false
        },function(){
        $.post(
                'clear',
                {
                    ids_gr: ids_gr
                },
            function (data)
            {
                $('#form_goods_receiving').waitMe('hide');    
                swal("Success","", "success");
                document.getElementById("Receive").disabled = false;
                $('#vwgr2detail-grpackqty').val('0.00');
                $('#vwgr2detail-gritemqty').val('0.00');
                var left = $('#vwgr2detail-grleftqty').val();
                $('#has').val(left);
                LocationGR(); 
            }
        );
       });
        $('#form_goods_receiving').waitMe('hide');
    });
    function wait(){
         var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#AssignLots').waitMe({
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
    function waitGR(){
         var current_effect = 'ios'; 
                run_waitMe(current_effect);
                function run_waitMe(effect){
                    $('#form_goods_receiving').waitMe({
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
//--------------------------------------END Save LotNumber ---------------------------------------------
JS;
$this->registerJs($script);
?>
