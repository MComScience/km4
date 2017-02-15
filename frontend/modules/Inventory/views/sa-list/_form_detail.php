<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
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
<?php
$layout = <<< HTML
<div class="pull-right"></div>
<div class="clearfix"></div><p></p>
{items}
<div class="clearfix"></div>
<div class="pull-left">{summary}</div>
<div class="pull-right">{pager}</div>
<div class="clearfix"></div>
HTML;

$form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'formdetail']);
?>

<div class="well">

    <input id="sritempackid" type="hidden" value="<?php
    if (!empty($sritempackid)) {
        echo $sritempackid;
    }
    ?>" name="sritempackid"/>
           <?=
           $form->field($modeledit, 'ids', ['showLabels' => false])->hiddenInput([
               'maxlength' => true,
               'readonly' => true,
               'style' => 'background-color: white;text-align:right',
           ])
           ?>
    <div class="form-group">
        <?= Html::activeLabel($modeledit, 'ItemID', ['label' => 'รหัสสินค้า', 'class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-4">
            <?= $form->field($modeledit, 'ItemID', ['showLabels' => false])->textInput(['readonly' => true]); ?>
        </div>

        <label class="col-sm-2 control-label" for="tbsaitemdetail2temp-itemid">คลังสินค้า</label>
        <div class="col-sm-3">
            <div class="form-group field-tbsaitemdetail2temp-itemid">
                <input type="hidden" id="stkid" name="stkid" value="<?php echo!empty($stk->StkID) ? $stk->StkID : '' ?>"/>
                <div class="col-md-12"><input type="text"  class="form-control" readonly value="<?php echo!empty($stk->StkName) ? $stk->StkName : '' ?>" ></div>
                <div class="col-md-12"></div>
                <div class="col-md-12"><div class="help-block"></div></div>
            </div>       
        </div>
    </div>
    <?=
    $form->field($Item, 'ItemName')->textarea([
        'rows' => 3,
        'readonly' => true,
        'style' => 'background-color:white',
    ])->label('รายการสินค้า')
    ?>

    <?php
    // if($rs != null){
    $html = '<table border="1" class="table table-bordered"><tr><td>Internal</td><td>หมายเลขการผลิต</td><td>วันหมดอายุ</td><td>จำนวนแพค</td><td>ราคา/แพค</td><td>หน่วยแพค</td><td>จำนวน</td><td>หน่วย</td><td>ราคาต่อหน่วย</td><td>Actions</td></tr>';
    foreach ($rs as $value) {
        $html .= '<tr>';
        $html .= '<td>' . $value->ItemInternalLotNum . '</td>';
        $html .= '<td>' . $value->ItemExternalLotNum . '</td>';
        $html .= '<td>' . $value->ItemExpdate . '</td>';
        $html .= '<td>' . $value->PackQTY . '</td>';
        $html .= '<td>' . $value->PackItemUnitCost . '</td>';
        $html .= '<td>' . $value->PackUnit . '</td>';
        $html .= '<td>' . $value->ItemQty . '</td>';
        $html .= '<td>' . $value->DispUnit . '</td>';
        $html .= '<td>' . $value->ItemUnitCost . '</td>';
        $html .= '<td><a class="btn btn-success btn-xs" href="javascript:selectlot(' . $value->ItemInternalLotNum . ')">Select</a></td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
    echo $html;
//    } 
    ?>
        </div>

        <script>
            function selectlot(id) {
                var stkid = $('#stkid').val();
                var tbsa2said = $('#tbsa2-said').val();
                var itemid = $('#tbsaitemdetail2-itemid').val();

                $.ajax({
                    url: 'adjitem-select',
                    type: 'get',
                    data: {id: id, stkid: stkid, itemid: itemid, tbsa2said: tbsa2said},
                    success: function (data) {
                        $('#form_adjitem_detail').html(data);
                        $('#form_adjitem').modal('show');
                    }
                });

            }
        </script>
        

