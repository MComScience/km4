<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use miloschuman\highcharts\Highcharts;
use frontend\assets\WaitMeAsset;
use frontend\assets\ScriptCamAsset;
use frontend\assets\LaddaAsset;
use frontend\assets\DataTableAsset;
use frontend\assets\AutoNumericAsset;

WaitMeAsset::register($this);
ScriptCamAsset::register($this);
LaddaAsset::register($this);
DataTableAsset::register($this);
AutoNumericAsset::register($this);

$this->title = Yii::t('app', 'บันทึกรายการสินค้ายา');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'จัดการรายการสินค้า'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$data = \app\modules\Inventory\models\Tbrxordercondition::findOne(['TMTID_GPU' => $modelitem['TMTID_GPU']]);
$checkdefault = \app\modules\Inventory\models\TbGenericproductGp::findOne(['TMTID_GP' => $modelitem['TMTID_GP']]);
if ($checkdefault['DrugGroup_GP'] == '6' || $Narcotics = $data['Narcotics_required'] == '1') {
    $Narcotics = '1';
} else {
    $Narcotics = $data['Narcotics_required'];
}
if ($checkdefault['ISED_CatID'] == '2' || $NED = $data['NED_required'] == '1') {
    $NED = '1';
} else {
    $NED = $data['NED_required'];
}
$CPR = $data['CPR_required'];
$Drug2 = $data['Drug2MDApprove_required'];
$DUE = $data['DUE_required'];
$OCPA = $data['OCPA_required'];
$Jor2 = $data['Jor2_required'];

