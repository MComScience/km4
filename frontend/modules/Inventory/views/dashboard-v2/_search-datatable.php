<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>

<div class="row">
    <div class="col-sm-12">
        <div class="tb-pr-search">
            <?php
            $form = ActiveForm::begin([
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'action' => ['cmd-listdrugnew'],
                        'method' => 'POST',
                        'options' => ['data-pjax' => true],
                        'id' => 'wait',
            ]);
            ?>
            <div class="form-group">
                <div class="col-sm-3" style="margin-left: 6px;">
                    <?=
                    $form->field($model,'StkID', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\Tbstk::find()->all(), 'StkID', 'StkName'),
                        'pluginOptions' => [
                            'placeholder' => 'กรุณาเลือกคลัง แล้วกดปุ่มค้นหา...',
                            'allowClear' => true,
                        ],
                    ])
                    ?>
                </div>
                <div class="input-group">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                    </span>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div> 
</div>

<script>
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
</script>
<?php
            $script = <<< JS

$('#wait').on('beforeSubmit', function(e){
     LoadingClass();
});

$('#w0').on('pjax:success', function () {
    $('.page-content').waitMe('hide');
    // var table = $('#datatables_w1').DataTable();
    // $("input[id=Chk1]").click(function () {
    //     if ($(this).is(':checked')) { 
    //         $.fn.dataTable.ext.search.push(
    //             function (settings, data, dataIndex) {
    //                 var age = data[2] || 0;
    //                 if (age.match(/^1.*$/))
    //                 {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //             );
    //             table.draw();
    //     }else{
    //         $.fn.dataTable.ext.search.pop();
    //         //table.destroy();
    //         var newTable = $('#datatables_w1').DataTable();
    //         newTable.draw();
    //     }
    // });
    // $("input[id=Chk2]").click(function () {
    //     if ($(this).is(':checked')) {
    //         $.fn.dataTable.ext.search.push(
    //             function (settings, data, dataIndex) {
    //                 var age = data[2] || 0;
    //                 if (age.match(/^2.*$/))
    //                 {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //             );
    //             table.draw();
    //     } else {
    //         $.fn.dataTable.ext.search.pop();
    //         //table.destroy();
    //         var newTable = $('#datatables_w1').DataTable();
    //         newTable.draw();
    //     }
    // });
    // $("input[id=Chk3]").click(function () {
    //     if ($(this).is(':checked')) {
    //         $.fn.dataTable.ext.search.push(
    //             function (settings, data, dataIndex) {
    //                 var age = data[2] || 0;
    //                 if (age.match(/^3.*$/))
    //                 {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //             );
    //             table.draw();
    //     } else {
    //         $.fn.dataTable.ext.search.pop();
    //         //table.destroy();
    //         var newTable = $('#datatables_w1').DataTable();
    //         newTable.draw();
    //     }
    // });
    // $("input[id=Chk4]").click(function () {
    //     if ($(this).is(':checked')) {
    //         $.fn.dataTable.ext.search.push(
    //             function (settings, data, dataIndex) {
    //                 var age = data[2] || 0;
    //                 if (age.match(/^4.*$/))
    //                 {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //             );
    //             table.draw();
    //     } else {
    //         $.fn.dataTable.ext.search.pop();
    //         //table.destroy();
    //         var newTable = $('#datatables_w1').DataTable();
    //         newTable.draw();
    //     }
    // });
    // $("input[id=Chk5]").click(function () {
    //     if ($(this).is(':checked')) {
    //         $.fn.dataTable.ext.search.push(
    //             function (settings, data, dataIndex) {
    //                 var age = data[2] || 0;
    //                 if (age.match(/^5.*$/))
    //                 {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //             );
    //             table.draw();
    //     } else {
    //         $.fn.dataTable.ext.search.pop();
    //         //table.destroy();
    //         var newTable = $('#datatables_w1').DataTable();
    //         newTable.draw();
    //     }
    // });
    // $("input[id=Chk6]").click(function () {
    //     if ($(this).is(':checked')) {
    //         $.fn.dataTable.ext.search.push(
    //             function (settings, data, dataIndex) {
    //                 var age = data[2] || 0;
    //                 if (age.match(/^6.*$/))
    //                 {
    //                     return true;
    //                 }
    //                 return false;
    //             }
    //             );
    //             table.draw();
    //     } else {
    //         $.fn.dataTable.ext.search.pop();
    //         //table.destroy();
    //         var newTable = $('#datatables_w1').DataTable();
    //         newTable.draw();
    //     }
    // });

});
JS;
$this->registerJs($script);
?>

