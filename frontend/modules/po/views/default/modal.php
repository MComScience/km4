<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use johnitvn\ajaxcrud\CrudAsset;
use frontend\assets\ModalFullScreenAsset;

ModalFullScreenAsset::register($this);
CrudAsset::register($this);
$action = Yii::$app->controller->action->id;
?>
<?php
if (($action == 'update') || ($action == 'verify') || ($action == 'reject') || ($action == 'update-approve')) :
    #Modal เลือกยาการค้า type1
    Modal::begin([
        'id' => 'modal-table-tpu',
        'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
        'footer' => Html::button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal']),
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    echo '<div id="tabletpu"></div>';
    Modal::end();
    #Modal Table TPU Type2 ยาแถม
    Modal::begin([
        'id' => 'modal-table-tpu2',
        'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
        'footer' => Html::button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal']),
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    echo '<div id="content-table-tpu2"></div>';
    Modal::end();
    #Modal Table ND Type2 ยาแถม
    Modal::begin([
        'id' => 'modal-table-nd2',
        'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
        'footer' => Html::button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal']),
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    echo '<div id="content-table-nd2"></div>';
    Modal::end();
    #Modal ฟอร์มบันทึก type1
    Modal::begin([
        'id' => 'modal-from',
        'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    echo '<div id="modalcontent"></div>';
    Modal::end();
    #modal vendor
    Modal::begin([
        "id" => "ajaxCrudModal",
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        "footer" => "", // always need it for jquery plugin
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    Modal::end();
endif;
?>
<?php if (($action == 'verify')) : ?>
    <?php
    Modal::begin([
        'id' => 'modal_reject',
        'size' => 'modal-dialog',
        'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Verify</h4></font>',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-reject'],
        'footer' => '<div class="col-xs-9 col-xs-offset-3">'
        . Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
        . Html::button('Rejected Verify', ['class' => 'btn btn-warning ladda-button btn-reject', 'data-style' => 'slide-down', 'id' => 'SaveRejectVerify'])
        . '</div>',
    ]);
    ?>
    <div class="row">
        <div class="col-xs-12">
            <textarea type="text" class="form-control" id="PRRejectReason" name="PRRejectReason" cols="100" rows="5" cols="10" style="background-color: #ffff99;"></textarea>
        </div>
    </div>
    <?php
    Modal::end();
    ?>
<?php endif; ?>

<?php if ($action == 'approve-po') : ?>
    <?php
    Modal::begin([
        'id' => 'modal_reject',
        'size' => 'modal-dialog',
        'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Verify</h4></font>',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-reject'],
        'footer' => '<div class="col-xs-9 col-xs-offset-3">'
        . Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
        . Html::button('Rejected Approve', ['class' => 'btn btn-warning ladda-button btn-reject', 'data-style' => 'slide-down', 'id' => 'SaveRejectApprove'])
        . '</div>',
    ]);
    ?>
    <div class="row">
        <div class="col-xs-12">
            <textarea type="text" class="form-control" id="PRRejectReason" name="PRRejectReason" cols="100" rows="5" cols="10" style="background-color: #ffff99;"></textarea>
        </div>
    </div>
    <?php
    Modal::end();
    ?>
<?php endif; ?>
