<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
$script = <<< JS
function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'ios',//roundBounce,progressBar
        text: 'กำลังโหลดข้อมูล...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#53a93f',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}
$(document).ready(function () {
        $("input[id=vwpurchasingplanstatussearch-plan_qty]").click(function (e) {
            LoadingClass();
            document.getElementById('formsearch').submit();
        });
        $("input[id=vwpurchasingplanstatussearch-stk_main_rop]").click(function (e) {
            document.getElementById('formsearch').submit();
            LoadingClass();
        });
    });
JS;
$this->registerJs($script);
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="tb-pr-search">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'post',
                        'options' => ['data-pjax' => true],
                        'id' => 'formsearch'
            ]);
            ?>
            <div class="col-sm-4">
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>
                    <span class="input-group-btn">
                        <button class="btn btn-default" id="you_button_id" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    </span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <?= $form->field($model, 'plan_qty', ['showLabels' => false])->checkbox(['type' => 'checkbox', 'label' => '<span class="text">แสดงรายการตามแผน</span>']); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2">
                    <?= $form->field($model, 'stk_main_rop', ['showLabels' => false])->checkbox(['type' => 'checkbox', 'label' => '<span class="text">ต่ำกว่าจุดสั่งซื้อ</span>']); ?>
                </div>
            </div>
            <?php /*
              <div class="input-group">
              <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...', 'style' => 'background-color: white']) ?>
              <span class="input-group-btn">
              <button class="btn btn-default" id="you_button_id" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
              </span>
              </div> */ ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div> 
</div>

