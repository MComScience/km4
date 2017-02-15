<?php

use yii\bootstrap\Modal;
use yii\helpers\Html;
use frontend\assets\ModalFullScreenAsset;

ModalFullScreenAsset::register($this);
?>
<?php if (Yii::$app->controller->action->id == 'update' || Yii::$app->controller->action->id == 'update-reject-verify') : ?>
    <?php
    Modal::begin([
        'id' => 'modal-table-nd',
        'header' => '<h4 class="modal-title">' . Html::encode('') . '</h4>',
        'footer' => Html::button('Close', ['class' => 'btn btn-default', 'type' => 'button', 'data-dismiss' => 'modal']),
        'size' => 'modal-lg',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
    ]);
    ?>
    <?php echo '<div id="datand"></div>'; ?>
    <?php Modal::end(); ?>
<?php endif; ?>

<?php
Modal::begin([
    'id' => 'nd-modal',
    'header' => '<h4 class="modal-title"></h4>',
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
    'options' => ['tabindex' => false, 'class' => 'modal-fullscreen'],
        //'closeButton' => false,
]);
?>
<?php echo '<div id="data"></div>'; ?>
<?php Modal::end(); ?>

<?php if (Yii::$app->controller->action->id == 'verify-pr') : ?>
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

<?php if (Yii::$app->controller->action->id == 'approve-pr') : ?>
    <?php
    Modal::begin([
        'id' => 'modal_reject',
        'size' => 'modal-dialog',
        'header' => ' <font color="#"><h4 class="modal-title">เหตุผลการ Reject Approve</h4></font>',
        'clientOptions' => ['backdrop' => 'static', 'keyboard' => false],
        'options' => ['tabindex' => false, 'class' => 'modal-reject'],
        'footer' => '<div class="col-xs-9 col-xs-offset-3">'
        . Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . ' '
        . Html::button('Rejected Approve', ['class' => 'btn btn-warning ladda-button btn-reject', 'data-style' => 'slide-down', 'id' => 'SaveRejectVerify'])
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
<?php if (Yii::$app->controller->action->id == 'approve') : ?>
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
<?php endif; ?>