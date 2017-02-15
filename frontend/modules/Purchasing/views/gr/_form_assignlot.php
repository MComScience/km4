<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;

$this->title = Yii::t('app', 'บันทึกใบรับสินค้า');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'บันทึกรับจากการสั่งซื้อ')];
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
                        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_goods_receiving']); ?>
                        <input id="PackUnitID" type="hidden" value="<?php echo $PackUnit; ?>"/>
                        <div class="form-group" >
                            <?= Html::activeLabel($modelGRTemp, 'ItemID', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'ItemID', ['showLabels' => false])->textInput([
                                    'maxlength' => true,
                                    'readonly' => true,
                                    'style' => 'background-color:white'
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group" >
                            <?= Html::activeLabel($modelGRTemp, 'ItemDetail', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-8">
                                <?=
                                $form->field($modelGRTemp, 'ItemDetail', ['showLabels' => false])->textarea([
                                    'readonly' => true,
                                    'style' => 'background-color:white',
                                    'rows' => 4
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right"><h5 class="row-title before-success">ยอดสั่งซื้อ</h5></label>
                            <div class="col-sm-3"></div>
                            <label class="col-sm-2 control-label no-padding-right"><h5 class="row-title before-success">สั่งครั้งนี้</h5></label>
                            <div class="col-sm-3"></div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right"></label>
                            <div class="col-sm-3"></div>
                            <label class="col-sm-2 control-label no-padding-right"></label>
                            <div class="col-sm-3">
                                <div class="radio"><label><input type="radio" name="แพค" id="แพค" value="yes"/> แพค</label>
                                    <label><input type="radio"  name="แพค" id="ชิ้น" value="no"/> ชิ้น</label></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POPackQtyApprove', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POPackQtyApprove', ['showLabels' => false])->textInput([
                                    'maxlength' => true,
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($modelGRTemp['POPackQtyApprove'], 2)
                                ])
                                ?>
                            </div>
                            <label class="col-sm-2 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRPackQty', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($GRPackQty, 2)
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POItemPackUnit', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POItemPackUnit', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                    'data' => yii\helpers\ArrayHelper::map(\app\models\TbPackunit::find()->where(['PackUnitID' => $modelGRTemp['POItemPackUnit']])->all(), 'PackUnitID', 'PackUnit'),
                                    'pluginOptions' => [
                                        'placeholder' => 'Select Option',
                                        'allowClear' => true,
                                    ],
                                ])
                                ?>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRPackUnit', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                    'data' => yii\helpers\ArrayHelper::map(\app\models\TbPackunit::find()->where(['PackUnitID' => $ItemPackUnit])->all(), 'PackUnitID', 'PackUnit'),
                                    'pluginOptions' => [
                                        'placeholder' => 'Select Option',
                                        'allowClear' => true,
                                    ],
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POItemPackSKUQty', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POItemPackSKUQty', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($modelGRTemp['POItemPackSKUQty'], 2)
                                ])
                                ?>
                            </div>
                            <label class="col-sm-2 control-label no-padding-right">ปริมาณ/แพค</label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRItemPackSKUQty', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($GRItemPackSKUQty, 2)
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POPackCostApprove', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POPackCostApprove', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($modelGRTemp['POPackCostApprove'], 2)
                                ])
                                ?>
                            </div>
                            <label class="col-sm-2 control-label no-padding-right">ราคา/แพค <a id="checkราคาต่อแพค"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRPackUnitCost', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($GRPackUnitCost, 2)
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POApprovedOrderQty', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POApprovedOrderQty', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($modelGRTemp['POApprovedOrderQty'], 2)
                                ])
                                ?>
                            </div>
                            <label class="col-sm-2 control-label no-padding-right">จำนวน <a id="checkขอซื้อ"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRItemQty', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($GRItemQty, 2)
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">หน่วย</label>
                            <div class="col-sm-3">
                                <input readonly="" class="form-control" value="<?php echo $modelGRTemp['DispUnit']; ?>" style="background-color: white;text-align: right"/>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">หน่วย</label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'DispUnit', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POApprovedUnitCost', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POApprovedUnitCost', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($modelGRTemp['POApprovedUnitCost'], 2)
                                ])
                                ?>
                            </div>
                            <label class="col-sm-2 control-label no-padding-right">ราคา/หน่วย <a id="checkราคาต่อหน่วย"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRItemUnitCost', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($GRItemUnitCost, 2)
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'POExtenedCost', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'POExtenedCost', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($modelGRTemp['POApprovedOrderQty'] * $modelGRTemp['POApprovedUnitCost'], 2)
                                ])
                                ?>
                            </div>
                            <?= Html::activeLabel($modelGRTemp, 'GRExtenedCost', ['class' => 'col-sm-2 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRExtenedCost', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                    'value' => number_format($GRItemQty * $GRItemUnitCost, 2),
                                ])
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($modelGRTemp, 'GRLeftQty', ['class' => 'col-sm-7 control-label no-padding-right']) ?>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelGRTemp, 'GRLeftQty', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                ])
                                ?>
                            </div>
                        </div>
                        <?= $form->field($modelGRTemp, 'ids_gr', ['showLabels' => false])->hiddenInput([]) ?>

                        <div class="form-group">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-4" style="text-align: right">
                                <a class="btn btn-danger" id="Clear">Clear</a>
                                <?= Html::submitButton($modelGRTemp->isNewRecord ? 'Receive' : 'Receive', ['class' => $modelGRTemp->isNewRecord ? 'btn btn-success draft' : 'btn btn-success draft', 'id' => 'Receive']) ?> 
                            </div>

                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="horizontal-space"></div>
    </div>
