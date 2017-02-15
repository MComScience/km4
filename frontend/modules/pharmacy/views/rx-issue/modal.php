<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use frontend\assets\ModalFullScreenAsset;

CrudAsset::register($this);
ModalFullScreenAsset::register($this);
?>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    "footer" => "", // always need it for jquery plugin
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
])
?>
<?php Modal::end(); ?>

<?php
Modal::begin([
    'id' => 'modal_request',
    'size' => 'modal-dialog',
    'header' => ' <font color="#"><h4 class="modal-title">Order Adjust Request</h4></font>',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-reject'],
    'footer' => '<div class="col-xs-9 col-xs-offset-3">'
    . Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
    . Html::button('Save', ['class' => 'btn btn-warning ladda-button', 'data-style' => 'expand-left', 'id' => 'btn-save-reques'])
    . '</div>',
]);
?>
<form id="form-adjrequest"> 
    <?= Html::input('text', 'ids', 'ids', ['type' => 'hidden', 'id' => 'ids_request', 'value' => '', 'class' => 'form-control']) ?>
    <div class="row">
        <div class="col-xs-12">
            <textarea type="text" class="form-control" id="RequestNote" name="RequestNote" cols="100" rows="5" cols="10" style="background-color: #ffff99;"></textarea>
        </div>
    </div>
</form>
<?php
Modal::end();
?>
