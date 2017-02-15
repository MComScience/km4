<?php 
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <?php
        $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form_druginterac']);
        ?>
        <div class="well">
            <div class="form-group" >
                <div class="col-sm-3">
                    <?=
                    $form->field($modeldrug, 'DDI_id', ['showLabels' => false])->hiddenInput([
                        'maxlength' => true,
                        'readonly' => true,
                        'style' => 'background-color:white'
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeldrug, 'Drug1', ['label' => 'รหัสตัวยา VTM1', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeldrug, 'Drug1', ['showLabels' => false])->textInput([
                        'style' => 'background-color:white',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label no-padding-right">ชื่อตัวยา</label>
                <div class="col-sm-7">
                    <textarea class="form-control" style="background-color: white"  rows="3" readonly="" id="fsn_vtm1"><?php echo $detaildrug1; ?></textarea>
                </div>
            </div>

            <p></p>

            <div class="form-group" >
                <?= Html::activeLabel($modeldrug, 'Drug2', ['label' => 'รหัสตัวยา VTM2', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeldrug, 'Drug2', ['showLabels' => false])->textInput([
                        'style' => 'background-color:white',
                        'readonly' => true,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <label class="col-sm-3 control-label no-padding-right">ชื่อตัวยา</label>
                <div class="col-sm-7">
                    <textarea class="form-control" style="background-color: white" id="fsn_vtm2" rows="3" readonly=""><?php echo $detaildrug2; ?></textarea>
                </div>
            </div>
            <p></p>

            <div class="form-group">
                <?= Html::activeLabel($modeldruglevel, 'DDI_Serverity', ['label' => 'ระดับผลกระทบ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-4">
                    <?=
                    $form->field($modeldruglevel, 'DDI_Serverity', ['showLabels' => false])->widget(\kartik\widgets\Select2::classname(), [
                        'data' => yii\helpers\ArrayHelper::map(app\modules\Inventory\models\Tbddiserverity::find()->all(), 'ids', 'DDI_Serverity_decs'),
                        'pluginOptions' => [
                            'placeholder' => '--- Select Option ---',
                            'allowClear' => true,
                        ],
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group" >
                <?= Html::activeLabel($modeldruglevel, 'DDI_Effect_decs', ['label' => 'ผลกระทบ' . '<font color="red"> *</font>', 'class' => 'col-sm-3 control-label no-padding-right']) ?>
                <div class="col-sm-7">
                    <?=
                    $form->field($modeldruglevel, 'DDI_Effect_decs', ['showLabels' => false])->textarea([
                        'style' => 'background-color: #ffff99',
                        'rows' => 3,
                    ])
                    ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10" style="text-align: right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?= Html::resetButton('Clear', ['class' => 'btn btn-danger']) ?>
                    <?= Html::submitButton($modeldrug->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Save'), ['class' => $modeldrug->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
