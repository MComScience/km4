<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="user-search">
    <div class="row">
        <?php if ($action == 'index') { ?>
            <div class="col-md-5">
            <?php } else { ?>
                <div class="col-md-4">
                <?php } ?>   
                <div class="user-search">
                    <?php
                    $form = ActiveForm::begin([
                                'action' => [$action],
                                'method' => 'get',
                                'options' => ['data-pjax' => true]
                    ]);
                    ?>
                    <div class="input-group">
                        <?= Html::activeTextInput($model, 'q', ['class' => 'form-control', 'placeholder' => 'ค้นหาข้อมูล...']) ?>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
                            <?php if ($action == 'index') { ?>
                                <?= Html::a('<i class="glyphicon glyphicon-plus"></i> ปรับปรุงยอดสินค้าคงคลัง', ['create-temp'], ['class' => 'btn btn-success']) ?>
                            <?php } ?>
                        </span>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div> 
</div> 
