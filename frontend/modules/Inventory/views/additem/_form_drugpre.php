<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\widgets\Select2;
?>
<div class="well">
    <div class="tb-drugin-form">
        <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_drugprecaution']); ?>
        <?=$form->errorSummary($model) ?>
        <div class="form-group">
            <?= Html::activeLabel($model, 'TMTID_GPU', ['label' => 'รหัสยาสามัญ', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'TMTID_GPU', ['showLabels' => false])->textInput([
                    'style' => 'background-color: white',
                    'readonly' => true,
                    'value' => $tmtid_gpu,
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">ชื่อยาสามัญ</label>
            <div class="col-sm-7">
                <textarea class="form-control" rows="3" readonly="" id="FSN_GPU" style="background-color: white"><?php echo $fsn_gpu ?></textarea>
            </div>
        </div>

        <br>

        <div class="form-group">
            <?= Html::activeLabel($model, 'DrugPrecaution_levelID', ['label' => 'ระดับการเตือน' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-4">
                <?=
                $form->field($model, 'DrugPrecaution_levelID', ['showLabels' => false])->widget(Select2::classname(), [
                    'data' => yii\helpers\ArrayHelper::map(\app\modules\Inventory\models\TbDrugprecautionLevel::find()->all(), 'DrugPrecaution_levelID', 'DrugPrecaution_levelDesc'),
                    'pluginOptions' => [
                        'placeholder' => 'Select Option',
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'DrugPrecautionNote', ['label' => 'หมายเหตุ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-7">
               <?=
                $form->field($model, 'DrugPrecautionNote', ['showLabels' => false])->textarea([
                    'style' => 'background-color: #ffff99',
                    'rows' => 3
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::activeLabel($model, 'DrugPrecaution_label', ['label' => 'ข้อความบนฉลากยา' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
            <div class="col-sm-7">
                <?= $form->field($model, 'DrugPrecaution_label', ['showLabels' => false])->textInput(['style' => 'background-color: #ffff99']); ?>
            </div>
        </div>

        <?= $form->field($model, 'ids', ['showLabels' => false])->hiddenInput(['style' => 'background-color: white',]); ?>

        <div class="form-group">
            <div class="col-sm-10" style="text-align: right">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $model->isNewRecord ? 'btn btn-success ladda-button' : 'btn btn-success ladda-button','data-style' => 'expand-left']) ?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


<?php
$script = <<< JS
$('#form_drugprecaution').on('beforeSubmit', function(e)
    {
    var l = $( '.ladda-button' ).ladda();
    l.ladda( 'start' );
    var \$form = $(this);
            $.post(
                    \$form.attr('action'), // serialize Yii2 form
                    \$form.serialize()
                    )
            .done(function(result) {
            if (result == 'success')
            {
                l.ladda( 'stop' );
                GettableDrugpre();
                //Notify('Save Successfully!', 'top-right', '2000', 'success', 'fa-check', true);
                //$.pjax.reload({container: '#tb_drugprecaution'});
                $('#form_drugprecaution').trigger('reset');
                $('#modaladd_drugin').modal('hide');
                Getdruglabel();/* เรียกใช้ function */
                swal("Save Complete!", "", "success");
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
/*   Query Table คำเตือนการใช้ยา     */
//    function GettableDrugpre() {
//        var gpu = $("#tbdrugprecaution-tmtid_gpu").val();
//        $.ajax({
//            url: "index.php?r=Inventory/additem/gettabledrugpre",
//            type: "post",
//            data: {gpu: gpu},
//            dataType: "JSON",
//            success: function (result) {
//                $("#query_drugprecaution").html(result.table);
//                $('#table_tb_drugprecaution').DataTable({
//                    "dom": '<"pull-left"f><"pull-right"l>tip',
//                    /* "paging": false, */
//                    "bFilter": false,
//                    "pageLength": 5,
//                    "aLengthMenu": [
//                        [5, 15, 20, 100, -1],
//                        [5, 15, 20, 100, "All"]
//                    ],
//                });
//            }
//        });
//    }
JS;
$this->registerJs($script);
?>