$script = <<< JS
$("#tbrxordercondition-narcotics_required").val('$Narcotics');
$("#tbrxordercondition-ned_required").val('$NED'); 
$("#tbrxordercondition-due_required").val('$DUE'); 
$("#tbrxordercondition-drug2mdapprove_required").val('$Drug2'); 
$("#tbrxordercondition-ocpa_required").val('$OCPA'); 
$("#tbrxordercondition-cpr_required").val('$CPR'); 
$("#tbrxordercondition-jor2_required").val('$Jor2');
JS;
$this->registerJs($script);
?>
<?= yii2mod\alert\Alert::widget() ?>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        สร้างรหัสสินค้า
                    </a>
                </li>
            </ul>

            <div class="tab-content" style="background-color: white">
                <div id="home" class="tab-pane in active">
                    <div class="well">
                        <div class="tb-item-form">
                            <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'options' => ['enctype' => 'multipart/form-data'], 'id' => 'from_additemnew']); ?>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($modelitem, 'ItemID', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'TMTID_TPU', ['label' => 'รหัสยาการค้า', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($modelitem, 'TMTID_TPU', ['showLabels' => false])->textInput(['style' => 'background-color: white', 'readonly' => true]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'Item_workingcode', ['label' => 'Working Code', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($modelitem, 'Item_workingcode', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99',]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right">ชื่อยาการค้า</label>
                                        <div class="col-sm-7">
                                            <input class="form-control" readonly="" style="background-color: white" id="" value="<?php echo $querytpu['TradeName_TMT'] ?>"/>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'ItemName', ['label' => 'รายละเอียดยาสามัญ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'ItemName', ['showLabels' => false])->textarea([
                                                'style' => 'background-color: #ffff99',
                                                //'readonly' => true,
                                                'rows' => 3,
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'Item_label', ['label' => 'ชื่อบนฉลากยา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($modelitem, 'Item_label', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99', 'maxlength' => 100,]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'ItemSpecPrep', ['label' => 'รูปแบบการเตรียมยา' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'ItemSpecPrep', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: #FFFF99',
                                                    //'value' => 'R1'
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'itemdosageform', ['label' => 'รูปแบบยา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'itemdosageform', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: white',
                                                'readonly' => true,
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'itemstmum', ['label' => 'ความแรงยา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'itemstmum', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: white',
                                                'readonly' => true,
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'itemContVal', ['label' => 'ขนาดบรรจุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'itemContVal', ['showLabels' => false])->textInput([
                                                'style' => 'background-color: #FFFF99',
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'itemContUnit', ['label' => 'หน่วยของขนาดบรรจุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'itemContUnit', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => yii\helpers\ArrayHelper::map(\app\models\TbContunit::find()->all(), 'ContUnitID', 'ContUnit'),
                                                'pluginOptions' => [
                                                    'placeholder' => 'Select Option',
                                                    'allowClear' => true
                                                ],
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'itemDispUnit', ['label' => 'หน่วยการจ่าย', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?=
                                            $form->field($modelitem, 'itemDispUnit', ['showLabels' => false])->widget(Select2::classname(), [
                                                'data' => yii\helpers\ArrayHelper::map(app\models\TbDispunit::find()->all(), 'DispUnitID', 'DispUnit'),
                                                'pluginOptions' => [
                                                    'placeholder' => 'Select Option',
                                                    'allowClear' => true,
                                                    'disabled' => true,
                                                ],
                                            ]);
                                            ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <?= Html::activeLabel($modelitem, 'itempBarcodeNum', ['label' => 'Item Barcode', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                        <div class="col-sm-7">
                                            <?= $form->field($modelitem, 'itempBarcodeNum', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99',]); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 1</label>
                                        <div class="col-sm-7">
                                            <div id="webcam1"></div>
                                            <p><img id="image1" src="<?php echo!empty($modelitem->ItemPic1) ? Yii::getAlias('@web') . '/' . $modelitem->ItemPic1 : ''; ?>"/></p>
                                            <a class="btn btn-small btn-success"  id="btnshowcamera1" onclick="showwebcam(1)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a> <a class="btn btn-small btn-danger" onclick="btndeleteimg(1)"><span class="glyphicon glyphicon-trash"></span></a>
                                            <a class="btn btn-small btn-success hidden" id="btntakesnapimg1" onclick="base64_toimage(1)">ถ่ายภาพ</a>
                                            <input type="hidden" id="tbitem-itempic1" name="TbItem[ItemPic1]" value="<?php echo $modelitem->ItemPic1; ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 3</label>
                                        <div class="col-sm-7">
                                            <div id="webcam3"></div>
                                            <p><img id="image3" src="<?php echo!empty($modelitem->ItemPic3) ? Yii::getAlias('@web') . '/' . $modelitem->ItemPic3 : ''; ?>"/></p>
                                            <a class="btn btn-small btn-success"  id="btnshowcamera3" onclick="showwebcam(3)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a> <a class="btn btn-small btn-danger" onclick="btndeleteimg(3)"><span class="glyphicon glyphicon-trash"></span></a>
                                            <a class="btn btn-small btn-success hidden" id="btntakesnapimg3" onclick="base64_toimage(3)">ถ่ายภาพ</a>
                                            <input type="hidden" id="tbitem-itempic3" name="TbItem[ItemPic3]" value="<?php echo $modelitem->ItemPic3; ?>"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <input id="order_condition_id" type="hidden" value="<?php echo $modelrxorder['order_condition_id'] ?>"/>
                                        <input id="itemContUnit" type="hidden" value="<?php echo $modelitem['itemContUnit'] ?>"/>
                                        <input id="itemDispUnit" type="hidden" value="<?php echo $modelitem['itemDispUnit'] ?>"/>
                                        <input id="TMTID_GPU" type="hidden" value="<?php echo $modelitem['TMTID_GPU'] ?>"/>
                                        <input id="TMTID_GP" type="hidden" value="<?php echo $modelitem['TMTID_GP'] ?>"/>
                                        <br/><br/><br/><br/>
                                        <br/><br/><br/><br/>
                                        <br/><p></p>
                                        <div class="invoice-container">
                                            <div class="panel panel-success">
                                                <div class="panel-heading bg-success" style="text-align: center">
                                                    <h5 class="white"><?= Html::encode('โรงพยาบาลมะเร็งอุดรธานี') ?></h5>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <a class="btn btn-block btn-default disabled">HN</a>
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <a class="btn btn-block btn-default disabled">ชื่อ-นามสกุล</a>
                                                        </div>
                                                    </div>
                                                    <p></p>
                                                    <div class="row">
                                                        <div class="col-xs-10">
                                                            <a class="btn btn-block  disabled" style="background-color: #ddd"><div id="druglabel" ></div></a>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <a class="btn btn-block btn-default disabled">จำนวน</a>
                                                        </div>
                                                    </div>
                                                    <p></p>

                                                    <ul>
                                                        <li>
                                                            <a class="btn btn-block disabled" style="text-align: left;background-color: #ddd"><div id="drugadminlabel"></div></a>
                                                        </li>
                                                        <p></p>
                                                        <li>
                                                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #ddd"><div id="druglabel1"></div></a>
                                                        </li>
                                                        <p></p>
                                                        <li>
                                                            <a class="btn btn-block  disabled" style="text-align: left;background-color: #ddd"><div id="druglabel2"></div></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>                
                                        </div> <!-- / end client details section -->



                                        <div class="form-group">
                                            <?= Html::activeLabel($modelitem, 'ItemAutoLotNum', ['label' => 'ควบคุม Lot Number', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                            <div class="col-sm-7">
                                                <?=
                                                $form->field($modelitem, 'ItemAutoLotNum', ['showLabels' => false])->radioList($modelitem->getItemAutoLotNum(), ['inline' => true, 'item' => function($index, $label, $name, $checked, $value) {
                                                        $check = $checked ? ' checked="checked"' : '';
                                                        $return = '<label class="modal-radio">';
                                                        $return .= '<input type="radio"  ' . $check . ' name="' . $name . '" value="' . $value . '" tabindex="3">';
                                                        $return .= '<i></i>';
                                                        $return .= '<span class="text">' . ucwords($label) . '</span>';
                                                        $return .= '</label>';

                                                        return $return;
                                                    }]);
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?= Html::activeLabel($modelitem, 'ItemExpDateControl', ['label' => 'เปลี่ยนสินค้าก่อนหมดอายุ(วัน)', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                            <div class="col-sm-7">
                                                <?= $form->field($modelitem, 'ItemExpDateControl', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99', 'value' => 90]); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?= Html::activeLabel($modelitem, 'ItemMinOrderQty', ['label' => 'ปริมาณน้อยสุด/การสั่งซื้อ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                            <div class="col-sm-7">
                                                <?= $form->field($modelitem, 'ItemMinOrderQty', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99',]); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <?= Html::activeLabel($modelitem, 'itemMinOrderLeadtime', ['label' => 'ระยะเวลาในการจัดหา', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                                            <div class="col-sm-7">
                                                <?= $form->field($modelitem, 'itemMinOrderLeadtime', ['showLabels' => false])->textInput(['style' => 'background-color: #FFFF99',]); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 2</label>
                                            <div class="col-sm-7">
                                                <div id="webcam2"></div>
                                                <p><img id="image2" src="<?php echo!empty($modelitem->ItemPic2) ? Yii::getAlias('@web') . '/' . $modelitem->ItemPic2 : ''; ?>" /></p>
                                                <a class="btn btn-small btn-success"  id="btnshowcamera2" onclick="showwebcam(2)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a> <a class="btn btn-small btn-danger" onclick="btndeleteimg(2)"><span class="glyphicon glyphicon-trash"></span></a>
                                                <a class="btn btn-small btn-success hidden" id="btntakesnapimg2" onclick="base64_toimage(2)">ถ่ายภาพ</a>
                                                <input type="hidden" id="tbitem-itempic2" name="TbItem[ItemPic2]" value="<?php echo $modelitem->ItemPic2; ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right" for="tbitem-itempic2">ภาพสินค้า ที่ 4</label>
                                            <div class="col-sm-7">
                                                <div id="webcam4"></div>
                                                <p><img id="image4" src="<?php echo!empty($modelitem->ItemPic4) ? Yii::getAlias('@web') . '/' . $modelitem->ItemPic4 : ''; ?>"/></p>
                                                <a class="btn btn-small btn-success"  id="btnshowcamera4" onclick="showwebcam(4)"> <i class="glyphicon glyphicon-camera"></i> ถ่ายภาพ</a>
                                                <a class="btn btn-small btn-danger" onclick="btndeleteimg(4)"><span class="glyphicon glyphicon-trash"></span></a>
                                                <a class="btn btn-small btn-success hidden" id="btntakesnapimg4" onclick="base64_toimage(4)">ถ่ายภาพ</a>
                                                <input type="hidden" id="tbitem-itempic4" name="TbItem[ItemPic4]" value="<?php echo $modelitem->ItemPic4; ?>"/>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div><!--/End Row -->

                            <hr>
                            <div class="row">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs" id="myTab">
                                        <li class="active">
                                            <a data-toggle="tab" href="#home1">
                                                ขนาดแพค
                                            </a>
                                        </li>

                                        <li class="tab-success">
                                            <a data-toggle="tab" href="#profile">
                                                ข้อมูลการจัดเก็บ
                                            </a>
                                        </li>

                                        <li class="tab-success">
                                            <a data-toggle="tab" href="#price">
                                                ราคาขายสินค้า
                                            </a>
                                        </li>
                                        <li class="tab-success">
                                            <a data-toggle="tab" href="#rxorder">
                                                เอกสารประกอบการเบิกจ่าย
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="home1" class="tab-pane in active">
                                            <?php if ($true == 'yes' || $true == 'edit') { ?>
                                                <a class="btn btn-success" id="บันทึกขนาดแพค"><i class="glyphicon glyphicon-plus"></i>บันทึกขนาดแพค</a>
                                            <?php } ?>
                                            <div id="query_itempack"></div>
                                        </div>

                                        <div id="profile" class="tab-pane">
                                            <?php if ($true == 'yes' || $true == 'edit') { ?>
                                                <a class="btn btn-success" id="บันทึกข้อมูลการจัดเก็บ"><i class="glyphicon glyphicon-plus"></i>บันทึกข้อมูลการจัดเก็บ</a>
                                            <?php } ?>
                                            <div id="query_stklevel"></div>
                                        </div>

                                        <div id="price" class="tab-pane">
                                            <?php if ($true == 'yes' || $true == 'edit') { ?>
                                                <a class="btn btn-success" id="บันทึกราคาขาย"><i class="glyphicon glyphicon-plus"></i>ราคาขาย</a>
                                            <?php } ?>
                                            <div id="query_itemprice"></div>
                                            <hr>
                                            <?php /*
                                              <?php if ($true == 'yes' || $true == 'edit') { ?>
                                              <a class="btn btn-success" id="เบิกได้ตามสิทธิ์การรักษา"><i class="glyphicon glyphicon-plus"></i>เบิกได้ตามสิทธิ์การรักษา</a>
                                              <a class="btn btn-info" id="แก้ไขราคาตามสิทธิ์การรักษา"><i class="glyphicon glyphicon-pencil"></i>แก้ไขราคาตามสิทธิ์การรักษา</a>
                                              <?php } ?>
                                              <div id="query_credititem"></div>
                                             * 
                                             */ ?>
                                        </div>

                                        <div id="rxorder" class="tab-pane">

                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-xs-6 col-sm-3">

                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">
                                                        <?=
                                                        $form->field($modelrxorder, 'Narcotics_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            //'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs'
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ],
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">
                                                        <?=
                                                        $form->field($modelrxorder, 'Drug2MDApprove_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            //'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs'
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ],
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-xs-6 col-sm-3">

                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">
                                                        <?=
                                                        $form->field($modelrxorder, 'Jor2_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            //'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs'
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ],
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">
                                                        <?=
                                                        $form->field($modelrxorder, 'OCPA_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            //'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs',
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ],
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-xs-6 col-sm-3">

                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">
                                                        <?=
                                                        $form->field($modelrxorder, 'NED_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            //'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs'
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ],
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">
                                                        <?=
                                                        $form->field($modelrxorder, 'CPR_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            // 'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs',
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ],
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-xs-6 col-sm-3">

                                                    </div>
                                                    <div class="col-xs-6 col-sm-2">
                                                        <?=
                                                        $form->field($modelrxorder, 'DUE_required')->widget(kartik\checkbox\CheckboxX::classname(), [
                                                            'autoLabel' => true,
                                                            //'initInputType' => \kartik\checkbox\CheckboxX::INPUT_CHECKBOX,
                                                            'pluginOptions' => [
                                                                'threeState' => false,
                                                                'size' => 'xs'
                                                            ],
                                                            'options' => [
                                                                'data-toggle' => 'checkbox-x'
                                                            ]
                                                        ])->label(false);
                                                        ?>
                                                    </div>
                                                    <div class="col-xs-2 col-sm-2">
                                                        <?=
                                                        $form->field($modelrxorder, 'due_id', ['showLabels' => false])->widget(Select2::classname(), [
                                                            'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\Tbdueform::find()->all(), 'due_id', 'due_decs'),
                                                            'pluginOptions' => [
                                                                'placeholder' => '---Select Option---',
                                                                'allowClear' => true,
                                                            ],
                                                        ]);
                                                        ?>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-4">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-xs-6 col-sm-3">

                                                    </div>
                                                    <div class="col-xs-6 col-sm-2">
                                                        <a class="btn btn-danger" onclick="DeleteRxorder(this);" id="btn-clearrxordersave">Clear</a>
                                                        <a class="btn btn-success ladda-button" onclick="SaveRxorder(this);" id="btn-rxordersave" data-style="expand-left">บันทึก</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="horizontal-space"></div>
                            </div><!--/End Row -->
                        </div>
                    </div><!--/End Well -->
                    <div class="form-group" style="text-align: right">
                        <?= Html::a('Close', ['index'], ['class' => 'btn btn-default']) ?>
                        <?php if ($true == 'yes' || $true == 'edit') { ?>
                            <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                            <?= Html::a('ปรับปรุงยาสามัญ', ['create', 'gpu' => $modelitem['TMTID_GPU'], 'itemid' => $modelitem['ItemID'], 'edit' => 'no'], ['class' => 'btn btn-info']) ?>
                            <?= Html::submitButton($modelitem->isNewRecord ? Yii::t('app', 'บันทึกข้อมูลสินค้า') : Yii::t('app', 'บันทึกข้อมูลสินค้า'), ['class' => $modelitem->isNewRecord ? 'btn btn-success ' : 'btn btn-primary ']) ?>
                        <?php } ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="horizontal-space"></div>
</div>

<!--/Modal บันทึก -->
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'modaladditem',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg modal-primary',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'closeButton' => false,
]);
?>
<div id="from_additem"></div>
<?php \yii\bootstrap\Modal::end(); ?>

<!--/Script -->
<?php if ($true == 'yes' || $true == 'edit') { ?>
    <?php
    $script = <<< JS
function Getdruglabel() {
        var itemid = $("#tbitem-itemid").val();
        run_waitMelabel();
        $.ajax({
            url: "getdruglabeltpu",
            type: "post",
            data: {itemid: itemid},
            dataType: "JSON",
            success: function (result) {
                $('#druglabel').html(result.label);
                $('#drugadminlabel').html(result.drugadmin);
                $('#druglabel1').html(result.druglabel1);
                $('#druglabel2').html(result.druglabel2);
                $('.panel-body').waitMe('hide');
            }
        });
    }
            
function run_waitMelabel(effect) {
        $('.panel-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }

function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'ios',//roundBounce
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}

$(function () {
    /* บันทึกราคาขาย */
    $('#บันทึกราคาขาย').click(function (e) {
        var ItemID = $("#tbitem-itemid").val();
        var FSN_GPU = $("#tbitem-itemname").val();
        var id = '';
        var e = document.getElementById("tbitem-itemdispunit");
        var DispUnit = e.options[e.selectedIndex].text;
        LoadingClass();
        $.ajax({
            url: "checkitemidprice",
            type: "post",
            data: {ItemID: ItemID},
            dataType: "JSON",
            success: function (result) {
                if (result != null) {
                    $('.page-content').waitMe('hide');
                    swal({
                        title: "",
                        text: "ราคาขายสินค้านี้ถูกบันทึกในระบบแล้ว!",
                        type: "warning"
                    });
                } else {

                    $.get(
                            'additemprice',
                            {
                                id: id
                            },
                            function (data)
                            {
                                $("#modaladditem").find(".modal-body").html(data);
                                $('#from_additem').html(data);
                                $(".modal-title").html("บันทึกราคาขาย");
                                $('.page-content').waitMe('hide');
                                $('#modaladditem').modal('show');
                                $("#tbitemidprice-itemid").val(ItemID);
                                $("#tbitemprice-itemname").val(FSN_GPU);
                                $("#tbitemprice-dispunit").val(DispUnit);
                            }
                    );
                }
            }
        });
    });
    /* เบิกได้ตามสิทธิ์การรักษา */
    $('#เบิกได้ตามสิทธิ์การรักษา').click(function (e) {
        var ItemID = $("#tbitem-itemid").val();
        var itemname = $("#tbitem-itemname").val();
        LoadingClass();
        $.ajax({
            url: "checkitemidprice",
            type: "post",
            data: {ItemID: ItemID},
            dataType: "JSON",
            success: function (result) {
                if (result == null) {
                    $('.page-content').waitMe('hide');
                    swal({
                        title: "",
                        text: "กรุณาบันทึกราคาขาย!",
                        type: "warning"
                    });
                } else {

                    $.get(
                            'addcredit-price-item',
                            {
                                id: ItemID
                            },
                            function (data)
                            {
                                $("#modaladditem").find(".modal-body").html(data);
                                $('#from_additem').html(data);
                                $(".modal-title").html("บันทึกราคาเบิกได้ตามสิทธิ");
                                $('.page-content').waitMe('hide');
                                $('#modaladditem').modal('show');
                                $("#vwitempricelistscl-itemid").val(ItemID);
                                $("#vwitempricelistscl-itemname").val(itemname);
                            }
                    );
                }
            }
        });
    });
    /* เบิกได้ตามสิทธิ์การรักษา */
    /*
     $('#เบิกได้ตามสิทธิ์การรักษา').click(function (e) {
     var ItemID = $("#tbitem-itemid").val();
     var FSN_GPU = $("#tbitem-itemname").val();
     var id = '';
     var e = document.getElementById("tbitem-itemdispunit");
     var DispUnit = e.options[e.selectedIndex].text;
     $('#modaladditem').modal('show');
     $.get(
     'addcredititem',
     {
     id: id
     },
     function (data)
     {
     $("#modaladditem").find(".modal-body").html(data);
     $('#from_additem').html(data);
     $(".modal-title").html("บันทึกราคาเบิกได้ตามสิทธิ");
     $("#tbcredititem-itemid").val(ItemID);
     $("#tbitemprice-itemname").val(FSN_GPU);
     $("#tbitemprice-dispunit").val(DispUnit);
     }
     );
     });*/
    /* บันทึกขนาดแพค */
    $('#บันทึกขนาดแพค').click(function (e) {
        var ItemID = $("#tbitem-itemid").val();
        var FSN_GPU = $("#tbitem-itemname").val();
        var TMTID_GPU = $("#TMTID_GPU").val();
        var id = '';
        var e = document.getElementById("tbitem-itemdispunit");
        var DispUnitval = e.options[e.selectedIndex].val;
        var DispUnit = e.options[e.selectedIndex].text;
        LoadingClass();
        $.get(
                'additem-pack',
                {
                    id: id
                },
                function (data)
                {
                    $("#modaladditem").find(".modal-body").html(data);
                    $('#from_additem').html(data);
                    $(".modal-title").html("บันทึกขนาดแพค");
                    $('.page-content').waitMe('hide');
                    $('#modaladditem').modal('show');
                    $("#tbitempack-itemid").val(ItemID);
                    $("#tbitempack-fsn_gpu").val(FSN_GPU);
                    $("#tbitempack-dispunit").val(DispUnit);
                    $("#tbitempack-tmtid_gpu").val(TMTID_GPU);
                    //$('#form_drugindication').trigger('reset');
                }
        );
    });
    /* บันทึกข้อมูลการจัดเก็บ */
    $('#บันทึกข้อมูลการจัดเก็บ').click(function (e) {
        var ItemID = $("#tbitem-itemid").val();
        var FSN_GPU = $("#tbitem-itemname").val();
        var id = '';
        var e = document.getElementById("tbitem-itemdispunit");
        var DispUnit = e.options[e.selectedIndex].text;
        LoadingClass();
        $.get(
                'addstklevel',
                {
                    id: id
                },
                function (data)
                {
                    $("#modaladditem").find(".modal-body").html(data);
                    $('#from_additem').html(data);
                    $(".modal-title").html("บันทึกข้อมูลการจัดเก็บ");
                    $('.page-content').waitMe('hide');
                    $('#modaladditem').modal('show');
                    $("#tbstklevelinfo-itemid").val(ItemID);
                    $("#fsn_gpu").val(FSN_GPU);
                    $("#dispunit").val(DispUnit);
                }
        );
    });
});
$('#แก้ไขราคาตามสิทธิ์การรักษา').click(function (e) {
    var ItemID = $("#tbitem-itemid").val();
    var itemname = $("#tbitem-itemname").val();
    LoadingClass();
    $.ajax({
        url: "checkitemidprice",
        type: "post",
        data: {ItemID: ItemID},
        dataType: "JSON",
        success: function (result) {
            if (result == null) {
                $('.page-content').waitMe('hide');
                swal({
                    title: "",
                    text: "กรุณาบันทึกราคาขาย!",
                    type: "warning"
                });
            } else {

                $.get(
                        'addcredit-price-item',
                        {
                            id: ItemID
                        },
                        function (data)
                        {
                            $("#modaladditem").find(".modal-body").html(data);
                            $('#from_additem').html(data);
                            $(".modal-title").html("บันทึกราคาเบิกได้ตามสิทธิ");
                            $('.page-content').waitMe('hide');
                            $('#modaladditem').modal('show');
                            $("#vwitempricelistscl-itemid").val(ItemID);
                            $("#vwitempricelistscl-itemname").val(itemname);
                        }
                );
            }
        }
    });
});
/*  เปลี่ยนหน่วย ตาม ID  */
$(document).ready(function () {
    var CoutUnit = $("#itemContUnit").val();
    var DispUnit = $("#itemDispUnit").val();
    $("#tbitem-itemcontunit").val(CoutUnit).trigger("change");
    $("#tbitem-itemdispunit").val(DispUnit).trigger("change");
    $('#btn-rxordersave').addClass("disabled", "disabled");
    $("#tbrxordercondition-due_id").attr('disabled', 'disabled');
    GettableItempack();
    GettableStklevel();
    Gettableitemprice();
    //Gettablecredititem();
    Getrxorder();
    Getdruglabel();
});
/*   Query Table ItemPAck     */
function GettableItempack() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'true';
    $.ajax({
        url: "gettableitempack",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_itempack").html(result.table);
            $('#table_tb_itempack').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                "bFilter": false,
                "bSortable" : false,
                "bAutoWidth": true,
                "ordering": false,
                "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
}
/*   Query Table stklevel     */
function GettableStklevel() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'true';
    $.ajax({
        url: "gettablestklevel",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_stklevel").html(result.table);
            $('#table_tb_stk_levelinfo').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
}     
/*   Query RXORDER    */
function Getrxorder() {
    var gpu = $("#TMTID_GPU").val();
    var gp = $("#TMTID_GP").val();
    $.ajax({
        url: "getrxorder",
        type: "post",
        data: {gpu: gpu, gp: gp},
        dataType: "JSON",
        success: function (result) {
            if (result.due_id != '0') {
                $("#tbrxordercondition-due_id").val(result.due_id).trigger("change");
            }
            $("#order_condition_id").val(result.id);
        }
    });
}
/* Disabled Button  */
$('input[data-toggle="checkbox-x"]').on('change', function() {
    $('#btn-rxordersave').removeClass("disabled", "disabled");
});
$('input[id="tbrxordercondition-due_required"]').on('change', function() {
    $("#tbrxordercondition-due_id").removeAttr('disabled');
});
JS;
    $this->registerJs($script, \yii\web\View::POS_END, 'additem');
    ?>

    <script>
        /* Save Rxorder */
        function SaveRxorder(e) {
            var l = $('.ladda-button').ladda();
            l.ladda('start');
            var id = $("#order_condition_id").val();
            var gpu = $("#TMTID_GPU").val();
            var narcotics = $("#tbrxordercondition-narcotics_required").val();
            var ned = $("#tbrxordercondition-ned_required").val();
            var due = $("#tbrxordercondition-due_required").val();
            var e = document.getElementById("tbrxordercondition-due_id");
            var due_id = e.options[e.selectedIndex].value;
            var drug2 = $("#tbrxordercondition-drug2mdapprove_required").val();
            var ocpa = $("#tbrxordercondition-ocpa_required").val();
            var cpr = $("#tbrxordercondition-cpr_required").val();
            var jor2 = $("#tbrxordercondition-jor2_required").val();
            $.post(
                    "saverxorderitem",
                    {
                        id: id, gpu: gpu, narcotics: narcotics, ned: ned, due: due, due_id: due_id, drug2: drug2, ocpa: ocpa, cpr: cpr, jor2: jor2
                    },
                    function (data)
                    {
                        Getrxorder();
                        $('#btn-rxordersave').addClass("disabled", "disabled");
                        l.ladda('stop');
                        swal("Save Complete!", "", "success");
                    }
            );
        }
        /* Delete เอกสารการเบิกจ่าย */
        function DeleteRxorder() {
            var id = $("#order_condition_id").val();
            swal({
                title: "Are you sure?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'delete-rxorder',
                                    {
                                        id: id
                                    },
                                    function (data)
                                    {
                                        //location.reload();
                                        $('.cbx-icon').html('');
                                        $('input[data-toggle="checkbox-x"]').val('0');
                                        Getrxorder();
                                        Notify('Clear Complete!', 'top-right', '2000', 'danger', 'fa-trash', true);
                                    }
                            );
                        }
                    });
        }
        /* Edit ItemPack */
        function UpdateItempack(id) {
            LoadingClass();
            $.get(
                    "additem-pack",
                    {
                        id: id,
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $('.page-content').waitMe('hide');
                        $("#modaladditem").modal("show");
                    }
            );
        }
        /* Edit StkLevel */
        function UpdateStklevel(d) {
            var id = (d.getAttribute("data-id"));
            var stkid = (d.getAttribute("id"));
            var FSN_GPU = $("#tbitem-itemname").val();
            var e = document.getElementById("tbitem-itemdispunit");
            var DispUnit = e.options[e.selectedIndex].text;
            LoadingClass();
            $.get(
                    "addstklevel", {
                        id: id, stkid: stkid
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $('.page-content').waitMe('hide');
                        $("#modaladditem").modal("show");
                        $("#fsn_gpu").val(FSN_GPU);
                        $("#dispunit").val(DispUnit);
                    }
            );
        }
        /* Edit ItemPrice */
        function UpdateItemprice(d) {
            var id = (d.getAttribute("data-id"));
            var date = (d.getAttribute("id"));
            LoadingClass();
            $.get(
                    "additemprice",
                    {
                        id: id, date: date
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $('.page-content').waitMe('hide');
                        $("#modaladditem").modal("show");
                    }
            );
        }
        /* Edit Credititem*/
        function UpdateCredititem(d) {
            var id = (d.getAttribute("data-id"));
            var maininscl_id = (d.getAttribute("id"));
            $.get(
                    "addcredititem",
                    {
                        id: id, maininscl_id: maininscl_id
                    },
                    function (data)
                    {
                        $("#modaladditem").find(".modal-body").html(data);
                        $("#from_additem").html(data);
                        $(".modal-title").html("แก้ไขข้อมูล");
                        $("#modaladditem").modal("show");
                    }
            );
        }
        /* DeleteItempack */
        function DeleteItempack(id) {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'delete-itempack',
                                    {
                                        id: id
                                    },
                                    function (data)
                                    {
                                        $.ajax({
                                            url: "gettableitempack",
                                            type: "post",
                                            data: {itemid: itemid, edit: edit},
                                            dataType: "JSON",
                                            success: function (result) {
                                                $("#query_itempack").html(result.table);
                                                $('#table_tb_itempack').DataTable({
                                                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                                    /* "paging": false, */
                                                    "bFilter": false,
                                                    "pageLength": 5,
                                                    "language": {
                                                        "lengthMenu": "_MENU_",
                                                        "infoEmpty": "No records available",
                                                        "search": "_INPUT_ ",
                                                        "sSearchPlaceholder": "ค้นหาข้อมูล",
                                                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                                    },
                                                    "aLengthMenu": [
                                                        [5, 15, 20, 100, -1],
                                                        [5, 15, 20, 100, "All"]],
                                                });
                                            }
                                        });
                                    }
                            );
                        }
                    });
        }
        /* Delete Stklevel */
        function DeleteStklevel(d) {
            var id = (d.getAttribute("data-id"));
            var stk = (d.getAttribute("id"));
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'delete-stklevel',
                                    {
                                        id: id, stk: stk
                                    },
                                    function (data)
                                    {
                                        $.ajax({
                                            url: "gettablestklevel",
                                            type: "post",
                                            data: {itemid: itemid, edit: edit},
                                            dataType: "JSON",
                                            success: function (result) {
                                                $("#query_stklevel").html(result.table);
                                                $('#table_tb_stk_levelinfo').DataTable({
                                                    "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                                                    /* "paging": false, */
                                                    "bFilter": false,
                                                    "pageLength": 5,
                                                    "language": {
                                                        "lengthMenu": "_MENU_",
                                                        "infoEmpty": "No records available",
                                                        "search": "_INPUT_ ",
                                                        "sSearchPlaceholder": "ค้นหาข้อมูล",
                                                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                                    },
                                                    "aLengthMenu": [
                                                        [5, 15, 20, 100, -1],
                                                        [5, 15, 20, 100, "All"]],
                                                });
                                            }
                                        });
                                    }
                            );
                        }
                    });
        }
        /* Delete itemprice */
        function Deleteitemprice(d) {
            var id = (d.getAttribute("data-id"));
            var date = (d.getAttribute("id"));
            var edit = 'true';
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'delete-itemprice',
                                    {
                                        id: id, date: date
                                    },
                                    function (data)
                                    {
                                        Gettableitemprice();
                                    }
                            );
                        }
                    });
        }
        /* Delete Credititem */
        function DeleteCredititem(d) {
            var id = (d.getAttribute("data-id"));
            var maininscl_id = (d.getAttribute("id"));
            var edit = 'true';
            swal({
                title: "ยืนยันการลบ?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: true,
                closeOnCancel: true,
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.post(
                                    'delete-credititem',
                                    {
                                        id: id, maininscl_id: maininscl_id
                                    },
                                    function (data)
                                    {
                                        Gettablecredititem();
                                    }
                            );
                        }
                    });
        }
        /*   Query Table itemprice     */
        function Gettableitemprice() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            $.ajax({
                url: "getitemprice",
                type: "post",
                data: {itemid: itemid, edit: edit}, dataType: "JSON",
                success: function (result) {
                    $("#query_itemprice").html(result.table);
                    $('#table_tb_itemid_price').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        /* "paging": false, */
                        "bFilter": false,
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                        "aLengthMenu": [
                            [5, 15, 20, 100, -1],
                            [5, 15, 20, 100, "All"]
                        ],
                    });
                }
            });
        }
        /*   Query Table credititem     */
        function Gettablecredititem() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'true';
            $.ajax({
                url: "getcredititem",
                type: "post", data: {itemid: itemid, edit: edit},
                dataType: "JSON",
                success: function (result) {
                    $("#query_credititem").html(result.table);
                    $('#table_tb_credititem').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        /* "paging": false, */
                        "bFilter": false,
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                        "aLengthMenu": [
                            [5, 15, 20, 100, -1],
                            [5, 15, 20, 100, "All"]
                        ],
                    });
                }
            });
        }
    </script>
<?php } ?>
<?php if ($true == 'view') { ?>
    <?php
    $script = <<< JS
/*  เปลี่ยนหน่วย ตาม ID  */
$(document).ready(function () {
    var CoutUnit = $("#itemContUnit").val();
    var DispUnit = $("#itemDispUnit").val();
    $("#tbitem-itemcontunit").val(CoutUnit).trigger("change");
    $("#tbitem-itemdispunit").val(DispUnit).trigger("change");
    $('#btn-rxordersave').addClass("disabled", "disabled");
    $('#btn-clearrxordersave').addClass("disabled", "disabled");
    GettableItempack();
    GettableStklevel();
    Gettableitemprice();
    Gettablecredititem();
    Getdruglabel();
});

function Getdruglabel() {
        var itemid = $("#tbitem-itemid").val();
        run_waitMelabel();
        $.ajax({
            url: "getdruglabeltpu",
            type: "post",
            data: {itemid: itemid},
            dataType: "JSON",
            success: function (result) {
                $('#druglabel').html(result.label);
                $('#drugadminlabel').html(result.drugadmin);
                $('#druglabel1').html(result.druglabel1);
                $('#druglabel2').html(result.druglabel2);
                $('.panel-body').waitMe('hide');
            }
        });
    }
            
function run_waitMelabel(effect) {
        $('.panel-body').waitMe({
            effect: 'ios',
            text: 'Loading...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            onClose: function () {
            }
        });
    }
    
/*   Query Table ItemPAck     */
function GettableItempack() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'false';
    $.ajax({
        url: "gettableitempack",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_itempack").html(result.table);
            $('#table_tb_itempack').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
}
/*   Query Table stklevel     */
    function GettableStklevel() {
    var itemid = $("#tbitem-itemid").val();
    var edit = 'false';
    $.ajax({
        url: "gettablestklevel",
        type: "post",
        data: {itemid: itemid, edit: edit},
        dataType: "JSON",
        success: function (result) {
            $("#query_stklevel").html(result.table);
            $('#table_tb_stk_levelinfo').DataTable({
                "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                /* "paging": false, */
                "bFilter": false,
                "pageLength": 5,
                "language": {
                    "lengthMenu": "_MENU_",
                    "infoEmpty": "No records available",
                    "search": "_INPUT_ ",
                    "sSearchPlaceholder": "ค้นหาข้อมูล",
                    "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                },
                "aLengthMenu": [
                    [5, 15, 20, 100, -1],
                    [5, 15, 20, 100, "All"]
                ],
            });
        }
    });
} 
/*   Query Table itemprice     */
        function Gettableitemprice() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'false';
            $.ajax({
                url: "getitemprice",
                type: "post",
                data: {itemid: itemid, edit: edit}, dataType: "JSON",
                success: function (result) {
                    $("#query_itemprice").html(result.table);
                    $('#table_tb_itemid_price').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        /* "paging": false, */
                        "bFilter": false,
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                        "aLengthMenu": [
                            [5, 15, 20, 100, -1],
                            [5, 15, 20, 100, "All"]
                        ],
                    });
                }
            });
        }
     
        /*   Query Table credititem     */
        function Gettablecredititem() {
            var itemid = $("#tbitem-itemid").val();
            var edit = 'false';
            $.ajax({
                url: "getcredititem",
                type: "post", data: {itemid: itemid, edit: edit},
                dataType: "JSON",
                success: function (result) {
                    $("#query_credititem").html(result.table);
                    $('#table_tb_credititem').DataTable({
                        "dom": '<"pull-left"f><"pull-right"l>t<"pull-left"i>p',
                        /* "paging": false, */
                        "bFilter": false,
                        "pageLength": 5,
                        "language": {
                            "lengthMenu": "_MENU_",
                            "infoEmpty": "No records available",
                            "search": "_INPUT_ ",
                            "sSearchPlaceholder": "ค้นหาข้อมูล",
                            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        },
                        "aLengthMenu": [
                            [5, 15, 20, 100, -1],
                            [5, 15, 20, 100, "All"]
                        ],
                    });
                }
            });
        }