</div>

<div class="row">
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
                        <?php $formlot = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_assign_lot']); ?>

                        <input name="ItemID1" type="hidden" id="ItemID1" class="form-control" readonly=""/>
                        <input name="ids_grlot" type="hidden" id="ids_grlot" class="form-control" readonly=""/>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right"></label>
                            <div class="col-sm-3"></div>
                            <label class="col-sm-2 control-label no-padding-right"></label>
                            <div class="col-sm-3">
                                <div class="radio"><label><input type="radio" name="แพค" id="แพค1" value="yes"/> แพค</label>
                                    <label><input type="radio"  name="แพค" id="ชิ้น1" value="no"/> ชิ้น</label></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">บันทึก Lot Number แล้ว</label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($balance, 'LNAssignedQty', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                    'readonly' => true,
                                ])
                                ?>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">จำนวนแพค <a id="checkจำนวนแพค1"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($modelLot, 'LNPackQty', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                        //'value' => number_format($GRPackQty, 2)
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">คงเหลือบันทึก Lot Number</label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($balance, 'LNAssignedLeftQty', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                    'readonly' => true,
                                ])
                                ?>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">หน่วยแพค <a id="checkหน่วยแพค1"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($modelLot, 'PackUnit', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                                    'data' => yii\helpers\ArrayHelper::map(\app\models\TbPackunit::find()->where(['PackUnitID' => $ItemPackUnit])->all(), 'PackUnitID', 'PackUnit'),
                                    'pluginOptions' => [
                                        'placeholder' => 'Select Option',
                                        'allowClear' => true,
                                    ],
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">หน่วย</label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($balance, 'GRUnit', ['showLabels' => false])->textInput([
                                    'readonly' => true,
                                    'style' => 'background-color: white;text-align:right',
                                ])
                                ?>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">ปริมาณ/แพค</label>
                            <div class="col-sm-3">
                                <input id="vwgr2lotassigneddetail-sku" readonly="" class="form-control"  style="background-color: white;text-align: right"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">หมายเลขการผลิต</label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($modelLot, 'ItemExternalLotNum', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;',
                                ])
                                ?>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">ราคาต่อแพค <a id="checkราคาต่อแพค1"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($modelLot, 'LNPackUnitCost', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right">วันหมดอายุ</label>
                            <div class="col-sm-3">
                                <?=
                                $form->field($modelLot, 'ItemExpDate', ['showLabels' => false])->widget(yii\jui\DatePicker::classname(), [
                                    'language' => 'th',
                                    'dateFormat' => 'dd/MM/yyyy',
                                    'clientOptions' => [
                                        'changeMonth' => true,
                                        'changeYear' => true,
                                    ],
                                    'options' => [
                                        'class' => 'form-control',
                                        'style' => 'background-color: white;'
                                    ],
                                ])
                                ?>
                            </div>
                            <label class="col-sm-2 control-label no-padding-right">จำนวน <a id="checkจำนวน1"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($modelLot, 'LNItemQty', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label no-padding-right"></label>
                            <div class="col-sm-3">
                                <?= $form->field($modelLot, 'ItemInternalLotNum', ['showLabels' => false])->hiddenInput([]) ?>
                            </div>

                            <label class="col-sm-2 control-label no-padding-right">หน่วย</label>
                            <div class="col-sm-3">
                                <input readonly="" id="vwgr2lotassigneddetail-dispunit" class="form-control" value="" style="background-color: white;text-align: right"/>
                            </div>     
                        </div>
                        <br>
                        <div class="form-group">
                            <label class="col-sm-7 control-label no-padding-right">ราคาต่อหน่วย <a id="checkราคาต่อหน่วย1"></a></label>
                            <div class="col-sm-3">
                                <?=
                                $formlot->field($modelLot, 'LNItemUnitCost', ['showLabels' => false])->textInput([
                                    'style' => 'background-color: white;text-align:right',
                                ])
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-7 control-label no-padding-right">รวมเป็นเงิน</label>
                            <div class="col-sm-3">
                                <input readonly="" id="vwgr2lotassigneddetail-extencost" class="form-control" value="" style="background-color: white;text-align: right"/>
                            </div>     
                        </div>


                        <div class="form-group" >
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <?= Html::submitButton('Assign Lot Number', ['class' => 'btn btn-primary', 'id' => 'btn_assignlot']) ?>
                                <?= Html::submitButton('Update Lot Number', ['class' => 'btn btn-primary', 'id' => 'btn_updatelot']) ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php \yii\widgets\Pjax::begin([ 'id' => 'table_lotassign_temp']) ?>
                            <?=
                            kartik\grid\GridView::widget([
                                'dataProvider' => $dataProvider,
                                //'filterModel' => $searchModel,
                                'bootstrap' => true,
                                'responsiveWrap' => FALSE,
                                'responsive' => true,
                                'showPageSummary' => FALSE,
                                'hover' => true,
                                'pjax' => true,
                                'striped' => true,
                                'condensed' => true,
                                'toggleData' => false,
                                'pageSummaryRowOptions' => ['class' => 'default'],
                                'layout' => "{summary}\n{items}\n{pager}",
                                'headerRowOptions' => ['class' => kartik\grid\GridView::TYPE_SUCCESS],
                                'rowOptions' => function($model) {
                            if ($model->LNItemStatusID == '3') {
                                return ['class' => 'warning'];
                            }
                        },
                                'columns' => [
                                    [
                                        'class' => 'kartik\grid\SerialColumn',
                                        'contentOptions' => ['class' => 'kartik-sheet-style'],
                                        'width' => '36px',
                                        'header' => '#',
                                        'headerOptions' => ['class' => 'kartik-sheet-style']
                                    ],
                                    [
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemInternalLotNum',
                                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemExternalLotNum',
                                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'attribute' => 'ItemExpDate',
                                        'format' => ['date', 'php:d/m/Y'],
                                        'hAlign' => GridView::ALIGN_CENTER,
                                    ],
                                    [
                                        'header' => '<a href="">จำนวน</a>',
                                        'attribute' => 'GRQty',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'hAlign' => kartik\grid\GridView::ALIGN_RIGHT,
                                        'value' => function ($model) {
                                    if ($model->dataonview->GRQty == NULL) {
                                        return '-';
                                    } else {
                                        return number_format($model->dataonview->GRQty, 2);
                                    }
                                }
                                    ],
                                    [
                                        'header' => '<a href="">หน่วย</a>',
                                        'attribute' => 'GRUnit',
                                        'headerOptions' => ['style' => 'text-align:center'],
                                        'hAlign' => kartik\grid\GridView::ALIGN_CENTER,
                                        'value' => function ($model) {
                                    if ($model->dataonview->GRUnit == NULL) {
                                        return '-';
                                    } else {
                                        return $model->dataonview->GRUnit;
                                    }
                                }
                                    ],
                                    [
                                        'class' => 'kartik\grid\ActionColumn',
                                        'header' => '<a>Actions</a>',
                                        'noWrap' => true,
                                        //'options' => ['style' => 'width:100px;'],
                                        'hAlign' => \kartik\grid\GridView::ALIGN_CENTER,
                                        'headerOptions' => ['style' => 'text-align:center;'],
                                        'template' => ' {update} {delete}',
                                        'buttonOptions' => ['class' => 'btn btn-default'],
                                        'buttons' => [
                                            'update' => function ($url, $model, $key) {
                                                return Html::a('<span class="btn btn-info btn-xs">Edit</span>', '#', [
                                                            'class' => 'activity-update-link',
                                                            'title' => 'แก้ไขข้อมูล',
                                                            'data-toggle' => 'modal',
                                                            //'data-target' => '#gpu-modal',
                                                            'data-id' => $key,
                                                            'data-pjax' => '0',
                                                ]);
                                            },
                                                    'delete' => function ($url, $model) {
                                                return Html::a('<span class="btn btn-danger btn-xs"> Delete </span> ', '#', [
                                                            //'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                            'title' => Yii::t('app', 'Delete'),
                                                            'data-toggle' => 'modal',
                                                            //'data-method' => "post",
                                                            //'role' => 'modal-remote',
                                                            'class' => 'activity-delete-link',
                                                ]);
                                            },
                                                ],
                                            ],
                                        ],
                                    ]);
                                    ?>
                                    <?php \yii\widgets\Pjax::end() ?>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: right">
                                <?= Html::a('Close', ['create', 'poid' => $poid, 'ponum' => $ponum, 'view' => 'list-draft'], ['class' => 'btn btn-default']); ?>
                                <?= Html::button('Save Lot Number', ['class' => 'btn btn-success', 'id' => 'SaveLotNumber']) ?>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
                <div class="horizontal-space"></div>
            </div>
        </div>


        <?php
        $script = <<< JS

$(document).ready(function () {
        var PackQtyApprove = parseFloat($("#vwgr2detail-popackqtyapprove").val().replace(/[,]/g, ""));
        //var PackQtyApprove = $("#vwgr2detail-popackqtyapprove").val();
        var PackUnitID = $("#PackUnitID").val();//หน่วยแพค
        
        //CheckPack
        if (PackQtyApprove == "" || PackQtyApprove == '0.00') {
            document.getElementById("ชิ้น").checked = true;
            Chin();
            //คำนวณค้างส่ง
            var poapprovedorderqty = parseFloat($("#vwgr2detail-poapprovedorderqty").val().replace(/[,]/g, ""));
            var gritemqty = parseFloat($("#vwgr2detail-gritemqty").val().replace(/[,]/g, ""));
                var balance = poapprovedorderqty - gritemqty;
             $("#vwgr2detail-grleftqty").val(addCommas(balance.toFixed(2)));
             
        } else {
            document.getElementById("แพค").checked = true;
            Pack();
            //คำนวณค้างส่ง
            var grpackqty = parseFloat($("#vwgr2detail-grpackqty").val().replace(/[,]/g, ""));
            //var grpackqty = $("#vwgr2detail-grpackqty").val();
            var balance = PackQtyApprove - grpackqty;
            $("#vwgr2detail-grleftqty").val(addCommas(balance.toFixed(2)));
        }
        if (PackUnitID != "") {
            $("#vwgr2detail-grpackunit").val(PackUnitID).trigger("change");//เปลี่ยนหน่วยแพคตาม
        }
    });   
//เลือกขอซื้อ แพค/ชิ้น
    $("input[id=แพค]").click(function () {
        if ($(this).is(":checked"))
        {
            Pack();
        }
    });
    $("input[id=ชิ้น]").click(function () {
        if ($(this).is(":checked"))
        {
            Chin();
        }
    });
 function Pack() {
        $("#vwgr2detail-grpackqty,#vwgr2detail-grpackunitcost").removeAttr('readonly');
        //$("#vwgr2detail-grpackunit").removeAttr('disabled');
        $("#vwgr2detail-gritemqty,#vwgr2detail-gritemunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย,#checkขอซื้อ').html('');
        $('#vwgr2detail-grpackqty,#vwgr2detail-grpackunitcost').css('background-color', '#FFFF99');
        $('#vwgr2detail-gritemqty,#vwgr2detail-gritemunitcost').css('background-color', 'white');
    }
    function Chin() {
        $('#checkขอซื้อ,#checkราคาต่อหน่วย').html('<font color="red">*</font>');
        $("#vwgr2detail-grpackqty,#vwgr2detail-grpackunitcost").attr('readonly', 'readonly');
        //$("#vwgr2detail-grpackunit").attr('disabled', 'disabled');
        $("#vwgr2detail-gritemqty,#vwgr2detail-gritemunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค,#checkหน่วยแพค,#checkราคาต่อแพค').html('');
        $('#vwgr2detail-gritemqty,#vwgr2detail-gritemunitcost').css('background-color', '#FFFF99');
        $('#vwgr2detail-grpackqty,#vwgr2detail-grpackunitcost').css('background-color', 'white');
    }
//คำนวณขอซื้อ
    $("#vwgr2detail-gritemqty").keyup(function () {
        $('input[id="vwgr2detail-gritemqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwgr2detail-gritemqty").val().replace(/[,]/g, ""));
        var poapprovedorderqty = parseFloat($("#vwgr2detail-poapprovedorderqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwgr2detail-grextenedcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2detail-grextenedcost").val('0.00');
        }
        //คงเหลือ
        var balance = poapprovedorderqty - uni;
        $("#vwgr2detail-grleftqty").val(addCommas(balance.toFixed(2)));
    });
//คำนวณราคาต่อหน่วย
    $("#vwgr2detail-gritemunitcost").keyup(function () {
        $('input[id="vwgr2detail-gritemunitcost"]').priceFormat({prefix: ''});
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
//คำนวณจำนวนแพค
    $("#vwgr2detail-grpackqty").keyup(function () {
        $('input[id="vwgr2detail-grpackqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwgr2detail-grpackqty").val().replace(/[,]/g, ""));
        var popackqtyapprove = parseFloat($("#vwgr2detail-popackqtyapprove").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2detail-gritempackskuqty").val().replace(/[,]/g, ""));
        var prunitcost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        var Total = jj * prunitcost;
        if (orq == 0) {
            $("#vwgr2detail-gritemqty").val(addCommas(uni.toFixed(2)));
        } else if (orq > 0) {
            orq = orq.toFixed(2);
            $("#vwgr2detail-gritemqty").val(addCommas(jj.toFixed(2)));
            $("#vwgr2detail-grextenedcost").val(addCommas(Total.toFixed(2)));
        }
        //คงเหลือ
        var balance = popackqtyapprove - uni;
        $("#vwgr2detail-grleftqty").val(addCommas(balance.toFixed(2)));
        
    });
//คำนวณ on chang หน่วยแพค
$('#vwgr2detail-grpackunit').on('change', function (e) {
        var ItemID = $("#vwgr2detail-itemid").val();
        var ItemPackUnit = $(this).find("option:selected").val();
        var qty = parseFloat($("#vwgr2detail-grpackqty").val().replace(/[,]/g, ""));
        var PRUnitCost = parseFloat($("#vwgr2detail-gritemunitcost").val().replace(/[,]/g, ""));
        if ($('#แพค').is(':checked')) {
            $.ajax({
                url: "index.php?r=Purchasing/gr/get-qty",
                type: "post",
                data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
                dataType: 'json',
                success: function (data) {
                    $('#vwgr2detail-gritempackskuqty').val(data.ItemPackSKUQty);
                    var SKUQty = parseFloat($("#vwgr2detail-gritempackskuqty").val().replace(/[,]/g, ""));
                    var jj = (SKUQty) * (qty);
                    var Total = jj * PRUnitCost;
                    if (data.qty == 0) {
                        $('#vwgr2detail-gritemqty').val('0.00');
                    } else {
                        $("#vwgr2detail-gritemqty").val(addCommas(jj.toFixed(2)));
                        $("#vwgr2detail-grextenedcost").val(addCommas(Total.toFixed(2)));
                    }
                }
            });
        }
    });    
        
//คำนวณราคาต่อแพค
    $("#vwgr2detail-grpackunitcost").keyup(function () {
        $('input[id="vwgr2detail-grpackunitcost"]').priceFormat({prefix: ''});
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
        
        
//On Save
    $('#form_goods_receiving').on('beforeSubmit', function(e)
    {
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == "success")
            {
                    Receive();
                    Notify('Receive Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
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

//Post Value
function  Receive() {
        var ItemID = $("#vwgr2detail-itemid").val();
        var ids_gr = $("#vwgr2detail-ids_gr").val();
        var GRPackQty = $("#vwgr2detail-grpackqty").val();
        var PackSKU = $("#vwgr2detail-gritempackskuqty").val();
        var PackUnitCost = $("#vwgr2detail-grpackunitcost").val();
        var GRItemQty = $("#vwgr2detail-gritemqty").val();
        var DispUnit = $("#vwgr2detail-dispunit").val();
        var GRItemUnitCost = $("#vwgr2detail-gritemunitcost").val();
        var GRExtenedCost = $("#vwgr2detail-grextenedcost").val();
        var e = document.getElementById("vwgr2detail-grpackunit");
        var PackUnit = e.options[e.selectedIndex].value;
        var PackUnitText = e.options[e.selectedIndex].text;
        //

        $('#ItemID1').val(ItemID);
        $('#ids_grlot').val(ids_gr);
        $('#vwgr2lotassigneddetail-lnpackqty').val(GRPackQty);
        $('#vwgr2lotassigneddetail-sku').val(PackSKU);
        $('#vwgr2lotassigneddetail-lnpackunitcost').val(PackUnitCost);
        $('#vwgr2lotassigneddetail-lnitemqty').val(GRItemQty);
        $('#vwgr2lotassigneddetail-dispunit').val(DispUnit);
        $('#vwgr2lotassigneddetail-lnitemunitcost').val(GRItemUnitCost);
        $('#vwgr2lotassigneddetail-extencost').val(GRExtenedCost);
        $("#vwgr2lotassigneddetail-packunit").val(PackUnit).trigger("change");
        $.ajax({
            url: "index.php?r=Purchasing/gr/get-balance",
            type: "post",
            data: {id: ids_gr},
            dataType: "JSON",
            success: function (data) {
                if (data.LNAssignedLeftQty == null) {
                    //Pack
                    if (PackUnit == "") {
                        document.getElementById("ชิ้น1").checked = true;
                        Chin1();
                        $('#vwgr2lotassignedbalance-lnassignedleftqty').val(GRItemQty);
                        $('#vwgr2lotassignedbalance-lnassignedqty').val('0.00');
                        $('#vwgr2lotassignedbalance-grunit').val(DispUnit);
                    } else {
                        document.getElementById("แพค1").checked = true;
                        Pack1();
                        $('#vwgr2lotassignedbalance-lnassignedleftqty').val(GRPackQty);
                        $('#vwgr2lotassignedbalance-lnassignedqty').val('0.00');
                        $('#vwgr2lotassignedbalance-grunit').val(PackUnitText);
                    }
                } else {
                    //Pack
                    if (PackUnit == "") {
                        document.getElementById("ชิ้น1").checked = true;
                        Chin1();
                    } else {
                        document.getElementById("แพค1").checked = true;
                        Pack1();
                    }
                }
            }
        });
    }

//Click ชิ้น1
    $("input[id=ชิ้น1]").click(function () {
        if ($(this).is(":checked"))
        {
            Chin1();
        }
    });
//Click แพค1
    $("input[id=แพค1]").click(function () {
        if ($(this).is(":checked"))
        {
            Pack1();
        }
    });
    function Chin1() {
        $('#checkจำนวน1,#checkราคาต่อหน่วย1').html('<font color="red">*</font>');
        $("#vwgr2lotassigneddetail-lnpackqty,#vwgr2lotassigneddetail-lnpackunitcost").attr('readonly', 'readonly');
        //$("#vwgr2detail-grpackunit").attr('disabled', 'disabled');
        $("#vwgr2lotassigneddetail-lnitemqty,#vwgr2lotassigneddetail-lnitemunitcost").removeAttr('readonly');
        $('#checkจำนวนแพค1,#checkหน่วยแพค1,#checkราคาต่อแพค1').html('');
        $('#vwgr2lotassigneddetail-lnitemqty,#vwgr2lotassigneddetail-lnitemunitcost').css('background-color', '#FFFF99');
        $('#vwgr2lotassigneddetail-lnpackqty,#vwgr2lotassigneddetail-lnpackunitcost').css('background-color', 'white');
    }

    function Pack1() {
        $("#vwgr2lotassigneddetail-lnpackqty,#vwgr2lotassigneddetail-lnpackunitcost").removeAttr('readonly');
        //$("#vwgr2detail-grpackunit").removeAttr('disabled');
        $("#vwgr2lotassigneddetail-lnitemqty,#vwgr2lotassigneddetail-lnitemunitcost").attr('readonly', 'readonly');
        $('#checkจำนวนแพค1,#checkหน่วยแพค1,#checkราคาต่อแพค1').html('<font color="red">*</font>');
        $('#checkราคาต่อหน่วย1,#checkจำนวน1').html('');
        $('#vwgr2lotassigneddetail-lnpackqty,#vwgr2lotassigneddetail-lnpackunitcost').css('background-color', '#FFFF99');
        $('#vwgr2lotassigneddetail-lnitemqty,#vwgr2lotassigneddetail-lnitemunitcost').css('background-color', 'white');
    }
        
//คำนวณจำนวนแพค1
$("#vwgr2lotassigneddetail-lnpackqty").keyup(function () {
        $('input[id="vwgr2lotassigneddetail-lnpackqty"]').priceFormat({prefix: ''});
        //var LeftQty = $("#vwgr2lotassignedbalance-lnassignedleftqty").val();
        var uni = parseFloat($("#vwgr2lotassigneddetail-lnpackqty").val().replace(/[,]/g, ""));
        var sku = parseFloat($("#vwgr2lotassigneddetail-sku").val().replace(/[,]/g, ""));
        var prunitcost = parseFloat($("#vwgr2lotassigneddetail-lnitemunitcost").val().replace(/[,]/g, ""));
        var jj = uni * sku;
        var Total = jj * prunitcost;
        if (sku == 0) {
            $("#vwgr2lotassigneddetail-lnitemqty").val(addCommas(uni.toFixed(2)));
        } else if (sku > 0) {
            sku = sku.toFixed(2);
            $("#vwgr2lotassigneddetail-lnitemqty").val(addCommas(jj.toFixed(2)));
            $("#vwgr2lotassigneddetail-extencost").val(addCommas(Total.toFixed(2)));
        }
    });    
        
//คำนวณราคาต่อแพค1
    $("#vwgr2lotassigneddetail-lnpackunitcost").keyup(function () {
        $('input[id="vwgr2lotassigneddetail-lnpackunitcost"]').priceFormat({prefix: ''});
        var qty = $("#vwgr2lotassigneddetail-lnitemqty").val().replace(/[,]/g, "");
        var uni = parseFloat($("#vwgr2lotassigneddetail-lnpackunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2lotassigneddetail-sku").val().replace(/[,]/g, ""));
        var jj = uni / orq;
        var ext = qty * jj;
        $("#vwgr2lotassigneddetail-extencost").val(addCommas(ext.toFixed(2)));
        if (uni > 0) {
            orq = orq.toFixed(2);
            $("#vwgr2lotassigneddetail-lnitemunitcost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2lotassigneddetail-lnitemunitcost").val('0.00');
        }
    });
        
//คำนวณขอซื้อ1
    $("#vwgr2lotassigneddetail-lnitemqty").keyup(function () {
        $('input[id="vwgr2lotassigneddetail-lnitemqty"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwgr2lotassigneddetail-lnitemqty").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2lotassigneddetail-lnitemunitcost").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwgr2lotassigneddetail-extencost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2lotassigneddetail-extencost").val('0.00');
        }
    });
        
//คำนวณราคาต่อหน่วย1
    $("#vwgr2lotassigneddetail-lnitemunitcost").keyup(function () {
        $('input[id="vwgr2lotassigneddetail-lnitemunitcost"]').priceFormat({prefix: ''});
        var uni = parseFloat($("#vwgr2lotassigneddetail-lnitemunitcost").val().replace(/[,]/g, ""));
        var orq = parseFloat($("#vwgr2lotassigneddetail-lnitemqty").val().replace(/[,]/g, ""));
        var jj = uni * orq;
        if (orq > 0) {
            uni = uni.toFixed(2);
            $("#vwgr2lotassigneddetail-extencost").val(addCommas(jj.toFixed(2)));
        } else {
            $("#vwgr2lotassigneddetail-extencost").val('0.00');
        }
    });
        

//On Save Assign Lot
$('#form_assign_lot').on('beforeSubmit', function (e)
    {
//SaveData
        var \$form = $(this);
                $.post(
                        \$form.attr('action'), // serialize Yii2 form
                        \$form.serialize()
                        )
                .done(function(result) {
                if (result == "success")
                {
                    Notify('AssignLot Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
                    GetBalance();
                    document.getElementById("btn_assignlot").disabled = false;
                    document.getElementById("btn_updatelot").disabled = true;
                    $('#vwgr2lotassigneddetail-iteminternallotnum').val('');
                    $.pjax.reload({container: '#table_lotassign_temp'});
                } else
                {
                    $('#message').html(result);
                    alert('บันทึก Lot Number ได้ไม่เกินจำนวนคงเหลือ!');
                }
            })
            .fail(function ()
            {
                console.log('server error');
            });
            return false;
    });
                
function init_click_handlers() {
//Edit
$('.activity-update-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        var ItemID = $("#vwgr2detail-itemid").val();
        $.ajax({
            url: 'index.php?r=Purchasing/gr/edititem-lotassign',
            type: 'POST',
            data: {id: fID},
            dataType: 'json',
            success: function (data) {
                document.getElementById("btn_updatelot").disabled = false;
                document.getElementById("btn_assignlot").disabled = true;
                if (data.LNItemPackID == null) {
                    document.getElementById("ชิ้น1").checked = true;
                    Chin1();
                } else {
                    document.getElementById("แพค1").checked = true;
                    Pack1();
                }
                $('#vwgr2lotassigneddetail-iteminternallotnum').val(data.ItemInternalLotNum);
                $('#vwgr2lotassigneddetail-itemexternallotnum').val(data.ItemExternalLotNum);
                $('#vwgr2lotassigneddetail-itemexpdate').val(data.ItemExpDate);
                $('#vwgr2lotassigneddetail-lnpackqty').val(data.LNPackQty);
                $('#vwgr2lotassigneddetail-sku').val(data.ItemPackSKUQty);
                $('#vwgr2lotassigneddetail-lnpackunitcost').val(data.LNPackUnitCost);
                $('#vwgr2lotassigneddetail-lnitemqty').val(data.LNItemQty);
                $('#vwgr2lotassigneddetail-dispunit').val(data.DispUnit);
                $('#vwgr2lotassigneddetail-lnitemunitcost').val(data.LNItemUnitCost);
                $('#vwgr2lotassigneddetail-extencost').val(data.LNExtenedCost);
                $('#ItemID1').val(ItemID);
                $('#ids_grlot').val(data.ids_gr);
                if ($('#แพค1').is(':checked')) {
                    $("#vwgr2lotassigneddetail-packunit").val(data.ItemPackUnit).trigger("change");
                }
                $.pjax.reload({container: '#table_lotassign_temp'}); 
            }
        });
    });
//Delete
    $('.activity-delete-link').click(function (e) {
        var fID = $(this).closest('tr').data('key');
        bootbox.confirm('Are you sure?', function (result) {
            if (result) {
                //Delete
                $.post(
                        'index.php?r=Purchasing/gr/deleteitem',
                        {
                            id: fID
                        },
                function (data)
                {
                    GetBalance();
                    $.pjax.reload({container: '#table_lotassign_temp'});
                }
                );
            }
        });
    });    
    }
    init_click_handlers(); //first run
    $('#table_lotassign_temp').on('pjax:success', function () {
        init_click_handlers(); //reactivate links in grid after pjax update
    });
//
$(document).ready(function () {
        var ItemInternalLotNum = $("#vwgr2lotassigneddetail-iteminternallotnum").val();
        var LefyQty = $("#vwgr2lotassignedbalance-lnassignedleftqty").val();
        if(ItemInternalLotNum == ""){
            document.getElementById("btn_updatelot").disabled = true;
        } 
        if(LefyQty == "0.00"){
            document.getElementById("btn_assignlot").disabled = true;    
        }
    });
//คำนวณ on chang หน่วยแพค1
        $('#vwgr2lotassigneddetail-packunit').on('change', function (e) {
            var ItemID = $("#vwgr2detail-itemid").val();
            var ItemPackUnit = $(this).find("option:selected").val();
            var qty = parseFloat($("#vwgr2lotassigneddetail-lnpackqty").val().replace(/[,]/g, ""));
            var GRUnitCost = parseFloat($("#vwgr2lotassigneddetail-lnitemunitcost").val().replace(/[,]/g, ""));
            if($('#แพค1').is(':checked')) {
                $.ajax({
                    url: "index.php?r=Purchasing/gr/get-qty",
                    type: "post",
                    data: {ItemID: ItemID, ItemPackUnit: ItemPackUnit},
                    dataType: 'json',
                    success: function (data) {
                        $('#vwgr2lotassigneddetail-sku').val(data.ItemPackSKUQty);
                        var SKUQty = parseFloat($("#vwgr2lotassigneddetail-sku").val().replace(/[,]/g, ""));
                        var jj = (SKUQty) * (qty);
                        var Total = jj * GRUnitCost;
                        if (data.qty == 0) {
                            $('#vwgr2lotassigneddetail-lnitemqty').val('0.00');
                        } else {
                            $("#vwgr2lotassigneddetail-lnitemqty").val(addCommas(jj.toFixed(2)));
                            $("#vwgr2lotassigneddetail-extencost").val(addCommas(Total.toFixed(2)));
                        }
                    }
                });
            }
        });
//GetBalance
function GetBalance() {
        var ids_gr = $("#vwgr2detail-ids_gr").val();
        $.ajax({
            url: "index.php?r=Purchasing/gr/get-balance",
            type: "post",
            data: {id: ids_gr},
            dataType: "JSON",
            success: function (data) {
                $("#vwgr2lotassignedbalance-lnassignedqty").val(data.LNAssignedQty);
                $("#vwgr2lotassignedbalance-lnassignedleftqty").val(data.LNAssignedLeftQty);
                $("#vwgr2lotassignedbalance-grunit").val(data.GRUnit);
                $('#vwgr2lotassigneddetail-itemexternallotnum').val('');
                $('#vwgr2lotassigneddetail-itemexpdate').val('');

                if (data.LNAssignedLeftQty == "0.00") {
                    //$('#form_assign_lot').trigger("reset");
                    document.getElementById("btn_assignlot").disabled = true;
                    if ($('#แพค1').is(':checked')) {
                        $('#vwgr2lotassigneddetail-lnpackqty,#vwgr2lotassigneddetail-lnpackunitcost').css('background-color', 'white');
                        $('#checkจำนวนแพค1,#checkหน่วยแพค1,#checkราคาต่อแพค1').html('');
                    } else {
                        $('#vwgr2lotassigneddetail-lnitemqty,#vwgr2lotassigneddetail-lnitemunitcost').css('background-color', 'white');
                        $('#checkราคาต่อหน่วย1,#checkจำนวน1').html('');
                    }
                } else {
                    document.getElementById("btn_assignlot").disabled = false;
                    //เช็คว่าเป็นแพคหรือชิ้น แล้วคำนวณ
                    if (data.LNItemPackID == null) {
                        if (data.LNAssignedLeftQty == null) {
                            Receive();
                        } else {
                            Chin1();
                            Receive();
                            $("#vwgr2lotassigneddetail-lnitemqty").val(data.LNAssignedLeftQty);
                            var Qty = parseFloat($("#vwgr2lotassigneddetail-lnitemqty").val().replace(/[,]/g, ""));
                            var UnitCost = parseFloat($("#vwgr2lotassigneddetail-lnitemunitcost").val().replace(/[,]/g, ""));
                            var ExtenCost = Qty * UnitCost;
                            if (UnitCost > 0) {
                                Qty = Qty.toFixed(2);
                                $("#vwgr2lotassigneddetail-extencost").val(addCommas(ExtenCost.toFixed(2)));
                            } else {
                                $("#vwgr2lotassigneddetail-extencost").val('0.00');
                            }
                        }
                    } else {
                        if (data.LNAssignedLeftQty == null) {
                            Receive();
                        } else {
                            Pack1();
                            $("#vwgr2lotassigneddetail-lnpackqty").val(data.LNAssignedLeftQty);
                            var PackQty = parseFloat($("#vwgr2lotassigneddetail-lnpackqty").val().replace(/[,]/g, ""));
                            var SKU = parseFloat($("#vwgr2lotassigneddetail-sku").val().replace(/[,]/g, ""));
                            var GRUnitCost = parseFloat($("#vwgr2lotassigneddetail-lnitemunitcost").val().replace(/[,]/g, ""));
                            var jj = PackQty * SKU;
                            var Total = jj * GRUnitCost;
                            if (SKU == 0) {
                                $("#vwgr2lotassigneddetail-lnitemqty").val(addCommas(PackQty.toFixed(2)));
                            } else if (SKU > 0) {
                                SKU = SKU.toFixed(2);
                                $("#vwgr2lotassigneddetail-lnitemqty").val(addCommas(jj.toFixed(2)));
                                $("#vwgr2lotassigneddetail-extencost").val(addCommas(Total.toFixed(2)));
                            }
                        }
                    }
                }
            }
        });
    }
//SaveLotNumber
$('#SaveLotNumber').click(function (e) {
        var ids_gr = $("#vwgr2detail-ids_gr").val();
        $.post(
                'index.php?r=Purchasing/gr/save-lot-number',
                {
                    ids_gr: ids_gr
                },
        function (data)
        {
            Notify('SaveLotNumber Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
        }
        );
    });

JS;
        $this->registerJs($script);
        ?>