JS;
    $this->registerJs($script, \yii\web\View::POS_END, 'additem');
    ?>
<?php } ?>
<script>
    function showwebcam(type) {
        if (type == '1') {
            var id = "#webcam1";
            $('#btntakesnapimg1').removeClass('hidden');
            $('#btnshowcamera1').addClass('hidden');

        } else if (type == '2') {
            var id = "#webcam2";
            $('#btntakesnapimg2').removeClass('hidden');
            $('#btnshowcamera2').addClass('hidden');
        } else if (type == '3') {
            var id = "#webcam3";
            $('#btntakesnapimg3').removeClass('hidden');
            $('#btnshowcamera3').addClass('hidden');
        } else if (type == '4') {
            var id = "#webcam4";
            $('#btntakesnapimg4').removeClass('hidden');
            $('#btnshowcamera4').addClass('hidden');
        }
        $(id).scriptcam({
            showMicrophoneErrors: false,
            onError: onError,
            cornerRadius: 20,
            cornerColor: 'e3e5e2',
            onWebcamReady: onWebcamReady,
            // uploadImage: 'upload.gif',
            onPictureAsBase64: base64_tofield_and_image
        });


    }
    function base64_tofield() {
        $('#formfield').val($.scriptcam.getFrameAsBase64());
    }
    ;
    function base64_toimage(type) {
        var ima = "data:image/png;base64," + $.scriptcam.getFrameAsBase64();
        var ItemID = $('#tbitem-itemid').val();
        if (type == '1') {
            $.ajax({
                url: "saveimage",
                type: "post",
                data: {im: ima,ItemID:ItemID,Type:type},
                success: function (result) {
                    $('#image1').attr("src", '/km4/' + result);
                    $("#webcam1").replaceWith("<div id='webcam1'></div>");
                    $('#btntakesnapimg1').addClass('hidden');
                    $('#tbitem-itempic1').val(result);
                    $('#btnshowcamera1').removeClass('hidden');
                }
            });
        } else if (type == '2') {
            $.ajax({
                url: "saveimage",
                type: "post",
                data: {im: ima,ItemID:ItemID,Type:type},
                success: function (result) {
                    $('#image2').attr("src", '/km4/' + result);
                    $("#webcam2").replaceWith("<div id='webcam2'></div>");
                    $('#btntakesnapimg2').addClass('hidden');
                    $('#tbitem-itempic2').val(result);
                    $('#btnshowcamera2').removeClass('hidden');
                }
            });
        } else if (type == '3') {
            $.ajax({
                url: "saveimage",
                type: "post",
                data: {im: ima,ItemID:ItemID,Type:type},
                success: function (result) {
                    $('#image3').attr("src", '/km4/' + result);
                    $("#webcam3").replaceWith("<div id='webcam3'></div>");
                    $('#btntakesnapimg3').addClass('hidden');
                    $('#tbitem-itempic3').val(result);
                    $('#btnshowcamera3').removeClass('hidden');
                }
            });
        } else if (type == '4') {
            $.ajax({
                url: "saveimage",
                type: "post",
                data: {im: ima,ItemID:ItemID,Type:type},
                success: function (result) {
                    $('#image4').attr("src", '/km4/' + result);
                    $("#webcam4").replaceWith("<div id='webcam4'></div>");
                    $('#btntakesnapimg4').addClass('hidden');
                    $('#tbitem-itempic4').val(result);
                    $('#btnshowcamera4').removeClass('hidden');
                }
            });
        }
    }
    ;
    function base64_tofield_and_image(b64) {
        $('#formfield').val(b64);
        $('#image').attr("src", "data:image/png;base64," + b64);
    }
    ;
    function changeCamera() {
        $.scriptcam.changeCamera($('#cameraNames').val());
    }
    function onError(errorId, errorMsg) {
        $("#btn1").attr("disabled", true);
        $("#btn2").attr("disabled", true);
        alert(errorMsg);
    }
    function onWebcamReady(cameraNames, camera, microphoneNames, microphone, volume) {
        $.each(cameraNames, function (index, text) {
            $('#cameraNames').append($('<option></option>').val(index).html(text))
        });
        $('#cameraNames').val(camera);
    }
    function btndeleteimg(type) {
        var ItemID = $('#tbitem-itemid').val();
        if (type == '1') {
            var imgsrc = $("#image1").attr('src');
            swal({
                title: "Are you sure?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc,ItemID:ItemID,Type:type},
                                success: function (result) {
                                    $('#image1').attr("src", '');
                                    $('#tbitem-itempic1').val(null);
                                }
                            });
                        } else {

                        }
                    });

        } else if (type == '2') {
            var imgsrc = $("#image2").attr('src');
            swal({
                title: "Are you sure?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc,ItemID:ItemID,Type:type},
                                success: function (result) {
                                    $('#image2').attr("src", '');
                                    $('#tbitem-itempic2').val(null);
                                }
                            });
                        } else {

                        }
                    });
        } else if (type == '3') {
            var imgsrc = $("#image3").attr('src');
            swal({
                title: "Are you sure?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc,ItemID:ItemID,Type:type},
                                success: function (result) {
                                    $('#image3').attr("src", '');
                                    $('#tbitem-itempic3').val(null);
                                }
                            });
                        } else {

                        }
                    });
        } else if (type == '4') {
            var imgsrc = $("#image4").attr('src');
            swal({
                title: "Are you sure?",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: "deleteimage",
                                type: "post",
                                data: {imgsrc: imgsrc,ItemID:ItemID,Type:type},
                                success: function (result) {
                                    $('#image4').attr("src", '');
                                    $('#tbitem-itempic4').val(null);
                                }
                            });
                        } else {

                        }
                    });
        }
    }

</script>
